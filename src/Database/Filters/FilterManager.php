<?php

namespace Kareem\illuminate\Facilitate\Database\Filters;

use Illuminate\Support\Arr;

class FilterManager
{

    /**
     * Query Builder instance
     *
     * @var \Illuminate\Database\Query\Builder
     */
    public $query;


    /**
     * options to be filtered
     * 
     * @var array  
     */
    public $options = [];


    /**
     * columns used in filtering
     * 
     * @var array  
     */
    public $filterBy = [];


    public function __construct($query, $options, $filterBy)
    {
        $this->query = $query;
        $this->options = $options;
        $this->filterBy = $filterBy;
    }

    public function filter(array $filterObjects)
    {

    }

    public function collectToBeFilteredValues()
    {
        $result = [];

                /**
        * [
        *   '=' => ['id', 'status']
        *   '<' => ['x', 'y']
        *   ]
        *       


        *   final shape
        * [ 
        *   
        *    [
        *       'columns' => ['filteredColumns' => ['id'],
        *                      'value           =>  1],

        *                    ['filteredColumns' => ['status'],
        *                      'value           =>  active]    


        *       'operator' => '='     ]   

        *                                                       ]

        *   all of this final shape should be put inside the $requestedOptions array
        */

        foreach ($this->filterBy as $operator => $columns) {
            $toBeFilteredColumns = [];
            $options = [];

            foreach ($columns as $column) {

                if ($value = Arr::get($this->options, $column, null) !== null) {
                    $toBeFilteredColumns[] = [
                        'filteredColumn' => (array) $column,
                        'value'          => $value
                    ];
                    $options['operator'] ??= $operator;
                    $options['columns'] = $toBeFilteredColumns;
                } else {
                    return false;
                }

                
            }
            $result = $options;
        }

        return $result;
    }
}
