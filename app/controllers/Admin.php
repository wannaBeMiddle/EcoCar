<?php

namespace App\Controllers;

use App\Modules\Ecocar\Sensor\Sensor;
use App\Modules\Ecocar\User\User as Us;
use App\Modules\System\Container\Container;
use App\Modules\System\Controller\ControllerInterface;
use App\Modules\System\Request\Request;
use App\Modules\System\User\User;
use App\Modules\System\View\View;

class Admin implements ControllerInterface
{
	public function start()
	{
		$user = Us::getUserById(Container::getInstance()->get(User::class)->getId());
		$view = Container::getInstance()->get(View::class);
		if($user['user']['role'] !== 'A')
		{
			header('Location: /');
			die();
		}
		$users = Us::getUsers();
		$view->show('admin', [
			'users' => $users
		], true);
	}

	public function getStat()
	{
		/**
		 * @var $request Request
		 */
		$request = Container::getInstance()->get(Request::class);
		$view = Container::getInstance()->get(View::class);
		if($user = $request->getQueryParameter('user'))
		{
			$sensor = new Sensor();
			$values = $sensor->getSensorStatistic($user);
			if(!$values)
			{
				$props = $sensor->getSensorProps();
				echo '<h4>Показания датчика отсутствуют</h4>';
				$view->show('add_values', [
					'props' => $props,
				], false);
				die();
			}
			$view->show('admin_stat', [
				'values' => $values,
				'user' => $user
			], false);
			die();
		}
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		die();
	}

	public function editProp()
	{
		/**
		 * @var $request Request
		 */
		$request = Container::getInstance()->get(Request::class);
		$user = $request->getPostParameter('user');
		$prop = $request->getPostParameter('prop');
		$value = $request->getPostParameter('value');
		$sensor = new Sensor();
		$result = $sensor->editSensorProp($user, $prop, $value);
		echo json_encode([
			'result' => $result,
			'prop' => $prop]
		);
		die();
	}

	public function addValues()
	{
		/**
		 * @var $request Request
		 */
		$request = Container::getInstance()->get(Request::class);
		$userId = $request->getPostParameter('userId');
		if(!$userId)
		{
			$userId = Container::getInstance()->get(User::class)->getId();
		}
		$sensor = new Sensor();
		$result = $sensor->addValues($request->getPostParameter('values'), $userId);
		echo json_encode($result);
		die();
	}
}