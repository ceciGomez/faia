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
   <p align="center"  style="padding: 10px 0px 20px 0px"><font color="WHITE"  >Criptograma</font></p>
	

<form  action="mostrarResul" method="POST" accept-charset="utf-8">

      <label>Numero de luciernagas</label>
    <input type="number" name="op1" style="width: 50px"/><br/>

    <label >Suma</label>
      <input type="radio" name="sex" id="male" value="" checked/><br/>
    
    <label >Resta</label>
      <input type="radio" name="sex" id="female" /><br/>

    
    <label>Primer operador</label>
    <input type="text" name="op1"/><br/>

    <label>Segundo operador</label>
    <input type="text" name="op2"/><br/>

    <label>Resultado</label>
    <input type="text" name="res"/><br/>

    <span  class="form-field-no-caption"><input type="submit" value="Resolver" style="color:white;
background-color:#555555; "/></span>
</form>

	</body>
	</html>