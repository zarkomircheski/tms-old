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
        return $this->retrieve($columns);
    }

    public function get($id, array $columns = [])
    {
        return $this->getBy(['id' => $id], $columns);
    }

    public function getBy(array $selectColumns, array $retrieveColumns = [])
    {
        $query = $this->model->query();
        foreach ($selectColumns as $column => $value) {
            $query->where($column, $value);
        }
        $this->data = $query->get();
        return $this->retrieve($retrieveColumns);
    }

    protected function retrieve(array $columns = [])
    {
        $data = $this->data->toArray();
        $returnData = [];

        foreach($data as $row)
        {
            $returnData[] = $this->retrieveSingle($row, $columns);
        }

        if(count($returnData)  == 1)
            return $returnData[0];
        return $returnData;
    }

    protected function retrieveSingle($row, $columns)
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