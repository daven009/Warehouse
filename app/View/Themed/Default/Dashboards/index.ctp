<?php
//echo $this->Html->script('rgraph/RGraph.common.core');
//echo $this->Html->script('rgraph/RGraph.line');
echo $this->Html->script('jqplot/jquery.jqplot.min');
echo $this->Html->script('jqplot/plugins/jqplot.canvasTextRenderer.min');
echo $this->Html->script('jqplot/plugins/jqplot.canvasAxisLabelRenderer.min');
echo $this->Html->script('jqplot/plugins/jqplot.canvasAxisTickRenderer.min');
echo $this->Html->css('jqplot/jquery.jqplot.min');
?>
<div class="row">
	<?php if($this->Session->read('Auth.User.group_id')==9999):?>
	<div class="span6">
		<h3 class="title-dashboard"><?php echo $this->Html->link(__('Companies'),array('plugin'=>'','controller'=>'company')); ?> <a class="btn btn-success btn-mini" href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'company','action'=>'add')); ?>"><i class="icon-plus"></i> <?php echo __('New'); ?></a></h3>
		<div>
			<table class="table table-bordered table-striped table-striped-warning">
				<thead class="warning">
					<?php echo $this->Html->tableHeaders(array(__('Name'), __('Type'), __('Address'), __('Postal Code')));?>
				</thead>
				<tbody>
					<?php foreach($companies as $company): ?>
					<tr>
						<td><a href="<?php echo $this->Html->url(array('controller' => 'company', 'action' => 'view', $company['Company']['id'])); ?>"><?php echo $company['Company']['name']; ?></a></td>
						<td>
						<?php
							if ($company['CompanyGroup']['name']=='Dealer'){
								
								echo '<span class="label label-important">' . $company['CompanyGroup']['name'] . '</span>';
							}
							else if($company['CompanyGroup']['name']=='Distributor'){
								echo '<span class="label label-warning">' . $company['CompanyGroup']['name'] . '</span>';
								
							}
							else if($company['CompanyGroup']['name']=='Supplier'){
								echo '<span class="label label-success">' . $company['CompanyGroup']['name'] . '</span>';
							}
						?>
						</td>
						<td><?php echo $company['Company']['address']; ?></td>
						<td><?php echo $company['Company']['postal_code']; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php endif;?>
	<div class="span6">
		<h3><?php echo __('Deal Growth Chart'); ?></h3>
		<div class="chart-box">
			<!--  <canvas id="thegraph" width="460" height="165">[Canvas not supported]</canvas>-->
			<div id="chartdiv" ></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="span6">
		<h3 class="title-dashboard"><?php echo $this->Html->link(__('My Deals'),array('plugin'=>'','controller'=>'deals'))?> <a class="btn btn-success btn-mini" href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'deals','action'=>'add')); ?>"><i class="icon-plus"></i> <?php echo __('New'); ?></a></h3>
		<div>
			<table class="table table-bordered table-striped table-striped-success">
				<thead class="success">
					<?php echo $this->Html->tableHeaders(array(__('Amount'), __('Company Name'), __('Status'),__('Date'))); ?>
				</thead>
				<tbody>
					<?php foreach($deals as $deal): ?>
					<tr>
						<td><a href="<?php echo $this->Html->url(array('controller' => 'deals', 'action' => 'view', $deal['Deal']['id'])); ?>"><?php echo $this->Number->currency($deal['Deal']['amount'],'USD',array('before'=>$currency)); ?></a></td>
						<td><?php echo $deal['Company']['full_name']; ?></td>
						<td><?php if($deal['DealStatus']['name']=='Process'){
							echo '<span class="label label-warning">'.$deal['DealStatus']['name'].'</span>'; 
						}
						else if($deal['DealStatus']['name']=='Accepted'){
							echo '<span class="label label-success">'.$deal['DealStatus']['name'].'</span>';
						}
						else if($deal['DealStatus']['name']=='Rejected'){
							echo '<span class="label label-important">'.$deal['DealStatus']['name'].'</span>';
						}?>
						</td>
						<td><?php echo $deal['Deal']['date']; ?>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="span6">
		<h3 class="title-dashboard"><?php echo $this->Html->link(__('My Events'),array('plugin'=>'full_calendar','controller'=>'events')); ?> <a class="btn btn-success btn-mini" href="<?php echo $this->Html->url(array('plugin'=>'full_calendar','controller'=>'events','action'=>'add')); ?>"><i class="icon-plus"></i> <?php echo __('New'); ?></a></h3>
		<div>
			<table class="table table-bordered table-striped table-striped-info">
				<thead class="info">
					<?php echo $this->Html->tableHeaders(array(__('Title'),__('Start'),__('End'),__('Status'))); ?>
				</thead>
				<tbody>
					<?php foreach($events as $event):?>
					<tr>
						<td><?php echo $this->Html->link($event['Event']['title'], array('plugin'=>'full_calendar','controller'=>'events','action' => 'view', $event['Event']['id'])); ?></td>
						<td><?php echo $event['Event']['start']; ?></td>
						<td><?php echo $event['Event']['end']; ?></td>
						<td><?php echo $event['Event']['status']; ?></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	.jqplot-yaxis-tick {
		right:1px;
		text-align:right;
	}
	.jqplot-xaxis {
		margin-top:3px;
	}
</style>
<script>
    var data = <?php echo json_encode($deal_graph_data);?>;
    var ticks =  <?php echo json_encode($ticks); ?>;//[["1","jj"],["2","kk"],["3","ll"],["4","mm"],["5","nn"],["6","oo"],["7","pp"]];
        
$(document).ready(function(){

  var plot3 = $.jqplot('chartdiv', data, 
    { 
      //title:'Line Style Options', 
      // Series options are specified as an array of objects, one object
      // for each series.
      series:[ 
          {
            // Change our line width and use a diamond shaped marker.
            label:'<?php echo __('Process')?>',
            lineWidth:1, 
            showMarker:false,
            color: 'rgb(248, 148, 6)',
            //markerOptions: { style:'diamond' }
          }, 
          {
        	  label:'<?php echo __('Accepted'); ?>',
        	 lineWidth:1,
        	 showMarker:false,
        	 color: 'rgb(70, 136, 71)',
            //showLine:false, 
            //markerOptions: { size: 7, style:"x" }
          },
          {
        	  label:'<?php echo __('Rejected'); ?>',
        	 lineWidth:1,
        	 showMarker:false,
        	 color: 'rgb(185, 74, 72)',
           // markerOptions: { style:"circle" }
          }
      ],
      legend: {
          show: false,
          location: 'e',
          placement: 'Grid'
      },
      axesDefaults: {
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer
          //tickRenderer: $.jqplot.CanvasAxisTickRenderer
        },
      
        axes: {
          // options for each axis are specified in seperate option objects.
          xaxis: {
        	  renderer: $.jqplot.CategoryAxisRenderer,
        	  //renderer:$.jqplot.DateAxisRenderer,
        	  tickRenderer: $.jqplot.CanvasAxisTickRenderer,
              tickOptions:{
                 angle:-90,
                fontSize:'11px',
                  },
              ticks: ticks,
            
           pad: 0,
            
          },
          yaxis: {
              tickOptions:{
            	  	formatString:'<?php echo $currency;?>%.0f&nbsp;&nbsp;',
                	angle: 0
                  },
            //label: "",
            min: 0,
          }
        }
    }
  );
    
});
</script>