<?php

namespace Kareem\illuminate\Facilitate\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Kareem\illuminate\Facilitate\Events\Dispatcher;
use Kareem\illuminate\Facilitate\Repository\contracts\RepositoryInterface;

abstract class RepositoryManager implements RepositoryInterface
{
    /**
     * Repository name 
     * @const string
     */
    const NAME = '';

    /**
     * TABLE name
     * @const string
     */
    const TABLE = '';


    /**
     * TABLE alias
     * @const string
     */
    const TABLE_ALIAS = '';


    /**
     * Model name
     * 
     * @const string
     */
    const MODEL = '';


    /**
     * Resource class 
     * 
     * @const string
     */
    const RESOURCE = '';
    
    /**
     * filters class
     * @const array
     */
    const FILTERs = [];

    /**
     * Filter by columns used with `list` method only
     * 
     * @const array
     */
    const FILTER_BY = [];

    /**
     * Event name to be triggered

     * 
     * @const string
     */
    const EVENT = '';

    /**
     * Event list that will be triggered 
     * 
     * @const array
     */
    const EVENTS_LIST = [
        'listing' => 'onListing',
        'filtering' => 'filters',
        'list' => 'onList',
        'creating' => 'onCreating',
        'create' => 'onCreate',
        'saving' => 'onSaving',
        'save' => 'onSave',
        'updating' => 'onUpdating',
        'update' => 'onUpdate',
        'deleting' => 'onDeleting',
        'delete' => 'onDelete',
    ];
    
    /**
     * This property will has the final table name that will be used
     * i.e if the TABLE_ALIAS is not empty, then this property will be the value of the TABLE_ALIAS
     * otherwise it will be the value of the TABLE constant
     *
     * @var string
     */
    protected $table;

    /**
     * The base event name that will be used
     *
     * @var string
     */
    protected $eventName;

    /**
     * Request Object
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * dispatcher Object
     *
     * @var \Kareem\Illuminate\Facilitate\Events\Dispatcher
     */
    protected $dispatcher;

    /**
     * Options list
     *
     * @param array
     */
    protected $options = [];

    /**
     * Query Builder Object
     *
     * @var \Illuminate\Database\Query\Builder
     */
    protected $query;


    /**
     * Select class Object
     *
     * @var \Kareem\Illuminate\Facilitate\Repository\Select
     */
    protected $select;


    public function __construct(Request $request, Dispatcher $dispatcher)
    {
        $this->request = $request;
        $this->dispatcher = $dispatcher;
        $this->eventName = static::EVENT ?: static::NAME;
        $this->registerEvents();   
    }


    protected function registerEvents()
    {
        if (! $this->eventName) return;

        foreach (static::EVENTS_LIST as $eventName => $methodCallback) {
            if (method_exists($this, $methodCallback)) {
                $this->dispatcher->subscribe("{$this->eventName}.$eventName", static::class . '@' . $methodCallback);
            }
        }
    }

    /**
     * @{inheritDoc}
     */
    public function list(array $options)
    {
        $this->setOptions($options);

        $this->query = $this->getQuery();

        $this->table = $this->TableName();

        $this->select();

        $filterManger = new FilterManager($this->query, $options, static::FILTER_BY);




    }


    protected function setOptions(array $options)
    {
        $this->options = $options;

        $selectColumns = (array) $this->getOption($this->options);

        $this->select = new Select($selectColumns);
    }


    protected function getOption(array $options, $default = null)
    {
        return Arr::get($this->options, 'select', $default);
    }


    /**
     * Get instance of query handler
     *
     * @return mixed
     */
    public function getQuery()
    {
        return static::MODEL::query();
    }

    /**
     * Manage Selected Columns
     *
     * @return void
     */
    abstract protected function select();

    /**
     * Get the table name that will be used in the rest of the query like select, where...etc
     * 
     * @return string
     */
    protected function TableName(): string
    {
        return static::TABLE_ALIAS ?: static::TABLE;
    }


    /**
     * @{inheritDoc}
     */
    public function create($data)
    {

    }

    /**
     * @{inheritDoc}
     */
    public function delete(int $id)
    {

    }

     /**
     * @{inheritDoc}
     */
    public function update(int $id, $data)
    {

    }


    /**
     * @{inheritDoc}
     */
    public function get(int $id)
    {

    }

    /**
     * @{inheritDoc}
     */
    public function has($value, string $column)
    {

    }
}
