<?php
class Stock extends AppModel {
	public $belongsTo = array('Good','Company');
			
	public $actsAs = array(
			'Search.Searchable',
			'Utils.CsvImport' => array(
					'delimiter'  => ','
			)
	);
	
	public $filterArgs = array(
			'search_name' => array('type'=>'like','field'=>array('Good.name')),
	);
	
	public function searchDefault($data = array()) {
		$filter = $data['search_all'];
		$cond = array(
				'OR' => array(
						$this->alias . '.name LIKE' => '%' . $filter . '%',
				));
		return $cond;
	}
	
	public function beforeFind($query) {
		$query['conditions'][$this->alias . '.company_id'] = CakeSession::read("Auth.User.company_id");;
		return $query;
	}
	
	public function beforeSave($options = array()) {
		$this->data[$this->alias]['company_id'] = CakeSession::read("Auth.User.company_id");
		return true;
	}
	
	function stockLevel($id){
		$this->virtualFields = array('total' => 'SUM(Stock.quantity)');
		$conditions = array(
			$this->alias . '.good_id' => $id,
			$this->alias . '.company_id'=>AuthComponent::user('company_id')
		);
		
		$record = $this->find('first',array('conditions'=>$conditions,'group'=>array($this->alias.".good_id")));
		if($record){
			return $record[$this->alias]['quantity'];
		}else{
			return 0;
		}
	}
}