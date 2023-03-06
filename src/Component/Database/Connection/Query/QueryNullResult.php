<?php
namespace Laventure\Component\Database\Connection\Query;


class QueryNullResult implements QueryResultInterface
{

    /**
     * @inheritDoc
     */
    public function all()
    {
         return [];
    }



    /**
     * @inheritDoc
    */
    public function one()
    {
        return null;
    }



    /**
     * @inheritDoc
    */
    public function column()
    {
        return null;
    }



    /**
     * @inheritDoc
    */
    public function columns()
    {
        return [];
    }



    /**
     * @inheritDoc
    */
    public function assoc()
    {
        return [];
    }




    /**
     * @inheritDoc
     */
    public function object()
    {
        return null;
    }



    /**
     * @inheritDoc
    */
    public function count()
    {
         return 0;
    }
}