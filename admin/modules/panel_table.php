<?php
function admin_panel_table($title, $field, $table, $order_by)
{
    global $mysqli;
    
    $sql = 'SELECT id, '.$field.' AS name, published
            FROM '.$table.'
            ORDER BY '.$order_by.'
            ;';
    ?>
    <h5><?php echo $title; ?></h5>
    <?php if ($result=mysqli_query($mysqli,$sql)): ?>
    <?php if (!$result->num_rows): ?>
    <span>No entries</span>
    <?php else: ?>
    <table class="table table-striped table-hover table-sm">
        <thead>
            <tr width="100%">
                <th width="15%">ID</th>
                <th width="70%">Name</th>
                <th width="15%" colspan="2">State</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_object($result)): ?>
            <tr>
                <td><?php echo $row->id; ?></td>
                <td><!--a href="'.$table.'.php?id='.$row->id.'"--><?php echo $row->name; ?><!--/a--></td>
                <td><?php echo (!$row->published) ? '<i class="fas fa-toggle-off"></i>' : '<i class="fas fa-toggle-on"></i>'; ?></td>
                <td><!--a href="modules/delete_'.$table.'.php?id='.$row->id.'"--><i class="fas fa-trash"></i><!--/a--></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <?php endif; ?>
    <?php mysqli_free_result($result); ?>
<?php
}
?>
