<div class="row">
<div class="span5 offset3 edit-user-box">
	<h3><?php echo __('Edit Product'); ?>
	<?php if (AuthComponent::user('group_id')==ADMINISTRATOR || AuthComponent::user('group_id')==SUPERADMIN):?>
	<a href="<?php echo $this->Html->url(array('controller'=>'good','action'=>'add')); ?>" class="btn btn-success btn-mini"><i class="icon-plus"></i></a>
	<a href="<?php echo $this->Html->url(array('controller'=>'good','action'=>'index')); ?>" class="btn btn-info btn-mini"><i class="icon-user"></i>&nbsp;<?php echo __('Product List'); ?></a>
	<?php endif; ?>
	</h3>
<?php echo $this->Form->create('Good',array('url'=>array('controller'=>'good','action'=>'edit'), 'class'=>'form-horizontal')); ?>
    <fieldset>
        <?php 
        echo $this->Form->input('name',array('type'=>'text'));
        echo $this->Form->input('description',array('type'=>'text'));
        echo $this->Form->input('unit',array('type'=>'text'));
        echo $this->Form->input('sales_price',array('type'=>'text'));
        echo $this->Form->input('remark',array('type'=>'textarea'));
    ?>
    <div class="form-actions">
	<?php echo $this->Form->submit('<i class="icon-save"></i> '.__('Save'),array( 'div'=>false,'class'=>'btn btn-info')); ?>
	<?php if (AuthComponent::user('group_id')==ADMINISTRATOR||AuthComponent::user('group_id')==SUPERADMIN) :?>
	<a href="#" class="btn btn-danger cdelete" ><i class="icon-trash"></i>&nbsp;<?php echo __('Delete'); ?></a>
	<?php endif; ?>
	</div>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
</div>
<script>
$(document).ready(function(){
	$("#GoodEditForm").validate({

		rules: {
			"data[Good][new_password]":{
				//required: false,
				minlength:5,

				},
			"data[Good][confirm]":{
				//required: false,
				minlength:5,
				equalTo: "#GoodNewPassword"

				}
		},
		messages: {
			"data[Good][new_password]":"<?php echo __('Please check this field'); ?>",
			"data[Good][confirm]":{equalTo:"<?php echo __('make sure both match'); ?>"}
		},
		errorElement:"span"

		});
});
</script>
<?php if (($this->request->data['Good']['id'] != AuthComponent::user('id')) and (AuthComponent::user('group_id') == 1 )) :?>
<form name="del" id="del" action="<?php echo $this->Html->url(array('controller'=>'good','action'=>'delete',$this->request->data['Good']['id']));?>" method="post">
<input type="hidden" name="id" id="delid" value="<?php echo $this->request->data['Good']['id']; ?>">
</form>
<script>

//Confirm delete modal/dialog with Twitter bootstrap?
// ---------------------------------------------------------- Generic Confirm  

  function confirm(heading, question, cancelButtonTxt, okButtonTxt, callback) {

    var confirmModal = 
      $('<div class="modal hide fade">' +    
          '<div class="modal-header">' +
            '<a class="close" data-dismiss="modal" >&times;</a>' +
            '<h3>' + heading +'</h3>' +
          '</div>' +

          '<div class="modal-body">' +
            '<p>' + question + '</p>' +
          '</div>' +

          '<div class="modal-footer">' +
            '<a href="#" class="btn" data-dismiss="modal">' + 
              cancelButtonTxt + 
            '</a>' +
            '<a href="#" id="okButton" class="btn btn-danger">' + 
              okButtonTxt + 
            '</a>' +
          '</div>' +
        '</div>');

    confirmModal.find('#okButton').click(function(event) {
      callback();
      confirmModal.modal('hide');
    });

    confirmModal.modal('show');     
  };

  // ---------------------------------------------------------- Confirm Put To Use

  $(".cdelete").live("click", function(event) {


    var heading = '<?php echo __('Confirm Delete'); ?>';
    var question = '<?php echo __('Are you sure, you want to delete this Good!'); ?>';
    var cancelButtonTxt = '<?php echo __('Cancel'); ?>';
    var okButtonTxt = '<?php echo __('Delete'); ?>';

    var callback = function() {
  
	  $('#del').submit();
    };

    confirm(heading, question, cancelButtonTxt, okButtonTxt, callback);

  });
</script>
<?php endif; ?>