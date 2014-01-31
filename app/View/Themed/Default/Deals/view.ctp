<div class="span6 offset3 view-deal-box">
	<h3><?php echo __('Deal Details'); ?>
	<a href="<?php echo $this->Html->url(array('controller'=>'deals','action'=>'edit', $deal['Deal']['id'])); ?>" class="btn btn-success btn-mini"><i class="icon-edit"></i> <?php echo __('Edit'); ?></a>
	</h3>
	<table class="table table-condensed">
		<thead>
			<tr>
				<th><?php echo __('Contact Name:'); ?></th>
				<th><?php echo $deal['Contact']['full_name']?></th>
			<tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo __('User\'s Name:'); ?></td>
				<td><?php echo $deal['children']['User']['full_name']?></td>
			<tr>
			<tr>
				<td><?php echo __('Amount:'); ?></td>
				<td><?php echo $this->Number->currency($deal['Deal']['amount'],'USD',array('before'=>$currency)); ?></td>
			<tr>
			<tr>
				<td><?php echo __('Date:')?></td>
				<td><?php echo $deal['Deal']['date']?></td>
			<tr>
			<tr>
				<td><?php echo __('Status:'); ?></td>
				<td><?php if($deal['DealStatus']['name']=='Process'){
				echo '<span class="label label-warning">'.$deal['DealStatus']['name'].'</span>'; 
			}
			else if($deal['DealStatus']['name']=='Accepted'){
				echo '<span class="label label-success">'.$deal['DealStatus']['name'].'</span>';
			}
			else if($deal['DealStatus']['name']=='Rejected'){
				echo '<span class="label label-important">'.$deal['DealStatus']['name'].'</span>';
			}?></td>
			<tr>
		</tbody>
	</table>
	
	<div class="view-deal-back">
		<?php echo $this->Html->link(__('Back'),array('controller'=>'deals','action'=>'index'),array('class'=>'btn btn-success'));?>
	</div>
</div>