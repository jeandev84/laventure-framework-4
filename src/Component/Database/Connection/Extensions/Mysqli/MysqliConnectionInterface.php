<?php
namespace Lexus\Component\Database\Connection\Extensions\Mysqli;

interface MysqliConnectionInterface
{
       /**
        * @return \mysqli
       */
       public function getMysqli():  \mysqli;
}