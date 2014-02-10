<div class="row-fluid">
<div class="span5 offset3 add-contact-box">
	<div><h3><?php echo __('Stock'); ?></h3></div>
	<?php echo $this->Form->create('Stock',array('class'=>'form-horizontal','type'=>'file')); ?>
	<fieldset>
	<?php echo $this->Form->input('good_id',array('options'=>$goods,'label'=>'Item Name')); ?>
	<?php echo $this->Form->input('quantity',array('type'=>'text')); ?>
	<?php echo $this->Form->input('remark',array('type'=>'textarea')); ?>
	<div class="form-actions">
	<?php echo $this->Form->submit('<i class="icon-save"></i>'.__(' Add'),array( 'div'=>false,'class'=>'btn btn-info')); ?>
	&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'stock','action'=>'index')); ?>" class="btn btn-primary"><i class="icon-reply"></i>&nbsp;<?php echo __('Cancel');?></a>
	</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
</div>
<script>

</script>