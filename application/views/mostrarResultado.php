<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <title>Criptograma</title>
        <link rel="stylesheet" href="http://localhost/faia/stylesheets/style.css" type="text/css">
        <script src="<?php echo base_url('javascripts/jquery-1.8.0.min.js');?>" type="text/javascript"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
		
		
</head>
<body>
    

        

<?php if ($brilloMayor!=null){ ?>
<?php if ($bandera){ ?>
   <div class="resultados">
     <div class="tituloPrincipal"><h1>SE HA ENCONTRADO UNA SOLUCION</h1></div>
     <div class="titulo"><h1>Operadores</h1></div>
     <div class="variable"><?php echo $operando1; ?></div>
     <div class="variable"><?php echo $operando2; ?></div>
     <div class="variable"><?php echo $operador; ?></div>
     <div class="titulo"><h1>Resultado</h1></div>
     <div class="variable"><?php echo $resultado; ?></div>
     <div class="titulo"><h1>Vector solucion</h1></div>
     <div class="variable"><?php echo $vector; ?></div>
     <div class="variable"><?php echo $vecinicio; ?></div>
     <div class="titulo"><h1>Numero de iteraciones</h1></div>
     <div class="variable"><?php echo $iteraciones; ?></div>
     </div>
<?php } else { ?>
<div class="resultados">
    <div class="tituloPrincipal"><h1>NO SE HA ENCONTRADO UNA SOLUCION</h1></div>
</div>
<?php } ?>
<?php } ?>
  
    </body>
</html>