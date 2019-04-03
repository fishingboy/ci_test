<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_scanner extends CI_Controller
{
    private $path = "/home/vagrant/Code/www_irs/application/controllers";
    private $url = "http://irs.local";
    private $curl_error;
    private $http_status_code;
    private $response_body;
    private $session_path = "/tmp2";
    private $curl_timeout = 60;

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

        $urls = $this->getScanUrls($controllers);
        echo "<pre>urls = " . print_r($urls, true) . "</pre>\n";
	}

    public function scan()
    {
        // 清除 session
        $this->clearSession();

        // 取出所有 method
        $controllers = $this->getControllers($this->path);
        $urls = $this->getScanUrls($controllers);

        // 逐一 post
        $total = 0;
        foreach ($urls as $url) {
            foreach ($url['methods'] as $method) {
                $total++;
                $method_url = "{$this->url}/{$url['controller_name']}/{$method['method_name']}" . str_repeat("/1", $method['arg_count']);
                echo "<pre>url = " . print_r($method_url, true) . "</pre>\n";

                $ret = $this->curlPost($method_url, [], $http_status_code, $response_body);
                echo "<pre>ret = " . print_r($ret, true) . "</pre>\n";
                break 2;
            }
        }
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

    private function getMethods($file)
    {
        $fp = fopen($file, "r");
        $methods = [];
        while ($line = fgets($fp)) {
            if (preg_match("/^[ ]+public[ ]+function[ ]+([a-zA-Z0-9_]+)\((.*)\)/", $line, $matches)) {
                $method_name = $matches[1];
                $args = $matches[2];
                $arg_count = ($args) ? count(explode(",", $matches[2])) : 0;

                if ($method_name == "__construct") {
                    continue;
                }

                $methods[] = [
                    'method_name' => $method_name,
                    'args'        => $args,
                    'arg_count'   => $arg_count,
                ];
            }
        }
        return $methods;
    }

    /**
     * CURL 取得資料
     * @param  string $url 網址
     * @param array $data
     * @param null $http_status_code
     * @param null $response_body
     * @return string|array  回應內容
     */
    public function curlPost($url, $data = [], & $http_status_code = null, & $response_body = null)
    {
        $url = trim($url);
        $curl = curl_init($url);

        if (substr($url, 0, 5) == "https") {
            curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        } else {
            curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP);
        }
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->curl_timeout);

        // post 參數
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        // 執行 curl
        $data = curl_exec($curl);

        // 檢查是否有錯誤
        $this->curl_error = "";
        if (false === $data) {
            $this->curl_error = curl_error($curl);;
        }

        // 取得 response code
        $http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $this->http_status_code = $http_status_code;

        // 取得 response body
        $response_body = file_get_contents("php://input",'r');
        $this->response_body = $response_body;

        // json decode
        if ($data) {
            $tmp = json_decode($data, true);
            if ($tmp) {
                $data = $tmp;
            }
        }

        return $data;
    }

    private function getScanUrls(array $controllers)
    {
        $urls = [];
        foreach ($controllers as $controller) {
            $controller_name = str_replace("{$this->path}/", "", $controller);
            $controller_name = str_replace(".php", "", $controller_name);
            $methods = $this->getMethods($controller);
            $urls[] = [
                'controller_name' => $controller_name,
                'methods' => $methods,
            ];
        }
        return $urls;
    }

    public function clearSession()
    {
        shell_exec("rm -rf {$this->session_path}/*");
    }

    /**
     * 計算目錄內的檔案數
     * @param $path
     * @return int
     */
    private function getFolderItemCount($path)
    {
        $dir = opendir($path);
        $count = 0;
        while ($f = readdir($dir)) {
            $file = "$path/$f";
            if (is_file($file)) {
                $count++;
            }
        }
        return $count;
    }
}
