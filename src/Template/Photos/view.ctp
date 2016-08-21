<div class="photos-view-row row">
    <div class="photos-view-detail col-sm-6">
        <div class="row">
            <div class="container photos-view-detail-container col-xs-6">
                <div class="<?= $photo->orientationClass.' '.$photo->orientationClass.'-background' ?>">
                </div>
                <?= $this->Html->image($this->Url->build([
                        'controller' => 'Photos',
                        'action' => 'display',
                        'id' => $photo->id,
                        'size' => 'med'
                    ]), ['class' => [$photo->orientationClass, 'img-responsive']]); ?>
            </div>
            <div class='photos-view-detail-text'>
                <h3><?= __('1e opname per kind op 13x19 €5,95<br>iedere volgende 13x19 van uw kind €3,29') ?></h3>
            </div>
        </div>
    </div>
    <div class="photos-view-products col-sm-6">
        <div class='row photos-view-products-row'>
            <!-- Large screen -->
            <div class="photos-view-products-buttons-md col-md-4 hidden-sm hidden-xs">
                <div class="photos-view-products-select">
                    <h3><?= __('Selecteer<br>een product >') ?></h3>
                </div>
            </div>
            <!-- Medium screen -->
            <div class="photos-view-products-buttons-sm col-sm-4 hidden-lg hidden-md hidden-xs">
                <div class="photos-view-products-select">
                    <h3><?= __('Selecteer<br>een product >') ?></h3>
                </div>
            </div>
            <!-- Small screen -->
            <div class="photos-view-products-buttons-xs col-xs-4 hidden-sm hidden-md hidden-lg">
                <div class="photos-view-products-select">
                    <h3><?= __('Selecteer<br>een product >') ?></h3>
                </div>
            </div>
            <!-- right product group panel -->
            <div class='photos-view-products-panel col-sm-8'>
                <div class="row">
                    <div class="photos-view-products-container col-xs-6">
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
                            <?php if ($photo->orientationClass == 'photos-horizontal') : ?>
                                <?= $this->Html->image('layout/Hoogstraten_navigatie rechts-01-horizontal.png', [
                                    'class' => [$photo->orientationClass.' '.$photo->orientationClass.'-overlay']
                                ]); ?>
                            <?php else: ?>
                                <?= $this->Html->image('layout/Hoogstraten_navigatie rechts-01-vertical.png', [
                                    'class' => [$photo->orientationClass.' '.$photo->orientationClass.'-overlay']
                                ]); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="photos-view-products-container  col-xs-6">
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
                            <?php if ($photo->orientationClass == 'photos-horizontal') : ?>
                                <?= $this->Html->image('layout/Hoogstraten_navigatie rechts-02-horizontal.png', [
                                    'class' => [$photo->orientationClass.' '.$photo->orientationClass.'-overlay']
                                ]); ?>
                            <?php else: ?>
                                <?= $this->Html->image('layout/Hoogstraten_navigatie rechts-02-vertical.png', [
                                    'class' => [$photo->orientationClass.' '.$photo->orientationClass.'-overlay']
                                ]); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="photos-view-products-container col-xs-6">
                        <div class="photos-view-products-labels label3 text-center vertical-center">
                            <span><?= __('Combinatievellen') ?></span>
                        </div>
                        <div class="photos-view-products-icon">
                            <?= $this->Html->image($this->Url->build([
                                'controller' => 'Photos',
                                'action' => 'displayProduct',
                                'layout' => $combinationSheetThumb[0]['layout'],
                                'id' => $photo->id,
                                'suffix' => $combinationSheetThumb[0]['suffix']
                            ]), [
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
                    <div class="photos-view-products-container  col-xs-6">
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
                    <div class="photos-view-products-container col-xs-6">
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
                            <?php if ($photo->orientationClass == 'photos-horizontal') : ?>
                                <?= $this->Html->image('layout/Hoogstraten_navigatie rechts-04-horizontal.png', [
                                    'class' => [$photo->orientationClass.' '.$photo->orientationClass.'-overlay']
                                ]); ?>
                            <?php else: ?>
                                <?= $this->Html->image('layout/Hoogstraten_navigatie rechts-04-vertical.png', [
                                    'class' => [$photo->orientationClass.' '.$photo->orientationClass.'-overlay']
                                ]); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>