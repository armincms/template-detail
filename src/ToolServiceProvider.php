<?php

namespace Armincms\TemplateDetail;
 
use Illuminate\Support\ServiceProvider; 
use Laravel\Nova\Nova as LaravelNova; 

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    { 
        LaravelNova::serving([$this, 'servingNova']);

        $this->app->booted(function($app) {
            collect(require __DIR__.'/../config/config.php')->each(function($config, $group) {   
                \Config::set("armin.template.{$group}", 
                    array_merge((array) config("armin.template.{$group}"), (array) $config)
                );   
            }); 
        });
    }

    public function servingNova()
    {
        LaravelNova::resources([
            Nova\TemplateDetail::class
        ]);
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
