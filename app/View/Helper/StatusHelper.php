<?php
App::uses('AppHelper', 'View/Helper');
class StatusHelper extends AppHelper{
	public $helpers = array('Html');
	
	public function format($status=NULL){
		switch($status){
			case PENDING:
				return "<strong class='red'>Pending";
			case PARTIAL:
				return "<strong class='yellow'>Partial";
			case COMPLETED:
				return "<strong class='green'>Completed";
			case DELIVERED:
				return "<strong class='blue'>Delivered";
			case PENDINGADMIN:
				return "<strong class='purple'>Pending Approval";
			default:
				return "<strong class='purple'>Pending Approval";
		}
	}
}

