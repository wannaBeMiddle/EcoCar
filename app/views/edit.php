<?php
$this->setTitle("Изменить показания счетчиков");
?>
<div class="table-block">

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $.ajax({
        url: '/admin/getUserStat',
        method: 'get',
        dataType: 'html',
        data: {user: <?=$result['user']?>},
        success: function(data){
            $('.table-block').html(data);
        }
    });

    $('body').on('click', '.edit-prop', function () {
        let value = prompt('Введите новое значение');
        $.ajax({
            url: '/admin/editProp',
            method: 'post',
            dataType: 'json',
            data: {
                user: $(this).attr('data-user-id'),
                prop: $(this).attr('data-prop-id'),
                value: value
            },
            success: function(data){
                if(data.result.result)
                {
                    let container = $('td[data-prop-id='+data.prop+']');
                    container.html(value);
                    if(data.result.eq === 'eq')
                    {
                        container.closest('tr').attr('scope', 'row');
                        container.closest('tr').removeAttr('class');
                        container.next().html(data.result.message);
                    }else
                    {
                        container.closest('tr').attr('class', 'table-danger');
                        container.closest('tr').removeAttr('scope');
                        container.next().html(data.result.message);
                    }
                }
            }
        });
    });
</script>
