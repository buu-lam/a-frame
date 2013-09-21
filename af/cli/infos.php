<?php
namespace af\cli;
/**
 * Description of infos
 *
 *
 * nodes:
 */
class infos extends \node
{
    public function run()
    {
        $this->dad->out('fwk_dir => ' . \af::$fwk_dir);
        $this->dad->out('app_dir => ' . \af::$app_dir);
    }
}

