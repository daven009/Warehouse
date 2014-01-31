<?php
class Contact extends AppModel {
	
	public $belongsTo = array(
			'ContactStatus' => array(
					'className' => 'ContactStatus',
					'foreignKey' => 'contact_status_id'
					),
			'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id'
					)
			);
	
	public $hasMany = 'Deal';
			
	public $actsAs = array(
			'Search.Searchable',
			'Upload.Upload' => array(
					'photo' => array(
							'fields' => array(
									'dir' => 'photo_dir'
							),
							'thumbnailSizes' => array(
									'view' => '100x120',
									'thumb' => '20x30'
							),
							'thumbnailMethod' => 'php', //GD library instead of imagick
							'thumbnailQuality' => '8'
					)
			),
			'Utils.CsvImport' => array(
					'delimiter'  => ','
			)
	);
	
	public $filterArgs = array(
			'search_name' => array('type'=>'like','field'=>array('Contact.first_name','Contact.last_name')),
			'search_city' => array('type'=>'like','field'=>'Contact.city'),
			'search_company' => array('type'=>'like','field'=>'Contact.company'),
			'search_phone' => array('type'=>'like','field'=>'Contact.phone'),
			'search_email' => array('type'=>'value','field'=>'Contact.email'),
			'search_all' => array('type'=>'query','method'=>'searchDefault')
	);
	
	public function searchDefault($data = array()) {
		$filter = $data['search_all'];
		$cond = array(
				'OR' => array(
						$this->alias . '.first_name LIKE' => '%' . $filter . '%',
						$this->alias . '.last_name LIKE' => '%' . $filter . '%',
						$this->alias . '.city LIKE' => '%' . $filter . '%',
						$this->alias . '.company LIKE' => '%' . $filter . '%'
				));
		return $cond;
	}
	
	public $virtualFields = array(
			"full_name"=>"CONCAT(Contact.first_name, ' ' ,Contact.last_name)"
			);
	
	public $displayField = 'full_name';
	//public $hasMany = array('Deal'=>array('className'=>'Deal'));
	
	public $validate = array(
		'first_name' => array(
			'length' => array(
				'rule' => array('maxLength',40),
				'message' => 'Maximum length 40 Character'
			)
		),
		'last_name' => array(
			'length' => array(
				'rule' => array('maxLength',40),
				'message' => 'Maximum length 40 Character'
			)
		),
		'company' => array(
			'length' => array(
				'rule' => array('maxLength',40),
				'message' => 'Maximum length 40 Character'
			)
		),
		'city' => array(
			'length' => array(
				'rule' => array('maxLength',40),
				'message' => 'Maximum length 40 Character'
			)
		),
		'phone' => array(
			'rule' => array('numeric'),
			'required' => true,
			'message' => 'Please check phone number'
		),
		'email' => array(
			'rule' => 'email',
			'required' => true,
			'message' => 'Please check email'
		)
	);
}