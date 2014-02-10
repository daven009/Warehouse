<?php
class Good extends AppModel {
	public $actsAs = array('Search.Searchable');
	
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
}