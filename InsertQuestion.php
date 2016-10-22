<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Sartu galdera</title>
    <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel='stylesheet' type='text/css' href='stylesPWS/signIn.css' />
  </head>
  <body>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>
 
	<div class='login'>
		<div class="login-header2">
			<h1>Sartu Galdera</h1>
		</div>
	

		<form id="galdera_sartu" name="galdera_sartu" method="POST" action="InsertQuestion.php" enctype="multipart/form-data">
			<div class="login-form">
				<h3>Galdera:</h3> 
  				<input type="text" name="galdera" title="Sartu zure galdera." placeholder="Sartu zure galdera" required><br>
				<h3>Erantzuna:</h3>
 				<input type="text" name="erantzuna" title="Sartu galderaren erantzuna." placeholder="Sartu galderaren erantzuna" required><br>
 				<h3>Arloa:</h3>
 				<input type="text" name="arloa" title="Sartu galderaren arloa." placeholder="Sartu galderaren arloa"><br>
				<h3>Zailtasuna:</h3>
 				<select id="zail" name="zailtasuna" >
  					<option value="1">1 - Oso erraza</option>
  					<option value="2">2 - Erraza</option>
  					<option value="3">3 - Erdibidekoa</option>
  					<option value="4">4 - Zaila</option>
					<option value="5">5 - Oso zaila</option>
				</select><br>
				<input type="submit" name="button" value="Bidali">
				<a class="no-access" href="layout.php">Hasiera</a>
			</div>
		</form> 
	</div>
	  
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
	
	
	<footer class='footer' id='f1'>
		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
		<a href='https://github.com/berrio86/wsGit16'><img style="width:3%" src="irudiak/github-icon.png"></a>
	</footer>

	</body>
</html>

<?php 
if(isset($_POST['galdera']) && isset($_POST['erantzuna'])){
	include 'dbkonexioak/dbOpen.php';
	session_start();
	$eposta=$_SESSION['eposta'];
	
	if($_SERVER['REQUEST_METHOD'] == 'GET')  { //get eskaera landu
		null;
	} else { //post eskaera landu	
		$galdera= $_POST['galdera'];
		$erantzuna= $_POST['erantzuna'];
		$arloa= $_POST['arloa'];
		$zailtasuna= $_POST['zailtasuna'];
	}
	
	
	if(($galdera=="")||($erantzuna=="")||($arloa=="")){
		echo("<div class='error-page'>
				<div class='try-again'>
					Mesedez bete galderak modu egokian.</br>
					Errorea: Saiatu berriro?
				</div>
		</div>
		<script src='js/signIn.js'></script>");
	}else{
		$sartu = "INSERT INTO quiz (egilePosta, galderaTestua, erantzunTestua, zailtasuna, galderaArloa) VALUES ('{$eposta}', '{$galdera}', '{$erantzuna}', '{$zailtasuna}', '{$arloa}')";
		$emaitza=$db->query($sartu);
		if($emaitza){
			echo("<div class='message'>");
			echo $eposta;
			$konexioid = $_SESSION['konexioid'];
			//honekl ip-a bilatuko du toki egokienean nonbaiten ez badago
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    			$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
    			$ip = $_SERVER['REMOTE_ADDR'];
			}
			$ekintza = "galdera txertatu";
			date_default_timezone_set('Europe/Madrid');
			$data = date(DATE_RSS, time());
			$sqlekintza="INSERT INTO ekintzak(konexioa, postaElektronikoa, ekintzaMota, ekintzaData, IP) VALUES ('$konexioid', '$eposta', '$ekintza', '$data', '$ip')";
			$emaitza=$db->query($sqlekintza);
			if(!$emaitza) {
				echo("Errore bat egon da ekintza gehitzean: ".$db->error);
			}

			//sartu baita ere erantzuna xml fitxategian
			$xml = new DOMDocument('1.0',"UTF-8");
			$xml->load('xml/galderak.xml') or die("Ezin izan da xml-a kargatu");
			$root = $xml->documentElement;
			$assessmentItem = $xml->createElement('assessmentItem');

			$atrZailtasuna = $xml->createAttribute("complexity");
			$atrZailtasuna->value=$zailtasuna;
			$assessmentItem->appendChild($atrZailtasuna);

			$atrArloa = $xml->createAttribute("subject");
			$atrArloa->value=$arloa;
			$assessmentItem->appendChild($atrArloa);
			
			$itemBody=$xml->createElement('itemBody');
			$p=$xml->createElement('p',$galdera);
			$itemBody->appendChild($p);
			
			$correctResponse=$xml->createElement('correctResponse');
			$value=$xml->createElement('value',$erantzuna);
			$correctResponse->appendChild($value);
			
				
			$assessmentItem->appendChild($itemBody);
			$assessmentItem->appendChild($correctResponse);

			$root->appendChild($assessmentItem);
			$xml->appendChild($root);
		
			echo("<div class='message'>
					Zure eposta: ".$eposta."</br>
					Zure galdera: ".$galdera."</br>
					Zure erantzuna: ".$erantzuna."</br>
					Galdera arloa: ".$arloa."</br>
					Zailtasun maila: ".$zailtasuna."</br>
					Zure galdera egoki sartu da. Sartu beste bat nahi izanez gero. </br>"); 
				echo("XML fitxategian gorde da: ".$xml->save('xml/galderak.xml')."</br>"); 
				echo("XML fitxategia bistaratu nahi baduzu sakatu hurrengo esteka: <a href='seeXMLQuestions.php'> XML galderak ikusi </a>");	 
				echo("</div>");
		}else{
			echo("<div class='error-page'>
				<div class='try-again'>
					Errore bat egon da galdera gehitzean: ".$db->error."</br>
					Errorea: Saiatu berriro?
				</div>
				</div>
				<script src='js/signIn.js'></script>");
		}	
	}
	
	include 'dbkonexioak/dbClose.php';
}

?>
