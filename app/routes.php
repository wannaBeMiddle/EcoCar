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
];