<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';
    protected $namespace = 'App\Http\Controllers';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {

                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group(base_path('routes/web.php'));

                // $this->mapApiRoutes();
                $this->mapSiteRoutes();
                $this->mapAdminApiRoutes();
                $this->mapSiteDesignRoutes();
        });
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace.'\Api\V1')
             ->group(base_path('routes/api.php'));
    }

    protected function mapAdminApiRoutes()
    {
        Route::prefix('AdminApi')
             ->middleware('AdminApi')
             ->namespace($this->namespace.'\AdminApi')
             ->group(base_path('routes/AdminApi.php'));
    }

    protected function mapSiteRoutes()
    {
        Route:: namespace($this->namespace.'\Site')
             ->middleware('site')
             ->group(base_path('routes/Site.php'));
    }

    protected function mapSiteDesignRoutes()
    {
           Route::prefix('Design')
             ->namespace($this->namespace.'\Design')
             ->group(base_path('routes/Design.php'));
    }



    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
