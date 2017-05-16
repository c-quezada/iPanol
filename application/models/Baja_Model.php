<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Baja_Model extends CI_Model {

public function __construct()
{
parent::__construct();
}

private  $_columns  =  array(
'BAJA_ID' => 0,
'BAJA_MOTIVO_ID' => 0,
'BAJA_DESC' => '',
'BAJA_INV_ID'	=> 0,
'BAJA_FECHA' => '',
'BAJA_USU_RUT' => 0
);

public function get($attr){
  return $this->_columns[$attr];
}

public function create($row){
  $baja =  new Baja_Model();
  foreach ($row as $key => $value)
    {
      $baja->_columns[$key] = $value;
    }
  return $baja;
}

public function insert(){
$this->db->insert('baja',$this->_columns);
}

public function update($id, $data) {
  $baja = $this->db->get_where('baja',array('BAJA_ID'=>$id));
  if($baja->num_rows() > 0){
    $this->db->where('BAJA_ID', $id);
    return $this->db->update('baja', $data);
    }else{
  $data['BAJA_ID'] = $id;
  return $this->db->insert('baja',$data);
  }
}

public function delete($id){
  $this->db->where('BAJA_ID',$id);
  return $this->db->delete('baja');
}


public function findAll(){
  $result=array();
  $bit = null;
  $consulta = $this->db->get('baja');
    foreach ($consulta->result() as $row) {
    $result[] = $this->create($row);
  }
  return $result;
}

public function findById($id){
  $result=array();
  $bit = null;
  $this->db->where('BAJA_ID',$id);
  $consulta = $this->db->get('baja');
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
