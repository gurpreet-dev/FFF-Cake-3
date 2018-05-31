<?php
namespace App\Controller\Admin;
use Cake\Event\Event;
use App\Controller\AppController;

/**
 * Productkey Controller
 *
 * @property \App\Model\Table\ProductkeyTable $Productkey
 *
 * @method \App\Model\Entity\Staticpage[] paginate($object = null, array $settings = [])
 */
class ProductkeyController extends AppController
{

	public function beforeFilter(Event $event) {

        parent::beforeFilter($event);

        if ($this->request->params['prefix'] == 'admin') {

            $this->viewBuilder()->setLayout('admin');

        }

        $this->Auth->allow(['delete']);

        $this->authcontent();

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $productkey = $this->Productkey->find('all',[
			'order'		=>  ['Productkey.id' => 'desc']
		]);
		
		$productkey = $productkey->all()->toArray();

        $this->set(compact('productkey'));
        $this->set('_serialize', ['productkey']);
    }

    /**
     * View method
     *
     * @param string|null $id Staticpage id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productkey = $this->Productkey->get($id, [
            'contain' => []
        ]);

        $this->set('productkey', $productkey);
        $this->set('_serialize', ['productkey']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productkey = $this->Productkey->newEntity();
        if ($this->request->is('post')) {
		
			$post = $this->request->data;
			
			/*$image = $this->request->data['image'];
			$name = time().$image['name'];
			$tmp_name = $image['tmp_name'];
			$upload_path = WWW_ROOT.'images/productkey/'.$name;
			move_uploaded_file($tmp_name, $upload_path);
			
			$post['image'] = $name;*/
		
			$post['slug'] = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $post['title']));
		
            $productkey = $this->Productkey->patchEntity($productkey, $post);
            if ($this->Productkey->save($productkey)) {
                $this->Flash->success(__('The productkey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{
            	$this->Flash->error(__('The productkey could not be saved. Please, try again.'));
			}	
        }
        $this->set(compact('productkey'));
        $this->set('_serialize', ['productkey']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Staticpage id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productkey = $this->Productkey->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
		
			$post = $this->request->data;
		
			/*if($this->request->data['image']['name'] != ''){
					
				if($productkey->image != ''){
					unlink(WWW_ROOT.'images/productkey/'.$productkey->image);
				}	
			
				$image = $this->request->data['image'];
				$name = time().$image['name'];
				$tmp_name = $image['tmp_name'];
				$upload_path = WWW_ROOT.'images/productkey/'.$name;
				move_uploaded_file($tmp_name, $upload_path);
				
				$post['image'] = $name;
			
			}else{
				unset($this->request->data['image']);
				$post = $this->request->data;
			}*/
			
			$post['slug'] = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $post['title']));
			
            $productkey = $this->Productkey->patchEntity($productkey, $post);
            if ($this->Productkey->save($productkey)) {
                $this->Flash->success(__('The productkey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{
           		$this->Flash->error(__('The productkey could not be saved. Please, try again.'));
			}	
        }
        $this->set(compact('productkey'));
        $this->set('_serialize', ['productkey']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Staticpage id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $productkey = $this->Productkey->get($id);
		
		if($productkey->image != ''){
			if(file_exists(WWW_ROOT.'images/productkey/'.$productkey->image)){
				unlink(WWW_ROOT.'images/productkey/'.$productkey->image);
			}
		}
		
        if ($this->Productkey->delete($productkey)) {
            $this->Flash->success(__('The productkey has been deleted.'));
        } else {
            $this->Flash->error(__('The productkey could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
