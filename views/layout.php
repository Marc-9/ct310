<?php session_start(); ?>
<!DOCTYPE html> 
<html lang = "en"> 
   <head> 
      <meta name = "viewport" content = "width = device-width, initial-scale = 1">  
      <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.ico" />
      <title><?php echo $title; ?></title>  
      
      <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
      <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src = "../../assets/js/bootstrap.js"></script>
      <link href = "../../assets/css/bootstrap.min.css" rel = "stylesheet">  
      <link href = "https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel = "stylesheet">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
       <script src = "https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   </head>  
   
   <body> 
      <nav class = "navbar navbar-inverse navbar-fixed-top"> 
         <div class = "container"> 
            <div class = "navbar-header">
               
               <button type = "button" class = "navbar-toggle collapsed" 
                  datatoggle = "collapse" data-target = "#navbar" 
                  aria-expanded = "false" ariacontrols = "navbar"> 
                  <span class=  "sr-only">Toggle navigation</span> 
                  <span class = "icon-bar"></span> 
                  <span class = "icon-bar"></span> 
                  <span class = "icon-bar"></span> 
               </button> 
               <a class = "navbar-brand" href = "index">Covert</a> 
            </div> 
            
            <div id = "navbar" class = "collapse navbar-collapse"> 
               <ul class = "nav navbar-nav"> 
                  <li class = <?php echo $indexactive ?>><a href = "index">Home</a></li> 
                  <li class = <?php echo $hospitalactive ?>><a href = "hospital">Hospitals</a></li>
                  <li class = <?php echo $drgactive ?>><a href = "drg">DRG</a></li>
                  <li class = <?php echo $aboutactive ?>><a href = "aboutus">About Us</a></li> 
                  <?php if(!isset($_SESSION['id'])){echo "<li class =$loginactive><a href = 'login'>Login</a></li>";} ?>
               </ul> 
            </div> 
         </div> 
      </nav>  
      
      <div class = "container"> 
         <div class = "starter-template" style = "padding: 50px 0 0 0;"> 
            <?php echo $content; ?> 
         </div> 
      
      </div>
   </body>
   
</html>