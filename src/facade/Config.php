<?php

namespace ayflying\facade;

/**
 * @see \ayflying\Config
 * @mixin \ayflying\Config
 */
class Config extends \think\Facade
{
    protected static $alwaysNewInstance = true;

    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'ayflying\Config';
    }
}
