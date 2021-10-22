<?php
declare(strict_types=1);


namespace Core\Http;


use Core\Interfaces\SessionsInterface;

use function session_start;
use function session_destroy;
use function session_status;
use function session_name;
use function session_get_cookie_params;
use function setcookie;
use function time;
use function serialize;
use function unserialize;

class Sessions implements SessionsInterface
{
    private array $_sessions;

    public function __construct()
    {
        if (!$this->isActive())
            session_start();

        $this->_sessions = $_SESSION;
    }
    public function isActive(): bool
    {
        return !(session_status() === PHP_SESSION_NONE || session_status() ===PHP_SESSION_DISABLED);

    }
    public function set(string $name, mixed $value, bool $replace = false): bool
    {
        if($this->has($name) && $replace === true)
            return false;
        else
            $_SESSION[$name] = serialize($value);
        return true;
    }

    public function get(?string $name = null): mixed
    {
        if(is_null($name))
            return $this->_sessions;
        elseif($this->has($name))
            return unserialize($this->_sessions[$name]);
        else
            return false;
    }

    public function destroy(): void
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public function has(string $name): bool
    {
        return isset($this->_sessions[$name]);
    }

    public function delete(string $name):void
    {
        if($this->has($name))
            unset($this->_sessions[$name], $_SESSION[$name]);
    }
}