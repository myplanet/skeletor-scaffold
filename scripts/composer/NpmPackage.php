<?php

/**
 * @file
 * Contains \DrupalSkeletor\composer\NpmPackage.
 */

namespace DrupalSkeletor\composer;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class NpmPackage {

  public static function npmInstall(Event $event) {
    static::runNpmCommand('install', $event);
  }

  public static function npmTest(Event $event) {
    static::runNpmCommand('test', $event);
  }

  public static function npmBuild(Event $event) {
    static::runNpmCommand('build', $event);
  }

  protected static function getPackageRoot() {
    return getcwd();
  }

  protected static function findNpmPackages($packageRoot) {
    // Find all npm instances in the package root,
    // that are not contained in contrib, vendor or node_module directories.
    $finder = new Finder();
    return $finder->in($packageRoot)->notPath("/contrib|vendor|node_modules/")->name("package.json");
  }

  protected static function runNpmCommand($command, Event $event) {
    $packageRoot = static::getPackageRoot();
    foreach(static::findNpmPackages($packageRoot) as $package) {
      $path = $package->getRelativePath();
      $event->getIO()->write("    Running npm $command in $path");
      exec("cd $packageRoot/$path; npm $command");
    }
  }
}
