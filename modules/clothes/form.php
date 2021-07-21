 <?php  
//Formulario correspondiente a add
if ($_GET['form']=='add') { ?> 

  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Agregar Prenda
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=start"><i class="fa fa-home"></i> Inicio </a></li>
      <li><a href="?module=clothes"> Prendas </a></li>
      <li class="active"> Más </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <!-- Se genera el codigo de la prenda sumando uno a la ultima prenda-->
          <form role="form" class="form-horizontal" action="modules/clothes/proses.php?act=insert" method="POST">
            <div class="box-body">
              <?php  
          
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(codigo,6) as codigo FROM prendas
                                                ORDER BY codigo DESC LIMIT 1")
                                                or die('error '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
            
                  $data_id = mysqli_fetch_assoc($query_id);
                  $codigo    = $data_id['codigo']+1;
              } else {
                  $codigo = 1;
              }


              $buat_id   = str_pad($codigo, 6, "0", STR_PAD_LEFT);
              $codigo = "B$buat_id";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Codigo</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>" readonly required>
                </div>
              </div>
 <!-- Se pregunta el atributo de Marca en un select con los datos de la tabla marca-->
              <div class="form-group">
                <label class="col-sm-2 control-label">Marca</label>
                <div class="col-sm-5">
                <select class="chosen-select" name="marca" data-placeholder="-- Seleccionar --" autocomplete="off" required>
                  <?php
                     
                     $formcate = mysqli_query($mysqli, "SELECT * FROM `marcas`")
                                           or die('error '.mysqli_error($mysqli));
                   ?>
                   <option value=""></option>
<!-- Se toma en cuenta como valor el codigo ya que es lo que inscribiremos en la tabla prenda-->
                   <?php 
         
                
                     foreach ($formcate as $opciones):?>
                      <option value=<?php echo $opciones ['codigomar']?>><?php echo $opciones['codigomar'] ," | ", $opciones['nombremar'] ?></option>
                   <?php endforeach ?>
                 </select>
                </div>
              </div>
 <!-- Se pregunta el precio de compra-->
              <div class="form-group">
                <label class="col-sm-2 control-label">Precio de Compra</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">s/.</span>
                    <input type="text" class="form-control" id="precio_compra" name="pcompra" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required>
                  </div>
                </div>
              </div>
 <!-- Se pregunta el precio de venta-->
              <div class="form-group">
                <label class="col-sm-2 control-label">Precio de Venta</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">s/.</span>
                    <input type="text" class="form-control" id="precio_venta" name="pventa" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required>
                  </div>
                </div>
              </div>
<!-- Se pregunta el atributo de Seccion en un select con los datos de la tabla seccion-->
              <div class="form-group">
                <label class="col-sm-2 control-label">Seccion</label>
                <div class="col-sm-5">
                <select class="chosen-select" name="seccion" data-placeholder="-- Seleccionar --" autocomplete="off" required>
                  <?php
                     
                     $formcate = mysqli_query($mysqli, "SELECT * FROM `secciones`")
                                           or die('error '.mysqli_error($mysqli));

                   ?>
                   <option value=""></option>
<!-- Se toma en cuenta como valor el codigo ya que es lo que inscribiremos en la tabla prenda-->
                   <?php 
         
                     foreach ($formcate as $opciones):?>
                      <option value=<?php echo $opciones ['codigosec']?>><?php echo $opciones['codigosec'] ," | ", $opciones['nombresec'] ?></option>
                   <?php endforeach ?>
                 </select>
                </div>
              </div>
<!-- Se pregunta el atributo de Categoria en un select con los datos de la tabla categoria-->
              <div class="form-group">
                <label class="col-sm-2 control-label">Categoria</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="categoria" data-placeholder="-- Seleccionar --" autocomplete="off" required>
                    <?php
                     
                      $formcate = mysqli_query($mysqli, "SELECT * FROM `categorias`")
                                            or die('error '.mysqli_error($mysqli));
                    ?>
                    <option value=""></option>
    <!-- Se toma en cuenta como valor el codigo ya que es lo que inscribiremos en la tabla prenda-->
                    <?php 
          
                      foreach ($formcate as $opciones):?>
                       <option value=<?php echo $opciones ['codigocat']?>><?php echo $opciones['codigocat'] ," | ", $opciones['nombrecat'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
            </div><!-- /.box body -->
<!-- Se guarda la informacion lo que nos llevara a la inscripcion de los datos tomados en la base de datos-->
            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">
                  <a href="?module=clothes" class="btn btn-default btn-reset">Cancelar</a>
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
//Formulario correspondiente a edit
elseif ($_GET['form']=='edit') { 
  if (isset($_GET['id'])) {

      $query = mysqli_query($mysqli, "SELECT a.codigo,a.marca,b.nombremar,a.precio_compra,a.precio_venta,a.seccion,c.nombresec,a.categoria,d.nombrecat FROM prendas as a 
      INNER JOIN marcas as b ON a.marca=b.codigomar
      INNER JOIN secciones as c ON a.seccion=c.codigosec
      INNER JOIN categorias as d ON a.categoria=d.codigocat WHERE codigo='$_GET[id]'") 
                                      or die('error: '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>

  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Modificar Prenda
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=start"><i class="fa fa-home"></i> Inicio </a></li>
      <li><a href="?module=clothes"> prendas </a></li>
      <li class="active"> Modificar </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/clothes/proses.php?act=update" method="POST">
            <div class="box-body">
            <!-- Mostramos los valores que ya estaban almacenados en cada atributo pero dando la opcion de modificar con excepcion del codigo -->  
              <div class="form-group">
                <label class="col-sm-2 control-label">Codigo</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="codigo" value="<?php echo $data['codigo']; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Marca</label>
                <div class="col-sm-5">
                <select class="chosen-select" name="marca" data-placeholder="-- Seleccionar --" autocomplete="off" required>
                <option value="<?php echo $data['marca']; ?>"><?php echo $data['nombremar']; ?></option>
                  <?php
                     
                     $formcate = mysqli_query($mysqli, "SELECT * FROM `marcas`")
                                           or die('error '.mysqli_error($mysqli));
                   ?>
                   
                   <?php 
         
                     foreach ($formcate as $opciones):?>
                     <option value="<?php echo $opciones ['codigomar']?>"><?php echo $opciones ['nombremar']?></option>
                   <?php endforeach ?>
                 </select>
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-2 control-label">Precio de Compra</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">s/.</span>
                    <input type="text" class="form-control" id="precio_compra" name="pcompra" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo format_rupiah($data['precio_compra']); ?>" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Precio de Venta</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">s/.</span>
                    <input type="text" class="form-control" id="precio_venta" name="pventa" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo format_rupiah($data['precio_venta']); ?>" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Seccion</label>
                <div class="col-sm-5">
                <select class="chosen-select" name="seccion" data-placeholder="-- Seleccionar --" autocomplete="off" required>
                    <option value="<?php echo $data['seccion']; ?>"><?php echo $data['nombresec']; ?></option>
                  <?php
                     
                     $formcate = mysqli_query($mysqli, "SELECT * FROM `secciones`")
                                           or die('error '.mysqli_error($mysqli));
                   ?>
                   
                   <?php 
         
                     foreach ($formcate as $opciones):?>
                     <option value="<?php echo $opciones ['codigosec']?>"><?php echo $opciones ['nombresec']?></option>
                   <?php endforeach ?>
                 </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Categoria</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="categoria" data-placeholder="-- Seleccionar --" autocomplete="off" required>
                  <option value="<?php echo $data['categoria']; ?>"><?php echo $data['nombrecat']; ?></option>
                    <?php
                     
                      $formcate = mysqli_query($mysqli, "SELECT * FROM `categorias`")
                                            or die('error '.mysqli_error($mysqli));
                    ?>
                    
                    <?php 
          
                      foreach ($formcate as $opciones):?>
                      <option value="<?php echo $opciones ['codigocat']?>"><?php echo $opciones ['nombrecat']?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">
                  <a href="?module=clothes" class="btn btn-default btn-reset">Cancelar</a>
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