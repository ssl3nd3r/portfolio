<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Blade;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Menu\MenuItem;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function ($request) {
            return [
                // MenuSection::dashboard('Main'),
                MenuItem::resource(\App\Nova\Info::class)
                    ->name('Info')
                    ->path('/resources/infos/1/edit'), // This is the detail page for Info with id 1
                MenuItem::resource(\App\Nova\Project::class),
                MenuItem::resource(\App\Nova\User::class),
            ];
        });

        Nova::footer(function($request) {
            return Blade::render('
                <div class="mt-8 leading-normal text-xs text-gray-500 space-y-1">
                    <p class="text-center">
                        <a class="link-default" href="/">Jimmy Jradeh</a> · {{date("Y")}}
                    </p>
                </div>
            ');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
