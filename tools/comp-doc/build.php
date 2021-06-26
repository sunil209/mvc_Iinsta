<?php
/**
 * Archive filename AND internal name
 */
if (!defined('BUILD_ARCHIVE')) {
  define('BUILD_ARCHIVE', 'comp-doc.phar');
}

/**
 * Root directory used to get paths below
 */
if (!defined('BUILD_ROOT')) {
  define('BUILD_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
}

/**
 * Source directory to build Phar archive from
 */
if (!defined('BUILD_SRC')) {
  define('BUILD_SRC', BUILD_ROOT . 'src');
}

/**
 * Output directory where Phar archive will be placed
 */
if (!defined('BUILD_BIN')) {
  define('BUILD_BIN', BUILD_ROOT . 'bin');
}

/**
 * Make sure that output directory is there
 */
@unlink(BUILD_BIN);
@mkdir(BUILD_BIN, 0777);

/**
 * Actually create Phar archive from files in source directory
 */
$phar = new Phar(
  BUILD_BIN . DIRECTORY_SEPARATOR . BUILD_ARCHIVE,
  FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
  BUILD_ARCHIVE
);
$phar->buildFromDirectory(BUILD_SRC);
$phar->setStub($phar->createDefaultStub('index.php'));
