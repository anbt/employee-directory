<h3>Department detail</h3>

<table class="table table-stripped table-responsive">
    <tr>
        <th>Name</th>
        <th>Office Number</th>
        <th>Manager</th>
    </tr>
    <tr>
        <td><?php echo $dep['Department']['name']; ?></td>
        <td><?php echo $dep['Department']['office_phone']; ?></td>
        <td><?php echo $dep['ManagedBy']['name']; ?></td>
    </tr>
</table>
<?php echo $this->Html->link("Back", array('controller' => 'departments', 'action' => 'index')); ?>
