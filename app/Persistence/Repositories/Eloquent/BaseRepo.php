<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 07.09.2015
 * Time: 20:46
 */

namespace App\Persistence\Repositories\Eloquent;


use App\Persistence\Interfaces\BaseRepositoryInterface;
use App\Persistence\ORM\Eloquent\System\Tenant;

class BaseRepo implements BaseRepositoryInterface {

    protected $model = null;
    protected $data = [];

    public function all(array $columns = [])
    {
        $this->data = $this->model->all();
        return $this->_retrieve($columns, false);
    }

    public function get($id, array $columns = [])
    {
        return $this->_getBy(['id' => $id], $columns, false);
    }
    
    public function getFirst($id, array $columns = [])
    {
        return $this->_getBy(['id' => $id], $columns, true);
    }

    public function getBy(array $selectColumns, array $retrieveColumns = [])
    {
        return $this->_getBy($selectColumns, $retrieveColumns, false);
    }
    
    public function getFirstBy(array $selectColumns, array $retrieveColumns = [])
    {
        return $this->_getBy($selectColumns, $retrieveColumns, true);
    }

    protected function _getBy(array $selectColumns, array $retrieveColumns = [], $first)
    {
        $query = $this->model->query();
        foreach ($selectColumns as $column => $value) {
            $query->where($column, $value);
        }
        if($first == true)
            $this->data = $query->first();
        else
            $this->data = $query->get();
        
        return $this->_retrieve($retrieveColumns, $first);
    }

    protected function _retrieve(array $columns = [], $first)
    {
        $data = $this->data->toArray();
        $returnData = [];

        if($first == true)
        {
            return $this->_retrieveSingle($data, $columns);
        }
        else
        {
            foreach($data as $row)
            {
                $returnData[] = $this->_retrieveSingle($row, $columns);
            }

            return $returnData;
        }

    }

    protected function _retrieveSingle($row, $columns)
    {
        if(count($columns))
            $row = array_intersect_key($row, array_flip($columns));
        return $row;
    }

    public function save(array $data)
    {
        unset($data['_token']);
        foreach($data as $column => $value)
            $this->model->{$column} = $value;

        $this->model->save();
        return $this->model->id;
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}