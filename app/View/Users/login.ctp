<div class="row">
<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Login</h3>
    </div>
    <div class="panel-body">
        <?php
            echo $this->Form->create('User');
            echo $this->Form->input(
                'username',
                array(
                    'class' => 'form-control',
                    'div' => array('class' => 'form-group')
                )
            );
            echo $this->Form->input(
                'password',
                array(
                    'class' => 'form-control',
                    'div' => array('class' => 'form-group')
                )
            );
            echo $this->Form->submit(
                'Log in',
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
