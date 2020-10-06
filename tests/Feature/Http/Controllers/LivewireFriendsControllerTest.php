<?php


namespace TallAndSassy\LivewireFriends\Tests\Feature\Http\Controllers;

class LivewireFriendsControllerTest extends \TallAndSassy\LivewireFriends\Tests\TestCase
{
    /** @test */
    public function global_urls_returns_ok()
    {
        // Test hard-coded routes...
        $this
            ->get('/grok/TallAndSassy/LivewireFriends/sample_string')
            ->assertOk()
            ->assertSee('Hello LivewireFriends string via global url.');
        $this
            ->get('/grok/TallAndSassy/LivewireFriends/sample_blade')
            ->assertOk()
            ->assertSee('Hello LivewireFriends from blade in TallAndSassy/LivewireFriends/groks/sample_blade');
        $this
            ->get('/grok/TallAndSassy/LivewireFriends/controller')
            ->assertOk()
            ->assertSee('Hello LivewireFriends from: TallAndSassy\LivewireFriends\Http\Controllers\LivewireFriendsController::sample');
    }


    /** @test */
    public function prefixed_urls_returns_ok()
    {
        // Test user-defined routes...
        // Reproduce in routes/web.php like so
        //  Route::tassylivewirefriends('staff');
        //  http://test-tallandsassy.test/staff/TallAndSassy/LivewireFriends/string
        //  http://test-tallandsassy.test/staff/TallAndSassy/LivewireFriends/blade
        //  http://test-tallandsassy.test/staff/TallAndSassy/LivewireFriends/controller
        $userDefinedBladePrefix = $this->userDefinedBladePrefix; // user will do this in routes/web.php Route::tassylivewirefriends('url');

        // string
        $this
            ->get("/$userDefinedBladePrefix/TallAndSassy/LivewireFriends/sample_string")
            ->assertOk()
            #->assertSee('hw(TallAndSassy\LivewireFriends\Http\Controllers\LivewireFriendsController)');
        ->assertSee('Hello LivewireFriends string via blade prefix');

        // blade
        $this
            ->get("/$userDefinedBladePrefix/TallAndSassy/LivewireFriends/sample_blade")
            ->assertOk()
            ->assertSee('Hello LivewireFriends from blade in TallAndSassy/LivewireFriends/groks/sample_blade');

        // controller
        $this
            ->get("/$userDefinedBladePrefix/TallAndSassy/LivewireFriends/controller")
            ->assertOk()
            ->assertSee('Hello LivewireFriends from: TallAndSassy\LivewireFriends\Http\Controllers\LivewireFriendsController::sample');
    }
}
