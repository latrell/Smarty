<?php
namespace Latrell\Smarty;

use Illuminate\Support\ServiceProvider;

class SmartyServiceProvider extends ServiceProvider
{

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
		$this->publishes([
			__DIR__ . '/../../config/config.php' => config_path('latrell-smarty.php')
		]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'latrell-smarty');

		$this->app['view']->addExtension($this->app['config']->get('latrell-smarty.extension', 'tpl'), 'smarty', function ()
		{
			return new SmartyEngine($this->app['config']);
		});
	}
}
