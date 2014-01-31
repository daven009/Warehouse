<div class="row-fluid">
<div class="span5 offset3 add-contact-box">
	<div><h3><?php echo __('Import Contacts'); ?></h3></div>
	<?php echo $this->Form->create('Contact',array('action'=>'import','class'=>'form-horizontal','type'=>'file')); ?>
	<fielsset>
	<?php  echo $this->Form->input('CsvFile', array('label'=>__('CSV File'),'type'=>'file') ); ?>
	<div class="form-actions">
	<?php echo $this->Form->submit('<i class="icon-save"></i> '.__('Import'),array( 'div'=>false,'class'=>'btn btn-info')); ?>
	&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'contacts','action'=>'index')); ?>" class="btn btn-primary"><i class="icon-reply"></i>&nbsp;<?php echo __('Cancel'); ?></a>
	</div>
	</fielsset>
	<?php echo $this->Form->end();?>
	<?php if (isset($import_errors)) print_r($import_errors); ?>
</div>
</div>