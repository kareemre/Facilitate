<?php

namespace Kareem\illuminate\Facilitate\Repository;

use Illuminate\Http\Request;
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
     *  TABLE name
     * @const string
     */
    const TABLE = '';


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
     * Event name to be triggered
     * If set to empty, then it will be the class model name
     * 
     * @const string
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
     * Events Object
     *
     * @var \Kareem\Illuminate\Facilitate\Events\Dispatcher
     */
    protected $dispatcher;

    public function __construct(Request $request, Dispatcher $dispatcher)
    {

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
    public function list(array $option)
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
