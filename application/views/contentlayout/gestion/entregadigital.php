<!-- Content Wrapper. Contains page content -->
  <div style="font-size: 10px" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <!-- /.box-header -->
      <div class="box-body">
    <!-- Small boxes (Stat box) -->

    <div class="panel panel-default">
        <div class="row panel-body">
        <div class="col-md-12">
            <!-- /.box-header -->
            <div class="table-responsive box-body">
              <table class="datatabledigital table table-bordered table-hover">
                <thead>
                  <tr bgcolor="orange">
                    <th>#</th>
                    <th class="col-md-2">Estado</th>
                    <th>Solicitante</th>
                    <th>RUT</th>
                    <th>Fecha pedido</th>
                    <th>Fecha entrega</th>
                    <th>Detalle</th>
                  </tr>
                </thead>
                <tbody>
              <!--  SOL_ID,SOL_USU_RUT,SOL_ASIG_ID,SOL_FECHA_INICIO,SOL_FECHA_TERMINO,SOL_NRO_GRUPOTRAB,SOL_OBSERVACION-->
                <?php foreach ($solicitudes as $key => $value): ?>
                  <tr>
                    <td><?=$value->get("SOL_ID")?></td>
                    <td>
                    <?php if ($value->get("SOL_ESTADO") == 1): ?>
                      <div class="alert alert-success">
                        Solicitado Catálogo
                      </div>
                    <?php endif?>
                    <?php if ($value->get("SOL_ESTADO") == 7): ?>
                      <div class="alert alert-info">
                        Parcialmente Entregado
                      </div>
                    <?php endif?>
                    </td>
                    <td><?=$value->get("USU_NOMBRES") . " " . $value->get("USU_APELLIDOS") . " (" . $value->get("CARGO_NOMBRE") . ")"?></td>
                    <td><?=$value->get("USU_RUT") . "-" . $value->get("USU_DV")?></td>
                    <td><?=$value->get("SOL_FECHA_INICIO")?></td>
                    <td class="bg-danger "><?=$value->get("SOL_FECHA_TERMINO")?></td>
                    <td class="text-center">
                      <a iddetalle="<?=$value->get("SOL_ID")?>" class="obtdetalle btn btn-xs btn-success fa fa-eye"></a>
                      <a idsolicitud="<?=$value->get("SOL_ID")?>"  class="rechazarsolicitud btn btn-xs btn-danger fa fa-power-off"></a>
                    </td>
                  </tr>
                <?php endforeach?>
                </tbody>
              </table>
            </div>
          <!-- /.box-body -->
        </div>

        </div>
      </div>

                <div class="row">
                <div class="col-md-4">
                  <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Detalle de la solicitud N° <strong id="setidsol"></strong></h3>
                    </div>
                    <div class="panel-body">
                    <div class="col-md-12">
                    <div class="box-body table-responsive">
                      <table style="font-size: 10px" class="table table-bordered table-hover">
                        <thead>
                          <tr bgcolor="CCCCCC">
                            <th>#</th>
                            <th>Producto / insumo</th>
                            <th>Cantidad</th>
                            <th>Posición</th>
                          </tr>
                        </thead>
                        <tbody id="detallesol">
                        </tbody>
                      </table>
                    </div>
                    </div>
                    <div class="col-md-12">
                      <div class="box-body">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators" id="carousel-indicators">
                          </ol>
                          <div class="carousel-inner" id="carousel-inner">
                          </div>
                          <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="fa fa-angle-left"></span>
                          </a>
                          <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="fa fa-angle-right"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>

                  </div>


                  <div class="col-md-5">

                    <div class="panel panel-success">
                      <div class="panel-heading">
                          <h3 class="panel-title">Asignación de insumos</h3>
                      </div>
                      <div class="panel-body">
                        <div class="box-body table-responsive">
                      <table style="font-size: 10px" id="dinamicajax" class="table table-bordered table-hover">

                      </table>
                    </div>
                      </div>
                    </div>

                  </div>


                  <div class="col-md-3">

                  <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Asignación final</h3>
                     </div>
                     <div class="panel-body">
                        <table style="font-size: 9px" id="resulasignacion"  class="table table-responsive table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Producto/Insumo</th>
                      <th>Cantidad</th>
                      <th>ID Prod.</th>
                    </tr>
                    </thead>
                     <tfoot>
                        <tr class="bg-success">
                          <td>Total asignados</td>
                          <td></td>
                          <td id="total"></td>
                          <td></td>
                        </tr>
                      </tfoot>
                    <tbody id="asignacion">

                    </tbody>
                      </table>
                     </div>
                   </div>

                </div>
              </div>
              <br>
              <div class="row">
              <div class="col-md-6">
              <button type="button" id="asignarcerrar" class="generarprestamo notify2 btn btn-block btn-success btn-flat">Asignar y Cerrar</button>
              </div>
                <div class="col-md-6">
                  <button type="button" id="asignarparcial" class="generarprestamo notify1 btn btn-block btn-success btn-flat">Asignar</button>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.row (main row) -->
    <!-- /.content-wrapper -->
    </section>
    </div>
    </div>

    <?php function MISJAVASCRIPTPERSONALIZADO()
{?>
    <script type="text/javascript" charset="utf-8">
    $(function() {
      $(".datatabledigital").dataTable({
                    lengthMenu: [5,10, 20, 50, 100],
                    cache: false,
                    responsive: true,
                    "pagingType": "simple",
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bInfo": true,
                    "bAutoWidth": false,
                    "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    }
                });

    });

    $(".notify1").hover(function() {
      $(".notify1").notify("Esta asignación es restrictiva y parcial, debe asignar por lo menos un producto que este en el detalle de la solicitud",{ position:"top" ,className: 'info'});
    }, function() {
      /* Stuff to do when the mouse leaves the element */
    });

    $(".notify2").hover(function() {
      $(".notify2").notify("Esta asignación permite asignar productos que se estime conveniente, los que no existan en stock o no quiera asignar serán omitidos.",{ position:"top" ,className: 'info'});
    }, function() {
      /* Stuff to do when the mouse leaves the element */
    });


    var tabla;
    var total = 0;
    var idsol = 0;
    var asignaciones = new Array();
    var productosid = new Array();
    productosid.push(0);
    tabla = $('#dinamicajax').DataTable({
                lengthMenu: [5,10, 20, 50, 100],
                "pagingType": "simple",
                "responsive": true,
                "paging": true,
                "cache": false,
                "processing": true,
                "lengthChange": true,
                "deferRender": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "ajax": {
                    "url": "<?=site_url('/gestion/get_inv_by_productos_id')?>",
                    "type": "POST",
                            "beforeSend": function () {
                            $('#carga_modal').modal('show');
                        },
                    "data": function (argument) {
                     // console.log(productosid);
                      return {'productosid': productosid};
                    },
                    "dataSrc": function ( json ) {
                      $('#carga_modal').modal('hide');
                        return json;
                    }
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                "columns": [
                    { title: "ID",
                        className: "text-sm hidden" },
                    { title: "Código",
                        className: "text-center"},
                    { title: "Stock",
                        className: "text-red text-center"},
                    { title: "Nombre",
                        className: "text-green text-center"},
                    { title: "Cantidad",
                        className: "text-center"},
                    { title: "Acción"}]
            });

     $(document).on('click','.obtdetalle',function(argument) {
      limpiar();
      idsol = $(this).attr("iddetalle");
      $("#setidsol").text(idsol);
      $.ajax({
                    method: "POST",
                    url: "<?=site_url('/gestion/get_detalle_solicitud')?>",
                    datatype: "json",
                    data:  {"idsolicitud": idsol},
                    success: function(response){
                        var i = 0;
                        response.forEach(function(rr) {
                        var obj = JSON.parse(rr);
                        if (i == 0) {
                          $("#carousel-indicators").append('<li data-target="#carousel-example-generic" data-slide-to="'+i+'" class="active"></li>');
                          $("#carousel-inner").append(' <div class="item active"><img style="width: 100%;height: 250px" src="'+obj.IMAGEN+'" alt="First slide"> <div class="carousel-caption"><h3 style="color: yellow">'+obj.PROD_NOMBRE+'</h3></div></div>');
                          i++;
                        }else{
                          $("#carousel-indicators").append('<li data-target="#carousel-example-generic" data-slide-to="'+i+'" class=""></li>');
                          $("#carousel-inner").append(' <div class="item"><img style="width: 100%;height: 250px" src="'+obj.IMAGEN+'" alt="First slide"> <div class="carousel-caption"><h3 style="color: yellow">'+obj.PROD_NOMBRE+'</h3></div></div>');
                          i++;
                        }
                        $("#detallesol").append('<tr><td>'+obj.ID+'</td><td>'+obj.PROD_NOMBRE+'</td><td>'+obj.CANTIDAD+'</td><td>'+obj.POSICION+'</td></tr>')
                        productosid.push(obj.PROD_ID);
                    });
                    $('#dinamicajax').DataTable().ajax.reload();
                    }
           })
    })

    $(document).on('click', '.rechazarsolicitud', function(event) {
      idsol = $(this).attr("idsolicitud");
      var r = confirm("¿ Esta seguro/a de rechazar esta solicitud ?");
        if (r == true) {
             $.ajax({
                    method: "POST",
                    url: "<?=site_url('/gestion/rechazar_solicitud')?>",
                    datatype: "json",
                    data:  {"idsolicitud": idsol},
                    success: function(response){
                      if (response.estado) {
                        $.notify(response.mensaje, "success");
                      }
                      location.reload();
                    }
           })
        }
    });

    $(document).on('click', '.ADDinv', function(){
    var id = $(this).attr("id");
    var stockactual = $(this).attr("cant");
    var nom = $(this).attr("nom");
    var tipo = $(this).attr("tipo");
    var prodid = $(this).attr("prodid");
    if(asignaciones.indexOf(id) == -1){
            if (tipo == 1) {
              $("#asignacion").append('<tr><td>'+id+'</td><td>'+nom+'</td><td>'+stockactual+'</td><td>'+prodid+'</td><td><a style="cursor:pointer;" id="DEL'+id+'" cant="'+stockactual+'" class="conlabel fa fa-trash"></a></td></tr>');
              asignaciones.push(id);
              total= parseInt(total)+parseInt(stockactual);
              $.notify("Se han añadido "+stockactual+" "+nom+"(#"+id+") ", "success");
            }else if(tipo == 2){
               cant = $("#INPUT"+id).val();
               if (parseInt(cant) <= parseInt(stockactual) && parseInt(cant) != 0) {
                    $("#asignacion").append('<tr><td>'+id+'</td><td>'+nom+'</td><td>'+cant+'</td><td>'+prodid+'</td><td><a style="cursor:pointer;" id="DEL'+id+'" cant="'+cant+'" class="conlabel fa fa-trash"></a></td></tr>');
                  asignaciones.push(id);
                  total= parseInt(total)+parseInt(cant);
                  $.notify("Se han añadido "+cant+" "+nom+"(#"+id+") ", "success");
               }else{
                $.notify("La cantidad no debe exceder el stock actual, Usted esta ingresando actualmente: "+cant, "warn");
               }
            }
            $("#total").text(total);
      }else{
        $.notify("El producto o insumo que desea agregar, ya está agregado", "warn");
        return false;
      }
   })


   $(".generarprestamo").click(function (argument) {
    var observaciones = prompt('Ingrese una obeservación para poder asignar productos a esta solicitud:','');
    if (observaciones === null) {
      $.notify("Ha cancelado la opción de ingresar una observación", "warn");
        return; //break out of the function early
    }
    var arrayasig = new Array();
    var parcialocerrar = $(this).attr("id");

    if ($("#asignacion").text() != "") {
        if (observaciones != "") {

        $("#resulasignacion tbody tr").each(function (index)
        {
            var idinv, nombreinv, cantidadinv, idprod;
            $(this).children("td").each(function (index2)
            {
                switch (index2)
                {
                    case 0: idinv = $(this).text();
                            break;
                    case 1: nombreinv = $(this).text();
                            break;
                    case 2: cantidadinv = $(this).text();
                            break;
                    case 3: idprod = $(this).text();
                            break;
                }
                $(this).css("background-color", "#ECF8E0");
            })
            arrayasig.push({'idinv': idinv,'cantidadinv': cantidadinv,'nombreinv' : nombreinv,'idprod' : idprod});
        })

         $.ajax({
                    method: "POST",
                    url: "<?=site_url('/gestion/insert_entrega_digital')?>",
                    datatype: "json",
                    data:  {"asignaciones": arrayasig,"observaciones": observaciones,"idsolicitud": idsol ,"parcialocerrar" : parcialocerrar},
                    beforeSend: function () {
                            $('#carga_modal').modal('show');
                        },
                    success: function(response){
                      $('#carga_modal').modal('hide');
                        if (response.resultado) {
                          $.notify(response.mensaje, "success");
                          var win = window.open('', '_blank');
                          win.location.href = response.path;
                          location.reload();
                        } else{
                          $.notify(response.mensaje, "warn");
                        }
                    }
           })

         }else{
          $.notify("Debe ingresar una observación", "warn");
          return false;
       }

    }else{
      if(parcialocerrar == "asignarparcial"){
        $.notify("Debe agregar asignación de inventario para esta solicitud", "warn");//never inside
      }else if(parcialocerrar == "asignarcerrar"){
        if (observaciones === null) {
      $.notify("Ha cancelado la opción de ingresar una observación", "warn");
        return; //break out of the function early
    }
      if (observaciones != "") {

       $("#resulasignacion tbody tr").each(function (index)
        {
            var idinv, nombreinv, cantidadinv, idprod;
            $(this).children("td").each(function (index2)
            {
                switch (index2)
                {
                    case 0: idinv = $(this).text();
                            break;
                    case 1: nombreinv = $(this).text();
                            break;
                    case 2: cantidadinv = $(this).text();
                            break;
                    case 3: idprod = $(this).text();
                            break;
                }
                $(this).css("background-color", "#ECF8E0");
            })
            arrayasig.push({'idinv': idinv,'cantidadinv': cantidadinv,'nombreinv' : nombreinv,'idprod' : idprod});
        })

         $.ajax({
                    method: "POST",
                    url: "<?=site_url('/gestion/insert_entrega_digital')?>",
                    datatype: "json",
                    data:  {"asignaciones": arrayasig,"observaciones": observaciones,"idsolicitud": idsol ,"parcialocerrar" : parcialocerrar},
                    beforeSend: function () {
                            $('#carga_modal').modal('show');
                        },
                    success: function(response){
                      $('#carga_modal').modal('hide');
                        if (response.resultado) {
                          alert(response.mensaje);
                          var win = window.open('', '_blank');
                          win.location.href = response.path;
                          location.reload();
                        } else{
                          $.notify(response.mensaje, "warn");
                        }
                    }
           })


        }else{
          $.notify("Debe ingresar una observación", "warn");
          return false;
        }

      }
    }


   });


   $(document).on('click','.conlabel', function(){
          var id = $(this).attr("id");
          var cant = $(this).attr("cant");
          total = parseInt(total)-parseInt(cant);
          id = id.replace('DEL', "");
          $(this).parent().parent().remove();
          var index = asignaciones.indexOf(id);
            if (index > -1) {
               asignaciones.splice(index, 1);
               $.notify("Se ha quitado de su lista se asignaciones el P/I #"+id, "error");
            }
          $("#total").text(total);
        });

   function limpiar(){
    idsol = 0;
    total = 0;
    $("#asignacion").text("");
    asignaciones = new Array();
    productosid = new Array();
    $("#detallesol").text('');
    $("#setidsol").text("");
    $("#total").text("");
    $("#carousel-inner").text("");
    $("#carousel-indicators").text("");
   }

    </script>
    <?php }?>
