<?php
namespace Laventure\Component\Database\Connection\Extensions\Mysqli;

interface MysqliConnectionInterface
{
       /**
        * @return \mysqli
       */
       public function getMysqli():  \mysqli;
}