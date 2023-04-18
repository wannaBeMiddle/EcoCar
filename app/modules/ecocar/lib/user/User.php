<?php

namespace App\Modules\Ecocar\User;

use App\Modules\System\Container\Container;
use App\Modules\System\DataBase\MySqlDb;
use App\Modules\System\DataBase\Queries\InsertQuery;
use App\Modules\System\DataBase\Queries\SelectQuery;
use App\Modules\System\DataBase\Queries\UpdateQuery;
use App\Modules\System\Request\Request;
use App\Modules\System\Validator\Rules\Email;
use App\Modules\System\Validator\Rules\Password;
use App\Modules\System\Validator\Rules\Regex;
use App\Modules\System\Validator\Validator;

class User
{
    static public function getUserById(int $id)
    {
        $user = (new SelectQuery())
            ->setTableName('users')
            ->setSelect(['email', 'code', 'model', 'manufacturedYear'])
            ->setWhere([
                'condition' => 'users.id = :id'
            ])
            ->setJoin([
                'type' => 'inner',
                'ref_table' => 'cars',
                'on' => 'this.car = ref.id'
            ])
            ->setJoin([
                'type' => 'inner',
                'ref_table' => 'sensors',
                'on' => 'this.sensor = ref.id'
            ])
            ->setParams([
                'id' => $id
            ])
            ->execution();
        $user = $user->getResult();
        $cars = (new SelectQuery())
            ->setTableName('models')
            ->setSelect(['id', 'country', 'name'])
            ->execution();
        $cars = $cars->getResult();
        return [
            'user' => $user,
            'cars' => $cars
        ];
    }

    static public function editProfile(Request $request): array
    {
        $userData = array_change_key_case($request->getPostParameters(), CASE_LOWER);

        $errors = [];

        $fields = [
            'email' => $userData['email'],
            'password' => $userData['password'],
        ];

        $rules = [
            'email' => [
                new Email()
            ],
            'password' => [
                new Password()
            ],
        ];

        $validation = Validator::run($fields, $rules);
        if(in_array(false, $validation))
        {
            foreach ($validation as $validatedField => $validateResult)
            {
                if(!$validateResult)
                {
                    $errors[$validatedField] = "Невалидное поле - {$validatedField}";
                }
            }
        }

        if($userData['password'] !== $userData['repeated_password'])
        {
            $errors[] = "Пароли не совпадают";
        }

        if(!$errors)
        {
            $db = Container::getInstance()->get(MySqlDb::class);
            $sql = "UPDATE `users` SET `email` = :email, `password` = :password WHERE `id` = :id";
            $userUpdate = $db->query($sql, [
                'email' => $userData['email'],
                'password' => password_hash($userData['password'], PASSWORD_BCRYPT),
                'id' => Container::getInstance()->get(\App\Modules\System\User\User::class)->getId()
            ]);
            if(!$userUpdate->getError())
            {
                $user = (new SelectQuery())
                    ->setTableName('users')
                    ->setSelect(['car'])
                    ->setWhere([
                        'condition' => 'users.id = :id'
                    ])
                    ->setParams([
                        'id' => Container::getInstance()->get(\App\Modules\System\User\User::class)->getId()
                    ])
                    ->execution();
                $userCar = $user->getResult()['car'];
                $sql = "UPDATE `cars` SET `manufacturedYear` = :year, `model` = :model WHERE `id` = :id";
                $carUpdate = $db->query($sql, [
                    'manufacturedYear' => $userData['datepicker'],
                    'model' => $userData['car'],
                    'id' => $userCar
                ]);
            }else
            {
                $errors = "Ошибка обновления данных";
            }
        }
        return [
            'errors' => $errors
        ];
    }

    static public function addQuestion(Request $request)
    {
        $userData = array_change_key_case($request->getPostParameters(), CASE_LOWER);
        (new InsertQuery())
            ->setTableName('questions')
            ->setFields(['name', 'email', 'question', 'user'])
            ->setValues([':name', ':email', ':question', ':user'])
            ->setParams([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'question' => $userData['question'],
                'user' => Container::getInstance()->get(\App\Modules\System\User\User::class)->getId()
            ])
            ->execution();
    }
}