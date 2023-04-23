<?php

use App\Modules\System\Router\Route;

return [
	new Route('example/{id}/{code}', 'Example', 'example', 'GET'),
	new Route('/', 'Main', 'login'),
	new Route('/signup/', 'Main', 'signup'),
	new Route('/stat/', 'Stat', 'getStatistic'),
	new Route('/logout/', 'Main', 'logout'),
	//new Route('keylogging/getOptions', 'KeyLogging', 'getOptions', 'GET'),
	new Route('keylogging/', 'KeyLogging', 'send', 'POST'),
	new Route('keylogging/getOptions', 'KeyLogging', 'getOptions', 'GET'),
	new Route('/profile', 'Profile', 'getProfile'),
	new Route('/question', 'Question', 'addQuestion'),
	new Route('/admin', 'Admin', 'start'),
	new Route('/admin/getUserStat', 'Admin', 'getStat', 'GET'),
	new Route('/admin/editProp', 'Admin', 'editProp', 'POST'),
	new Route('/edit/', 'Main', 'edit', 'GET'),
	new Route('/admin/addValues', 'Admin', 'addValues', 'POST'),
];