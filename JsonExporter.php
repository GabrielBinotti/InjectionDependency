<?php

require "InterfaceExporter.php";

class JsonExporter implements InterfaceExporter
{
    public function export(array $data)
    {
        return json_encode($data);
    }
}