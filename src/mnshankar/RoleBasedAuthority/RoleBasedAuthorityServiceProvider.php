<?php

namespace mnshankar\RoleBasedAuthority;

use Illuminate\Support\ServiceProvider;

class RoleBasedAuthorityServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {        
        $this->package('mnshankar/RoleBasedAuthority');
        
        $this->app['authority'] = $this->app->share(function ($app)
        {
            $user = $app['auth']->user();
            $authority = new Authority($user);
            $fn = $app['config']->get('authority-l4::initialize', null);
            
            if ($fn) {
                $fn($authority);
            }
            
            return $authority;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('authority');
    }
}