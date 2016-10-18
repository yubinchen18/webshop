<div class="photos-view-row row">
    <div class="photos-view-detail col-md-8 col-xs-9">
        <div class="row">
            <!-- Medium screen -->
            <div class="photos-view-products-buttons-sm col-sm-12 hidden-lg hidden-md">
                <div class="photos-view-products-select">
                    <h3><?= __('Selecteer een product >') ?></h3>
                </div>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="container photos-view-detail-container">
                    <div class="<?= $photo->orientationClass.' '.$photo->orientationClass.'-background' ?>">
                    </div>
                    <?= $this->Html->image($this->Url->build([
                            'controller' => 'Photos',
                            'action' => 'display',
                            'id' => $photo->id,
                            'size' => 'med'
                        ]), ['class' => [$photo->orientationClass, 'img-responsive']]); ?>
                </div>
            </div>
            <!-- Large screen -->
            <div class="photos-view-products-buttons-md col-md-3 hidden-sm hidden-xs">
                <div class="photos-view-products-select">
                    <h3><?= __('Selecteer<br /> een product >') ?></h3>
                </div>
            </div>
        </div>
        <div class='photos-view-detail-text'>
            <h3><?= __('1e opname per kind op 13x19 €5,95<br>iedere volgende 13x19 van uw kind €3,29') ?></h3>
        </div>
        
    </div>
    <!-- Right panel -->
    <?= $this->element('Frontend/productsPanel', ['photo' => $photo]); ?>
</div>
