<div>
	<div class="row-fluid">
		<div class="span5 view-contact-box">
			<h3><?php echo __('Quotation Details'); ?></h3>
			<div class="row-fluid">
				<div class="span12">
					<table class="table table-condensed">
						<thead>
						<tr>
							<th><?php echo __('Number:'); ?></th>
							<th><?php echo $purchase['PurchaseOrder']['number']?></th>
						</tr>
						</thead>
						<tr>
							<td><?php echo __('Customer:'); ?></td>
							<td><?php echo $purchase['Company']['name']?></td>
						</tr>
						<tr>
							<td><?php echo __('Supplier:')?></td>
							<td><?php echo $purchase['Supplier']['name']?></td>
						</tr>
						<tr>
							<td><?php echo __('Address:')?></td>
							<td><?php echo $purchase['Company']['address']?></td>
						</tr>
						<tr>
							<td><?php echo __('Postal:'); ?></td>
							<td><?php echo $purchase['Company']['postal_code']?></td>
						</tr>
						<tr>
							<td><?php echo __('Amount:'); ?></td>
							<td><?php echo $purchase['PurchaseOrder']['amount']?></td>
						</tr>
						<tr>
							<td><?php echo __('Status:'); ?></td>
							<td><?php echo $this->Status->format($purchase['PurchaseOrder']['status'])?></td>
						</tr>
						<tr>
							<td><?php echo __('Remark:'); ?></td>
							<td><?php $purchase['PurchaseOrder']['remark']?></td>
						</tr>
						<tr>
							<td><?php echo __('Created:'); ?></td>
							<td><?php echo $purchase['PurchaseOrder']['created']?></td>
						</tr>
						<tr>
							<td><?php echo __('Modified:'); ?></td>
							<td><?php echo $purchase['PurchaseOrder']['modified']?></td>
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
							<?php foreach ($purchase['PurchaseOrder']['items'] as $item):?>
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
			  	<?php if($purchase['PurchaseOrder']['status']==PENDING && $purchase['PurchaseOrder']['supplier_id']==$this->Session->read('Auth.User.company_id')):?>
			  		<div class="view-contact-box">
			  		<h3><?php echo __('Confirm with detail'); ?></h3>
			  		<?php echo $this->Form->create('DeliveryOrder',array('url'=>array('controller'=>'purchase_order','action'=>'confirm',$purchase['PurchaseOrder']['id']),'id'=>'PurchaseOrderForm','class'=>'form-horizontal')); ?>
					<fieldset>
					<?php echo $this->Form->input('number',array('type'=>'text','label'=>'DO Number','class'=>'input-xlarge','placeholder'=>'leave blank will be auto-generated')); ?>
					<?php echo $this->Form->input('remark',array('type'=>'textarea','class'=>'input-xlarge')); ?>
					</fieldset>
					<?php echo $this->Form->end(); ?>
					</div>
			  	<?php endif;?>
			  	<div class="view-contact-back">
			  		<?php if(($purchase['PurchaseOrder']['status']==PENDING||$purchase['PurchaseOrder']['status']==PENDINGADMIN)):?>
			  			<?php if($purchase['PurchaseOrder']['company_id']==$this->Session->read('Auth.User.company_id')):?>
			  				<?php if(($this->Session->read('Auth.User.group_id')==ADMINISTRATOR||$this->Session->read('Auth.User.group_id')==SUPERADMIN)&&$purchase['PurchaseOrder']['status']==PENDINGADMIN):?>
			  					<?php echo $this->Html->link(__('Approve'),array('controller'=>'quotation','action'=>'approve',$purchase['PurchaseOrder']['id']),array('class'=>'confirm btn btn-success'));?>
			  				<?php endif;?>
							<?php echo $this->Html->link(__('Edit'),array('controller'=>'quotation','action'=>'edit',$purchase['PurchaseOrder']['id']),array('class'=>'btn btn-primary'));?>
						<?php elseif($purchase['PurchaseOrder']['supplier_id']==$this->Session->read('Auth.User.company_id')):?>
							<?php echo $this->Html->link(__('Confirm'),'javascript:;',array('onclick'=>"$('#PurchaseOrderForm').submit()",'class'=>'btn btn-success'));?>
						<?php endif;?>
					<?php endif;?>
					<?php if($purchase['PurchaseOrder']['company_id']==$this->Session->read('Auth.User.company_id')):?>
						<?php echo $this->Html->link(__('Back'),array('controller'=>'quotation','action'=>'index'),array('class'=>'btn btn-inverse'));?>
					<?php else:?>
						<?php echo $this->Html->link(__('Back'),array('controller'=>'quotation','action'=>'index','self'),array('class'=>'btn btn-inverse'));?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
	
</div>