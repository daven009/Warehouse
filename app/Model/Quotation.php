<?php
class Quotation extends AppModel {
	protected $dates = array('order_date');
// 	protected $datetimes = array('start_date','end_date');
	protected $jsons = array('items');
	
	public $belongsTo = array(
			'Customer'=>array(
					'className'=>'Company',
					'foreignKey'=>'customer_id',
					),
			'Company'=>array(
					'className' => 'Company',
					'foreignKey' => 'company_id'
					)
			);
	
	public $actsAs = array('Search.Searchable');
	
	public $filterArgs = array(
			'search_status' => array('type'=>'value','field'=>array('Quotation.status')),
			'search_company_id' => array('type'=>'value','field'=>array('Quotation.company_id')),
			'search_number' => array('type'=>'like','field'=>array('Quotation.number')),
			'search_customer_id' => array('type'=>'value','field'=>array('Quotation.customer_id')),
			'search_company_name' => array('type'=>'like','field'=>array('Customer.name')),
			'search_date_from' => array('type'=>'expression','method'=>'searchDate','field'=>'Quotation.date BETWEEN ? AND ?'),
			'search_all' => array('type'=>'query','method'=>'searchDefault')
	);
	
	public function searchDefault($data = array()) {
		$filter = $data['search_all'];
		$cond = array(
				'OR' => array(
						'Customer.name LIKE' => '%' . $filter . '%',
				));
		return $cond;
	}
	
	public function searchDate($data = array()) {
		$date_from = $data['search_date_from'];
		if(!empty($data['search_date_to'])){
			$date_to = $data['search_date_to'] . ' 23:59:59';
		} else {
			$date_to = date('Y-m-d H:i:s');
		}
		$cond = array($date_from,$date_to);
		return $cond;
	}
	
	public function afterFind($results,$primary=false){
		//parent::afterFind($results,$primary);
		if(!$results) return $results;
			
		if($primary==false)
		{
			return parent::afterFind($results,$primary);
		}
		
		$result_return = array();
		
		foreach($results as $k => $result){
			if(isset($result[$this->alias])){
				$subtotal = 0;
				$items = json_decode($result[$this->alias]['items'],true);
				
				if($items!=null)
				{
					foreach($items as $row)
					{
						$subtotal = $subtotal + $row['total'];
					}
				}
					
				$result[$this->alias]['subtotal'] = $subtotal;
	
				$result_return[$k] = $result;
			}
		}
		
// 		var_dump($result_return);exit;
	
		return parent::afterFind($result_return,$primary);
	}
}