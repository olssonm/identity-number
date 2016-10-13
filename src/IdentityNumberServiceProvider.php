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
         * Extend the Laravel Validator with the "organization_number" rule
         */
        $this->app['validator']->extend('organization_number', function ($attribute, $value, $parameters)
        {
            return Pin::isValid($value, 'organization');
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
