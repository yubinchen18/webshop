<div class='col-xs-12 hidden-lg hidden-md hidden-sm photos-view-buttons-panel-top' data-spy="affix" data-offset-top="0"
    data-product-group= '<?= $this->request->params['pass'][0]; ?>' data-photo-id="<?= $this->request->params['pass'][1]; ?>">
    <div class='photos-view-buttons-box1' id="photos-view-buttons-box1-top">
        <div class='button-glans photos-view-buttons-button photos-view-buttons-selected' 
             data-option-value='{"name": "Uitvoering", "value": "glans", "icon": "layout/Hoogstraten_webshop-onderdelen-25.png"}'>
            <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-25.png', [
                'class' => ['img-responsive']
            ]); ?>
            <div class="photos-view-buttons-select"></div>
        </div>
        <div class='button-mat photos-view-buttons-button' 
             data-option-value='{"name": "Uitvoering", "value": "mat", "icon": "layout/Hoogstraten_webshop-onderdelen-26.png"}'>
            <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-26.png', [
                'class' => ['img-responsive']
            ]); ?>
        </div>
    </div>
    <div class='photos-view-buttons-box2' id="photos-view-buttons-box2-top">
        <div class='button-geen photos-view-buttons-button photos-view-buttons-selected' 
             data-option-value='{"name": "Kleurbewerking", "value": "geen", "icon": "layout/Hoogstraten_webshop-onderdelen-31.png"}'>
            <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-31.png', [
                'class' => ['img-responsive']
            ]); ?>
            <div class="photos-view-buttons-select"></div>
        </div>
        <div class='button-zwartWit photos-view-buttons-button' 
             data-option-value='{"name": "Kleurbewerking", "value": "zwartwit", "icon": "layout/Hoogstraten_webshop-onderdelen-32.png"}'>
            <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-32.png', [
                'class' => ['img-responsive']
            ]); ?>
        </div>
        <div class='button-sepia photos-view-buttons-button' 
             data-option-value='{"name": "Kleurbewerking", "value": "sepia", "icon": "layout/Hoogstraten_webshop-onderdelen-33.png"}'>
            <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-33.png', [
                'class' => ['img-responsive']
            ]); ?>
        </div>
    </div>
</div>
