<div class="row">
    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Change password</h3>
            </div>
            <div class="panel-body">
                <p class="alert alert-warning">
                    Remember : <br>
                    You have to change pass right after first login. <br>
                    And you should not use the password we provided via mail, ever again.
                </p>
                <?php
                    echo $this->Form->create(
                        'User',
                        array(
                            'inputDefaults' => array(
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            )
                        )
                    );
                    echo $this->Form->input(
                        'cur_password',
                        array(
                            'label' => 'Current Password',
                            'type' => 'password'
                        )
                    );
                    echo $this->Form->input(
                        'password',
                        array(
                            'label' => 'New Password'
                        )
                    );
                    echo $this->Form->input(
                        'confirm',
                        array(
                            'type' => 'password'
                        )
                    );
                    echo $this->Form->submit(
                        'Change',
                        array(
                            'class' => array('btn', 'btn-info')
                        )
                    );
                    echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>
