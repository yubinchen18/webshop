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
    <?= $this->Html->css('../admin/css/font-awesome.min.css') ?>
    <?= $this->Html->script('main.js') ?>

    <?= $this->fetch('meta') ?>
</head>
<body>
    <?php if(!($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'login')): ?>   
        <?= $this->element('Frontend/navigation'); ?>
    <?php endif; ?>
    <div id="content" class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
    <?= $this->fetch('scriptBottom'); ?>
    <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
        try {
            var pageTracker = _gat._getTracker("UA-12470546-8");
            pageTracker._trackPageview();
        } catch(err) {}
    </script>
</body>
</html>
