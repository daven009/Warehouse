<div>
	<div>
		<h3><?php echo __('View Stock Movement'); ?>
		<a class="btn btn-primary btn-mini" href="<?php echo $this->Html->url(array('controller'=>'stock','action'=>'index')); ?>"><i class="icon-reply"></i> <?php echo __('back')?></a>
		</h3>
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
					array(__('Quantity')=>array('class'=>'info')),
					array(__('Type')=>array('class'=>'warning')),
					array(__('Remark')=>array('class'=>'warning'))))
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
			<td><?php echo $stock['Stock']['quantity']; ?></td>
			<td>
			<?php 
			if(is_null($stock['Stock']['foreign_id'])){
				echo "Manual Movement";	
			}
			?></td>
			<td><?php echo $stock['Stock']['remark']; ?></td>
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