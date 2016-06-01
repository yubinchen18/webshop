<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Blank Page - Ace Admin</title>

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
        ]) ?>

         <?= $this->Html->script([
             '/admin/js/jquery.min.js',
            '/admin/js/bootstrap.min.js',
            '/admin/js/ace-elements.js',
            '/admin/js/ace.js',
        ]) ?>
        
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>

    <body class="no-skin">
        <?= $this->Flash->render() ?>
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
                                    <a href="#"> <?= $this->request->params['controller'] ?></a>
                                </li>
                                <li>
                                    <a href="#"><?= $this->request->params['action'] ?></a>
                                </li>
                            </ul>
                        </div>

                        <div class="page-content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?= $this->fetch('content') ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </body>
</html>
