<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Cart;


/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 */
class CartsController extends AppController
{
    public function beforeAdd() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $cartlineData = $this->request->data('cartline');
            $this->set(compact('cartlineData'));
            $this->viewBuilder()->layout('ajax');
            $this->render('/Element/Frontend/addToCartPopup');
        } else {
            return false;
        }
    }
    
    public function addToCart() {
        if ($this->request->is('ajax') && !empty($this->request->data)) {
            $cartlineData = $this->request->data();
            $userId = ($this->Auth->user('id'));
            
            // get the user and cart
            $user = $this->Carts->Users->find()
                    ->where(['Users.id' => $userId])
                    ->contain(['Carts'])
                    ->first();

            if (empty($user->cart)) {
                $cart = $this->Carts->newEntity();
                $cart->user_id = $userId;
                
                $error = true;
                if ($this->Carts->save($cart)) {
                    $user = $this->Carts->Users->find()
                    ->where(['Users.id' => $userId])
                    ->contain(['Carts'])
                    ->first();
                    $error = false;
                }
            }
            
            // check current cartline to edit in
            $cartline = $this->Carts->Cartlines->find()
                    ->where([
                        'cart_id' => $user->cart->id,
                        'product_id' => $cartlineData['product_id']
                    ])
                    ->contain(['CartlineProductoptions.ProductoptionChoices'])
                    ->first();
            
            if (empty($cartline)) {
                $cartline = $this->Carts->Cartlines->newEntity();
            }
            
            // save cartline
//            $cartline->cart_id = $user->cart->id;
//            $cartline->photo_id = $cartlineData['photo_id'];
//            $cartline->product_id = $cartlineData['product_id'];
//            $cartline->quantity = $cartlineData['quantity'];
            
            $data = [
                'cart_id' => $user->cart->id,
                'photo_id' => $cartlineData['photo_id'],
                'product_id' => $cartlineData['product_id'],
                'quantity' => (int)$cartlineData['quantity']
            ];
            
            debug($cartline);
            $this->Carts->Cartlines->patchEntity($cartline, $data);
            if ($this->Carts->Cartlines->save($cartline)) {
                debug($cartline);
                $this->Carts->Cartlines->CartlineProductOptions->deleteAll(['cartline_id' => $cartline->id]);
                
                //check if there are product options and save them
                if (array_key_exists('product_options', $cartlineData) && !empty($cartlineData['product_options'])) {
                    foreach ($cartlineData['product_options'] as $productOption) {
                        $cartlineProductoption = $this->Carts->Cartlines->CartlineProductoptions->newEntity();
                        $cartlineProductoption->cartline_id = $cartline->id;
                        $cartlineProductoption->productoption_choice_id = 
                            $this->Carts->Cartlines->Products->Productoptions->ProductoptionChoices->find()
                                ->select('id')
                                ->where([
                                    'productoption_id' => $this->Carts->Cartlines->Products->Productoptions->find()
                                        ->select('id')
                                        ->where(['name' => $productOption['name']])
                                        ->first()
                                        ->id,
                                    'value' => $productOption['value']
                                ])
                                ->first()
                                ->id;
                        
                        $this->Carts->Cartlines->CartlineProductoptions->save($cartlineProductoption);
                    }
                }
            $error = false;    
            }
        }
        
        $response = $this->Carts->find()
                ->where(['id' => $user->cart->id])
                ->contain(['Cartlines.CartlineProductoptions'])
                ->first();
        
        debug($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }
    
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $carts = $this->paginate($this->Carts);

        $this->set(compact('carts'));
        $this->set('_serialize', ['carts']);
    }

    /**
     * View method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => []
        ]);

        $this->set('cart', $cart);
        $this->set('_serialize', ['cart']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cart = $this->Carts->newEntity();
        if ($this->request->is('post')) {
            $cart = $this->Carts->patchEntity($cart, $this->request->data);
            if ($this->Carts->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cart could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('cart'));
        $this->set('_serialize', ['cart']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cart = $this->Carts->patchEntity($cart, $this->request->data);
            if ($this->Carts->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cart could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('cart'));
        $this->set('_serialize', ['cart']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cart = $this->Carts->get($id);
        if ($this->Carts->delete($cart)) {
            $this->Flash->success(__('The cart has been deleted.'));
        } else {
            $this->Flash->error(__('The cart could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
