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
        <th>Action</th>
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
        <td>
        <?php
            // add link to Employees later
            echo $this->Html->link(
                'Employees', 
                    array(
                        'controller' => '#', 
                        'action' => '#'
                    ), 
                    array(
                        'class' => array(
                            'btn', 'btn-primary')
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
            echo $this->Html->link(
                'Delete',
                array(
                    'controller' => 'departments',
                    'action' => 'delete', 
                    $dep['Department']['id']
                ),
                array(
                    'class' => array('btn', 'btn-danger')
                )
            );
        ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php } ?>
