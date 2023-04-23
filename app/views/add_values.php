<table class="table table-hover">
	<thead>
	<tr>
		<th scope="col">Компонент</th>
		<th scope="col">Содержание по объему, %</th>
	</tr>
	</thead>
	<tbody>
	<?foreach ($result['props'] as $prop):?>
		<tr scope="row">
			<th><?=$prop['name']?></th>
			<td> <input type="number" class="form-control new-value" data-prop-id="<?=$prop['id']?>"> </td>
		</tr>
	<?endforeach;?>
	</tbody>
</table>
<button type="button" class="btn btn-primary save">Сохранить</button>