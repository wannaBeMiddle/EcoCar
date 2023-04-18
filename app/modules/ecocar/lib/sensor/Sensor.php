<?php

namespace App\Modules\Ecocar\Sensor;

use App\Modules\System\Container\Container;
use App\Modules\System\DataBase\Queries\SelectQuery;
use App\Modules\System\User\User;

class Sensor
{
	public function getSensorStatistic(): array
	{
		$userId = Container::getInstance()->get(User::class)->getId();
		$sensorPropertiesValues = (new SelectQuery())
			->setTableName('sensorPropertiesValues')
			->setSelect([
				'sensorPropertiesValues.value',
				'sensorProperties.name',
				'sensorProperties.chemicalName',
				'sensors.lastReloadDate',
				'normalValues.minValue',
				'normalValues.maxValue'
			])
			->setJoin([
				'type' => 'inner',
				'ref_table' => 'sensors',
				'on' => 'this.sensor = ref.id'
			])
			->setJoin([
				'type' => 'inner',
				'ref_table' => 'users',
				'on' => 'users.sensor = sensors.id'
			])
			->setJoin([
				'type' => 'inner',
				'ref_table' => 'cars',
				'on' => 'users.car = cars.id'
			])
			->setJoin([
				'type' => 'inner',
				'ref_table' => 'sensorProperties',
				'on' => 'this.property = ref.id'
			])
			->setJoin([
				'type' => 'inner',
				'ref_table' => 'normalValues',
				'on' => 'ref.sensorProperty = sensorProperties.id'
			])
			->setWhere([
				'condition' => "users.id = :id"
			])
			->setWhere([
				'condition' => "normalValues.engineType = cars.engineType",
				'logic' => 'and'
			])
			->setParams([
				'id' => $userId
			])
			->execution();
		$values = $sensorPropertiesValues->getResult();
		foreach ($values as &$value)
		{
			if($value['value'] > $value['maxValue'])
			{
				$value['error'] = true;
				$value['message'] = 'Выше нормы';
				continue;
			}
			if($value['value'] < $value['minValue'])
			{
				$value['error'] = true;
				$value['message'] = 'Ниже нормы';
				continue;
			}
			$value['error'] = false;
			$value['message'] = 'В норме';
		}
		unset($value);
		return $values;
	}

	public function getMessagesByStatistic(array $statistic): array
	{
		$messages = [];
		if($statistic)
		{
			$defaultMessages = require_once $_SERVER['DOCUMENT_ROOT'] . "/app/modules/ecocar/include/messages.php";
			$wrongData = [];
			foreach ($statistic as $statValue)
			{
				if($statValue['error'])
				{
					$wrongData[] = $statValue['chemicalName'];
				}
			}
			foreach($defaultMessages as $key => $message)
			{
				$arKeys = explode(' ', $key);
				if(!array_diff($arKeys, $wrongData))
				{
					$messages[] = $message;
				}
			}
			if(!$messages)
			{
				$messages[] = $defaultMessages['default'];
			}
		}
		return $messages;
	}
}