<?php
  header('Access-Control-Allow-Origin : http://localhost:8080');
  header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE');
  header('Access-Control-Allow-Headers : X-Requested-With, content-type');

  mysql_connect("localhost","root","root");
  mysql_select_db("react-website");


?>