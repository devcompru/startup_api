<?php
declare(strict_types=1);

namespace Devcompru\Http;


use function filter_var;
use function parse_str;
use function file_get_contents;


class Request
{
    private string $_method;
    private array  $_get = [];
    private array  $_post;
    private array  $_put;
    private array  $_patch;
    private string $_query_string;
    private string $_uri;



    public function __construct()
    {
        $this->_method = $_SERVER['REQUEST_METHOD'] ??= 'GET';
        $_SERVER['REQUEST_URI'] ??= '';
        $_SERVER['QUERY_STRING'] ??= '';

        $this->_query_string = filter_var($_SERVER['QUERY_STRING'], FILTER_SANITIZE_STRING);
        $this->_query_string = str_replace('?', '&', $this->_query_string);

        parse_str($this->_query_string, $this->_get);


        $this->_uri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING);
    }

    public function isGet():    bool
    {
        return $this->_method === 'GET';
    }
    public function isPost():   bool
    {
        return $this->_method === 'POST';
    }
    public function isPut():    bool
    {
        return $this->_method === 'PUT';
    }
    public function isPatch():  bool
    {
        return $this->_method === 'PATCH';
    }
    public function isDelete(): bool
    {
        return $this->_method === 'DELETE';
    }

    public function get(?string $name = null):  bool|array|string
    {
        return $this->getFromArray($name, $this->validate($this->_get));
    }
    public function post(?string $name = null): bool|array|string
    {
        $data_array = $_POST;
        if($this->isPost())
            return $this->getFromArray($name, $this->validate($data_array));

        return false;

    }
    public function put(?string $name = null):  bool|array|string
    {
        parse_str($this->body(), $_PUT);;
        $data_array = $_PUT;
        if($this->isPut())
            return $this->getFromArray($name, $this->validate($data_array));

        return false;

    }

    public function uri():          string
    {
        return $this->_uri;
    }
    public function path():         string
    {
        return parse_url($this->_uri)['path'];
    }
    public function body():         string
    {
        return file_get_contents('php://input');
    }
    public function method():       string
    {
        return $this->_method;
    }
    public function queryString():  string
    {
        return str_replace('?','&', $this->_query_string);
    }


    private function validate(array $array): array
    {

        return $array;
    }
    private function getFromArray(?string $name, array $array): bool|array|string
    {
        if(is_null($name))
            return $array;
        elseif(isset($array[$name]))
            return $array[$name];
        else
            return false;
    }


}