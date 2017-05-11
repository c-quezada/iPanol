<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permiso_Model extends CI_Model {

public function __construct()
{
parent::__construct();
}

private  $_columns  =  array(
'PERMISO_PERFIL_ID' => 0,
'PERMISO_USU_RUT' => 0
);

function get($attr){
  return $this->_columns[$attr];
}

public function create($row){
  $permiso =  new Permiso_Model();
  foreach ($row as $key => $value)
    {
      $permiso->_columns[$key] = $value;
    }
  return $permiso;
}

function insert(){
$this->db->insert('PERMISO',$this->_columns);
}

function update($id, $data) {
  $permiso = $this->db->get_where('PERMISO',array('PERMISO_PERFIL_ID'=>$id));
  if($permiso->num_rows() > 0){
    $this->db->where('PERMISO_PERFIL_ID', $id);
    return $this->db->update('PERMISO', $data);
    }else{
  $data['PERMISO_PERFIL_ID'] = $id;
  return $this->db->insert('PERMISO',$data);
  }
}

function delete($id){
  $this->db->where('PERMISO_PERFIL_ID',$id);
  return $this->db->delete('PERMISO');
}


function findAll(){
  $result=array();
  $bit = null;
  $consulta = $this->db->get('PERMISO');
    foreach ($consulta->result() as $row) {
    $result[] = $this->create($row);
  }
  return $result;
}

function findById($id){
  $result=array();
  $bit = null;
  $this->db->where('PERMISO_PERFIL_ID',$id);
  $consulta = $this->db->get('PERMISO');
  if($consulta->num_rows() > 0){
    foreach ($consulta->result() as $row) {
    $result[] = $this->create($row);
    }
  }else{
    $result[] = $this->create($this->_columns);
  }
    return $result;
  }
}
