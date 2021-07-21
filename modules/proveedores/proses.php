
<?php
session_start();


require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}

else {
    //Se consultan los datos del formulario y se insertan en la tabla proveedores
    if ($_GET['act']=='insert') {
        if (isset($_POST['Guardar'])) {
     
            $codigoprov       = mysqli_real_escape_string($mysqli, trim($_POST['codigoprov']));
            $rucdniprov   = mysqli_real_escape_string($mysqli, trim($_POST['rucdniprov']));
            $nomrazonsocial_pro      = mysqli_real_escape_string($mysqli, trim($_POST['nomrazonsocial_pro']));
            $telefonopro= mysqli_real_escape_string($mysqli, trim($_POST['telefonopro']));
            $direpro= mysqli_real_escape_string($mysqli, trim($_POST['direpro']));
            $created_user    = $_SESSION['id_user'];
            $email= mysqli_real_escape_string($mysqli, trim($_POST['email']));


            $query = mysqli_query($mysqli, "INSERT INTO proveedores(codigoprov,email,rsnomprov,rucdni,telefono,direccion, user_id) 
                                            VALUES('$codigoprov','$email','$nomrazonsocial_pro','$rucdniprov','$telefonopro','$direpro','$created_user')")
                                            or die('Error: '.mysqli_error($mysqli));      

        
            if ($query) {
         
                header("location: ../../main.php?module=proveedores&alert=1");
            }   
        }   
    }
    elseif ($_GET['act']=='update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['codigoprov'])) {
                
        //Se consultan los datos del formulario y se actualizan en la tabla proveedores
                $codigoprov       = mysqli_real_escape_string($mysqli, trim($_POST['codigoprov']));
                $rucdniprov   = mysqli_real_escape_string($mysqli, trim($_POST['rucdniprov']));
                $nomrazonsocial_pro      = mysqli_real_escape_string($mysqli, trim($_POST['nomrazonsocial_pro']));
                $telefonopro= mysqli_real_escape_string($mysqli, trim($_POST['telefonopro']));
                $direpro= mysqli_real_escape_string($mysqli, trim($_POST['direpro']));
                $email= mysqli_real_escape_string($mysqli, trim($_POST['email']));

        

                $query = mysqli_query($mysqli, "UPDATE proveedores SET  
                                                                    rucdni      = '$rucdniprov',
                                                                    rsnomprov      = '$nomrazonsocial_pro',
                                                                    telefono          = '$telefonopro',
                                                                    direccion          = '$direpro',
                                                                    email= '$email'
                                                              WHERE codigoprov       = '$codigoprov'")
                                                or die('error: '.mysqli_error($mysqli));

    
                if ($query) {
                  
                    header("location: ../../main.php?module=proveedores&alert=2");
                }         
            }
        }
    }

    

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $codigo = $_GET['id'];
      
            $query = mysqli_query($mysqli, "DELETE FROM proveedores WHERE codigoprov='$codigo'")
                                            or die('error '.mysqli_error($mysqli));


            if ($query) {
     
                header("location: ../../main.php?module=proveedores&alert=3");
            }
        }
    }       
}       
?>