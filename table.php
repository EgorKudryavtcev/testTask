<?php require_once 'functions.php';
include_once 'views/layouts/header.php';
$table_id = addslashes($_GET['table_id']);
$table = get_table_by_id($table_id);
$cells = get_cells($table_id);
?>

<div class="container">
    <table class="color-table">
        <caption>Таблица: <?php echo $table['title']?></caption>
        <tr>
            <th style="width: 20px">№</th>
            <?php
            $columns = get_columns_by_table_id($table_id);
            foreach ($columns as $column):?>
                <th>
                    <?php echo $column['title']?>
                </th>
            <?php endforeach;?>
        <th class="buttons-th"></th>
        <th class="buttons-th"></th>
        <th class="buttons-th"></th>
        </div>
        <div class="row">
            <?php foreach (get_rows_by_table_id($table_id) as $key => $row):?>
                <tr style="background-color: <?php echo $row['color'];?>">
                    <th class="numbers"><?php echo $key+1;?></th>
                    <?php foreach($columns as $column):?>
                        <td data-column_id="<?php echo $column['id'];?>" data-row_id="<?php echo $row['id'];?>" class="cell-<?php echo $row['id'];?>-<?php echo $column['id']?>"><?php echo (isset($cells[$column['id']][$row['id']]) ? $cells[$column['id']][$row['id']]['value'] :'')?></td>
                    <?php endforeach;?>
                    <th class="buttons-th"><i class="icons pen edit-row" data-row_id="<?php echo $row['id']?>" title="Изменить цвет фона ряда на случайный"></i></th>
                    <th class="buttons-th"><i class="icons reset reset-row" data-row_id="<?php echo $row['id']?>" title="Изменить цвет фона ряда на белый"></i></th>
                    <th class="buttons-th"><i class="icons trash delete-row" data-row_id="<?php echo $row['id']?>" title="Удалить ряд"></i></th>
                </tr>
            <?php endforeach;?>
        </div>
    </table>
    <div class="row mar-t-5 mar-l-10">
        <i class="icons plus add-row" data-table_id="<?php echo $table['id']?>" title="Добавить новый ряд"></i>
    </div>
</div>
<script>
    var saveCellUrl = '/ajax/saveCell.php',
        addRowUrl = '/ajax/addRow.php',
        editRowUrl = '/ajax/editRow.php',
        deleteRowUrl = '/ajax/deleteRow.php';
</script>
<?php include_once 'views/layouts/footer.php';?>
