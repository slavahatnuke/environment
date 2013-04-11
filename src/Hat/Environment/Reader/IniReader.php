<?php
namespace Hat\Environment\Reader;

use Hat\Environment\Profile;

class IniReader extends Reader
{

    public function has($path)
    {
        return file_exists($path);
    }

    public function read($path)
    {
        if (!$this->has($path)) {
            throw new ReaderException('File is not found: ' . getcwd() . DIRECTORY_SEPARATOR . $path);
        } else {
            return parse_ini_file($path, true);
        }

    }


}
