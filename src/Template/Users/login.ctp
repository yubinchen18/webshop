<div class='login-background'>
    <div class='login-main-container'>
        <div class='login-main-container-panel'>
            <?= $this->Form->create(null, [
                'url' => [
                    'controller' => 'Users',
                    'action' => 'login'
                    ],
                'class' => 'inlog-form',
                'role'=>'form'
            ]) ?>
            <div class="login-portraits-container">
                <?php if($authuser): ?>
                    <?php foreach ($photos as $photo): ?>
                        <div class="portrait-container">
                            <?= $this->Html->image($this->Url->build([
                                'controller' => 'Photos',
                                'action' => 'display',
                                'id' => $photo->id,
                                'size' => 'thumbs'
                            ]), [
                                'alt' => $photo->path,
            //                    'url' => ['controller' => 'Photos', 'action' => 'view', $photo->id],
                                'class' => [$photo->orientationClass]
                            ]); ?>
                        </div>
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
                        <?=$this->Form->submit('layout/Hoogstraten_webshop-onderdelen-13.png', [
                            'class' => ['login-container-submit']
                        ]); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="login-inputs-panel-after">
                    <div class="input login-forward-button">
                        <?=$this->Html->image('layout/Hoogstraten_webshop-onderdelen-14.png', [
                            'class' => ['login-container-submit'],
                            'url' => ['controller' => 'Photos', 'action' => 'index']
                        ]); ?>
                    </div>
                    <div class="input login-add-button">
                        <?=$this->Html->image('layout/Hoogstraten_webshop-onderdelen-15.png', [
                            'class' => ['login-container-submit', 'login-add-child']
                        ]); ?>
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
                            <?=$this->Form->submit('layout/Hoogstraten_webshop-onderdelen-13.png', [
                                'class' => ['login-container-submit']
                            ]); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="flash-message"><?= $this->Flash->render(); ?></div>
            <?= $this->Form->end() ?>
        </div>
        <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-36.png', [
            'class' => ['login-main-logo']
        ]); ?>
    </div>
</div>


