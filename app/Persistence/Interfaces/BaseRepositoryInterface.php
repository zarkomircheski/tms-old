<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 07.09.2015
 * Time: 20:43
 */

namespace App\Persistence\Interfaces;


Interface BaseRepositoryInterface {

    public function get($id, array $columns = []);

    public function save(array $data);

    public function delete($id);
}