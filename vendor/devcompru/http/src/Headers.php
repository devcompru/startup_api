<?php
declare(strict_types=1);


namespace Core\Http;


use Core\Interfaces\HeadersInterface;
use Exception;

use function getallheaders;
use function headers_sent;
use function header;
use function filter_var;
use function ucfirst;
use function strtolower;
use function array_map;
use function explode;
use function implode;


class Headers implements HeadersInterface
{
    private static HeadersInterface $_instance;
    private array $_headers;

    public function __construct()
    {
        foreach (getallheaders() as $key => $value)
        {
            $this->_headers[strtolower($key)] = filter_var($value, FILTER_SANITIZE_STRING);
        }
    }

    public function set(string $name, string $value): bool
    {
        if(!headers_sent())
        {
            $name = implode('-', array_map(fn($el)=>ucfirst($el), explode('-',$name)));
            header($name.': '.$value, true);
        }
        else
        {
            throw new Exception('Не удалось установить headers', 500);
        }
        return true;
    }
    public function setByArray(array $array): bool
    {
        foreach ($array as $name=>$value)
            $this->set($name,$value);

        return  true;
    }
    public function get(?string $name = null): bool|string|array
    {
        if(is_null($name))
            return $this->_headers;
        elseif($this->has($name))
            return $this->_headers[strtolower($name)];
        else
            return false;
    }
    public function has(string $name): bool
    {
        return isset($this->_headers[strtolower($name)]);
    }

}