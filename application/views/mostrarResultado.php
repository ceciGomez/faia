<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <title>Criptograma</title>
        <link rel="stylesheet" href="http://localhost/faia/stylesheets/style.css" type="text/css">
  
</head>
<body>
    

        

<?php if ($brilloMayor!=null){ ?>
<?php if ($bandera){ ?>
   <div class="resultados">
     <div class="tituloPrincipal"><h1>SE HA ENCONTRADO UNA SOLUCION</h1></div>
     <div class="titulo"><h1>Operadores</h1></div>
     <div class="variable"><?php echo $operando1." ".$operando1resultado; ?></div>
     <div class="variable"><?php echo $operando2." ".$operando2resultado; ?></div>
     <div class="variable"><?php echo $operador; ?></div>
     <div class="titulo"><h1>Resultado</h1></div>
     <div class="variable"><?php echo $resultadoletras." - ".$resultadonumero; ; ?></div>
     <div class="titulo"><h1>Vector solucion</h1></div>
     <div class="variable"><?php echo $vector; ?></div>
     <div class="variable"><?php echo $vecinicio; ?></div>
     <div class="titulo"><h1>Numero de luciernagas</h1></div>
     <div class="variable"><?php echo $luciernagas; ?></div>
     <div class="titulo"><h1>Numero de iteraciones</h1></div>
     <div class="variable"><?php echo $iteraciones; ?></div>
     <div class="titulo"><h1>Tiempo de procesamiento</h1></div>
     <div class="variable"><?php echo $tiempo; ?></div>
     </div>
<?php } else { ?>
<div class="resultados">
    <div class="tituloPrincipal"><h1>NO SE HA ENCONTRADO UNA SOLUCION</h1></div>
</div>
<?php } ?>
<?php } ?>
  
    </body>
</html>