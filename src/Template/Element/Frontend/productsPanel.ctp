<div class="photos-view-products col-md-4 col-xs-3">
    <div class='row photos-view-products-row'>
        <div class='photos-view-products-panel col-sm-12'>
            <div class="row">
                <div class="photos-view-products-container col-md-6">
                    <?php if ($photo->orientationClass == 'photos-horizontal') {
                        $layer1Name = 'layout/Hoogstraten_navigatie rechts-01-horizontal.png';
                        $layer2Name = 'layout/Hoogstraten_navigatie rechts-02-horizontal.png';
                        $layer3Name = 'layout/Hoogstraten_navigatie rechts-04-horizontal.png';
                    } else {
                        $layer1Name = 'layout/Hoogstraten_navigatie rechts-01-vertical.png';
                        $layer2Name = 'layout/Hoogstraten_navigatie rechts-02-vertical.png';
                        $layer3Name = 'layout/Hoogstraten_navigatie rechts-04-vertical.png';
                    }; ?>
                    <div class="photos-view-products-labels label1 text-center vertical-center">
                        <span><?= __('Losse afdrukken') ?></span>
                    </div>
                    <div class="photos-view-products-icon">
                        <?= $this->Html->image($this->Url->build([
                            'controller' => 'Photos',
                            'action' => 'display',
                            'id' => $photo->id,
                            'size' => 'thumbs'
                        ]), ['class' => [$photo->orientationClass, 'img-responsive']]); ?>
                        <?= $this->Html->image($layer1Name, [
                            'url' => $this->Url->build([
                                'controller' => 'Photos', 
                                'action' => 'productGroupIndex',
                                'loose-prints', 
                                $photo->id
                            ]),
                            'class' => [$photo->orientationClass.' '.$photo->orientationClass.'-overlay']
                        ]); ?>
                    </div>
                </div>
                <div class="photos-view-products-container  col-md-6">
                    <div class="photos-view-products-labels label2 text-center">
                        <span><?= __('Fotocadeaus') ?></span>
                    </div>
                    <div class="photos-view-products-icon">
                        <?= $this->Html->image($this->Url->build([
                            'controller' => 'Photos',
                            'action' => 'display',
                            'id' => $photo->id,
                            'size' => 'thumbs'
                        ]), ['class' => [$photo->orientationClass, 'img-responsive']]); ?>
                        <?= $this->Html->image($layer2Name, [
                            'url' => $this->Url->build([
                               'controller' => 'Photos',
                                'action' => 'productGroupIndex',
                                'funproducts',
                                $photo->id
                            ]),
                            'class' => [$photo->orientationClass.' '.$photo->orientationClass.'-overlay']
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="photos-view-products-container col-md-6">
                    <div class="photos-view-products-labels label3 text-center vertical-center">
                        <span><?= __('Combinatievellen') ?></span>
                    </div>
                    <div class="photos-view-products-icon">
                        <?= $this->ImageHandler->createProductPreview($photo, [
                            'alt' => $photo->path,
                            'url' => $this->Url->build([
                                'controller' => 'Photos', 
                                'action' => 'productGroupIndex',
                                'combination-sheets', 
                                $photo->id
                            ]),
                            'class' => [$photo->orientationClass, 'img-responsive']
                        ]); ?>
                    </div>
                </div>
                <div class="photos-view-products-container  col-md-6">
                    <div class="photos-view-products-labels label4 text-center">
                        <span><?= __('Digitale downloads') ?></span>
                    </div>
                    <div class="photos-view-products-icon">
                        <?= $this->Html->image('layout/Hoogstraten_navigatie rechts-03.png', [
                            'class' => [$photo->orientationClass, 'img-responsive']
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="photos-view-products-container col-md-6">
                    <div class="photos-view-products-labels label5 text-center">
                        <span><?= __('Canvas') ?></span>
                    </div>
                    <div class="photos-view-products-icon">
                        <?= $this->Html->image($this->Url->build([
                            'controller' => 'Photos',
                            'action' => 'display',
                            'id' => $photo->id,
                            'size' => 'thumbs'
                        ]), ['class' => [$photo->orientationClass, 'img-responsive']]); ?>
                        <?= $this->Html->image($layer3Name, [
                            'url' => $this->Url->build([
                                'controller' => 'Photos', 
                                'action' => 'productGroupIndex',
                                'canvas',
                                $photo->id
                            ]),
                            'class' => [$photo->orientationClass.' '.$photo->orientationClass.'-overlay']
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
