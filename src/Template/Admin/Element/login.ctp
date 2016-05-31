
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h4 class="blue" id="id-company-text">&copy; Hoogstraten Fotografie </h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        <i class="ace-icon fa fa-coffee green"></i>
                                        Please Enter Your Information
                                    </h4>

                                    <div class="space-6"></div>                                    

                                    <?= $this->Form->create(null, [
                                        'url' => [
                                            'controller' => 'Users',
                                            'action' => 'login'
                                            ],
                                        'class' => 'intro-form',
                                        'id' => 'register_form',
                                        'role'=>'form'
                                    ]) ?>
                                    <fieldset>
                                        <label class="block clearfix">
                                            <span class="block input-icon input-icon-right">
                                                <?= $this->Form->input( 'username',
                                                    [
                                                        'type' => 'text',
                                                        'class' => 'form-control',
                                                        'placeholder' => __('username'),
                                                        'required' => 'required'

                                                    ]);
                                                  ?>
                                                <i class="ace-icon fa fa-user"></i>
                                            </span>
                                        </label>

                                        <label class="block clearfix">
                                            <span class="block input-icon input-icon-right">
                                                <?= $this->Form->input( 'password',
                                                [
                                                    'type' => 'password',
                                                    'class' => 'form-control',
                                                    'placeholder' => __('password'),
                                                    'required' => 'required'

                                                ]);
                                              ?>
                                                <i class="ace-icon fa fa-lock"></i>
                                            </span>
                                        </label>

                                        <div class="space"></div>

                                        <div class="clearfix">
                                            <label class="inline">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"> Remember Me</span>
                                            </label>

                                            <?=$this->Form->button(__('Login'), ['type' => 'submit', 'class' => 'width-35 pull-right btn btn-sm btn-primary']); ?>
                                        </div>

                                        <div class="space-4"></div>
                                    </fieldset>
                                    <?= $this->Form->end() ?>


                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.login-box -->
                    </div><!-- /.position-relative -->                    
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->

