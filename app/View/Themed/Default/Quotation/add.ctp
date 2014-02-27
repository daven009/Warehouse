<div>
	<?php echo $this->Form->create('Quotation',array('inputDefaults'=>array('label'=>false,'div'=>false))); ?>
	<div class="row-fluid">
		<div class="span5 view-contact-box">
			<h3><?php echo __('Quotation Details'); ?></h3>
			<div class="row-fluid">
				<div class="span12">
					<table class="table table-condensed">
						<thead>
						<tr>
							<th><?php echo __('Number:'); ?></th>
							<th>Auto-generate</th>
						</tr>
						</thead>
						<tr>
							<td><?php echo __('Customer:'); ?></td>
							<td><?php echo $this->Form->input('customer_id',array('data'=>$customers,'type'=>'select'))?></td>
						</tr>
						<tr>
							<td><?php echo __('Order Date:'); ?></td>
							<td><?php echo $this->Form->input('order_date',array('type'=>'text','class'=>'date'))?></td>
						</tr>
						
						<tr>
							<td><?php echo __('Remark:'); ?></td>
							<td><?php echo $this->Form->input('remark')?></td>
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
								echo $this->Html->tableHeaders(array('',__('Name'), __('Description'),__('Price'),__('Quantity'),__('Total')));
							?>
							</thead>
							<tbody id="record-tbody">
								<?php if(@$this->data['Quotation']['items']):?>
									<?php foreach($this->data['Quotation']['items'] as $k=>$item):?>
									<tr class="native-record">
										<td><span class="removerow" style="cursor: pointer"><i class="icon-remove"></i></span></td>
										<td data-modal-title="<?php echo __('Add Item')?>" data-modal-href="<?php echo Router::url(array('controller'=>'Quotation','action'=>'addPart'))?>" class="native-row">
											<?php echo $this->Form->input("Quotation.items.$k.id",array('type'=>'hidden','class'=>'span12 m-wrap part_id'))?>
											<span class="text"><?php echo $goods[$item['id']]?></span>
										</td>
										<td><?php echo $this->Form->input("Quotation.items.$k.description",array('class'=>'span12 m-wrap description'))?></td>
										<td class="control-group controls"><?php echo $this->Form->input("Quotation.items.$k.price",array('class'=>'right_align span12 m-wrap number price'))?></td>
										<td class="control-group controls"><?php echo $this->Form->input("Quotation.items.$k.quantity",array('class'=>'right_align span12 m-wrap number quantity'))?></td>
										<td class="control-group controls"><?php echo $this->Form->input("Quotation.items.$k.total",array('class'=>'right_align span12 m-wrap number totalprice'))?></td>
									</tr>
									<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td width="30"></td>
									<td style="vertical-align:middle"><?php echo $this->Form->select('items_id',$goods,array('type'=>'select'))?></td>
									<td><?php echo $this->Html->link(__('Add'),'javascript:;',array('onclick'=>'add()','class'=>'btn btn-success'));?></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tfoot>
						</table>
			  		</div>
			  	</div>
			  	
			  	<div class="view-contact-back">
			  	<?php echo $this->Html->link(__('Save'),'javascript:;',array('onclick'=>'$("form").submit()','class'=>'btn btn-primary'));?>		
			  	<?php if(isset($this->data['PurchaseOrder']['id'])):?>
					<?php echo $this->Html->link(__('Back'),array('controller'=>'quotation','action'=>'view',$this->data['Quotation']['id']),array('class'=>'btn btn-inverse'));?>
				<?php else:?>
					<?php echo $this->Html->link(__('Back'),array('controller'=>'quotation','action'=>'index'),array('class'=>'btn btn-inverse'));?>
				<?php endif;?>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end()?>
	
	<table id="templatetr_part" style="display:none">
	<?php $k = 0;?>
	<tr class="native-record">
		<td><span class="removerow" style="cursor: pointer"><i class="icon-remove"></i></span></td>
		<td data-modal-title="<?php echo __('Add Item')?>" data-modal-href="<?php echo Router::url(array('controller'=>'Quotation','action'=>'addPart'))?>" class="native-row">
			<?php echo $this->Form->input("Quotation.items.$k.id",array('type'=>'hidden','class'=>'span12 m-wrap part_id'))?>
			<span class="part_name text"></span>
		</td>
		<td><?php echo $this->Form->input("Quotation.items.$k.description",array('class'=>'span12 m-wrap description'))?></td>
		<td class="control-group controls"><?php echo $this->Form->input("Quotation.items.$k.price",array('class'=>'right_align span12 m-wrap number price'))?></td>
		<td class="control-group controls"><?php echo $this->Form->input("Quotation.items.$k.quantity",array('class'=>'right_align span12 m-wrap number quantity'))?></td>
		<td class="control-group controls"><?php echo $this->Form->input("Quotation.items.$k.total",array('class'=>'right_align span12 m-wrap number totalprice'))?></td>
	</tr>
	</table>
</div>

<script>
$(document).ready(function(){
	$(".date").datepicker({ dateFormat: "dd/mm/yy" });
})

<?php if(@$this->data['Quotation']['items']):?>
var i = <?php echo count($this->data['Quotation']['items'])?>;
<?php else:?>
var i = 0;
<?php endif;?>
function add(){
	var cl = $("#templatetr_part tr").clone();
	cl = fixRow(cl,i);

	var url = "<?php echo Router::url(array('controller'=>'Good','action'=>'find'))?>/"+$('#QuotationItemsId').val();
	 $.ajax({
		 url:url,
		 type:'get',
		 dataType:'json'
	 }).done(function(data){
		 $('#record-tbody').append(cl);
			cl.find(".part_id").val(data.id);
			cl.find(".part_name").html(data.name);
			cl.find(".price").attr("value",data.sales_price);
			cl.find(".description").val(data.description);

			i++;
	 });
}
</script>