<?php
function field_checkbox ($label, $field, $value, $attributes)
{
?>
<div class="form-check">
    <input type="checkbox" class="form-check-input" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $value; ?>"<?php if ($attributes) echo ' '.$attributes; ?>>
    <label for="<?php echo $field; ?>" class="form-check-label"><?php echo $label; ?></label>
</div>
<?php
}

function field_date ($label, $field, $value, $placeholder, $attributes)
{
?>
<div class="form-group">
    <label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($attributes == 'required') echo ' *'; ?></label>
    <input type="date" class="form-control" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $value; ?>" aria-describedby="<?php echo $field; ?>Help" placeholder="<?php echo $placeholder; ?>"<?php if ($attributes) echo ' '.$attributes; ?>>
</div>
<?php
}

function field_email ($label, $field, $value, $placeholder, $attributes)
{
?>
<div class="form-group">
    <label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($attributes == 'required') echo ' *'; ?></label>
    <input type="email" class="form-control" name="<?php echo $field; ?>" id="<?php echo $field; ?>" aria-describedby="<?php echo $field; ?>Help" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>"<?php if ($attributes) echo ' '.$attributes; ?>>
</div>
<?php
}

function field_number ($label, $field, $value, $placeholder, $min, $max, $step)
{
?>
<div class="form-group">
    <label for="<?php echo $field; ?>"><?php echo $label; ?></label>
    <input type="number" class="form-control" name="<?php echo $field; ?>" id="<?php echo $field; ?>" aria-describedby="<?php echo $field; ?>Help" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>">
</div>
<?php
}

function field_password ($label, $field, $value, $placeholder, $attributes)
{
?>
<div class="form-group">
    <label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($attributes == 'required') echo ' *'; ?></label>
    <input type="password" class="form-control" name="<?php echo $field; ?>" id="<?php echo $field; ?>" aria-describedby="<?php echo $field; ?>Help" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>"<?php if ($attributes) echo ' '.$attributes; ?>>
</div>
<?php
}

function field_select ($label, $field, $values, $table, $id, $selected, $option, $multiple)
{
    if (!$id)
    {
        $selected = $selected;
    }
    else
    {
        global $mysqli;
        $sql = 'SELECT '.$field.' FROM '.$table.' WHERE id = '.$id;
        $result = $mysqli->query($sql)
            or die($mysqli->connect_error);
        $row = mysqli_fetch_assoc($result);
        $selected = $row[$field];
    }
    //echo $selected;
?>
<div class="form-group">
    <label for="<?php echo $field; ?>"><?php echo $label; ?></label>
    <!--div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Function field_selectDB deprecated. Use libraries/html/Fields.php >> Fields->selectDB instead.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div-->
    <select id="<?php echo $field; ?>" class="form-control" name="<?php echo $field; ?>"<?php if($multiple) echo ' multiple'; ?>>
        <?php
        echo $option;
        foreach($values as $key => $value):
        ?>
            <option name="<?php echo lcfirst($value); ?>" value="<?php echo $key; ?>"<?php if ($key == $selected) echo ' selected'; ?>><?php echo $value; ?></option>
        <?php
        endforeach;
        ?>
    </select>
</div>
<?php
}

function field_selectDB ($label, $field, $value, $name, $fromTable, $toTable, $where, $option, $multiple)
{
global $mysqli;
$fromSql = 'SELECT id, '.$name.' FROM '.$fromTable.' WHERE published = 1 ORDER BY '.$name;
$fromResult = $mysqli->query($fromSql);

if($value)
{
    $toSql = 'SELECT '.$field.' FROM '.$toTable.' WHERE '.$where.' = '.$value;
    $toResult = $mysqli->query($toSql);
    $toRow = mysqli_fetch_row($toResult);
    $selected = '';
/*
    if($toRow[$field] == $fromRow['id'])
    {
        $selected = ' selected';
    }
    else
    {
        $selected = '';
    }
*/
}
?>
<div class="form-group">
    <label for="<?php echo $field; ?>"><?php echo $label; ?></label>
    <!--div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Function field_selectDB deprecated. Use libraries/html/Fields.php >> Fields->selectDB instead.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div-->
    <select id="<?php echo $field; ?>" class="form-control" name="<?php echo $field; ?>"<?php if($multiple) echo ' multiple'; ?>>
        <?php
        echo $option;
        if ($fromResult->num_rows > 0)
        {
            while($fromRow = $fromResult->fetch_assoc())
            {
                echo '<option name="'.lcfirst($fromRow[$name]).'" value="'.$fromRow['id'].'"'.$selected.'>'.ucfirst($fromRow[$name]).'</option>'."\n";
            }
        }
        ?>
    </select>
</div>
<?php
}

function field_tel ($label, $field, $value, $placeholder, $attributes)
{
?>
<div class="form-group">
    <label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($attributes == 'required') echo ' *'; ?></label>
    <input type="tel" class="form-control" name="<?php echo $field; ?>" id="<?php echo $field; ?>" aria-describedby="<?php echo $field; ?>Help" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>"<?php if ($attributes) echo ' '.$attributes; ?>>
</div>
<?php
}

function field_text ($label, $field, $value, $placeholder, $attributes)
{
?>
<div class="form-group">
    <label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($attributes == 'required') echo ' *'; ?></label>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Function field_text deprecated. Use libraries/html/Fields.php >> Fields->text instead.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <input type="text" class="form-control" name="<?php echo $field; ?>" id="<?php echo $field; ?>" aria-describedby="<?php echo $field; ?>Help" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>"<?php if ($attributes) echo ' '.$attributes; ?>>
</div>
<?php
}

function field_textarea ($label, $field, $value, $attributes)
{
?>
<label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($attributes == 'required') echo ' *'; ?></label>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Warning!</strong> Function field_textarea deprecated. Use libraries/html/Fields.php >> Fields->textarea instead.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<textarea class="form-control" id="<?php echo $field; ?>" name="<?php echo $field; ?>" <?php if ($attributes) echo ' '.$attributes; ?>><?php echo $value; ?></textarea>
<?php
}

function field_toggle ($label, $field, $values, $table, $id, $checked, $class)
{
    if (!$id)
    {
        $checked = $checked;
    }
    else
    {
        global $mysqli;
        $sql = 'SELECT '.$field.' FROM '.$table.' WHERE id = '.$id;
        $result = $mysqli->query($sql)
            or die($mysqli->connect_error);
        $row = mysqli_fetch_assoc($result);
        $checked = $row[$field];
    }
    //echo $checked;
    ?>
    <div class="form-label"><?php echo $label; ?></div>
    <!--div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Function field_toggle deprecated. Use libraries/html/Fields.php >> Fields->radioToggle instead.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div-->
    <?php foreach ($values as $key => $value): ?>
        <?php $n = mt_rand (0, 99); ?>
        <input type="radio" name="<?php echo $field; ?>" id="<?php echo $value.$n; ?>" value="<?php echo $key; ?>"<?php if ($key == $checked) echo ' checked'; ?> />
        <label for="<?php echo $value.$n; ?>"><?php echo ucfirst($value); ?></label>
    <?php endforeach; ?>
<?php
}

function field_url ($label, $field, $placeholder, $attributes)
{
?>
<div class="form-group">
    <label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($attributes == 'required') echo ' *'; ?></label>
    <input type="url" class="form-control" name="<?php echo $field; ?>" id="<?php echo $field; ?>" aria-describedby="<?php echo $field; ?>Help" placeholder="<?php echo $placeholder; ?>"<?php if ($attributes) echo ' '.$attributes; ?>>
</div>
<?php
}
?>