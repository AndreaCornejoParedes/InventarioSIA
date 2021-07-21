<?php
session_start();
ob_start();


require_once "../../config/database.php";

include "../../config/fungsi_tanggal.php";

include "../../config/fungsi_rupiah.php";


//Se realiza la consulta a la base de datos
if (isset($_GET['id'])) {
    $query1 = mysqli_query($mysqli, "SELECT RUC,razon_social, direccion, email, telefono FROM configuracion WHERE id=1")
        or die('Error: '.mysqli_error($mysqli));
    $rows1  = mysqli_num_rows($query1);
    $configuracion=mysqli_fetch_assoc($query1);
    $query = mysqli_query($mysqli, "SELECT a.tipo_transaccion,a.documentoid, a.codigo_transaccion,a.proveedor,p.rsnomprov, p.rucdni, p.telefono,p.email, p.direccion, a.fecha, DATE_FORMAT(a.fecha,'%d/%m/%Y') as fecha, DATE_FORMAT(a.fecha,'%H:%i:%s') as hora, a.numero,b.codigo,c.nombremar,d.nombresec,e.nombrecat
    FROM transaccion_prendas as a 
    INNER JOIN prendas as b ON a.codigo=b.codigo 
    INNER JOIN marcas as c ON b.marca=c.codigomar 
    INNER JOIN secciones as d ON b.seccion=d.codigosec 
    INNER JOIN categorias as e ON b.categoria=e.codigocat 
    INNER JOIN proveedores as p ON a.proveedor=p.codigoprov 
    WHERE codigo_transaccion='$_GET[id]'")
    or die('Error: '.mysqli_error($mysqli));      
    $rows  = mysqli_num_rows($query);
    $transaccion=mysqli_fetch_assoc($query);
    $no_trans=$transaccion['codigo_transaccion'];
    
    
}

?>

<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title style="width: 50%">PARTE DE ENTRADA</title>
        <link rel="stylesheet" type="text/css" href="../../assets/css/laporan.css" />
        <style>  
    body  
    {  
    background-image:url("img/fondo.png");  
    background-position: 50% 50%;
    background-size: cover;
    }  
    </style> 
    </head>
    <body>
         <!--Se crea la cabecera con nuestros datos --> 
        <table cellspacing="0" style="width:100%;">
            <tr>
            <td style="position:center">
            <img src="img/logo.png" width="130" height="130" >
            </td>
            <td  style="color:dark;background-color:#ffffff;padding:2px;text-align:center;position: relative;
            width: 400px;height: 200px;margin-left:120px"> 
                <strong style="font-size:30px;text-align:center;margin-left:50px;margin-top:0.0001px" > PARTE DE ENTRADA</strong>
                <table style="text-align:left; position:relative;width:100%;top: 00px;right: -150px;">
                  <?php
                   echo "  
                   <tr>
                    <td style='font-size:12px;text-align:center;margin-left:10000px;margin-top:0.0001px'>RUC: $configuracion[RUC]</td>
                   </tr>
                   <tr>
                    <td style='font-size:12px;text-align:center;margin-left:10000px;margin-top:0.0001px'>$configuracion[razon_social]</td>
                    </tr>
                    <tr>
                   <td style='font-size:12px;text-align:center;margin-left:10000px;margin-top:0.0001px'>$configuracion[direccion]</td>
                   </tr>
                   <tr>
                   <td style='font-size:12px;text-align:center;margin-left:10000px;margin-top:0.0001px'>email:$configuracion[email]</td>
                   </tr>
                   <tr>
                   <td style='font-size:12px;text-align:center;margin-left:10000px;margin-top:0.0001px'>celular: $configuracion[telefono]</td>
                    </tr>"
                    ?>
                    
                </table>
            </td>
            
                <td  style="width: 7%;text-align:right"></td>
 <!--Datos de la transaccion --> 
            <td  style="width: 15.5%;text-align:right">
                    <table style="text-align:center; position:center;margin-top:0px;border-collapse:collapse;border:solid black 1px;border-spacing: 100;border-radius:7px;">
                    <tr>
                      <td colspan="2" style="background-color:#542996">
                          <strong style="font-size:15px;text-align:center;margin-left:0px;margin-top:0px;color:#FFFFFF;" > Transaccion </strong>
                      </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;text-align:left;margin-left:0px;margin-top:0px" > Codigo: </p>
                        </td>
                        <td  style="width: 0%; font-size:10px;text-align:left;margin-left:0px"> 
                            <?php echo  $transaccion['codigo_transaccion']  ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;text-align:left;margin-left:0px;margin-top:0px" > Fecha: </p>
                        </td>
                         <td  style="width: 0%; font-size:10px;text-align:left"> 
                            <?php echo  $transaccion['fecha'], $transaccion['hora'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;text-align:left;margin-left:00px;margin-top:0px" > Tipo: </p>
                        </td>
                        <td>
                            <p style="font-size:10px;text-align:left;margin-left:0px;margin-top:0px" > ENTRADA </p>
                        </td>
                    </tr>
                </table>
            </td>

            </tr>
        </table>
        <div >
             <!--Datos del proveedor --> 
            <hr style="color:#542996;height: 1px;">
             <strong style="font-size:16px;text-align:center;margin-left:250px;margin-top:0px;color:#542996;" > DATOS PROVEEDOR </strong>
             <hr style="color:#25217A;height: 1px;">
        </div>
        
        <table style="width:90%;">
            <tr>
            <td  style="width: 19.5%; ">
                    <strong style="font-size:12px;" > Codigo proveedor: </strong>
            </td>
            
            <td  style="width: 50%;font-size:12px "> 
            <?php echo  $transaccion['proveedor']  ?>
            </td>
            <td  style="width: 17.5%; ">
                    <strong style="font-size:12px;text-align:left;margin-left:0px;margin-top:0px" > RUC / DNI: </strong>
            </td>
            
            <td  style="width: 50%; font-size:12px;text-align:left;margin-left:0px"> 
            <?php echo  $transaccion['rucdni']  ?>
            </td>
            </tr>

            <tr>
            <td  style="width: 17.5%; ">
                    <strong style="font-size:12px;" > Nombre: </strong>
            </td>
            
            <td  style="width: 50%;font-size:12px"> 
                <?php echo  $transaccion['rsnomprov']  ?>
            </td>
            <td  style="width: 17.5%; ">
                    <strong style="font-size:12px;text-align:left;margin-left:0px;margin-top:0px" > Telefono : </strong>
            </td>
            
            <td  style="width: 50%;font-size:12px"> 
            <?php echo $transaccion['telefono']?>
            </td>
            </tr>
            <tr>
            <td  style="width: 19.5%; ">
                    <strong style="font-size:12px;" > Doc. proveedor: </strong>
            </td>
            
            <td  style="width: 50%;font-size:12px"> 
            <?php echo $transaccion['documentoid']?>
            </td>

            <td  style="width: 17.5%; ">
                    <strong style="font-size:12px;text-align:left;margin-left:0px;margin-top:0px" > Email : </strong>
            </td>
            
            <td  style="width: 50%;font-size:12px"> 
            <?php echo $transaccion['email']?>
            </td>
            </tr>

            
                        
        </table>

        <hr style="height: 3px;color:#542996"><br>
         <!--Datos de la prenda --> 
        
        <hr style="height: 1.5px;color:#542996">
        <strong><h1 id="title" style="margin-top:0px;color:#542996">
          DATOS PRODUCTOS
       </h1></strong>
       <hr style="height: 1.5px;color:#542996;">
       <table style="width:90%;margin-top:0px" cellspacing="0">
            <tr style="background-color:#D6BCFF">
            <td  style="width: 22%; text-align:center">
                    <strong style="font-size:12px;text-align:right;margin-left:0px;margin-top:0px" > CANTIDAD </strong>
            </td>
            
            <td  style="width: 22%; text-align:center">
                    <strong style="font-size:12px;text-align:right;margin-left:0px;margin-top:0px" > CODIGO </strong>
            </td>
            
            <td  style="width: 22%; text-align:center">
                    <strong style="font-size:12px;text-align:right;margin-left:0px;margin-top:0px" > MARCA </strong>
            </td>
            
            <td  style="width: 22%; text-align:center">
                    <strong style="font-size:12px;text-align:right;margin-left:0px;margin-top:0px" > SECCION </strong>
            </td>
            
            <td  style="width: 22%; text-align:center">
                    <strong style="font-size:12px;text-align:right;margin-left:0px;margin-top:0px" > CATEGORIA </strong>
            </td>
            
            </tr>
               
                <?php 
     
      
     
       echo "  <tr>
                   <td style='font-size:12px;text-align:center;margin-left:100px;margin-top:0.0001px'>$transaccion[numero]</td>
                   <td style='font-size:12px;text-align:center;margin-left:100px;margin-top:0.0001px'>$transaccion[codigo]</td>
                   <td style='font-size:12px;text-align:center;margin-left:100px;margin-top:0.0001px'>$transaccion[nombremar]</td>
                   <td style='font-size:12px;text-align:center;margin-left:100px;margin-top:0.0001px'>$transaccion[nombresec]</td>
                   <td style='font-size:12px;text-align:center;margin-left:100px;margin-top:0.0001px'>$transaccion[nombrecat]</td>
                  
               </tr>";
     
   
   ?>             
        </table>
        <table style="text-align:center; position:relative;width:100%;top: 550px;right: -150px;">
                    <tr>
                        <td>
                            <p style="font-size:10px;text-align:center;margin-left:150px;margin-top:0.0001px" > Proyecto SIA - Tercera Fase</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;text-align:center;margin-left:150px;margin-top:0.0001px" > Carlos Ala Samayani</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;text-align:center;margin-left:150px;margin-top:0.0001px" > Andrea Cornejo Paredes</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;text-align:center;margin-left:150px;margin-top:0.0001px" > Beatrice Cueva Medina</p>
                        </td>
                    </tr>
                </table>  
    </body>
</html>
<?php
//Se define el nombre del archivo y se envia todo a la libreria
$filename="PARTE DE ENTRADA $no_trans .pdf"; 
//==========================================================================================================
$content = ob_get_clean();
$content = '<page style="font-family: freeserif">'.($content).'</page>';

require_once('../../assets/plugins/html2pdf_v4.03/html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P','F4','en', false, 'ISO-8859-15',array(10, 10, 10, 10));
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output($filename);
}
catch(HTML2PDF_exception $e) { echo $e; }
?>