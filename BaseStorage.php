<?php
/*
 * This file is a part of Solve framework.
 *
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 * @copyright 2009-2014, Alexandr Viniychuk
 * created: 24.11.13 19:07
 */

namespace Solve\Storage;

/**
 * @package Solve\EventDispatcher
 *
 * Interface StrageInterface is used to be implemented for storage classes
 *
 * @version 1.0
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 */
abstract class BaseStorage implements \ArrayAccess, \IteratorAggregate, \Countable {

    protected $_data;

    /**
     * Set data for current instance
     *
     * @param $data
     * @return BaseStorage
     */
    public function setData($data) {
        $this->_data = new \ArrayIterator($data);
    }

    /**
     * Return Array with all data
     *
     * @param string $key
     * @return Array
     */
    public function getArray($key = null) {}

    /**
     * Set value to current instance with key sliced by "/"
     *
     * @param mixed $value
     * @param string $deepKey
     * @return BaseStorage
     */
    public function setDeepValue($deepKey, &$value) {
        setDeepArrayValue($this->_data, $value, $deepKey);
        return $this;
    }

    public function unsetDeepValue($deepKey) {
        unsetDeepArrayValue($this->_data, $deepKey);
    }

    public function extendDeepValue($extender, $key = null) {
        $extendHandler = null;
        if ($key) {
            if ($this->has($key)) {
                $extendHandler = $this->getDeepValue($key);
            }
        } else {
            $extendHandler = &$this->_data;
        }
        if (is_null($extendHandler)) $extendHandler = array();
        extendDeepArrayValue($extender, $extendHandler);
        if ($key) {
            $this->setDeepValue($key, $extendHandler);
        }
        return $this;
    }

    public function getDeepValue($deepKey, $defaultValue = null) {
        $value = getDeepArrayValue($this->_data, $deepKey);
        return is_null($value) ? $defaultValue : $value;
    }

    public function erase() {
        unset($this->_data);
    }

    public function clear() {
        $this->_data = array();
    }

    public function isEmpty() {
        return empty($this->_data);
    }

    public function has($key) {
        return $this->offsetExists($key);
    }

    public function get($key, $defaultValue = null) {
        return $this->offsetExists($key) ? $this->offsetGet($key) : $defaultValue;
    }

    public function getKeys() {
        return array_keys($this->_data);
    }

    public function count() {
        return count($this->_data);
    }

}

if (!function_exists('getDeepArrayValue')) {
    function getDeepArrayValue($array, $what = null) {
        if ($what !== null) {
            $what = explode('/', $what);
            foreach($what as $key) {
                if (!isset($array[$key])) return null;

                $array = $array[$key];
            }
        }

        return $array;
    }

    function setDeepArrayValue(&$array, $value, $what = null) {
        $set_to = &$array;
        if ($what) {
            $what = explode('/', $what);
            foreach($what as $key) {
                if (is_object($set_to)) {
                    $set_to[$key] = array();
                } elseif (!array_key_exists($key, $set_to)) $set_to[$key] = array();

                $set_to = &$set_to[$key];
                if (!is_object($set_to) && (is_null($set_to))) $set_to = array();
            }
        }
        $set_to = $value;
    }

    function unsetDeepArrayValue(&$array, $what = null) {
        $deep = &$array;
        if ($what) {
            $what = explode('/', $what);
            foreach($what as $i => $key) {
                if (!array_key_exists($key, $deep)) break;
                if ($i == count($what) -1) {
                    unset($deep[$key]);
                } else {
                    $deep = &$deep[$key];
                }
            }
        }
    }

    function extendDeepArrayValue($extender, &$handle) {
        foreach($extender as $key=>$value) {
            if (!array_key_exists($key, $handle)) {
                $handle[$key] = $value;
                continue;
            }
            if (is_array($value)) {
                extendDeepArrayValue($value, $handle[$key]);
            } else {
                $handle[$key] = $value;
            }
        }
    }

    function convertObjectToArray ($object) {
        if(!is_object($object) && !is_array($object))
            return $object;

        return array_map('convertObjectToArray', (array) $object);
    }
}