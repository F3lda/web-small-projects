<? 
   $emailadr = "fhgh@email.cz";            
   $predmet = "Registrace";         
   $odKoho = "fhgh@email.cz";                              
 
    $zprava = "Jméno: ".$_POST['jmeno']."
";            
    $zprava .= "Heslo: ".$_POST['heslo']."
";    
    $zprava .= "E-mail: ".$_POST['email']."
";    
    $zprava .= "Jméno ve hře Minecraft: ".$_POST['minecraft']."
";       
 
 
 
if (Mail($emailadr,$predmet,$zprava,"From: $odKoho
\r\n
Reply-To: $odKoho")) { 
 
   require "registrovan.html";
 
  }
  else
  {
  echo "Nepodařilo se ti zaregistrovat!";
  }
 
?>