<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
    </div>

    <ul class="nav nav-list">
        <?php $params = $this->request->params; ?>

        <?php foreach ($menu as $menuitem): ?>
            <?php $active = ($params['controller'] == $menuitem['url']['controller']) ? 'active' : ''; ?>
            <?php $active = $active && ! empty($menuitem['children']) ? 'active open' : $active; ?>
            <li class="<?= $active; ?>">

                <?php if ( ! empty($menuitem['children'])): ?>

                    <?php $link = sprintf('<i class="menu-icon %s"></i> <span class="menu-text"> %s</span><b class="arrow fa fa-angle-down"></b>', $menuitem['icon'], $menuitem['name']); ?>

                    <?= $this->Html->link($link, '#', ['escape' => false, 'class' => 'dropdown-toggle']); ?>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <?php foreach ($menuitem['children'] as $childmenuitem): ?>
                            <?php $active = ($params['controller'] == $childmenuitem['url']['controller'] && $params['action'] == $childmenuitem['url']['action']) ? 'active' : ''; ?>
                            <li class="<?= $active; ?>">

                                <?php $link = sprintf('<i class="menu-icon fa fa-caret-right"></i> %s', $childmenuitem['name']); ?>

                                <?= $this->Html->link($link, $childmenuitem['url'], ['escape' => false]); ?>

                                <b class="arrow"></b>
                            </li>
                        <?php endforeach; ?>
                    </ul>


                <?php else: ?>
                    <?php $link = sprintf('<i class="menu-icon %s"></i> <span class="menu-text"> %s</span>', $menuitem['icon'], $menuitem['name']); ?>

                    <?= $this->Html->link($link, $menuitem['url'], ['escape' => false]); ?>

                    <b class="arrow"></b>
                <?php endif; ?>


            </li>
        <?php endforeach; ?>

    </ul>

</div>
