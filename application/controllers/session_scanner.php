<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_scanner extends CI_Controller
{
    private $systems = [
        'irs' => [
            "path" => "/home/vagrant/Code/www_irs/application/controllers",
            "url" => "http://irs.local",
            "session_path" => "/tmp2",
        ],
        'irs2' => [
            "path" => "/home/vagrant/Code/www_irs2/application/controllers",
            "url" => "http://irs2.local",
            "session_path" => "/tmp3",
        ],
    ];

    private $curl_error;
    private $http_status_code;
    private $response_body;
    private $curl_timeout = 60;
    private $header;

    public function __construct()
    {
        parent::__construct();

        $this->benchmark->mark('start');
    }

    public function showTime()
    {
        $this->benchmark->mark('end');
        echo $this->benchmark->elapsed_time('start', 'end') . "秒";
    }

    /**
     * 掃描 irs session 產生狀況
     * @param string $system
     */
    public function index($system = "irs")
    {
        $system_path = $this->systems[$system]['path'];
        $system_url = $this->systems[$system]['url'];
        $system_session_path = $this->systems[$system]['session_path'];

        $controllers = $this->getControllers($system_path);
        echo "<pre>controllers = " . print_r($controllers, true) . "</pre>\n";

        $urls = $this->getScanUrls($controllers, $system_path);
        echo "<pre>urls = " . print_r($urls, true) . "</pre>\n";

        $this->showTime();
	}

    /**
     *
     * @param string $system
     */
    public function scan($system = "irs")
    {
        $system_path = $this->systems[$system]['path'];
        $system_url = $this->systems[$system]['url'];
        $system_session_path = $this->systems[$system]['session_path'];

        // 清除 session
        $this->clearSession($system_session_path);

        // 取出所有 method
        $controllers = $this->getControllers($system_path);
        $urls = $this->getScanUrls($controllers, $system_path);

        // 逐一 post
        $total = 0;
        $session_total = 0;
        $error_total = 0;
        foreach ($urls as $url) {
            foreach ($url['methods'] as $method) {
                $controller_name = strtolower($url['controller_name']);
                $method_name = strtolower($method['method_name']);

                if (false !== strpos($controller_name, 'script')) {
//                    echo "<pre>exit.controller_name = " . print_r($controller_name, true) . "</pre>\n";
                    continue;
                }

                if (false !== strpos($controller_name, 'system')) {
//                    echo "<pre>exit.controller_name = " . print_r($controller_name, true) . "</pre>\n";
                    continue;
                }

                if (false !== strpos($controller_name, 'sync')) {
//                    echo "<pre>exit.controller_name = " . print_r($controller_name, true) . "</pre>\n";
                    continue;
                }

                if (false !== strpos($method_name, 'delete')) {
//                    echo "<pre>exit.method_name = " . print_r($method_name, true) . "</pre>\n";
                    continue;
                }
//
//                if ( ! in_array($url['controller_name'], ["app_v2", "irs"])) {
//                    continue;
//                }
                if ( ! in_array($url['controller_name'], ["question"])) {
                    continue;
                }

                $total++;
                $method_url = "{$system_url}/{$url['controller_name']}/{$method['method_name']}" . str_repeat("/1", $method['arg_count']);
//                echo "url = <a href='$method_url' target='_blank'>$method_url</a><br>";

                $ret = $this->curlPost($method_url, [], $http_status_code, $response_body);
                $is_error = $this->isError($ret);

                $header = $this->getResponseHeader();
                $is_enable_session = $this->isEnableSession($header);
                $session_status = "<span style='color:green'>[Session:Off] </span>";
                if ($is_enable_session) {
                    $session_total++;
                    $session_status = "<span style='color:red'>[Session:On] </span>";
                }

//                echo "<pre>ret = " . print_r($ret, true) . "</pre>\n";
                if ($is_error) {
                    $error_total++;
//                    break 2;
                    echo "{$session_status} - <a href='$method_url' target='_blank'>$method_url</a>, Error!<br>";
                } else {
                    echo "{$session_status} - <a href='$method_url' target='_blank'>$method_url</a>, Ok!<br>";
                }
//
//                if ($total > 10) {
//                    break 2;
//                }
            }
        }

        echo "<div>total: $total, error_total = $error_total</div>";
        echo "<div>session total: $session_total</div>";

        $session_count = $this->getFolderItemCount($system_session_path);
        echo "<div>session file count: $session_count</div>";

        $this->showTime();
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

        // 拿 header
        curl_setopt($curl, CURLOPT_HEADER, 1);

        // 執行 curl
        $data = curl_exec($curl);



        // 檢查是否有錯誤
        $this->curl_error = "";
        if (false === $data) {
            $this->curl_error = curl_error($curl);;
        }

        // 分離 header 和 content
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $this->header = substr($data, 0, $header_size);
        $body = substr($data, $header_size);

        // 取得 response code
        $http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $this->http_status_code = $http_status_code;

        // 取得 response body
        $response_body = file_get_contents("php://input",'r');
        $this->response_body = $response_body;

        // json decode
        if ($body) {
            $tmp = json_decode($body, true);
            if ($tmp) {
                $body = $tmp;
            }
        }

        return $body;
    }

    private function getResponseHeader()
    {
        return $this->header;
    }

    private function getScanUrls(array $controllers, $path)
    {
        $urls = [];
        foreach ($controllers as $controller) {
            $controller_name = str_replace("{$path}/", "", $controller);
            $controller_name = str_replace(".php", "", $controller_name);
            $methods = $this->getMethods($controller);
            $urls[] = [
                'controller_name' => $controller_name,
                'methods' => $methods,
            ];
        }
        return $urls;
    }

    public function clearSession($session_path)
    {
        shell_exec("rm -rf {$session_path}/*");
        echo "clear session folder: `$session_path` <br>";
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

    private function isError($ret)
    {
        if (is_array($ret)) {
            return false;
        }

        if (strpos($ret, "Fatal error")) {
            return true;
        }

        if (strpos($ret, "Severity: Notice")) {
            return true;
        }

        if (strpos($ret, "Warning")) {
            return true;
        }

        return false;
    }

    private function isEnableSession($header)
    {
        if (strpos($header, "PHPSESSID=")) {
            return true;
        }
        return false;
    }
}
