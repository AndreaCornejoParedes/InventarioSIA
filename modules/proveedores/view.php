<section class="content-header">
  <h1>
    <i class="fa fa-folder-o icon-title"></i> Datos de proveedores

    <a class="btn btn-primary btn-social pull-right" href="?module=form_proveedores&form=add" title="agregar" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Agregar
    </a>
  </h1>

</section>


<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php  
//Se definen las alertas
    if (empty($_GET['alert'])) {
      echo "";
    } 
  
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Exito!</h4>
             Nuevos datos de proveedores ha sido  almacenado correctamente.
            </div>";
    }

    elseif ($_GET['alert'] == 2) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Exito!</h4>
             Datos de la proveedores modificados correctamente.
            </div>";
    }

    elseif ($_GET['alert'] == 3) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Exito!</h4>
            Se eliminaron los datos del proveedores
            </div>";
    }
    //Se define la cabecera
    ?>

      <div class="box box-primary">
        <div class="box-body">
    
          <table id="dataTables1" class="table table-bordered table-striped table-hover">
      
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Codigo</th>
                <th class="center">Razon social / Nombre</th>
                <th class="center">RUC / DNI </th>
                <th class="center">Telefono</th>
                <th class="center">Email</th>
                <th class="center">Direccion</th>
                
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php  
            $no = 1;
            $query = mysqli_query($mysqli, "SELECT codigoprov,rsnomprov, rucdni ,telefono,email, direccion FROM proveedores 
                                            ORDER BY codigoprov DESC")
                                            or die('error: '.mysqli_error($mysqli));

            while ($data = mysqli_fetch_assoc($query)) { 
            
          //Se muestran los datos ademas de las acciones de editar y eliminar 
              echo "<tr>
                      <td width='30' class='center'>$no</td>
                      <td width='80' class='center'>$data[codigoprov]</td>
                      <td width='80' class='center'>$data[rsnomprov]</td>
                      
                      
                      <td width='80' class='center'>$data[rucdni]</td>
                      <td width='80'class='center'>$data[telefono]</td>
                      <td width='100'class='center'>$data[email]</td>
                      <td width='100' class='center'>$data[direccion]</td>
                      <td class='center' width='80'>
                        <div>
                          <a data-toggle='tooltip' data-placement='top' title='modificar' style='margin-right:5px' class='btn btn-primary btn-sm' href='?module=form_proveedores&form=edit&id=$data[codigoprov]'>
                              <i style='color:#fff' class='glyphicon glyphicon-edit'></i>
                          </a>";
            ?>
                          <a data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm" href="modules/proveedores/proses.php?act=delete&id=<?php echo $data['codigoprov'];?>" onclick="return confirm('¿Estas seguro de eliminar<?php echo ' ',$data['codigoprov'],' ',$data['rsnomprov'] ; ?> ?');">
                              <i style="color:#fff" class="glyphicon glyphicon-trash"></i>
                          </a>


                          
            <?php
              echo "    </div>
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