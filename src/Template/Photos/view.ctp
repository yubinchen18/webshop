<div class="photos-view-row row">
    <div class="photos-view-detail col-xs-9">
        <div class="container photo-view-detail-container col-xs-6">
            <div class="<?= $photo->orientationClass.'-background' ?>">
            </div>
            <?= $this->Html->image($this->Url->build([
                    'controller' => 'Photos',
                    'action' => 'display',
                    'path' => $photo->path,
                    'size' => 'original'
                ]), ['class' => [$photo->orientationClass, 'img-responsive']]); ?>
        </div>
        <div class="photo-view-buttons col-xs-3">
            <div class="photo-view-next">
                <h2><?= __('Selecteer<br>een product >') ?></h2>
            </div>
        </div>
    </div>
    <div class="photos-view-detail col-md-3">
        
    </div>
    
</div>
