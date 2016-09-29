<div class="row">
    <!-- left panel -->
    <div class="photos-product-index col-md-8 col-xs-9">
        <!-- left pics panel -->
        <div class='row'>
            <div class='col-sm-11 col-xs-12'>
                <div class="row">
                    <h2 class='col-xs-12'><?= __('Losse afdrukken') ?></h2>
                    <!-- top buttons panel xs only -->
                    <div class='col-xs-12 hidden-lg hidden-md hidden-sm photos-view-buttons-panel-top'>
                        <div class='photos-view-buttons-box1-top'>
                            <div class='photos-view-buttons-button'>
                                <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-25.png', [
                                    'class' => ['img-responsive']
                                ]); ?>
                            </div>
                            <div class='photos-view-buttons-button'>
                                <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-26.png', [
                                    'class' => ['img-responsive']
                                ]); ?>
                            </div>
                        </div>
                        <div class='photos-view-buttons-box2-top'>
                            <div class='photos-view-buttons-button'>
                                <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-31.png', [
                                    'class' => ['img-responsive']
                                ]); ?>
                            </div>
                            <div class='photos-view-buttons-button'>
                                <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-32.png', [
                                    'class' => ['img-responsive']
                                ]); ?>
                            </div>
                            <div class='photos-view-buttons-button'>
                                <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-33.png', [
                                    'class' => ['img-responsive']
                                ]); ?>
                            </div>
                            <div class='photos-view-buttons-button'>
                                <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-34.png', [
                                    'class' => ['img-responsive']
                                ]); ?>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 col-xs-6 photos-product-container">
                            <div class="photos-product-label">
                                <div class="row">
                                    <div class="flex-box price col-xs-5">
                                        <?= $this->Number->currency($product->price_ex, 'EUR'); ?>
                                        <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-21.png', ['class' => 'plus-sign'])  ?>
                                    </div>
                                    <div class="flex-box dimensions col-xs-7">
                                        <?php $size = explode('_', $product->slug); ?>
                                        <?= $size[1] . ' cm'?>
                                    </div>
                                </div>
                            </div>
                            <div class="photos-product-icon">
                                <div class="<?= $photo->orientationClass.' '.$photo->orientationClass.'-background' ?>">
                                </div>
                                    <?= $this->Html->image($this->Url->build([
                                        'controller' => 'Photos',
                                        'action' => 'displayProduct',
                                        'layout' => $product->layout,
                                        'id' => $photo->id,
                                        'suffix' => $product->image['suffix'],
                                    ]), ['class' => [$photo->orientationClass, 'img-responsive']]); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- right buttons panel -->
            <div class='col-sm-1 hidden-xs photos-view-buttons-panel'>
                <div class='photos-view-buttons-box1'>
                    <div class='photos-view-buttons-button'>
                        <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-25.png', [
                            'class' => ['img-responsive']
                        ]); ?>
                    </div>
                    <div class='photos-view-buttons-button'>
                        <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-26.png', [
                            'class' => ['img-responsive']
                        ]); ?>
                    </div>
                </div>
                <div class='photos-view-buttons-box2'>
                    <div class='photos-view-buttons-button'>
                        <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-31.png', [
                            'class' => ['img-responsive']
                        ]); ?>
                    </div>
                    <div class='photos-view-buttons-button'>
                        <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-32.png', [
                            'class' => ['img-responsive']
                        ]); ?>
                    </div>
                    <div class='photos-view-buttons-button'>
                        <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-33.png', [
                            'class' => ['img-responsive']
                        ]); ?>
                    </div>
                    <div class='photos-view-buttons-button'>
                        <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-34.png', [
                            'class' => ['img-responsive']
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Right products panel -->
    <?= $this->element('Frontend/productsPanel', ['photo' => $photo]); ?>
</div>
