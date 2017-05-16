<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AsigCar_Model extends CI_Model {

public function __construct()
{
parent::__construct();
}

private  $_columns  =  array(
'ASIGCAR_ASIG_ID' => 0,
'ASIGCAR_CARRERA_ID' => 0
);

public function get($attr){
  return $this->_columns[$attr];
}

public function create($row){
  $asig =  new AsigCar_Model();
  foreach ($row as $key => $value)
    {
      $asig->_columns[$key] = $value;
    }
  return $asig;
}

public function insert(){
$this->db->insert('ASIGCARRERA',$this->_columns);
}

public function update($id, $data) {
  $asig = $this->db->get_where('ASIGCARRERA',array('ASIGCAR_ASIG_ID'=>$id));
  if($asig->num_rows() > 0){
    $this->db->where('ASIGCAR_ASIG_ID', $id);
    return $this->db->update('ASIGCARRERA', $data);
    }else{
  $data['ASIGCAR_ASIG_ID'] = $id;
  return $this->db->insert('ASIGCARRERA',$data);
  }
}

public function delete($id){
  $this->db->where('ASIGCAR_ASIG_ID',$id);
  return $this->db->delete('ASIGCARRERA');
}


public function findAll(){
  $result=array();
  $bit = null;
  $consulta = $this->db->get('ASIGCARRERA');
    foreach ($consulta->result() as $row) {
    $result[] = $this->create($row);
  }
  return $result;
}

public function findById($id){
  $result=array();
  $bit = null;
  $this->db->where('ASIGCAR_ASIG_ID',$id);
  $consulta = $this->db->get('ASIGCARRERA');
  if($consulta->num_rows() > 0){
    foreach ($consulta->result() as $row) {
    $result[] = $this->create($row);
    }
  }else{
    $result[] = $this->create($this->_columns);
  }
    return $result;
  }

  public function setColumns ($row = null){
    foreach ($row as $key => $value) {
      $this->columns[$key] = $value;
      }
    }
}
