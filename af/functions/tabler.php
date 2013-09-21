<?php
namespace af;

/**
 * get an extract of csv from a filepath
 * @param type $path
 * @param type $header
 * @param type $delimiter
 * @param type $enclosure
 * @param type $escape
 * @return array|of|arrays|assocs
 */
function file2csv($path, $header = true, $delimiter = ',', $enclosure = '"', $escape = '\\')
{
    return str2csv(file_get_contents($path), $header, $delimiter, $enclosure, $escape);
}

/**
 * get an extract of csv from a string
 * @param string $input
 * @param bool|callable $header
 * @param string $delimiter
 * @param string $enclosure
 * @param string $escape
 * @param array $row
 * @return array|of|arrays|assocs
 */
function str2csv($input, $header = true, $delimiter = ',', $enclosure = '"', $escape = '\\')
{
    $rows    =   array_map(
        function($row) use ($delimiter, $enclosure, $escape)
        {return str_getcsv($row, $delimiter, $enclosure, $escape);},
        explode("\r\n", $input)
    );
    //  pop last (empty) line
    array_pop($rows);
    
    //  if header then create assocs
    if ($header)
    {
        //  shift the header
        $keys   =   array_shift($rows);
        
        if (is_callable($header))
        {
            $keys   =   array_map($header, $keys);
        }
        
        foreach($rows as &$row)
        {
            $row    =   array_combine($keys, $row);
        }
    }
    
    return $rows;
}