<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService\UserServiceInterface;
use App\Services\UserService\UserService;

class ServicesServiceProvider extends ServiceProvider
{
    protected array $services = [
        UserServiceInterface::class => UserService::class,
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->services as $k => $val) {
            $this->app->bind($k, $val);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
