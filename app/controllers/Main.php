<?php

namespace App\Controllers;

use App\Modules\Ecocar\User\User as Us;
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

		/**
		 * @var $request Request
		 */
		$request = Container::getInstance()->get(Request::class);
		$view = Container::getInstance()->get(View::class);

		$user = [];
		if($request->getPostParameter('email') || $request->getPostParameter('password'))
		{
			$user = Container::getInstance()->get(User::class)->authorize($request);
			if(!isset($user['errors']))
			{
				header('Location: /stat/');
				die();
			}
		}

		$view->show('login', [
			'email' => $request->getPostParameter('email'),
			'errors' => $user['errors']??[]
		], false);
	}

	public function signup()
	{
		$this->redirectIfAuthorized();

		/**
		 * @var $request Request
		 */
		$request = Container::getInstance()->get(Request::class);
		$view = Container::getInstance()->get(View::class);
		$user = [];
		if($request->getPostParameter('email') && $request->getPostParameter('password'))
		{
			$user = Container::getInstance()->get(User::class)->register($request);
			if(!isset($user['errors']))
			{
				header('Location: /');
				die();
			}
			$user['values'] = $request->getPostParameters();
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

	public function edit()
	{
		$user = Container::getInstance()->get(User::class)->getId();
		if ($user)
		{
			$view = Container::getInstance()->get(View::class);
			$view->show('edit', [
				'user' => Container::getInstance()->get(User::class)->getId()
			], true);
		}
	}
}