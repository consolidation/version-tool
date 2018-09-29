<?php

namespace VersionTool\Cli;

use VersionTool\VersionInfo;
use Consolidation\OutputFormatters\StructuredData\RowsOfFields;

class InfoCommands extends \Robo\Tasks
{
    /**
     * Multiply two numbers together
     *
     * @command info
     * @field-labels
     *   application: Application
     *   version: Version
     *   path: Path
     * @default-fields application,version
     * @return \Consolidation\OutputFormatters\StructuredData\RowsOfFields
     */
    public function info(array $paths, $options = ['format' => 'tsv'])
    {
        if (empty($paths)) {
            $paths[] = getcwd();
        }

        $version_info = new VersionInfo();

        $result = [];
        foreach ($paths as $path) {
            $info = $version_info->info($path);

            if (!$info) {
                throw new \Exception('Could not identify any application at path ' . $path);
            }

            $data = [
                'application' => $info->application(),
                'version' => $info->version(),
                'path' => $path,
            ];
            $result[] = $data;
        }

        return new RowsOfFields($result);
    }
}
