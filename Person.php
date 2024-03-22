<?php

class Person
{
    private $data = [];


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function export (InterfaceExporter $objExporter)
    {
        return $objExporter->export($this->data);
    }

}