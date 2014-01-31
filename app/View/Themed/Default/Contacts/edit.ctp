<div class="edit-contact-container">
	<div><h3><?php echo __('Edit Contact'); ?></h3></div>
	<div class="edit-contact-box">
	<?php echo $this->Form->create('Contact',array('action'=>'edit', 'class'=>'form-horizontal')); ?>
	<fieldset>
	<div class="control-group head-group" >
		<label class="control-label"><?php echo __('Contact Status'); ?></label>
		<div class="controls">
			<div class="btn-group" data-toggle="buttons-radio" data-toggle-name="contact_status_id">
			<?php foreach ($contactstatuses as $key=>$value):?>
				<?php if ($value=='Lead') $color_class='btn-danger';
				else if($value=='Opportunity') $color_class='btn-warning';
				else if($value=='Account') $color_class='btn-success';
				else $color_class='btn-info';?>
			  <button type="button" class="btn <?php echo $color_class; ?>" value="<?php echo $key; ?>">
			  <?php echo $value; ?>
			  </button>
			  <?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php echo $this->Form->input('first_name',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('last_name',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('photo',array('type'=>'file')); ?>
	<?php echo $this->Form->input('photo_dir',array('type'=>'hidden')); ?>
	<?php echo $this->Form->input('company',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('city',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('phone',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('email',array('type'=>'text','class'=>'input-xlarge')); ?>
	
	<?php echo $this->Form->input('contact_status_id',array('type'=>'hidden')); ?>
	<div class="form-actions">
	<?php echo $this->Form->submit('<i class="icon-save"></i>'.__(' Save'),array( 'div'=>false,'class'=>'btn btn-info')); ?>
	&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'contacts','action'=>'index')); ?>" class="btn btn-primary"><i class="icon-reply"></i>&nbsp;<?php echo __('Cancel'); ?></a>
	<a href="#" class="btn btn-danger cdelete" ><i class="icon-trash"></i>&nbsp;<?php echo __('Delete'); ?></a>
	</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
	</div>
</div>
<script>
jQuery(function($) {
	  $('div.btn-group[data-toggle-name]').each(function(){
	    var group   = $(this);
	    var form    = group.parents('form').eq(0);
	    var name    = "data[Contact][contact_status_id]";
	    var hidden  = $('input[name="' + name + '"]', form);
	    $('button', group).each(function(){
	      var button = $(this);
	      button.live('click', function(){
	          hidden.val($(this).val());
	      });
	      if(button.val() == hidden.val()) {
	        button.addClass('active');
	      }
	    });
	  });
	});
</script>
<form name="del" id="del" action="<?php echo $this->Html->url(array('controller'=>'contacts','action'=>'delete'));?>" method="post">
<input type="hidden" name="id" id="delid" value="<?php echo $this->request->data['Contact']['id']; ?>">
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


    var heading = '<?php echo __('Confirm Delete')?>';
    var question = '<?php echo __('Are you sure, you want to delete this contact!')?>';
    var cancelButtonTxt = '<?php echo __('Cancel') ?>';
    var okButtonTxt = '<?php echo __('Delete'); ?>';

    var callback = function() {
  
	  $('#del').submit();
    };

    confirm(heading, question, cancelButtonTxt, okButtonTxt, callback);

  });
</script>