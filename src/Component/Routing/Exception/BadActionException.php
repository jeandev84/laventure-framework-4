<?php
namespace Lexus\Component\Routing\Exception;

class BadActionException extends \BadMethodCallException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }
}