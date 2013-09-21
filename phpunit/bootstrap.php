<?php
/**
 * @author ble
 */
ini_set('include_path', ini_get('include_path').';'.__DIR__);

include dirname(__DIR__).'/af.php';

$loader = new Phalcon\Loader;

$loader->registerNamespaces(array(
   'af' =>  dirname(__DIR__).'/af/'
));

$loader->registerDirs(array(
    dirname(__DIR__).'/mock/',
    
));
$loader->register();

af::boot(__DIR__.'/../mock', false);
echo \af::$app_dir, "\n",
    \af::$fwk_dir, "\n";


