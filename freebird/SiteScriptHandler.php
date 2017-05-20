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
    
  }

}
