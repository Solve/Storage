<?php
/*
 * This file is a part of Solve framework.
 *
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 * @copyright 2009-2014, Alexandr Viniychuk
 * created: 10/23/14 6:10 PM
 */

namespace Solve\Storage\ArrayStorage\Tests;

require_once __DIR__ . '/../BaseStorage.php';
require_once __DIR__ . '/../ArrayStorage.php';

use Solve\Storage\ArrayStorage;

class ArrayStorageTest extends \PHPUnit_Framework_TestCase {

    public function testBasic()     {

        $storage = new ArrayStorage();
        $storage->offsetSet('key', 'value');
        $this->assertEquals('value', $storage->offsetGet('key'), 'offsetGet after offsetSet');
        $this->assertEquals('value', $storage->get('key'), 'get after offsetSet');
        $this->assertEquals('value', $storage['key'], '[]get after offsetSet');
        $this->assertEquals('value', $storage->key, '__get after offsetSet');

        $storage->key2 = 'value2';
        $this->assertEquals('value2', $storage->key2, '__get after __set');
        $this->assertEquals('value2', $storage->get('key2'), 'get after __set');
    }

}
