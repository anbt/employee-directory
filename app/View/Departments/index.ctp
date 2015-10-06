<h3>Departments</h3>

<?php
if (count($departments) == 0) {
    echo "<p>There is no department</p>";
} else {
?>

<table class="table table-stripped table-responsive">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Office Number</th>
        <th>Manager</th>
<?php if ($loggedIn) : ?>
        <th>Action</th>
<?php endif; ?>
    </tr>
    
<?php foreach($departments as $dep): ?>
    <tr>
        <td><?php echo $dep['Department']['id']; ?></td>
        <td><?php echo $this->Html->link(
                $dep['Department']['name'], 
                array('controller' => 'departments', 'action' => 'detail', $dep['Department']['id'])
            ); ?>
        </td>
        <td><?php echo $dep['Department']['office_phone']; ?></td>
        <td><?php echo $dep['ManagedBy']['name']; ?></td>
<?php if ($loggedIn) : ?>
        <td>
        <?php
            // add controller and action to Employees link later
            echo $this->Html->link(
                'Employees', 
                array(
                    'controller' => '#',
                    'action' => '#'),
                array(
                    'class' => array('btn', 'btn-primary')
                )
            );
            echo $this->Html->link(
                'Edit',
                array(
                    'controller' => 'departments',
                    'action' => 'edit', 
                    $dep['Department']['id']
                ),
                array(
                    'class' => array('btn', 'btn-warning')
                )
            );
            echo $this->Form->postLink(
                __('Delete'),
                array(
                    'action' => 'delete', 
                    $dep['Department']['id']
                ),
                array(
                    'class' => array('btn', 'btn-danger')
                ),
                __('Are you sure you want to delete department "%s"?', $dep['Department']['name'])
            );

        ?>
        </td>
<?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>
<?php }
if ($loggedIn) {
    echo $this->Html->link("Add department", array('controller' => 'departments', 'action' => 'add'));
}
?>
