<?php

namespace App\Providers;

use App\Models\OrderDetails;
use App\Observers\OrderDetailsObserver;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive('money', function ($amount) {
          return "<?php echo number_format($amount, 2); ?>";
        });

        OrderDetails::observe(OrderDetailsObserver::class);
    }
}
