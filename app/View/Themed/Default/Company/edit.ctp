<div class="edit-contact-container">
	<div><h3><?php echo __('Edit Company'); ?></h3></div>
	<div class="edit-contact-box">
	<?php echo $this->Form->create('Company',array('action'=>'edit', 'class'=>'form-horizontal')); ?>
	<fieldset>
	<div class="control-group head-group" >
		<label class="control-label"><?php echo __('Company Group'); ?></label>
		<div class="controls">
			<div class="btn-group" data-toggle="buttons-radio" data-toggle-name="company_group_id">
			<?php foreach ($companygroups as $key=>$value):?>
				<?php if ($value=='Dealer') $color_class='btn-danger';
				else if($value=='Distributor') $color_class='btn-warning';
				else if($value=='Supplier') $color_class='btn-success';
				else $color_class='btn-info';?>
			  <button type="button" class="btn <?php echo $color_class; ?>" value="<?php echo $key; ?>">
			  <?php echo $value; ?>
			  </button>
			  <?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php echo $this->Form->input('name',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('address',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('postal_code',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('company_group_id',array('type'=>'hidden')); ?>
	<div class="form-actions">
	<?php echo $this->Form->submit('<i class="icon-save"></i>'.__(' Save'),array( 'div'=>false,'class'=>'btn btn-info')); ?>
	&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'company','action'=>'index')); ?>" class="btn btn-primary"><i class="icon-reply"></i>&nbsp;<?php echo __('Cancel'); ?></a>
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
	    var name    = "data[Company][company_group_id]";
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
<form name="del" id="del" action="<?php echo $this->Html->url(array('controller'=>'company','action'=>'delete'));?>" method="post">
<input type="hidden" name="id" id="delid" value="<?php echo $this->request->data['Company']['id']; ?>">
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
    var question = '<?php echo __('Are you sure, you want to delete this company!')?>';
    var cancelButtonTxt = '<?php echo __('Cancel') ?>';
    var okButtonTxt = '<?php echo __('Delete'); ?>';

    var callback = function() {
  
	  $('#del').submit();
    };

    confirm(heading, question, cancelButtonTxt, okButtonTxt, callback);

  });
</script>