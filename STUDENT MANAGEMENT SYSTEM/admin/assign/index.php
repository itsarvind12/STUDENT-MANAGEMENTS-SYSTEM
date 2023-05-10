<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	.student-img{
		width:3em;
		height:3em;
		object-fit:cover;
		object-position:center center;
	}
</style>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">Assign or Unassign Students</h3>
		<div class="card-tools">
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<div class="table-responsive">
				<table class="table table-sm table-hover table-striped table-bordered" id="list">
					<colgroup>
						<col width="5%">
						<col width="15%">
						<col width="20%">
						<col width="30%">
						<col width="20%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Date Created</th>
							<th>Reg. No.</th>
							<th>Student</th>
							<th>Current Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 1;
						$qry = $conn->query("SELECT *, COALESCE((SELECT count(id) FROM `assign_list` where `assign_list`.`student_id` = `student_list`.`id` and `status` = 1), 0) is_assigned from `student_list` order by `name` asc ");
						while($row = $qry->fetch_assoc()):
						?>
							<tr>
								<td class="align-items-center text-center"><?php echo $i++; ?></td>
								<td class="align-items-center"><?php echo date("Y-m-d H:i",strtotime($row['created_at'])) ?></td>
								<td class="align-items-center"><?= $row['regno'] ?></td>
								<td class="align-items-center"><?= $row['name'] ?></td>
								<td class="align-items-center text-center">
									<?php if($row['is_assigned'] == 1): ?>
										<span class="badge badge-success px-3 rounded-pill">Assigned</span>
									<?php else: ?>
										<span class="badge badge-danger px-3 rounded-pill">Unassigned</span>
									<?php endif; ?>
								</td>
								<td class="align-items-center" align="center">
									<a href="./?page=assign/manage&sid=<?= $row['id'] ?>" class="btn btn-flat p-1 btn-default btn-sm "><i class="fa fa-pen-square"></i> Manage</a>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this student permanently?","delete_student",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [2,5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_student($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_student",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>