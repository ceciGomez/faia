<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title> IA</title>
   <link rel="stylesheet" href="http://localhost/faia/stylesheets/style.css" type="text/css">
    <script src="<?php echo base_url('javascripts/jquery-1.8.0.min.js');?>" type="text/javascript"></script>
   <script type="text/javascript">
     $(document).ready(function (){
      $("input:checkbox").click(function(){
        $("[name="+$(this).prop('name')+"]").prop("checked", false);
        $(this).prop("checked", true);
      });
     });
   </script>
   
   </head>
   <body >
   <p align="center"  style="padding: 120px 0px 20px 0px"><font size="45" color="WHITE"  >Criptograma</font></p>
	

<form style="padding: 40px 0px 0px 0px" action="mostrarResul" method="POST" accept-charset="utf-8">
    <label>Operacion</label>
    <input  name="prop" type="radio" id="suma" value="" checked="checked" /> Suma<br/>
    
    
    <label>Primer operador</label>
    <input type="text" name="op1"/><br/>

    <label>Segundo operador</label>
    <input type="text" name="op2"/><br/>

    <label>Resultado</label>
    <input type="text" name="res"/><br/>


    <span  class="form-field-no-caption"><input type="submit" value="Resolver" /></span>
</form>

	</body>
	</html>