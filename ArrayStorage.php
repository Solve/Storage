<?php
/*
 * This file is a part of Solve framework.
 *
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 * @copyright 2009-2014, Alexandr Viniychuk
 * created: 24.11.13 19:12
 */

namespace Solve\Storage;

/**
 * Class ArrayStorage
 * @package Solve\Storage
 *
 * Class ArrayStorage is used to ...
 *
 * @version 1.0
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 */
class ArrayStorage extends BaseStorage {

    protected $_data = array();


    /**
     * Initialize and set the data
     * @param array $data
     */
    public function __construct($data = array()) {
        $this->_data = $data;
    }

    public function getFirst() {
        $arrayKeys = array_keys($this->_data);
        return empty($arrayKeys) ? null : $this->_data[$arrayKeys[0]];
    }

    public function getLast() {
        $arrayKeys = array_keys($this->_data);
        return empty($arrayKeys) ? null : $this->_data[$arrayKeys[count($arrayKeys) - 1]];
    }

    public function getIterator() {
        return new \ArrayIterator($this->_data);
    }

    public function offsetExists($offset) {
        return array_key_exists($offset, $this->_data);
    }

    public function &offsetGet($offset) {
//        $val = $this->offsetExists($offset) ? $this->_data[$offset] : null;
        return $this->_data[$offset];
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_data[] = $value;
        } else {
            $this->_data[$offset] = $value;
        }
    }

    public function offsetUnset($offset) {
        unset($this->_data[$offset]);
    }

    public function __set($key, $value) {
        $this->offsetSet($key, $value);
        return $value;
    }

    public function &__get($key) {
        return $this->offsetGet($key);
    }

    /**
     * Set data for current instance
     *
     * @param $data
     * @return mixed
     */
    public function setData($data) {
        if (!empty($data)) {
            foreach($data as $key=>$value) {
                $this->_data[$key] = $value;
            }
        } else {
            $this->_data = array();
        }
    }

    /**
     * @return array data stored in storage
     */
    public function getData() {
        return $this->_data;
    }

    /**
     * Return Array with all data
     *
     * @param string $key
     * @return mixed
     */
    public function getArray($key = null) {
        if (!is_null($key)) {
            return $this->getDeepValue($key);
        } else {
            return $this->_data;
        }
    }



}