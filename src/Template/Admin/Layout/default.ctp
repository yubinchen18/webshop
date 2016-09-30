<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Hoogstraten Fotografie Admin - <?= __($this->request->params['controller']) .' - '. __($this->request->params['action']) ?></title>

        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

         <?= $this->Html->css([
            '/admin/css/bootstrap.min.css',
            '/admin/css/font-awesome.min.css',
            '/admin/css/ace-fonts.css',
            '/admin/css/ace.css',
            '/admin/css/ace-part2.css',
            '/admin/css/ace-ie.css',
            '/admin/css/cake.css',
            '/admin/css/custom.css',
            '/admin/css/dropzone.css'
        ]) ?>

         <?= $this->Html->script([
            '/admin/js/jquery.min.js',
            '/admin/js/bootstrap.min.js',
            '/admin/js/ace-elements.js',
            '/admin/js/ace.js',
            '/admin/js/main.js'
        ]) ?>
        
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>

    <body class="no-skin">
        <?php if($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'login'): ?>        
            <?= $this->element('login'); ?>
        <?php else: ?>
            <?= $this->element('top-menu'); ?>            
            <div class="main-container ace-save-state" id="main-container">
                <?= $this->cell('Sidebar', [$authuser]); ?>

                <div class="main-content">
                    <div class="main-content-inner">
                        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                            <ul class="breadcrumb">
                                <li>
                                    <i class="ace-icon fa fa-home home-icon"></i>
                                    <a href="#"> <?= __($this->request->params['controller']) ?></a>
                                </li>
                                <li>
                                    <a href="#"><?= __($this->request->params['action']) ?></a>
                                </li>
                            </ul>
                            
                            <!-- #section:basics/content.searchbox -->
                            <div class="nav-search" id="nav-search">                                
                                <?= $this->Form->create(null, [
                                    'url' => [
                                        'controller' => 'searches',
                                        'action' => 'showResults'
                                    ],
                                    'class'=> [
                                        'form-search'
                                    ],
                                    'type'=> 'get'
                                ]); ?>
                                <span class="input-icon">
                                    <?= $this->Form->input('query', [
                                        'label' => false,
                                        'type' => 'text',
                                        'class'=> 'nav-search-input',
                                        'id' => "nav-search-input",
                                        'placeholder' => __('Search...'),
                                        'autocomplete' => 'off',
                                        'templates' => [
                                            'inputContainer' => '{{content}}'
                                        ]
                                    ]); ?>
                                    <!--<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />-->
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                                <?= $this->Form->end(); ?>                                
                            </div><!-- /.nav-search -->
                            


                        </div>

                        <div class="page-content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?= $this->Flash->render() ?>
                                    <?= $this->fetch('content') ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?= $this->fetch('scriptBottom'); ?>
    </body>
</html>
