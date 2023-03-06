<?php
namespace Laventure\Component\Database\Schema\BluePrint;

use Laventure\Component\Database\Schema\BluePrint\Column\Column;

interface BluePrintInterface
{

    /**
     * @param string $name
     * @return Column
    */
    public function increments(string $name): Column;





    /**
     * @param string $name
     * @param int $length
     * @return Column
    */
    public function string(string $name, int $length = 255): Column;





    /**
     * @param string $name
     * @return Column
    */
    public function text(string $name): Column;





    /**
     * @param string $name
     * @return Column
    */
    public function datetime(string $name): Column;





    /**
     * @param string $name
     * @return Column
    */
    public function boolean(string $name): Column;




    /**
     * @param string $name
     * @param int $length
     * @return Column
    */
    public function integer(string $name, int $length = 11): Column;




    /**
     * @param string $name
     * @return Column
    */
    public function smallInteger(string $name): Column;





    /**
     * @param string $name
     * @return Column
    */
    public function bigInteger(string $name): Column;
}