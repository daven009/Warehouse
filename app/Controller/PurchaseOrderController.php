<?php
class PurchaseOrderController extends AppController {
	public $uses = array('PurchaseOrder','Good','PurchaseOrder');
	
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
				$this->passedArgs['search_supplier_id'] = $this->Auth->user('company_id');
				break;
		}
		
		$this->Prg->commonProcess();
		//$this->Contact->recursive = 0;
		
		$this->paginate = array(
				'conditions' => $this->PurchaseOrder->parseCriteria($this->passedArgs),
				'limit' => 6,
				'order' => array(
						'PurchaseOrder.id' => 'desc'
				)
		);
// 		var_dump($this->passedArgs);
// 		var_dump($this->Paginate());exit;
		$this->set('quotations', $this->Paginate());
	}
	
	public function view($id = null){
		$this->PurchaseOrder->id = $id;
		if(!$this->PurchaseOrder->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		
		
		$this->set('purchase',$this->PurchaseOrder->read());
		$this->set('goods',$this->Good->find('list'));
		
	}
	
	public function add(){
		$suppliers = $this->supplier_list();
		$this->set(compact('suppliers'));
		$goods = $this->Good->find('list');
		$this->set(compact('goods'));
		if(!empty($this->request->data)){
			$this->request->data['PurchaseOrder']['company_id'] = $this->Auth->user('company_id');
			$amount = 0;
			$records = array();
			foreach ($this->request->data['PurchaseOrder']['items'] as $item){
				$amount += $item['total'];
				$records[] = $item;
			}
			$this->request->data['PurchaseOrder']['items'] = $records;
			$this->request->data['PurchaseOrder']['amount'] = $amount;
// 			var_dump($this->request->data);exit;
			
			
			$this->PurchaseOrder->create();
			if($this->PurchaseOrder->save($this->request->data)){
				$this->Session->setFlash(__('New purchase order added'),'alert'); //print_r($this->request->data); exit;
				$this->redirect(array('action'=>'view',$this->PurchaseOrder->id));
			}
			else
			{
				$this->Session->setFlash(__('Unable to add'),'alert', array('class'=>'alert-error'));
			}
		}
	}
	
	public function edit($id = null){
		$this->view = 'add';
		$this->PurchaseOrder->id = $id;
		if(!$this->PurchaseOrder->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		$extra_msg = '';
		if(!empty($this->request->data)){
			$amount = 0;
			$records = array();
			foreach ($this->request->data['PurchaseOrder']['items'] as $item){
				$amount += $item['total'];
				$records[] = $item;
			}
			$this->request->data['PurchaseOrder']['items'] = $records;
			$this->request->data['PurchaseOrder']['amount'] = $amount;
			
			if($this->PurchaseOrder->save($this->request->data)){
				$this->Session->setFlash(__('Purchase order data saved'),'alert');
				$this->redirect(array('action'=>'view',$id));
			}
			else
			{
				$this->Session->setFlash(__('Unable to save changes'),'alert', array('class'=>'alert-error'));
			}
		}
		else
		{
			$suppliers = $this->supplier_list();
			$this->set(compact('suppliers'));
			$goods = $this->Good->find('list');
			$this->set(compact('goods'));
			$this->data = $this->PurchaseOrder->read();
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
		
		$quotation = $this->PurchaseOrder->find('first',array('conditions'=>array('PurchaseOrder.id'=>$id,'PurchaseOrder.company_id'=>$this->Auth->user('company_id'))));
		
		if($quotation){
			$this->PurchaseOrder->id = $id;
			$record = $this->PurchaseOrder->saveField('status',PENDING);
			if($record){
				$this->Session->setFlash(__('PurchaseOrder approved'),'alert');
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
		$this->loadModel('DeliveryOrder');
		
		$purchase_order = $this->PurchaseOrder->find('first',array('conditions'=>array('PurchaseOrder.id'=>$id,'PurchaseOrder.supplier_id'=>$this->Auth->user('company_id'))));
		
		if($purchase_order){
			$order = 0;
			do {
				$order+=1;
				$order_number = 'Q'.date('y').date('m').sprintf('%04d',$order);
				$exist = $this->DeliveryOrder->find('first',array('recursive'=>-1,'conditions'=>array('DeliveryOrder.number'=>$order_number)));
			} while ($exist);
				
			$this->request->data['DeliveryOrder']['number'] = $order_number;
			$this->request->data['DeliveryOrder']['purchase_order_id'] = $id;
			$this->request->data['DeliveryOrder']['customer_id'] = $purchase_order['PurchaseOrder']['company_id'];
			$this->request->data['DeliveryOrder']['company_id'] = $purchase_order['PurchaseOrder']['supplier_id'];
			$this->request->data['DeliveryOrder']['items'] = $purchase_order['PurchaseOrder']['items'];
			$this->request->data['DeliveryOrder']['order_date'] = $purchase_order['PurchaseOrder']['order_date'];
			$this->request->data['DeliveryOrder']['amount'] = $purchase_order['PurchaseOrder']['amount'];
			$this->DeliveryOrder->create();
			if($this->DeliveryOrder->save($this->request->data)){
				$this->PurchaseOrder->id = $id;
				$this->PurchaseOrder->saveField('status',COMPLETED);
				$this->Session->setFlash(__('Purchase order completed, DO has been issued'),'alert');
			}
		}else{
			$this->Session->setFlash(__('Unable to retrieve'),'alert', array('class'=>'alert-error'));
		}
		
		$this->redirect($this->referer());
	}
}