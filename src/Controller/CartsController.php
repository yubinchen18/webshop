<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\BadRequestException;
use App\Lib\ImageHandler;

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
            
            $this->loadModel('Products');
            $product = $this->Products->get($this->request->data['cartline']['product_id']);
            $cartlineData = $this->request->data('cartline');
            $cartlineData['discount_price'] = ($product->has_discount == 1) ? 3.78 : 0;
            $this->set(compact('cartlineData'));
            $this->viewBuilder()->layout('ajax');
            return;
        }
        throw new BadRequestException();
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
        $response = ['success' => false, 'message' => __('Invalid method error')];
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }
    
    public function display()
    {
        $cart = $this->Carts->checkExistingCart($this->Auth->user('id'));
        $orderSubtotal = 0;
        
        //add the orientation data to the photos array in cart
        if (!empty($cart->cartlines)) {
            
            foreach ($cart->cartlines as $cartline) {
                //add the orientation data to the photos array
                $filePath = $this->Carts->Cartlines->Photos->getPath($cartline->photo->barcode_id) . DS . $cartline->photo->path;
                $dimensions = getimagesize($filePath);
                if ($dimensions[0] > $dimensions[1]) {
                    $orientationClass = 'photos-horizontal';
                } else {
                    $orientationClass = 'photos-vertical';
                }
                $cartline->photo->orientationClass = $orientationClass;
                //create tmp product preview images
                $imageHandler = new ImageHandler();
                $image = $imageHandler->createProductPreview($cartline->photo, $cartline->product->product_group, [
                    'resize' => ['width' => 200, 'height' => 180],
                    'layout' => $cartline->product->layout
                ]);
                //add the image data to product object and calc subtotal price
                $cartline->product->image = $image[0];
                $cartline->subtotal = $cartline->quantity * $cartline->product->price_ex;
                $orderSubtotal = $orderSubtotal + $cartline->subtotal;
                $shippingCost = 3.95;
                $orderTotal = $orderSubtotal + $shippingCost;
            }
        }
        
        $this->set(compact('cart', 'orderSubtotal', 'orderTotal', 'shippingCost'));
    }
    
    public function update()
    {
        if ($this->request->is('ajax') && !empty($this->request->data)) {
            $postData = $this->request->data();
            $cartline = $this->Carts->Cartlines->find()
                ->where(['Cartlines.id' => $postData['cartline_id']])
                ->first();
            
            if (empty($cartline)) {
                $response = ['success' => false, 'message' => __('Cartline not found')];
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
                return;
            };
            
            $cartline->quantity = $postData['cartline_quantity'];
            if (!$this->Carts->Cartlines->save($cartline)) {
                $response = ['success' => false, 'message' => __('Could not save cartline')];
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
                return;
            }
            
            $newCartline = $this->Carts->Cartlines->find()
                ->where(['Cartlines.id' => $postData['cartline_id']])
                ->contain(['Products', 'Carts.Cartlines.Products'])
                ->first();
            
            $newCartline->subtotal = $newCartline->product->price_ex * $newCartline->quantity;
            
            //price calculations;
            $shippingCost = 3.95;
            $orderSubtotal = 0;
            foreach ($newCartline->cart->cartlines as $allCartline) {
                $newSubtotal = $allCartline->product->price_ex * $allCartline->quantity;
                $orderSubtotal += $newSubtotal;
            };
            $orderTotal = $orderSubtotal + $shippingCost;
            $response = [
                'success' => true,
                'message' => 'Cartline successfully updated',
                'cartline' => $newCartline,
                'orderSubtotal' => $orderSubtotal,
                'orderTotal' => $orderTotal,
                'shippingCost' => $shippingCost
            ];
            $this->set(compact('response'));
            $this->set('_serialize', 'response');
            return;
        }
        
        $response = ['success' => false, 'message' => __('Invalid method error')];
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }
    
    public function orderInfo() {
    }
}
