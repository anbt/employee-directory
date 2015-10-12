<?php if ($loggedIn) : ?>
<div class="panel panel-info">
    <div class="panel-body">
<?php
    echo $this->Html->link(
        "Add employee",
        array('controller' => 'employees', 'action' => 'add'),
        array('class' => array('btn', 'btn-primary'))
    );
?>
    </div>
</div>
<?php endif; ?>

<?php
if (count($employees) == 0) :
    echo '<h3>Employees</h3>';
    echo "<p>There is no employee.</p>";
else :
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Search employees</h3>
    </div>
    <div class="panel-body">
<?php
    echo $this->Form->create(
        'Employee',
        array(
            'type' => 'get',
            'class' => 'form-inline',
            'inputDefaults' => array(
                'class' => 'form-control',
                'div' => array('class' => 'form-group')
            )
        )
    );
    echo $this->Form->input(
        'name',
        array(
            'placeholder' => 'Employee Name',
            'label' => false,
            'required' => false
        )
    );
    echo $this->Form->input(
        'department_id',
        array(
            'options' => $departments,
            'empty' => 'Departments',
            'label' => false
        )
    );
    echo $this->Form->submit('Search', array('div' => array('class' => 'form-group'), 'class' => array('btn', 'btn-success')));
    echo $this->Form->button('Clear', array('type' => 'reset', 'class' => array('btn', 'btn-info')));
    echo $this->Form->end();
?>
    </div>
</div>

<h3>Employees</h3>
<div class="table-responsive">
    <table class="table table-stripped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Department</th>
                <th>Job title</th>
                <th>Email</th>
<?php if ($loggedIn) : ?>
                <th>Action</th>
<?php endif; ?>
            </tr>
        </thead>
        <tbody>
<?php foreach($employees as $emp): ?>
            <tr>
                <td><?php echo $emp['Employee']['id']; ?></td>
                <td><?php echo $this->Html->link(
                        $emp['Employee']['name'], 
                        array('controller' => 'employees', 'action' => 'profile', $emp['Employee']['id'])
                    ); ?>
                </td>
                <td><?php echo $emp['WorkingIn']['name']; ?></td>
                <td><?php echo $emp['Employee']['job_title']; ?></td>
                <td><?php echo $emp['Employee']['email']; ?></td>
    <?php if ($loggedIn) : ?>
        
                <td>
            <?php
                echo $this->Html->link(
                    'Edit',
                    array(
                        'controller' => 'employees',
                        'action' => 'edit', 
                        $emp['Employee']['id']
                    ),
                    array(
                        'class' => array('btn', 'btn-warning')
                    )
                );
                echo $this->Form->postLink(
                    __('Delete'),
                    array(
                        'action' => 'delete', 
                        $emp['Employee']['id']
                    ),
                    array(
                        'class' => array('btn', 'btn-danger')
                    ),
                    __('Are you sure you want to delete employee "%s"?', $emp['Employee']['name'])
                );

            ?>
            
                </td>
    <?php endif; ?>
            
            </tr>
    <?php endforeach; ?>
        
        </tbody>
    </table>
</div>
<?php 
endif;
?>
