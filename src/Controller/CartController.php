<?php

namespace App\Controller;

use Cake\Core\Configure;

use Cake\Network\Exception\ForbiddenException;

use Cake\Network\Exception\NotFoundException;

use Cake\View\Exception\MissingTemplateException;

use Cake\Event\Event;



class CartController extends AppController

{

	public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index', 'add', 'update', 'remove']);
        $this->authcontent();
    }

    public function index(){
        $session = $this->request->session();

        if($session->read('cartdata')){
            $cartdata = $session->read('cartdata');
        }else{
            $cartdata = array();
        }

        $this->set(compact('cartdata'));
        $this->set('_serialize', ['cartdata']);
    }

    public function add(){

        if ($this->request->is(['patch', 'post', 'put'])) {

            $session = $this->request->session();

            if($session->read('cartdata')){
                $data = $session->read('cartdata');
            }else{
                $data = array();
            }

            $data = $session->read('cartdata');

            $data[$this->request->data['asin']] = [
                'title' =>  $this->request->data['title'],
                'asin'  =>  $this->request->data['asin'],
                'image' =>  $this->request->data['image'],
                'qty'   =>  $this->request->data['quantity'],
                'price' =>  12.50
            ];

            $session->write('cartdata', $data);

            $cartdata = $session->read('cartdata');

            echo count($cartdata);
            exit;

        }

    }

    public function update($asin = null, $qty = null){

        $session = $this->request->session();

        $data = $session->read('cartdata');

        $data[$asin]['qty'] = $qty;

        $session->write('cartdata', $data);

        $product_price = $data[$asin]['qty'] * $data[$asin]['price'];

        $total_price = 0;

        foreach($data as $cart){
            $total_price = $total_price + ($cart['qty'] * $cart['price']);
        }

        $json = [
            'product_price' =>  $product_price,
            'total_price'   =>  $total_price
        ];

        echo json_encode($json);
        exit;
    }

    public function remove($asin = null){

        $session = $this->request->session();

        $data = $session->read('cartdata');

        unset($data[$asin]);

        $session->write('cartdata', $data);

        return $this->redirect(['action' => 'index']);

    }

}

