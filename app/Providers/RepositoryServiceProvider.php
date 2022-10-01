<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository\UserRepositoryInterface;
use App\Repositories\UserRepository\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var array $repositories
     */
    protected array $repositories = [
        UserRepositoryInterface::class => UserRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $k => $val) {
            $this->app->singleton($k, $val);
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
