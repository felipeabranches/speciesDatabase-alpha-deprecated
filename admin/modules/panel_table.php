<?php
function admin_panel_table($title, $field, $table, $order_by)
{
    global $mysqli;
    ?>
    <h5><?php echo $title; ?></h5>
    <table class="table table-striped table-hover table-sm">
        <tr width="100%">
            <th width="15%">ID</th>
            <th width="70%">Name</th>
            <th width="15%" colspan="2">State</th>
        </tr>
        <?php
        $sql = 'SELECT id, '.$field.' AS name, published
                FROM '.$table.'
                ORDER BY '.$order_by.'
                ';

        echo '<tr>';
        if($result=mysqli_query($mysqli,$sql))
        {
            if($result->num_rows)
            {
                // Fetch one and one row
                while($row = mysqli_fetch_object($result))
                {
                    if($row->published)
                    {
                        $published='<i class="fas fa-toggle-on"></i>';
                    }
                    else
                    {
                        $published='<i class="fas fa-toggle-off"></i>';
                    }
                    echo '<td>'.$row->id.'</td>';
                    echo '<td><!--a href="'.$table.'.php?id='.$row->id.'"-->'.$row->name.'<!--/a--></td>';
                    echo '<td>'.$published.'</td>';
                    echo '<td><a href="modules/delete_'.$table.'.php?id='.$row->id.'"><i class="fas fa-trash"></i></a></td>';
                    echo '</tr>';
                }
                // Free result set
                mysqli_free_result($result);
            }
            else
            {
                echo '<td colspan="3">No entries</td>';
            }
        }
        echo '</tr>';
        ?>
    </table>
<?php
}
?>
