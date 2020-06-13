# PHP配置读取

### 安装
~~~
composer require ayflying/config
~~~

## 使用方法
~~~
use ayflying\facade\Config;

//读取配置
Config::get("name");

//写入配置
Config::set("name","data");

~~~