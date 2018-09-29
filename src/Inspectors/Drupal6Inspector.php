<?php

namespace VersionTool\Inspectors;

use VersionTool\Info\VersionInfo;
use VersionTool\Util\ComposerInfo;

class Drupal6Inspector implements InspectorInterface
{
    /**
     * @inheritdoc
     */
    public function valid(ComposerInfo $composer_info)
    {
        $drupal_root = $composer_info->projectRoot();
        if (file_exists("$drupal_root/index.php")) {
            $candidate = 'includes/common.inc';
            if (file_exists($drupal_root . '/' . $candidate) && file_exists($drupal_root . '/misc/drupal.js') && !file_exists($drupal_root . '/modules/field/field.module')) {
                    return new VersionInfo('Drupal', $composer_info, $drupal_root, '/modules/system/system.module', "#define\('VERSION', '([0-9.]*)'\);#m");
            }
        }
        return false;
    }
}
