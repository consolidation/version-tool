<?php

namespace VersionTool\Inspectors;

use VersionTool\Info\InfoInterface;
use VersionTool\Util\ComposerInfo;

interface InspectorInterface
{
    /**
     * valid checks to see if the provided path is the project root for
     * an application that is the specific type of application handled
     * by the class that implements InspectorInterface.
     *
     * @param string $path
     * @return InfoInterface|false
     */
    public function valid(ComposerInfo $composer_info);
}
