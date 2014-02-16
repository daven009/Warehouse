<div>
	<div class="row-fluid">
		<div class="span5 view-contact-box">
			<h3><?php echo __('Quotation Details'); ?>
				<a href="<?php echo $this->Html->url(array('controller'=>'quotation','action'=>'edit', $quotation['Quotation']['id'])); ?>" class="btn btn-success btn-mini"><i class="icon-edit"></i> <?php echo __('Edit'); ?></a>
			</h3>
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
							<td><?php
							if ($quotation['Quotation']['status']=='Lead'){
								
								echo '<span class="label label-important">' . $quotation['Quotation']['status'] . '</span>';
							}
							else if($quotation['Quotation']['status']=='Opportunity'){
								echo '<span class="label label-warning">' . $quotation['Quotation']['status'] . '</span>';
								
							}
							else if($quotation['Quotation']['status']=='Account'){
								echo '<span class="label label-success">' . $quotation['Quotation']['status'] . '</span>';
							}
						?>	</td>
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
								echo $this->Html->tableHeaders(array(__('Name'), __('Description'),__('Price'),__('Quantity'),__('Total'), __('Action')));
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
								
								<td align="center">
								</td>
							</tr>
							<?php endforeach;?>
							</tbody>
						</table>
			  		</div>
			  	</div>
			  	<div class="view-contact-back">
					<?php echo $this->Html->link(__('Back'),array('controller'=>'quotation','action'=>'index'),array('class'=>'btn btn-success'));?>
				</div>
			</div>
		</div>
	</div>
	
</div>