<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class='col-md-4 col-sm-5 col-xs-6' id='logo-top'>
                <?= $this->Html->link(
                    $this->Html->image('/img/layout/logo-hoogstraten-fotografie.png',
                        ['alt' => 'logo', 'class' => 'img-responsive']),
                    ['controller' => 'Photos', 'action' => 'index'],
                    ['escape' => false]
                );  ?>
            </div>
            <!-- user portraits -->
            <?php if (isset($userPortraits)): ?>
                <div class='col-md-6 col-xs-6 hidden-sm hidden-xs portraits-container'>
                    <div class="portrait-container login-extra-child-icon">
                        <?= $this->Html->link($this->Html->image('layout/Hoogstraten_webshop-onderdelen-48.png', ['alt' => 'add-child']),
                            '/', ['escapeTitle' => false, 'title' => 'Kind toevoegen']); ?>
                    </div>
                    <?php foreach($userPortraits as $userPortrait): ?>
                        <?= $this->element('Frontend/portrait', ['userPortrait' => $userPortrait]); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <!-- Desktop screen -->
            <div class="col-sm-7 col-md-2">
                <div class="cart-btn desktopmenu">
                    <div class="dropdown">
                        <?= $this->Html->link(
                                $this->Html->image('/img/layout/menu.png',
                                    ['alt' => 'logo', 'class' => 'img-responsive']),
                                '#',
                                ['escape' => false, 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true', 'aria-expanded' => 'false']
                        );  ?>
                        <ul class="dropdown-menu pull-right" aria-labelledby="dropdown">
                          <li><?= $this->Html->link(__('Hoe werkt het'), ['controller' => 'Pages', 'action' => 'display', 'prefix' => false]); ?></li>
                          <li><?= $this->Html->link(__('Opties'), ['controller' => 'Pages', 'action' => 'display', 'prefix' => false], ['class' => 'even']); ?></li>
                          <li><?= $this->Html->link(__('Info voor scholen'), ['controller' => 'Pages', 'action' => 'display', 'prefix' => false]); ?></li>
                          <li><?= $this->Html->link(__('Klantenservice'), ['controller' => 'Pages', 'action' => 'display', 'prefix' => false], ['class' => 'even']); ?></li>
                          <li><?= $this->Html->link(__('Veelgestelde'), ['controller' => 'Pages', 'action' => 'display', 'prefix' => false]); ?></li>
                        </ul>
                    </div>
                    <div class="small-cart">
                        <?= $this->Html->image('/img/layout/cart.png',
                                ['alt' => 'logo', 
                                 'class' => 'img-responsive',
                                 'url' => ['controller' => 'Carts', 'action' => 'display']]);  ?>
                        <div class="cartlabel label label-info"><?= !empty($cartcount)? $cartcount : 0; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- back to index button -->
    <?php if ($this->request->params['controller'] === 'Photos' && in_array($this->request->params['action'], ['view','productGroupIndex'])): ?>
        <?php $viewUrl = $this->Url->build(['controller' => 'Photos', 'action' => 'view', $this->request->params['id']]); ?>    
        <?php $indexUrl = $this->Url->build(['controller' => 'Photos', 'action' => 'index']); ?>
        <?php switch ($this->request->params['action']) {
            case 'view':
                $backUrl = $indexUrl;
                break;
            case 'productGroupIndex':
                $backUrl = $viewUrl;
                break;
            default:
                $backUrl = $indexUrl;
        }?>
        <a href="<?= $backUrl; ?>">
            <div class="navbar-back-to-index">
                <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-11.png', [
                    'class' => ['img-responsive', 'navbar-back-to-index-img']
                ]); ?>
                <div class="text-center navbar-back-to-index-text hidden-xs">
                    <?= __("TERUG NAAR OVERZICHT"); ?>
                </div>
            </div>
        </a>
    <?php endif; ?>
</nav>