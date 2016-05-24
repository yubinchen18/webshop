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

    <?= $this->Html->css('layout.css') ?>
    <?= $this->Html->script('main.js') ?>

    <?= $this->fetch('meta') ?>
</head>
<body>
    <?= $this->element('Frontend/navigation'); ?>
    
    <div id="content" class="container clearfix">
        <?= $this->Flash->render(); ?>
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
