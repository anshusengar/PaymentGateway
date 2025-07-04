<?php

namespace App\Providers;
 use App\Services\PaymentGatewayInterface;
use App\Services\StripeService;
use App\Services\RazorpayService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
  

public function register()
{
    $this->app->bind(PaymentGatewayInterface::class, function () {
        $gateway = request()->header('X-GATEWAY', 'razorpay');

        return match ($gateway) {
            'stripe' => new StripeService(),
            default => new RazorpayService(),
        };
    });
}


    /**
     * Bootstrap any application services.
     */
  public function boot()
{
    if (class_exists(\Meilisearch\Client::class) && !class_exists(\MeiliSearch\Client::class)) {
        class_alias(\Meilisearch\Client::class, \MeiliSearch\Client::class);
    }
}

}
