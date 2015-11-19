<?php namespace Modules\Api\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Boot the application events.
	 * 
	 * @return void
	 */
	public function boot(Router $router)
	{
		$this->registerConfig();
		$this->registerTranslations();
		$this->registerViews();
        
        $this->registerMiddleware($router);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{		
		//
	}

    /**
     * Register Middleware.
     *
     * @return void
     */
    protected function registerMiddleware($router)
    {
        $router->middleware('forbidden', \Modules\Admin\Http\Middleware\Forbidden::class);
        $router->middleware('authorise', \Modules\Admin\Http\Middleware\Authorise::class);
    }
    
	/**
	 * Register config.
	 * 
	 * @return void
	 */
	protected function registerConfig()
	{
		$this->publishes([
		    __DIR__.'/../Config/config.php' => config_path('api.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'api'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('views/modules/api');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom([$viewPath, $sourcePath], 'api');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/api');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'api');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'api');
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
