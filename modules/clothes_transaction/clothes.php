
<?php
session_start();


require_once "../../config/database.php";

if(isset($_POST['dataidobat'])) {
	$codigo = $_POST['dataidobat'];

  //Se consulta atributos de la tabla prenda que vamos a usar al momento de mostrar el formulario
 
  $query = mysqli_query($mysqli, "SELECT a.codigo,b.nombremar,c.nombresec,stock,d.nombrecat FROM prendas as a INNER JOIN marcas as b ON a.marca=b.codigomar
                     INNER JOIN secciones as c ON a.seccion=c.codigosec
                    INNER JOIN categorias as d ON a.categoria=d.codigocat
                      WHERE codigo='$codigo'")
                                  or die('error '.mysqli_error($mysqli));


  $data = mysqli_fetch_assoc($query);

  $stock   = $data['stock'];
  $seccion = $data['nombresec'];
  $categoria = $data['nombrecat'];

	if($stock != '') {
		echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Stock</label>
                <div class='col-sm-5'>
                  <div class='input-group'>
                    <input type='text' class='form-control' id='stok' name='stock' value='$stock' readonly>
                    <span class='input-group-addon'>$seccion</span>
                    <span class='input-group-addon'>$categoria</span>
                  </div>
                </div>
              </div>";
	} else {
		echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Stock</label>
                <div class='col-sm-5'>
                  <div class='input-group'>
                    <input type='text' class='form-control' id='stok' name='stock' value='' readonly>
                    <span class='input-group-addon'></span>
                  </div>
                </div>
              </div>";
	}		
}
?> 