<!DOCTYPE html>
<html>
    <head>
        <title>Criptograma</title>
        <link rel="stylesheet" href="http://localhost/faia/stylesheets/styleresultado.css" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
		<style type="text/css">
	.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(http://localhost/faia/images/loading.gif) center no-repeat #fff;
}
</style>
<script type="text/javascript">
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
</script>
</head>
   
    
<div class="se-pre-con"></div>
        

<?php if ($brilloMayor<>""){ ?>
<?php if ($bandera){ ?>
   <div class="resultados">
     <div class="tituloPrincipal"><h1 style="font-size:30px">SE HA ENCONTRADO UNA SOLUCION</h1></div>
     <div class="titulo"><h1 style="font-family:Code-Bold, sans-serif; font-size:20px;color: #848484">Operadores</h1></div>
     <div class="variable"><?php echo $operando1; ?></div>
     <div class="variable"><?php echo $operando2; ?></div>
     <div class="titulo"><h1 style="font-family:Code-Bold, sans-serif; font-size:20px;color: #848484">Resultado</h1></div>
     <div class="variable"><?php echo $resultado; ?></div>
     <div class="titulo"><h1 style="font-family:Code-Bold, sans-serif; font-size:20px;color: #848484">Vector solucion</h1></div>
     <div class="variable"><?php echo $vector; ?></div>
     <div class="titulo"><h1 style="font-family:Code-Bold, sans-serif; font-size:20px;color: #848484">Numero de iteraciones</h1></div>
     <div class="variable"><?php echo $iteraciones; ?></div>
     </div>
<?php } else { ?>
<div class="resultados">
    <div class="tituloPrincipal"><h1 style="font-size:30px">NO SE HA ENCONTRADO UNA SOLUCION</h1></div>
</div>
<?php } ?>
<?php } ?>
  
    </body>
</html>