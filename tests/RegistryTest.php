<?php

namespace Imj\test;

use Imj\Registry;

/**
 * Class RegistryTest
 * @package Imj\test
 */
class RegistryTest extends \PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $r = new Registry();
        $r->set('foo', 'a');
        $this->assertEquals('a', $r->get('foo'));
        $this->assertEquals('a', $r['foo']);

        $r['bar'] = 'b';
        $this->assertEquals('b', $r['bar']);

        $r->singleton('foo_class', function($c){
            return new Foo();
        });
        $this->assertEquals('hi', $r->get('foo_class')->sayHi());
        $this->assertEquals('hi', $r->foo_class->sayHi());

        $r->register(new LibraryProvider());
        $this->assertEquals('hey', $r->bar_class->sayHey());
    }
}

class Foo
{
    public function sayHi()
    {
        return 'hi';
    }
}