<?php

namespace VersionTool;

use VersionTool\Inspectors\InspectorInterface;
use VersionTool\Inspectors\Drupal8Inspector;
use VersionTool\Inspectors\Drupal7Inspector;
use VersionTool\Inspectors\Drupal6Inspector;
use VersionTool\Util\ComposerInfo;

class VersionInfo
{
    protected $inspectors = [];

    public function __construct()
    {
        $this->add(new Drupal8Inspector());
        $this->add(new Drupal7Inspector());
        $this->add(new Drupal6Inspector());
    }

    /**
     * add a new inspector to our collection
     */
    public function add(InspectorInterface $inspector)
    {
        $this->inspectors[] = $inspector;
    }

    /**
     * info returns an info object for the provided path.
     *
     * @param $value multiplicand
     * @return InfoInterface
     */
    public function info($path)
    {
        $composer_info = new ComposerInfo($path);
        foreach ($this->inspectors as $inspector) {
            $info = $inspector->valid($composer_info);
            if ($info) {
                return $info;
            }
        }
        return false;
    }
}
