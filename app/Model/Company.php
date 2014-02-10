<?php
class Company extends AppModel {
	public $belongsTo = array('CompanyGroup');
			
	public $actsAs = array(
			'Search.Searchable',
			'Utils.CsvImport' => array(
					'delimiter'  => ','
			)
	);
	
	public $filterArgs = array(
			'search_name' => array('type'=>'like','field'=>array('Company.name')),
	);
	
	public function searchDefault($data = array()) {
		$filter = $data['search_all'];
		$cond = array(
				'OR' => array(
						$this->alias . '.name LIKE' => '%' . $filter . '%',
				));
		return $cond;
	}
	
// 	public $displayField = 'full_name';
//	public $hasMany = array('Deal'=>array('className'=>'Deal'));
	
// 	public $validate = array(
// 		'first_name' => array(
// 			'length' => array(
// 				'rule' => array('maxLength',40),
// 				'message' => 'Maximum length 40 Character'
// 			)
// 		),
// 		'last_name' => array(
// 			'length' => array(
// 				'rule' => array('maxLength',40),
// 				'message' => 'Maximum length 40 Character'
// 			)
// 		),
// 		'company' => array(
// 			'length' => array(
// 				'rule' => array('maxLength',40),
// 				'message' => 'Maximum length 40 Character'
// 			)
// 		),
// 		'city' => array(
// 			'length' => array(
// 				'rule' => array('maxLength',40),
// 				'message' => 'Maximum length 40 Character'
// 			)
// 		),
// 		'phone' => array(
// 			'rule' => array('numeric'),
// 			'required' => true,
// 			'message' => 'Please check phone number'
// 		),
// 		'email' => array(
// 			'rule' => 'email',
// 			'required' => true,
// 			'message' => 'Please check email'
// 		)
// 	);
}