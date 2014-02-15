<div class="row">
<div class="span5 offset3 add-user-box">
<h3><?php echo __('Add New User'); ?></h3>
<?php echo $this->Form->create('User',array('class'=>'form-horizontal')); ?>
    <fieldset>
       
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('confirm',array('type'=>'password','required'=>'required'));
        echo $this->Form->input('group_id',array('options'=>$grouplist));
        echo $this->Form->input('first_name');
        echo $this->Form->input('last_name');
        echo $this->Form->input('email');
        echo $this->Form->input('active');
    ?>
    <div class="form-actions">
	<?php echo $this->Form->submit('<i class="icon-save"></i> '.__('Add'),array( 'div'=>false,'class'=>'btn btn-info')); ?>
	</div>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
</div>
<script>
$(document).ready(function(){
	$("#UserAddForm").validate({

		rules: {
			"data[User][password]":{
				required: true,
				minlength:5,

				},
			"data[User][confirm]":{
				required: true,
				minlength:5,
				equalTo: "#UserPassword"

				}
		},
		messages: {
			"data[User][password]":"<?php echo __('Please check this field'); ?>",
			"data[User][confirm]":{equalTo:"<?php echo __('make sure both match'); ?>"}
		},
		errorElement:"span"

		});
});
</script>