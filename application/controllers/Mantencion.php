<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mantencion extends CI_Controller {

  public function __construct()
  {
		parent::__construct();
    if ($this->session->userdata('logged_in')["cargo"][0] == 3 or $this->session->userdata('logged_in')["cargo"][0] == 4) {
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
    	$this->load->model('Inventario_Model','inventario',true);
  } else {
    redirect('/Login');
  }
  

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
			$usu=$_POST['new_usu'];
			$value=$this->usuario->findById($usu['USU_RUT']);
			if($value==null){
				$nuevousuario=$this->usuario->create($_POST['new_usu']);
				$nuevousuario->insert();
	    		$usersesion = $this->session->userdata('logged_in');
				$this->usuario->insertLogs(1,$usersesion['rut'],$usu['USU_RUT'],'hola');
				$this->session->set_flashdata('Habilitar', 'El Usuario se a agregado con exito');
			}else{
				$this->session->set_flashdata('Deshabilitar', 'El Usuario ya se encuentra registrado');
			}
			redirect('/Mantencion/usuarios');
		}else{
			echo "usuario no fue agregado";
		}
	}
	public function edit_usuario(){
		if(isset($_POST['new_usu'])){
			$id=$_POST['rut'];
			$this->usuario->update($id,$_POST['new_usu']);
			$usersesion = $this->session->userdata('logged_in');
			$this->usuario->insertLogs(2,$usersesion['rut'],$id,'$_POST[new_usu]');
			$this->session->set_flashdata('Habilitar', 'El Usuario se a editado con exito');
			redirect('/Mantencion/usuarios');
		}else{
			echo "usuario no fue agregado";
		}
	}

	public function eliminarusuario($id=null){
		$this->usuario->delete($id);
		$this->session->set_flashdata('Deshabilitar', 'Se Deshabilitó Correctamente el Usuario');
		redirect('/Mantencion/usuarios');
	}

	public function CambiarEstadoUSU($tipo, $id){
    if ($tipo == 0) {
      $this->session->set_flashdata('Deshabilitar', 'Se Deshabilitó Correctamente');
      $this->usuario->update($id, array('USU_ESTADO' => 0));
      $usersesion = $this->session->userdata('logged_in');
	  $this->usuario->insertLogs(4,$usersesion['rut'],$id,'$_POST[new_usu]');
      redirect('/Mantencion/usuarios');
    } elseif ($tipo == 1) {
      $this->session->set_flashdata('Habilitar', 'Se Habilitó Correctamente');
      $this->usuario->update($id, array('USU_ESTADO' => 1));
      $usersesion = $this->session->userdata('logged_in');
	  $this->usuario->insertLogs(3,$usersesion['rut'],$id,'$_POST[new_usu]');
      redirect('/Mantencion/usuarios');
    }
  	}
	//Fin Usuario*************************************************************************

	//Categoria***************************************************************************
	public function categorias(){
	  $datos['categoria'] = $this->categorias->findAll();
	  $this->layouthelper->LoadView("mantenedores/categorias", $datos, null);
	}

	public function findById_categorias(){
	  $id= $_POST['id'];
	  $newarray = null;
	  $value = $this->categorias->findById($id);
	  	$newarray = array(
					'CAT_ID' => $value->get("CAT_ID"),
					'CAT_NOMBRE' => $value->get("CAT_NOMBRE"),
					'CAT_DESC' => $value->get("CAT_DESC"),
					'CAT_CODIGO' => $value->get("CAT_CODIGO"),
					'CAT_ESTADO' => $value->get("CAT_ESTADO")
					);
	  $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($newarray));
	}

	public function new_cat(){
		if(isset($_POST['cat'])){
			$nuevo=$this->categorias->create($_POST['cat']);
			$nuevo->insert();
			$usersesion = $this->session->userdata('logged_in');
			$this->categorias->insertLogs(1,$usersesion['rut'],0,'$_POST[new_usu]');
			$this->session->set_flashdata('Habilitar', 'Se agregó Correctamente');
			redirect('/Mantencion/categorias');
		}else{
			echo "categorias no fue agregado";
		}
	}

  public function CambiarEstadoCAT($tipo, $id){
    if ($tipo == 0) {
      $this->session->set_flashdata('Deshabilitar', 'Se Deshabilitó Correctamente');
      $usersesion = $this->session->userdata('logged_in');
	  $this->categorias->insertLogs(4,$usersesion['rut'],$id,'$_POST[new_usu]');
      $this->categorias->update($id, array('CAT_ESTADO' => 0));
      redirect('/Mantencion/categorias');
    } elseif ($tipo == 1) {
      $this->session->set_flashdata('Habilitar', 'Se Habilitó Correctamente');
      $usersesion = $this->session->userdata('logged_in');
	  $this->categorias->insertLogs(3,$usersesion['rut'],$id,'$_POST[new_usu]');
      $this->categorias->update($id, array('CAT_ESTADO' => 1));
      redirect('/Mantencion/categorias');
    }
  }

	public function eliminarCategoria($ID){
	  $this->categorias->delete($ID);
	  redirect('/Mantencion/categorias');
	}

  public function edit_categoria(){
    if(isset($_POST['cat'])){
      $id=$_POST['id'];
      $this->categorias->update($id,$_POST['cat']);
      $usersesion = $this->session->userdata('logged_in');
	  $this->categorias->insertLogs(2,$usersesion['rut'],$id,'$_POST[new_usu]');
      $this->session->set_flashdata('Habilitar', 'Se editó Correctamente');
      redirect('/Mantencion/categorias');
    }else{
      echo "categorias no fue agregado";
    }
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

	public function new_producto($num){
		if(isset($_POST['producto'])){
			if(isset($_FILES['files'])){
			$data = $_FILES['files'];
			 $archivo = $this->copiarimg->__construct(htmlspecialchars($data['name']),htmlspecialchars($data['size']),htmlspecialchars($data['type']),htmlspecialchars($data['tmp_name']));
			/* if ($this->copiarimg->validate()) {*/
			 $nameimg = $this->copiarimg->upload();
			/* }*/
			if($data['size']>90112){
				$config['image_library'] = 'gd2';
				$config['source_image'] = FCPATH.'resources/images/Imagenes_Server/'.$nameimg;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width']         = 800;
				$config['height']       = 800;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
			}
			}
			$nuevopro=$this->productos->create($_POST['producto']);
			$nuevopro->insert($nameimg);
			$usersesion = $this->session->userdata('logged_in');
			$this->productos->insertLogs(1,$usersesion['rut'],0,'$_POST[new_usu]');
			$this->session->set_flashdata('Habilitar', 'Se agregó Correctamente');
			if($num==1){redirect('/Mantencion/productos');}
			else{redirect('/Gestion/ingreso');}
		}else{
			echo "productos no fue agregado";
		}
	}

	public function edit_producto(){
		if(isset($_POST['producto'])){
			$id=$_POST['id_pro'];
			$producto=$_POST['producto'];
			if(isset($_FILES['files'])){
				$data = $_FILES['files'];
				//htmlspecialchars($data['name']),htmlspecialchars($data['size']),htmlspecialchars($data['type']),htmlspecialchars($data['tmp_name'])
				 $archivo = $this->copiarimg->__construct(htmlspecialchars($data['name']),htmlspecialchars($data['size']),htmlspecialchars($data['type']),htmlspecialchars($data['tmp_name']));
				 /*if ($this->copiarimg->validate()) {*/
				 /*$nameimg*/
				 $producto['PROD_IMAGEN'] = $this->copiarimg->upload();
				 /*}*/
				 if($data['size']>90112){
					$config['image_library'] = 'gd2';
					$config['source_image'] = FCPATH.'resources/images/Imagenes_Server/'.$producto['PROD_IMAGEN'] ;
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width']         = 800;
					$config['height']       = 800;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
				}
			}
			if($producto['PROD_IMAGEN']==null){
				$product = $this->productos->findById($id);
				$producto['PROD_IMAGEN'] = $product->get('PROD_IMAGEN');
			}
			$nuevopro=$this->productos->update($id,$producto);
			$usersesion = $this->session->userdata('logged_in');
			$this->productos->insertLogs(2,$usersesion['rut'],$id,'$_POST[new_usu]');
			$this->session->set_flashdata('Habilitar', 'Se editó Correctamente');
			redirect('/Mantencion/productos');
		}else{
			echo "productos no fue agregado";
		}
	}

	public function eliminarproducto($ID){
	  $this->productos->delete($ID);
	  $this->session->set_flashdata('Alert', 'Se Deshabilitó Correctamente');
	  redirect('/Mantencion/productos');
	}

	public function CambiarEstadoPROD($tipo, $id){
	$producto = $this->productos->findById($id);
	$nameimg= $producto->get('PROD_IMAGEN');
    if ($tipo == 0) {
      $this->session->set_flashdata('Deshabilitar', 'Se Deshabilitó Correctamente');
      $this->productos->update($id, array('PROD_ESTADO' => 0),$nameimg);
      $usersesion = $this->session->userdata('logged_in');
	  $this->productos->insertLogs(4,$usersesion['rut'],$id,'$_POST[new_usu]');
      redirect('/Mantencion/productos');
    }
    if ($tipo == 1) {
      $this->session->set_flashdata('Habilitar', 'Se Habilitó Correctamente');
      $this->productos->update($id, array('PROD_ESTADO' => 1),$nameimg);
      $usersesion = $this->session->userdata('logged_in');
	  $this->productos->insertLogs(3,$usersesion['rut'],$id,'$_POST[new_usu]');
      redirect('/Mantencion/productos');
    }
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
      $this->session->set_flashdata('Habilitar', 'Se agregó Correctamente');
      redirect('/Mantencion/asignaturas');
    } else {
      echo "NO AGRAGADO";
    }
  }

  public function findByIdAsig(){
    $id= $_POST['id'];
    $newarray = null;
    $value = $this->asignatura->findById($id);
    $newarray = array(
    'ASIGNATURA_ID' => $value->get("ASIGNATURA_ID"),
    'ASIGNATURA_NOMBRE' => $value->get("ASIGNATURA_NOMBRE"),
    'ASIGNATURA_ESTADO' => $value->get("ASIGNATURA_ESTADO")
    );
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode($newarray));
  }

  public function EditAsig(){
    if(isset($_POST['asig'])){
      $id=$_POST['id'];
      $this->asignatura->update($id,$_POST['asig']);
      $this->session->set_flashdata('Habilitar', 'Se editó Correctamente');
      redirect('/Mantencion/asignaturas');
    }else{
      echo "asignatura no modificada";
    }
  }

  public function CambiarEstadoAsig($tipo, $id){
    if ($tipo == 1) {
      $this->session->set_flashdata('Alert', 'Se Deshabilitó Correctamente');
      $this->asignatura->update($id, array('ASIGNATURA_ESTADO' => 2));
      redirect('/Mantencion/asignaturas');
    } elseif ($tipo == 2) {
      $this->session->set_flashdata('Info', 'Se Habilitó Correctamente');
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
      $this->session->set_flashdata('Info', 'Se Agregó Correctamente');
      redirect('/Mantencion/motivos');
    } else {
      echo "NO AGRAGADO";
    }
  }

  public function CambiarEstado($tipo, $id){
    if ($tipo == 1) {
      $this->session->set_flashdata('Deshabilitar', 'Se Deshabilitó Correctamente');
      $this->motivo->update($id, array('MOT_ESTADO' => 2));
      redirect('/Mantencion/motivos');
    } elseif ($tipo == 2) {
      $this->session->set_flashdata('Habilitar', 'Se Habilitó Correctamente');
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

  public function findByIdMotivo(){
    $id= $_POST['id'];
    $newarray = null;
    $value = $this->motivo->findById($id);
    $newarray = array(
    'MOT_ID' => $value->get("MOT_ID"),
    'MOT_NOMBRE' => $value->get("MOT_NOMBRE"),
    'MOT_ESTADO' => $value->get("MOT_ESTADO"),
    'MOT_DIF' => $value->get("MOT_DIF"),
    );
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode($newarray));
  }

  public function updateMotivo(){
    if(isset($_POST['MOT'])){
      $id=$_POST['id'];
      $this->motivo->update($id,$_POST['MOT']);
      $this->session->set_flashdata('Habilitar', 'Se Actualizó Correctamente');
      redirect('/Mantencion/motivos');
    }else{
      echo "Motivo No Actualizado";
    }
  }
	//Fin Motivos***************************************************************************

	//Proveedores***************************************************************************
	public function proveedores(){
	  $datos['proveedor'] = $this->proveedores->findAll();
	  $this->layouthelper->LoadView("mantenedores/proveedores", $datos);
	}

  public function NuevoProveedor(){

    $this->form_validation->set_rules('PROV[PROV_RUT]', 'RUT', 'min_length[7]|max_length[8]|required');
    $this->form_validation->set_rules('PROV[PROV_DV]', 'DIGITO VERIFICADOR', 'exact_length[1]|alpha_numeric|required');
    $this->form_validation->set_rules('PROV[PROV_NOMBRE]', 'NOMBRE', 'required');
    $this->form_validation->set_rules('PROV[PROV_RSOCIAL]', 'RAZON SOCIAL', 'required');
    $this->form_validation->set_rules('PROV[PROV_ESTADO]', 'ESTADO', 'required');
    $this->form_validation->set_rules('PROV[PROV_TIPO]', 'TIPO', 'required');

    if ($this->form_validation->run() == FALSE) {
      $datos['proveedor'] = $this->proveedores->findAll();
  	  $this->layouthelper->LoadView("mantenedores/proveedores", $datos);
    } else {
    		if(isset($_POST['PROV'])){
    			$NuevoProveedor=$this->proveedores->create($_POST['PROV']);
    			$NuevoProveedor->insert();
    			$this->session->set_flashdata('Habilitar', 'Se agregó Correctamente');
    			redirect('/Mantencion/proveedores');
    		}else{
    			echo "usuario no fue agregado";
    		}
    }
  }

  public function findByIdProveedor(){
    $id= $_POST['id'];
    $newarray = null;
    $value = $this->proveedores->findById($id);
    $newarray = array(
    'PROV_RUT' => $value->get("PROV_RUT"),
    'PROV_DV' => $value->get("PROV_DV"),
    'PROV_NOMBRE' => $value->get("PROV_NOMBRE"),
    'PROV_RSOCIAL' => $value->get("PROV_RSOCIAL"),
    'PROV_ESTADO' => $value->get("PROV_ESTADO"),
    );
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode($newarray));
  }

  public function updateProveedor(){
    if(isset($_POST['PROV'])){
      $id=$_POST['id'];
      $this->proveedores->update($id,$_POST['PROV']);
      $this->session->set_flashdata('Habilitar', 'Se Agregó Correctamente');
      redirect('/Mantencion/proveedores');
    }else{
      echo "Proveedor No Actualizado";
    }
  }

  public function CambiarEstadoPROV($tipo, $id){
    if ($tipo == 1) {
      $this->session->set_flashdata('Deshabilitar', 'Se Deshabilitó Correctamente');
      $this->proveedores->update($id, array('PROV_ESTADO' => 2));
      redirect('/Mantencion/proveedores');
    } elseif ($tipo == 2) {
      $this->session->set_flashdata('Habilitar', 'Se Habilitó Correctamente');
      $this->proveedores->update($id, array('PROV_ESTADO' => 1));
      redirect('/Mantencion/proveedores');
    }
  }

	public function eliminarProveedor($RUT){
	  $this->proveedores->delete($RUT);
	  $this->session->set_flashdata('Habilitar', 'Se eliminó Correctamente');
	  redirect('/Mantencion/proveedores');
	}
	//Fin Proveedores***************************************************************************

	//Bajas***************************************************************************
	public function bajas(){
		$this->layouthelper->LoadView("mantenedores/bajas" , null);
	}
	//Fin Bajas***************************************************************************


/*nuevoooooooooooooooooooooooooo*/

	public function inventario(){
		$NuevoInventario = array();
		$inventario = $this->inventario->findAll();
	    foreach ($inventario as $key => $value) {
	        $NuevoInventario[] = array(
	        'INV_ID' => $value->get('INV_ID'),
	    	'INV_PROD_ID' => $value->get('INV_PROD_ID'),
			'INV_PROD_NOM' => $value->get('INV_PROD_NOM'),
			'INV_PROD_CANTIDAD'	=> $value->get('INV_PROD_CANTIDAD'),
			'INV_PROD_ESTADO'	=> $value->get('INV_PROD_ESTADO'),
			'INV_PROD_CODIGO' => $value->get('INV_PROD_CODIGO'),
			'INV_INGRESO_ID' => $value->get('INV_INGRESO_ID'),
			'INV_CATEGORIA_ID' => $this->categorias->findById($value->get('INV_CATEGORIA_ID')),
			'INV_TIPO_ID' => $this->tipoProducto->findById($value->get('INV_TIPO_ID')),
			'INV_FECHA' => $value->get('INV_FECHA'),
			'INV_IMAGEN' => $value->get('INV_IMAGEN'),
			'INV_ULTIMO_USUARIO' => $value->get('INV_ULTIMO_USUARIO'),
			'INV_ACTUAL_USUARIO' => $value->get('INV_ACTUAL_USUARIO')
	        );
	        $datos['inventario'] = $NuevoInventario;
	      }
	    $datos['tipos'] = $this->tipoProducto->findAll();
	    $datos['categorias'] = $this->categorias->findAllSelect();
		$this->layouthelper->LoadView("mantenedores/inventario", $datos, null);
	}

	public function inventarioById(){
		$id= $_POST['id'];
	 	$newarray = null;
	  	$inventario = $this->inventario->findById($id);
	  	$newarray = array(
	        'INV_ID' => $inventario->get('INV_ID'),
	    	'INV_PROD_ID' => $inventario->get('INV_PROD_ID'),
			'INV_PROD_NOM' => $inventario->get('INV_PROD_NOM'),
			'INV_PROD_CANTIDAD'	=> $inventario->get('INV_PROD_CANTIDAD'),
			'INV_PROD_ESTADO'	=> $inventario->get('INV_PROD_ESTADO'),
			'INV_PROD_CODIGO' => $inventario->get('INV_PROD_CODIGO'),
			'INV_INGRESO_ID' => $inventario->get('INV_INGRESO_ID'),
			'INV_CATEGORIA_ID' => $inventario->get('INV_CATEGORIA_ID'),
			'INV_TIPO_ID' => $inventario->get('INV_TIPO_ID'),
			'INV_FECHA' => $inventario->get('INV_FECHA'),
			'INV_IMAGEN' => $inventario->get('INV_IMAGEN'),
			'INV_ULTIMO_USUARIO' => $inventario->get('INV_ULTIMO_USUARIO'),
			'INV_ACTUAL_USUARIO' => $inventario->get('INV_ACTUAL_USUARIO')
	    );
	  $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($newarray));
	}

	public function edit_inventario(){
		if(isset($_POST['inventario'])){
			$id=$_POST['id'];
			if(isset($_FILES['files'])){
				$data = $_FILES['files'];
				 $archivo = $this->copiarimg->__construct(htmlspecialchars($data['name']),htmlspecialchars($data['size']),htmlspecialchars($data['type']),htmlspecialchars($data['tmp_name']));
				 $nameimg = $this->copiarimg->upload();
				 if($data['size']>90112){
					$config['image_library'] = 'gd2';
					$config['source_image'] = FCPATH.'resources/images/Imagenes_Server/'.$nameimg;
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width']         = 800;
					$config['height']       = 800;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
				}
			}
			if($nameimg==null){
				$producto = $this->inventario->findById($id);
				$nameimg= $producto->get('INV_IMAGEN');
			}
			$nuevopro=$this->inventario->update($id,$_POST['inventario'],$nameimg);
			$this->session->set_flashdata('Habilitar', 'Se editó Correctamente');
			redirect('/Mantencion/inventario');
		}else{
			echo "usuario no fue agregado";
		}
	}
}

/* End of file mantencion.php */
/* Location: ./application/controllers/mantencion.php */
