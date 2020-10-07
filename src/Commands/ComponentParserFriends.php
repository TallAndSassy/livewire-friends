<?php


namespace TallAndSassy\LivewireFriends\Commands;

use Livewire\Commands\ComponentParser;


class ComponentParserFriends extends ComponentParser
{
    /* Motivation: adjust destination of the class to be in the vendor directory.
    Old code heavily assumes it is not in a package, so we'll just bypass it.
    */
    public function __construct($classNamespace, $viewPath, $rawCommand, $destinationRootDir)
    {
        parent::__construct($classNamespace, $viewPath, $rawCommand);
        //        $arrParts = explode('\\', $classNamespace);
        //        unset($arrParts[0]);
        //        unset($arrParts[1]);
        //
        //        $arrParts = array_merge($arrParts, $this->directories);
        //
        //        $subPath = implode('/', $arrParts);
        //        $subPath = empty($subPath) ? '' : '/'.$subPath;
        $this->baseClassPath = $destinationRootDir."/src/Components/";
        $this->baseViewPath = $viewPath.'/';
    }
}