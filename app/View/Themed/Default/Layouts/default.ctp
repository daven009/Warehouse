<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title . ' - ' . $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap');
		echo $this->Html->css('bootstrap-responsive.min');
		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css('custom'); //costom css
		echo $this->Html->css('styleless'); //dynamic css
		
		echo $this->Html->css('start/jquery-ui');
		//echo $this->Html->css('redmond/jquery-ui');
		//echo $this->Html->css('cupertino/jquery-ui');
		echo $this->Html->css('jquery-ui-timepicker-addon');
		
		echo $this->Html->script('jquery');
		echo $this->Html->script('bootstrap.min');
		
		echo $this->Html->script('jquery.validate.min');
		echo $this->Html->script('jquery-ui-1.9.2.custom.min');
		echo $this->Html->script('jquery-ui-timepicker-addon');
		echo $this->Html->script('own');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<script>
		
	</script>
    <!-- Le styles -->
   
    <style type="text/css">
      body {
        padding-bottom: 0px;
        background-color:#fffaee;
      }
      
     .masthead .nav {
     	margin-bottom: 10px;
     }
     .navbar-search {
     	margin-top:0px;
     }
	  a.btn {
		button.btn
	  }
	 .nav > li > a.no-hover:hover {
	 	text-decoration:none;
	 	background: transparent;
	 	color:rgb(0,136,204);
	 	background-image: none;
	 }
	 .dropdown:hover .dropdown-menu {
    /*display: block;*/
	}
	.copyright .dropup {
		display:inline-block;
	}
	
    </style>
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>
	<div class="navbar navbar-static-top">
		<div class="navbar-inner zhen-nav">
			<div class="container"><div class="logo">
				<a class="brand muted" href="<?php echo $this->Html->url('/'); ?>">
				<?php echo $this->Html->image('../files/option/logo/'.$logo,array('class'=>'','height'=>'50px')); ?>
				<?php if($title) echo $title; else echo 'Zhen CRM'; ?></a></div>
				<ul class="nav">
	    		  		<li class="<?php if($this->params['controller']=='dashboards') echo 'active'; ?>"><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'dashboards','action'=>'index')); ?>"><span><i class="icon-dashboard"></i></span><?php echo __('DASHBOARD'); ?></a></li>
	    		  		<li class="<?php if($this->params['controller']=='good') echo 'active'; ?>"><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'good','action'=>'index')); ?>"><span><i class="icon-th"></i></span><?php echo __('PRODUCT'); ?></a></li>
		          		<li class="dropdown <?php if($this->params['controller']=='stock') echo 'active'; ?>">
		          		<a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'stock','action'=>'index')); ?>"><span><i class="icon-list"></i></span><?php echo __('INVENTORY'); ?></a>
		          			<ul class="dropdown-menu">
		          				<li><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'stock','action'=>'add'));?>" ><i class="icon-plus"></i> <?php echo __('Stock In'); ?></a></li>
		          			</ul>
		          		</li>
		          		<li class="dropdown <?php if($this->params['controller']=='quotation') echo 'active'; ?>">
		          		<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span><i class="icon-thumbs-up"></i></span><?php echo __('APPS'); ?></a>
		          			<ul class="dropdown-menu">
				                <li class="dropdown-submenu">
				                    <a tabindex="-1" href="#">Quotation</a>
				                    <ul class="dropdown-menu">
				                   	  <?php if($CompanyRole==SUPPLIER||$CompanyRole==DEALER):?>
				                      <li><a tabindex="-1" href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'quotation','action'=>'index'));?>">To Customer</a></li>
				                      <?php endif;?>
				                      <?php if($CompanyRole==DEALER||$CompanyRole==DISTRIBUTOR):?>
				                      <li><a tabindex="-1" href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'quotation','action'=>'index','self'));?>">From Supplier</a></li>
				                      <?php endif;?>
				                    </ul>
				                </li>
				                <li class="divider"></li>
				                <li class="dropdown-submenu">
				                    <a tabindex="-1" href="#">Purchase Order</a>
				                    <ul class="dropdown-menu">
				                      <?php if($CompanyRole==SUPPLIER||$CompanyRole==DEALER):?>
				                      <li><a tabindex="-1" href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'purchase_order','action'=>'index','self'));?>">From Customer</a></li>
				                      <?php endif;?>
				                      <?php if($CompanyRole==DEALER||$CompanyRole==DISTRIBUTOR):?>
				                      <li><a tabindex="-1" href="#">To Supplier</a></li>
				                      <?php endif;?>
				                    </ul>
				                </li>
		          			</ul>
		          		</li>
		          		<li class="dropdown <?php if($this->params['plugin']=='full_calendar') echo 'active'; ?>">
		          		<a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo $this->Html->url(array('plugin'=>'full_calendar','controller'=>'full_calendar','action'=>'index'));?>"><span><i class="icon-calendar"></i></span>CALENDAR</a>
		          			<ul class="dropdown-menu">
		          				<li><a href="<?php echo $this->Html->url(array('plugin'=>'full_calendar','controller'=>'events','action'=>'add'));?>" ><i class="icon-plus"></i> <?php echo __('New Event'); ?></a></li>
		          				<li><a href="<?php echo $this->Html->url(array('plugin'=>'full_calendar','controller'=>'events','action'=>'index'));?>" ><i class="icon-tasks"></i> <?php echo __('Event View'); ?></a></li>
		          				<li><a href="<?php echo $this->Html->url(array('plugin'=>'full_calendar','controller'=>'event_types','action'=>'index'));?>" ><i class="icon-sitemap"></i> <?php echo __('Event Categories'); ?></a></li>
		          				<li><a href="<?php echo $this->Html->url(array('plugin'=>'full_calendar','controller'=>'event_types','action'=>'add'));?>" ><i class="icon-plus"></i> <?php echo __('New Category'); ?></a></li>
		          			</ul>
		          		</li>
		        </ul>
			    <ul class="nav pull-right">
        			<?php if($this->Session->read('Auth.User')): ?>
		        	<li class="<?php if(($this->params['controller']=='users') and ($this->params['action']=='edit')) echo 'active'; ?>"><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'users','action'=>'edit',AuthComponent::user('id'))); ?>"><span><i class="icon-user"></i></span>Hi, <?php echo AuthComponent::user('full_name'); ?></a></li>
		        	<?php  if (AuthComponent::user('group_id')==ADMINISTRATOR || AuthComponent::user('group_id')==SUPERADMIN): ?>
		        	<li class="dropdown <?php if(($this->params['controller']=='users') and ($this->params['action']=='index')) echo 'active'; ?>">
		        		<a class="dropdown-toggle"
					       data-toggle="dropdown"
					       href="#"><span><i class="icon-cogs"></i></span>
					        <?php echo __('Admin')?>
					        <i class="icon-angle-down"></i>
					    </a>
						<ul class="dropdown-menu" >
						      <li><?php echo $this->Html->link(__('Users'),array('plugin'=>'','controller'=>'users','action'=>'index')); ?></li>
						      <?php  if (AuthComponent::user('group_id')==SUPERADMIN): ?>
						      <li><?php echo $this->Html->link(__('Companies'),array('plugin'=>'','controller'=>'company','action'=>'index')); ?></li>
						      <li><?php echo $this->Html->link(__('Settings'),array('plugin'=>'','controller'=>'options','action'=>'edit')); ?></li>
						      <?php endif;?>
						</ul>
		        	</li>
		        	<?php endif; ?>
		       		<li><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'users','action'=>'logout')); ?>"><span><i class="icon-lock"></i></span><?php echo __('Logout'); ?></a></li>
		        	<?php else: ?>
		        	<li class="<?php if($this->params['controller']=='users' && $this->params['action']=='login') echo 'active'; ?>"><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'users','action'=>'login')); ?>"><span><i class="icon-lock"></i></span><?php echo __('Login'); ?></a></li>
		        	<?php endif; ?>
		        </ul>
			</div>
		</div>
	</div>
    <div class="container main-wraper">
		<?php echo $this->Session->flash('flash',array('element'=>'alert')); ?>
		<?php echo $this->Session->flash('auth',array('element'=>'alert')); ?>
		<?php echo $this->fetch('content'); ?>
    </div> <!-- /container -->
	 <div class="footer">
      <div class="copyright">
      Copyright &copy; 2013 <?php if($copyright) echo $copyright; else echo 'Telerim'; ?>&nbsp;| Powered By <a href="http://www.telerim.com" target="_blank">Zhen Apps</a> |&nbsp;
      <div class="dropup">
		  <a class="dropdown-toggle supported-by" data-toggle="dropdown" href="#">Supported By</a>
		  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
		    <li><a href="http://www.theepochtimes.com" target="_blank">Epoch Times</a></li>
		    <li><a href="http://www.ntdtv.org" target="_blank">NTDTV</a></li>
		  </ul>
		</div>
      </div>
      </div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<?php
	echo $this->Html->script('bootstrap-transition');
	echo $this->Html->script('bootstrap-alert');
	echo $this->Html->script('bootstrap-modal');
	echo $this->Html->script('bootstrap-dropdown');
	//echo $this->Html->script('bootstrap-scrollspy');
	echo $this->Html->script('bootstrap-tab');
	echo $this->Html->script('bootstrap-tooltip');
	//echo $this->Html->script('bootstrap-popover');
	echo $this->Html->script('bootstrap-button');
	echo $this->Html->script('bootstrap-collapse');
	//echo $this->Html->script('bootstrap-carousel');
	echo $this->Html->script('bootstrap-typeahead');
	?>
	<script>
	$(document).ready(function(){
   		 $('.dropdown-toggle').dropdown();
   	//Add Hover effect to menus
   		jQuery('ul.nav li.dropdown').hover(function() {
   		  jQuery(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn();
   		}, function() {
   		  jQuery(this).find('.dropdown-menu').stop(true, true).delay(90).fadeOut();
   		});
   		
   		jQuery('.dropup').hover(function() {
   		  jQuery('div.dropup').find('.dropdown-menu').stop(true, true).delay(50).fadeIn();
   		}, function() {
   		  jQuery('div.dropup').find('.dropdown-menu').stop(true, true).delay(1900).fadeOut();
   		});
   	});
    </script>
  </body>
</html>