<?php
namespace Laventure\Component\Console\Command;

use Laventure\Component\Console\Command\Contract\ShellCommandInterface;

class ShellCommand extends Command implements ShellCommandInterface
{

    /**
     * @inheritDoc
    */
    public function exec(string $command)
    {
        return shell_exec($command);
    }
}