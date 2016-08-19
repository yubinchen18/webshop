<div class="photos-view-row row">
    <div class="photos-view-detail col-sm-8">
        <h2><?= __('Combinatievellen') ?></h2>
        <?php if (isset($person)): ?>
            <?php $p = 0; $count = count($images); ?>
            <?php foreach ($images as $image): ?>
                <?php $p++; ?>
                <?php if ($p % 3 == 1): ?>
                <div class="row">
                <?php endif; ?>
                    <div class="col-xs-4 container photo-container">
                        <div class="<?= 'photos-vertical'.' '.'photos-vertical-background' ?>">
                        </div>
                            <?= $this->Html->image($this->Url->build([
                                'controller' => 'Photos',
                                'action' => 'displayProduct',
                                'layout' => $image['layout'],
                                'id' => $photo->id,
                                'suffix' => $image['suffix']
                            ]), ['class' => ['photos-vertical', 'img-responsive']]); ?>
                    </div>
                <?php if ($p % 3 == 0 || $p == ($count)) : ?>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif ?>
    </div>
    <div class="photos-view-products col-sm-4">
        <div class='row photos-view-products-row'>
            <div class='photos-view-products-panel col-sm-12'>
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
                                'action' => 'display',
                                'id' => $photo->id,
                                'size' => 'thumbs'
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
                        <!--    <?php for ($i = 1; $i < 8; $i++): ?>
                            <?= $this->Html->image($this->Url->build([
                                'controller' => 'Photos',
                                'action' => 'display',
                                'id' => $photo->id,
                                'size' => 'thumbs'
                            ]), ['class' => [$photo->orientationClass.'-combi-'.$i, 'img-responsive']]); ?>
                            <?php endfor; ?>-->
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
