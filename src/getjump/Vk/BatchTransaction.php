<?php

namespace getjump\Vk;

use getjump\Vk\Response\Api;

/**
 * Class BatchTransaction
 * Used for processing data from api methods that supports count and offset
 * @package getjump\Vk
 */
class BatchTransaction implements \Iterator
{
    private $position = 0;
    private $count = 0;
    private $transaction = null;
    private $eof = false;

    public function __construct(RequestTransaction $transaction, $count = 0)
    {
        $this->transaction = $transaction;
        $this->position = 0;
        $this->count = $count;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return Api
     */
    public function current()
    {
        $this->transaction->incrementOffset($this->position * $this->count);
        $d = $this->transaction->fetchData();
        $count = sizeof($d->response->items);
        $this->eof = $count > 0 && $count >= $this->count ? false : true;
        return $d;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return !$this->eof;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->position = 0;
    }
}
