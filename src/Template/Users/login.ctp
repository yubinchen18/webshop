<div class='login-background'>
    <div class='login-main-container'>
        <div class='row'>
            <div class='login-main-container-panel col-sm-4'>
                <?= $this->Form->create(null, [
                    'url' => [
                        'controller' => 'Users',
                        'action' => 'login'
                        ],
                    'class' => 'inlog-form',
                    'role'=>'form'
                ]) ?>
                <div class="login-portraits-container">
                    <?php if ($authuser): ?>
                        <?php foreach ($userPortraits as $userPortrait): ?>
                            <?= $this->element('Frontend/portrait', ['userPortrait' => $userPortrait]); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="login-inputs-panel-before">
                    <div class='login-divide-stripe'></div>
                    <?= $this->Form->input( 'username',
                        [
                            'type' => 'text',
                            'class' => ['form-control', 'login-container-input'],
                            'placeholder' => __('GEBRUIKERSNAAM'),
                            'required' => 'required',
                            'label' => false,
                        ]);
                      ?>
                    <div class='login-divide-stripe'></div>
                        <?= $this->Form->input( 'password',
                        [
                            'type' => 'password',
                            'class' => ['form-control', 'login-container-input'],
                            'placeholder' => __('INLOGCODE'),
                            'required' => 'required',
                            'label' => false
                        ]);
                        ?>
                    <div class='login-divide-stripe'></div>
                    <div class="login-submit-button">
                        <div class="login-container-button submit-button">
                            <?= $this->Form->input('', [
                                'id' => 'login-extra-child',
                                'label' => false,
                                'type' => 'image',
                                'class' => 'input-image',
                                'src' => '../img/layout/Hoogstraten_webshop-onderdelen-45.png',
                                'templates' => [
                                    'inputContainer' => '{{content}}'
                                ]
                            ]); ?>
                            <span class='noselect'><?= __('NOG EEN KIND INLOGGEN'); ?></span>
                        </div>
                    </div>
                    
                    <div class="login-submit-button">
                        <div class="login-container-button submit-button large">
                            <?= $this->Form->input('', [
                                'id' => 'login',
                                'label' => false,
                                'type' => 'image',
                                'class' => 'input-image',
                                'src' => '../img/layout/Hoogstraten_webshop-onderdelen-46.png',
                                'templates' => [
                                    'inputContainer' => '{{content}}'
                                ]
                            ]); ?>
                            <span class='noselect'><?= __('INLOGGEN EN FOTO\'S BEKIJKEN'); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="flash-message"><?= $this->Flash->render(); ?></div>
                <?= $this->Form->hidden('login-type', array('id' => 'login-type'))?>
                <?= $this->Form->end() ?>
                <!-- action logo -->
                <div class='login-action-star'>
                    <div class='login-action-star-message'>
                        <?= __('Gratis verzending vanaf 3 afdrukken'); ?>
                    </div>
                    <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-37.png', [
                        'class' => ['login-action-start-logo']
                    ]); ?>
                </div>
            </div>
            
            
            <div class='login-logo-container col-sm-5 col-sm-offset-3'>
            <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-36.png', [
                'class' => ['login-main-logo']
            ]); ?>
            </div>
        </div>
        
    </div>
</div>


