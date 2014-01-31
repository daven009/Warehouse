<?php
class OptionsController extends AppController {
	
	public function index(){
		$this->set('options',$this->Option->find('all'));
	}
	
	public function edit(){
		if($this->request->is('post')){
			$extra_msg = '';
			$option_title = $this->Option->findByName('title');
			if(!empty($option_title)){
				$this->Option->id = $option_title['Option']['id'];
				$option_data['Option']['name'] = 'title';
				//$option_data['Option']['logo'] = $this->request->data['Option']['logo'];
				//$option_data['Option']['logo_dir'] = $this->request->data['Option']['logo_dir'];
				//$this->Option->saveField('value',$this->request->data['Option']['title']);
				$this->Option->save($option_data);
			}
			else {
				$option_data['Option']['name'] = 'title';
				$option_data['Option']['value'] = $this->request->data['Option']['title'];
				//$option_data['Option']['logo'] = $this->request->data['Option']['logo'];
				//$option_data['Option']['logo_dir'] = $this->request->data['Option']['logo_dir'];
				$this->Option->create();
				$this->Option->save($option_data);
			}
			
			$option_title = $this->Option->findByName('email');
			if(!empty($option_title)){
				$this->Option->id = $option_title['Option']['id'];
				$this->Option->saveField('value',$this->request->data['Option']['email']);
					
			}
			else {
				$option_data['Option']['name'] = 'email';
				$option_data['Option']['value'] = $this->request->data['Option']['email'];
				$this->Option->create();
				$this->Option->save($option_data);
			}
				
			$option_title = $this->Option->findByName('email_title');
			if(!empty($option_title)){
				$this->Option->id = $option_title['Option']['id'];
				$this->Option->saveField('value',$this->request->data['Option']['email_title']);
					
			}
			else {
				$option_data['Option']['name'] = 'email_title';
				$option_data['Option']['value'] = $this->request->data['Option']['email_title'];
				$this->Option->create();
				$this->Option->save($option_data);
			}
			
			$option_title = $this->Option->findByName('currency');
			if(!empty($option_title)){
				$this->Option->id = $option_title['Option']['id'];
				$this->Option->saveField('value',$this->request->data['Option']['currency']);
					
			}
			else {
				$option_data['Option']['name'] = 'currency';
				$option_data['Option']['value'] = $this->request->data['Option']['currency'];
				$this->Option->create();
				$this->Option->save($option_data);
			}
			
		// logo saving routine has to be in last
			$option_copyright = $this->Option->findByName('copyright');
			if(!empty($option_copyright)){
				$this->Option->id = $option_copyright['Option']['id'];
				$option_data['Option']['name'] = 'copyright';
				$option_data['Option']['logo'] = $this->request->data['Option']['logo'];
       			$option_data['Option']['logo_dir'] = $this->request->data['Option']['logo_dir'];
      			$option_data['Option']['value'] = $this->request->data['Option']['copyright'];
       			$this->Option->save($option_data);
       			//$this->Option->saveField('value',$this->request->data['Option']['copyright']); 
				
				
			}
			else {
				$option_data['Option']['name'] = 'copyright';
				$option_data['Option']['logo'] = $this->request->data['Option']['logo'];
				$option_data['Option']['logo_dir'] = $this->request->data['Option']['logo_dir'];
				$option_data['Option']['value'] = $this->request->data['Option']['copyright'];
				$this->Option->create();
				$this->Option->save($option_data);
			}
			
			
			$this->Session->setFlash(__('Settings saved. '),'alert',array('class'=>'alart-success'));
		}
		$option_title = $this->Option->find('first',array('conditions'=>array('name'=>'title')));
		if(!empty($option_title)){
			$this->request->data['Option']['title'] = $option_title['Option']['value'];
		}
		else {
			$this->request->data['Option']['title'];
		}
		
		$option_email = $this->Option->find('first',array('conditions'=>array('name'=>'email')));
		if(!empty($option_email)){
			$this->request->data['Option']['email'] = $option_email['Option']['value'];
		}
		else {
			$this->request->data['Option']['email'] = 'admin@zhen-crm.com';
		}
		
		$option_email_title = $this->Option->find('first',array('conditions'=>array('name'=>'email_title')));
		if(!empty($option_email_title)){
			$this->request->data['Option']['email_title'] = $option_email_title['Option']['value'];
		}
		else {
			$this->request->data['Option']['email_title'] = 'Zhen-CRM';
		}
		
		$option_currency = $this->Option->find('first',array('conditions'=>array('name'=>'currency')));
		if(!empty($option_currency)){
			$this->request->data['Option']['currency'] = $option_currency['Option']['value'];
		}
		else {
			$this->request->data['Option']['currency'] = '$';
		}
		
		$option_copyright = $this->Option->find('first',array('conditions'=>array('name'=>'copyright')));
		if(!empty($option_copyright)){
			$this->request->data['Option']['copyright'] = $option_copyright['Option']['value'];
		}
		else {
			$this->request->data['Option']['copyright'] = '';
		}
	}
}