<?php
namespace Hat\Environment\Builder;

/**
 * @author Ton Sharp <66ton99@gmail.com>
 */
class Delete extends Builder
{
    protected $defaults = array(
        'path' => null,
        'exclude' => null,
    );

    public function build()
    {
        $path = $this->get('path');
        if (empty($path)) {
            throw new \Exception('Path must be initialized.');
        }

        if ($this->rm($path)) {
            return true;
        }

        return false;
    }

    protected function isExcluded($file)
    {
        $excludes = array();
        if ($this->get('exclude')) {
            $excludes = explode(',', $this->get('exclude'));
        }

        $excludes = array_merge($excludes, array('.', '..'));
        foreach ($excludes as $exclude) {
            if ($exclude == $file) {
                return true;
            }
        }
    }

    protected function rm($path)
    {
        if (is_dir($path)) {
            $dirHandle = opendir($path);
        }
        if (empty($dirHandle)) {
            return false;
        }
        while ($file = readdir($dirHandle)) {
            if (!$this->isExcluded($file)) {
                if (is_dir($path . '/' . $file)) {
                    $this->rm($path . '/' . $file);
                } else {
                    unlink($path . '/' . $file);
                }
            }
        }
        closedir($dirHandle);
        @rmdir($path);
        return true;
    }
}
