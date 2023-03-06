<?php
namespace Laventure\Component\Console\Output\Contract;



/**
 * OutputInterface
 */
interface OutputInterface
{


    /**
     * Write message inline
     *
     * @param $message
     * @return mixed
     */
    public function write($message);




    /**
     * Write and go to the new line
     *
     * @param $message
     * @return mixed
    */
    public function writeln($message);





    /**
     * Print all messages
     *
     * @return string
    */
    public function __toString();

}