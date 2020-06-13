<?php
declare (strict_types=1);

namespace ayflying;

class Config
{

    protected $path = "./config";
    public $config = [];

    /**
     * 初始化配置
     * @author  An Yang
     * @time 2020/6/10 19:33
     */
    public function __construct()
    {
        if (empty($this->config)) {
            self::load();
        }
        return $this->config;
    }

    public function config($config)
    {
        $this->$config = [];
    }

    public function pull(string $name): array
    {
        $name = strtolower($name);
        $config = $this->config[$name] ?? [];
        return $config;
    }

    /**
     * 获取配置
     * @param string $name 配置参数名（支持多级配置 .号分割）
     * @param null $default 默认值
     * @return mixed
     * @author  An Yang
     * @time 2020/6/10 20:27
     */
    public function get(string $name = "", $default = null)
    {
        // 无参数时获取所有
        if (empty($name)) {
            return $config = $this->config;
        }

        //获取一级配置
        if (false === strpos($name, '.')) {
            return $this->pull($name);
        }
        $name = explode('.', $name);
        $name[0] = strtolower($name[0]);

        // 按.拆分成多维数组进行判断
        $config = $this->config;
        foreach ($name as $val) {
            if (isset($config[$val])) {
                $config = $config[$val];
            } else {
                return $default;
            }
        }

        return $config;
    }


    /**
     * 设置配置参数 name为数组则为批量设置
     * @param array $config 配置参数
     * @param string|null $name 配置名
     * @return array
     * @author  An Yang
     * @time 2020/6/10 21:01
     */
    public function set(array $config, string $name = null): array
    {
        if (!empty($name)) {
            if (isset($this->$config[$name])) {
                $result = array_merge($this->$config[$name], $config);
            } else {
                $result = $config;
            }

            $this->config[$name] = $result;
        } else {
            $result = $this->$config = array_merge($this->$config, array_change_key_case($config));
        }
        return $result;
    }


    /**
     * 检测配置是否存在
     * @access public
     * @param  string $name 配置参数名（支持多级配置 .号分割）
     * @return bool
     */
    public function has(string $name): bool
    {
        return !is_null($this->get($name));
    }


    /**
     * 载入配置文件
     * @param string $name
     * @author  An Yang
     * @time 2020/6/10 20:49
     */
    public function load(string $name = "")
    {
        $list = [
            'app' => "app.php",
            'database' => 'database.php',
        ];

        //读取单独的配置
        if (!empty($name)) {
            $file = $this->path . DIRECTORY_SEPARATOR . $list[$name];
            if (is_file($file)) {
                $this->config[$name] = include $file;
            }
        } else {
            $files = glob($this->path . DIRECTORY_SEPARATOR . "*.php");
            $list = [];
            foreach ($files as $val) {
                //文件名去掉后缀，转为小写
                $name = strtolower(basename($val, ".php"));
                $list[$name] = $val;
            }
            foreach ($list as $key => $file) {
                if (is_file($file)) {
                    $this->config[$key] = include $file;
                }
            }
        }
    }
}