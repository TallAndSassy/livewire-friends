<?php

namespace TallAndSassy\LivewireFriends;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TallAndSassy\LivewireFriends\Commands\LivewireFriendsCommand;
use TallAndSassy\LivewireFriends\Http\Controllers\LivewireFriendsController;

class LivewireFriendsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/livewire-friends.php' => config_path('livewire-friends.php'),
                ],
                'config'
            );

            $this->publishes(
                [
                    __DIR__ . '/../resources/views' => base_path('resources/views/vendor/livewire-friends'),
                ],
                'views'
            );

            $migrationFileName = 'create_livewire_friends_table.php';
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
                __DIR__.'/../resources/assets' => public_path('tallandsassy/livewire-friends'),
            ], 'grok.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/tallandsassy/livewire-friends'),
            ], 'grok.views');*/



            // Registering package commands.
            $this->commands(
                [
                    LivewireFriendsCommand::class,
                ]
            );
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tassylivewirefriends');


        Route::macro(
            'tassylivewirefriends',
            function (string $prefix) {
                Route::prefix($prefix)->group(
                    function () {
                        // Prefix Route Samples -BEGIN-
                        // Sample routes that only show while developing...
                        if (App::environment(['local', 'testing'])) {
                            // prefixed url to string
                            Route::get(
                                '/TallAndSassy/LivewireFriends/sample_string', // you will absolutely need a prefix in your url
                                function () {
                                    return "Hello LivewireFriends string via blade prefix";
                                }
                            );

                            // prefixed url to blade view
                            Route::get(
                                '/TallAndSassy/LivewireFriends/sample_blade',
                                function () {
                                    return view('tassylivewirefriends::sample_blade');
                                }
                            );

                            // prefixed url to controller
                            Route::get(
                                '/TallAndSassy/LivewireFriends/controller',
                                [LivewireFriendsController::class, 'sample']
                            );
                        }
                        // Prefix Route Samples -END-

                        // TODO: Add your own prefixed routes here...
                    }
                );
            }
        );
        Route::tassylivewirefriends('tassylivewirefriends'); // This works. http://test-jet.test/tassylivewirefriends/TallAndSassy/LivewireFriends/string
        // They are addatiive, so in your own routes/web.php file, do Route::tassylivewirefriends('staff'); to
        // make http://test-jet.test/staff/TallAndSassy/LivewireFriends/string work


        // global url samples -BEGIN-
        if (App::environment(['local', 'testing'])) {
            // global url to string
            Route::get(
                '/grok/TallAndSassy/LivewireFriends/sample_string',
                function () {
                    return "Hello LivewireFriends string via global url.";
                }
            );

            // global url to blade view
            Route::get(
                '/grok/TallAndSassy/LivewireFriends/sample_blade',
                function () {
                    return view('tassylivewirefriends::sample_blade');
                }
            );

            // global url to controller
            Route::get('/grok/TallAndSassy/LivewireFriends/controller', [LivewireFriendsController::class, 'sample']);
        }
        // global url samples -END-

        // TODO: Add your own global routes here...

        // GROK
        if (App::environment(['local', 'testing'])) {
            \ElegantTechnologies\Grok\GrokWrangler::grokMe(static::class, 'TallAndSassy', 'livewire-friends', 'resources/views/grok', 'tassylivewirefriends');//tassylivewirefriends gets macro'd out
            Route::get('/grok/TallAndSassy/LivewireFriends', fn () => view('tassylivewirefriends::grok/index'));
        }
        // TODO: Add your own other boot related stuff here...
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/livewire-friends.php', 'livewire-friends');
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
