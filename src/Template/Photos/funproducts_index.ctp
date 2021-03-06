<div class="row full-width">
    <!-- left panel -->
    <div class="photos-product-index col-md-8 col-xs-9">
        <?= $this->Flash->render(); ?>
        
        <!-- left pics panel -->
        <div class="row">
             <div class='col-sm-11 col-xs-12'>
                <div class="row">
                    <h2 class='col-xs-12'><?= __('Fotocadeaus') ?></h2>
                </div>
            </div>
        </div>
        
        <div class='row'>
            <div class='col-sm-11 col-xs-12'>
                <div class="row">
                    <div class='addToCartPopup-confirmation col-md-4 col-xs-5 alert'>
                        <span id='msg'></span>
                    </div>
                    <?php foreach ($products as $product): ?>
                        <div class="photos-product-container fun-product col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="photos-product-label col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="flex-box price col-xs-2">
                                            <?= $this->Number->currency($product->price_ex, 'EUR'); ?>
                                            <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-21.png', [
                                                'class' => 'plus-sign',
                                                'data-cartline' => json_encode([
                                                    'photo_id' => $photo->id,
                                                    'product_id' => $product->id,
                                                    'product_price' => $product->price_ex,
                                                    'product_name' => $product->name,
                                                    'product_options' => ''
                                                ]),
                                            ])?>
                                        </div>
                                        <div class="flex-box dimensions col-xs-10">
                                            <?= $product->name; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="photos-product-details">
                                    <div class="flex-box product-image-container col-xs-5">
                                        <div class="row">
                                            <div class="flex-box product-image col-xs-8">
                                                <?= $this->Html->image('layout/funartikelen/'.$product->image,
                                                    array('class' => 'img-responsive')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-box product-description col-xs-6">
                                        <?= $product->description; ?>
                                    </div>
                                    <div class="flex-box col-xs-1"></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Right products panel -->
    <?= $this->element('Frontend/productsPanel', ['photo' => $photo]); ?>
</div>
