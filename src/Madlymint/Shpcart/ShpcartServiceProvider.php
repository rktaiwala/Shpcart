<?php namespace Madlymint\Shpcart;
use Madlymint\Shpcart\Helper\FormatNumber;
use Illuminate\Support\ServiceProvider;

class ShpcartServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('madlymint/shpcart');
		include __DIR__.'/../../route.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		$this->app['shpcart'] = $this->app->share(function($app) {
            return new Shpcart;
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('shpcart');
	}

}