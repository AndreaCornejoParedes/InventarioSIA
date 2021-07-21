

<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Registro de prendas

    <a class="btn btn-primary btn-social pull-right" href="?module=form_clothes_transaction&form=add" title="Agregar" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Entradas
    </a>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php  
//Se establecen las alertas
    if (empty($_GET['alert'])) {
      echo "";
    } 

    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Exito!</h4>
              Datos de la transaccion han sido registrado correctamente.
            </div>";
    }
    ?>
<!-- Se establece la cabecera de la table--> 
      <div class="box box-primary">
        <div class="box-body">
        
          <table id="dataTables1" class="table table-bordered table-striped table-hover">
           
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Codigo de Transación</th>
                <th class="center">Fecha / Hora</th>
                <th class="center">Codigo prenda</th>
                <th class="center">Documento Proveedor</th>
				        <th class="center">Tipo</th>
                <th class="center">Cantidad</th>
                <th class="center">Proveedor</th>
                <th class="center">Accion</th>
              </tr>
            </thead>
         
            <tbody>
            <?php  
            $no = 1;
//Se realiza la consulta a la base de datos y se muestran los datos        
            $query = mysqli_query($mysqli, "SELECT a.tipo_transaccion, a.codigo_transaccion,a.proveedor,a.fecha,a.codigo,a.numero,b.codigo,c.nombremar,d.nombresec,a.documentoid
                                            FROM transaccion_prendas as a 
                                            INNER JOIN prendas as b ON a.codigo=b.codigo 
                                            INNER JOIN marcas as c ON b.marca=c.codigomar 
                                            INNER JOIN secciones as d ON b.seccion=d.codigosec
                                            INNER JOIN categorias as e ON b.categoria=e.codigocat
                                            
                                            ORDER BY codigo_transaccion DESC")
                                            or die('error '.mysqli_error($mysqli));

           
            while ($data = mysqli_fetch_assoc($query)) { 
              $fecha         = $data['fecha'];
              $exp             = explode('-',$fecha);
              $fecha2   = $exp[2]."-".$exp[1]."-".$exp[0];

             
              echo "<tr>
              <td width='30' class='center'>$no</td>
              <td width='100' class='center'>$data[codigo_transaccion]</td>
              <td width='80' class='center'>$fecha</td>
              <td width='80' class='center'>$data[codigo]</td>
              <td width='100'class='center'>$data[documentoid]</td>
    <td width='80' class='center'>$data[tipo_transaccion]</td>
              <td width='100' class='center'>$data[numero]</td>
              <td width='80' class='center'>$data[proveedor]</td>
              <td class='center' width='80'>
              
              <div>
        <a data-toggle='tooltip' data-placement='top' title='Visualizar Parte Entrada' style='margin-right:5px' class='btn btn-primary btn-sm' href='modules/stock_inventory/print.php?id=$data[codigo_transaccion]'>
            <i style='color:#fff' class='glyphicon glyphicon-eye-open'></i>
        </a>
                     
            
                      </div>
                      </td>

                    </tr>";
              $no++;
            }

            ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      
    </div><!--/.col -->
  </div>   <!-- /.row -->
  
</section><!-- /.content