<?php
namespace Laventure\Component\Routing\Exception;

class NotFoundException extends \Exception
{

     public function __construct(string $message)
     {
         parent::__construct($message, 404);
     }
}