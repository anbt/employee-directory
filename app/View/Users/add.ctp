<div class="row">
<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Add user</h3>
    </div>
    <div class="panel-body">
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
            echo $this->Form->input('username');
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
