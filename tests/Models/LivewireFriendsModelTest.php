<?php

namespace TallAndSassy\LivewireFriends\Tests\Feature\Models;

use TallAndSassy\LivewireFriends\Models\LivewireFriendsModel;
use TallAndSassy\LivewireFriends\Tests\TestCase;

class LivewireFriendsModelTest extends TestCase
{
    /** @test */
    public function it_can_create_a_model()
    {
        $model = LivewireFriendsModel::create(['name' => 'John']);
        $this->assertDatabaseCount('livewire-friends', 1);
        $this->assertEquals('JOHN', $model->getUpperCasedName());
    }
}
