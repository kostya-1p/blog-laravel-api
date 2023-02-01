<?php

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return new CategoryRepository();
        });

        $this->app->bind(TagRepositoryInterface::class, function ($app) {
            return new TagRepository();
        });

        $this->app->bind(ArticleRepositoryInterface::class, function ($app) {
            return new ArticleRepository();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
