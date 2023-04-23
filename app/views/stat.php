<?$this->setTitle("Мой автомобиль")?>
<table class="table table-hover">
	<thead>
	<tr>
		<th scope="col">Компонент</th>
		<th scope="col">Содержание по объему, %</th>
		<th scope="col">Примечание</th>
	</tr>
	</thead>
	<tbody>
    <?foreach ($result['values'] as $component):?>
        <tr <?=$component['error']?'class="table-danger"':'scope="row"'?>>
            <th><?=$component['name']?></th>
            <td><?=$component['value']?></td>
            <td><?=$component['message']?></td>
        </tr>
    <?endforeach;?>
	</tbody>
</table>
<?if($result['values'][0]['lastReloadDate']):?>
    <p>Данные обновлены: <?=$result['values'][0]['lastReloadDate']?></p>
<?endif;?>
<button type="button" class="btn btn-primary">Запросить обновление данных</button>
<div class="table-explaining">
    <?if(isset($result['messages'])):?>
        <?if(!$result['messages']):?>
            <h4>Проблем не обнаружено.</h4>
        <?else:?>
        <h4>Найденные проблемы:</h4>
        <?foreach ($result['messages'] as $message):?>
            <p><?=$message?></p>
        <?endforeach;?>
        <?endif;?>
    <?endif;?>
</div>