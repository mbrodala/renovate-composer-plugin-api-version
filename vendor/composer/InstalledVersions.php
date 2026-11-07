<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;








class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-master',
    'version' => 'dev-master',
    'aliases' => 
    array (
    ),
    'reference' => '6ef1ed517d69f51c61867f29460fef4d2a8af261',
    'name' => '__root__',
  ),
  'versions' => 
  array (
    '__root__' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
      ),
      'reference' => '6ef1ed517d69f51c61867f29460fef4d2a8af261',
    ),
    'psr/container' => 
    array (
      'pretty_version' => '2.0.2',
      'version' => '2.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c71ecc56dfe541dbd90c5360474fbc405f8d5963',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0|2.0',
      ),
    ),
    'symfony/console' => 
    array (
      'pretty_version' => 'v5.4.55',
      'version' => '5.4.55.0',
      'aliases' => 
      array (
      ),
      'reference' => '0b8208c757a9f97e372c6297a1863ffe19686dc0',
    ),
    'symfony/deprecation-contracts' => 
    array (
      'pretty_version' => 'v3.8.1',
      'version' => '3.8.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'feb1edf4e546af3b85c5caebe8359a20db230ca3',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.37.0',
      'version' => '1.37.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '141046a8f9477948ff284fa65be2095baafb94f2',
    ),
    'symfony/polyfill-intl-grapheme' => 
    array (
      'pretty_version' => 'v1.43.3',
      'version' => '1.43.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '5a8f33c87aeecffce24e721b5064fab05f4becf8',
    ),
    'symfony/polyfill-intl-normalizer' => 
    array (
      'pretty_version' => 'v1.43.0',
      'version' => '1.43.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ebd57ccc7edb93d632e184efbe7693d2517bab3b',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.43.3',
      'version' => '1.43.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '122889ed24dc000165bcbfd77ec412f15cbdfc6a',
    ),
    'symfony/polyfill-php73' => 
    array (
      'pretty_version' => 'v1.37.0',
      'version' => '1.37.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f68c03565dcaaf25a890667542e8bd75fe7e5bb',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.43.0',
      'version' => '1.43.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9c6a5d6b01ca51d486c813e9a9c0ed55f208bb74',
    ),
    'symfony/service-contracts' => 
    array (
      'pretty_version' => 'v3.8.1',
      'version' => '3.8.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '052852a96fd5e5ebdb617dba22031e41a3300fb5',
    ),
    'symfony/string' => 
    array (
      'pretty_version' => 'v6.4.49',
      'version' => '6.4.49.0',
      'aliases' => 
      array (
      ),
      'reference' => '6910c3715e0bd5cb2d3416348c0051bf54d43201',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}

if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}








public static function getRawData()
{
@trigger_error('getRawData only returns the first dataset loaded, which may not be what you expect. Use getAllRawData() instead which returns all datasets for all autoloaders present in the process.', E_USER_DEPRECATED);

return self::$installed;
}







public static function getAllRawData()
{
return self::getInstalled();
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}





private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
