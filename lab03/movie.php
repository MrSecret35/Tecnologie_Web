<!--File realizzato da
	Giorgio Mecca
	Mat: 880847
-->
<!-- File contenente la struttura html/codice php di una pagina con descrizione\recensioni di un film

-->
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Rancid Tomatoes</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="movie.css" type="text/css" rel="stylesheet">
		<link href="http://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rotten.gif" type="image/gif" rel="shortcut icon">
	</head>

	<body>
		<?php
            $_FILENAME= $_GET["film"];	//ottengo il nome della directory contenente i file del fil sccelto
            $path= $_FILENAME. "\info.txt"; // creo il path delle info del film scelto 
            $_INFO= file_get_contents($path);
            $info = explode("\n",$_INFO);
            $info = array("titolo" => trim($info[0]), "anno" => trim($info[1]), "perc" => trim($info[2]));
        ?>
		<div  class="banner">
			<img class="bannerP" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/banner.png" alt="Rancid Tomatoes">
		</div>

		<h1 id="hPrincipale" ><?= $info["titolo"]?> (<?= $info["anno"]?>)</h1>

		<div class="pBlock">
			<div class="GeneralO">
				
				<div>
					<img src="<?= $_FILENAME?>/overview.png" alt="general overview">
                </div>
                
                <?php
                    $overview = explode("\n", file_get_contents($_FILENAME. "\overview.txt")); //ottengo i dati delle overview
                ?>
				<dl>
                    <?php
                        foreach($overview as $row){
                            $row= explode(":", $row);
                    ?>
					<dt><?= trim($row[0]) ?></dt>
                    <dd><?= trim($row[1]) ?></dd>
                    
                    <?php
                        }
                    ?>
				</dl>
			</div>

			<div class="headerDiv" >
                <?php
                    if($info["perc"] > 60){
                ?>
                <img class="headerDivImg" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/freshbig.png" alt="Rotten">
                <?php
                    }else{
                ?>
                <img class="headerDivImg" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/rottenbig.png" alt="Rotten">
                <?php
                    }
                ?>
				<p id="headerText" ><?= $info["perc"]; ?>%</p> 
				
			</div>
			
			<div class="recensioni">
				<?php
					$nReview=0; //numero di recensioni
					$nTotR=0;
					foreach(glob($_FILENAME ."/*") as $nomefile){
						if(strpos($nomefile, "review") !== false){ $nTotR++; }}
 
				?>
				<div class="colonna">
					<?php
						foreach(glob($_FILENAME ."/*") as $nomefile){
							if(strpos($nomefile, "review") !== false){ //controllo se il file è una review
								$review= file_get_contents($nomefile);
								$review = explode("\n", $review);

								if($nReview < ceil($nTotR/2)){
					?>
					<div class="rec">
						<p class="critica">
							<?php
								if(trim($review[1]) == "ROTTEN"){
							?>
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/rotten.gif" alt="Rotten">
							<?php
								}else{
							?>
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/fresh.gif" alt="Fresh">
							<?php
								}
							?>
							<q><?= $review[0] ?></q>
						</p>
						<p class="autore">
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
							<?= $review[2] ?> <br>
							<?= $review[3] ?>
						</p>
					</div>
					<?php
						}$nReview++;}}
					?>
				</div>
				
				<div class="colonna">
					<?php
						$nReview=0;
						foreach(glob($_FILENAME ."/*") as $nomefile){
							if(strpos($nomefile, "review") !== false){ //controllo se il file è una review
								$review= file_get_contents($nomefile);
								$review = explode("\n", $review);

								if($nReview >= ceil($nTotR/2)){
					?>
					<div class="rec">
						<p class="critica">
							<?php
								if(trim($review[1]) == "ROTTEN"){
							?>
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/rotten.gif" alt="Rotten">
							<?php
								}else{
							?>
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/fresh.gif" alt="Fresh">
							<?php
								}
							?>
							<q><?= $review[0] ?></q>
						</p>
						<p class="autore">
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
							<?= $review[2] ?> <br>
							<?= $review[3] ?>
						</p>
					</div>
					<?php
						}$nReview++;}}
					?>
				</div>
				
			</div>
			<hr class="clean">
			<div class="footerDiv">
				<p>(1-<?= $nReview?>) of <?= $nReview?></p>
			</div>
			
		</div>
		<div class="footer">
			<a href="ttp://validator.w3.org/check/referer"><img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/w3c-xhtml.png" alt="Validate HTML"></a> <br>
			<a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"></a>
		</div>
	</body>
</html>
