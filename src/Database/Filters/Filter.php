<?php

namespace Kareem\illuminate\Facilitate\Database\Filters;

class Filter
{   
    
    /**
     * available filters
     * 
     * @const array
     */
    const FILTER_MAP = [
        '='    => 'basicFilter',
        '>'    => 'basicFilter',
        '<'    => 'basicFilter',
        '>='   => 'basicFilter',
        '<='   => 'basicFilter',
        'like' => 'filterLike',
        'in'   => 'filterIn',
    ];

    /**
     * query builder instance
     * 
     * @var \Illuminate\Database\Query\Builder
     */
    protected $query;

    /**
     * Set the query builder instance
     * 
     * @param  \Illuminate\Database\Query\Builder $query
     * @return void
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * Filter columns with basic operators
     * 
     * @param array $columns
     * @param string $value
     * @param string $operator
     * @return void 
     */
    public function basicFilter($columns, $value, $operator = '=')
    {
        foreach ($columns as $column) {
            $this->query->where($column, $operator, $value);
        }
    }


    /**
     * Filter with Like operator.
     *
     * @param array $columns
     * @param string $value     
     * @return void
     */
    public function filterLike($columns, $value)
    {
        $this->query->where(function ($query) use ($columns, $value) {
            foreach ($columns as $index => $column) {
                if ($index > 0) {
                    $query->orWhereLike($column, $value);
                } else {
                    $query->whereLike($column, $value);
                }
            }
        });
    }


    /**
     * Get all available filters map 
     * 
     * @return array 
     */
    public function filterMap()
    {
        return static::FILTER_MAP;
    }
}