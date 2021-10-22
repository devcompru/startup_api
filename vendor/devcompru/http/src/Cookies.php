<?php
declare(strict_types=1);


namespace Devcomp\Http;


use function filter_var;
use function setcookie;
use function time;


class Cookies
{

    private array $_cookies = [];
    private string $_domain;
    private int $_expires;
    private bool $_httponly;
    private bool $_secure;

    public function __construct($config)
    {
        $this->setConfig($config);
        foreach ($_COOKIE as $key => $value)
            $this->_cookies[filter_var($key, FILTER_SANITIZE_STRING)] = filter_var($value, FILTER_SANITIZE_STRING);

    }

    private function setConfig(array $config):void
    {
        $this->_domain = isset($config['domain'])?$config['domain']:'unicso.ru';
        $this->_expires = isset($config['expires'])?$config['expires']:60*60*24*30;
        $this->_secure = isset($config['secure'])?$config['secure']:true;
        $this->_httponly = isset($config['httponly'])?$config['httponly']:false;

    }
    public function set(string $name, string $value, array $options = []): bool
    {
        $options['expires']  ??= $this->_expires;
        $options['domain']   ??= $this->_domain;
        $options['secure']   ??= $this->_secure;
        $options['httponly'] ??= $this->_httponly;
        $options['expires']  = time() + $options['expires'];
        return setcookie($name, $value, $options);
    }

    public function get(?string $name = null): bool|string|array
    {
        if(is_null($name))
            return $this->_cookies;
        elseif($this->has($name))
            return $this->_cookies[$name];
        else
            return false;
    }

    public function remove($name): bool
    {
        $this->set($name, '', ['expires'=>time()-82000]);
        return true;
    }

    public function has(string $name): bool
    {
        return isset($this->_cookies[$name]);
    }
}