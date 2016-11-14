<div class='order-info row'>
    <!-- left panel -->
    <div class="order-info-details col-md-9">
        <h2><?= __('Uw gegevens');?></h2>
        <?= $this->Form->create(null, ['url' => ['controller' => 'Orders', 'action' => 'add']]); ?>
            <div class="form-group row gender">
                <div class="col-md-10">
                    <?= $this->Form->select('gender', 
                                ['m' => __('De heer'), 'f' => __('Mevrouw')], [
                                'required' => true,
                        ]); ?>
                </div>
            </div>
            <div class="form-group row">
                <div class='col-md-4'>
                    <?= $this->Form->input('firstname', [
                        'type' => 'text',
                        'label' => false,
                        'placeholder' => __('Naam'),
                        'required' => true,
                        'class' => 'form-control'
                    ]); ?>
                </div>
                <div class='col-md-2'>
                    <?= $this->Form->input('prefix', [
                        'type' => 'text',
                        'label' => false,
                        'placeholder' => __('Tussenvoegsel'),
                        'class' => 'form-control'
                    ]); ?>
                </div>
                <div class='col-md-4'>
                    <?= $this->Form->input('lastname', [
                        'type' => 'text',
                        'label' => false,
                        'placeholder' => __('Achternaam'),
                        'required' => true,
                        'class' => 'form-control'
                    ]); ?>
                </div>
            </div>
            <div class="form-group row">
                <div class='col-md-6'>
                    <?= $this->Form->input('street', [
                        'label' => false,
                        'placeholder' => __('Straatnaam'),
                        'required' => true,
                        'class' => 'form-control'
                    ]); ?>
                </div>
                <div class='col-md-2'>
                    <?= $this->Form->input('number', [
                        'label' => false,
                        'placeholder' => __('Huisnummer'),
                        'required' => true,
                        'class' => 'form-control'
                    ]); ?>
                </div>
                <div class='col-md-2'>
                    <?= $this->Form->input('extension', [
                        'label' => false,
                        'placeholder' => __('Toevoeging'),
                        'class' => 'form-control'
                    ]); ?>
                </div>
            </div>
            <div class="form-group row">
                <div class='col-md-10'>
                    <?= $this->Form->input('zipcode', [
                        'label' => false,
                        'placeholder' => __('Postcode'),
                        'required' => true,
                        'class' => 'form-control'
                    ]); ?>
                </div>
            </div>
            <div class="form-group row">
                <div class='col-md-10'>
                    <?= $this->Form->input('city', [
                        'label' => false,
                        'placeholder' => __('Plaatsnaam'),
                        'required' => true,
                        'class' => 'form-control'
                    ]); ?>
                </div>
            </div>
            <div class='form-group row'>
                <div class='col-md-10'>
                    <?= $this->Form->input('email', [
                        'type' => 'email',
                        'label' => false,
                        'placeholder' => __('Email'),
                        'required' => true,
                        'class' => 'form-control'
                    ]); ?>
                </div>
            </div>
            <div class='form-group row'>
                <div class='col-md-10'>
                    <?= $this->Form->input('phone', [
                        'label' => false,
                        'placeholder' => __('Telefoonnummer'),
                        'required' => true,
                        'class' => 'form-control'
                    ]); ?>
                </div>
            </div>
            <div class='form-group row'>
                <div class='col-md-10'>
                    <?= $this->Form->input('different-address', [
                        'label' => __('Verstuur naar ander adres'),
                        'type' => 'checkbox',
                        'templates' => [
                            'formGroup' => '{{input}}{{label}}'
                        ],
                        'id' => 'different-address'
                    ]); ?>
                </div>
            </div>

            <div id='alternative-address' style='display:none'>
                <div class="form-group row gender">
                    <div class="col-md-10">
                        <?= $this->Form->select('alternative.gender', 
                                ['m' => __('De heer'), 'f' => __('Mevrouw')], [
                                'required' => false,
                        ]); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class='col-md-4'>
                        <?= $this->Form->input('alternative.firstname', [
                            'type' => 'text',
                            'label' => false,
                            'placeholder' => __('Naam'),
                            'required' => false,
                            'class' => 'form-control'
                        ]); ?>
                    </div>
                    <div class='col-md-2'>
                        <?= $this->Form->input('alternative.prefix', [
                            'type' => 'text',
                            'label' => false,
                            'placeholder' => __('Tussenvoegsel'),
                            'class' => 'form-control'
                        ]); ?>
                    </div>
                    <div class='col-md-4'>
                        <?= $this->Form->input('alternative.lastname', [
                            'type' => 'text',
                            'label' => false,
                            'placeholder' => __('Achternaam'),
                            'required' => false,
                            'class' => 'form-control'
                        ]); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class='col-md-6'>
                        <?= $this->Form->input('alternative.street', [
                            'label' => false,
                            'placeholder' => __('Straatnaam'),
                            'required' => false,
                            'class' => 'form-control'
                        ]); ?>
                    </div>
                    <div class='col-md-2'>
                        <?= $this->Form->input('alternative.number', [
                            'label' => false,
                            'placeholder' => __('Huisnummer'),
                            'required' => false,
                            'class' => 'form-control'
                        ]); ?>
                    </div>
                    <div class='col-md-2'>
                        <?= $this->Form->input('alternative.extension', [
                            'label' => false,
                            'placeholder' => __('Toevoeging'),
                            'class' => 'form-control'
                        ]); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class='col-md-10'>
                        <?= $this->Form->input('alternative.zipcode', [
                            'label' => false,
                            'placeholder' => __('Postcode'),
                            'required' => false,
                            'class' => 'form-control'
                        ]); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class='col-md-10'>
                        <?= $this->Form->input('alternative.city', [
                            'label' => false,
                            'placeholder' => __('Plaatsnaam'),
                            'required' => false,
                            'class' => 'form-control'
                        ]); ?>
                    </div>
                </div>
            </div>
        
            <h3>
                <?= __('Betaling'); ?>
            </h3>
        
            <div class='form-group row'>
                <div class='col-md-10'>
                    <?= $this->Form->input('paymentmethod', [
                            'label' => __('Hoe wilt u betalen?'),
                            'class' => 'form-control',
                            'options' => [
                                'transfer' => __('Bankoverschrijving'),
                                'ideal' => __('iDeal'),
                            ]]); 
                    ?>
                </div>
            </div>
        
            <div class='form-group row' id="ideal-issuers">
                <div class='col-md-10'>
                    <?= $this->Form->input('issuerId', [
                            'label' => __('Kies uw bank'),
                            'class' => 'form-control',
                            'options' => $issuers]); 
                    ?>
                </div>
            </div>
        
        <?= $this->Form->button(__('Ga verder'), [
            'type' => 'submit',
            'id' => 'order-info-submit',
            'class' => 'btn btn-success'
        ]); ?>
        <?= $this->Form->end(); ?>
    </div>
    <!-- right panel -->
    <div class="cart-order-details col-md-3 hidden-sm hidden-xs">
                 <h2><?= __('Uw bestelling');?></h2>
         <div class="row">
             <div class="col-md-2"><?= __('Aantal'); ?></div>
             <div class="col-md-8"><?= __('Product'); ?></div>
             <div class="col-md-2"><?= __('Subtotaal'); ?></div>
         </div>
         <?php foreach($cart->cartlines as $line): ?>
         <div class="row">
             <div class="col-md-2"><?= $line->quantity ?></div>
             <div class="col-md-8"><?= $line->product->name; ?></div>
             <div class="col-md-2"><?= $line->quantity * $line->product->price_ex; ?></div>
         </div>
        <?php endforeach; ?>
    </div>
</div>
