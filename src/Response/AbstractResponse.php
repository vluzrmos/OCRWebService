<?php

namespace OCRWebService\Response;

/**
 * Class AbstractResponse
 * @package OCRWebService\Response
 */
abstract class AbstractResponse
{
    protected $data;

    /**
     * Constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (method_exists($this, $method = 'get' . ucfirst($name))) {
            return $this->$method;
        }

        return $this->__call($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __call($name, array $arguments = [])
    {
        $name = ucfirst(preg_replace('/^get/i', '', $name));

        return $this->getAttribute($name);
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        return $this->hasAttribute($name) ? $this->data[$name] : $default;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        return isset($this->data[$name]);
    }
}