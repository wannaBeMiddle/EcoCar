<?php

namespace App\Modules\Ecocar\Sensor;

use App\Modules\System\Container\Container;
use App\Modules\System\DataBase\DataBaseResult;
use App\Modules\System\DataBase\MySqlDb;
use App\Modules\System\DataBase\Queries\SelectQuery;
use App\Modules\System\Request\Request;
use App\Modules\System\User\User;
use App\Modules\Ecocar\User\User as Us;

class Sensor
{
	public function getSensorStatistic(int $userId): array
	{
		$sensorPropertiesValues = (new SelectQuery())
			->setTableName('sensorPropertiesValues')
			->setSelect([
				'sensorPropertiesValues.value',
				'sensorProperties.name',
				'sensorProperties.id',
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

	public function editSensorProp(int $userId, int $propId, float $value): array
	{
		$user = Us::getUserById($userId);
		$sensor = $user['user']['sensor'];
		$db = Container::getInstance()->get(MySqlDb::class);
		$sql = "UPDATE `sensorPropertiesValues` SET `value` = :value WHERE `property` = :prop AND `sensor` = :sensor";
		/**
		 * @var $result DataBaseResult
		 */
		$result = $db->query($sql, [
			'value' => $value,
			'prop' => $propId,
			'sensor' => $sensor
		]);
		$normalVals = (new SelectQuery())
			->setTableName('normalValues')
			->setSelect(['minValue', 'maxValue'])
			->setWhere([
				'condition' => 'sensorProperty = :prop',
				'logic' => 'AND'
			])
			->setWhere([
				'condition' => 'engineType = :engineType',
				'logic' => 'AND'
			])
			->setParams([
				'prop' => $propId,
				'engineType' => $user['user']['engineType']
			])
			->execution()
			->getResult();
		if($value >= $normalVals['minValue'] && $value <= $normalVals['maxValue'])
		{
			$message = 'В норме';
			$eq = 'eq';
		}elseif($value < $normalVals['minValue'])
		{
			$message = 'Ниже нормы';
			$eq = 'l';
		}else
		{
			$message = 'Выше нормы';
			$eq = 'more';
		}
		if($result->getRowsCount() > 0)
		{
			return [
				'result' => true,
				'message' => $message,
				'eq' => $eq
			];
		}
		return [
			'result' => false,
		];
	}
}