<?php

namespace TallAndSassy\LivewireFriends\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use TallAndSassy\LivewireFriends\LivewireFriendsServiceProvider;

class TestCase extends Orchestra
{
    protected $userDefinedBladePrefix;
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'TallAndSassy\\LivewireFriends\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        // route prefix
        // this must match/sync with what was put in
        // tests/Feature/Http/Controllers/LivewireFriendsControllerTest.php/setup
        // Hint: 'Blade Prefix' (all lowercase, no spaces) is a substition string when using this as a template
        $this->userDefinedBladePrefix = uniqid("Blah");
        Route::tassylivewirefriends($this->userDefinedBladePrefix); # what is our prefix route (just for testing)?
        #https://forum.laravel-livewire.com/t/livewire-class-does-not-exists-package-development/1443/5
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireFriendsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Using Livewire: Add this config view paths.
        // see: https://forum.laravel-livewire.com/t/livewire-class-does-not-exists-package-development/1443/5
        $app['config']->set('view.paths', [__DIR__.'/../views', resource_path('views')]);

        include_once __DIR__.'/../database/migrations/create_livewire_friends_table.php';
        (new \CreateLivewireFriendsTable())->up();
    }
}
