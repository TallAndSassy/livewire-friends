<?php

namespace TallAndSassy\LivewireFriends\Commands;

use Illuminate\Support\Facades\File;
use Livewire\Commands\ComponentParser;
use Livewire\Commands\MakeCommand;




class LivewireFriendsCommandPackageMake extends MakeCommand
{
    protected $signature = 'tassy:lwpmake {vendorCamelCase} {packageCamelCase}  {name}  {--force} {--inline} {--pathtopackage=}';

    protected $description = 'Create a new Livewire component in a package. use: --pathtopackage="vendor/blah/mah" if the autogenerator does not seem to work.';

    public function handle()
    {
        $viewOffsetFromPackageRoot = 'resources/views';  #FutureMaybeDo: Make a command line option
        #dd([$this->arguments()]);
        $vendorCamelCase = $this->argument('vendorCamelCase');
        $packageCamelCase = $this->argument('packageCamelCase');
        $destinationNamespace = "$vendorCamelCase\\$packageCamelCase";
        $vendorComposerName = strtolower($vendorCamelCase);
        $packageComposerName = \Illuminate\Support\Str::kebab($packageCamelCase);
        if ($this->option('pathtopackage')) {
            $destinationRootDir = $this->option('pathtopackage');
        } else {
            $destinationRootDir = "vendor/$vendorComposerName/$packageComposerName";
        }
        $destinationRootDirFull = base_path($destinationRootDir);
        if (! is_dir($destinationRootDirFull)) {
            $this->line("<options=bold,reverse;fg=red> The package directory($destinationRootDir) does not exist. </> 😳 \n");
            $this->line("<fg=cyan;>Full path:</> {$destinationRootDirFull}");
            $this->comment("The directory wasn't there, so I can't go around putting files there and expect things to work.
            If you don't yet have a package, first make one, and then come back to this command add your livewire make package stuff.
            If you have a package, but this is the wrong directory for it, try using the '--pathtopackage=\"vendor/vendorname/package-name\"'
                option to more full specify how to reach your package.");

            return;
        }

        $viewPath = "$destinationRootDir/$viewOffsetFromPackageRoot/livewire";
        $this->parser = new ComponentParserFriends(
            $destinationNamespace,
            $viewPath,
            $this->argument('name'),
            $destinationRootDir,
        );

        if ($this->isReservedClassName($name = $this->parser->className())) {
            $this->line("<options=bold,reverse;fg=red> WHOOPS! </> 😳 \n");
            $this->line("<fg=red;options=bold>Class is reserved:</> {$name}");

            return;
        }

        $force = $this->option('force');
        $inline = $this->option('inline');

        $showWelcomeMessage = $this->isFirstTimeMakingAComponent();

        $class = $this->createClass($force, $inline);
        $view = $this->createView($force, $inline);

        $this->refreshComponentAutodiscovery();

        if ($class || $view) {
            $this->line("<options=bold,reverse;fg=green> COMPONENT CREATED </> 🤙\n");
            $class && $this->line("<options=bold;fg=green>CLASS:</> {$this->parser->relativeClassPath()}");

            if (! $inline) {
                $view && $this->line("<options=bold;fg=green>VIEW:</>  {$this->parser->relativeViewPath()}");
            }

            if ($showWelcomeMessage && ! app()->environment('testing')) {
                $this->writeWelcomeMessage();
            }
        }
    }

    //    protected function createClass($force = false, $inline = false)
    //    {
    //        $classPath = $this->parser->classPath();
    //
    //
    //        if (File::exists($classPath) && ! $force) {
    //            $this->line("<options=bold,reverse;fg=red> WHOOPS-IE-TOOTLES </> 😳 \n");
    //            $this->line("<fg=red;options=bold>Class already exists:</> {$this->parser->relativeClassPath()}");
    //
    //            return false;
    //        }
    //
    //        $this->ensureDirectoryExists($classPath);
    //
    //        File::put($classPath, $this->parser->classContents($inline));
    //
    //        return $classPath;
    //    }
    //
    //    protected function createView($force = false, $inline = false)
    //    {
    //        if ($inline) {
    //            return false;
    //        }
    //        $viewPath = $this->parser->viewPath();
    //
    //        if (File::exists($viewPath) && ! $force) {
    //            $this->line("<fg=red;options=bold>View already exists:</> {$this->parser->relativeViewPath()}");
    //
    //            return false;
    //        }
    //
    //        $this->ensureDirectoryExists($viewPath);
    //
    //        File::put($viewPath, $this->parser->viewContents());
    //
    //        return $viewPath;
    //    }
    //
    //    public function isReservedClassName($name)
    //    {
    //        return array_search($name, ['Parent', 'Component', 'Interface']) !== false;
    //    }
}
