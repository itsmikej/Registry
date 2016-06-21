<?php

namespace Imj;

/**
 * Class Registry
 * @package Imj
 */
class Registry implements \ArrayAccess, \Countable, \IteratorAggregate
{
    private $_values = [];

    public function __construct()
    {
    }

    /**
     * get value
     * If the variable is an object, it will be instantiated
     * @param $key
     * @param bool|true $ins
     * @return null
     */
    public function get($key, $ins = true)
    {
        if ($this->has($key)) {
            $is_invoke = is_object($this->_values[$key]) && method_exists($this->_values[$key], '__invoke');
            return ($is_invoke && $ins) ? $this->_values[$key]($this) : $this->_values[$key];
        }
        return null;
    }

    /**
     * set value
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value)
    {
        if ($this->has($key)) {
            return false;
        }
        $this->_values[$key] = $value;
        return true;
    }

    /**
     * check
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->_values[$key]);
    }

    /**
     * remove
     * @param $key
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            unset($this->_values[$key]);
        }
    }

    /**
     * replace
     * @param $key
     * @param $value
     * @param bool|true $singleton
     */
    public function replace($key, $value, $singleton = true)
    {
        $this->remove($key);
        $singleton ? $this->singleton($key, $value) : $this->set($key, $value);
    }

    /**
     * clear
     */
    public function clear()
    {
        $this->_values = array();
    }

    /**
     * Make sure instance unique
     * @param $key
     * @param $value
     */
    public function singleton($key, $value)
    {
        $this->set($key, function($c) use ($value) {
            static $object;

            if (null === $object) {
                $object = $value($c);
            }

            return $object;
        });
    }

    /**
     * Service register
     * @param ServiceProviderInterface $provider
     * @param array $values
     * @return $this
     */
    public function register(ServiceProviderInterface $provider, array $values = array())
    {
        $provider->register($this);

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }

        return $this;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    public function count()
    {
        return count($this->_values);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_values);
    }
}
