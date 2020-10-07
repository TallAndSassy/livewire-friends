<?php

namespace TallAndSassy\LivewireFriends\Commands;

use Illuminate\Console\Command;
use \Livewire\Commands;
class LivewireFriendsCommandStubs extends Command
{
    public $signature = 'tassy:lwstubs';

    public $description = 'Publish new set of livewire stubs that uses lots of hints';



    public function handle()
    {
        #parent::handle();
        $subSourceDir = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'stubs';
        // Now, lets copy our files
        if (! is_dir($stubsPath = base_path('stubs'))) {
            (new Filesystem)->makeDirectory($stubsPath);
        }

        file_put_contents(
            $stubsPath.'/livewire.stub',
            file_get_contents($subSourceDir.'/livewire.stub')
        );

        file_put_contents(
            $stubsPath.'/livewire.inline.stub',
            file_get_contents($subSourceDir.'/livewire.inline.stub')
        );

        file_put_contents(
            $stubsPath.'/livewire.view.stub',
            file_get_contents($subSourceDir.'/livewire.view.stub')
        );

        $this->info('Stubs from LivewireFriends published successfully.');
        $this->comment('We have published a new set up livewire stubs, so "php artisan livewire:create" will now use these, instead of the originals. You can safely remove them from the /stubs directory, whenever you wish to revert to the default stubs."');
    }
}

