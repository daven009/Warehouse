<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	protected $dates = array();
	protected $datetimes = array();
	protected $jsons = array();
	
	public function beforeSave($options = array()) {
// 		foreach($this->dates as $date){
// 			if(isset($this->data[$this->alias][$date]) && !empty($this->data[$this->alias][$date])){
// 				$testdate = DateTime::createFromFormat(VIEWDATEFORMATPHP, $this->data[$this->alias][$date]);
	
// 				if($testdate){
// 					$this->data[$this->alias][$date] = $testdate->format(DBDATEFORMATPHP);
// 				}else{
// 					unset($this->data[$this->alias][$date]);
// 				}
// 			}
// 		}
			
// 		foreach($this->datetimes as $datetime){
// 			if(isset($this->data[$this->alias][$datetime]) && !empty($this->data[$this->alias][$datetime])){
// 				$testdate = DateTime::createFromFormat(VIEWDATETIMEFORMATPHP, $this->data[$this->alias][$datetime]);
// 				if($testdate){
// 					$this->data[$this->alias][$datetime] = $testdate->format(DBDATETIMEFORMATPHP);
// 				}else{
// 					unset($this->data[$this->alias][$datetime]);
// 				}
// 			}
// 		}

		foreach($this->jsons as $json){
			if(isset($this->data[$this->alias][$json]) && !empty($this->data[$this->alias][$json])){
				$this->data[$this->alias][$json] = json_encode($this->data[$this->alias][$json]);
			}
		}
	
		return parent::beforeSave($options);
	}
	
	public function afterFind($results,$primary=false){
		//parent::afterFind($results,$primary);
		if(!$results) return $results;
		$result_return = array();
			
		foreach($results as $k => $result){
	
			if(isset($result[$this->alias])){
// 				foreach($this->dates as $date){
// 					if(isset($result[$this->alias][$date]) && !empty($result[$this->alias][$date])){
// 						$testdate = DateTime::createFromFormat(DBDATEFORMATPHP, $result[$this->alias][$date]);
// 						$result[$this->alias][$date] = $testdate->format(VIEWDATEFORMATPHP);
// 					}
// 				}
	
// 				foreach($this->datetimes as $datetime){
// 					if(isset($result[$this->alias][$datetime]) && !empty($result[$this->alias][$datetime])){
// 						$testdate = DateTime::createFromFormat(DBDATETIMEFORMATPHP, $result[$this->alias][$datetime]);
// 						$result[$this->alias][$datetime] = $testdate->format(VIEWDATETIMEFORMATPHP);
// 					}
// 				}
					
				foreach($this->jsons as $json){
					if(isset($result[$this->alias][$json]) && !empty($result[$this->alias][$json])){
						$result[$this->alias][$json] = json_decode($result[$this->alias][$json],true);
					}
				}
			}
				
			$this->clean($result);
			$result_return[$k] = $result;
		}
	
		return parent::afterFind($result_return,$primary);
	}
	
	private function clean(&$data){
	
		if(empty($data)) return;
		// 		if(empty($data)) return $data;
	
		if (is_array($data)) {
			foreach ($data as $key => $val) {
				$this->clean($data[$key]);
				// 				$data[$key] = $this->clean($val);
			}
			return;
			// 			return $data;
		}else{
				
			$data = strip_tags($data,'<style><iframe><p><blockquote><pre><h1><h2><h3><h4><h5><h6><b><i><strike><div><span><ul><ol><li><table><tbody><tr><td><thead><th><a><hr><br><em><del><strong><img>');
			// 			var_dump($data);
			return;
			// 			return $data;
		}
	}
}
