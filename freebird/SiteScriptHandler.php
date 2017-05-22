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
    $drupalRoot = getcwd() . '/web';
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
            $linkdir = $drupalRoot . '/' . $type;
            $link = $linkdir . '/' . $content;
            $target = getcwd() . '/' . $dir . '/' . $content;
            if (!is_dir($target)) {
              continue;
            }
            $target = $fs->makePathRelative($target, $linkdir);
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
