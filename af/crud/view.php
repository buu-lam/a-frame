<?php
namespace af\crud;

/**
 * Description of view
 *
 *
 * nodes:
 */
class view extends \view
{
    public function path_template()
    {
        return \af::$app_dir . '/' . str_replace('/view.php', '/template.php', $this->_path);
    }
}
