<?php

namespace TallAndSassy\LivewireFriends\Commands;

use Illuminate\Console\Command;

class LivewireFriendsCommand extends Command
{
    public $signature = 'hw';

    public $description = 'Default description for TallAndSassy/LivewireFriends command';

    public function handle()
    {
        $this->comment('TallAndSassy/LivewireFriends/hw/tbd');
    }
}
