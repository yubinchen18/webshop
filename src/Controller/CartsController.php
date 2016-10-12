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
    /**
     * Generates Ajax popup screen before add
     * @return boolean
     */
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
        if ($this->request->is('ajax') && !empty($this->request->data)) {
            $cartlineData = $this->request->data();
            $userId = ($this->Auth->user('id'));
            $response = [];
            $cart = $this->Carts->checkExistingCart($userId);
            $productOptions = (!empty($cartlineData['product_options'])) ? $cartlineData['product_options'] : [];
            $cartline = $this->Carts->Cartlines->checkExistingCartline($cart->id, $cartlineData['product_id'], $productOptions);
            $data = [
                'cart_id' => $cart->id,
                'photo_id' => $cartlineData['photo_id'],
                'product_id' => $cartlineData['product_id'],
                'quantity' => ($cartline->quantity) ? $cartline->quantity + (int)$cartlineData['quantity'] : (int)$cartlineData['quantity'],
                'options_hash' => md5(json_encode($productOptions))
            ];
            
            $this->Carts->Cartlines->patchEntity($cartline, $data);
            if (!$this->Carts->Cartlines->save($cartline)) {
                $response = ['message' => 'Could not save new cartline'];
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
                return;
            }

            //check if there are product options and save them
            $this->Carts->Cartlines->CartlineProductOptions->deleteAll(['cartline_id' => $cartline->id]);
            if (array_key_exists('product_options', $cartlineData) && !empty($cartlineData['product_options'])) {
                foreach ($cartlineData['product_options'] as $productOption) {
                    $cartlineProductoption = $this->Carts->Cartlines->CartlineProductoptions->newEntity();
                    $cartlineProductoption->cartline_id = $cartline->id;
                    $cartlineProductoption->productoption_choice_id = 
                        $this->Carts->Cartlines->Products->Productoptions->ProductoptionChoices
                            ->checkIdByName($productOption['name'], $productOption['value']);
                    if(!$this->Carts->Cartlines->CartlineProductoptions->save($cartlineProductoption)){
                        $response = 'Could not save product options to cartline';
                        $this->set(compact('response'));
                        $this->set('_serialize', 'response');
                        return;
                    }
                }
            }
            $response = ['message' => 'Cart successfully saved'];
            $this->set(compact('response'));
            $this->set('_serialize', 'response');
            return;
        }
        $response = ['message' => 'Invalid method error'];
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
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
