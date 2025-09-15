<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
// 	public function boot()
// 	{
// 		Paginator::useBootstrap();
// 	}


      public function boot()
      {
            Paginator::useBootstrap();
            
            // Add role and permission blade directives
            Blade::directive('role', function ($role) {
                return "<?php if(auth()->check() && auth()->user()->hasRole({$role})): ?>";
            });
            
            Blade::directive('endrole', function () {
                return "<?php endif; ?>";
            });
            
            Blade::directive('permission', function ($permission) {
                return "<?php if(auth()->check() && auth()->user()->hasPermission({$permission})): ?>";
            });
            
            Blade::directive('endpermission', function () {
                return "<?php endif; ?>";
            });
      }


	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
// 	public function register()
// 	{
// 		$this->app->bind(
// 			'Illuminate\Contracts\Auth\Registrar',
// 			'App\Services\Registrar'
// 		);
//         $this->app->bind('path.public', function() {
//             return realpath(base_path().'/../');
//         });
// 	}


    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Services\Registrar'
        );
        $this->app->bind('path.public', function() {
            return realpath(base_path().'/../');
        });
    }

}
