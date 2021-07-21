

<?php
session_start();

require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}
//Archivo que hace las consultas a la base de datos para add ademas de que se actualiza el stock
else {
    if ($_GET['act']=='insert') {
        if (isset($_POST['Guardar'])) {
            
            $codigo_transaccion = mysqli_real_escape_string($mysqli, trim($_POST['codigo_transaccion']));
            $fecha = mysqli_real_escape_string($mysqli, trim($_POST['fecha_a']));
			
            
            $codigo       = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
      
            $num   = mysqli_real_escape_string($mysqli, trim($_POST['num']));
            $total_stock      = mysqli_real_escape_string($mysqli, trim($_POST['total_stock']));
            $tipo_transaccion= mysqli_real_escape_string($mysqli, trim($_POST['transaccion']));
            $created_user    = $_SESSION['id_user'];
            $proveedor= mysqli_real_escape_string($mysqli, trim($_POST['dnirucprovselec']));
            $documentoid= mysqli_real_escape_string($mysqli, trim($_POST['documentoid']));
          
            $query = mysqli_query($mysqli, "INSERT INTO transaccion_prendas(codigo_transaccion,codigo,numero,created_user,tipo_transaccion,proveedor,documentoid) 
                                            VALUES('$codigo_transaccion','$codigo','$num','$created_user','$tipo_transaccion','$proveedor','$documentoid')")
                                            or die('Error: '.mysqli_error($mysqli));    

           
            if ($query) {
                
                $query1 = mysqli_query($mysqli, "UPDATE prendas SET stock        = '$total_stock'
                                                              WHERE codigo   = '$codigo'")
                                                or die('Error: '.mysqli_error($mysqli));

               
                if ($query1) {                       
                    
                    header("location: ../../main.php?module=clothes_transaction&alert=1");
                }
            }   
        }   
    }
    
}       
?>