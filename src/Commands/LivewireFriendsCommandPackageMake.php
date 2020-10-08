<?php

namespace TallAndSassy\LivewireFriends\Commands;

use Livewire\Commands\MakeCommand;

class LivewireFriendsCommandPackageMake extends MakeCommand
{
    protected $signature = 'tassy:lwpmake {vendorCamelCase} {packageCamelCase}  {name}  {--force} {--inline} {--pathtopackage=} {--bladeprefix=}';

    protected $description = 'Livewire Package Make: Create a new Livewire component for an existing package. use: --pathtopackage="vendor/blah/mah" if the autogenerator does not seem to work.';

    public $help = <<<EOD
    This makes a new livewire component
    TODO For You: Required - Look at the generate component class for instructions on on how to register this component with the system.

    Usage:
    ------
                                  (vendor)     (package)
        php artisan tassy:lwpmake TallAndSassy GrokJetUi SomeNewLivewireComponent --bladeprefix="tassy"

    Troubleshooting:
    ----------------
    Q: I see 'No hint path defined for [tassy]'
    A: You specified a bladeprefix that doesn't match what you defined for the ServiceProvider.
    Look at your version of TallAndSassy\GrokJetUi where you define something like
        Route::macro('tassier',...
    In this case, 'tassier' is the prefix you should have specified.

    EOD;

    public function handle()
    {
        $viewOffsetFromPackageRoot = 'resources/views';  #FutureMaybeDo: Make a command line option
        #dd([$this->arguments()]);
        $vendorCamelCase = $this->argument('vendorCamelCase');
        $packageCamelCase = $this->argument('packageCamelCase');
        $destinationNamespace = "$vendorCamelCase\\$packageCamelCase";
        $vendorComposerName = strtolower($vendorCamelCase);
        $packageComposerName = \Illuminate\Support\Str::kebab($packageCamelCase);


        $this->vendorNameCamel = $vendorCamelCase;
        $this->vendorNameComposer = $vendorComposerName;
        $this->vendorNameLower = $vendorComposerName;
        $this->packageNameCamel = $packageCamelCase;
        $this->packageNameComposer = $packageComposerName;


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

        // --- Find out some details, like the blade prefix for this package
        $nameServiceProvider = "\\$vendorCamelCase\\$packageCamelCase\\{$packageCamelCase}ServiceProvider";

        if ($this->option('bladeprefix')) {
            $blade_prefix = $this->option('bladeprefix');
        } else {
            if (! isset($nameServiceProvider::$blade_prefix)) {
                $this->line("<options=bold,reverse;fg=red> No blade prefix found. You can either specify it on the command line via  --bladeprefix=\"blah\" or give your service provider the static property 'public static \$blade_prefix' </> 😳 \n");

                return;
            }
            $blade_prefix = $nameServiceProvider::$blade_prefix;
        }


        $this->parser = new ComponentParserFriends(
            $destinationNamespace,
            $viewPath,
            $this->argument('name'),
            $destinationRootDir,
            $blade_prefix,
            $this->vendorNameCamel,
            $this->vendorNameComposer,
            $this->vendorNameLower,
            $this->packageNameCamel,
            $this->packageNameComposer,
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
}
