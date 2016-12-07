<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button id="menu-toggler" class="navbar-toggle menu-toggler pull-left" type="button" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    Hoogstraten Fotografie Admin
                </small>
            </a>
        </div>
    
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="/admin/avatars/cor.png" alt="Jason's Photo" />
                        <span class="user-info">
                            <small>Welkom,</small>
                            <?= $this->request->session()->read('Auth.User.username'); ?>
                        </span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="#">
                                <i class="ace-icon fa fa-cog"></i>
                                Instellingen
                            </a>
                        </li>
                        <li class="divider"></li>

                        <li>
                            <?= $this->Html->link('<i class="ace-icon fa fa-power-off"></i>' . __('Uitloggen'),
                                    ['controller' => 'Users', 'action' => 'logout'],
                                    ['escape' => false]
                                )
                            ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>