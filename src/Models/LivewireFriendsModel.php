<?php

namespace TallAndSassy\LivewireFriends\Models;

use Illuminate\Database\Eloquent\Model;

class LivewireFriendsModel extends Model
{
    public $gaurded = [];// Defualt to no mass assignements
    public $fillable = ['name'];
    public $table = 'livewire-friends';

    public function getUpperCasedName() : string
    {
        return strtoupper($this->name);
    }
}
