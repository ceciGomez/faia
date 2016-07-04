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
     <div class="titulo"><h2>Operadores</h2></div>
     <div class="variable"><?php echo $operando1." = ".$operando1resultado; ?></div>
     <div class="variable"><?php echo $operando2." = ".$operando2resultado; ?></div>
     <div class="variable"><?php echo 'Operador: '.$operador; ?></div>
     <div class="titulo"><h2>Resultado</h2></div>
     <div class="variable"><?php echo $resultadoletras." = ".$resultadonumero; ; ?></div>
     <div class="titulo"><h2>Vector solucion</h2></div>
     <div class="variable"><?php echo $vector; ?></div>
     <div class="variable"><?php echo $vecinicio; ?></div>
     <div class="titulo"><h2>Numero de luciernagas</h2></div>
     <div class="variable"><?php echo $luciernagas; ?></div>
     <div class="titulo"><h2>Numero de iteraciones</h2></div>
     <div class="variable"><?php echo $iteraciones; ?></div>
     <div class="titulo"><h2>Tiempo de procesamiento</h2></div>
     <div class="variable"><?php echo $tiempo.' segundos'; ?></div>
     </div>
<?php } else { ?>
<div class="resultados">
    <div class="tituloPrincipal"><h1>NO SE HA ENCONTRADO UNA SOLUCION</h1></div>
</div>
<?php } ?>
<?php } ?>
  
    </body>
</html>