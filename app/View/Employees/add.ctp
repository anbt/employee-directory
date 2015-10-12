<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Add Employee</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php 
                        echo $this->Form->create(
                            'Employee',
                            array(
                                'type' => 'file',
                                'inputDefaults' => array(
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                )
                            )
                        ); 
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <?php 
                            echo $this->Html->image(
                                '/files/icon-profile.png',
                                array(
                                    'alt' => 'Icon Profile',
                                    'class' => array('img-responsive')
                                )
                            );
                            echo $this->Form->input(
                                'photo',
                                array(
                                    'type' => 'file',
                                    'label' => false,
                                    'required' => false,
                                    'class' => false,
                                    'div' => false
                                )
                            );
                        ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <?php
                            echo $this->Form->input(
                                'name',
                                array(
                                    'label' => 'Employee Name'
                                )
                            );
                            echo $this->Form->input(
                                'department_id',
                                array(
                                    'options' => $departments,
                                    'empty' => '',
                                    'label' => 'Department'
                                )
                            );
                            echo $this->Form->input('job_title');
                            echo $this->Form->input('cellphone');
                            echo $this->Form->input('email');
                            echo $this->Form->submit(
                                'Add',
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
    </div>
</div>
