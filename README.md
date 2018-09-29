# VersionTool

The version-tool identifies the type and version of several popular projects.

[![Travis CI](https://travis-ci.org/consolidation/version-tool.svg?branch=master)](https://travis-ci.org/consolidation/version-tool)
[![Windows CI](https://ci.appveyor.com/api/projects/status/{{PUT_APPVEYOR_STATUS_BADGE_ID_HERE}}?svg=true)](https://ci.appveyor.com/project/consolidation/version-tool)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/consolidation/version-tool/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/consolidation/version-tool/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/consolidation/version-tool/badge.svg?branch=master)](https://coveralls.io/github/consolidation/version-tool?branch=master) 
[![License](https://img.shields.io/badge/license-MIT-408677.svg)](LICENSE)

<!-- 
There are two choices for LICENSE badges:

1. License using shields.io (above): Can contain any text you want, and has no prerequisites, but must be manually updated if you change the license.
2. License using poser.pugx.org (below): shows the license that Packagist.org read from your composer.json file. Must register with Packagist to use Poser.

[![License](https://poser.pugx.org/consolidation/version-tool/license)](https://github.com/consolidation/version-tool//master/LICENSE)
-->


## Getting Started

Download the latest `version-tool.phar` from the [releases](https://github.com/consolidation/version-tool/releases) page. Run `chmod +x version-tool.phar`, rename to `version-tool`, and move to some directory in your $PATH (e.g. /usr/local/bin).

version-tool will tell you what program and what version exists in the current working directory:
```
$ version-tool info
program: Drupal 
version: 8.6.1
```
Detected frameworks:
- Drupal 8
- Drupal 7
- Drupal 6

## Using the API

The Version Tool may also be included in another project as a library.
```
$ composer require consolidation/version-tool
```
Then, call as follows:
```
    $version_info = new VersionInfo();
    $info = $version_info->info($path);
    $app = $info->application();
    $version = $info->version();
```

## Running the tests

The test suite may be run locally by way of some simple composer scripts:

| Test             | Command
| ---------------- | ---
| Run all tests    | `composer test`
| PHPUnit tests    | `composer unit`
| PHP linter       | `composer lint`
| Code style       | `composer cs`     
| Fix style errors | `composer cbf`


## Deployment

- Edit the `VERSION` file to contain the version to release followed by "-dev", and commit the change.
- Run `composer release`

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [releases](https://github.com/consolidation/version-tool/releases) page.

## Authors

* **Greg Anderson** - created project from template.

See also the list of [contributors](https://github.com/consolidation/version-tool/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
