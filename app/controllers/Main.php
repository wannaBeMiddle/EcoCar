<?php

namespace App\Controllers;

use App\Modules\System\Container\Container;
use App\Modules\System\Controller\ControllerInterface;
use App\Modules\System\Request\Request;
use App\Modules\System\Session\Session;
use App\Modules\System\User\User;
use App\Modules\System\View\View;

class Main implements ControllerInterface
{
	public function login()
	{
		if(Container::getInstance()->get(User::class)->isAuthorized())
		{
			header('Location: /stat/');
			die();
		}
		$request = Container::getInstance()->get(Request::class);
		$view = Container::getInstance()->get(View::class);
		$email = $request->getPostParameter('email');
		$password = $request->getPostParameter('password');
		$user = [];
		if($email || $password)
		{
			$user = Container::getInstance()->get(User::class)->authorize($email, $password);
			if(!isset($user['errors']))
			{
				header('Location: /stat/');
				die();
			}
		}
		$view->show('login', [
			'email' => $email,
			'user' => $user
		], false);
	}

	public function signup()
	{
		if(Container::getInstance()->get(User::class)->isAuthorized())
		{
			header('Location: /stat/');
			die();
		}
		$request = Container::getInstance()->get(Request::class);
		$view = Container::getInstance()->get(View::class);
		$user = [];
		if($request->getPostParameter('email') && $request->getPostParameter('password'))
		{
			$email = $request->getPostParameter('email');
			$password = $request->getPostParameter('password');
			$repeatedPassword = $request->getPostParameter('repeatedPassword');
			$sensor = $request->getPostParameter('sensor');
			$car = $request->getPostParameter('car');
			$year = $request->getPostParameter('year');
			$engineType = $request->getPostParameter('engineType');
			$mailingAgreement = !is_null($request->getPostParameter('mailingAgreement'));
			$user = Container::getInstance()->get(User::class)->register($email, $password, $repeatedPassword, $sensor, $year, $car, $engineType, $mailingAgreement);
			if(!isset($user['errors']))
			{
				header('Location: /');
				die();
			}
			$user['values'] = [
				'email' => $email,
				'sensor' => $sensor,
				'car' => $car,
				'year' => $year,
				'engineType' => $engineType
			];
		}
		$view->show('signup', $user, false);
	}

	public function logout()
	{
		if(Session::has('USER'))
		{
			Session::unset('USER');
		}
		header('Location: /');
		die();
	}
}