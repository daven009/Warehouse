<div>
	<div>
		<h3><?php echo __('Stock'); ?>
		<a class="btn btn-success btn-mini" href="<?php echo $this->Html->url(array('controller'=>'stock','action'=>'add')); ?>"><i class="icon-plus"></i> <?php echo __('Stock In')?></a>
		<a class="btn btn-info btn-mini btn-left-margin" href="<?php echo $this->Html->url(array_merge(array('controller'=>'stock','action'=>'index'),$this->params['named'],array(''))).'/stock-'.date('m-d-Y-His-A').'.csv'; ?>"><i class="icon-file-text"></i> <?php echo __('Download Excel/CSV')?></a>
		<a class="btn btn-info btn-mini btn-left-margin" href="<?php echo $this->Html->url(array('controller'=>'stock','action'=>'import')); ?>"><i class="icon-file-text"></i> <?php echo __('CSV Import');?></a>
		<?php echo $this->Form->create('Stock', array('class'=>'navbar-search pull-right')); ?>
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
			<?php if(!empty($search_args['search_name'])): ?>
			<strong><?php echo __('Name:'); ?> </strong><span><?php echo $search_args['search_name']; ?></span>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="filter-box" style="display:none">
			<?php echo $this->Form->create('Stock', array('class'=>'form-inline')); ?>
			<fieldset>
			<legend>__(Filters)</legend>
				<?php echo $this->Form->input('search_name',array('div'=>false,'class'=>'span2','label'=>'Name ','placeholder'=>'Name')); ?>
				<?php echo $this->Form->submit('Filter',array('div'=>false,'class'=>'btn btn-info')); ?>
			</fieldset>
			<?php echo $this->Form->end(); ?>
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
					array(__('Name')=>array('class'=>'info')),
					array(__('Description')=>array('class'=>'info')),
					array(__('Quantity')=>array('class'=>'warning')),
					array(__('Action')=>array('class'=>'warning'))));
		?>
		</thead>
		<tbody>
		<?php if(empty($stocks)): ?>
		<tr>
			<td colspan="8" class="striped-info"><?php echo __('No record found.'); ?></td>
		</tr>
		<?php endif; ?>
		<?php foreach ($stocks as $stock):?>
		<tr>
			<td><?php echo $stock['Good']['name']; ?></td>
			<td><?php echo $stock['Good']['description']; ?></td>
			<td><?php echo $stock['Stock']['total']; ?></td>
			<td>
				<a href="<?php echo $this->Html->url(array('controller' => 'stock', 'action' => 'view', $stock['Stock']['good_id'])); ?>"><i class="icon-eye-open"></i></a>
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
	$(".date").datepicker();
	$('#filter-result-close').click(function(){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'stock','action'=>'index')); ?>";
	});
});
</script>