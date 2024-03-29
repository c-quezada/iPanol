<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h3>Reportes Stock Crítico</h3>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
      <div class="row">
          <div class="col-md-4">
          <form action="" method="post" class="form">
          <div class="form-group">
            <label>Tipo</label>
              <select placeholder="Seleccionar tipo de artículo..." id="tipo" name="tipo" class="select2" style="width: 100%">
                <option ></option>
              <?php foreach ($tipo as $key => $value): ?>
              <option value="<?= $value['TIPO_ID']; ?>"><?= $value['TIPO_NOMBRE'];  ?></option>
              <?php endforeach ?>
        </select>
          </div>
        </div>

               <div class="col-md-4">
          <label>Categorías</label>
             <div class="form-group">
                <select id="cat" name="cat" class="select2" style="width: 100%">
                <option value="0">Todas las categorías</option>
                   <?php foreach ($categoria as $key => $value): ?>
                    <?php if ($value->get("CAT_ESTADO") == 1): ?>
                       <option value=" <?= $value->get('CAT_ID')  ?>"><?= $value->get('CAT_NOMBRE')  ?>
                       </option>
                    <?php endif ?>
                  <?php endforeach ?>
                </select>
              </div>
        </div> 
                <div class="col-md-4">
          <label>Adquisición</label>
             <div class="form-group">
                <select id="adq" name="adq" class="select2" style="width: 100%">
                <option value="0">Todas las adquisiciones</option>  
                       <option value="1">Compra</option>
                       <option value="2">Donación</option>
                </select>
              </div>
        </div>
       <div class="col-md-3" class="pull-right">
               <label>Acción</label>
               <input type="submit"  class="btn btn-block btn-danger" name="filtro" value="Filtro">
            </div>
       </div>
       </form>
       
      <div class="box-body">
        <div class="box-body">
          <?php if (isset($buscar) > 0): ?>
            <div class="col-sm-offset-9 col-md-3">    
               <form id="pdf" action="Pdfcritico" method="post" target="_blank">
                  <input id="recuperartipo" type="hidden" name="recuperartipo" 
                         value="<?= @$buscartipo ?>">
                  <input id="recuperarcat" type="hidden" name="recuperarcat" 
                         value="<?= @$buscarcat?>">
                  <input id="recuperaradq" type="hidden" name="recuperaradq"
                         value="<?= @$buscaradq  ?>">
                  
                  <button name="verpdf" type="submit" class="pull-right btn btn-primary btn-block  "  data-skin="skin-blue"><i class="fa fa-pdf"></i> Exportar PDF</button>              
                </br>
                </br>
                </form>
                <form id="excel" action="excelcritico" method="post" target="_blank">
                <meta charset="utf-8">
                  <input id="recuperartipo" type="hidden" name="recuperartipo" 
                         value="<?= @$buscartipo ?>">
                  <input id="recuperarcat" type="hidden" name="recuperarcat" 
                         value="<?= @$buscarcat?>">
                  <input id="recuperaradq" type="hidden" name="recuperaradq"
                        value="<?= @$buscaradq  ?>">
                  
                  <button name="verexcel" type="submit" class="pull-right btn btn-primary btn-block  "  data-skin="skin-blue"><i class="fa fa-pdf"></i> Exportar EXCEL</button>
                                         
                </br>
                </br>
                </form>
            </div>
            </div>
            <div class="table-responsive">
            <table id="example2" class="datatable table-bordered table-hover">    
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Nombre producto</th>
                  <th>Tipo</th>
                  <th>Categoría</th>
                  <th>Tipo ingreso</th>
                  <th>Stock óptimo</th>
                  <th>Stock crítico</th>
                  <th>Prioridad</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($buscar as $key => $value): ?>
                <tr>
                <td><?= $value['INV_PROD_CODIGO']; ?></td>
                <td><?= $value['INV_PROD_NOM']; ?></td>
                <td><?= $value['TIPO_NOMBRE']; ?></td>
                <td><?= $value['CAT_NOMBRE']; ?></td>

               <?php if ($value['ING_TIPO_INGRESO'] == 1): ?>
                  <td>Compra</td>
                  <?php elseif($value['ING_TIPO_INGRESO'] == 2): ?> 
                  <td>Donación</td> 
                  <?php else: ?>
                   <td>No Definido</td>
                <?php endif ?>


                <td><?= $value['PROD_STOCK_OPTIMO']; ?></td>
                <td><?= $value['PROD_STOCK_CRITICO']; ?></td>
                <td><?= @$value['PROD_PRIORIDAD']; ?></td>   
                <?php if (@$value['INV_PROD_CODIGO'] !=0): ?>
                  <?php if ($value['TIPO_ID'] == 1): ?>
                <td> <?= @$value['CANTIDAD']; ?></td>
                  <?php endif ?>
                <?php if ($value['TIPO_ID'] == 2): ?>
                  <td><?= $value['INV_PROD_CANTIDAD']; ?></td>
                  <?php endif ?>
                  <?php endif ?>
                  <?php if ($value['INV_PROD_CODIGO'] == 0): ?>

                  <td>0</td>
                  </tr>
                  <?php endif ?>
              <?php endforeach ?>
              
              </tbody>
            </table>
            </div>
          <?php endif ?>
          </div>
      </div>
       
    </div>
  </section>
  <!-- /.content -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

  <?php if(isset($buscartipo) && isset($buscarcat)): ?>
    $("#cat").val('<?=$buscarcat?>').trigger('change');
    $("#tipo").val('<?=$buscartipo?>').trigger('change');
    $("#adq").val('<?=$buscaradq?>').trigger('change');
  <?php endif; ?>
  $('#pdf').submit(function(){
     $(this).append("<input name='tipo' type='hidden' value='"+$("#recuperartipo").val()+"'  >");
     $(this).append("<input name='cat' type='hidden' value='"+$("#recuperarcat").val()+"'  >");
     $(this).append("<input name='adq' type='hidden' value='"+$("#recuperaradq").val()+"'  >");
      console.log($("#tipo").val());
      console.log($("#cat").val()); 
      console.log($("#adq").val());
     return ;
    });
     $('#excel').submit(function(){
     $(this).append("<input name='tipo' type='hidden' value='"+$("#recuperartipo").val()+"'  >");
     $(this).append("<input name='cat' type='hidden' value='"+$("#recuperarcat").val()+"'  >");
     $(this).append("<input name='adq' type='hidden' value='"+$("#recuperaradq").val()+"'  >");
    console.log($("#tipo").val());
      console.log($("#cat").val());
     //return false;
  });
  });

</script>
</div>