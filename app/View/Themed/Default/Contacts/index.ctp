<div>
	<div>
		<h3><?php echo __('Contacts'); ?>
		<a class="btn btn-success btn-mini" href="<?php echo $this->Html->url(array('controller'=>'contacts','action'=>'add')); ?>"><i class="icon-plus"></i> <?php echo __('New')?></a>
		<a class="btn btn-info btn-mini btn-left-margin" href="<?php echo $this->Html->url(array_merge(array('controller'=>'contacts','action'=>'index'),$this->params['named'],array(''))).'/contacts-'.date('m-d-Y-His-A').'.csv'; ?>"><i class="icon-file-text"></i> <?php echo __('Download Excel/CSV')?></a>
		<a class="btn btn-info btn-mini btn-left-margin" href="<?php echo $this->Html->url(array('controller'=>'contacts','action'=>'import')); ?>"><i class="icon-file-text"></i> <?php echo __('CSV Import');?></a>
		<?php echo $this->Form->create('Contact', array('url' => array_merge(array('action' => 'index'), $this->params['pass']),'class'=>'navbar-search pull-right')); ?>
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
			<?php if(!empty($search_args['search_city'])): ?>
			<strong><?php echo __('City:'); ?> </strong><span><?php echo $search_args['search_city']; ?></span>
			<?php endif; ?>
			<?php if(!empty($search_args['search_company'])): ?>
			<strong><?php echo __('Company:'); ?> </strong><span><?php echo $search_args['search_company']; ?></span>
			<?php endif; ?>
			<?php if(!empty($search_args['search_phone'])): ?>
			<strong><?php echo __('Phone:'); ?> </strong><span><?php echo $search_args['search_phone']; ?></span>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="filter-box" style="display:none">
			<?php echo $this->Form->create('Contact', array('url' => array_merge(array('action' => 'index'), $this->params['pass']),'class'=>'form-inline')); ?>
			<fieldset>
			<legend>__(Filters)</legend>
				
				<?php echo $this->Form->input('search_name',array('div'=>false,'class'=>'span2','label'=>'Name ','placeholder'=>'Name')); ?>
				<?php echo $this->Form->input('search_city',array('div'=>false,'class'=>'span2','label'=>'City ','placeholder'=>'City')); ?>
				<?php echo $this->Form->input('search_company',array('div'=>false,'class'=>'span2','label'=>'Company ','placeholder'=>'Company')); ?>
				<?php echo $this->Form->input('search_phone',array('div'=>false,'class'=>'span2','label'=>'Phone ','placeholder'=>'Phone')); ?>
				<?php echo $this->Form->input('search_email',array('div'=>false,'class'=>'span2','label'=>'Email ','placeholder'=>'Email')); ?>
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
					array(__('First Name')=>array('class'=>'info')),
					array(__('Last Name')=>array('class'=>'info')),
					array(__('Status')=>array('class'=>'warning')),
					array(__('Company')=>array('class'=>'warning')),
					array(__('City')=>array('class'=>'warning')),
					array('<i class="icon-mobile-phone"></i> '.__('Phone #')=>array('class'=>'warning')),
					array('<i class="icon-envelope"></i> '.__('E-mail')=>array('class'=>'warning')),
					array(__('Action')=>array('class'=>'warning'))));
		?>
		</thead>
		<tbody>
		<?php if(empty($contacts)): ?>
		<tr>
			<td colspan="8" class="striped-info"><?php echo __('No record found.'); ?></td>
		</tr>
		<?php endif; ?>
		<?php foreach ($contacts as $contact):?>
		<tr>
			<td class="striped-info"><a href="<?php echo $this->Html->url(array('controller' => 'contacts', 'action' => 'view', $contact['Contact']['id'])); ?>">
			<?php
			if($contact['Contact']['photo']){
				echo $this->Html->image('../files/contact/photo/'.$contact['Contact']['photo_dir'].'/thumb_'.$contact['Contact']['photo'],array('class'=>'','width'=>'20px','height'=>'30px'));
			}
			else {
				echo $this->Html->image('no-picture.png',array('class'=>'','width'=>'20px','height'=>'30px'));
			}
			 ?>&nbsp;<?php echo $contact['Contact']['first_name']; ?></a></td>
			<td class="striped-info"><a href="<?php echo $this->Html->url(array('controller' => 'contacts', 'action' => 'view', $contact['Contact']['id'])); ?>"><?php echo $contact['Contact']['last_name']; ?></a></td>
			<td>
			<?php
				if ($contact['ContactStatus']['name']=='Lead'){
					
					echo '<span class="label label-important">' . $contact['ContactStatus']['name'] . '</span>';
				}
				else if($contact['ContactStatus']['name']=='Opportunity'){
					echo '<span class="label label-warning">' . $contact['ContactStatus']['name'] . '</span>';
					
				}
				else if($contact['ContactStatus']['name']=='Account'){
					echo '<span class="label label-success">' . $contact['ContactStatus']['name'] . '</span>';
				}
			?>
			</td>
			<td><?php echo $contact['Contact']['company']; ?></td>
			<td><?php echo $contact['Contact']['city']; ?></td>
			<td><?php echo $contact['Contact']['phone']; ?></td>
			<td><?php echo $contact['Contact']['email']; ?></td>
			<td>
				<a href="<?php echo $this->Html->url(array('controller' => 'contacts', 'action' => 'edit', $contact['Contact']['id'])); ?>"><i class="icon-edit"></i></a>
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
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'contacts','action'=>'index')); ?>";
	});
});
</script>