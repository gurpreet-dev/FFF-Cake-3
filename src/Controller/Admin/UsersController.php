<?php

namespace App\Controller\Admin;



use App\Controller\AppController;

use Cake\Event\Event;

use Cake\Core\Configure;

use Cake\Error\Debugger;

use Cake\Utility\Xml;

/**

 * Users Controller

 *

 * @property \App\Model\Table\UsersTable $Users

 *

 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])

 */

class UsersController extends AppController

{



	public function beforeFilter(Event $event) {

        parent::beforeFilter($event);

        if ($this->request->params['prefix'] == 'admin') {

            $this->viewBuilder()->setLayout('admin');

        }

        $this->Auth->allow(['logout', 'amazontest']);

        $this->authcontent();

    }



    /**

     * Index method

     *

     * @return \Cake\Http\Response|void

     */

    public function login()

    {

	

		if($this->Auth->user()){

			return $this->redirect(['action' => 'index']);

		}

	

		$this->viewBuilder()->layout('admin2');

		

		if ($this->request->is('post')) {

			

            /*$users = $this->Users->find('all', [

                'conditions' => ['Users.email' => $this->request->data['username']]

            ]);

			

            $user = $users->first();*/

			

			

			if(!filter_var($this->request->data['username'], FILTER_VALIDATE_EMAIL)===false){

				$this->Auth->config('authenticate', [

					'Form'=>['fields'=>['username'=>'email', 'password'=>'password']]

				]);

				$this->Auth->constructAuthenticate();

				$this->request->data['email']=$this->request->data['username'];

				unset($this->request->data['username']);

			}

		

		

			$user = $this->Auth->identify();

			if ($user) {

				$this->Auth->setUser($user);

				

				if($this->Auth->user('role') != 'admin'){

					$this->logout();

					$this->Flash->error(__('Invalid Username or Password, try again'));

				}else{				

			   		return $this->redirect($this->Auth->redirectUrl());

				}	

			}else{

				$this->Flash->error(__('Invalid Username or Password, try again'));

			}

        }

    }

	

	public function index()

    {

		//$users = $this->Users->find('all');		

  		$users = $this->Users->find('all', [
			'order' => ['Users.id' => 'desc']
		]);

		$users = $users->all()->toArray();

		$this->set('users', $users);

		$this->set('_serialize', ['users']);

    }

	

	public function logout() {

        if ($this->Auth->logout()) {

            return $this->redirect(['action' => 'login']);

        }

    }

	

	/**

     * View method

     *

     * @param string|null $id User id.

     * @return \Cake\Http\Response|void

     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.

     */

    public function view($id = null)

    {

        $user = $this->Users->get($id, [

            'contain' => []

        ]);



        $this->set('user', $user);

        $this->set('_serialize', ['user']);

    }



    /**

     * Add method

     *

     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.

     */

    public function add()

    {

        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {

			$post = $this->request->getData();
			$post['status'] = 1;

            $user = $this->Users->patchEntity($user, $post);

            if ($this->Users->save($user)) {

                $this->Flash->success(__('The user has been saved.'));



                return $this->redirect(['action' => 'index']);

            }else{

            	$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}	

        }

        $this->set(compact('user'));

        $this->set('_serialize', ['user']);
		
		$this->loadModel('Countries');
		
		$countries = $this->Countries->find()->toArray();
		
		$this->set(compact('countries'));

        $this->set('_serialize', ['countries']);

    }



    /**

     * Edit method

     *

     * @param string|null $id User id.

     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.

     * @throws \Cake\Network\Exception\NotFoundException When record not found.

     */

    public function edit($id = null)

    {

        $user = $this->Users->get($id, [

            'contain' => []

        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
			
			$post = $this->request->data;

			if($this->request->data['image']['name'] != ''){
					
				if($user->image != ''){
                    if(file_exists(WWW_ROOT.'images/users/'.$user->image)){
					   unlink(WWW_ROOT.'images/users/'.$user->image);
                    }
				}	
			
				$image = $this->request->data['image'];
				$name = time().$image['name'];
				$tmp_name = $image['tmp_name'];
				$upload_path = WWW_ROOT.'images/users/'.$name;
				move_uploaded_file($tmp_name, $upload_path);
				
				$post['image'] = $name;
			
			}else{
				unset($this->request->data['image']);
				$post = $this->request->data;
			}

            $user = $this->Users->patchEntity($user, $post);

            if ($this->Users->save($user)) {

                $this->Flash->success(__('Details have been updated'));



                return $this->redirect(['action' => 'edit', $id]);

            }else{

	            $this->Flash->error(__('The user could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'edit', $id]);
			}
        }

        $this->set(compact('user'));

        $this->set('_serialize', ['user']);
		
		$this->loadModel('Countries');
		
		$countries = $this->Countries->find()->toArray();
		
		$this->set(compact('countries'));

        $this->set('_serialize', ['countries']);

    }



    /**

     * Delete method

     *

     * @param string|null $id User id.

     * @return \Cake\Http\Response|null Redirects to index.

     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.

     */

    public function delete($id = null)

    {
        //$this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {

            $this->Flash->success(__('The user has been deleted.'));

        } else {

            $this->Flash->error(__('The user could not be deleted. Please, try again.'));

        }



        return $this->redirect(['action' => 'index']);

    }
	
	public function changepassword($id = null){
		$user = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			
			if ($this->Users->save($user)) {
				$this->Flash->success(__('Your password has been changed'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->success(__('Invalid Password, try again'));
				return $this->redirect(['action' => 'index']);
			}
		}
		
		$this->set(compact('user'));
        $this->set('_serialize', ['user']);
	}

    /************************/

    public function plans()
    {

        $this->loadModel('Plans');

        $plans = $this->paginate($this->Plans);

        $this->set(compact('plans'));
        $this->set('_serialize', ['plans']);
    }

    public function addplan()
    {
        $this->loadModel('Plans');

        $plan = $this->Plans->newEntity();
        if ($this->request->is('post')) {
            $plan = $this->Plans->patchEntity($plan, $this->request->getData());
            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'plans']);
            }else{
                $this->Flash->error(__('The location could not be saved. Please, try again.'));
            }
        }
        
        
        $this->set(compact('plan'));
        $this->set('_serialize', ['plan']);
    }

    public function editplan($id = null)
    {
        $this->loadModel('Plans');

        $plan = $this->Plans->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $plan = $this->Plans->patchEntity($plan, $this->request->getData());
            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'plans']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        
        $this->set(compact('plan'));
        $this->set('_serialize', ['plan']);
    }

    public function deleteplan($id = null)
    {
        $this->loadModel('Plans');

        //$this->request->allowMethod(['post', 'delete']);
        $plan = $this->Plans->get($id);
        if ($this->Plans->delete($plan)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'plans']);
    }

    public function subscribers(){

        $subscribers = $this->Users->find('all', [
            'contain'   =>  [],
            'conditions'    =>  ['Users.subscribed' =>  1],
            'order' =>  ['Users.id' =>  'desc']
        ])->all();

        $this->set(compact('subscribers'));
        $this->set('_serialize', ['subscribers']);

    }


    public function upcomingsubscriptions(){

        $upcoming = $this->Users->find('all', [
            'conditions'    =>  ['Users.subscribed' =>  1]
        ]);

        $users = array();

        foreach($upcoming as $user){
            $from = strtotime($user['from']);

            $current_date = date('d-m-Y', strtotime("-1 month", time()));

            for($i=1; $i<=$user['duration']; $i++){

                $final = date("d-m-Y", strtotime("+".$i." month", $from));

                if($current_date < $final){

                    $user['final'] = strtotime($final);

                    $users[] = $user;

                    break;

                } 

            }
        }

        usort($users, function($a, $b) {
            return $a['final'] - $b['final'];
        });

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);

    }

    public function orders($id = null){

        $user = $this->Users->get($id);

        $this->loadModel('Orders');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->request->data['user_id'] = $id;

            $plan = $this->Orders->newEntity();
            $plan = $this->Orders->patchEntity($plan, $this->request->getData());
            if ($this->Orders->save($plan)) {
                $this->Flash->success(__('The order record has been saved successfully.'));
                return $this->redirect(['action' => 'orders', $id]);
            }else{
                $this->Flash->error(__('The order record could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'orders', $id]);
            }
        }


        /************* Amazon products **************/

        define ("AWS_ACCESS_KEY_ID", "AKIAIEI5PX3NEEWYKBCA");
        define ("MERCHANT_ID", "A2X0UWPHYR1Z6P");
        define ("MARKETPLACE_ID", "A2EUQ1WTGCTBG2");
        define ("AWS_SECRET_ACCESS_KEY","z142y2i/QR+kX/hHUyUAim/MxyiHkRxMzn8WhQCU");

        $base_url = "https://mws.amazonservices.com/Products/2011-10-01";
        $method = "POST";
        $host = "mws.amazonservices.com";
        $uri = "/Products/2011-10-01";


        $searchTerm = 'Vianei [Jan 01, 2018]';


        $this->loadModel('Productkey');

        $keys = $this->Productkey->find('all', [])->all()->toArray();

        //echo '<pre>'; print_r($keys); echo '</pre>';

        $params = array(
        'AWSAccessKeyId' => AWS_ACCESS_KEY_ID,
        'MWSAuthToken'  =>  'amzn.mws.70b130f5-f7df-d2ad-371e-bf197a131c73',
        //'IdType' => 'ASIN',
        'Action' => "GetMatchingProduct",
        'SellerId' => MERCHANT_ID,
        'SignatureMethod' => "HmacSHA256",
        'SignatureVersion' => "2",
        'Timestamp'=> date("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()),
        'Version'=> "2011-10-01",
        'MarketplaceId' => MARKETPLACE_ID);

        if(count($keys) >= 10){

            for($i=1; $i<=10; $i++){
                $params['ASINList.ASIN.'.$i] = $keys[$i]['key'];
            }

        }else{
            for($i=0; $i<count($keys); $i++){

                $j = $i+1;

                $params['ASINList.ASIN.'.$j] = $keys[$i]['key'];
            }
        }


        // Sort the URL parameters
        $url_parts = array();
        foreach(array_keys($params) as $key)
            $url_parts[] = $key . "=" . str_replace('%7E', '~', rawurlencode($params[$key]));
        sort($url_parts);

        // Construct the string to sign
        $url_string = implode("&", $url_parts);
        $string_to_sign = "GET\nmws.amazonservices.com\n/Products/2011-10-01\n" . $url_string;

        // Sign the request
        $signature = hash_hmac("sha256", $string_to_sign, AWS_SECRET_ACCESS_KEY, TRUE);

        // Base64 encode the signature and make it URL safe
        $signature = urlencode(base64_encode($signature));

        $url = "https://mws.amazonservices.com/Products/2011-10-01" . '?' . $url_string . "&Signature=" . $signature;



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ]);
        $response = curl_exec($ch);


        //$response = file_get_contents("https://mws.amazonservices.com/Products/2011-10-01" . '?' . $url_string . "&Signature=" . $signature);

        $xml_data = str_replace("ns2:","",$response);
        $products = Xml::build($xml_data);
        $products = json_decode(json_encode($products), TRUE);

        /************* Amazon products (END) **************/


        $orders = $this->Orders->find('all', [
            'conditions'    =>  ['Orders.user_id' => $id],
            'order'         =>  ['Orders.id'    =>  'desc']
        ])->all()->toArray();

        $orderkeys = array();

        foreach($orders as $order){
            $orderkeys[] = $order['key'];
        }


        $this->set(compact('products', 'orders', 'user', 'orderkeys'));
        $this->set('_serialize', ['products']);

    }

    public function changesequence($id = null){

        $user = $this->Users->get($id);

        $this->loadModel('Orders');

        if ($this->request->is(['patch', 'post', 'put'])) {


            $userupdate = $this->Users->updateAll(array(
                'books_sequence'    =>      implode(',',$this->request->data['keys'])
            ),array(    
                'Users.id'          =>      $id
            ));

            if ($userupdate) {
                $this->Flash->success(__('The sequence has been updated successfully.'));
                return $this->redirect(['action' => 'changesequence', $id]);
            }else{
                $this->Flash->error(__('The sequence could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'changesequence', $id]);
            }
        }


        /************* Amazon products **************/

        define ("AWS_ACCESS_KEY_ID", "AKIAIEI5PX3NEEWYKBCA");
        define ("MERCHANT_ID", "A2X0UWPHYR1Z6P");
        define ("MARKETPLACE_ID", "A2EUQ1WTGCTBG2");
        define ("AWS_SECRET_ACCESS_KEY","z142y2i/QR+kX/hHUyUAim/MxyiHkRxMzn8WhQCU");

        $base_url = "https://mws.amazonservices.com/Products/2011-10-01";
        $method = "POST";
        $host = "mws.amazonservices.com";
        $uri = "/Products/2011-10-01";


        $searchTerm = 'Vianei [Jan 01, 2018]';


        $this->loadModel('Productkey');

        $keys = $this->Productkey->find('all', [ 'order' => ['id' => 'desc']])->all()->toArray();

        //echo '<pre>'; print_r($keys); echo '</pre>';

        $params = array(
        'AWSAccessKeyId' => AWS_ACCESS_KEY_ID,
        'MWSAuthToken'  =>  'amzn.mws.70b130f5-f7df-d2ad-371e-bf197a131c73',
        //'IdType' => 'ASIN',
        'Action' => "GetMatchingProduct",
        'SellerId' => MERCHANT_ID,
        'SignatureMethod' => "HmacSHA256",
        'SignatureVersion' => "2",
        'Timestamp'=> date("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()),
        'Version'=> "2011-10-01",
        'MarketplaceId' => MARKETPLACE_ID);

        if(count($keys) >= 10){

            for($i=1; $i<=10; $i++){
                $params['ASINList.ASIN.'.$i] = $keys[$i]['key'];
            }

        }else{
            for($i=0; $i<count($keys); $i++){

                $j = $i+1;

                $params['ASINList.ASIN.'.$j] = $keys[$i]['key'];
            }
        }


        // Sort the URL parameters
        $url_parts = array();
        foreach(array_keys($params) as $key)
            $url_parts[] = $key . "=" . str_replace('%7E', '~', rawurlencode($params[$key]));
        sort($url_parts);

        // Construct the string to sign
        $url_string = implode("&", $url_parts);
        $string_to_sign = "GET\nmws.amazonservices.com\n/Products/2011-10-01\n" . $url_string;

        // Sign the request
        $signature = hash_hmac("sha256", $string_to_sign, AWS_SECRET_ACCESS_KEY, TRUE);

        // Base64 encode the signature and make it URL safe
        $signature = urlencode(base64_encode($signature));

        $url = "https://mws.amazonservices.com/Products/2011-10-01" . '?' . $url_string . "&Signature=" . $signature;



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ]);
        $response = curl_exec($ch);


        //$response = file_get_contents("https://mws.amazonservices.com/Products/2011-10-01" . '?' . $url_string . "&Signature=" . $signature);

        $xml_data = str_replace("ns2:","",$response);
        $products = Xml::build($xml_data);
        $products = json_decode(json_encode($products), TRUE);

        /************* Amazon products (END) **************/


        /**************** Amazon Orders by user email *******************/

        /**************** Amazon Orders by user email *******************/

        $orders = $this->Orders->find('all', [
            'conditions'    =>  ['Orders.user_id' => $id],
            'order'         =>  ['Orders.id'    =>  'desc']
        ])->all()->toArray();

        $orderkeys = array();

        foreach($orders as $order){
            $orderkeys[] = $order['key'];
        }

        $selected = explode(',', $user->books_sequence);

        $this->set(compact('products', 'user', 'orderkeys', 'selected'));
        $this->set('_serialize', ['products']);


    }

    public function subrelorders(){

        $subscribers = $this->Users->find('all', [
            'contain'   =>  [],
            'conditions'    =>  ['Users.subscribed' =>  1],
            'order' =>  ['Users.id' =>  'desc']
        ])->all();


        $current_date = time();

        foreach($subscribers as $user){

            $this->loadModel('Orders');

            $orders = $this->Orders->find('all', [
                'conditions' => ['Orders.user_id' => $user->id]
            ])->all()->toArray();

            /***********/

            $ordered_dates = array();

            foreach($orders as $order){
                $ordered_dates[] = $order->date;
            }

            /***********/

            $from = strtotime($user['from']);

            for($i=1; $i<=$user['duration']; $i++){

                $final = date("d-m-Y", strtotime("+".$i." month", $from));

                if(!in_array($final, $ordered_dates)){
                    $user['due_date'] = $final;
                    break;
                }

            }


            $seqs = explode(',',$user->books_sequence);

            $condition = array();

            foreach($seqs as $seq){
                $condition[]['key'] = $seq;
            }

            $this->loadModel('Productkey');

            $keys = $this->Productkey->find('all', [
                'conditions'    =>  ['or' => $condition]
            ])->all();


            /*************/

            $ordered_books = array();

            foreach($orders as $order){
                $ordered_books[] = $order->key;
            }

            /*************/

            foreach($keys as $key){
                if(!in_array($key->key, $ordered_books)){
                    $user['next_book']  =  [
                        'ASIN'  =>  $key->key,
                        'Title' =>  $key->title
                    ];

                    break;
                }
            }

        }

        $this->set(compact('subscribers'));
        $this->set('_serialize', ['subscribers']);

    }

    public function createorder(){


        $this->loadModel('Orders');

        if ($this->request->is(['patch', 'post', 'put'])) {

            //echo '<pre>'; print_r($this->request->data); echo '</pre>'; exit;

            $plan = $this->Orders->newEntity();
            $plan = $this->Orders->patchEntity($plan, $this->request->getData());
            if ($this->Orders->save($plan)) {
                $this->Flash->success(__('The order record has been saved successfully.'));
                return $this->redirect(['action' => 'subrelorders']);
            }else{
                $this->Flash->error(__('The order record could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'subrelorders']);
            }
        }    

    }

    public function amazontest(){

        $user = $this->Users->get(8);

        define ("AWS_ACCESS_KEY_ID", "AKIAIEI5PX3NEEWYKBCA");
        define ("MERCHANT_ID", "A2X0UWPHYR1Z6P");
        define ("MARKETPLACE_ID", "A2EUQ1WTGCTBG2");
        define ("AWS_SECRET_ACCESS_KEY","z142y2i/QR+kX/hHUyUAim/MxyiHkRxMzn8WhQCU");

        $base_url = "https://mws.amazonservices.com/Orders/2013-09-01";
        $method = "POST";
        $host = "mws.amazonservices.com";
        $uri = "/Orders/2013-09-01";

        $params = array(
        'AWSAccessKeyId' => AWS_ACCESS_KEY_ID,
        'MWSAuthToken'  =>  'amzn.mws.70b130f5-f7df-d2ad-371e-bf197a131c73',
        'MarketplaceId.Id.1'    =>  'A2EUQ1WTGCTBG2',
        'BuyerEmail'    =>  $user->email,
        'Action' => "ListOrders",
        'SellerId' => MERCHANT_ID,
        'SignatureMethod' => "HmacSHA256",
        'SignatureVersion' => "2",
        'Timestamp'=> date("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()),
        'Version'=> "2013-09-01",
        'MarketplaceId' => MARKETPLACE_ID);

        // Sort the URL parameters
        $url_parts = array();
        foreach(array_keys($params) as $key)
            $url_parts[] = $key . "=" . str_replace('%7E', '~', rawurlencode($params[$key]));
        sort($url_parts);

        // Construct the string to sign
        $url_string = implode("&", $url_parts);
        $string_to_sign = "GET\nmws.amazonservices.com\n/Orders/2013-09-01\n" . $url_string;

        // Sign the request
        $signature = hash_hmac("sha256", $string_to_sign, AWS_SECRET_ACCESS_KEY, TRUE);

        // Base64 encode the signature and make it URL safe
        $signature = urlencode(base64_encode($signature));

        $url = "https://mws.amazonservices.com/Orders/2013-09-01" . '?' . $url_string . "&Signature=" . $signature;



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ]);
        $response = curl_exec($ch);


        //$response = file_get_contents("https://mws.amazonservices.com/Products/2011-10-01" . '?' . $url_string . "&Signature=" . $signature);

        $xml_data = str_replace("ns2:","",$response);
        $products = Xml::build($xml_data);
        $products = json_decode(json_encode($products), TRUE);

        print_r($products);
        exit;
    }

}

