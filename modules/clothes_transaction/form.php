//Definicion de funciones que vamos a usar
<script type="text/javascript">
  function tampil_obat(input){
    var num = input.value;

    $.post("modules/clothes_transaction/clothes.php", {
      dataidobat: num,
    }, function(response) {      
      $('#stok').html(response)

      document.getElementById('jumlah_masuk').focus();
    });
  }

  function cek_jumlah_masuk(input) {
    jml = document.formObatMasuk.jumlah_masuk.value;
    var jumlah = eval(jml);
    if(jumlah < 1){
      alert('Jumlah Masuk Tidak Boleh Nol !!');
      input.value = input.value.substring(0,input.value.length-1);
    }
  }

  function hitung_total_stok() {
    bil1 = document.formObatMasuk.stok.value;
    bil2 = document.formObatMasuk.jumlah_masuk.value;
	tt = document.formObatMasuk.transaccion.value;
	
    if (bil2 == "") {
      var hasil = "";
    }
    else {
      var salida = eval(bil1) - eval(bil2);
	  var hasil = eval(bil1) + eval(bil2);
    }

	if (tt=="Salida"){
		document.formObatMasuk.total_stok.value = (salida);
	}	else {
		document.formObatMasuk.total_stok.value = (hasil);
	} 
    
  }
</script>

<?php  
//Formulario para add
if ($_GET['form']=='add') { ?> 

  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Datos de entrada/ salida de prendas
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=start"><i class="fa fa-home"></i> Inicio </a></li>
      <li><a href="?module=clothes_transaction"> Entrada </a></li>
      <li class="active"> Agregar </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/clothes_transaction/proses.php?act=insert" method="POST" name="formObatMasuk">
            <div class="box-body">
              <?php  
            //Se autogenera el codigo sumando 1
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(codigo_transaccion,7) as codigo FROM transaccion_prendas
                                                ORDER BY codigo_transaccion DESC LIMIT 1")
                                                or die('Error : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                 
                  $data_id = mysqli_fetch_assoc($query_id);
                  $codigo    = $data_id['codigo']+1;
              } else {
                  $codigo = 1;
              }

             
              $tahun          = date("Y");
              $buat_id        = str_pad($codigo, 7, "0", STR_PAD_LEFT);
              $codigo_transaccion = "TM-$tahun-$buat_id";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Codigo de Transacción </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="codigo_transaccion" id="codigo_transaccion" value="<?php echo $codigo_transaccion; ?>" readonly required>
                </div>
              </div>
<!-- Se consulta la fecha del sistema -->
              <div class="form-group">
                <label class="col-sm-2 control-label">Fecha</label>
                <div class="col-sm-5">
               
                   
                  <input type="date" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="fecha_a" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" readonly required>
                </div>
              </div>
<!-- A traves de seleccion se pide seleccionar el proveedor permitiendo que busque por codigo o descripcion -->
              <hr>
              <div class="form-group">  
                <label class="col-sm-2 control-label">DNI/RUC del proveedor</label>
                <div class="col-sm-5">
                <select class="chosen-select" name="dnirucprovselec" id="dnirucprovselec" data-placeholder="-- Seleccionar Proveedor --" autocomplete="off" required>
                    <?php
                     
                      $formcate = mysqli_query($mysqli, "SELECT codigoprov, rsnomprov FROM proveedores ORDER BY rsnomprov ASC")
                      or die('error '.mysqli_error($mysqli));
                    ?>
                    <option value=""></option>
                    <?php 
          
                      foreach ($formcate as $opciones):?>
                      <option value=<?php echo $opciones ['codigoprov']?>><?php echo $opciones['codigoprov'] ," | ", $opciones['rsnomprov'] ?></option>
                      
                      <?php endforeach ?>
                  </select>

                </div>
              </div>
             
              <hr>
<!-- A traves de seleccion se pide seleccionar la prenda permitiendo que busque por codigo o descripcion -->
              <div class="form-group">  
                <label class="col-sm-2 control-label">Prenda</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="codigo" data-placeholder="-- Seleccionar Prenda --" onchange="tampil_obat(this)" autocomplete="off" required>
                    <option value=""></option>
                    <?php
                      $query_obat = mysqli_query($mysqli, "SELECT codigo, b.nombremar FROM prendas as a INNER JOIN marcas as b ON a.marca=b.codigomar ORDER BY marca ASC")
                                                            or die('error '.mysqli_error($mysqli));
                      while ($data_obat = mysqli_fetch_assoc($query_obat)) {
                        echo"<option value=\"$data_obat[codigo]\"> $data_obat[codigo] | $data_obat[nombremar] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
     <!-- Se muestra el Stock -->         
              <span id='stok'>
              <div class="form-group">
                <label class="col-sm-2 control-label">Stock</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="stok" name="stock" readonly required>
                </div>
              </div>
              </span>
    <!-- Se pide la cantidad --> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Cantidad</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="jumlah_masuk" name="num" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" onkeyup="hitung_total_stok(this)&cek_jumlah_masuk(this)" required>
                </div>
              </div>
		<!-- Se pide la transaccion (En este caso entrada) --> 	  
			  <div class="form-group">
                <label class="col-sm-2 control-label">Transacción</label>
                <div class="col-sm-5">
                  <input value="Entrada" name="transaccion" id="transaccion" readonly required class='form-control' onchange="hitung_total_stok();">
				
				
                </div>                    
              </div>
    <!-- Teniendo en cuenta la cantidad se mostrara el stock total --> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Total Stock</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="total_stok" name="total_stock" readonly required>
                </div>
              </div>
      <!-- Se pide el documento del proveedor es decir guia  --> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Documento proveedor</label>
                <div class="col-sm-5">
                <input type="text" class="form-control" name="documentoid" id="documentoid" autocomplete="off" required>
                </div>
              </div>

            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input id= btn_guardartransac type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">
                  <a  href="?module=clothes_transaction" class="btn btn-default btn-reset">Cancelar</a>
                  
                </div>
              </div>
            </div><!-- /.box footer -->
            <script>
              
            </script>
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
?>