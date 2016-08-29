<?php
$cakeDescription = 'Schoolfotografie by Hoogstraten ... de beste kwaliteit schoolfoto\'s';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css([
            'layout.css',
            '/admin/css/bootstrap.min.css',
            '/admin/css/font-awesome.min.css',
            '/admin/css/ace-fonts.css',
        ]) ?>
    
    <?= $this->Html->script([
        'main.js',
        '/admin/js/bootstrap.min.js',
        ]) ?>

    <?= $this->fetch('meta') ?>
</head>
<body>
    <?php if(!($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'login')): ?>   
        <?= $this->element('Frontend/navigation'); ?>
    <?php endif; ?>
    <div id="content" class="container clearfix">
        <?= $this->Flash->render(); ?>
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
    <?= $this->fetch('scriptBottom'); ?>
</body>
</html>
