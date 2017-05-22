<?php

/**
 * @file
 * Contains \DrupalProject\composer\SiteScriptHandler.
 */

namespace DrupalProject\composer;

use Composer\Script\Event;
use Composer\Semver\Comparator;
use DrupalFinder\DrupalFinder;
use Symfony\Component\Filesystem\Filesystem;
use Webmozart\PathUtil\Path;

class SiteScriptHandler {
  
  /**
   * Link freebird modules, themes, and profiles
   */
  public static function createSiteSymlinks(Event $event) {
    $fs = new Filesystem();
    $drupalFinder = new DrupalFinder();
    $drupalFinder->locateRoot(getcwd());
    $drupalRoot = $drupalFinder->getDrupalRoot();
    $dirs = [
      'modules' => 'modules',
      'profiles' => 'profiles',
      'themes' => 'themes',
      'vendor/highwire/freebird/modules' => 'modules',
      'vendor/highwire/freebird/profiles' => 'profiles',
      'vendor/highwire/freebird/themes' => 'themes',
    ];
    foreach ($dirs as $dir => $type) {
      if ($fs->exists($dir)) {
        $contents = scandir($dir);
        foreach ($contents as $content) {
          if ($content != '.' && $content != '..') {
            $link = $drupalRoot . '/' . $dir . '/' . $content;
            $target = $fs->makePathRelative('web/' . $type . '/' . $content);
            if (!$fs->exists($link)) {
              $fs->symlink($target, $link, true);
              $event->getIO()->write("Create a symlink from $link to $target");
            }
          }
        }
      }
    }
  }

}
