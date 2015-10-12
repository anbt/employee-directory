<div class="row">
    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Department</h3>
            </div>
            <div class="panel-body">
                <?php
                    echo $this->Form->create(
                        'Department',
                        array(
                            'inputDefaults' => array(
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            )
                        )
                    );
                    echo $this->Form->input('name');
                    echo $this->Form->input('office_phone');
                    echo $this->Form->input(
                        'manager_id',
                        array(
                            'options' => $managers,
                            'empty' => '',
                            'label' => 'Manager'
                        )
                    );
                    echo $this->Form->submit(
                        'Edit',
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
