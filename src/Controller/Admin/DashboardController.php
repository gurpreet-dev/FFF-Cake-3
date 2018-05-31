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

class DashboardController extends AppController

{

	public function beforeFilter(Event $event) {

        parent::beforeFilter($event);

        if ($this->request->params['prefix'] == 'admin') {

            $this->viewBuilder()->setLayout('admin');

        }

        $this->Auth->allow(['logout']);

        $this->authcontent();

    }



	public function index(){

		$this->loadModel('Users');
		$this->loadModel('Reviews');
		
		$users = $this->Users->find('all',[
			'conditions' => ['Users.status' => 1]
		])->all()->toArray();
		
		$this->set('users', $users);
		$this->set('_serialize', ['users']);
		
		$subscribed = $this->Users->find('all',[
			'conditions' => ['Users.subscribed' => '1', 'Users.status' => 1]
		])->all()->toArray();
		
		$this->set('subscribed', $subscribed);
		$this->set('_serialize', ['subscribed']);
		
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
		
		$this->set('products', $products);
		$this->set('_serialize', ['products']);
		
		$reviews = $this->Reviews->find()->toArray();
		
		$this->set('reviews', $reviews);
		$this->set('_serialize', ['reviews']);
		
		
		$members = $this->Users->find('all',[
			'conditions' => ['Users.status' => 1],
			'order'		=> ['Users.id' => 'desc'],
			'limit'		=>	8
		])->all()->toArray();
		
		$this->set('members', $members);
		$this->set('_serialize', ['members']);
		
		$reviewslist = $this->Reviews->find('all',[
			'contain' => ['Users']
		])->all()->toArray();
		
		$this->set('reviewslist', $reviewslist);
		$this->set('_serialize', ['members']);

	}
}