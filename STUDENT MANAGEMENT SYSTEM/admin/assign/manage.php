<?php
if(isset($_GET['sid']) && $_GET['sid'] > 0){
    $qry = $conn->query("SELECT *, COALESCE((SELECT count(id) FROM `assign_list` where `assign_list`.`student_id` = `student_list`.`id` and `status` = 1), 0) is_assigned from `student_list` where id = '{$_GET['sid']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
		echo '<script>alert("Student ID is not valid."); location.replace("./?page=students")</script>';
	}
}else{
	echo '<script>alert("Student ID is Required."); location.replace("./?page=students")</script>';
}
?>
<div class="content py-5 px-3 bg-gradient-teal">
	<h2><b><?= isset($id) ? "Update Student Details" : "New Student Entry" ?></b></h2>
</div>
<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
		<div class="card rounded-0">
			<div class="card-body">

				<div class="container-fluid">
					<div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <colgroup>
                                <col width="15%">
                                <col width="30%">
                                <col width="15%">
                                <col width="30%">
                            </colgroup>
                            <tr>
                                <th>Registration No.</th>
                                <td><?= $regno ?></td>
                                <th>Name</th>
                                <td><?= $name ?></td>
                            </tr>
                            <tr>
                                <th>Contact</th>
                                <td><?= $contact ?></td>
                                <th>Email</th>
                                <td><?= $email ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?= $address ?></td>
                                <th>Status</th>
                                <td>
                                    <?php if($status == 1): ?>
                                        <span class="badge badge-success px-3 rounded-pill">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                    <h2 class=""><b>Assigned Desk History</b></h2>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="history">
                            <colgroup>
                                <col width="%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="text-center">Created</th>
                                    <th class="text-center">Desk COde</th>
                                    <th class="text-center">Remarks</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $records = $conn->query("SELECT al.*, d.code as desk_code FROM `assign_list` al inner join `desk_list` d on d.id = al.desk_id where al.student_id = '{$id}' order by abs(unix_timestamp(al.`created_at`)) desc");
                                while($row = $records->fetch_assoc()):
                                ?>
                                <tr>
                                    <th><?= date("F d, Y", strtotime($row['created_at'])) ?></th>
                                    <td><?= $row['desk_code'] ?></td>
                                    <td><?= $row['remarks'] ?></td>
                                    <td class="text-center">
                                        <?php if($row['status'] == 1): ?>
                                            <span class="badge badge-success px-3 rounded-pill">Assigned</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger px-3 rounded-pill">Unassigned</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                Action
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <?php if($row['status'] == 1): ?>
                                            <a class="dropdown-item edit_assign" href="#" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item unassign_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-slash text-muted"></span> Unassign</a>
                                            <div class="dropdown-divider"></div>
                                            <?php endif; ?>
                                            <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button type="button" id="assign_student" class="btn btn-primary btn-sm bg-gradient-teal btn-flat border-0"><i class="fa fa-sitemap" <?= ($is_assigned == 1 ? "disabled" : "") ?>></i> Assign to Desk</button>
                <a class="btn btn-light btn-sm bg-gradient-light border btn-flat" href="./?page=assign"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
	</div>
</div>
<script>
    function delete_assign($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_assign",
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
    function unassign_data($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=save_assign",
			method:"POST",
			data:{id: $id, status: 0},
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
	$(document).ready(function(){
        $("#assign_student").click(function(){
            console.log('test')
            uni_modal("Assign Student", "<?= base_url ?>admin/assign/assign.php?sid=<?= $id ?>")
        })

        $('.edit_assign').click(function(e){
            e.preventDefault();
            var id = $(this).attr('data-id')
            uni_modal("Edit Assign Details", "<?= base_url ?>admin/assign/assign.php?id="+id)
        })
        $('.unassign_data').click(function(){
			_conf("Are you sure to unassign student from this desk?","unassign_data",[$(this).attr('data-id')])
		})
        $('.delete_data').click(function(){
			_conf("Are you sure to delete this assigned record permanently?","delete_assign",[$(this).attr('data-id')])
		})
        $('#history').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
	})
</script>