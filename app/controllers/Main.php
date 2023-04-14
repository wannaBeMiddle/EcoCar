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
		$this->redirectIfAuthorized();

		$request = Container::getInstance()->get(Request::class);
		$view = Container::getInstance()->get(View::class);

		$userData = [
			'EMAIL' => $request->getPostParameter('email'),
			'PASSWORD' => $request->getPostParameter('password')
		];

		$user = [];
		if($userData['EMAIL'] || $userData['PASSWORD'])
		{
			$user = Container::getInstance()->get(User::class)->authorize($userData);
			if(!isset($user['errors']))
			{
				header('Location: /stat/');
				die();
			}
		}

		$view->show('login', [
			'email' => $userData['EMAIL'],
			'errors' => $user['errors']??[]
		], false);
	}

	public function signup()
	{
		$this->redirectIfAuthorized();

		$request = Container::getInstance()->get(Request::class);
		$view = Container::getInstance()->get(View::class);
		$userData = [
			'EMAIL' => $request->getPostParameter('email'),
			'PASSWORD' => $request->getPostParameter('password'),
			'REPEATED_PASSWORD' => $request->getPostParameter('repeatedPassword'),
			'SENSOR' => $request->getPostParameter('sensor'),
			'CAR' => $request->getPostParameter('car'),
			'YEAR' => $request->getPostParameter('year'),
			'ENGINE_TYPE' => $request->getPostParameter('engineType'),
			'MAILING_AGREEMENT' => !is_null($request->getPostParameter('mailingAgreement'))
		];
		$user = [];
		if($request->getPostParameter('email') && $request->getPostParameter('password'))
		{
			$user = Container::getInstance()->get(User::class)->register($userData);
			if(!isset($user['errors']))
			{
				header('Location: /');
				die();
			}
			$user['values'] = [
				'email' => $userData['EMAIL'],
				'sensor' => $userData['SENSOR'],
				'car' => $userData['CAR'],
				'year' => $userData['YEAR'],
				'engineType' => $userData['ENGINE_TYPE']
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

	protected function redirectIfAuthorized(): void
	{
		if(Container::getInstance()->get(User::class)->isAuthorized())
		{
			header('Location: /stat/');
			die();
		}
	}
}