<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mantencion extends CI_Controller {

  public function __construct()
  {
		parent::__construct();
		$this->layouthelper->SetMaster('layout');
		$this->load->library('CopiarImg','copiarimg',false);
		$this->load->model('Cargo_Model','cargo', true);
		$this->load->model('Usuario_Model','usuario', true);
		$this->load->model('Carrera_Model','carrera', true);
		$this->load->model('Categoria_Model', 'categorias', true);
		$this->load->model('Proveedor_Model', 'proveedores', true);
		$this->load->model('Producto_Model', 'productos', true);
		$this->load->model('TipoProd_Model', 'tipoProducto', true);
    $this->load->model('Motivo_Model', 'motivo', true);
    $this->load->model('Asignatura_Model', 'asignatura', true);
  }

	//Usuarios***************************************************************************
	public function usuarios(){
		$newarray= array();
		$usuarios = $this->usuario->findAll();
		foreach ($usuarios as $key => $value) {
			$newarray[] = array(
					'USU_RUT' => $value->get("USU_RUT"),
					'USU_DV' => $value->get("USU_DV"),
					'USU_NOMBRES' => $value->get("USU_NOMBRES"),
					'USU_APELLIDOS' => $value->get("USU_APELLIDOS"),
					'USU_CARGO_ID' => $this->cargo->findById($value->get("USU_CARGO_ID")),
					'USU_CARRERA_ID' => $this->carrera->findById($value->get("USU_CARRERA_ID")),
					'USU_EMAIL' => $value->get("USU_EMAIL"),
					'USU_TELEFONO1' => $value->get("USU_TELEFONO1"),
					'USU_TELEFONO2' => $value->get("USU_TELEFONO2"),
					'USU_CLAVE' => $value->get("USU_CLAVE"),
					'USU_ESTADO' => $value->get("USU_ESTADO")
					);

		}

		$data['usuario']= $newarray;
		$data['carrera']=$this->carrera->findAll();
		$data['cargo']=$this->cargo->findAll();
		$this->layouthelper->LoadView("mantenedores/usuarios" ,$data, false);
	}

	public function findById_usuario(){
	  $id= $_POST['id'];
	  $newarray = null;
	  $value = $this->usuario->findById($id);
	  	$newarray = array(
					'USU_RUT' => $value->get("USU_RUT"),
					'USU_DV' => $value->get("USU_DV"),
					'USU_NOMBRES' => $value->get("USU_NOMBRES"),
					'USU_APELLIDOS' => $value->get("USU_APELLIDOS"),
					'USU_CARGO_ID' => $value->get("USU_CARGO_ID"),
					'USU_CARRERA_ID' => $value->get("USU_CARRERA_ID"),
					'USU_EMAIL' => $value->get("USU_EMAIL"),
					'USU_TELEFONO1' => $value->get("USU_TELEFONO1"),
					'USU_TELEFONO2' => $value->get("USU_TELEFONO2"),
					'USU_CLAVE' => $value->get("USU_CLAVE"),
					'USU_ESTADO' => $value->get("USU_ESTADO")
					);
	  $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($newarray));
	}

	public function new_usuario(){
		if(isset($_POST['new_usu'])){
			$nuevousuario=$this->usuario->create($_POST['new_usu']);
			$nuevousuario->insert();
			redirect('/Mantencion/usuarios');
		}else{
			echo "usuario no fue agregado";
		}
	}
	public function edit_usuario(){
		if(isset($_POST['new_usu'])){
			$id=$_POST['rut'];
			$this->usuario->update($id,$_POST['new_usu']);
			redirect('/Mantencion/usuarios');
		}else{
			echo "usuario no fue agregado";
		}
	}

	public function eliminarusuario($id=null){
		$this->usuario->delete($id);
		redirect('/Mantencion/usuarios');
	}
	//Fin Usuario*************************************************************************

	//Categoria***************************************************************************
	public function categorias(){
	  $datos['categoria'] = $this->categorias->findAll();
	  $this->layouthelper->LoadView("mantenedores/categorias", $datos, null);
	}

	public function new_cat(){
		if(isset($_POST['cat'])){
			$nuevo=$this->categorias->create($_POST['cat']);
			$nuevo->insert();
			redirect('/Mantencion/categorias');
		}else{
			echo "usuario no fue agregado";
		}
	}

	public function eliminarCategoria($ID){
	  $this->categorias->delete($ID);
	  redirect('/Mantencion/categorias');
	}

	public function editarCategoria($ID){

	}
	//Fin Categoria***************************************************************************

	//Productos***************************************************************************
	public function productos(){
	  $NuevoProducto = array();
	  $productos = $this->productos->findAll();
	  foreach ($productos as $key => $value) {
	    $NuevoProducto[] = array(
	      'PROD_ID' => $value->get('PROD_ID'),
	      'PROD_NOMBRE' => $value->get('PROD_NOMBRE'),
	      'PROD_STOCK_TOTAL' => $value->get('PROD_STOCK_TOTAL'),
	      'PROD_STOCK_CRITICO' => $value->get('PROD_STOCK_CRITICO'),
	      'PROD_CAT_ID' => $this->categorias->findById($value->get('PROD_CAT_ID')),
	      'PROD_TIPOPROD_ID' => $this->tipoProducto->findById($value->get('PROD_TIPOPROD_ID')),
	      'PROD_POSICION' => $value->get('PROD_POSICION'),
	      'PROD_PRIORIDAD' => $value->get('PROD_PRIORIDAD'),
	      'PROD_STOCK_OPTIMO' => $value->get('PROD_STOCK_OPTIMO'),
	      'PROD_DIAS_ANTIC' => $value->get('PROD_DIAS_ANTIC'),
	      'PROD_IMAGEN' => $value->get('PROD_IMAGEN'),
	      'PROD_ESTADO' => $value->get('PROD_ESTADO')
	    );
	    $datos['productos'] = $NuevoProducto;
	  }
	  $datos['categorias'] = $this->categorias->findAllSelect();
	  $datos['tipos'] = $this->tipoProducto->findAll();
	  $this->layouthelper->LoadView("mantenedores/productos", $datos, null);
	}

	public function findById_productos(){
	  $id= $_POST['id'];
	  $newarray = null;
	  $producto = $this->productos->findById($id);
	  	$newarray = array(
	      'PROD_ID' => $producto->get('PROD_ID'),
	      'PROD_NOMBRE' => $producto->get('PROD_NOMBRE'),
	      'PROD_STOCK_TOTAL' => $producto->get('PROD_STOCK_TOTAL'),
	      'PROD_STOCK_CRITICO' => $producto->get('PROD_STOCK_CRITICO'),
	      'PROD_CAT_ID' => $producto->get('PROD_CAT_ID'),
	      'PROD_TIPOPROD_ID' => $producto->get('PROD_TIPOPROD_ID'),
	      'PROD_POSICION' => $producto->get('PROD_POSICION'),
	      'PROD_PRIORIDAD' => $producto->get('PROD_PRIORIDAD'),
	      'PROD_STOCK_OPTIMO' => $producto->get('PROD_STOCK_OPTIMO'),
	      'PROD_DIAS_ANTIC' => $producto->get('PROD_DIAS_ANTIC'),
	      'PROD_IMAGEN' => $producto->get('PROD_IMAGEN'),
	      'PROD_ESTADO' => $producto->get('PROD_ESTADO')
	    );
	  $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($newarray));
	}

	public function new_producto(){
		if(isset($_POST['producto'])){
			if(isset($_FILES['files'])){
			$data = $_FILES['files'];
			//htmlspecialchars($data['name']),htmlspecialchars($data['size']),htmlspecialchars($data['type']),htmlspecialchars($data['tmp_name'])
			 $archivo = $this->copiarimg->__construct(htmlspecialchars($data['name']),htmlspecialchars($data['size']),htmlspecialchars($data['type']),htmlspecialchars($data['tmp_name']));
			 if ($this->copiarimg->validate()) {
			 $nameimg = $this->copiarimg->upload();
			 }
			}
			$nuevopro=$this->productos->create($_POST['producto']);
			$nuevopro->insert($nameimg);
			redirect('/Mantencion/productos');
		}else{
			echo "usuario no fue agregado";
		}
	}

	public function edit_producto(){
		if(isset($_POST['producto'])){
			$id=$_POST['id_pro'];
			if(isset($_FILES['files'])){
			$data = $_FILES['files'];
			//htmlspecialchars($data['name']),htmlspecialchars($data['size']),htmlspecialchars($data['type']),htmlspecialchars($data['tmp_name'])
			 $archivo = $this->copiarimg->__construct(htmlspecialchars($data['name']),htmlspecialchars($data['size']),htmlspecialchars($data['type']),htmlspecialchars($data['tmp_name']));
			 if ($this->copiarimg->validate()) {
			 $nameimg = $this->copiarimg->upload();
			 }
			}
			$nuevopro=$this->productos->update($id,$_POST['producto']);
			redirect('/Mantencion/productos');
		}else{
			echo "usuario no fue agregado";
		}
	}

	public function eliminarproducto($ID){
	  $this->productos->delete($ID);
	  redirect('/Mantencion/productos');
	}
	//Fin Productos***************************************************************************

	//Asignatura***************************************************************************
	public function asignaturas(){
    $datos['asignatura'] = $this->asignatura->findAll();
		$this->layouthelper->LoadView("mantenedores/asignaturas", $datos, null);
	}

  public function NuevaAsignatura(){
    if (isset($_POST['asignatura'])) {
      $NuevaAsignatura = $this->asignatura->create($_POST['asignatura']);
      $NuevaAsignatura->insert();
      redirect('/Mantencion/asignaturas');
    } else {
      echo "NO AGRAGADO";
    }
  }

  public function CambiarEstadoAsig($tipo, $id){
    if ($tipo == 1) {
      $this->session->set_flashdata('Alert', 'Se Deshabilito Correctamente');
      $this->asignatura->update($id, array('ASIGNATURA_ESTADO' => 2));
      redirect('/Mantencion/asignaturas');
    } elseif ($tipo == 2) {
      $this->session->set_flashdata('Info', 'Se Habilito Correctamente');
      $this->asignatura->update($id, array('ASIGNATURA_ESTADO' => 1));
      redirect('/Mantencion/asignaturas');
    }
  }
	//Fin Asignatura***************************************************************************

	//Motivos***************************************************************************
	public function motivos(){
    $datos['motivos'] = $this->motivo->findAll();
		$this->layouthelper->LoadView("mantenedores/motivos", $datos, null);
	}

  public function NuevoMotivo(){
    if (isset($_POST['motivo'])) {
      $NuevoMotivo = $this->motivo->create($_POST['motivo']);
      $NuevoMotivo->insert();
      redirect('/Mantencion/motivos');
    } else {
      echo "NO AGRAGADO";
    }
  }

  public function CambiarEstado($tipo, $id){
    if ($tipo == 1) {
      $this->session->set_flashdata('Deshabilitar', 'Se Deshabilito Correctamente');
      $this->motivo->update($id, array('MOT_ESTADO' => 2));
      redirect('/Mantencion/motivos');
    } elseif ($tipo == 2) {
      $this->session->set_flashdata('Habilitar', 'Se Habilito Correctamente');
      $this->motivo->update($id, array('MOT_ESTADO' => 1));
      redirect('/Mantencion/motivos');
    } elseif ($tipo == 3) {
      $this->session->set_flashdata('Observacion', 'Cambió a Motivo de Observacion');
      $this->motivo->update($id, array('MOT_DIF' => 2));
      redirect('/Mantencion/motivos');
    } elseif ($tipo == 4) {
      $this->session->set_flashdata('Baja', 'Cambió a Motivo de Baja');
      $this->motivo->update($id, array('MOT_DIF' => 1));
      redirect('/Mantencion/motivos');
    }
  }
	//Fin Motivos***************************************************************************

	//Proveedores***************************************************************************
	public function proveedores(){
	  $datos['proveedor'] = $this->proveedores->findAll();
	  $this->layouthelper->LoadView("mantenedores/proveedores", $datos,	 null);
	}

	public function eliminarProveedor($RUT){
	  $this->proveedores->delete($RUT);
	  redirect('/Mantencion/proveedores');
	}
	//Fin Proveedores***************************************************************************

	//Bajas***************************************************************************
	public function bajas(){
		$this->layouthelper->LoadView("mantenedores/bajas" , null);
	}
	//Fin Bajas***************************************************************************

}

/* End of file mantencion.php */
/* Location: ./application/controllers/mantencion.php */
