$(document).ready(function () {
    var modelForm = $('#modelCellValue');
    $('table.color-table').on('dblclick', 'td', function () {
        let item = $(this);
        modelForm.show().find('input[type=text]').focus().val(item.text());
        modelForm.find('.class').val(item.attr('class'));
        modelForm.find('.column_id').val(item.data('column_id'));
        modelForm.find('.row_id').val(item.data('row_id'));
    });

    modelForm.find('input[name=value]').keypress(function (e) {
        if(e.which === 13)
            saveCell();
    });

    $('#modelCellValue .close').click( function(){
        modelForm.hide();
    });
    $('#modelCellValue .save').click(function () {
        saveCell();
    });

    function saveCell() {
        let value = modelForm.find('input[type=text]').val();
        $.ajax( {
            type: "POST",
            url: saveCellUrl,
            data: { value: value, row_id:  modelForm.find('.row_id').val(), column_id:  modelForm.find('.column_id').val()},
            dataType:'json'
        }).done(function( data ) {
            if (typeof data.result != 'undefined') {
                if (data.result === 'success') {
                    $('.color-table').find('.' + modelForm.find('.class').val()).text(value);
                } else if (data.result === 'error') {
                    alert(data.msg);
                }
            }
            modelForm.find('.class').val('');
            modelForm.find('.column_id').val('');
            modelForm.find('.row_id').val('');
        });
        modelForm.hide();
    }


    $('.add-row').click(function () {
        $.ajax({
            type: 'POST',
            url: addRowUrl,
            data: { table_id: $(this).data('table_id')},
            dataType: 'json'
        }).done(function (data) {
            if (typeof data.result != 'undefined') {
                if (data.result === 'success') {
                    $('table.color-table tbody').append(data.row);
                    reIndexRows();
                } else if (data.result === 'error') {
                    alert(data.msg);
                }
            }
        });
    });
    $(document).on('click', '.reset-row', function () {
        change_color($(this), 'FFFFFF');
    });
    $(document).on('click', '.edit-row',function () {
        change_color($(this));
    });
    
    function change_color(item, color = '') {
        $.ajax({
            type: 'POST',
            url: editRowUrl,
            data: { row_id: item.data('row_id'), color: color},
            dataType: 'json'
        }).done(function (data) {
            if (typeof data.result != 'undefined') {
                if (data.result === 'success') {
                    item.parent().parent().css('background-color', data.color);
                } else if (data.result === 'error') {
                    alert(data.msg);
                }
            }
        });
    }
    function reIndexRows() {
        $('th.numbers').each(function (index, item) {
            $(item).text(index + 1);
        });
    }

    $(document).on('click', '.delete-row',function () {
        let item = $(this);
        $.ajax({
            type: 'POST',
            url: deleteRowUrl,
            data: { row_id: $(this).data('row_id')},
            dataType: 'json'
        }).done(function (data) {
            if (typeof data.result != 'undefined') {
                if (data.result === 'success') {
                    item.parent().parent().remove();
                    reIndexRows();
                } else if (data.result === 'error') {
                    alert(data.msg);
                }
            }
        });
    });
});