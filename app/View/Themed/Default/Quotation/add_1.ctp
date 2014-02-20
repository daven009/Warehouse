<div class="row">
<div class="span7 offset2 add-deal-box">
	<div><h3><?php echo __('Add New Quotation'); ?></h3></div>
	<?php echo $this->Form->create('Quotation',array('class'=>'form-horizontal')); ?>
	<fieldset>
	<?php echo $this->Form->input('customer_id',array('class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('amount',array('type'=>'text','class'=>'span3')); ?>
	<?php echo $this->Form->input('date',array('class'=>'span1 date')); ?>
	<div class="form-actions">
	<?php echo $this->Form->submit('<i class="icon-save"></i> '.__('Add'),array( 'div'=>false,'class'=>'btn btn-info')); ?>
	&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'deals','action'=>'index')); ?>" class="btn btn-primary"><i class="icon-reply"></i>&nbsp;<?php echo __('Cancel'); ?></a>
	</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
</div>
<script>
jQuery(function($) {
	$(".date").datepicker({ dateFormat: 'yy-mm-dd' });
})
</script>