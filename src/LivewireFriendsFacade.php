<?php

namespace TallAndSassy\LivewireFriends;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TallAndSassy\LivewireFriends\LivewireFriends
 */
class LivewireFriendsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'livewire-friends';
    }
}
