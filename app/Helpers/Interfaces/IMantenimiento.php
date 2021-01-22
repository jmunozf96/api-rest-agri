<?php 

namespace App\Helpers\Interfaces;

Interface IMantenimiento{
    public function all();
    public function save($data);
    public function update($data);
    public function delete($id);
}