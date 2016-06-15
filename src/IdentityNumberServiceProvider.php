<?php namespace Olssonm\IdentityNumber;

use Illuminate\Support\ServiceProvider;
use Olssonm\IdentityNumber\IdentityNumberFormatter;
use Olssonm\IdentityNumber\IdentityNumber;

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
         * Extend the Laravel Validator with the "personal_identity_number" rule
         */
        $this->app['validator']->extend('personal_identity_number', function ($attribute, $value, $parameters)
        {
            return IdentityNumber::isValid($value, true);
        });

        /**
         * Extend the Laravel Validator with the "org_number" rule
         */
        $this->app['validator']->extend('org_number', function ($attribute, $value, $parameters)
        {
            return IdentityNumber::isValid($value, false);
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
