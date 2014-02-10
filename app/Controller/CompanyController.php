<?php
class CompanyController extends AppController {
	public $uses = array('Company','CompanyGroup');
	
	public $components = array('RequestHandler');
	
	public function index($csvFile = null){
		$searched = false;
		if ($this->passedArgs) {
			$args = $this->passedArgs;
			if(isset($args['search_name'])){
				$searched = true;
			}
		}
		$this->set('searched',$searched);
		
		$this->Prg->commonProcess();
		//$this->Contact->recursive = 0;
		if ($csvFile) {
			$this->paginate = array(
					'conditions' => $this->Company->parseCriteria($this->passedArgs),
					'order' => array(
							'Company.id' => 'asc'
					)
			);
			$this->request->params['named']['page'] = null;
		} else {
			$this->paginate = array(
					'conditions' => $this->Company->parseCriteria($this->passedArgs),
					'limit' => 6,
					'order' => array(
							'Company.id' => 'asc'
					)
			);
		}
		$this->set('companies', $this->Paginate());
	}
	
	public function import() {
		if ( $this->request->is('POST') ) {
			$records_count = $this->Contact->find( 'count' );
			try {
				$allData = $this->Contact->importCSVdata($this->request->data['Contact']['CsvFile']['tmp_name']);
			} catch (Exception $e) {
				$import_errors = $this->Contact->getImportErrors();
				$this->set( 'import_errors', $import_errors );
				$this->Session->setFlash( __('Error Importing') . ' ' . $this->request->data['Contact']['CsvFile']['name'] . ', ' . __('column name mismatch.')  );
				$this->redirect( array('action'=>'import') );
			}
			//test 
			$dt = array(
					'Contact'=>array('first_name'=>'imp_test4','contact_status_id'=>5)
					
			); 
			
			if (!empty($allData)){
				$result = $this->Contact->saveMany($allData,array('validate' => false,'atomic' => false));

			}
			
			/*
			foreach ($allData as $theData) {
				if($theData['Contact']['contact_status_id']){
					$this->Contact->create();
					$this->Contact->save($dt);
				}
			//print_r($theData);
			
			}
			*/
			$new_records_count = $this->Contact->find( 'count' ) - $records_count;
			if ($result === true) {
				$this->Session->setFlash(__('Successfully imported') . ' ' . $new_records_count .  ' records from ' . $this->request->data['Contact']['CsvFile']['name'] );
			}
			else if ($result === false) {
				$this->Session->setFlash(__('Successfully imported') . ' ' . $new_records_count .  ' records from ' . $this->request->data['Contact']['CsvFile']['name'] );
			}
			else {
				$ir = 1;
				$rows = '';
				foreach($result as $r){
					if ($r['Contact'] == false) $rows .= ' ,' .$ir;
					$ir++;
				}
				$this->Session->setFlash(__('Successfully imported') . ' ' . $new_records_count .  ' records from ' . $this->request->data['Contact']['CsvFile']['name'] ) . 
				"\nRows" . $rows . __(' Could not be saved.');
			}
			$this->redirect( array('action'=>'index') );
		}
	}
	
	public function view($id = null){
		$this->Contact->id = $id;
		if(!$this->Contact->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		$this->set('contact',$this->Contact->read());
		$deals = $this->Deal->find('all',array(
				'limit'=>5,
				'conditions'=>array(
						'Deal.contact_id'=>$id
						)
				)
		);
		foreach ($deals as $key => $values){
				
			$deals[$key]['children'] = $this->User->find('first',array(
					'fields' => array('User.full_name'),
					'conditions'=>array('User.id'=>$deals[$key]['Contact']['user_id']),
					'contain'=>false));
		}
		$this->set('deals', $deals);
		
		$this->Event->bindModel(array('hasOne' => array('ContactsEvent')), false);
		
		//$this->Event->Behaviors->load('Containable');
		
		$this->set('events',$this->Event->find('all',array(
				'conditions'=>array('ContactsEvent.contact_id'=>$id),
				'limit'=>5
				)
		)
		);
	}
	
	public function add(){
		$companygroups = $this->CompanyGroup->find('list');
		$this->set(compact('companygroups'));
		
		if($this->request->is('post')){
			$this->Company->create();
			if($this->Company->save($this->request->data)){
				$this->Session->setFlash(__('New company added'),'alert'); //print_r($this->request->data); exit;
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('Unable to add'),'alert', array('class'=>'alert-error'));
			}
		}
	}
	
	public function edit($id = null){
		$this->Company->id = $id;
		if(!$this->Company->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		$extra_msg = '';
		if($this->request->is('post')){
			if($this->Company->save($this->request->data)){
				$this->Session->setFlash(__('Company data saved'),'alert');
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('Unable to save changes'),'alert', array('class'=>'alert-error'));
			}
		}
		else
		{
			$companygroups = $this->CompanyGroup->find('list');
			$this->set(compact('companygroups'));
			$this->request->data = $this->Company->read();
		}
	}
	
	public function delete($id = null){
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Company->id = $this->request->data['id']; //--
		if(!$this->Company->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		
		if($this->Company->delete($id)){
			$this->Session->setFlash(__('Company deleted'),'alert');
			$this->redirect(array('action'=>'index'));
		}
		else
		{
			$this->Session->setFlash(__('Unable to delete'),'alert', array('class'=>'alert-error'));
			$this->redirect(array('action'=>'index'));
		}
	}
}