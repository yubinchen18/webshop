<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\BadRequestException;
use App\Lib\ImageHandler;
use Cake\Core\Configure;
use Cake\Utility\Hash;

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
            $cartlineData['discount_price'] = ($product->has_discount == 1) ? Configure::read('DiscountPrice') : 0;
            $this->set(compact('cartlineData'));
            $this->viewBuilder()->layout('ajax');
            return;
        }
        throw new BadRequestException();
    }
    
    /**
     * Add cartline into cart method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('ajax') && !empty($this->request->data)) {
            $cartlineData = $this->request->data();
            $cart = $this->Carts->checkExistingCart($this->Auth->user('id'));
            
            $personBarcode = (isset($cartlineData['person_barcode'])) ? $cartlineData['person_barcode'] : false;
            $digitalPack = (isset($cartlineData['digital_pack'])) ? $cartlineData['digital_pack'] : false;
            $response = [
                'success' => true,
                'message' => __('De foto is toegevoegd aan de winkelwagen'),
                'digital' => $digitalPack,
                'redirect' => $personBarcode,
            ];
            $productOptions = (!empty($cartlineData['product_options'])) ? $cartlineData['product_options'] : [];
                        
            $hash = json_encode($productOptions);
            $hash .= $cartlineData['product_id'];
            $hash .= $cartlineData['photo_id'];
            $hash = md5($hash);
 
            $giftFor = false;
            if (isset($cartlineData['digital_product']) || $personBarcode) {
                foreach ($cart->cartlines as $line) {
                    if ($personBarcode && $line->product->article === "DPack") {
                        $giftFor = $personBarcode;
                        break;
                    }
                    if ($digitalPack === $line->photo->barcode_id && $line->product->product_group === 'digital') {
                        if ($line->product->article !== "D1") {
                            $response = [
                                'success' => false,
                                'message' => __('Het pakket is al toegevoegd aan de winkelwagen')
                            ];
                            $this->set(compact('response'));
                            $this->set('_serialize', 'response');
                            return;
                        }
                        $this->Carts->Cartlines->delete($line);
                    }
                    if ($cartlineData['photo_id'] === $line->photo_id) {
                        $response = ['success' => true, 'message' => __('Het pakket is toegevoegd aan de winkelwagen')];
                        $this->set(compact('response'));
                        $this->set('_serialize', 'response');
                    }
                }
            }
            
            $cartline = $this->Carts->Cartlines->checkExistingCartline($cart->id, $hash);
            $cartline->gift_for = $giftFor;

            $data = [
                'cart_id' => $cart->id,
                'photo_id' => $cartlineData['photo_id'],
                'product_id' => $cartlineData['product_id'],
                'quantity' => ($cartline->quantity) ? $cartline->quantity + (int)$cartlineData['quantity']
                    : (int)$cartlineData['quantity'],
                'options_hash' => $hash
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
            
            //add cart count
            $cartCount = $this->Carts->getCartTotals($cart->id)['cartCount'];
            $response['cartCount'] = $cartCount;
            $this->set(compact('response'));
            $this->set('_serialize', 'response');
            return;
        }
        $response = ['success' => false, 'message' => __('Invalid method error')];
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }
    
    public function orderInfo()
    {
        if (!empty($this->request->session()->read('order'))) {
            $order = $this->request->session()->read('order');
            
            $this->request->data = $this->Carts->Orders->Invoiceaddresses->get($order->invoiceaddress_id);
            $this->request->data['paymentmethod'] = $order->payment_method;
            if ($order->invoiceaddress_id != $order->deliveryaddress_id) {
                $this->request->data['different-address'] = 1;
                $this->request->data['alternative'] = $this->Carts->Orders->Deliveryaddresses
                    ->get($order->deliveryaddress_id);
            }
        }
        $this->loadComponent('CakeIdeal.CakeIdeal', [
            'certificatesFolder' => ROOT . DS . 'plugins' . DS . 'CakeIdeal' . DS . 'config' . DS . 'certificates' . DS
        ]);
        
        $cart = $this->Carts->find('byUserid', ['user_id' => $this->Auth->user('id')])->first();
                
        $issuers = $this->CakeIdeal->sendDirectoryRequest();
        $this->set(compact('issuers', 'cart'));
    }
    
    public function confirm()
    {
        $data = $this->request->data;
        $dataJson = json_encode($data);
        $cart = $this->Carts->checkExistingCart($this->Auth->user('id'));
        $cart = $this->Carts->updatePrices($cart->id);
        $this->loadComponent('CakeIdeal.CakeIdeal', [
            'certificatesFolder' => ROOT . DS . 'plugins' . DS . 'CakeIdeal' . DS . 'config' . DS . 'certificates' . DS
        ]);
        $issuers = $this->CakeIdeal->sendDirectoryRequest();

        $orderSubtotal = 0;
        $groupSelectedArr = [];
        $totalDigitalPacks = 0;
        //add the orientation data to the photos array in cart
        if (!empty($cart->cartlines)) {
            foreach ($cart->cartlines as $cartline) {
                //add the orientation data to the photos array
                $filePath = $this->Carts->Cartlines->Photos
                    ->getPath($cartline->photo->barcode_id) . DS . $cartline->photo->path;
                $dimensions = getimagesize($filePath);
                if ($dimensions[0] > $dimensions[1]) {
                    $orientationClass = 'photos-horizontal';
                } else {
                    $orientationClass = 'photos-vertical';
                }
                $cartline->photo->orientationClass = $orientationClass;
                //create tmp product preview images
                $imageHandler = new ImageHandler();
                $filter = $this->Carts->Cartlines->getFilter($cartline->id);
                $image = $imageHandler->createProductPreview($cartline->photo, $cartline->product->product_group, [
                    'resize' => ['width' => 200, 'height' => 180],
                    'layout' => !empty($cartline->product->layout) ? $cartline->product->layout : 'all',
                    'filter' => $filter
                ]);
                //add the image data to product object and calc subtotal price
                $cartline->product->image = $image[0];
                $cartline->discountPrice = Configure::read('DiscountPrice');
                if (!empty($userDiscounts[$cartline->photo->barcode->person->user_id])
                    && $cartline->product->has_discount === 1) {
                    $cartline->product->price_ex = Configure::read('DiscountPrice');
                }
                
                if ($cartline->product->has_discount === 1) {
                    $userDiscounts[$cartline->photo->barcode->person->user_id] = true;
                }
                
                if ($cartline->product->article === "DPack") {
                    $totalDigitalPacks++;
                }
                if ($cartline->product->article === "GAF 13x19") {
                    $groupSelectedArr[$cartline->gift_for] = true;
                }
            }
        }
        
        $totals = $this->Carts->getCartTotals($cart->id);
        $orderSubtotal = $totals['products'];
        $shippingCost = $totals['shippingcosts'];
        $orderTotal = $orderSubtotal + $shippingCost;
        $discount = $totals['discount'];
        $freeGroupPicturesSelected = (count($groupSelectedArr) >= $totalDigitalPacks) ? true : false;

        $this->set(compact(
            'cart',
            'discount',
            'orderSubtotal',
            'orderTotal',
            'shippingCost',
            'freeGroupPicturesSelected',
            'groupSelectedArr',
            'data',
            'dataJson',
            'issuers'
        ));
    }
    
    public function zipcode($zipcode = null)
    {
        $uri = 'https://postcode-api.apiwise.nl/v2/addresses?postcode='.$zipcode;
        $apiKey = 'ab5paH09Er69bseA1fJnF6G94r0pV1Kg9G4Gv9p8';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Api-Key: ' . $apiKey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        if (empty($response)) {
            die;
        }
        $firstAddress = isset($response['_embedded']['addresses'][0]) ? $response['_embedded']['addresses'][0] : false;
        $return = array(
                'success' => (bool) $firstAddress,
            'street' => !empty($firstAddress['street']) ? $firstAddress['street'] : '',
            'town' => !empty($firstAddress['city']['label']) ? $firstAddress['city']['label'] : ''
        );

        echo json_encode($return);
        die;
    }
    
    public function display()
    {
        $cart = $this->Carts->checkExistingCart($this->Auth->user('id'));
        $cart = $this->Carts->updatePrices($cart->id);

        $orderSubtotal = 0;
        $groupSelectedArr = [];
        $totalDigitalPacks = 0;
        //add the orientation data to the photos array in cart
        if (!empty($cart->cartlines)) {
            foreach ($cart->cartlines as $cartline) {
                //add the orientation data to the photos array
                $filePath = $this->Carts->Cartlines->Photos
                    ->getPath($cartline->photo->barcode_id) . DS . $cartline->photo->path;
                $dimensions = getimagesize($filePath);
                if ($dimensions[0] > $dimensions[1]) {
                    $orientationClass = 'photos-horizontal';
                } else {
                    $orientationClass = 'photos-vertical';
                }
                $cartline->photo->orientationClass = $orientationClass;
                //create tmp product preview images
                $imageHandler = new ImageHandler();
                $filter = $this->Carts->Cartlines->getFilter($cartline->id);
                $image = $imageHandler->createProductPreview($cartline->photo, $cartline->product->product_group, [
                    'resize' => ['width' => 200, 'height' => 180],
                    'layout' => !empty($cartline->product->layout) ? $cartline->product->layout : 'all',
                    'filter' => $filter
                ]);
                //add the image data to product object and calc subtotal price
                if ($cartline->product->product_group === 'funproducts') {
                    $productImage = $cartline->product->image;
                    $cartline->product->image = $image[0];
                    $cartline->product->image['product_image'] = $productImage;
                } else {
                    $cartline->product->image = $image[0];
                }
                        
                $cartline->discountPrice = Configure::read('DiscountPrice');
                if (!empty($userDiscounts[$cartline->photo->barcode->person->user_id])
                    && $cartline->product->has_discount === 1) {
                    $cartline->product->price_ex = Configure::read('DiscountPrice');
                }
                
                if ($cartline->product->has_discount === 1) {
                    $userDiscounts[$cartline->photo->barcode->person->user_id] = true;
                }
                
                if ($cartline->product->article === "DPack") {
                    $totalDigitalPacks++;
                }
                if ($cartline->product->article === "GAF 13x19") {
                    $groupSelectedArr[$cartline->gift_for] = true;
                }
            }
        }
        
        $totals = $this->Carts->getCartTotals($cart->id);
        $orderSubtotal = $totals['products'];
        $shippingCost = $totals['shippingcosts'];
        $orderTotal = $orderSubtotal + $shippingCost;
        $discount = $totals['discount'];
        $freeGroupPicturesSelected = (count($groupSelectedArr) >= $totalDigitalPacks) ? true : false;

        $this->set(compact(
            'cart',
            'discount',
            'orderSubtotal',
            'orderTotal',
            'shippingCost',
            'freeGroupPicturesSelected',
            'groupSelectedArr'
        ));
    }
        
    public function update()
    {
        if ($this->request->is('ajax') && !empty($this->request->data)) {
            $postData = $this->request->data();
            $cartline = $this->Carts->Cartlines->find()
                ->where(['Cartlines.id' => $postData['cartline_id']])
                ->contain(['Products'])
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
            
            $this->Carts->Cartlines->save($cartline, ['quantity' => $postData['cartline_quantity']]);
            $cart = $this->Carts->updatePrices($cartline->cart_id);
            $cartTotals = $this->Carts->getCartTotals($cart->id);
            
            $response = [
                'success' => true,
                'message' => 'Cartline successfully updated',
                'cart' => $cart,
                'cartCount' => $cartTotals['cartCount'],
                'discountPrice' => Configure::read('DiscountPrice'),
                'orderSubtotal' => $cartTotals['products'],
                'orderTotal' => $cartTotals['products']+$cartTotals['shippingcosts'],
                'shippingCost' => $cartTotals['shippingcosts']
            ];
            $this->set(compact('response'));
            $this->set('_serialize', 'response');
            return;
        }
        
        $response = ['success' => false, 'message' => __('Invalid method error')];
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }
    
    public function updateFreeProductInCartline()
    {
        if (($this->request->is('ajax') || $this->request->is('post')) && !empty($this->request->data)) {
            $postData = $this->request->data();
            $cartline = $this->Carts->Cartlines->find()
                ->where(['Cartlines.id' => $postData['cartline_id']])
                ->first();
            
            if (empty($cartline)) {
                $response = ['success' => false];
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
                return;
            };
            
            $cartline->photo_id = $postData['cartline_photo_id'];
            if (!$this->Carts->Cartlines->save($cartline)) {
                $response = ['success' => false];
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
                return;
            }
            
            $this->setAction('display');
        }
    }
    
    public function delete($id)
    {
        $line = $this->Carts->Cartlines->find()
                ->contain(['Products'])
                ->where(['Cartlines.id' => $id])
                ->first();

        if (!empty($line->id)) {
            $this->Carts->Cartlines->delete($line);
            if ($line->product->article === "DPack") {
                $cart = $this->Carts->checkExistingCart($this->Auth->user('id'));
                foreach ($cart->cartlines as $cartline) {
                    if ("GAF 13x19" === $cartline->product->article) {
                        $this->Carts->Cartlines->delete($cartline);
                        $removeGroup = $cartline->id;
                    }
                }
            }
            $cartTotals = $this->Carts->getCartTotals($line->cart_id);
            $response = [
                'success' => true,
                'message' => 'Cartline deleted',
                'orderSubtotal' => $cartTotals['products'],
                'orderTotal' => $cartTotals['products']+$cartTotals['shippingcosts'],
                'shippingCost' => $cartTotals['shippingcosts'],
                'cartCount' => $cartTotals['cartCount']
            ];
            $response['removeGroup'] = (isset($removeGroup)) ? $removeGroup : "";
            $this->set(compact('response'));
            $this->set('_serialize', 'response');
        }
    }
}
