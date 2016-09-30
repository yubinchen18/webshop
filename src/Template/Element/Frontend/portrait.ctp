<div class="portrait-container">
    <?php if ($userPortrait): ?>
        <?= $this->Html->image($this->Url->build([
            'controller' => 'Photos',
            'action' => 'display',
            'id' => $userPortrait->id,
            'size' => 'thumbs'
        ]), [
            'alt' => $userPortrait->path,
            'class' => [$userPortrait->orientationClass]
        ]); ?>
    <?php else: ?>
        <?= $this->Html->image('layout/user-default.png', [
            'alt' => 'default_user',
            'class' => ['img-responsive']
        ]); ?>
    <?php endif; ?>
</div>
