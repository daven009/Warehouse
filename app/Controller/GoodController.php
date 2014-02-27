<?php
class GoodController extends AppController {
	public $uses = array('Good');
	
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
					'conditions' => $this->Good->parseCriteria($this->passedArgs),
					'order' => array(
							'Good.id' => 'asc'
					)
			);
			$this->request->params['named']['page'] = null;
		} else {
			$this->paginate = array(
					'conditions' => $this->Good->parseCriteria($this->passedArgs),
					'limit' => 6,
					'order' => array(
							'Good.id' => 'asc'
					)
			);
		}
		$this->set('goods', $this->Paginate());
	}
	
	public function view($id = null){
		
	}
	
	public function add(){
		if($this->request->is('post')){
			$this->Good->create();
			if($this->Good->save($this->request->data)){
				$this->Session->setFlash(__('New good added'),'alert'); //print_r($this->request->data); exit;
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('Unable to add'),'alert', array('class'=>'alert-error'));
			}
		}
	}
	
	public function edit($id = null){
		$this->Good->id = $id;
		if(!$this->Good->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		$extra_msg = '';
		if(!empty($this->request->data)){
			if($this->Good->save($this->request->data)){
				$this->Session->setFlash(__('Good data saved'),'alert');
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('Unable to save changes'),'alert', array('class'=>'alert-error'));
			}
		}
		else
		{
			$this->request->data = $this->Good->read();
		}
	}
	
	public function delete($id = null){
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Good->id = $this->request->data['id']; //--
		if(!$this->Good->exists()){
			throw new NotFoundException(__('Record not found'));
		}
		
		if($this->Good->delete($id)){
			$this->Session->setFlash(__('Product deleted'),'alert');
			$this->redirect(array('action'=>'index'));
		}
		else
		{
			$this->Session->setFlash(__('Unable to delete'),'alert', array('class'=>'alert-error'));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	public function find($id){
		$good = $this->Good->findById($id);
		echo json_encode($good['Good']);
		exit;
	}
}