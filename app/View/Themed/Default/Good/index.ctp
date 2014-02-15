<div>
	<div>
		<h3><?php echo __('Products'); ?>
		<?php if((AuthComponent::user('group_id')==ADMINISTRATOR || AuthComponent::user('group_id')==SUPERADMIN) && $CompanyRole==DEALER):?>
		<a class="btn btn-success btn-mini" href="<?php echo $this->Html->url(array('controller'=>'good','action'=>'add')); ?>"><i class="icon-plus"></i> <?php echo __('New')?></a>
		<?php endif;?>
		<?php echo $this->Form->create('Good', array('class'=>'navbar-search pull-right')); ?>
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
			<?php echo $this->Form->create('Good', array('class'=>'form-inline')); ?>
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
					array(__('Description')=>array('class'=>'warning')),
					array(__('Unit')=>array('class'=>'warning')),
					array(__('Sales Price')=>array('class'=>'warning')),
					array(__('Remark')=>array('class'=>'warning')),
					array(__('Action')=>array('class'=>'warning'))));
		?>
		</thead>
		<tbody>
		<?php if(empty($goods)): ?>
		<tr>
			<td colspan="8" class="striped-info"><?php echo __('No record found.'); ?></td>
		</tr>
		<?php endif; ?>
		<?php foreach ($goods as $good):?>
		<tr>
			<td><?php echo $good['Good']['name']; ?></td>
			<td><?php echo $good['Good']['description']; ?></td>
			<td><?php echo $good['Good']['unit']; ?></td>
			<td><?php echo $good['Good']['sales_price']; ?></td>
			<td><?php echo $good['Good']['remark']; ?></td>
			<td>
				<?php if((AuthComponent::user('group_id')==ADMINISTRATOR||AuthComponent::user('group_id')==SUPERADMIN) && $CompanyRole==DEALER):?>
				<a href="<?php echo $this->Html->url(array('controller' => 'good', 'action' => 'edit', $good['Good']['id'])); ?>"><i class="icon-edit"></i></a>
				<?php endif;?>
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
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'good','action'=>'index')); ?>";
	});
});
</script>