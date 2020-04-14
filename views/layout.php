<!DOCTYPE html> 
<html lang = "en"> 
   <head> 
      <meta name = "viewport" content = "width = device-width, initial-scale = 1">  
      <title><?php echo $title; ?></title>  
      
      <link href = "../../assets/css/bootstrap.min.css" rel = "stylesheet">  
      <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
      </script> 
      <script src = "../../assets/js/bootstrap.js"></script> 
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
               <a class = "navbar-brand" href = "index">Starting Sample</a> 
            </div> 
            
            <div id = "navbar" class = "collapse navbar-collapse"> 
               <ul class = "nav navbar-nav"> 
                  <li class = <?php echo $indexactive ?>><a href = "index">Home</a></li> 
                  <li class = <?php echo $hospitalactive ?>><a href = "hospital">Hospitals</a></li> 
                  <li class = <?php echo $aboutactive ?>><a href = "aboutus">About Us</a></li> 
               </ul> 
            </div><!--/.nav-collapse --> 
         </div> 
      </nav>  
      
      <div class = "container"> 
         <div class = "starter-template" style = "padding: 50px 0 0 0;"> 
            <?php echo $content; ?> 
         </div> 
      
      </div>
   </body>
   
</html>