<?php
/*
 * This file is a part of Solve framework.
 *
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 * @copyright 2009-2014, Alexandr Viniychuk
 * created: 02.01.14 23:53
 */

namespace Solve\Storage;
use Symfony\Component\Yaml\Yaml;


/**
 * Class YamlStorage
 * @package Solve\Storage
 *
 * Class YamlStorage is used to ...
 *
 * @version 1.0
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 */
class YamlStorage extends ArrayStorage {

    /**
     * @var string file associated with current storage
     */
    private $_filename;

    public function __construct($filename, $data = array()) {
        $this->_filename = $filename;
        $this->reload();
    }

    public function reload() {
        if (is_file($this->_filename)) {
            $source = file_get_contents($this->_filename);
            if (!empty($source)) {
                $this->setData(Yaml::parse($source));
            } else {
                $this->setData(array());
            }
        }
    }

    public function flush() {
        file_put_contents($this->_filename, Yaml::dump($this->_data, 6, 2));
    }

} 