<?php
namespace af;
/**
 * Description of module
 *
 * @author b.le
 * nodes:
 */
abstract class module extends \node
{
    abstract public function run($url = null);
    
    /**
     * 
     * @return \module
     */
    public function module()
    {
        return $this;
    }
}
