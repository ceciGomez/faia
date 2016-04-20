<!DOCTYPE html>
<html>
   <head>
      <meta charset='utf-8'>
      <meta http-equiv="X-UA-Compatible" content="chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <link href='https://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen">
      <link rel="stylesheet" type="text/css" href="stylesheets/github-light.css" media="screen">
      <link rel="stylesheet" type="text/css" href="stylesheets/print.css" media="print">
      <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <title>Criptoaritmetica para IA </title>
   </head>
   <body>
      <header>
         <div class="inner">
            <h1>Inteligencia Artificial</h1>
            <h2>Resolviendo criptoaritmetica con la utilizacion de algoritmos genéticos</h2>
            <a href="https://github.com/ceciGomez/faia" class="button"><small>View project on</small> GitHub</a>
         </div>
      </header>
      <div id="content-wrapper">
      <div class="inner clearfix">
      <section id="main-content">
         <h3>
            <a id="welcome-to-github-pages" class="anchor" href="#welcome-to-github-pages" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Comenzar
         </h3>
         <form>
            <p>Vamos a comenzar con el ejemplo de TWO + TWO = FOUR</p>
            <p align="justify">1) Se orden las letras ingresadas de empezando por el resultado, las letras ordenadas quedan:</p>
            <table>
               <tr>
                  <td>Posición</td>
                  <td>0</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>9</td>
               </tr>
               <tr>
                  <td>Letras Ordenadas</td>
                  <td>R</td>
                  <td>U</td>
                  <td>O</td>
                  <td>F</td>
                  <td>W</td>
                  <td>T</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
               </tr>
               <tbody>
                  <tr>
                     <?php
                        $arrayNumeros = array('0','1','2','3','4','5','6','7','8','9');
                        
                        shuffle($arrayNumeros);
                        ?>
                  <tr>
                     <TD>vector 1</TD>
                     <td>
                        <?php echo "$arrayNumeros[0]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[1]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[2]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[3]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[4]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[5]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[6]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[7]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[8]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[9]";?>
                     </td>
                  </tr>
                  <tr>
                     <?php
                        $arrayNumeros = array('0','1','2','3','4','5','6','7','8','9');
                        
                        shuffle($arrayNumeros);
                        ?>
                  <tr>
                     <TD>vector 2</TD>
                     <td>
                        <?php echo "$arrayNumeros[0]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[1]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[2]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[3]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[4]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[5]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[6]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[7]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[8]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[9]";?>
                     </td>
                  </tr>
                  <tr>
                     <?php
                        $arrayNumeros = array('0','1','2','3','4','5','6','7','8','9');
                        
                        shuffle($arrayNumeros);
                        ?>
                  <tr>
                     <TD>vector 3</TD>
                     <td>
                        <?php echo "$arrayNumeros[0]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[1]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[2]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[3]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[4]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[5]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[6]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[7]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[8]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[9]";?>
                     </td>
                  </tr>
                  <tr>
                     <?php
                        $arrayNumeros = array('0','1','2','3','4','5','6','7','8','9');
                        
                        shuffle($arrayNumeros);
                        ?>
                  <tr>
                     <TD>vector 4</TD>
                     <td>
                        <?php echo "$arrayNumeros[0]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[1]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[2]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[3]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[4]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[5]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[6]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[7]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[8]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[9]";?>
                     </td>
                  </tr>
                  <tr>
                     <?php
                        $arrayNumeros = array('0','1','2','3','4','5','6','7','8','9');
                        
                        shuffle($arrayNumeros);
                        ?>
                  <tr>
                     <TD>vector 5</TD>
                     <td>
                        <?php echo "$arrayNumeros[0]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[1]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[2]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[3]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[4]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[5]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[6]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[7]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[8]";?>
                     </td>
                     <td>
                        <?php echo "$arrayNumeros[9]";?>
                     </td>
                  </tr>
               </tbody>
               </tr>
            </table>
         </form>
      </section>
      <aside id="sidebar">
         <a href="https://github.com/cecidrunk/faia/zipball/master" class="button">
         <small>Download</small>
         .zip file
         </a>
         <p class="repo-owner"><a href="https://github.com/ceciGomez/faia"></a> is maintained by
            <a href="https://github.com/ceciGomez">Maria Laura Acuña</a>,
            <a href="https://github.com/ceciGomez">Cecilia Gomez</a>,
            <a href="https://github.com/ceciGomez">Marcelo Espinoza</a>,
         </p>
         <p>This page was generated by <a href="https://pages.github.com">GitHub Pages</a> using the Architect theme by <a href="https://twitter.com/jasonlong">Jason Long</a>.</p>
      </aside>
   </body>
</html>