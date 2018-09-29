<?php

namespace VersionTool\Util;

class ComposerInfo
{
    /** @var array */
    protected $composer_json = [];

    /** @var string */
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
        $composer_json_path = "$path/composer.json";
        if (!file_exists($composer_json_path)) {
            return;
        }

        $composer_json_contents = file_get_contents($composer_json_path);
        if (empty($composer_json_contents)) {
            return;
        }

        $this->composer_json = json_decode($composer_json_contents, true);
    }

    public function projectRoot()
    {
        return $this->path;
    }

    public function valid()
    {
        return !empty($this->composer_json) && isset($this->composer_json['name']);
    }

    public function pathForType($typeToFind)
    {
        foreach ($this->installerPaths() as $path => $types) {
            if (in_array($typeToFind, $types)) {
                return $path;
            }
        }
        return false;
    }

    public function installerPaths()
    {
        if (!isset($this->composer_json['extra']['installer-paths'])) {
            return [];
        }
        return $this->composer_json['extra']['installer-paths'];
    }
}
