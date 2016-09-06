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
                <?php if (!$authuser): ?>
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
                                <?=$this->Form->input('', [
                                    'label' => false,
                                    'type' => 'image',
                                    'class' => 'input-image',
                                    'src' => '../img/layout/Hoogstraten_webshop-onderdelen-14.png',
                                    'templates' => [
                                        'inputContainer' => '{{content}}'
                                    ]
                                ]); ?>
                                <span class='noselect'><?= __('INLOGGEN'); ?></span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="login-inputs-panel-after">
                        <div class="input login-forward-button">
                            <a href="<?= $this->Url->build(['controller' => 'Photos', 'action' => 'index'])?>">
                                <div class="login-container-button order-button">
                                    <?=$this->Html->image('layout/Hoogstraten_webshop-onderdelen-14.png', [
                                        'class' => ['input-image']
                                    ]); ?>
                                    <span><?=__('BEKIJK FOTO\'S');?></span>
                                </div>
                            </a>
                        </div>
                        <div class="input login-add-button">
                            <div class='login-container-button login-add-child'>
                                <?=$this->Html->image('layout/Hoogstraten_webshop-onderdelen-18.png', [
                                    'class' => ['input-image']
                                ]); ?>
                                <span><?=__('NOG EEN KIND INLOGGEN?');?></span>
                            </div>
                        </div>
                        <div class="login-inputs-panel-after-hidden">
                            <div class='login-divide-stripe'></div>
                            <?= $this->Form->input( 'username',
                                [
                                    'type' => 'text',
                                    'class' => ['form-control', 'login-container-input', 'input-small'],
                                    'placeholder' => __('GEBRUIKERSNAAM'),
                                    'required' => 'required',
                                    'label' => false,
                                ]);
                             ?>
                            <?= $this->Form->input( 'password',
                            [
                                'type' => 'password',
                                'class' => ['form-control', 'login-container-input', 'input-small'],
                                'placeholder' => __('INLOGCODE'),
                                'required' => 'required',
                                'label' => false
                            ]);
                            ?>
                            <div class='login-divide-stripe'></div>
                            <div class="login-submit-button">
                                <div class="login-container-button submit-button">
                                    <?=$this->Form->input('', [
                                        'label' => false,
                                        'type' => 'image',
                                        'class' => 'input-image',
                                        'src' => '../img/layout/Hoogstraten_webshop-onderdelen-14.png',
                                        'templates' => [
                                            'inputContainer' => '{{content}}'
                                        ]
                                    ]); ?>
                                    <span><?= __('INLOGGEN'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="flash-message"><?= $this->Flash->render(); ?></div>
                <?= $this->Form->end() ?>
            </div>
            <div class='col-sm-8'>
            <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-36.png', [
                'class' => ['login-main-logo']
            ]); ?>
            </div>
        </div>
    </div>
</div>


