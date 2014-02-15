<?php
/*
 * This file is a part of Solve framework.
 *
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 * @copyright 2009-2014, Alexandr Viniychuk
 * created: 24.11.13 19:12
 */

namespace Solve\Storage;
use Traversable;


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

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator() {
        return new \ArrayIterator($this->_data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset) {
        return array_key_exists($offset, $this->_data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function &offsetGet($offset) {
//        $val = $this->offsetExists($offset) ? $this->_data[$offset] : null;
        return $this->_data[$offset];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_data[] = $value;
        } else {
            $this->_data[$offset] = $value;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset) {
        unset($this->_data[$offset]);
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