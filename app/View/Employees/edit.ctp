<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Employee</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php echo $this->Form->create('Employee', array('type' => 'file')); ?>
                    <div class="col-lg-5 col-md-5 col-sm-5">
                        <?php 
                            echo $this->Html->image(
                                '/files/' . ($imageName ? $imageName : 'icon-profile.png'),
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
                                    'required' => false
                                )
                            );
                        ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                        <?php
                            echo $this->Form->input(
                                'name',
                                array(
                                    'label' => 'Employee Name',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                )
                            );
                            echo $this->Form->input(
                                'department_id',
                                array(
                                    'options' => $departments,
                                    'empty' => '',
                                    'label' => 'Department',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                )
                            );
                            echo $this->Form->input(
                                'job_title',
                                array(
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                )
                            );
                            echo $this->Form->input(
                                'cellphone',
                                array(
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                )
                            );
                            echo $this->Form->input(
                                'email',
                                array(
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
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
    </div>
</div>
