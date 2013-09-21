<?php
namespace af;

function file_exists($path, $extension = 'php')
{
    return \file_exists(
        fullpath($path).($extension ? ('.'.$extension):'')
    );
}

function file_get_contents($path)
{
    return \file_get_contents(fullpath($path));
}

function file_put_contents($path, $data)
{
    file_exists($dir = dirname($path), '') or mkdir($dir);
    \file_put_contents(fullpath($path), $data);
}

function fullpath($path)
{
    if (\strpos($path, '/') !== 0)
    {
        $path = '/' . $path;
    }
    
    $is_fwk =   (\strpos($path, '/af') === 0);
    
    return ($is_fwk ? \af::$fwk_dir : \af::$app_dir) .$path;
}

function mkdir($dir)
{
    return \mkdir(fullpath($dir), 0775, true);
}