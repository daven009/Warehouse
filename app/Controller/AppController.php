<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	private $_CompanyRole = false;
	private $_CompanyName = false;
	
	public $theme = 'Default';
	
	public $components = array(
			'Session',
			'Email',
			'Auth' => array(
					'loginRedirect' => array('controller' => 'dashboards', 'action' => 'index'),
					'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
					'authorize' => array(
							
							)
			),
			'Search.Prg',
			'Cookie'
	);
	
	public $helpers = array(
			'Session',
			'Time',
			'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
			'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
			'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
			'Status'
			
    );
	
	public $uses = array('Option','User');
	
	public function beforeFilter(){
		if ($this->Session->check('Config.language')) {
			Configure::write('Config.language', $this->Session->read('Config.language'));
		}
		
		$this->Auth->authError = __('You need to login!!');
		// set cookie options
		$this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!SL#$%)asGb$@11~_+!@#HKis~#^';
		$this->Cookie->httpOnly = true;
		
		if (!$this->Auth->loggedIn() && $this->Cookie->read('remember_me_cookie')) {
			$cookie = $this->Cookie->read('remember_me_cookie');
				
			$user = $this->User->find('first', array(
					'conditions' => array(
							'User.username' => $cookie['username'],
							'User.password' => $cookie['password']
					)
			));
		
			if ($user && !$this->Auth->login($user)) {
				$this->redirect('/users/logout'); // destroy session & cookie
			}
		}
		
		$option_title = $this->Option->find('first',array('conditions'=>array('name'=>'title')));
		if(!empty($option_title)){
			$this->set('title',$option_title['Option']['value']);
		}
		else {
			$this->set('title','');
		}
		
		$option_currency = $this->Option->find('first',array('conditions'=>array('name'=>'currency')));
		if(!empty($option_currency)){
			$this->set('currency',$option_currency['Option']['value']);
		}
		else {
			$this->set('currency','$');
		}
		
		$option_copyright = $this->Option->find('first',array('conditions'=>array('name'=>'copyright')));
		if(!empty($option_copyright)){
			$this->set('copyright',$option_copyright['Option']['value']);
		}
		else {
			$this->set('copyright','');
		}
		$temp_logo = $option_copyright['Option']['logo_dir'] . "/l_" . $option_copyright['Option']['logo'];
		$this->set('logo',$temp_logo);
		/*
		$option_logo = $this->Option->find('first',array('conditions'=>array('name'=>'logo')));
		if(!empty($option_logo)){
			$this->set('logo',$option_logo['Option']['value']);
		}
		else {
			$this->set('logo','');
		}*/
		
		if($this->Auth->loggedIn()){
			$this->loadModel('Company');
			$company_id = $this->Auth->user('company_id');
			$company = $this->Company->find('first',array('recursive'=>-1,'conditions'=>array('Company.id'=>$company_id)));
			$this->_CompanyName = $company['Company']['name'];
			$this->_CompanyRole = $company['Company']['company_group_id'];
		}
		$this->set('CompanyName',$this->_CompanyName);
		$this->set('CompanyRole',$this->_CompanyRole);
	}
	
	public function beforeRender()
	{
		// only compile it on development mode
		if (Configure::read('debug') > 0)
		{
			// import the file to application
			App::import('Vendor', 'lessc');
	
			// set the LESS file location
			$less = ROOT . DS . APP_DIR . DS .'View'.DS.'Themed'.DS.'Default'.DS. 'webroot' . DS . 'less' . DS . 'styleless.less';
	
			// set the CSS file to be written
			$css = ROOT . DS . APP_DIR . DS .'View'.DS.'Themed'.DS.'Default'.DS. 'webroot' . DS . 'css' . DS . 'styleless.css';
	
			// compile the file
			lessc::ccompile($less, $css);
		}
		
		//$this->Number->defaultCurrency('USD');
		
		parent::beforeRender();
	}
	
	public function isAuthorized($user) {
		// Admin can access every action
		/*if (isset($user['role']) && $user['role'] === 'admin') {
			return true;
		}*/
	
		// Default deny
		return true;// allow all for now
	}
	
	function customer_list(){
		$this->loadModel('Company');
		switch ($this->_CompanyRole){
			case SUPPLIER:
				$company_list = $this->Company->find('list',array('conditions'=>array('Company.company_group_id'=>DEALER)));
				break;
			case DEALER:
				$company_list = $this->Company->find('list',array('conditions'=>array('Company.company_group_id'=>DISTRIBUTOR)));
				break;
			default:
				return false;
		}
		
		return $company_list;
	}
	
	function supplier_list(){
		$this->loadModel('Company');
		switch ($this->_CompanyRole){
			case DISTRIBUTOR:
				$company_list = $this->Company->find('list',array('conditions'=>array('Company.company_group_id'=>DEALER)));
				break;
			case DEALER:
				$company_list = $this->Company->find('list',array('conditions'=>array('Company.company_group_id'=>SUPPLIER)));
				break;
			default:
				return false;
		}
		
		return $company_list;
	}
		
}