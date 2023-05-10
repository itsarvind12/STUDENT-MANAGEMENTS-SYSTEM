<?php 
require_once("./../../config.php");
$desks = $conn->query("SELECT * FROM `desk_list` where `status` = 1 and id NOT IN (SELECT desk_id FROM `assign_list` where `status` = 1 ".(isset($_GET['id']) && $_GET['id'] > 0 ? "and `id` != '{$_GET['id']}'" : "").") order by `code` asc");
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `assign_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        $data = $qry->fetch_assoc();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
    }
}
?>
<div class="container-fluid">
    <form action="" id="assign-form">
        <input type="hidden" name="id" value="<?= $data['id'] ?? "" ?>">
        <input type="hidden" name="student_id" value="<?= $_GET['sid'] ?? $data['student_id'] ?? "" ?>">
        <div class="form-group">
            <label for="desk_id" class="control-label">Desk Code</label>
            <select name="desk_id" class="custom-select rounded-0" id="desk_id" required="required">
                <?php foreach($desks->fetch_all(MYSQLI_ASSOC) as $row): ?>
                <option value="<?= $row['id'] ?>" <?= isset($data['desk_id']) && $data['desk_id'] == $row['id'] ? "selected" : "" ?>><?= $row['code'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="remarks" class="control-label">Remarks</label>
            <textarea class="form-control form-control-sm rounded-0" name="remarks" id="remarks" rows="3"><?= $data['remarks'] ?? "" ?></textarea>
        </div>
    </form>
</div>

<script>
    
    $(function(){
        $('#desk_id').select2({
            placeholder:"Please Select Desk Code",
            width:'relative',
            dropdownParent:$('#uni_modal')
        })
        $('#assign-form').submit(function(e){
            e.preventDefault()
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_assign",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload()
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").scrollTop(0);
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
        })
        
    })
</script>