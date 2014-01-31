<div>
<?php if($success): ?>
<?php echo $this->Html->link(__('Take me to Login page'),array('controller'=>'users','action'=>'login')); ?>
<?php else:?>
<?php echo $this->Html->link(__('Reset password again'),array('controller'=>'users','action'=>'forgot')); ?>
<?php endif;?>
</div>