<?php
    function loginDB()
    {
       if (!($link=mysql_connect("localhost","root","root")))
       {
          echo "Error conectando a la base de datos.";
          exit();
       }
       if (!mysql_select_db("javier",$link))
       {
          echo "Error seleccionando la base de datos.";
          exit();
       }
       return $link;
    } 
?>
