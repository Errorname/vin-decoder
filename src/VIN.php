<?php

namespace Errorname\VINDecoder;

class VIN implements \ArrayAccess {

    protected $data = [];

    public function __construct($raw = []) {
        foreach($raw as $attribute) {
            $this->data[$attribute['label']] = $attribute['value'];
        }
    }

    public function available() {
        return array_keys($this->data);
    }

    /* GETTERS AND SETTERS */

    public function __get($name) {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }

    public function __isset($name) {
        return isset($this->data[$name]);
    }

    public function offsetSet($offset, $value) {
        throw new \Exception('VIN are read-only objects');
    }

    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset) {
        throw new \Exception('VIN are read-only objects');
    }

    public function offsetGet($offset) {
        return $this->data[$offset] ?? null;
    }

}
