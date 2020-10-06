<?php


namespace TallAndSassy\LivewireFriends\Tests\Feature\Commands;

class LivewireFriendsCommandTest extends \TallAndSassy\LivewireFriends\Tests\TestCase
{
    /** @test */
    public function test_command_works()
    {
        $this->artisan('hw')->assertExitCode(0);
        $this->artisan('hw')->expectsOutput('TallAndSassy/LivewireFriends/hw/tbd');
    }
}
