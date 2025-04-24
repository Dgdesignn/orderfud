<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OrderFüd</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=Outfit:wght@200;300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="stela.css" />
  </head>
  <body>
    <?php  

        $rota = "";

        if(isset($_SESSION['rota']))$rota = $_SESSION['rota'];
        

    ?>
    <!-- Header & Navigation -->
    <header class="header">
     <?php
        include "webesite2.php";
     ?>
     

    </header>

    <main>
          
          <?php 
              
            if(isset($_GET["rota"])){
                $rota =$_GET["rota"] ;
                
                switch($rota){
                    case"home":
                      include "./includes/clients/landingpage.php";
                    break;
                    case"produtos":
                      include "./shopping.php";
                    break;

                    default :
                      include "./includes/clients/landingpage.php";
                }
  
            }
           
            ?>
        </main>


    <!-- Footer -->
   <?php include "./includes/clients/footer.php"?>

    

    <script src="script.js?=123"></script>
  </body>
</html>