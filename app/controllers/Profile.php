<?php

namespace App\Controllers;

use App\Modules\System\Container\Container;
use App\Modules\System\Controller\ControllerInterface;
use App\Modules\System\Request\Request;
use App\Modules\System\User\User;
use App\Modules\Ecocar\User\User as Us;
use App\Modules\System\View\View;

class Profile implements ControllerInterface
{
    public function getProfile()
    {
        $this->redirectIfNotAuthorized();

        /**
         * @var $request Request
         */
        $request = Container::getInstance()->get(Request::class);
        $view = Container::getInstance()->get(View::class);
        if($request->getPostParameters())
        {
            $result = Us::editProfile($request);
            if(!$result['errors'])
            {
                header('Location: /profile');
                die();
            }else
            {
                $user = Us::getUserById(Container::getInstance()->get(User::class)->getId());
                $cars = [];
                foreach ($user['cars'] as $car)
                {
                    $cars[$car['country']][] = [
                        'name' => $car['name'],
                        'id' => $car['id']
                    ];
                }
                $view->show('profile', [
                    'user' => $user['user'],
                    'cars' => $cars,
                    'errors' => ['errors' => $result]
                ], false);
            }
        }else
        {
            $user = Us::getUserById(Container::getInstance()->get(User::class)->getId());
            $cars = [];
            foreach ($user['cars'] as $car)
            {
                $cars[$car['country']][] = [
                    'name' => $car['name'],
                    'id' => $car['id']
                ];
            }
            $view->show('profile', [
                'user' => $user['user'],
                'cars' => $cars
            ], false);
        }
    }

    protected function redirectIfNotAuthorized(): void
    {
        if(!Container::getInstance()->get(User::class)->isAuthorized())
        {
            header('Location: /');
            die();
        }
    }
}