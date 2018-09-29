<?php

namespace VersionTool\Info;
use VersionTool\Util\ComposerInfo;

class DrupalInfo implements InfoInterface
{
    /** @var ComposerInfo */
    protected $composer_info;

    /** @var string */
    protected $drupal_root;

    /** @var string */
    protected $version_file;

    /** @var string */
    protected $pattern;

    public function __construct($composer_info, $drupal_root, $version_file, $pattern)
    {
        $this->composer_info = $composer_info;
        $this->drupal_root = $drupal_root;
        $this->version_file = $version_file;
        $this->pattern = $pattern;
    }

    public function application()
    {
        return 'Drupal';
    }

    public function composerInfo()
    {
        return $this->composer_info;
    }

    /**
     * @inheritdoc
     */
    public function version()
    {
        $version_path = $this->drupal_root . $this->version_file;
        if (!file_exists($version_path)) {
            return false;
        }

        $contents = file_get_contents($version_path);

        if (!preg_match($this->pattern, $contents, $matches)) {
            return false;
        }

        return $matches[1];
    }
}
