<?php
$this->setTitle("Административная страница");
?>
<form>
	<div class="form-header">
		<h4>Административная страница</h4>
	</div>
	<div class="mb-3">
		<label for="carName" class="form-label">Выберите пользователя из списка</label>
		<select class="selectpicker form-select" id="carName" data-live-search="true">
			<?foreach($result['users'] as $user):?>
				<option value="<?=$user['id']?>">(<?=$user['id']?>) <?=$user['email']?></option>
			<?endforeach;?>
		</select>
	</div>
</form>
<div class="table-block">

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
	$('.selectpicker').on('change', function () {
        let userId = $( this ).val();
        $.ajax({
            url: '/admin/getUserStat',
            method: 'get',
            dataType: 'html',
            data: {user: userId},
            success: function(data){
                $('.table-block').html(data);
            }
        });
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
