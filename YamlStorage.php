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
    private $_path;

    public function __construct($path, $data = array()) {
        $this->_path = $path;
        $this->reload();
    }

    public function reload() {
        if (is_file($this->_path)) {
            $source = file_get_contents($this->_path);
            if (!empty($source)) {
                $this->setData(Yaml::parse($source));
            } else {
                $this->setData(array());
            }
        }
    }

    public function getPath() {
        return $this->_path;
    }

    public function flush() {
        file_put_contents($this->_path, Yaml::dump($this->_data, 6, 2));
    }

} 