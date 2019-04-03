<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_scanner extends CI_Controller
{
    private $path = "/home/vagrant/Code/www_irs/application/controllers";
    private $url = "http://irs.local";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 掃描 irs session 產生狀況
     */
    public function index()
    {
        $controllers = $this->getControllers($this->path);
        echo "<pre>controllers = " . print_r($controllers, true) . "</pre>\n";
	}

    private function getControllers($path)
    {
        $dir = opendir($path);
        $files = [];
        while ($f = readdir($dir)) {
            if ($f == "." || $f == '..') {
                continue;
            }

            $item = "$path/$f";
            if (is_file($item) && strpos($item, ".php")) {
                $files[] = $item;
            } else if (is_dir($item)) {
                $dir_files = $this->getControllers($item);
                $files = array_merge($files, $dir_files);
            }
        }
        return $files;
    }
}
