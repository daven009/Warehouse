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
							<th><?php echo $quotation['Quotation']['number']?></th>
						</tr>
						</thead>
						<tr>
							<td><?php echo __('Customer:'); ?></td>
							<td><?php echo $quotation['Customer']['name']?></td>
						</tr>
						<tr>
							<td><?php echo __('Supplier:')?></td>
							<td><?php echo $quotation['Company']['name']?></td>
						</tr>
						<tr>
							<td><?php echo __('Address:')?></td>
							<td><?php echo $quotation['Customer']['address']?></td>
						</tr>
						<tr>
							<td><?php echo __('Postal:'); ?></td>
							<td><?php echo $quotation['Customer']['postal_code']?></td>
						</tr>
						<tr>
							<td><?php echo __('Amount:'); ?></td>
							<td><?php echo $quotation['Quotation']['amount']?></td>
						</tr>
						<tr>
							<td><?php echo __('Status:'); ?></td>
							<td><?php echo $this->Status->format($quotation['Quotation']['status'])?></td>
						</tr>
						<tr>
							<td><?php echo __('Remark:'); ?></td>
							<td><?php echo $quotation['Quotation']['remark']?></td>
						</tr>
						<tr>
							<td><?php echo __('Created:'); ?></td>
							<td><?php echo $quotation['Quotation']['created']?></td>
						</tr>
						<tr>
							<td><?php echo __('Modified:'); ?></td>
							<td><?php echo $quotation['Quotation']['modified']?></td>
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
							<?php foreach ($quotation['Quotation']['items'] as $item):?>
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
			  	<?php if($quotation['Quotation']['status']==PENDING && $quotation['Quotation']['customer_id']==$this->Session->read('Auth.User.company_id')):?>
			  		<div class="view-contact-box">
			  		<h3><?php echo __('Confirm with detail'); ?></h3>
			  		<?php echo $this->Form->create('PurchaseOrder',array('url'=>array('controller'=>'quotation','action'=>'confirm',$quotation['Quotation']['id']),'id'=>'PurchaseOrderForm','class'=>'form-horizontal')); ?>
					<fieldset>
					<?php echo $this->Form->input('number',array('type'=>'text','label'=>'PO Number','class'=>'input-xlarge','placeholder'=>'leave blank will be auto-generated')); ?>
					<?php echo $this->Form->input('remark',array('type'=>'textarea','class'=>'input-xlarge')); ?>
					</fieldset>
					<?php echo $this->Form->end(); ?>
					</div>
			  	<?php endif;?>
			  	<div class="view-contact-back">
			  		<?php if(($quotation['Quotation']['status']==PENDING||$quotation['Quotation']['status']==PENDINGADMIN)):?>
			  			<?php if($quotation['Quotation']['company_id']==$this->Session->read('Auth.User.company_id')):?>
			  				<?php if(($this->Session->read('Auth.User.group_id')==ADMINISTRATOR||$this->Session->read('Auth.User.group_id')==SUPERADMIN)&&$quotation['Quotation']['status']==PENDINGADMIN):?>
			  					<?php echo $this->Html->link(__('Approve'),array('controller'=>'quotation','action'=>'approve',$quotation['Quotation']['id']),array('class'=>'confirm btn btn-success'));?>
			  				<?php endif;?>
							<?php echo $this->Html->link(__('Edit'),array('controller'=>'quotation','action'=>'edit',$quotation['Quotation']['id']),array('class'=>'btn btn-primary'));?>
						<?php elseif($quotation['Quotation']['customer_id']==$this->Session->read('Auth.User.company_id')):?>
							<?php echo $this->Html->link(__('Confirm'),'javascript:;',array('onclick'=>"$('#PurchaseOrderForm').submit()",'class'=>'btn btn-success'));?>
						<?php endif;?>
					<?php endif;?>
					<?php if($quotation['Quotation']['company_id']==$this->Session->read('Auth.User.company_id')):?>
						<?php echo $this->Html->link(__('Back'),array('controller'=>'quotation','action'=>'index'),array('class'=>'btn btn-inverse'));?>
					<?php else:?>
						<?php echo $this->Html->link(__('Back'),array('controller'=>'quotation','action'=>'index','self'),array('class'=>'btn btn-inverse'));?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
	
</div>