<?php
namespace af;

function node($obj, $path, $sep = '/')
{
    assert(\strlen($sep));
    $nodes    =   \explode($sep, $path);
    while($node = \array_shift($nodes) and $obj = $obj->$node);
    return $obj;
}

function metadata($comment)
{
    $start      =   strpos($comment, '/**');
    $stop       =   strpos($comment, '*/',$start);
    return preg_match_all(
        '#\*\s*@([^\s]+)\s+([^\s]+)#', 
        substr($comment, $start, $stop - $start), 
        $matches
    ) ?
        (object)array_combine($matches[1], $matches[2])
        : 
        array()
    ;
}


function first_node($path, $sep = '/')
{
    $arr    =   explode($sep, $path);
    return array_shift($arr);
}

function last_node($path, $sep = '/')
{
    $arr    =   explode($sep, $path);
    return array_pop($arr);
}