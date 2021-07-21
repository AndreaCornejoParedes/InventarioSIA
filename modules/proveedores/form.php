 <?php  

if ($_GET['form']=='add') { ?> 

  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Agregar Proveedor
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=start"><i class="fa fa-home"></i> Inicio </a></li>
      <li><a href="?module=proveedores"> Proveedores </a></li>
      <li class="active"> Más </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start Formulario para insertar proveedor-->
          <form role="form" class="form-horizontal" action="modules/proveedores/proses.php?act=insert" method="POST">
            <div class="box-body">
              <?php  
          // Se autogenera el codigo sumando 1 al ultimo
          $query_id = mysqli_query($mysqli, "SELECT RIGHT(codigoprov,10) as codigoprov FROM proveedores
                                                ORDER BY codigoprov DESC LIMIT 1")
                                                or die('error '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
            
                  $data_id = mysqli_fetch_assoc($query_id);
                  $codigoprov    = $data_id['codigoprov']+1;
              } else {
                  $codigoprov = 1;
              }


              $buat_id   = str_pad($codigoprov, 10, "0", STR_PAD_LEFT);
              $codigoprov = "P$buat_id";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Codigo de Proveedor</label>
                <div class="col-sm-5">
                <input type="text" class="form-control" name="codigoprov" value="<?php echo $codigoprov; ?>" readonly required>
                </div>
              </div>
<!-- Se pide el DNI RUC --> 
              <div class="form-group">
                <label class="col-sm-2 control-label">DNI/RUC</label>
                <div class="col-sm-5">
                <input type="text" class="form-control" name="rucdniprov" id="rucdniprov" autocomplete="off" required>
                </div>
              </div>
<!-- Se pide el nombre o razon social --> 
              <div class="form-group" >
                <label class="col-sm-2 control-label">Nombre / Razon Social</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nomrazonsocial_pro" id="nomrazonsocial_pro"  autocomplete="off"  required>
                </div>
              </div>
<!-- Se pide el telefono --> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Telefono</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="telefonopro" id="telefonopro" autocomplete="off"  required>
                </div>
              </div>
<!-- Se pide el email --> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="email" id="email" autocomplete="off"  required>
                </div>
              </div>
<!-- Se pide la direccion --> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Direccion</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="direpro"  id="direpro" autocomplete="off"  required>
                </div>
              </div>
            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">
                  <a href="?module=proveedores" class="btn btn-default btn-reset">Cancelar</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}

elseif ($_GET['form']=='edit') { 
  //Formulario para editar proveedor, primero consultamos codigo
  if (isset($_GET['id'])) {

      $query = mysqli_query($mysqli, "SELECT codigoprov,email,rsnomprov,rucdni,telefono,direccion FROM proveedores  WHERE codigoprov='$_GET[id]'") 
                                      or die('error: '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>

  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Modificar Proveedor
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=start"><i class="fa fa-home"></i> Inicio </a></li>
      <li><a href="?module=proveedores"> proveedores </a></li>
      <li class="active"> Modificar </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/proveedores/proses.php?act=update" method="POST">
            <div class="box-body">
              <!--Se muestra el codigo --> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Codigo</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="codigoprov" value="<?php echo $data['codigoprov']; ?>" readonly required>
                </div>
              </div>
           <!--Se muestran los otros datos a editar -->  
              <div class="form-group">
                <label class="col-sm-2 control-label">DNI/RUC</label>
                <div class="col-sm-5">
                <input type="text" class="form-control" name="rucdniprov" value="<?php echo $data['rucdni']; ?>" required>
                </div>
              </div>


              <div class="form-group" >
                <label class="col-sm-2 control-label">Nombre / Razon Social</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="nomrazonsocial_pro" name="nomrazonsocial_pro" value="<?php echo $data['rsnomprov']; ?>" required>
                  </div>
                </div>
            

              <div class="form-group">
                <label class="col-sm-2 control-label">Telefono</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="telefonopro" id="telefonopro" value="<?php echo $data['telefono']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="email" id="email" value="<?php echo $data['email']; ?>"   required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Direccion</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="direpro"  id="direpro" value="<?php echo $data['direccion']; ?>" required>
                  </div>
                </div>
              
              

              
            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">
                  <a href="?module=proveedores" class="btn btn-default btn-reset">Cancelar</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
?>