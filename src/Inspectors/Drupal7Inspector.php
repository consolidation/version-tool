<?php

namespace VersionTool\Inspectors;

use VersionTool\Info\VersionInfo;
use VersionTool\Util\ComposerInfo;

class Drupal7Inspector implements InspectorInterface
{
    /**
     * @inheritdoc
     */
    public function valid(ComposerInfo $composer_info)
    {
        $drupal_root = $composer_info->projectRoot();
        if (file_exists("$drupal_root/index.php")) {
            // Additional check for the presence of core/composer.json to
            // grant it is not a Drupal 7 site with a base folder named "core".
            $candidate = 'includes/common.inc';
            if (file_exists($drupal_root . '/' . $candidate) && file_exists($drupal_root . '/misc/drupal.js') && file_exists($drupal_root . '/modules/field/field.module')) {
                    return new VersionInfo('Drupal', $composer_info, $drupal_root, '/includes/bootstrap.inc', "#define\('VERSION', '([0-9.]*)'\);#m");
            }
        }
        return false;
    }
}
