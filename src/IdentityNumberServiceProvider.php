<?php namespace Olssonm\IdentityNumber;

use Illuminate\Support\ServiceProvider;

class IdentityNumberServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Extend the Laravel Validator with the "identity_number" rule
         */
        $this->app['validator']->extend('identity_number', function ($attribute, $value, $parameters)
        {
            return Pin::isValid($value, 'identity');
        });

        /**
         * Extend the Laravel Validator with the "organisation_number" rule
         */
        $this->app['validator']->extend('organisation_number', function ($attribute, $value, $parameters)
        {
            return Pin::isValid($value, 'organisation');
        });

        /**
         * Extend the Laravel Validator with the "coordination_number" rule
         */
        $this->app['validator']->extend('coordination_number', function ($attribute, $value, $parameters)
        {
            return Pin::isValid($value, 'coordination');
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
