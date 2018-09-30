<?php

namespace VersionTool\Cli;

use VersionTool\VersionTool;
use Consolidation\OutputFormatters\StructuredData\RowsOfFields;

class InfoCommands extends \Robo\Tasks
{
    /**
     * Determine the application type and version of the specified
     * framework or frameworks.
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

        $version_tool = new VersionTool();

        $result = [];
        foreach ($paths as $path) {
            $info = $version_tool->info($path);

            if (!$info) {
                throw new \Exception('Could not identify any application at path ' . $path);
            }

            $data = [
                'application' => $info->application(),
                'version' => $info->version(),
                'project-root' => $info->projectRoot(),
                'document-root' => $info->documentRoot(),
            ];
            $result[] = $data;
        }

        return new RowsOfFields($result);
    }
}
