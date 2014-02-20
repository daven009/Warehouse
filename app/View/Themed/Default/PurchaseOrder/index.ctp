<div>
	<div>
		<h3><?php echo __('Purchase Orders'); ?>
		<?php if(!in_array('self',$this->params['pass'])):?>
		<a class="btn btn-success btn-mini" href="<?php echo $this->Html->url(array('controller'=>'quotation','action'=>'add')); ?>"><i class="icon-plus"></i> <?php echo __('New'); ?></a>
		<?php endif?>
		<?php echo $this->Form->create('PurchaseOrder', array('url' => array_merge(array('action' => 'index'), $this->params['pass']),'class'=>'navbar-search pull-right')); ?>
	  		<div class="input-append">
	  		<?php echo $this->Form->input('search_all',array('div'=>false,'class'=>'span2','placeholder'=>'Search','label'=>false)); ?>
	  		<button type="submit" class="btn btn-success"><i class="icon-search"></i></button>
	  		<a class="btn btn-primary" id="more" ><i class="icon-caret-down"></i> <?php echo __('More'); ?></a>	
	  		</div>
	  	<?php echo $this->Form->end(); ?>	
		</h3>
		<?php if($searched): 
		$search_args = $this->passedArgs; ?>
		<div class="filter-result-box alert alert-info" >
		<button type="button" id="filter-result-close" class="close" data-dismiss="alert">&times;</button>
			<?php if(!empty($search_args['search_number'])): ?>
			<strong><?php echo __('Number:'); ?> </strong><span><?php echo $search_args['search_number']; ?></span>
			<?php endif; ?>
			<?php if(!empty($search_args['search_company_name'])): ?>
			<strong><?php echo __('Name:'); ?> </strong><span><?php echo $search_args['search_company_name']; ?></span>
			<?php endif; ?>
			<?php if(!empty($search_args['search_date_from'])): ?>
			<strong><?php echo __('From Date:'); ?> </strong><span><?php echo $search_args['search_date_from']; ?></span>
			<?php endif; ?>
			<?php if(!empty($search_args['search_date_to'])): ?>
			<strong><?php echo __('To Date:'); ?> </strong><span><?php echo $search_args['search_date_to']; ?></span>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="filter-box" style="display:none">
			<?php echo $this->Form->create('PurchaseOrder', array('url' => array_merge(array('controller'=>'quotation','action' => 'index'), $this->params['pass']),'class'=>'form-inline')); ?>
			<fieldset>
			<legend><?php echo __('Filters'); ?></legend>
			<?php echo $this->Form->input('search_number',array('div'=>false,'class'=>'span2','label'=>'Number ')); ?>
			<?php echo $this->Form->input('search_company_name',array('div'=>false,'class'=>'span2','label'=>'Company Name ','placeholder'=>'Company Name')); ?>
			<?php echo $this->Form->input('search_date_from',array('div'=>false,'class'=>'span2 date','label'=>'From ')); ?>
			<?php echo $this->Form->input('search_date_to',array('div'=>false,'class'=>'span2 date','label'=>'To ')); ?>
			<?php echo $this->Form->submit('Filter',array('div'=>false,'class'=>'btn btn-info')); ?>
			</fieldset>
			<?php $this->Form->end(); ?>
		</div>
	</div>
	<div class="pagination pagination-centered pagination-mini">
	  <ul>
		<?php echo $this->Paginator->prev(''); ?>
		<?php echo $this->Paginator->numbers(array('first' => 2, 'last' => 2));?>
		<?php echo $this->Paginator->next(''); ?>
	  </ul>
	</div>
	<table class="table table-bordered table-hover table-striped table-striped-warning">
		<thead>
		<?php
			echo $this->Html->tableHeaders(array(
					array(__('Number')=>array('class'=>'info')),
					array(__('Supplier Name')=>array('class'=>'info')),
					array(__('Customer Name')=>array('class'=>'info')),
					array(__('Status')=>array('class'=>'info')),
					array(__('Amount')=>array('class'=>'warning')),
					array(__('Date')=>array('class'=>'warning')),
					array(__('Action')=>array('class'=>'warning'))));
		?>
		</thead>
		<tbody>
		<?php if(empty($quotations)): ?>
		<tr>
			<td colspan="7" class="striped-info"><?php echo __('No record found.'); ?></td>
		</tr>
		<?php endif; ?>
		<?php foreach ($quotations as $quotation):?>
		<tr>
			<td><?php echo $quotation['PurchaseOrder']['number']?></td>
			<td><?php echo $quotation['Supplier']['name']; ?></td>
			<td><?php echo $quotation['Company']['name']; ?></td>
			<td><?php echo $this->Status->format($quotation['PurchaseOrder']['status'])?></td>
			<td><?php echo $quotation['PurchaseOrder']['amount']; ?></td>
			<td><?php echo $quotation['PurchaseOrder']['order_date']; ?></td>
			<td>
				<a href="<?php echo $this->Html->url(array('controller' => 'purchase_order', 'action' => 'view', $quotation['PurchaseOrder']['id'])); ?>"><i class="icon-eye-open"></i></a>
			</td>
		</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div class="pagination pagination-centered pagination-mini">
	  <ul>
		<?php echo $this->Paginator->prev(''); ?>
		<?php echo $this->Paginator->numbers(array('first' => 2, 'last' => 2));?>
		<?php echo $this->Paginator->next(''); ?>
	  </ul>
	</div>
</div>
<script>
jQuery(function($) {
	$("#more").click(function(){
		$(".filter-box").toggle('fold');
	});
	$(".date").datepicker({ dateFormat: 'yy-mm-dd' });
	$('#filter-result-close').click(function(){
		window.location.href = "<?php echo $this->Html->url(array_merge(array('controller'=>'quotation','action' => 'index'), $this->params['pass'])); ?>";
	});
});
</script>