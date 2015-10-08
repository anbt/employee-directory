<h3>Employees</h3>

<?php
if (count($employees) == 0) :
    echo "<p>There is no employee</p>";
else :
?>

<table class="table table-stripped table-responsive">
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
</table>
<?php 
endif;
if ($loggedIn) :
    echo $this->Html->link("Add employee", array('controller' => 'employees', 'action' => 'add'));
endif;
?>
