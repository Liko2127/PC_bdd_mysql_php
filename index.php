<?php

session_start();

$serveur = $_SESSION["serveur"];
$utilisateur = $_SESSION["utilisateur"];
$motdepasse = $_SESSION["motdepasse"];
$base = $_SESSION["base"];
$table = $_SESSION["table"];

$connexion = false;
$connexion_base = false;

$message_connecter = "";
$message_alerte = "";

$redir_home = "<meta http-equiv='refresh' content='0; URL=./'>";

function set_height($str) {
	$ary = explode("\n", $str);
	$style = '';
	if(is_array($ary) && count($ary)>1) {
		$height = 20 * count($ary);
		$style=' style="height:'.$height.'px;" ';
	}
	return $style;
}

if($_GET["action"] == "deco") {
	$_SESSION["serveur"] = "";
	$_SESSION["utilisateur"] = "";
	$_SESSION["motdepasse"] = "";
	$_SESSION["base"] = "";
	$_SESSION["table"] = "";
	echo $redir_home;
	exit();
}

if($_POST["action"] == "log_un") {
	$post_serveur = $_POST["connec_serveur"];
	$post_utilisateur = $_POST["connec_user"];
	$post_motdepasse = $_POST["connec_mp"];

	$connexion = mysql_connect($post_serveur,$post_utilisateur,$post_motdepasse); 
	if(!$connexion) {
		$message_alerte = "Connexion impossible, vérifiez les informations ci-dessous."; 
	}
	else {
		$_SESSION["serveur"] = $post_serveur;
		$_SESSION["utilisateur"] = $post_utilisateur;
		$_SESSION["motdepasse"] = $post_motdepasse;
		
		$_SESSION["base"] = "";
		$_SESSION["table"] = "";
		
		echo $redir_home;
		exit();
	}	
}

if($_POST["action"] == "log_deux") {
	$base_select = $_POST["connec_base"];
	$connexion = mysql_connect($serveur,$utilisateur,$motdepasse);
	$connexion_base = mysql_select_db($base_select,$connexion); 
	if(!$connexion) {
		$message_alerte = "Connexion impossible, vérifiez les informations ci-dessous."; 
	}
	if(!$connexion_base) {
		$message_alerte = "Connexion à la base ".$base_select." impossible."; 
	}
	else {
		$_SESSION["base"] = $base_select;
		$_SESSION["table"] = "";			
		echo $redir_home;
		exit();
	}
}

if($_POST["action"] == "log_trois") {
	$table_select = $_POST["connec_table"];
	$connexion = mysql_connect($serveur,$utilisateur,$motdepasse);
	$connexion_base = mysql_select_db($base,$connexion); 
	if($connexion && $connexion_base) {
		$_SESSION["table"] = $table_select;		
		echo $redir_home;
		exit();
	}
}

if($serveur != "" && $utilisateur != "" && $motdepasse != "" && $base == "") {
	$connexion = mysql_connect($serveur,$utilisateur,$motdepasse);
	if($connexion) {
		$message_connecter = "Vous êtes connectez au serveur ".$serveur." - <a href='./?action=deco'>Me déconnecter de se serveur</a>";
	}
}
if($serveur != "" && $utilisateur != "" && $motdepasse != "" && $base != "") {
	$connexion = mysql_connect($serveur,$utilisateur,$motdepasse);
	if($connexion) {
		$connexion_base = mysql_select_db($base,$connexion);
		if(!$connexion_base) {
			$message_alerte = "Connexion à la base ".$base." impossible";
		}
		else {
			$message_connecter = "Vous êtes connectez au serveur ".$serveur." - <a href='./?action=deco'>Me déconnecter de se serveur</a>";
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
<style type="text/css">
HTML, BODY {
	margin: 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #505050;
	height: 100%;
}

A {
	color: #000;
}

INPUT, TEXTAREA, SELECT  {
	outline-color: #bd513e;
}
TEXTAREA {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	width: 99%;
	height: 200px;
	
}
.input_text {
	font-size: 14px;
	height: 29px;
	color: #666;
	outline: none;
	padding: 3px;
	border: 1px solid #D9D9D9!important;
	border-top: 1px solid silver!important;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	border-radius: 1px;
	-webkit-border-radius: 1px;
	-moz-border-radius: 1px;
	-o-transition: none;
	-webkit-transition: none;
	border-image: initial;
	margin: 0px;
}

.btn {
	color: #FFF;
	text-decoration: none;
	cursor: pointer;
	font-size: 11px;
	font-weight: bold;
	line-height: 27px;
	padding: 0 8px;
	margin: 0;
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
	outline: none;
	text-align: center;
	transition: all .218s;
	-moz-transition: all .218s;
	-moz-user-select: none;
	-o-transition: all .218s;
	-webkit-transition: all .218s;
	-webkit-user-select: none;
	display: inline-block;
	background-color: #D14836;
	background-image: -webkit-linear-gradient(top,#dd4b39,#d14836);
	background-image: -moz-linear-gradient(top,#dd4b39,#d14836);
	background-image: -ms-linear-gradient(top,#dd4b39,#d14836);
	background-image: -o-linear-gradient(top,#dd4b39,#d14836);
	background-image: linear-gradient(top,#dd4b39,#d14836);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#f5f5f5',EndColorStr='#f1f1f1');
	border: 1px solid transparent;
	border-image: initial;
	border-radius: 2px;
}
.btn:hover {
	background-color: #C53727;
	background-image: -webkit-linear-gradient(top,#dd4b39,#c53727);
	background-image: -moz-linear-gradient(top,#dd4b39,#c53727);
	background-image: -ms-linear-gradient(top,#dd4b39,#c53727);
	background-image: -o-linear-gradient(top,#dd4b39,#c53727);
	background-image: linear-gradient(top,#dd4b39,#c53727);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#dd4b39',EndColorStr='#c53727');
	border: 1px solid #B0281A;
	box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.btn:active {
	box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
	-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
	-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
}

.btn_gris {
	background: #F5F5F5;
	background-image: -webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));
	background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
	background-image: -moz-linear-gradient(top,#f5f5f5,#f1f1f1);
	background-image: -ms-linear-gradient(top,#f5f5f5,#f1f1f1);
	background-image: -o-linear-gradient(top,#f5f5f5,#f1f1f1);
	background-image: linear-gradient(top,#f5f5f5,#f1f1f1);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#f5f5f5',EndColorStr='#f1f1f1');
	border: 1px solid rgba(0, 0, 0, 0.1);
	color: #444;
}
.btn_gris:hover {
	background: #F8F8F8;
	background-image: -webkit-gradient(linear,left top,left bottom,from(#f8f8f8),to(#f1f1f1));
	background-image: -webkit-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image: -moz-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image: -ms-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image: -o-linear-gradient(top,#f8f8f8,#f1f1f1);
	background-image: linear-gradient(top,#f8f8f8,#f1f1f1);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#f8f8f8',EndColorStr='#f1f1f1');
	border: 1px solid #C6C6C6;
	box-shadow: 0 1px 1px rgba(0,0,0,0.1);
	color: #444;
}
.btn_gris:active {
	background: #EEE;
	background-image: -webkit-gradient(linear,left top,left bottom,from(#eeeeee),to(#e0e0e0));
	background-image: -webkit-linear-gradient(top,#eeeeee,#e0e0e0);
	background-image: -moz-linear-gradient(top,#eeeeee,#e0e0e0);
	background-image: -ms-linear-gradient(top,#eeeeee,#e0e0e0);
	background-image: -o-linear-gradient(top,#eeeeee,#e0e0e0);
	background-image: linear-gradient(top,#eeeeee,#e0e0e0);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#EEEEEE',EndColorStr='#E0E0E0');
	border: 1px solid #CCC;
	box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	color: #444;
}

.entete {
	height: 17px;
	background: #2D2D2D;
	color: #AAA;
	font-size: 13px;
	padding: 8px;
}
.entete A {
	font-weight: bold;
	color: #AAA;
	text-decoration: none;
}
.entete A:hover {
	color: #FFF;
}
.deco {
	position: absolute;
	right: 10px;
	top: 10px;
}

.menu {
	position: absolute;
	top: 33px;
	bottom: 0px;
	width: 200px;
	background: #EFEFEF;
	padding-top: 30px;
}
.menu A {
	display: block;
	padding: 6px 6px 6px 15px;
	text-decoration: none;
	font-weight: bold;
	font-size: 12px;
	color: #505050;
	margin-bottom: 10px;
	text-shadow: 1px 1px 1px #FFF;
}
.menu A:hover, .menu A.hover  {
	color: #DD4B39;
	background: #FFF;
}

.contenu {
	position: absolute;
	top: 33px;
	left: 231px;
	right: 0px;
	bottom: 0px;
	background: #FFF;
	padding: 30px 30px 0 30px;
	overflow: auto;
}

.message_connect {
	padding: 10px;
	border: solid 1px #029c1b;
	background: #dbffe1;
	margin-bottom: 10px;
}
.message_alerte {
	padding: 10px;
	border: solid 1px #cd0a0a;
	background: #f3d8d8;
	margin: 20px 0px;
	color: #000;
}

.contenu .liste TD {
	border-bottom: solid 1px #CCC;
	padding: 10px;
}
.contenu .liste .entete_table {
	border: solid 1px #CCC;
}
.contenu .liste .entete_table TD {
	padding: 10px;
	background: #EFEFEF;
	text-shadow: 1px 1px 1px #FFF;
	color: #505050;
}
.contenu .select_deselect {
	padding-bottom: 10px;
}
.contenu .btns_actions {
	padding: 10px 0;
}
.contenu .decal {
	margin-left: 30px;	
}

</style>
</head>

<body>

<div class="entete">
	<div class="deco">
    	
    </div>
    Générateur de requêtes MySQL PHP par Liko</div>

<div class="menu">
    <?php
		if(file_exists("./menu.php")) {
			include("./menu.php");
			echo $menu;
		}
		else {
			echo("<a href='./'>MYSQL > PHP</a>");
		}
	?>
</div>

<div class="contenu">

<?php

if($message_connecter != "") {
	echo("<div class='message_connect'>".$message_connecter."</div>");
}

if($message_alerte != "") {
	echo("<div class='message_alerte'>".$message_alerte."</div>");
}

if(!$connexion) {
	echo("<form method='post' action='./'>
		<input type='hidden' name='action' value='log_un' />
		<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"liste\" width=\"100%\">
			<tr class=\"entete_table\">
				<td width=\"100\">Serveur</td>
				<td>
					<input type=\"text\" class=\"input_text\" name=\"connec_serveur\" style=\"width: 90%\" placeholder=\"Saisissez le serveur de base de donnée\" value=\"".$_POST["connec_serveur"]."\">
				</td>
			</tr>
			<tr class=\"entete_table\">
				<td width=\"100\">Utilisateur</td>
				<td>
					<input type=\"text\" class=\"input_text\" name=\"connec_user\" style=\"width: 90%\" placeholder=\"Saisissez le nom d'utilisateur MYSQL\" value=\"".$_POST["connec_user"]."\">
				</td>
			</tr>
			<tr class=\"entete_table\">
				<td width=\"100\">Mot de passe</td>
				<td>
					<input type=\"password\" class=\"input_text\" name=\"connec_mp\" style=\"width: 90%\" placeholder=\"Saisissez le mot de passe MYSQL\" value=\"".$_POST["connec_mp"]."\">
				</td>
			</tr>
			<tr class=\"entete_table\">
				<td colspan='2' align='center'>
					<input type='submit' class='btn' value='Valider' />
				</td>
			</tr>
		</table>
	</form>");
}
else {
	
	echo("<form method='post' action='./'>
		<input type='hidden' name='action' value='log_deux' />
		<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"liste\" width=\"100%\">
			<tr class=\"entete_table\">
				<td width=\"100\">Base de donnée</td>
				<td>
					<select class=\"input_text\" name=\"connec_base\" style=\"width: 90%\" onchange='submit();'>");
						if($base == "") {
							echo("<option value=''>Choisissez une base de donnée</option>");
						}
						$requete = mysql_query("SHOW DATABASES");
						while($ligne = mysql_fetch_assoc($requete)) {
							$base_dispo = $ligne['Database'];
							echo("<option value=\"".$base_dispo."\"");
							if($base_dispo == $base) {
								echo(" selected");
							}
							echo(">".$base_dispo."</option>");
						}
					echo("</select>
				</td>
			</tr>
		</table>
	</form>");
	
	if($connexion_base) {
		echo("<form method='post' action='./'>
			<input type='hidden' name='action' value='log_trois' />
			<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"liste\" width=\"100%\">
				<tr class=\"entete_table\">
					<td width=\"100\">Table</td>
					<td>
						<select class=\"input_text\" name=\"connec_table\" style=\"width: 90%\" onchange='submit();'>");
							if($table == "") {
								echo("<option value=''>Choisissez une table</option>");
							}
							$requete = mysql_query("SHOW TABLES FROM ".$base);
							while($ligne = mysql_fetch_row($requete)) {
								$table_dispo = $ligne[0];
								echo("<option value=\"".$table_dispo."\"");
								if($table_dispo == $table) {
									echo(" selected");
								}
								echo(">".$table_dispo."</option>");
							}
						echo("</select>
					</td>
				</tr>
			</table>
		</form>");
	}
	
	if($table != "") {
		$debug = "";
		if($_GET["option"][0] == "1") {
			$debug = " or die(mysql_error())";
		}
		
		$chs = $_GET['ch'];
		$requete = mysql_query("SHOW COLUMNS FROM ".$table);
		$combien_results = mysql_num_rows($requete);
		echo("<form method='GET' action='./#res'>
			<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"liste\" width=\"100%\">
				<tr class=\"entete_table\">
					<td width=\"100\" valign='top' style='padding-top: 10px;'>Champs</td>
					<td>
						<div class='select_deselect'>
							<a href='./?check=au'>Aucuns</a> - <a href='./?check=tt'>Tous</a> (".$combien_results.")
						</div>");
						if($combien_results > 0) {
							$cle = "";
							$i=0;
							while($ligne = mysql_fetch_assoc($requete)) {
								if($i == 0) {
									$cle = $ligne["Field"];
								}
								echo "<div>
									<label>
										<input type='checkbox' name='ch[]' value=\"".$ligne["Field"]."\"";
										if($_GET["check"] != "au") {
											if(@in_array($ligne["Field"], $chs) || $_GET["check"] == "tt") {
												echo " checked";
											}
										}
										echo " /> 
										<b>".$ligne["Field"]."</b> ".$ligne["Type"]."
									</label>
								</div>";
								$i++;
							}
						}
					echo("</td>
				</tr>
			</table>
			<a name='res'></a>
			<div class='btns_actions'>
				<input type='submit' name='action' value='SELECT *' class='btn btn_gris' />
				<input type='submit' name='action' value='SELECT' class='btn btn_gris' />
				<input type='submit' name='action' value='INSERT' class='btn btn_gris' />
				<input type='submit' name='action' value='UPDATE' class='btn btn_gris' />
				<input type='submit' name='action' value='INSERT OR UPDATE' class='btn btn_gris' />
				<label><input type='checkbox' name='option[]' value='1'");
				if($debug != "") {
					echo(" checked");
				}
				echo(" /> Debug</label>
			</div>
		</form>");
		
		if($_GET["action"] == "SELECT *") {
			$liste_ch_ligne = "";
			$hauteur = (count($chs) + 3) * 20;
			foreach($chs as $value) {
				$liste_ch_ligne .= "\t$".$value." = $"."ligne[\"".$value."\"];\n";
			}
			$html = "$"."requete = mysql_query(\"SELECT * FROM ".$table." WHERE ".$cle."=&#092;\"\".$".$cle.".\"&#092;\"\")".$debug.";\nwhile($"."ligne = mysql_fetch_array($"."requete)) {\n".$liste_ch_ligne."}";
			
			echo "<textarea style='height: ".$hauteur."px;'>".$html."</textarea>";
		}
		
		if($_GET["action"] == "SELECT") {
			$hauteur = (count($chs) + 3) * 20;
			$i = 0;
			$liste_ch = "";
			$liste_ch_ligne = "";
			foreach($chs as $value) {
				if($i > 0) {
					$liste_ch .= ",";
				}
				$liste_ch .= "`".$value."`";
				$liste_ch_ligne .= "\t$".$value." = $"."ligne[\"".$value."\"];\n";
				$i++;
			}
			$html = "$"."requete = mysql_query(\"SELECT ".$liste_ch." FROM ".$table." WHERE ".$cle."=&#092;\"\".$".$cle.".\"&#092;\"\")".$debug.";\nwhile($"."ligne = mysql_fetch_array($"."requete)) {\n".$liste_ch_ligne."}";
			
			echo "<textarea".set_height($html).">".$html."</textarea>";
		}
		
		if($_GET["action"] == "INSERT") {
			$i = 0;
			$liste_ch = "";
			$liste_ch_ligne = "";
			foreach($chs as $value) {
				if($i > 0) {
					$liste_ch .= ",";
					$liste_ch_ligne .= ",";
				}
				$liste_ch .= "`".$value."`";
				$liste_ch_ligne .= "&#092;\"\".$".$value.".\"&#092;\"";
				$i++;
			}
			$html = "$"."requete = mysql_query(\"INSERT INTO `".$table."` (".$liste_ch.") VALUES (".$liste_ch_ligne.")\")".$debug.";";
			
			echo "<textarea>".$html."</textarea>";
		}
		
		if($_GET["action"] == "UPDATE") {
			$i = 0;
			$liste_ch = "";
			$liste_ch_ligne = "";
			foreach($chs as $value) {
				if($i > 0) {
					$liste_ch .= ",";
				}
				$liste_ch .= "`".$value."`=&#092;\"\".$".$value.".\"&#092;\"";
				$i++;
			}
			$html = "$"."requete = mysql_query(\"UPDATE ".$table." SET ".$liste_ch." WHERE ".$cle."=&#092;\"\".$".$cle.".\"&#092;\"\")".$debug.";";
			
			echo "<textarea>".$html."</textarea>";
		}
		
		if($_GET["action"] == "INSERT OR UPDATE") {
			$i = 0;
			$liste_ch_up = "";
			$liste_ch = "";
			$liste_ch_ligne = "";
			foreach($chs as $value) {
				if($i > 0) {
					$liste_ch_up .= ",";
					$liste_ch .= ",";
					$liste_ch_ligne .= ",";
				}
				$liste_ch_up .= "`".$value."`=&#092;\"\".$".$value.".\"&#092;\"";
				$liste_ch .= "`".$value."`";
				$liste_ch_ligne .= "&#092;\"\".$".$value.".\"&#092;\"";
				$i++;
			}
			$html = "$"."requete = mysql_query(\"INSERT INTO `".$table."` (".$liste_ch.") VALUES (".$liste_ch_ligne.") ON DUPLICATE KEY UPDATE ".$liste_ch_up."\")".$debug.";";
			
			echo "<textarea>".$html."</textarea>";
		}
	}
	
}

?>

</div>

<div class="pied"></div>

</body>
</html>