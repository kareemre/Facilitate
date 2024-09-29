<?php

namespace Kareem\illuminate\Facilitate\Database\Filters;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

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

    /**
     * filtering column with the applied operator and value 
     * 
     * @param array $filterObjects
     * 
     * @return void
     */
    public function filter(array $filterObjects)
    {
        $setUpOptions = $this->collectToBeFilteredValues();

        foreach ($filterObjects as $filterObject) {

            $filterInstance = App::make($filterObject);

            $filterInstance->setQuery($this->query);

            $filtersList = $filterInstance->filterMap();

            foreach ($setUpOptions as $option) {
                $filterOperator = $option['operator'];

                if (! array_key_exists($option['operator'], $filtersList)) continue;

                $filterFunction = $filtersList[$option['operator']];

                foreach ($option['columns'] as $column) {
                    if (empty($column['filteredColumns'])) continue;

                    call_user_func_array([$filterInstance, $filterFunction], [$column['filteredColumns'], $column['value'], $option['operator']]);
                }
            }

        }

    }

    /**
     * set up options coming from list method of the repo manager
     * 
     * @return array|bool
     */
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
