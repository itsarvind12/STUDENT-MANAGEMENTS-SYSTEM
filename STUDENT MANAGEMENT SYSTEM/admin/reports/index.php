<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php 
$from = $_GET['date_from'] ?? date("Y-m-d", strtotime(date("Y-m-d")." -1 month"));
$to = $_GET['date_to'] ?? date("Y-m-d");
?>
<div class="card shadow mb-3">
    <div class="card-header">Filter Report</div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="" id="filter-report">
                <div class="row align-items-end">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label for="date_from">From</label>
                        <input type="date" class="form-control rounded-0" id="date_form" name="date_from" value="<?= $from ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label for="date_to">To</label>
                        <input type="date" class="form-control rounded-0" id="date_form" name="date_to" value="<?= $to ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <button class="btn btn-primary rounded-0"><i class="fa fa-filter"></i> Filter</button>
                        <button id="printReport" type="button" class="btn btn-default border rounded-0"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">Date-wise Reports</h3>
		<div class="card-tools">
			<!-- <a href="./?page=students/manage_student" id="create_new" class="btn btn-flat btn-primary bg-gradient-teal border-0"><span class="fas fa-plus"></span>  Create New</a> -->
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<div class="table-responsive">
				<table class="table table-sm table-hover table-striped table-bordered" id="report-tbl">
					<colgroup>
						<col width="10%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="30%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Date Created</th>
							<th>Student</th>
							<th>Desk Code</th>
							<th>Remarks</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 1;
						$qry = $conn->query("SELECT al.*, CONCAT(sl.regno, '-', sl.name) as student, dl.code from `assign_list` al inner join `student_list` sl on sl.id = al.student_id inner join `desk_list` dl on dl.id = al.desk_id where date_format(al.`created_at`, '%Y-%m-%d') BETWEEN '{$from}' and '{$to}'  order by abs(unix_timestamp(al.created_at)) asc ");
						while($row = $qry->fetch_assoc()):
						?>
							<tr>
								<td class="align-items-center text-center"><?php echo $i++; ?></td>
								<td class="align-items-center"><?php echo date("Y-m-d H:i",strtotime($row['created_at'])) ?></td>
								<td class="align-items-center"><?= $row['student'] ?></td>
								<td class="align-items-center"><?= $row['code'] ?></td>
								<td class="align-items-center"><?= $row['remarks'] ?></td>
							</tr>
						<?php endwhile; ?>
                        <?php if($qry->num_rows <= 0): ?>
                            <tr>
                                <td class="text-center" colspan="5">No records</td>
                            </tr>
                        <?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php 
$dateRange =  date("F d, Y", strtotime($from));
if(date("F-Y", strtotime($from)) == date("F-Y", strtotime($to)) && date("F-d-Y", strtotime($from)) != date("F-d-Y", strtotime($to)) ){
    $dateRange = (date("F ", strtotime($from))). date("d - ", strtotime($from)). date(" d", strtotime($to)) . (date(", Y ", strtotime($from)));
}elseif(date("F-d-Y", strtotime($from)) != date("F-d-Y", strtotime($to))){
    $dateRange =  date("F d, Y", strtotime($from)) . " - " . date("F d, Y", strtotime($to));
}
?>
<script>

    $(function(){
        $('#filter-report').submit(function(e){
            e.preventDefault()
            location.href = '<?= base_url ?>admin?page=reports&'+$(this).serialize()
        })
        $('#printReport').click(function(e){
            e.preventDefault()
            start_loader();
            var _headClone = $('head').clone()
            var _report = $('#report-tbl').clone()
            var _header = `
                <h1 class="text-center"><b><?= $_settings->info('name') ?></b></h1>
                <h2 class="text-center"><b>Date-wise Report for <?= $dateRange ?></b></h2>
                <h1 class="text-center"><b>Assigned Desk History</h1>
                <hr>
            `;
            var div = $('<div>')
            div[0].innerHTML = _header
            div[0].innerHTML += _report[0].outerHTML

            var nw = window.open("", "_blank","height="+($(window).width())+"px, width="+($(window).width())+"px")
            nw.document.querySelector('head').innerHTML = _headClone[0].innerHTML
            nw.document.body.innerHTML = div[0].innerHTML
            nw.document.close()
            setTimeout(() => {
                nw.print();
                setTimeout(() => {
                    nw.close();
                    end_loader();
                }, 500);
            }, 1500);
        })
    })

</script>