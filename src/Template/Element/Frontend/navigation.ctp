<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <a class="col-xs-3">Logo</a>
            <!-- Desktop screen -->
            <div class="col-md-6 col-md-offset-3 hidden-sm hidden-xs">
                <div class="cart-btn desktopmenu">
                    <div class="row">
                        <div class="dropdown col-md-5 col-md-offset-7">
                            <a href="/cart"><img src="/img/layout/cart.png" /></a>
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown"><img src="/img/layout/menu.png" /></a>
                            <ul class="dropdown-menu pull-right">
                              <li><a href="#">HTML</a></li>
                              <li><a href="#" class="even">CSS</a></li>
                              <li><a href="#">JavaScript</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Small screen -->
            <div class="col-xs-12 hidden-md hidden-lg">
                <div class="cart-btn">
                    <div class="dropdown">
                        <a href="/cart"><img src="/img/layout/cart.png" /></a>
                        <a class="dropdown-toggle" data-toggle="dropdown"><img src="/img/layout/menu.png" /></a>
                        <ul class="dropdown-menu col-xs-12">
                          <li><a href="#">HTML</a></li>
                          <li><a href="#" class="even">CSS</a></li>
                          <li><a href="#">JavaScript</a></li>
                        </ul>
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
                <div class="text-center navbar-back-to-index-text">
                    <?= __("TERUG NAAR OVERZICHT"); ?>
                </div>
            </div>
        </a>
    <?php endif; ?>
</nav>