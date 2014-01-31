<div>
	<div class="row-fluid">
		<div class="span5 view-contact-box">
			<h3><?php echo __('Contact Details'); ?>
				<a href="<?php echo $this->Html->url(array('controller'=>'contacts','action'=>'edit', $contact['Contact']['id'])); ?>" class="btn btn-success btn-mini"><i class="icon-edit"></i> <?php echo __('Edit'); ?></a>
			</h3>
			<div class="row-fluid">
				<div class="span4 img-box">
					<?php if($contact['Contact']['photo']): ?>
					<?php echo $this->Html->image('../files/contact/photo/'.$contact['Contact']['photo_dir'].'/view_'.$contact['Contact']['photo'],array('fullBase' => true,'width'=>'100px','height'=>'120px')); ?>
					<?php else: ?>
					<?php echo $this->Html->image('no-picture.png',array('class'=>'','width'=>'100px','height'=>'120px')); ?>
					<?php endif; ?>
				</div>
				<div class="span8">
					<table class="table table-condensed">
						<thead>
						<tr>
							<th><?php echo __('First Name:'); ?></th>
							<th><?php echo $contact['Contact']['first_name']?></th>
						</tr>
						</thead>
						<tr>
							<td><?php echo __('Last Name:'); ?></td>
							<td><?php echo $contact['Contact']['last_name']?></td>
						</tr>
						<tr>
							<td><?php echo __('Company:')?></td>
							<td><?php echo $contact['Contact']['company']?></td>
						</tr>
						<tr>
							<td><?php echo __('City:')?></td>
							<td><?php echo $contact['Contact']['city']?></td>
						</tr>
						<tr>
							<td><?php echo __('Phone:'); ?></td>
							<td><?php echo $contact['Contact']['phone']?></td>
						</tr>
						<tr>
							<td><?php echo __('Email:'); ?></td>
							<td><?php echo $contact['Contact']['email']?></td>
						</tr>
						<tr>
							<td><?php echo __('Status:'); ?></td>
							<td><?php
							if ($contact['ContactStatus']['name']=='Lead'){
								
								echo '<span class="label label-important">' . $contact['ContactStatus']['name'] . '</span>';
							}
							else if($contact['ContactStatus']['name']=='Opportunity'){
								echo '<span class="label label-warning">' . $contact['ContactStatus']['name'] . '</span>';
								
							}
							else if($contact['ContactStatus']['name']=='Account'){
								echo '<span class="label label-success">' . $contact['ContactStatus']['name'] . '</span>';
							}
						?>	</td>
						</tr>
						<tr>
							<td><?php echo __('Created:'); ?></td>
							<td><?php echo $contact['Contact']['created']?></td>
						</tr>
						<tr>
							<td><?php echo __('Modified:'); ?></td>
							<td><?php echo $contact['Contact']['modified']?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="span7">
			<div class="tabbable contact-tabbable">
				<ul class="nav nav-tabs">
			    	<li class="tab-green active"><a href="#tab1" data-toggle="tab"><?php echo __('Related Deals')?></a></li>
			    	<li class="tab-blue"><a href="#tab2" data-toggle="tab"><?php echo __('Related Events'); ?></a></li>
			  	</ul>
			  	<div class="tab-content">
			  		<div class="tab-pane active" id="tab1">
			  			<table class="table table-bordered table-hover table-striped table-striped-success">
							<thead class="success">
							<?php
								echo $this->Html->tableHeaders(array(__('Amount'), __('Name'), __('Status'),__('User\'s Name'),__('Date'), __('Action')));
							?>
							</thead>
							<tbody>
							<?php foreach ($deals as $deal):?>
							<tr>
								<td><a href="<?php echo $this->Html->url(array('controller' => 'deals', 'action' => 'view', $deal['Deal']['id'])); ?>"><?php echo $this->Number->currency($deal['Deal']['amount'],'USD',array('before'=>$currency)); ?></a></td>
								<td><?php echo $deal['Contact']['full_name']; ?></td>
								<td><?php if($deal['DealStatus']['name']=='Process'){
									echo '<span class="label label-warning">'.$deal['DealStatus']['name'].'</span>'; 
								}
								else if($deal['DealStatus']['name']=='Accepted'){
									echo '<span class="label label-success">'.$deal['DealStatus']['name'].'</span>';
								}
								else if($deal['DealStatus']['name']=='Rejected'){
									echo '<span class="label label-important">'.$deal['DealStatus']['name'].'</span>';
								}?></td>
								<td><?php echo $deal['children']['User']['full_name']; ?></td>
								<td><?php echo $deal['Deal']['date']; ?></td>
								<td align="center">
									<a href="<?php echo $this->Html->url(array('controller' => 'deals', 'action' => 'edit', $deal['Deal']['id'])); ?>"><i class="icon-edit"></i></a>
								</td>
							</tr>
							<?php endforeach;?>
							</tbody>
						</table>
			  		</div>
			  		<div class="tab-pane" id="tab2">
			  			<table class="table table-bordered table-hover table-striped table-striped-info">
							<thead class="info">
							<?php
								echo $this->Html->tableHeaders(array(__('Title'), __('Status'),__('Start'),__('End'),__('All Day'), __('Action')));
							?>
							</thead>
							<tbody>
							<?php foreach ($events as $event): ?>
							<tr>
								<td><?php echo $this->Html->link($event['Event']['title'], array('plugin'=>'full_calendar','controller'=>'events','action' => 'view', $event['Event']['id'])); ?></td>
								<td><?php echo $event['Event']['status']; ?></td>
								<td><?php echo $event['Event']['start']; ?></td>
						        <?php if($event['Event']['all_day'] == 0) { ?>
						   		<td><?php echo $event['Event']['end']; ?></td>
						        <?php } else { ?>
								<td>N/A</td>
						        <?php } ?>
						        <td><?php if($event['Event']['all_day'] == 1) { echo "Yes"; } else { echo "No"; } ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Html->link('', array('plugin'=>'full_calendar','controller'=>'events','action' => 'edit', $event['Event']['id']),array('icon'=>'edit')); ?>
								</td>
							</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
			  		</div>
			  	</div>
			  	<div class="view-contact-back">
					<?php echo $this->Html->link(__('Back'),array('controller'=>'contacts','action'=>'index'),array('class'=>'btn btn-success'));?>
				</div>
			</div>
		</div>
	</div>
	
</div>