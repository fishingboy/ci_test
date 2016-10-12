<?php
class Api
{
    public $a = [];

    public function __construct($config = [])
    {
        $this->a = $config;
    }

    public function get()
    {
        return $this->a;
    }
}