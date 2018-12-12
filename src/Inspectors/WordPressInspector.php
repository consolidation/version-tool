<?php

namespace VersionTool\Inspectors;

use VersionTool\Info\VersionInfo;
use VersionTool\Util\ComposerInfo;

class WordPressInspector implements InspectorInterface
{
    /**
     * @inheritdoc
     */
    public function valid(ComposerInfo $composer_info)
    {
        $candidates = [];
        $project_root = $composer_info->projectRoot();

        // Determine if there is a relocated drupal root.
        $pluginsDir = $composer_info->pathForType('type:wordpress-plugin');
        if ($pluginsDir) {
            $candidates[] = dirname(dirname(dirname("$project_root/$pluginsDir")));
        }

        $candidates[] = $project_root;

        foreach ($candidates as $document_root) {
            $info = $this->isWordPressRoot($composer_info, $document_root);
            if ($info) {
                return $info;
            }
        }
        return false;
    }

    /**
     * Create an info object if there is a valid drupal root at the
     * specified path.
     */
    protected function isWordPressRoot(ComposerInfo $composer_info, $document_root)
    {
        foreach (['/', '/wp/'] as $dir) {
            $version_file = $dir . 'wp-includes/version.php';
            if (file_exists("$document_root/$version_file")) {
                return new VersionInfo('WordPress', $composer_info, $document_root, $version_file, "#wp_version = '([0-9.]*)';#m");
            }
        }
        return false;
    }
}
