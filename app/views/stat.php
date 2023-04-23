<?$this->setTitle("Мой автомобиль")?>
<?if(isset($result['values']) && count($result['values'])):?>
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
<?else:?>
<h4>Показания датчика отсутствуют</h4>
<?endif;?>
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