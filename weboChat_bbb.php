<?php

/*****************
 * Initialisatie *
 *****************/
$_srv = $_SERVER['PHP_SELF']; 
$_loc= setlocale(LC_ALL, 'nl_NL'); //maand en dag in het Nederlands
$_output = "";
$_formulier= "";
$_chat= "";
$_teller= "";
$_copyR = "";


//********* copyricht (JavaScript) --> $_copy ********** 
$_copyR = "
<script>
    nu = new Date();
    copyright_string = '&copy; ' + nu.getFullYear() +' webontwikkeling.info';
    document.write(copyright_string);
    </script>";


/*********** $_output (client-side) **********
* chat formulier
* horizontale lijn (<hr>)
* teller
* horizontale lijn (<hr>)
* Commentaren
* horizontale lijn (<hr>)
**********************************************/
// HTML content met $_formulier, $_commentaar, $_teller en $_copyR 
$_output= "
<header>
  <h1>WEBO chat</h1
</header>

<main>
  <section id=form>
    <strong>formulier</strong>
    $_formulier
    <hr>
  </section

  <section id=teller>
    <p><strong>Teller</strong> Het aantal bezoekers tot nu is $_teller</p>
    <hr>
  </section>

  <section id=chat>
    <strong>Chats</strong>
    $_chat
    <hr>
  </section>
</main> 

<footer>
  $_copyR
    <hr>
</footer>";


/*****************
 *   output      *
 *****************/

echo($_output);
?>