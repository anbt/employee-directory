<h3>Department detail</h3>
<div class="table-responsive">
<table class="table table-stripped">
    <tr>
        <th>Name</th>
        <td><?php echo $dep['Department']['name']; ?></td>
    </tr>
    <tr>
        <th>Office Number</th>
        <td><?php echo $dep['Department']['office_phone']; ?></td>
    </tr>
    <tr>
        <th>Manager</th>
        <td><?php echo $dep['ManagedBy']['name']; ?></td>
    </tr>
</table>
</div>
<?php echo $this->Html->link("Back", array('controller' => 'departments', 'action' => 'index'), array('class' => array('btn', 'btn-info'))); ?>
