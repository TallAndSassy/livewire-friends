<?php


namespace TallAndSassy\LivewireFriends\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Commands\ComponentParser;

class ComponentParserFriends extends ComponentParser
{
    /* Motivation: adjust destination of the class to be in the vendor directory.
    Old code heavily assumes it is not in a package, so we'll just bypass it.
    */
    public function __construct(
        $classNamespace,
        $viewPath,
        $rawCommand,
        $destinationRootDir,
        string $bladeprefix,
        $vendorNameCamel,
        $vendorNameComposer,
        $vendorNameLower,
        $packageNameCamel,
        $packageNameComposer
    ) {
        parent::__construct($classNamespace, $viewPath, $rawCommand);
        $this->baseClassPath = $destinationRootDir."/src/Components/";
        $this->baseClassNamespace = $this->baseClassNamespace.'\\Components';
        $this->baseViewPath = $viewPath.'/';
        $this->bladeprefix = $bladeprefix;
        $this->vendorNameCamel = $vendorNameCamel;
        $this->vendorNameComposer = $vendorNameComposer;
        $this->vendorNameLower = $vendorNameLower;
        $this->packageNameCamel = $packageNameCamel;
        $this->packageNameComposer = $packageNameComposer;

        // States/citiesAndTowns/PollABI ==> states.cities-and-towns.poll-a-b-i
        $this->view_subpath = [];
        $this->view_subpath[] = 'livewire';
        foreach ($this->directories as $dirname) {
            $this->view_subpath[] = Str::kebab($dirname);
        }
        $this->view_subpath[] = $this->component();
        $this->view_subpath = implode('.', $this->view_subpath);
    }

//     public function classNamespace()
//    {
//        return empty($this->directories)
//            ? $this->baseClassNamespace
//            : $this->baseClassNamespace.'\\'.collect()
//                ->concat($this->directories)
//                ->map([Str::class, 'studly'])
//                ->implode('\\');
//    }


    public function templateContentToSpecificContent(string $templateContent):string
    {
        $asrSubstitutions = [
            'class_namespace' => $this->classNamespace(),
            'class_name' => $this->className(),
            'class_path' => $this->classPath(),
            'blade_subpath' => $this->viewPath(), //filesystem path
            'view_subpath' => $this->view_subpath,
            'bladeprefix' => $this->bladeprefix,
            'vendorNameCamel' => $this->vendorNameCamel,
            'vendorNameComposer' => $this->vendorNameComposer ,
            'vendorNameLower' => $this->vendorNameLower,
            'packageNameCamel' => $this->packageNameCamel,
            'packageNameComposer' => $this->packageNameComposer,
        ];
        foreach ($asrSubstitutions as $orig => $new) {
            $templateContent = str_replace("[{$orig}]", $new, $templateContent);
        }

        return $templateContent;
    }

    /* This overrides the original, cuz we want a unified subsitution mechanism, and to pull our stubs)
    */
    public function classContents($inline = false)
    {
        // Which template...
        $stubName = $inline ? 'plw_class_with_inline_view.stub' : 'plw_class.stub';

        // load template file
        if (File::exists($stubPath = base_path('stubs/'.$stubName))) {
            $template = file_get_contents($stubPath);
        } else {
            $template = file_get_contents(__DIR__."/../../stubs/$stubName");
        }

        // make subsitutions
        $reconstituted_template = $this->templateContentToSpecificContent($template);

        return $reconstituted_template;
    }

    public function viewContents()
    {
        // load template file...
        $stubPath = base_path('stubs/plw_view.blade.stub');
        if (! File::exists($stubPath)) {
            $stubPath = __DIR__.'/../../stubs/plw_view.blade.stub';
        }
        $template = file_get_contents($stubPath);

        // make subsitutions
        $reconstituted_template = $this->templateContentToSpecificContent($template);

        return $reconstituted_template;
    }
}
