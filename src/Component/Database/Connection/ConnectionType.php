<?php
namespace Laventure\Component\Database\Connection;

class ConnectionType
{
    const pdo_mysql  = 'pdo_mysql';
    const pdo_pgsql  = 'pdo_pgsql';
    const pdo_sqlite = 'pdo_sqlite';
    const pdo_oci    = 'pdo_oci';
    const mysqli     = 'mysqli';
}