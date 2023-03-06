<?php
namespace Lexus\Component\Routing\Exception;

class BadControllerException extends \Exception
{
    public function __construct(string $controller)
    {
        parent::__construct("Controller {$controller} is not exist.", 400);
    }
}