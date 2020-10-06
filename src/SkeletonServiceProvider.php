<?php

namespace Spatie\Skeleton;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\Skeleton\Commands\SkeletonCommand;
use Spatie\Skeleton\Http\Controllers\SkeletonController;

class SkeletonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/skeleton.php' => config_path('skeleton.php'),
                ],
                'config'
            );

            $this->publishes(
                [
                    __DIR__ . '/../resources/views' => base_path('resources/views/vendor/skeleton'),
                ],
                'views'
            );

            $migrationFileName = 'create_skeleton_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes(
                    [
                        __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path(
                            'migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName
                        ),
                    ],
                    'migrations'
                );
            }

             $this->publishes([
                 __DIR__.'/../resources/public' => public_path('eleganttechnologies/grok'),
                ], ['public']);

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('spatie/skeleton'),
            ], 'grok.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/spatie/skeleton'),
            ], 'grok.views');*/



            // Registering package commands.
            $this->commands(
                [
                    SkeletonCommand::class,
                ]
            );
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'bladeprefix');


        Route::macro(
            'bladeprefix',
            function (string $prefix) {
                Route::prefix($prefix)->group(
                    function () {
                        // Prefix Route Samples -BEGIN-
                        // Sample routes that only show while developing...
                        if (App::environment(['local', 'testing'])) {
                            // prefixed url to string
                            Route::get(
                                '/Spatie/Skeleton/sample_string', // you will absolutely need a prefix in your url
                                function () {
                                    return "Hello Skeleton string via blade prefix";
                                }
                            );

                            // prefixed url to blade view
                            Route::get(
                                '/Spatie/Skeleton/sample_blade',
                                function () {
                                    return view('bladeprefix::sample_blade');
                                }
                            );

                            // prefixed url to controller
                            Route::get(
                                '/Spatie/Skeleton/controller',
                                [SkeletonController::class, 'sample']
                            );
                        }
                        // Prefix Route Samples -END-

                        // TODO: Add your own prefixed routes here...
                    }
                );
            }
        );
        Route::bladeprefix('bladeprefix'); // This works. http://test-jet.test/bladeprefix/Spatie/Skeleton/string
        // They are addatiive, so in your own routes/web.php file, do Route::bladeprefix('staff'); to
        // make http://test-jet.test/staff/Spatie/Skeleton/string work


        // global url samples -BEGIN-
        if (App::environment(['local', 'testing'])) {
            // global url to string
            Route::get(
                '/grok/Spatie/Skeleton/sample_string',
                function () {
                    return "Hello Skeleton string via global url.";
                }
            );

            // global url to blade view
            Route::get(
                '/grok/Spatie/Skeleton/sample_blade',
                function () {
                    return view('bladeprefix::sample_blade');
                }
            );

            // global url to controller
            Route::get('/grok/Spatie/Skeleton/controller', [SkeletonController::class, 'sample']);
        }
        // global url samples -END-

        // TODO: Add your own global routes here...

        // GROK
        if (App::environment(['local', 'testing'])) {
            \ElegantTechnologies\Grok\GrokWrangler::grokMe(static::class, 'Spatie', 'skeleton', 'resources/views/grok', 'bladeprefix');//bladeprefix gets macro'd out
            Route::get('/grok/Spatie/Skeleton', fn () => view('bladeprefix::grok/index'));
        }
        // TODO: Add your own other boot related stuff here...
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/skeleton.php', 'skeleton');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
