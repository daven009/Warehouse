<div class="row-fluid">
<div class="span5 offset3 add-contact-box">
	<div><h3><?php echo __('Add New Contact'); ?></h3></div>
	<?php echo $this->Form->create('Contact',array('class'=>'form-horizontal','type'=>'file')); ?>
	<fieldset>
	<?php echo $this->Form->input('first_name',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('last_name',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php //echo $this->Form->input('photo_file',array('type'=>'file')); ?>
	<?php echo $this->Form->input('photo',array('type'=>'file')); ?>
	<?php echo $this->Form->input('photo_dir',array('type'=>'hidden')); ?>
	<?php echo $this->Form->input('company',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('city',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('phone',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('email',array('type'=>'text','class'=>'input-xlarge')); ?>
	<div class="control-group" >
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
	<?php echo $this->Form->input('contact_status_id',array('type'=>'hidden')); ?>
	<div class="form-actions">
	<?php echo $this->Form->submit('<i class="icon-save"></i>'.__(' Add'),array( 'div'=>false,'class'=>'btn btn-info')); ?>
	&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'contacts','action'=>'index')); ?>" class="btn btn-primary"><i class="icon-reply"></i>&nbsp;<?php echo __('Cancel');?></a>
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