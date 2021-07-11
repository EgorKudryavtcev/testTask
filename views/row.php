<tr style="background-color: #ffffff">
    <th class="numbers"></th>
    <?php foreach($columns as $column):?>
        <td data-column_id="<?php echo $column['id'];?>" data-row_id="<?php echo $row_id;?>" class="cell-<?php echo $row_id;?>-<?php echo $column['id']?>"><?php echo (isset($cells[$column['id']][$row_id]) ? $cells[$column['id']][$row_id]['value'] :'')?></td>
    <?php endforeach;?>
    <th class="buttons-th"><i class="icons pen edit-row" data-row_id="<?php echo $row['id']?>" title="Изменить цвет фона ряда на случайный"></i></th>
    <th class="buttons-th"><i class="icons reset reset-row" data-row_id="<?php echo $row['id']?>" title="Изменить цвет фона ряда на белый"></i></th>
    <th class="buttons-th"><i class="icons trash delete-row" data-row_id="<?php echo $row['id']?>" title="Удалить ряд"></i></th>
</tr>