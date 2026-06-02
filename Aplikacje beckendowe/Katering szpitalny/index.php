<?php
// plik kontaktu, wykrywa jeden z 2 możliwych stanów aplikacji 1 zalogowany , 2 nie zalogowany, dokonuje
// oceny na podstawie zmiennej sesyjnej ustawianej podczas procesu weryfikacji logowania użytkownika
session_start();

   if(!isset($_SESSION['logged_in_user_id'])){
      // dla nie zalogowanych przenosi na podstrone do logowania
      header('Location:window/login.php');
   }else if(isset($_SESSION['logged_in_user_id'])){
      // jeżeli użytkownik zalogowany przenosi na dashboard gdzie to bedzie głowny ośrodek nawigacyjny edycji danych
      header('Location:window/dashboard.php');
   }
   
?>