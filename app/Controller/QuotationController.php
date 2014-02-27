<?php
class QuotationController extends AppController {
	public $uses = array('Quotation','Good','PurchaseOrder');
	
	public $components = array('RequestHandler');
	
	public function index($type="other"){
		$searched = false;
		if ($this->passedArgs) {
			$args = $this->passedArgs;
			if(isset($args['search_number'])||isset($args['search_company_name'])||isset($args['search_date_from'])||isset($args['search_date_to'])){
				$searched = true;
			}
		}
		$this->set('searched',$searched);
		
// 		if(!is_null($company_id) && $this->Auth->user('group_id')==SUPERADMIN){
// 			$this->loadModel('Company');
// 			$this->passedArgs['search_company_id'] = $company_id;
// 			$company = $this->Company->find('first',array('conditions'=>array('Company.id'=>$company_id)));
// 			$this->set(compact('company'));
// 			$back = true;
// 		}else{
// 			$this->passedArgs['search_company_id'] = $this->Auth->user('company_id');
// 		}
		switch ($type){
			case "other":
				$this->passedArgs['search_company_id'] = $this->Auth->user('company_id');
				break;
			case "self":
				$this->passedArgs['search_customer_id'] = $this->Auth->user('company_id');
				break;
		}
		
		$this->Prg->commonProcess();
		//$this->Contact->recursive = 0;
		
		$this->paginate = array(
				'conditions' => $this->Quotation->parseCriteria($this->passedArgs),
				'limit' => 6,
				'order' => array(
						'Quotation.id' => 'desc'
				)
		);
// 		var_dump($this->passedArgs);
// 		var_dump($this->Paginate());exit;
		$this->set('quotations', $this->Paginate());
	}
	
	public function view($id = null){
		$this->Quotation->id = $id;
		if(!$this->Quotation->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		
		
		$this->set('quotation',$this->Quotation->read());
		$this->set('goods',$this->Good->find('list'));
		
	}
	
	public function add(){
		$customers = $this->customer_list();
		$this->set(compact('customers'));
		$goods = $this->Good->find('list');
		$this->set(compact('goods'));
		if(!empty($this->request->data)){
			$date = $this->request->data['Quotation']['order_date'];
			$year = DateTime::createFromFormat('d/m/Y', $date)->format('y');
			$month = DateTime::createFromFormat('d/m/Y', $date)->format('m');
			//-------------------------------------------
			$conditions = array(
					'Quotation.order_date >='=>DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-'."01"),
					'Quotation.order_date <='=>DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-t')
			);
			$order = $this->Quotation->find('count',array('conditions'=>$conditions));
			
			do {
				$order+=1;
				$order_number = 'Q'.$year.$month.sprintf('%04d',$order);
				$exist = $this->Quotation->find('first',array('recursive'=>-1,'conditions'=>array('Quotation.number'=>$order_number)));
			} while ($exist);
			
			$this->request->data['Quotation']['number'] = $order_number;
			$this->request->data['Quotation']['company_id'] = $this->Auth->user('company_id');
			//-------------------------------------------
			$amount = 0;
			$records = array();
			foreach ($this->request->data['Quotation']['items'] as $item){
				$amount += $item['total'];
				$records[] = $item;
			}
			$this->request->data['Quotation']['items'] = $records;
			$this->request->data['Quotation']['amount'] = $amount;
// 			var_dump($this->request->data);exit;
			
			
			$this->Quotation->create();
			if($this->Quotation->save($this->request->data)){
				$this->Session->setFlash(__('New quotation added'),'alert'); //print_r($this->request->data); exit;
				$this->redirect(array('action'=>'view',$this->Quotation->id));
			}
			else
			{
				$this->Session->setFlash(__('Unable to add'),'alert', array('class'=>'alert-error'));
			}
		}
	}
	
	public function edit($id = null){
		$this->view = 'add';
		$this->Quotation->id = $id;
		if(!$this->Quotation->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		$extra_msg = '';
		if(!empty($this->request->data)){
			$amount = 0;
			$records = array();
			foreach ($this->request->data['Quotation']['items'] as $item){
				$amount += $item['total'];
				$records[] = $item;
			}
			$this->request->data['Quotation']['items'] = $records;
			$this->request->data['Quotation']['amount'] = $amount;
			
			if($this->Quotation->save($this->request->data)){
				$this->Session->setFlash(__('Quotation data saved'),'alert');
				$this->redirect(array('action'=>'view',$id));
			}
			else
			{
				$this->Session->setFlash(__('Unable to save changes'),'alert', array('class'=>'alert-error'));
			}
		}
		else
		{
			$customers = $this->customer_list();
			$this->set(compact('customers'));
			$goods = $this->Good->find('list');
			$this->set(compact('goods'));
			$this->data = $this->Quotation->read();
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
	
	public function approve($id=NULL){
		if(is_null($id)){
			$this->Session->setFlash(__('Unable to retrieve'),'alert', array('class'=>'alert-error'));
			$this->redirect($this->referer());
		}
		
		$quotation = $this->Quotation->find('first',array('conditions'=>array('Quotation.id'=>$id,'Quotation.company_id'=>$this->Auth->user('company_id'))));
		
		if($quotation){
			$this->Quotation->id = $id;
			$record = $this->Quotation->saveField('status',PENDING);
			if($record){
				$this->Session->setFlash(__('Quotation approved'),'alert');
			}else{
				$this->Session->setFlash(__('Unable to approved'),'alert', array('class'=>'alert-error'));
			}
		}else{
			$this->Session->setFlash(__('Unable to retrieve'),'alert', array('class'=>'alert-error'));
		}
		
		$this->redirect($this->referer());
	}
	
	public function confirm($id){
		if(is_null($id)){
			$this->Session->setFlash(__('Unable to retrieve'),'alert', array('class'=>'alert-error'));
			$this->redirect($this->referer());
		}
		
		$quotation = $this->Quotation->find('first',array('conditions'=>array('Quotation.id'=>$id,'Quotation.customer_id'=>$this->Auth->user('company_id'))));
		
		if($quotation){
			$number = $this->request->data['PurchaseOrder']['number'];
			if($number==""){
				$order = 0;
				do {
					$order+=1;
					$order_number = 'Q'.date('y').date('m').sprintf('%04d',$order);
					$exist = $this->PurchaseOrder->find('first',array('recursive'=>-1,'conditions'=>array('PurchaseOrder.number'=>$order_number)));
				} while ($exist);
					
				$this->request->data['PurchaseOrder']['number'] = $order_number;
			}
			$this->request->data['PurchaseOrder']['quotation_id'] = $id;
			$this->request->data['PurchaseOrder']['supplier_id'] = $quotation['Quotation']['company_id'];
			$this->request->data['PurchaseOrder']['company_id'] = $quotation['Quotation']['customer_id'];
			$this->request->data['PurchaseOrder']['items'] = $quotation['Quotation']['items'];
			$this->request->data['PurchaseOrder']['order_date'] = $quotation['Quotation']['order_date'];
			$this->request->data['PurchaseOrder']['amount'] = $quotation['Quotation']['amount'];
			$this->PurchaseOrder->create();
			if($this->PurchaseOrder->save($this->request->data)){
				$this->Quotation->id = $id;
				$this->Quotation->saveField('status',ACCEPTED);
				$this->Session->setFlash(__('Quotation confirmed, PO has been issued'),'alert');
			}
		}else{
			$this->Session->setFlash(__('Unable to retrieve'),'alert', array('class'=>'alert-error'));
		}
		
		$this->redirect($this->referer());
	}
}