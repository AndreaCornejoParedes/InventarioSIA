
<?php
session_start();

//Archivo que hace las consultas a la base de datos para add, edit y delete

require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}

else {
    if ($_GET['act']=='insert') {
        if (isset($_POST['Guardar'])) {
     //Al presionar guardar en el formulario se recopila lo que escribio o selecciono
            $codigo  = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
            $marca     = mysqli_real_escape_string($mysqli, trim($_POST['marca']));
            $pcompra = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['pcompra'])));
            $pventa = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['pventa'])));
            $seccion     = mysqli_real_escape_string($mysqli, trim($_POST['seccion']));
            $categoria     = mysqli_real_escape_string($mysqli, trim($_POST['categoria']));

            $created_user = $_SESSION['id_user'];

   //Y se inserta el la tabla mostrando la alerta si todo fue correcto
            $query = mysqli_query($mysqli, "INSERT INTO prendas(codigo,marca,precio_compra,precio_venta,seccion,created_user,updated_user,categoria) 
                                            VALUES('$codigo','$marca','$pcompra','$pventa','$seccion','$created_user','$created_user','$categoria')")
                                            or die('error '.mysqli_error($mysqli));    

        
            if ($query) {
         
                header("location: ../../main.php?module=clothes&alert=1");
            }   
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['codigo'])) {
                
        //Al presionar guardar en el formulario se recopila lo que escribio o selecciono
                $codigo  = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
                $marca  = mysqli_real_escape_string($mysqli, trim($_POST['marca']));
                $pcompra = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['pcompra'])));
                $pventa = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['pventa'])));
                $seccion     = mysqli_real_escape_string($mysqli, trim($_POST['seccion']));
                $categoria     = mysqli_real_escape_string($mysqli, trim($_POST['categoria']));

                $updated_user = $_SESSION['id_user'];

                $query = mysqli_query($mysqli, "UPDATE prendas SET  marca       = '$marca',
                                                                    precio_compra      = $pcompra,
                                                                    precio_venta      = $pventa,
                                                                    seccion          = '$seccion',
                                                                    categoria          = '$categoria',
                                                                    updated_user    = '$updated_user'
                                                              WHERE codigo       = '$codigo'")
                                                or die('error: '.mysqli_error($mysqli));

    
                if ($query) {
                  
                    header("location: ../../main.php?module=clothes&alert=2");
                }         
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $codigo = $_GET['id'];
      // Si selecciono eliminar se buscara el producto por su codigo y se elimina
            $query = mysqli_query($mysqli, "DELETE FROM prendas WHERE codigo='$codigo'")
                                            or die('error '.mysqli_error($mysqli));


            if ($query) {
     
                header("location: ../../main.php?module=clothes&alert=3");
            }
        }
    }       
}       
?>