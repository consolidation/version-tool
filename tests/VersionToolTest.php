<?php

namespace VersionTool;

use PHPUnit\Framework\TestCase;

class VersionToolTest extends TestCase
{
    /**
     * Data provider for testFrameworkVersions.
     */
    public function frameworkVersionsTestValues()
    {
        return [
            [
                'https://github.com/pantheon-systems/drops-8.git',
                'Drupal',
                '8',
            ],
        ];
    }

    /**
     * @dataProvider frameworkVersionsTestValues
     */
    public function testFrameworkVersions($url, $expectedApplication, $majorVersion)
    {
        $dir = Fixtures::instance()->cloneRepo($url);

        $version_info = new VersionTool();
        $info = $version_info->info($dir);
        $app = $info->application();

        // TODO: Get all of the tags from $dir and check out each in
        // turn, and test to see if $version matches the tag.
        $this->assertEquals($expectedApplication, $app);

        $version = $info->version();
        $this->assertTrue(is_string($version));
    }
}
