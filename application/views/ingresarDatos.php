<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title> IA</title>
   <link rel="stylesheet" href="http://localhost/faia/stylesheets/style.css">
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
   <body>
   <p align="center" style="padding: 80px 0px 20px 0px"><font size=10 >Criptograma</font></p>
	
	<div id="main">
    <form id="frm" action="ingresarDatos" method="POST" accept-charset="utf-8">
        <label><span>Operador 1:</span><input name="op1"></label><br/>
       <table id="check">
         <tr>
           <td><input id="suma" type="checkbox" name="prop" class="chb" /><label >+</label></td>
         </tr>
         <tr>
            <td><input id="resta" type="checkbox" name="prop" /><label >-</label></td>
         </tr>
       </table>
        <label><span>Operador 2:</span><input name="op2"></label><br>
        <label><span>Resultado:</span><input name="res"></label><br/>
        <button type="submit"  style="height:50px; width:100px">Resolver</button>
    </form>
    </div>
	</body>
	</html>