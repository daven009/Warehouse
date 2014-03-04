<div>
	<div class="row-fluid">
		<div class="span5 view-contact-box">
			<h3><?php echo __('Delivery Order Details'); ?></h3>
			<div class="row-fluid">
				<div class="span12">
					<table class="table table-condensed">
						<thead>
						<tr>
							<th><?php echo __('Number:'); ?></th>
							<th><?php echo $delivery_order['DeliveryOrder']['number']?></th>
						</tr>
						</thead>
						<tr>
							<td><?php echo __('Customer:'); ?></td>
							<td><?php echo $delivery_order['Customer']['name']?></td>
						</tr>
						<tr>
							<td><?php echo __('Supplier:')?></td>
							<td><?php echo $delivery_order['Company']['name']?></td>
						</tr>
						<tr>
							<td><?php echo __('Address:')?></td>
							<td><?php echo $delivery_order['Customer']['address']?></td>
						</tr>
						<tr>
							<td><?php echo __('Postal:'); ?></td>
							<td><?php echo $delivery_order['Customer']['postal_code']?></td>
						</tr>
						<tr>
							<td><?php echo __('Amount:'); ?></td>
							<td><?php echo $delivery_order['DeliveryOrder']['amount']?></td>
						</tr>
						<tr>
							<td><?php echo __('Status:'); ?></td>
							<td><?php echo $this->Status->format($delivery_order['DeliveryOrder']['status'])?></td>
						</tr>
						<tr>
							<td><?php echo __('Remark:'); ?></td>
							<td><?php echo $delivery_order['DeliveryOrder']['remark']?></td>
						</tr>
						<tr>
							<td><?php echo __('Created:'); ?></td>
							<td><?php echo $delivery_order['DeliveryOrder']['created']?></td>
						</tr>
						<tr>
							<td><?php echo __('Modified:'); ?></td>
							<td><?php echo $delivery_order['DeliveryOrder']['modified']?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="span7">
			<div class="tabbable contact-tabbable">
				<ul class="nav nav-tabs">
			    	<li class="tab-green active"><a href="#tab1" data-toggle="tab"><?php echo __('Related Goods')?></a></li>
			  	</ul>
			  	<div class="tab-content">
			  		<div class="tab-pane active" id="tab1">
			  			<table class="table table-bordered table-hover table-striped table-striped-success">
							<thead class="success">
							<?php
								echo $this->Html->tableHeaders(array(__('Name'), __('Description'),__('Price'),__('Quantity'),__('Total')));
							?>
							</thead>
							<tbody>
							<?php foreach ($delivery_order['DeliveryOrder']['items'] as $item):?>
							<tr>
								<td><?php echo $goods[$item['id']]?></td>
								<td><?php echo $item['description']; ?></td>
								<td align="right"><?php echo $item['price']; ?></td>
								<td align="right"><?php echo $item['quantity']; ?></td>
								<td align="right"><?php echo $item['total']; ?></td>
							</tr>
							<?php endforeach;?>
							</tbody>
						</table>
			  		</div>
			  	</div>
			  	<div class="view-contact-back">
			  		<?php if(($delivery_order['DeliveryOrder']['status']==PENDING)):?>
			  			<?php if($delivery_order['DeliveryOrder']['company_id']==$this->Session->read('Auth.User.company_id')):?>
							<?php echo $this->Html->link(__('Stock Out'),array('controller'=>'delivery_order','action'=>'confirm',$delivery_order['DeliveryOrder']['id']),array('class'=>'btn btn-primary'));?>
						<?php endif;?>	
					<?php endif;?>
			  		<?php if(($delivery_order['DeliveryOrder']['status']==DELIVERING)):?>
			  			<?php if($delivery_order['DeliveryOrder']['customer_id']==$this->Session->read('Auth.User.company_id') && $delivery_order['DeliveryOrder']['status']==DELIVERING):?>
							<?php echo $this->Html->link(__('Stock In'),array('controller'=>'delivery_order','action'=>'receive',$delivery_order['DeliveryOrder']['id']),array('class'=>'btn btn-primary'));?>
						<?php endif;?>
					<?php endif;?>
					<?php if($delivery_order['DeliveryOrder']['company_id']==$this->Session->read('Auth.User.company_id')):?>
						<?php echo $this->Html->link(__('Back'),array('controller'=>'delivery_order','action'=>'index'),array('class'=>'btn btn-inverse'));?>
					<?php else:?>
						<?php echo $this->Html->link(__('Back'),array('controller'=>'delivery_order','action'=>'index','self'),array('class'=>'btn btn-inverse'));?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
	
</div>