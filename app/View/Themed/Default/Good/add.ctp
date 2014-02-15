<div class="row-fluid">
<div class="span5 offset3 add-contact-box">
	<div><h3><?php echo __('Add New Product'); ?></h3></div>
	<?php echo $this->Form->create('Good',array('class'=>'form-horizontal','type'=>'file')); ?>
	<fieldset>
	<?php echo $this->Form->input('name',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('description',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('unit',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('sales_price',array('type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('remark',array('type'=>'textarea','class'=>'input-xlarge')); ?>
	<div class="form-actions">
	<?php echo $this->Form->submit('<i class="icon-save"></i>'.__(' Add'),array( 'div'=>false,'class'=>'btn btn-info')); ?>
	&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'good','action'=>'index')); ?>" class="btn btn-primary"><i class="icon-reply"></i>&nbsp;<?php echo __('Cancel');?></a>
	</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
</div>