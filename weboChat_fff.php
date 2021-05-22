<?php

/*****************
 * Initialisatie *
 *****************/
$_srv = $_SERVER['PHP_SELF']; 
$_loc= setlocale(LC_ALL, 'nl_NL'); //maand en dag in het Nederlands
$_output = "";

/*****************
 * Verwerking    *
 *****************/

if (isset($_POST['submit']))
{
	//********* Formlulier verwerking **********  
	// nieuwe entry in het gastenboek copiëren in lokale variabele
	$_gast = $_POST['gast'];
	// vervang alle & door &#38
	$_gast = str_replace('&', '&#38', $_gast);
	// vervang alle comma's door &#44
	$_gast = str_replace(',', '&#44', $_gast);

	$_tekst = $_POST['tekst'];
	// vervang alle & door &#38
	$_tekst = str_replace('&', '&#38', $_tekst);
	// vervang alle comma's door &#44
	$_tekst = str_replace(',', '&#44', $_tekst);


	//-----voorbereiding  wegschrijven gegevens------  
	/*
  we kunnen enkel 'arrays' wegschrijven naar een csv
  daarom copieren we hieronder de losse variabelen naar de array $_record
*/
	$_record[0] = $_gast;
	$_record[1] = $_tekst;
	$_record[2] = time(); // timestamp


	//------wegschrijven gegevens---------
	// open file  
	$_pointer = fopen('chat.csv','a+b') or die("File open error"); 
	// schrijf $_record naar file
	fputcsv($_pointer,$_record); 
	//sluit file
	fclose($_pointer);
}

//********* chats uitlezen --> $_chat **********  
// initialisatie
$_chat ="";

//------uitlezen  gegevens---------
// open file
$_pointer = fopen("chat.csv","rb") 
	or 
	die("error");

// lees alle records/lijnen --> tot end-of-file (feof)
while(! feof($_pointer)) 
{
	// zet de geleven array (fgetcsv) om naar inidividuele variabelen

	list($_gast, $_tekst, $_timestamp) = fgetcsv($_pointer);

	// voer $_gast,$_tekst,$_tijd toe aan het $_chat maar zorg er voor dat het laatste bericht eerst staat"
	if(! feof($_pointer)) // laatste lijn !!!!
	{
		//timestamp verwerken
		$_tijd = strftime("%A %d %B %Y - %H:%M:%S",$_timestamp);

		$_chat = "\n<p><strong>$_gast</strong><br>$_tekst<br><em>$_tijd</em></p><hr>$_chat";
	}
}
// sluit file
fclose($_pointer);

 
//********* bezoekers teller --> $_teller  ********** 
// 1 --> open file  
$_pointer = fopen('teller.txt','r+b') 
	or
	die('file niet geopend');

// 2 --> lees teller
$_teller = fread($_pointer,255);

// 3 --> verhoog teller
$_teller = $_teller +1;

// 4 --> rewind
rewind($_pointer);

// 5 --> schrijf (verhoogde) teller terug in file
fwrite($_pointer,$_teller);

// 6--> sluit file
fclose($_pointer);
		 
// 7 --> toon (verhoogde) teller --> $_teller naar $_output


//********* chat formulier --> $_formulier **********  
// formulier wordt ALTIJD getoond
$_formulier = "
<form method='post' action=' $_srv'>
  <label>Uw naam:</label> &nbsp;&nbsp;&nbsp;
    <input type='text' name='gast' />
  <br>
  <label>Uw boodschap</label>
	<br>
    <textarea name='tekst' cols='81' rows='5'></textarea>
  <br>
  <input type='submit' name='submit'  value='Verzenden' />
</form>";

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