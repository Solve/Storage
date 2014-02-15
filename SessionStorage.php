<?php
/*
 * This file is a part of Solve framework.
 *
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 * @copyright 2009-2014, Alexandr Viniychuk
 * created: 08.01.14 01:35
 */

namespace Solve\Storage;


/**
 * Class SessionStorage
 * @package Solve\Storage
 *
 * Class SessionStorage is used to ...
 *
 * @version 1.0
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 */
class SessionStorage extends ArrayStorage {

    protected $_data = null;

    protected $_id;

    /**
     * Initialize and set the data
     * @param array $data
     * @param string $id
     */
    public function __construct($data = array(), $id) {
        if (empty($_SESSION['__storage_' . $id])) {
            $_SESSION['__storage_' . $id] = $data;
        }
        $this->_data = &$_SESSION['__storage_' . $id];
    }

}