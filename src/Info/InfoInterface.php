<?php

namespace VersionTool\Info;

interface InfoInterface
{
    /**
     * version returns the version information for the specific application
     * identified by this info object.
     *
     * @return string
     */
    public function version();

    /**
     * Return the name of the identified application, e.g. "Drupal" or "WordPress"
     */
    public function application();

    public function composerInfo();
}
