<?php

namespace Kareem\illuminate\Facilitate\Repository\contracts;

interface RepositoryInterface
{


    /**
     * Create new record
     * 
     * @param  \Illuminate\Http\Request|array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data);


    /**
     * Update a specific record
     * 
     * @param  int id
     * @param  \Illuminate\Http\Request|array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(int $id, $data);


    /**
     * Delete a specific record
     * 
     * @param  int id
     * @return bool
     */
    public function delete(int $id);


    /**
     * List of records
     * 
     * @param  array options
     * @return \Illuminate\Support\Collection
     */
    public function list(array $option);


    /**
     * Get a specific record with full details
     * 
     * @param  int id
     * @return mixed
     */
    public function get(int $id);
    

    /**
     * Determine whether the given value exists 
     * 
     * @param  mixed    $value
     * @param  string   $column
     * @return bool
     */
    public function has($value, string $column);
}
