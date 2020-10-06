<?php


namespace Spatie\Skeleton\Tests\Feature\Http\Controllers;

class SkeletonControllerTest extends \Spatie\Skeleton\Tests\TestCase
{
    /** @test */
    public function global_urls_returns_ok()
    {
        // Test hard-coded routes...
        $this
            ->get('/grok/Spatie/Skeleton/sample_string')
            ->assertOk()
            ->assertSee('Hello Skeleton string via global url.');
        $this
            ->get('/grok/Spatie/Skeleton/sample_blade')
            ->assertOk()
            ->assertSee('Hello Skeleton from blade in Spatie/Skeleton/groks/sample_blade');
        $this
            ->get('/grok/Spatie/Skeleton/controller')
            ->assertOk()
            ->assertSee('Hello Skeleton from: Spatie\Skeleton\Http\Controllers\SkeletonController::sample');
    }


    /** @test */
    public function prefixed_urls_returns_ok()
    {
        // Test user-defined routes...
        // Reproduce in routes/web.php like so
        //  Route::bladeprefix('staff');
        //  http://test-spatie.test/staff/Spatie/Skeleton/string
        //  http://test-spatie.test/staff/Spatie/Skeleton/blade
        //  http://test-spatie.test/staff/Spatie/Skeleton/controller
        $userDefinedBladePrefix = $this->userDefinedBladePrefix; // user will do this in routes/web.php Route::bladeprefix('url');

        // string
        $this
            ->get("/$userDefinedBladePrefix/Spatie/Skeleton/sample_string")
            ->assertOk()
            #->assertSee('hw(Spatie\Skeleton\Http\Controllers\SkeletonController)');
        ->assertSee('Hello Skeleton string via blade prefix');

        // blade
        $this
            ->get("/$userDefinedBladePrefix/Spatie/Skeleton/sample_blade")
            ->assertOk()
            ->assertSee('Hello Skeleton from blade in Spatie/Skeleton/groks/sample_blade');

        // controller
        $this
            ->get("/$userDefinedBladePrefix/Spatie/Skeleton/controller")
            ->assertOk()
            ->assertSee('Hello Skeleton from: Spatie\Skeleton\Http\Controllers\SkeletonController::sample');
    }
}
