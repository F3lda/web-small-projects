<? 
   $emailadr = "fhgh@email.cz";            
   $predmet = "P�ikoupen� 1 m�s�c";         
   $odKoho = "fhgh@email.cz";                              
 
    $zprava = "Jm�no: ".$_POST['jmeno']."
";            
   
 
if (Mail($emailadr,$predmet,$zprava,"From: $odKoho
\r\n
Reply-To: $odKoho")) { 
 
   require "prikoupeni.html";
 
  }
  else
  {
  echo "Nepoda�ilo se ti p�ikoupit 1 m�s�c!";
  }
 
?>