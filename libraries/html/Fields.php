<?php
class Fields
{
    public function __construct()
    {
        //if ($debug_mode) echo 'A classe "', __CLASS__, '" foi instanciada!<br />';
    }

    public function __destruct()
    {
        //if ($debug_mode) echo 'A classe "', __CLASS__, '" foi destruída!<br />';
    }

    function radioToggle ($label, $field, $values, $table, $id, $checked, $class)
    {
        if (!$id):
            $checked = $checked;
        else:
            // Global scope
            $db = Database::instance();

            $row = $db
                ->select($table, 'id = '.$id, false, false, false, $field)
                ->row_array();
            $checked = $row[$field];
        endif;

        //if ($debug_mode) echo $checked;

        $n = mt_rand(0, 99);
        $yesno = (!$checked) ? 'no' : 'yes';
        ?>
        <div class="form-group form-toggle<?php if ($class) echo ' '.$class; ?>">
            <div class="form-label"><?php echo $label; ?></div>
            <div id="cover<?php echo $n; ?>"<?php if ($class == 'yesno') echo ' class="'.$yesno.'"'; ?>>
                <?php foreach ($values as $key => $value): ?>
                <input type="radio" name="<?php echo $field; ?>" id="<?php echo $value.$n; ?>" value="<?php echo $key; ?>"<?php if ($key == $checked) echo ' checked="checked"'; ?> />
                <label for="<?php echo $value.$n; ?>" class="btn btn-sm"><?php echo ucfirst($value); ?></label>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if ($class == 'yesno'): ?>
        <script>
        (function (){
            var radios = document.getElementsByName('<?php echo $field; ?>');
            console.log(radios);
            for (var i = 0; i < radios.length; i++)
            {
                radios[i].onclick = function()
                {
                    document.getElementById('cover<?php echo $n; ?>').className = this.id;
                }
            }
        })();
        </script>
        <?php endif; ?>
    <?php
    }

    function select ($label, $field, $values, $table, $id, $selected, $option, $multiple)
    {
        if (!$id):
            $selected = $selected;
        else:
            // Global scope
            $db = Database::instance();

            $row = $db
                ->select($table, 'id = '.$id, false, false, false, $field)
                ->row_array();
            $selected = $row[$field];
        endif;
        //echo $db->sql().'<br />';
        //echo $selected.'<br />';
        //echo $row[$field].'<br />';
    ?>
    <div class="form-group">
        <label for="<?php echo $field; ?>"><?php echo $label; ?></label>
        <select id="<?php echo $field; ?>" class="form-control" name="<?php echo $field; ?>"<?php if($multiple) echo ' multiple'; ?>>
            <?php echo $option; ?>
            <?php foreach($values as $key => $value): ?>
                <option name="<?php echo lcfirst($value); ?>" value="<?php echo $key; ?>"<?php if ($key == $selected) echo ' selected'; ?>><?php echo $value; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php
    }

    function selectDB ($label, $field, $value, $name, $fromTable, $toTable, $where, $order_by, $option, $required, $multiple)
    {
        // Global scope
        $db = Database::instance();

        $fromResult = $db
            ->select($fromTable, 'published = 1', false, $order_by, false, 'id, '.$name)
            ->result_array();
        //echo $db->count($fromResult).'<br />';
        //echo $db->sql($fromResult).'<br />';
        //echo '<pre>';print_r($fromResult);echo '</pre>'.'<br />';

        if($value):
            $toResult = $db
                ->select($toTable, $field.' = '.$value, false, false, false, $field)
                ->row_array();
            //echo $db->count($toResult).'<br />';
            //echo $db->sql($toResult).'<br />';
            //echo '<pre>';print_r($toResult);echo '</pre>'.'<br />';
        endif;
        ?>
        <div class="form-group">
            <label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($required) echo ' *'; ?></label>
            <select id="<?php echo $field; ?>" class="form-control" name="<?php echo $field; ?>"<?php if ($required) echo ' required'; ?><?php if($multiple) echo ' multiple'; ?>>
                <?php echo $option; ?>
                <?php if ($db->count($fromResult)): ?>
                <?php foreach ($fromResult as $row): ?>
                <option name="<?php echo lcfirst($row['name']); ?>" value="<?php echo $row['id']; ?>"<?php if($value) echo $selected = ($toResult[$field] == $row['id']) ? ' selected="selected"' : ''; ?>><?php echo ucfirst($row['name']); ?></option>
                <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    <?php
    }

    function text ($label, $field, $value, $placeholder, $attributes)
    {
    ?>
    <div class="form-group">
        <label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($attributes == 'required') echo ' *'; ?></label>
        <input type="text" class="form-control" name="<?php echo $field; ?>" id="<?php echo $field; ?>" aria-describedby="<?php echo $field; ?>Help" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>"<?php if ($attributes) echo ' '.$attributes; ?>>
    </div>
    <?php
    }

    function textarea ($label, $field, $value, $attributes)
    {
    ?>
    <label for="<?php echo $field; ?>"><?php echo $label; ?><?php if ($attributes == 'required') echo ' *'; ?></label>
    <textarea class="form-control" id="<?php echo $field; ?>" name="<?php echo $field; ?>" <?php if ($attributes) echo ' '.$attributes; ?>><?php echo $value; ?></textarea>
    <?php
    }

}
?>