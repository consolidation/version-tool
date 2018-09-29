<?php

namespace VersionTool\Inspectors;

use VersionTool\Info\VersionInfo;
use VersionTool\Util\ComposerInfo;

class Drupal8Inspector implements InspectorInterface
{
    /**
     * @inheritdoc
     */
    public function valid(ComposerInfo $composer_info)
    {
        // This cannot be a Drupal 8 site unless there is a composer.json
        // file at the specified path
        if (!$composer_info->valid()) {
            return false;
        }

        $candidates = [];
        $project_root = $composer_info->projectRoot();

        // Determine if there is a relocated drupal root.
        $core = $composer_info->pathForType('type:drupal-core');
        if ($core) {
            $candidates[] = dirname("$project_root/$core");
        }

        $candidates[] = $project_root;

        foreach ($candidates as $drupal_root) {
            $info = $this->isDrupalRoot($composer_info, $drupal_root);
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
    protected function isDrupalRoot(ComposerInfo $composer_info, $drupal_root)
    {
        if (file_exists("$drupal_root/autoload.php")) {
            // Additional check for the presence of core/core.services.yml to
            // grant it is not a Drupal 7 site with a base folder named "core".
            $candidate = 'core/includes/common.inc';
            if (file_exists($drupal_root . '/' . $candidate) && file_exists($drupal_root . '/core/core.services.yml')) {
                if (file_exists($drupal_root . '/core/misc/drupal.js') || file_exists($drupal_root . '/core/assets/js/drupal.js')) {
                    return new VersionInfo('Drupal', $composer_info, $drupal_root, '/core/lib/Drupal.php', "#const VERSION = '([0-9.]*)';#m");
                }
            }
        }
        return false;
    }
}
