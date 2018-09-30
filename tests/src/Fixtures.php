<?php

namespace VersionTool;

use Symfony\Component\Filesystem\Filesystem;

class Fixtures
{
    protected $testDir;
    protected $tmpDirs = [];
    protected $clonedRepos = [];

    /**
     * Fixtures constructor
     */
    protected function __construct()
    {
        $testDir = false;
    }

    public static function instance()
    {
        static $instance = null;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Clean up any temporary directories that may have been created
     */
    public function cleanup()
    {
        $this->putEnvs($this->prevEnvs);
        return;
        $fs = new Filesystem();
        foreach ($this->tmpDirs as $tmpDir) {
            $fs->remove($tmpDir);
        }
        $this->tmpDirs = [];
    }

    public function cloneRepo($url)
    {
        if (!isset($this->clonedRepos[$url])) {
            $this->clonedRepos[$url] = $this->doCloneRepo($url);
        }
        return $this->clonedRepos[$url];
    }

    public function doCloneRepo($url)
    {
        // https://github.com/pantheon-systems/drops-8.git
        $shortname = basename($url, '.git');
        $dir = $this->mktmpdir() . "/$shortname";

        passthru("git clone $url $dir", $status);
        if ($status != 0) {
            throw new \Exception("Could not clone $url: status = $status");
        }
        return $dir;
    }

    /**
     * Create a new temporary directory.
     *
     * @param string|bool $basedir Where to store the temporary directory
     * @return type
     */
    public function mktmpdir($basedir = false)
    {
        $tempfile = tempnam($basedir ?: $this->testDir ?: sys_get_temp_dir(),'version-tool-tests');
        unlink($tempfile);
        mkdir($tempfile);
        $this->tmpDirs[] = $tempfile;
        return $tempfile;
    }

    protected function fixturesDir()
    {
        return dirname(__DIR__) . '/fixtures';
    }

    protected function homeDir()
    {
        return $this->fixturesDir() . '/home';
    }

    protected function testDir()
    {
        if (!$this->testDir) {
            $this->testDir = $this->mktmpdir();
        }
        return $this->testDir;
    }

    /**
     * Calculate the next version after the provided version
     */
    public function next($version)
    {
        $parts = explode('.', $version);
        $parts[count($parts) - 1]++;
        return implode('.', $parts);
    }
}
