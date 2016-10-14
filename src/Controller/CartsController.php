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
    public function beforeAdd()
    {
        if ($this->request->is('ajax') && !empty($this->request->data)) {
            $cartlineData = $this->request->data('cartline');
            $this->set(compact('cartlineData'));
            $this->viewBuilder()->layout('ajax');
            return;
        }
        return false;
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
            $response = ['success' => true, 'message' => __('De foto is toegevoegd aan de winkelwagen')];
            $cart = $this->Carts->checkExistingCart($this->Auth->user('id'));
            $productOptions = (!empty($cartlineData['product_options'])) ? $cartlineData['product_options'] : [];
            $cartline = $this->Carts->Cartlines
                ->checkExistingCartline($cart->id, $cartlineData['product_id'], $productOptions);
            $data = [
                'cart_id' => $cart->id,
                'photo_id' => $cartlineData['photo_id'],
                'product_id' => $cartlineData['product_id'],
                'quantity' => ($cartline->quantity) ? $cartline->quantity + (int)$cartlineData['quantity']
                    : (int)$cartlineData['quantity'],
                'options_hash' => md5(json_encode($productOptions))
            ];
            
            $this->Carts->Cartlines->patchEntity($cartline, $data);
            if (!$this->Carts->Cartlines->save($cartline)) {
                $response = ['success' => false, 'message' => __('Could not save new cartline')];
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
                    if (!$this->Carts->Cartlines->CartlineProductoptions->save($cartlineProductoption)) {
                        $response = ['success' => false, 'message' => __('Could not save product options to cartline')];
                        $this->set(compact('response'));
                        $this->set('_serialize', 'response');
                        return;
                    }
                }
            }
            $response = ['success' => true,'message' => __('De foto is toegevoegd aan de winkelwagen')];
            $this->set(compact('response'));
            $this->set('_serialize', 'response');
            return;
        }
        $response = ['message' => 'Invalid method error'];
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }
}
