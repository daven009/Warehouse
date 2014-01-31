<div>
	<div><h3><?php echo __('Edit Title'); ?></h3></div>
	<?php echo $this->Form->create('Option',array('class'=>'form-horizontal','type'=>'file')); ?>
	<fieldset>
	<?php echo $this->Form->input('title',array('type'=>'text','label'=>__('Title'))); ?>
	<?php echo $this->Form->input('logo',array('type'=>'file','label'=>__('Logo'))); ?>
	<?php echo $this->Form->input('logo_dir',array('type'=>'hidden')); ?>
	<?php echo $this->Form->input('copyright',array('type'=>'text','label'=>__('Copyright Text'))); ?>
	<?php echo $this->Form->input('email',array('type'=>'text','label'=>__('E-mail address'))); ?>
	<?php echo $this->Form->input('email_title',array('type'=>'text','label'=>__('E-mail name'))); ?>
	<?php echo $this->Form->input('currency',array('type'=>'text','label'=>__('Currency'))); ?>
	<div class="form-actions">
	<?php echo $this->Form->submit(__('Save'),array('class'=>'btn btn-info','div'=>false,'icon'=>'save')); ?>
	</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>