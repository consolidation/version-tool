<?php

namespace VersionTool\Info;

use VersionTool\Util\ComposerInfo;

class VersionInfo implements InfoInterface
{
    /** @var string */
    protected $application;

    /** @var ComposerInfo */
    protected $composer_info;

    /** @var string */
    protected $document_root;

    /** @var string */
    protected $version_file;

    /** @var string */
    protected $pattern;

    public function __construct($application, $composer_info, $document_root, $version_file, $pattern)
    {
        $this->application = $application;
        $this->composer_info = $composer_info;
        $this->document_root = $document_root;
        $this->version_file = $version_file;
        $this->pattern = $pattern;
    }

    public function application()
    {
        return $this->application;
    }

    public function composerInfo()
    {
        return $this->composer_info;
    }

    public function projectRoot()
    {
        return $this->composer_info->projectRoot();
    }

    public function documentRoot()
    {
        return $this->document_root;
    }

    /**
     * @inheritdoc
     */
    public function version()
    {
        $version_path = $this->document_root . $this->version_file;
        if (!file_exists($version_path)) {
            print "no file $version_path\n";
            return false;
        }

        $contents = file_get_contents($version_path);

        if (!preg_match($this->pattern, $contents, $matches)) {
            print "pattern did not match\n";
            return false;
        }

        return $matches[1];
    }
}
