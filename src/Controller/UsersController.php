<?php

namespace App\Controller;



use App\Controller\AppController;

use Cake\Event\Event;

use Cake\Routing\Router;

use Cake\Mailer\Email;

use Cake\Auth\DefaultPasswordHasher;

use Cake\Utility\Xml;

require_once('../vendor/stripe/stripe-php/init.php');

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



        $this->Auth->allow(['index', 'add', 'login', 'home', 'forgot', 'reset', 'contact', 'ajaxSignup', 'plans', 'getproducts', 'sendsubscriptionmailtoadmin', 'checksubscriptionexpiry', 'getinventories', 'cart', 'stripe', 'addguest', 'ajaxgetplan', 'plansuccess2']);

        $this->authcontent();

    }

	

    /**

     * Index method

     *

     * @return \Cake\Http\Response|void

     */

    public function ajaxSignup(){
		$response = array();
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			
			$user_check = $this->Users->find('all', ['conditions' => ['Users.email' => $this->request->data['email']]]);
			$user_check = $user_check->first();
			if (!empty($user_check)) {
				$response['isSucess'] = "false";
				$response['msg'] = "<div class='alert alert-danger'><strong>Email Address already exists. Please try with another email ID..</strong></div>";
			}else {
				$post = $this->request->data;
				$post['status'] = '1';
				$post['role'] = 'user';
				$user = $this->Users->patchEntity($user, $post);
				$new_user = $this->Users->save($user);
				if ($new_user) {
					$ms = 'A new User has been registered recently with email ID <strong>' . $post['email'] . '</strong>';
					$ms.= '<br />';
					$ms.= '<table border="0"><tr><th scope="row" align="left">Name</th><td>' . $post['name'] . '</td></tr><tr><th scope="row" align="left">Email</th><td>' . $post['email'] . '</td></tr></table>';
					// $email = new Email('default');
					// $email->from(['gurpreet@avainfotech.com' => 'Trip'])
					// 	->emailFormat('html')
					// 	->template('default', 'default')
					// 	->to('gurpreet@avainfotech.com')
					// 	->subject('New User Registration')
					// 	->send($ms);
					$this->request->data['username'] = $post['email'];
					$this->request->data['password'] = $this->request->data['password'];
					if (!filter_var($this->request->data['username'], FILTER_VALIDATE_EMAIL) === false) {
						$this->Auth->config('authenticate', ['Form' => ['fields' => ['username' => 'email', 'password' => 'password']]]);
						$this->Auth->constructAuthenticate();
						$this->request->data['email'] = $this->request->data['username'];
						unset($this->request->data['username']);
					}
					$user1 = $this->Auth->identify();
					if ($user1) {
						$this->Auth->setUser($user1);
						$response['isSucess'] = "true";
						$response['msg'] = "<div class='alert alert-success'><strong>Registered Successfully.</strong></div>";
					}
					else {
						$response['isSucess'] = "false";
						$response['msg'] = "<div class='alert alert-success'><strong>Registered Successfully. But unable to login</strong></div>";
					}
				}
			}
		}
		echo json_encode($response);
		exit;
	}
	
	public function home(){

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
		'MWSAuthToken'	=>	'amzn.mws.70b130f5-f7df-d2ad-371e-bf197a131c73',
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

		for($i=0; $i<count($products['GetMatchingProductResult']); $i++){
			$pro = $this->Productkey->find('all', ['conditions' => ['Productkey.key' => $products['GetMatchingProductResult'][$i]['Product']['Identifiers']['MarketplaceASIN']['ASIN']]])->first();

			$products['GetMatchingProductResult'][$i]['description'] = $pro->content;

		}


		/*******************/

		// foreach($products['GetMatchingProductResult'] as $product){

		// 	$price_params = array(
		// 	'ASINList.ASIN.1' => 'B07C9CSJ3T',
		// 	'AWSAccessKeyId' => AWS_ACCESS_KEY_ID,
		// 	'MWSAuthToken'	=>	'amzn.mws.70b130f5-f7df-d2ad-371e-bf197a131c73',
		// 	'Action' => "GetMyPriceForASIN",
		// 	'SellerId' => MERCHANT_ID,
		// 	'SignatureMethod' => "HmacSHA256",
		// 	'SignatureVersion' => "2",
		// 	'Timestamp'=> date("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()),
		// 	'Version'=> "2011-10-01",
		// 	'MarketplaceId' => MARKETPLACE_ID
		// 	);

		

		// 	$url_parts1 = array();
		// 	foreach(array_keys($price_params) as $key)
		// 	    $url_parts1[] = $key . "=" . str_replace('%7E', '~', rawurlencode($price_params[$key]));
		// 	sort($url_parts1);

		// 	// Construct the string to sign
		// 	$url_string1 = implode("&", $url_parts1);
		// 	$string_to_sign1 = "GET\nmws.amazonservices.com\n/Products/2011-10-01\n" . $url_string1;

		// 	// Sign the request
		// 	$signature1 = hash_hmac("sha256", $string_to_sign1, AWS_SECRET_ACCESS_KEY, TRUE);

		// 	// Base64 encode the signature and make it URL safe
		// 	$signature1 = urlencode(base64_encode($signature1));

		// 	$url1 = "https://mws.amazonservices.com/Products/2011-10-01" . '?' . $url_string1 . "&Signature=" . $signature1;

		// 	$response1 = file_get_contents("https://mws.amazonservices.com/Products/2011-10-01" . '?' . $url_string1 . "&Signature=" . $signature1);

		// 	$xml_data1 = str_replace("ns2:","",$response1);
		// 	$products1 = Xml::build($xml_data1);
		// 	$products1 = json_decode(json_encode($products1), TRUE);

		// 	if(!empty($products1['GetMyPriceForASINResult']['Product']['Offers'])){

		// 		$product['Product']['AttributeSets']['Price'] = $products1['GetMyPriceForASINResult']['Product']['Offers']['Offer']['RegularPrice']['Amount'];
		// 		$product['Product']['AttributeSets']['CurrencyCode'] = $products1['GetMyPriceForASINResult']['Product']['Offers']['Offer']['RegularPrice']['CurrencyCode'];
		// 	}

		// }	


		/*******************/


		
		$this->set(compact('products'));
		$this->set('_serialize', ['products']);

	}
	
	public function logout() {
		if ($this->Auth->logout()) {
			return $this->redirect(['action' => 'home']);
		}
    }
	
	public function login(){
		if ($this->request->is('post')) {
		
			if (!filter_var($this->request->data['username'], FILTER_VALIDATE_EMAIL) === false) {
				$this->Auth->config('authenticate', ['Form' => ['fields' => ['username' => 'email', 'password' => 'password']]]);
				$this->Auth->constructAuthenticate();
				$this->request->data['email'] = $this->request->data['username'];
				unset($this->request->data['username']);
			}
			$user = $this->Auth->identify();
			if ($user) {
				if ($user['status'] == 0) {
					$this->Auth->logout();
					$response['data'] = "no data";
					// $response['user'] = $user['email_status'];
					$response['isSucess'] = "false";
					$response['msg'] = "<div class='alert alert-danger'>You are not active yet</div>";
				}
				else {
					$this->Auth->setUser($user);
					if ($this->Auth->user('role') == 'admin') {
						$this->Auth->logout();
						$response['data'] = "no data";
						$response['isSucess'] = "false";
						$response['msg'] = "<div class='alert alert-danger'>Entered wrong Username or Password ! Please try again!</div>";
					}
					else {
						$response['data'] = $this->Auth->user();
						$response['isSucess'] = "true";
						$response['msg'] = "<div class='alert alert-success'>Logged In successfully. Redirecting..</div>";
					}
				}
			}
			else {
				$response['data'] = "no data";
				$response['isSucess'] = "false";
				$response['msg'] = "<div class='alert alert-danger'>Entered wrong Username or Password ! Please try again!</div>";
			}
		}
		
		$this->set(compact('response'));
		$this->set('_serialize', ['response']);
	}
	
	public function forgot(){
		if ($this->Auth->user()) {
			$this->redirect('/');
		}
		
		$response = array();
		
		if ($this->request->is('post')) {
			$email = $this->request->data['email'];
			$user = $this->Users->find('all', ['conditions' => ['Users.email' => $email]]);
			$user = $user->first();
			$burl = Router::fullbaseUrl();
			if (empty($user)) {
				$response['data'] = "no data";
				$response['isSucess'] = "false";
				$response['msg'] = "<div class='alert alert-danger'>Please enter registered email address</div>";
			}
			else {
				if ($user->email) {
					$hash = md5(time() . rand(111999999999999999999999999, 99999999999999999999999999999999999999999));
					$url = Router::url(['controller' => 'Users', 'action' => 'reset' . '/' . $hash]);
					$this->Users->updateAll(array(
						'tokenhash' => $hash
					) , array(
						'id' => $user->id
					));

					$email = new Email('default'); 
	                $email->from(['gurpreet@avainfotech.com' => 'Friendly Fables'])
	                    ->template('forgot')
	                    ->emailFormat('html')
	                    ->viewVars(['url' => $burl . $url, 'email' => $user->email])
	                    ->to($user->email)
	                    ->subject('Reset Your Password')
	                    ->send(); 	
					
					$response['data'] = "no data";
					$response['isSucess'] = "true";
					$response['msg'] = "<div class='alert alert-success'>Check your email to reset your password</div>";
				}
				else {
					$response['data'] = "no data";
					$response['isSucess'] = "false";
					$response['msg'] = "<div class='alert alert-danger'>Email is invalid</div>";
				}
			}
		}
		
		echo json_encode($response);
		exit;
	}
	
	
	public function edit($id = null){
		// print_r($this->request->session()->read('Auth.User'));
		// $current_user = $this->Users->find('all', ['conditions' => ['Users.id' => $this->Auth->user('id')]]);
		//    $current_user = $current_user->first()->toArray();
		//    print_r($current_user);
		$id = substr(base64_decode($id) , 4);
		$user = $this->Users->get($id, ['contain' => []]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			// echo "<pre>"; print_r($this->request->data); echo "</pre>"; exit;
			$post = $this->request->data;
			if (isset($this->request->data['image']) && $this->request->data['image']['name'] != '') {
				if ($user->image != '') {
					unlink(WWW_ROOT . 'images/users/' . $user->image);
				}
				$image = $this->request->data['image'];
				$name = time() . $image['name'];
				$tmp_name = $image['tmp_name'];
				$upload_path = WWW_ROOT . 'images/users/' . $name;
				move_uploaded_file($tmp_name, $upload_path);
				$post['image'] = $name;
			}else {
				unset($this->request->data['image']);
				$post = $this->request->data;
			}
			
			if (!empty($post['languages'])) {
				$post['languages'] = implode(',', $post['languages']);
			}else {
				$post['languages'] = '';
			}
			
			$user = $this->Users->patchEntity($user, $post);
			if ($this->Users->save($user)) {
				$current_user = $this->Users->get($id, ['contain' => []]);
				$session = $this->request->session();
				$session->write('Auth.User.image', $current_user->image);
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'edit', base64_encode('user'.$id), '?' => array('step' => '2')]);
			}
			else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
				return $this->redirect(['action' => 'edit', base64_encode('user'.$id), '?' => array('step' => '2')]);
			}
		}
		// $this->loadModel('Countries');
		// $countries = $this->Countries->find('all');
		// $countries = $countries->all();
		// $this->set(compact('countries'));
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
	}

	
	
	public function reset($token = null){
		if ($this->request->is(['patch', 'post', 'put'])) {
			$query = $this->Users->find('all', ['conditions' => ['Users.tokenhash' => $token]]);
			$data = $query->first();
			if ($data) {
					
				$this->request->data['password'] = $this->request->data['rcpassword'];
				
				$this->request->data['tokenhash'] = md5(time() . rand(111999999999999999999999999999, 999999999999999999999999999999999));
				$user = $this->Users->get($data->id, ['contain' => []]);
				$user = $this->Users->patchEntity($user, $this->request->getData());
				if ($this->Users->save($user)) {
					$this->Flash->success('Your password has been changed', ['key' => 'positive']);
				}
				else {
					$this->Flash->error('Invalid Password, try again', ['key' => 'positive']);
					$this->redirect(['action' => 'reset/' . $token]);
				}
			}
			else {
				$this->Flash->error('Invalid Token, try again', ['key' => 'positive']);
				$this->redirect(['action' => 'reset/' . $token]);
			}
		}	
		$this->set(compact('response'));
		$this->set('_serialize', ['response']);
	}
	
	
	public function changepassword(){
		$id = $this->Auth->user('id');
		$user = $this->Users->get($id, ['contain' => []]);
		if ($this->request->is(['patch', 'post', 'put'])) {
		
			$this->request->data['password'] = $this->request->data['cppassword'];
		
			if ((new DefaultPasswordHasher)->check($this->request->data['opassword'], $user['password'])) {
				$user = $this->Users->patchEntity($user, $this->request->data);
				if ($this->Users->save($user)) {
					$this->Flash->success(__('Password Changed Successfully'));
					if (isset($_GET['route'])) {
						return $this->redirect(['action' => 'edit', base64_encode('user'.$id), '?' => array('step' => '3')]);
					}
					else {
						return $this->redirect(['action' => 'edit', base64_encode('user'.$id), '?' => array('step' => '3')]);
					}
				}
				else {
					$this->Flash->error(__('Invalid Password, try again'));
					if (isset($_GET['route'])) {
						return $this->redirect(['action' => 'edit', base64_encode('user'.$id), '?' => array('step' => '3')]);
					}
					else {
						return $this->redirect(['action' => 'edit', base64_encode('user'.$id), '?' => array('step' => '3')]);
					}
				}
			}
			else {
				$this->Flash->error(__('Old password did not match'));
				if (isset($_GET['route'])) {
					return $this->redirect(['action' => 'edit', base64_encode('user'.$id), '?' => array('step' => '3')]);
				}
				else {
					return $this->redirect(['action' => 'edit', base64_encode('user'.$id), '?' => array('step' => '3')]);
				}
			}
		}
	}

	public function contact() {





        $this->loadModel('Contacts');



        $contact = $this->Contacts->newEntity();

        if ($this->request->is('post')) {





            $contact = $this->Contacts->patchEntity($contact, $this->request->data);

            if ($this->Contacts->save($contact)) {



                $ms = '<table width="200" border="1"><tr><th scope="row">Name</th><td>' . $this->request->data['name'] . '</td></tr><tr><th scope="row">Email</th><td>' . $this->request->data['email'] . '</td></tr><th scope="row">Message</th><td>' . $this->request->data['message'] . '</td></tr></table>';





                $email = new Email('default');



                $email->from(['gurpreet@avainfotech.com' => 'FFF'])
                        ->emailFormat('html')
                        ->template('default', 'default')
                        ->to('gurpreet@avainfotech.com')
                        ->subject('Contact Us Enquiry')
                        ->send($ms);





                $this->Flash->success(__('Thanks for getting in touch. Your message has been sent to Admin. Our team will contact you shortly.'));
            } else {

                $this->Flash->error(__('The contact could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('contact'));

        $this->set('_serialize', ['contact']);
    }


    /***********************/


    public function plans(){


        $this->loadModel('Plans');

        $plans = $this->paginate($this->Plans);

        if($this->Auth->user('id')){
        	$loggedin = 1;
        }else{
        	$loggedin = 0;
        }

        $this->set(compact('plans', 'loggedin'));
        $this->set('_serialize', ['plans']);
    }

    public function ajaxgetplan($id = null){

    	$this->loadModel('Plans');

    	$plan = $this->Plans->get($id);

    	echo json_encode($plan);
    	exit;
    }

    public function planpay($id = null){

    	if(!$id){
    		return $this->redirect(['action' => 'plans']);
    	}

    	$this->loadModel('Plans');

    	$plan = $this->Plans->get($id);

    	$user = $this->Users->get($this->Auth->user('id'));

    	echo ".<form name=\"_xclick\" action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\">
				<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
				<input type=\"hidden\" name=\"email\" value=\"$user->email\">
				<input type=\"hidden\" name=\"business\" value=\"rupak1-facilitator@avainfotech.com\">
				<input type=\"hidden\" name=\"currency_code\" value=\"USD\">
				<input type=\"hidden\" name=\"custom\" value=\"$id\">
				<input type=\"hidden\" name=\"amount\" value=\"$plan->price\">
				<input type=\"hidden\" name=\"landing_page\" value=\"billing\">
				<input type=\"hidden\" name=\"return\" value=\"http://singhgurpreet.crystalbiltech.com/fff/users/plansuccess\">
				</form>";
				echo "<script>document._xclick.submit();</script>";

    }

    public function plansuccess(){

    	if(isset($_REQUEST['tx'])){ 
		
    		$this->loadModel('Plans');

    		$plan = $this->Plans->get($_REQUEST['cm']);

    		$this->Users->updateAll(array(
                'plan_id'			=>  $_REQUEST['cm'],
                'price'				=>  $plan->price,
                'duration'			=>  $plan->duration,
                'from'				=>	date('d-m-Y'),
                'to'				=>	date("d-m-Y", strtotime(" +".$plan->duration." months")),
                'subscribed'		=>  1    
            ),array(
                'Users.id'			=>  $this->Auth->user('id')
            ));

            $post = [
            	'user_id'			=>	$this->Auth->user('id'),
            	'transaction_id'	=>	$_REQUEST['tx'],
            	'payment_status'   	=>  $_REQUEST['st'],
            	'price'				=>	$plan->price,
            	'duration'			=>	$plan->duration
            ];

            $this->loadModel('Subscriptions');

            $subscription = $this->Subscriptions->newEntity();
			$subscription = $this->Subscriptions->patchEntity($subscription, $post);
			$subscription = $this->Subscriptions->save($subscription);

			$user = $this->Users->get($this->Auth->user('id'));

            // $email = new Email('default');  // Expert Booking
            // $email->from(['gurpreet@avainfotech.com' => 'Subscription'])
            //     ->template('usersubscription')
            //     ->emailFormat('html')
            //     ->viewVars(['plan' => $plan])
            //     ->to($user->email)
            //     ->subject('Platour Booking')
            //     ->send();

            $response = 'success';
            
        }else{
            $response = 'error';
        }
        
        $this->set('response', $response);
        $this->set('_serialize', ['response']);

    }

    public function sendsubscriptionmailtoadmin(){

    	$users = $this->Users->find('all', [
    		'contain'		=>	['Plans'],
    		'conditions'	=>	['Users.subscribed'	=>	1]
    	])->all()->toArray();

    	//print_r($users); exit;

    	$current_date = date('d-m-Y');

    	foreach($users as $user){
    		$from = strtotime($user['from']);

    		for($i=1; $i<=$user['duration']; $i++){

    			$final = date("d-m-Y", strtotime("+".$i." month", $from));

    			if($current_date == $final){

	    			$email = new Email('default');  // Expert Booking
		            $email->from(['gurpreet@avainfotech.com' => 'Subscription Month'])
		                ->template('subscriptionmonthadmin')
		                ->emailFormat('html')
		                ->viewVars(['user' => $user])
		                ->to($this->adminEmail())
		                ->subject('Subscription Month')
		                ->send();

	            } 

    		}

    	}

    	exit;

    }

    public function checksubscriptionexpiry(){

    	$users = $this->Users->find('all', [
    		'contain'		=>	['Plans'],
    		'conditions'	=>	['Users.subscribed'	=>	1]
    	])->all()->toArray();

    	$current_date = time();

    	foreach($users as $user){
    		$to = strtotime($user['to']);

    		if($current_date > $to){

    			$this->Users->updateAll(array(
	                'subscribed'		=>  0   
	            ),array(
	                'Users.id'			=>  $user['id']
	            ));

    			$this->loadModel('Subscriptions');

	            $this->Subscriptions->updateAll(array(
	                'status'		=>  'expired'  
	            ),array(
	                'Subscriptions.user_id'			=>  $user['id']
	            ));


    			$email = new Email('default');  // Expert Booking
	            $email->from(['gurpreet@avainfotech.com' => 'Friendly Family Fables'])
	                ->template('subscriptionexpireuser')
	                ->emailFormat('html')
	                ->viewVars(['user' => $user])
	                ->to($user['email'])
	                ->subject('Subscription Expired')
	                ->send();

	            $email = new Email('default');  // Expert Booking
	            $email->from(['gurpreet@avainfotech.com' => 'Friendly Family Fables'])
	                ->template('subscriptionexpireadmin')
	                ->emailFormat('html')
	                ->viewVars(['user' => $user])
	                ->to($this->adminEmail())
	                ->subject('Subscription Expired')
	                ->send();    

    		}

    	}

    	exit;

    }

    /*************************/


    public function getproducts(){

		define ("AWS_ACCESS_KEY_ID", "AKIAIEI5PX3NEEWYKBCA");
		define ("MERCHANT_ID", "A2X0UWPHYR1Z6P");
		define ("MARKETPLACE_ID", "A2EUQ1WTGCTBG2");
		define ("AWS_SECRET_ACCESS_KEY","z142y2i/QR+kX/hHUyUAim/MxyiHkRxMzn8WhQCU");

		$base_url = "https://mws.amazonservices.com/Products/2011-10-01";
		$method = "POST";
		$host = "mws.amazonservices.com";
		$uri = "/Products/2011-10-01";


		$searchTerm = 'Vianei [Jan 01, 2018]';

		$params = array(
		'AWSAccessKeyId' => AWS_ACCESS_KEY_ID,
		'MWSAuthToken'	=>	'amzn.mws.70b130f5-f7df-d2ad-371e-bf197a131c73',
		'Action' => "ListMatchingProducts",
		'SellerId' => MERCHANT_ID,
		'SignatureMethod' => "HmacSHA256",
		'SignatureVersion' => "2",
		'Timestamp'=> date("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()),
		'Version'=> "2011-10-01",
		'MarketplaceId' => MARKETPLACE_ID,
		'Query' => $searchTerm);


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

		//$url = "https://mws.amazonservices.com/Products/2011-10-01" . '?' . $url_string . "&Signature=" . $signature;



		// $ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL,$url);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// //curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ]);
		// $response = curl_exec($ch);


		$response = file_get_contents("https://mws.amazonservices.com/Products/2011-10-01" . '?' . $url_string . "&Signature=" . $signature);

		$xml_data = str_replace("ns2:","",$response);
		$xml = Xml::build($xml_data);
		$xml = json_decode(json_encode($xml), TRUE);
		print_r($xml);
		exit;

    }


    public function getinventories(){

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

		$params = array(
		'AWSAccessKeyId' => AWS_ACCESS_KEY_ID,
		'MWSAuthToken'	=>	'amzn.mws.70b130f5-f7df-d2ad-371e-bf197a131c73',
		'IdType' => 'ASIN',
		'Action' => "GetMatchingProductForId",
		'SellerId' => MERCHANT_ID,
		'SignatureMethod' => "HmacSHA256",
		'SignatureVersion' => "2",
		'Timestamp'=> date("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()),
		'Version'=> "2011-10-01",
		'MarketplaceId' => MARKETPLACE_ID);

		for($i=1; $i<count($keys); $i++){
			$params['IdList.Id.'.$i] = $keys[$i]['key'];
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
		$xml = Xml::build($xml_data);
		$xml = json_decode(json_encode($xml), TRUE);
		print_r($xml);
		exit;

    }

    public function cart(){
    	
    }

    public function stripe($id = null, $user_id= null){

    	// if(!$id){
    	// 	return $this->redirect(['action' => 'plans']);
    	// }

    	// $id = base64_decode($id);

    	 $this->loadModel('Plans');

    	 $plan = $this->Plans->get($id);

    	 $user = $this->Users->get($user_id);

    	if ($this->request->is(['patch', 'post', 'put'])) {

	    	\Stripe\Stripe::setApiKey('sk_test_OTtRBBZRsCTxVhoGHz5DGCMg');

            if($user->stripe_customer != ''){
                $customer = \Stripe\Customer::retrieve($user->stripe_customer);
                //$cardID = $customer->default_source;

                if(!isset($customer->default_source)){
                    $customer = \Stripe\Customer::create(array(
                        'email' => $user->email,
                        'source'  => $_POST['stripeToken']
                    ));
                }else{
                    $customer_id = $user->stripe_customer;
                }
            }else{
                $customer = \Stripe\Customer::create(array(
                    'email' => $user->email,
                    'source'  => $_POST['stripeToken']
                ));

                $customer_id = $customer->id;
            } 

            $amount = $plan->price * 100;

			$charge = \Stripe\Charge::create(['customer' => $customer_id, 'amount' => $amount, 'currency' => 'USD']);

		    $chargeJson = $charge->jsonSerialize();

		    //echo "<pre>"; print_r($chargeJson); echo "</pre>"; exit;

		    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){

		    	$amount = $chargeJson['amount'];
		        $balance_transaction = $chargeJson['balance_transaction'];
		        $currency = $chargeJson['currency'];
		        $status = $chargeJson['status'];
		        $date = date("Y-m-d H:i:s");

		    	if($status == 'succeeded'){

		    		$this->Users->updateAll(array(
		                'plan_id'			=>  $id,
		                'price'				=>  $plan->price,
		                'duration'			=>  $plan->duration,
		                'from'				=>	date('d-m-Y'),
		                'to'				=>	date("d-m-Y", strtotime(" +".$plan->duration." months")),
                        'books_sequence'    =>  '',
                        'stripe_customer'          =>  $customer_id,
		                'subscribed'		=>  1    
		            ),array(
		                'Users.id'			=>  $user_id
		            ));

		            $post = [
		            	'user_id'			=>	$user_id,
                        'customer'          =>  $customer_id,
		            	'transaction_id'	=>	$balance_transaction,
		            	'payment_status'   	=>  'completed',
		            	'price'				=>	$plan->price,
		            	'duration'			=>	$plan->duration
		            ];

		            $this->loadModel('Subscriptions');

		            $subscription = $this->Subscriptions->newEntity();
					$subscription = $this->Subscriptions->patchEntity($subscription, $post);
					$subscription = $this->Subscriptions->save($subscription);

					$user = $this->Users->get($user_id, ['contain' => ['Plans']]);

		            $email = new Email('default');  // Expert Booking
		            $email->from(['gurpreet@avainfotech.com' => 'Subscription'])
		                ->template('usersubscription')
		                ->emailFormat('html')
		                ->viewVars(['user' => $user])
		                ->to($user->email)
		                ->subject('Friendly Fables Subscription')
		                ->send();

		            $response = "success";
		        }else{
		            $response = "error";
		        }
		    }else{
	            $response = "error";
	        }

		    return $this->redirect(['action' => 'plansuccess2', '?' => ['res' => $response]]);
		}	
    }

    public function addguest($subscription_id = null){

    	$response = array();
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {

			//print_r($this->request->data); exit;
			
			$user_check = $this->Users->find('all', ['conditions' => ['Users.email' => $this->request->data['email']]]);
			$user_check = $user_check->first();
			if (!empty($user_check)) {
				if($user_check->subscribed == 0){
					$response['isSucess'] = "true";
					$response['msg'] = "<div class='alert alert-success'><strong>Registered Successfully.</strong></div>";
					$response['url'] = "users/stripe/".$subscription_id ."/".$user_check->id;
				}else{
					$response['isSucess'] = "false";
					$response['msg'] = "<div class='alert alert-warning'><strong>'".$this->request->data['email']."' has been already subscribed. Please try again with another email address.</strong></div>";
				}
			}else {
				$post = $this->request->data;
				$post['status'] = '1';
				$post['role'] = 'guest';
				$user = $this->Users->patchEntity($user, $post);
				$new_user = $this->Users->save($user);
				if ($new_user) {
						$response['isSucess'] = "true";
						$response['msg'] = "<div class='alert alert-success'><strong>Registered Successfully.</strong></div>";
						$response['url'] = "users/stripe/".$subscription_id ."/".$new_user->id;
				}
				else {
					$response['isSucess'] = "false";
					$response['msg'] = "<div class='alert alert-success'><strong>Unable to Proceed. Try Again</strong></div>";
				}
			}
		}
		echo json_encode($response);
		exit;


    }

    public function plansuccess2()
    {
    	
    }
 
}

