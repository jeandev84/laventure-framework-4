<?php
namespace Laventure\Component\Console\Command\Contract;

interface ShellCommandInterface
{
    /**
     * @param string $command
     * @return mixed
    */
    public function exec(string $command);
}