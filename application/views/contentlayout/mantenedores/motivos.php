<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-sm-6">
          <h3>
            Mantenedor | Motivo
          </h3>
        </div>
        <div class="col-sm-6"><br>

          <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#newCategoria" >Agregar nuevo motivo</button>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="datatable table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>NOMBRE</th>
                  <th>ACCIONES</th>
                  <th>ORIGEN</th>
                  <th>EDITAR</th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach ($motivos as $key => $value): ?>
                    <tr>
                      <td><?= $value->get('MOT_ID'); ?></td>
                      <td><?= $value->get('MOT_NOMBRE'); ?></td>
                      <?php if ($value->get('MOT_ESTADO') == 1): ?>
                        <td><a href="<?= site_url('/Mantencion/CambiarEstado/1/');?><?=$value->get('MOT_ID');?>" class="btn btn-danger btn-block">Deshabilitar</a></td>
                      <?php else: ?>
                        <td><a href="<?= site_url('/Mantencion/CambiarEstado/2/');?><?=$value->get('MOT_ID');?>" class="btn btn-info btn-block">Habilitar</a></td>
                      <?php endif; ?>
                      <?php if ($value->get('MOT_DIF') == 1): ?>
                        <td><a href="<?= site_url('/Mantencion/CambiarEstado/3/');?><?=$value->get('MOT_ID');?>" class="btn btn-warning btn-block">Baja</a></td>
                      <?php else: ?>
                        <td><a href="<?= site_url('/Mantencion/CambiarEstado/4/');?><?=$value->get('MOT_ID');?>" class="btn btn-success btn-block">Observación</a></td>
                      <?php endif; ?>
                      <td><button id="<?= $value->get('MOT_ID'); ?>" type="button" class="editar btn btn-success btn-block" data-toggle="modal" data-target="#myEdit"><i class="fa fa-edit"></i></button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!--modalMotivoNUEVO-->
  <!--modalMotivoNUEVO-->
    <div class="modal fade bs-example-modal-lg" id="newCategoria" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-tittle">Nuevo Motivo</h4>
            <div class="modal-body">
              <div class="box">
                <div class="row">
                  <form class="form-horizontal" action="<?= site_url('Mantencion/NuevoMotivo') ?>" method="post">
                    <div class="box-body">
                      <div class="form-group">
                        <label class="col-sm-2 control-label">NOMBRE</label>

                        <div class="col-md-9">
                          <input name="motivo[MOT_NOMBRE]" type="text" class="col-md-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">ESTADO</label>
                        <div class="col-md-9">
                          <select placeholder="Seleccionar estado..." class="form-control select2"  name="motivo[MOT_ESTADO]" style="width: 100%;">
                            <option></option>
                              <option value="1">ACTIVO</option>
                              <option value="2">ELIMINADO</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">ORIGEN</label>
                        <div class="col-md-9">
                          <select placeholder="Seleccionar origen..." class="form-control select2" name="motivo[MOT_DIF]" style="width: 100%;">
                            <option></option>
                            <option value="1">BAJA</option>
                            <option value="2">OBSERVACIÓN</option>
                          </select>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <button type="submit" class="btn btn-default col-md-12" data-dismiss="modal">Cancelar</button>
                        </div>
                        <div class="col-sm-6">
                          <button type="submit" class="btn btn-danger col-md-12">Agregar</button>
                        </div>
                      </div>
                    <!-- /.box-footer -->
                  </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!--modalMotivoNUEVO-->
  <!--modalMotivoNUEVO-->

  <!--modalMotivo-->
  <!--modalMotivoNUEVO-->
    <div class="modal fade bs-example-modal-lg" id="myEdit" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-tittle">Editar motivo</h4>
            <div class="modal-body">
              <div class="box">
                <div class="row">
                  <form action="<?= site_url('/Mantencion/updateMotivo'); ?>" method="post" class="form-horizontal">
                    <input id="id" name="id" type="number" style="visibility: hidden;">
                    <div class="box-body">
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Nombre</label>

                        <div class="col-md-9">
                          <input id="nombre" name="MOT[MOT_NOMBRE]" type="text" class="col-md-12">
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-default col-md-12" data-dismiss="modal">Cancelar</button>
                  </div>
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-danger col-md-12">Agregar</button>
                  </div>
                </div>
              <!-- /.box-footer -->
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    <?php function MISJAVASCRIPTPERSONALIZADO(){  ?>
    <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

      $('.editar').click(function(){
          limpiar();
          var id=$(this).attr("id");
          $.ajax({
            type:"POST",
            dataType:"json",
            data: {"id": id},
            url:"<?=site_url('/Mantencion/findByIdMotivo')?>",
            success: function(data){
              $("#id").val(data.MOT_ID);
              $("#nombre").val(data.MOT_NOMBRE);
              console.log(data);
            }
          });
        });
    });

    function limpiar(){
        $("#id").val("");
        $("#nombre").val("");
      }
    </script>
    <?php } ?>
