<table class="table table-hover">
	<thead>
	<tr>
		<th scope="col">Компонент</th>
		<th scope="col">Содержание по объему, %</th>
		<th scope="col">Примечание</th>
		<th scope="col">Действие</th>
	</tr>
	</thead>
	<tbody>
    <?foreach ($result['values'] as $component):?>
        <tr <?=$component['error']?'class="table-danger"':'scope="row"'?>>
            <th><?=$component['name']?></th>
            <td data-prop-id="<?=$component['id']?>"><?=$component['value']?></td>
            <td><?=$component['message']?></td>
            <td><button type="button" data-user-id="<?=$result['user']?>" data-prop-id="<?=$component['id']?>" class="btn btn-warning edit-prop">Редактировать</button> </td>
        </tr>
    <?endforeach;?>
	</tbody>
</table>