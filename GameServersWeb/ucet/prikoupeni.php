<? 
   $emailadr = "fhgh@email.cz";            
   $predmet = "Pøikoupení 1 mìsíc";         
   $odKoho = "fhgh@email.cz";                              
 
    $zprava = "Jméno: ".$_POST['jmeno']."
";            
   
 
if (Mail($emailadr,$predmet,$zprava,"From: $odKoho
\r\n
Reply-To: $odKoho")) { 
 
   require "prikoupeni.html";
 
  }
  else
  {
  echo "Nepodaøilo se ti pøikoupit 1 mìsíc!";
  }
 
?>