<?php

namespace ayflying\facade;

/**
 * @see \ayflying\Env
 * @mixin \ayflying\Env
 */
class Env extends \think\Facade
{
    protected static $alwaysNewInstance = true;

    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'ayflying\Env';
    }
}
