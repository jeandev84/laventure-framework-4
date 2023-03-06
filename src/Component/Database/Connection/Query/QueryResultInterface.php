<?php
namespace Lexus\Component\Database\Connection\Query;

interface QueryResultInterface
{


      /**
       * @return mixed
      */
      public function all();


      /**
       * @return mixed
      */
      public function one();


      /**
       * @return mixed
      */
      public function column();


      /**
       * @return mixed
      */
      public function columns();


      /**
       * @return mixed
      */
      public function assoc();


      /**
       * @return mixed
      */
      public function object();




      /**
       * @return mixed
      */
      public function count();
}