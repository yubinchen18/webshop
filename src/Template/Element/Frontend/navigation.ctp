<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <?= $this->Html->link(
                    $this->Html->image('/img/layout/logo-hoogstraten-fotografie.png',
                        ['alt' => 'logo', 'class' => 'img-responsive']),
                    ['controller' => 'Photos', 'action' => 'index'],
                    ['escape' => false, 'class' => 'col-xs-3', 'id' => 'logo-top']
            );  ?>
            <!-- user portraits -->
            <?php if (isset($userPortraits)): ?>
                <div class='col-xs-6 col-md-7 col-xs-offset-3 hidden-sm hidden-xs portraits-container'>
                    <?php foreach($userPortraits as $userPortrait): ?>
                        <?= $this->element('Frontend/portrait', ['userPortrait' => $userPortrait]); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <!-- Desktop screen -->
            <div class="col-sm-9 col-md-2 col-xs-offset-3 col-md-offset-0">
                <div class="cart-btn desktopmenu">
                    <div class="dropdown">
                        <?= $this->Html->link(
                                $this->Html->image('/img/layout/menu.png',
                                    ['alt' => 'logo', 'class' => 'img-responsive']),
                                '#',
                                ['escape' => false, 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true', 'aria-expanded' => 'false']
                        );  ?>
                        <ul class="dropdown-menu pull-right" aria-labelledby="dropdown">
                          <li><a href="#">HTML</a></li>
                          <li><a href="#" class="even">CSS</a></li>
                          <li><a href="#">JavaScript</a></li>
                        </ul>
                    </div>  
                    <?= $this->Html->link(
                            $this->Html->image('/img/layout/cart.png',
                                ['alt' => 'logo', 'class' => 'img-responsive']),
                            ['controller' => 'Photos', 'action' => 'index'],
                            ['escape' => false]
                    );  ?>
                     
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
                <div class="text-center navbar-back-to-index-text hidden-xs hidden-sm">
                    <?= __("TERUG NAAR OVERZICHT"); ?>
                </div>
            </div>
        </a>
    <?php endif; ?>
</nav>