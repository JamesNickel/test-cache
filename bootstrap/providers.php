<?php

$providers = [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
];
//if ($this->app->environment(['local', 'staging'])) {
//    $providers[] = Eghamat24\DatabaseRepository\DatabaseRepositoryServiceProvider::class;
//}
return $providers;
