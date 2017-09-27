<?php

/**
 * @file
 * Contains \DrupalSkeletor\ProductionBuild.
 */

namespace DrupalSkeletor;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ProductionBuild {

  protected static function getDrupalRoot($project_root) {
    return $project_root . '/docroot';
  }

  public static function placeGitIgnore(Event $event) {
    $filesystem = new Filesystem();
    $project_root = getcwd();

    if ($filesystem->exists($project_root . '/prod.gitignore')) {
      $filesystem->copy($project_root . '/prod.gitignore', $project_root . '/.gitignore', true);
      $event->getIO()->write("    Placed production gitignore in project root.");
    }
  }

  public static function removeGitFolders(Event $event) {
    $filesystem = new Filesystem();
    $finder = new Finder();
    $drupal_root = static::getDrupalRoot(getcwd());

    // Find all .git directories found in the drupal root,
    // searching only contrib or vendor folders.
    $git_dirs = $finder->directories()->ignoreVCS(false)->ignoreDotFiles(false)
      ->in($drupal_root)->name(".git")->path("/contrib|vendor/");

    // Remove them.
    $filesystem->remove($git_dirs);

    $event->getIO()->write("    Removed git instances in vendor or contrib directories");
  }
}
