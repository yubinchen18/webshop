    <div class="col-md-6" id="tow">
    <div class="widget-box">
        <div class="widget-header">
            <h4 class="widget-title"><?=__("Leerling Foto's"); ?></h4>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        
        <div class="widget-body">
            <div class="widget-main">
                    <table class="vertical-table">
                        <?php foreach($person->barcode->photos as $photo): ?>
                            <td class="col-md-4">
                            <?= $this->Html->image($this->Url->build([
                                'controller' => 'Photos',
                                'action' => 'display',
                                'path' => $photo->id,
                                'size' => 'med',
                                ])); 
                            ?>
                            </td>
                        <?php endforeach; ?>
                    </table>
                <div class="clearfix"></div>    
            </div>
        </div>
    </div>
    </div>