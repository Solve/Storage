<?php
/*
 * This file is a part of Solve framework.
 *
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 * @copyright 2009-2014, Alexandr Viniychuk
 * created: 05.01.14 11:01
 */

namespace Solve\Storage;


/**
 * Class ParametersStorage
 * @package Solve\Storage
 *
 * Class ParametersStorage is used to ...
 *
 * @version 1.0
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 */
class ParametersStorage extends ArrayStorage {

    public function __construct() {
        $args = func_get_args();
        if (count($args)) {
            $data = array_shift($args);
            parent::__construct($data);
            $defaultValue = '';

            if (!empty($args[0]) && is_array($args[0])) {
                $args = $args[0];
            }
            foreach($args as $key_index => $key_value) {

                if (is_scalar($key_index)) {
                    if (is_numeric($key_index)) {
                        $value = !empty($this->_data[$key_index]) ? $this->_data[$key_index] : $defaultValue;
                        $key_index = $key_value;
                        $key_value = $value;
                    }

//                    $this->_keys[] = $key_index;
                    if (!isset($this->_data[$key_index])) {
                        $this->_data[$key_index] = $key_value;
                    }
                }
            }
        }
    }

    public function __call($method, $params) {
        if (substr($method, 0, 3) == 'get') {
            $key = substr($method, 3);
            return $this->offsetGet(strtolower($key));
        }
    }

}