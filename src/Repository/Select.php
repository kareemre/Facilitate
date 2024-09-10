<?php

namespace Kareem\illuminate\Facilitate\Repository;
use Illuminate\Support\Collection;

class Select
{
    /**
     * list
     * 
     * @var \Illuminate\Support\Collection
     */
    protected $list;

    public function __construct(array $selectList)
    {
        $this->list = new Collection($selectList);
    }

    /**
     * merge columns to the list
     * @param string ...$columns
     * 
     * @return $this
     */
    public function add(...$columns)
    {
        $this->list = $this->list->merge($columns)->all();
        
        return $this;
    }

    
}