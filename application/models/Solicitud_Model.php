<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud_Model extends CI_Model {

public function __construct()
{
parent::__construct();
}

private  $_columns  =  array(
'SOL_ID' => 0,
'SOL_USU_RUT' => 0,
'SOL_ASIG_ID' => 0,
'SOL_FECHA_INICIO' => '',
'SOL_FECHA_TERMINO' => '',
'SOL_NRO_GRUPOTRAB' => 0,
'SOL_OBSERVACION' => 0
);

public function get($attr){
  return $this->_columns[$attr];
}

public function create($row){
  $solicitud =  new Solicitud_Model();
  foreach ($row as $key => $value)
    {
      $solicitud->_columns[$key] = $value;
    }
  return $solicitud;
}

public function insert(){
$this->db->insert('solicitud',$this->_columns);
}

public function update($id, $data) {
  $solicitud = $this->db->get_where('solicitud',array('SOL_ID'=>$id));
  if($solicitud->num_rows() > 0){
    $this->db->where('SOL_ID', $id);
    return $this->db->update('solicitud', $data);
    }else{
  $data['SOL_ID'] = $id;
  return $this->db->insert('solicitud',$data);
  }
}

public function delete($id){
  $this->db->where('SOL_ID',$id);
  return $this->db->delete('solicitud');
}


public function findAll(){
  $result=array();
  $bit = null;
  $consulta = $this->db->get('solicitud');
    foreach ($consulta->result() as $row) {
    $result[] = $this->create($row);
  }
  return $result;
}

public function findById($id){
  $result=array();
  $bit = null;
  $this->db->where('SOL_ID',$id);
  $consulta = $this->db->get('solicitud');
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
