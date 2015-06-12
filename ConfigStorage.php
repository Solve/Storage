<?php
/*
 * This file is a part of control project.
 *
 * @author Alexandr Viniychuk <a@viniychuk.com>
 * created: 12:13 AM 5/29/15
 */

namespace Solve\Storage;


class ConfigStorage extends ArrayStorage {

    public function get($deepKey, $defaultValue = NULL) {
        return $this->getDeepValue($deepKey, $defaultValue);
    }

}