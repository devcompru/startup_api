<?php
declare(strict_types=1);


namespace Devcomp\Http;


class Response implements ResponseInterface
{
    const   TYPE_JSON = 'JSON',
            TYPE_HTML = 'HTML',
            TYPE_XML = 'XML',
            TYPE_RAW = 'RAW';
    private  $_headers;
    private int $_code = 200;
    private mixed $_body;
    private string $_type  = self::TYPE_JSON;
    private bool $_error = false;
    public function __construct()
    {


    }


    public function emit()
    {


        ob_start();
        echo $this->build();
        $size = ob_get_length();

        $this->_headers->set('Content-Encoding', 'none');
        $this->_headers->set('Content-Length', "$size");
        $this->_headers->set('Connection', 'close');

        ob_end_flush();
        flush();

        if(session_id())
            session_write_close();
        fastcgi_finish_request();

        return $this;
    }

    public function afterRender($object, $method)
    {
        $object->$method();
    }
    public function build()
    {

        if($this->_type === self::TYPE_JSON)
        {
            $this->_headers->set('content-type', 'application/json;charset=utf-8');
            $response_array = [
                'code'=>$this->_code,
                'error'=>$this->_error,
                'is_guest'=>Core::$app->user()->is_guest,
                'token'=>Core::$app->user()->token,
                'auth_token'=>Core::$app->user()->auth_token,
                'body'=>$this->_body,
            ];
            return   json_encode($response_array, JSON_INVALID_UTF8_IGNORE);

        }
        elseif($this->_type === self::TYPE_HTML)
        {
            $this->_headers->set('content-type', 'text/html;charset=utf-8');
            return is_string($this->_body)?$this->_body:json_encode($this->_body, JSON_UNESCAPED_UNICODE);
        }

        elseif ($this->_type === self::TYPE_RAW)
        {
           // $this->_headers->set('content-type', 'text/html;charset=utf-8');
            return $this->_body;

        }

    }

    public function setType(string $type)
    {
        if($type === self::TYPE_JSON || $type === self::TYPE_HTML || $type === self::TYPE_XML || $type === self::TYPE_RAW )
            $this->_type = $type;
        return $this;
    }
    public function asHtml()
    {
        $this->_type = self::TYPE_HTML;
    }
    public function setBody(mixed $body)
    {
        $this->_body = $body;
        return $this;
    }

    public function setDefaultHeaders(array $headers)
    {
        $this->_headers->set('content-type', 'application/json;charset=utf-8');
        return $this;
    }

    public function setCode( $code=200)
    {
        $this->_code = (int)$code;
        return $this;
    }
    public function setError(bool $error = true)
    {
        $this->_error = $error;
        return $this;
    }
}