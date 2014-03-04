<?php
class DeliveryOrderController extends AppController {
	public $uses = array('DeliveryOrder','Good','DeliveryOrder');
	
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
				'conditions' => $this->DeliveryOrder->parseCriteria($this->passedArgs),
				'limit' => 6,
				'order' => array(
						'DeliveryOrder.id' => 'desc'
				)
		);
// 		var_dump($this->passedArgs);
// 		var_dump($this->Paginate());exit;
		$this->set('delivery_orders', $this->Paginate());
	}
	
	public function view($id = null){
		$this->DeliveryOrder->id = $id;
		if(!$this->DeliveryOrder->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		
		
		$this->set('delivery_order',$this->DeliveryOrder->read());
		$this->set('goods',$this->Good->find('list'));
		
	}
	
	public function add(){
		$suppliers = $this->supplier_list();
		$this->set(compact('suppliers'));
		$goods = $this->Good->find('list');
		$this->set(compact('goods'));
		if(!empty($this->request->data)){
			$this->request->data['DeliveryOrder']['company_id'] = $this->Auth->user('company_id');
			$amount = 0;
			$records = array();
			foreach ($this->request->data['DeliveryOrder']['items'] as $item){
				$amount += $item['total'];
				$records[] = $item;
			}
			$this->request->data['DeliveryOrder']['items'] = $records;
			$this->request->data['DeliveryOrder']['amount'] = $amount;
// 			var_dump($this->request->data);exit;
			
			
			$this->DeliveryOrder->create();
			if($this->DeliveryOrder->save($this->request->data)){
				$this->Session->setFlash(__('New purchase order added'),'alert'); //print_r($this->request->data); exit;
				$this->redirect(array('action'=>'view',$this->DeliveryOrder->id));
			}
			else
			{
				$this->Session->setFlash(__('Unable to add'),'alert', array('class'=>'alert-error'));
			}
		}
	}
	
	public function edit($id = null){
		$this->view = 'add';
		$this->DeliveryOrder->id = $id;
		if(!$this->DeliveryOrder->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		$extra_msg = '';
		if(!empty($this->request->data)){
			$amount = 0;
			$records = array();
			foreach ($this->request->data['DeliveryOrder']['items'] as $item){
				$amount += $item['total'];
				$records[] = $item;
			}
			$this->request->data['DeliveryOrder']['items'] = $records;
			$this->request->data['DeliveryOrder']['amount'] = $amount;
			
			if($this->DeliveryOrder->save($this->request->data)){
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
			$this->data = $this->DeliveryOrder->read();
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
		
		$quotation = $this->DeliveryOrder->find('first',array('conditions'=>array('DeliveryOrder.id'=>$id,'DeliveryOrder.company_id'=>$this->Auth->user('company_id'))));
		
		if($quotation){
			$this->DeliveryOrder->id = $id;
			$record = $this->DeliveryOrder->saveField('status',PENDING);
			if($record){
				$this->Session->setFlash(__('DeliveryOrder approved'),'alert');
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
		
		$delivery_order = $this->DeliveryOrder->find('first',array('conditions'=>array('DeliveryOrder.id'=>$id,'DeliveryOrder.company_id'=>$this->Auth->user('company_id'))));
		
		if($delivery_order){
			$this->loadModel('Stock');
			foreach ($delivery_order['DeliveryOrder']['items'] as $item){
				$stock_level = $this->Stock->stockLevel($item['id']);
				if($item['quantity']>$stock_level){
					$this->Session->setFlash(__('Insufficient stock level'),'alert', array('class'=>'alert-error'));
					$this->redirect($this->referer());
				}else{
					$data[] = array('good_id' => $item['id'],'company_id'=>$this->Auth->user('company_id'),'quantity'=>-$item['quantity'],'model'=>'DeliveryOrder','foreign_id'=>$id);
				}
			}
			$this->Stock->savemany($data);
			$this->DeliveryOrder->id = $id;
			if($this->DeliveryOrder->saveField('status',DELIVERING)){
				$this->Session->setFlash(__('Delivery order items been stocked out'),'alert');
			}
		}else{
			$this->Session->setFlash(__('Unable to retrieve'),'alert', array('class'=>'alert-error'));
		}
		
		$this->redirect($this->referer());
	}
	
	public function receive($id){
		if(is_null($id)){
			$this->Session->setFlash(__('Unable to retrieve'),'alert', array('class'=>'alert-error'));
			$this->redirect($this->referer());
		}
		$this->loadModel('DeliveryOrder');
		
		$delivery_order = $this->DeliveryOrder->find('first',array('conditions'=>array('DeliveryOrder.id'=>$id,'DeliveryOrder.customer_id'=>$this->Auth->user('company_id'))));
	
		if($delivery_order){
			$this->loadModel('Stock');
			foreach ($delivery_order['DeliveryOrder']['items'] as $item){
				$data[] = array('good_id' => $item['id'],'company_id'=>$this->Auth->user('company_id'),'quantity'=>$item['quantity'],'model'=>'DeliveryOrder','foreign_id'=>$id);
			}
			$this->Stock->savemany($data);
			$this->DeliveryOrder->id = $id;
			if($this->DeliveryOrder->saveField('status',DELIVERED)){
				$this->Session->setFlash(__('Delivery order items been stocked in'),'alert');
			}
		}else{
			$this->Session->setFlash(__('Unable to retrieve'),'alert', array('class'=>'alert-error'));
		}
		
		$this->redirect($this->referer());
	}
}