<?php
session_start();?>
<html>
    <head>
        <title>
            Energy Advisor
        </title>
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">
                            Toggle navigation
                        </span>
                        <span class="icon-bar">
                        </span>
                        <span class="icon-bar">
                        </span>
                        <span class="icon-bar">
                        </span>
                    </button>
                    <a class="navbar-brand" href="index.php">
                        Energy Advisor
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="predictions.php">
                                Prediction
                            </a>
                        </li>
                        <li class="active">
                            <a href="settings.php">
                                Settings
                            </a>
                        </li>
                        <li>
                            <a href="mailto:ppe1535@gmail.com">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.nav-collapse -->
            </div>
        </nav>
        <div class="container">
            <div class = "page-header">
                <h1>
                    Settings
                </h1>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Define a new data provider
                    </h4>
                </div>
                <div class="panel-body">
                    <form action= "<?php downloader()?>" method="post">
                        <p>
                            Enter URL of data provider :
                            <input id="url" name="url"/>
                        </p>
                        <p>
                            Select date pattern (as written in the URL) :
                            <select name="select">
                                <option value="yyyy-mm-dd" selected>
                                    yyyy-mm-dd
                                </option>
                                <option value="yy-mm-dd" >
                                    yy-mm-dd
                                </option>
                                <option value="dd-mm-yyyy">
                                    dd-mm-yyyy
                                </option>
                            </select>
                        </p>
                        <p>
                            Enter begin date :
                            <input id="begin" name="begin" value="2016-01-01"/>
                        </p>
                        <p>
                            Enter end date :
                            <input id="end" name="end" value="2016-01-10"/>
                        </p>
                        <p>
                            <input type="submit" value="Analyse"/>
                        </p>
                    </form>
                    <em>
                        This will later ask you to select data fields in raw file, and our algorithm will automatically load datas from this provider
                    </em>
                </div>



            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Or upload raw file to be analysed and added to our system
                    </h4>
                </div>
                <div class="panel-body">

                    <form enctype="multipart/form-data" action="<?php uploader()?>" method="post">
                            <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
                            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                            <!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
                            Path of your file: <input type="file" name="userfile" id="userfile" /><br>
                            <input type="submit" value="Upload" name="submit" />
                    </form>


                </div>

            <?php
if (isset($_SESSION['return'])) {
	//echo $_SESSION['return'] . "<br/>";

	if ($_SESSION['return']['validate']) {
		echo "File downloaded";
	} else {
		echo "There was a problem during the download";
	}

}
?>
        </body>
        <?php
function patternRecognition($url, $begin, $end, $pattern) {
	//CHECK http://php.net/manual/fr/function.substr.php
	$pos1 = strpos($url, $begin);
	$final1 = substr($url, 0, $pos1); //FINAL1 OK
	$tmp1 = substr($url, -(strlen($url) - $pos1)); //TMP1 OK
	$pos2 = strpos($tmp1, $end);
	$tmp2 = substr($tmp1, 0, $pos2);
	$tmp3 = substr($tmp1, -(strlen($tmp1) - $pos2));
	$final2 = substr($tmp2, -(strlen($tmp2) - strlen($pattern)));
	$final3 = substr($tmp3, -(strlen($tmp3) - strlen($pattern)));
	$stored = array($final1, $final2, $final3, $pattern);
	return $stored;
}
//http://www.smart.grtgaz.com/api/v1/fr/consommation/export/Zone.csv?startDate=2016-01-01&endDate=2016-01-10&range=daily
function downloader() {
	set_time_limit(60);
	//url will be replaced. At the end : we will store "fragments" of this url and the date pattern, and our server will automatically download datas and store them with the correct format
	$destination = 'file.csv';
	$urlpieces = patternRecognition($_POST['url'], $_POST['begin'], $_POST['end'], $_POST['select']);
	$_SESSION['return'] = $urlpieces[0] . $_POST['begin'] . $urlpieces[1] . $_POST['end'] . $urlpieces[2];
	$_SESSION['fragments'] = $urlpieces;
	$url = $_SESSION['return'];
	$file = fopen($url, "rb");
	if ($file) {
		$newf = fopen($destination, "wb");
	}
	if ($newf) {
		while (!feof($file)) {
			fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
		}
	}
}

function uploader() {
	$uploadfile = "script.m";

	if (isset($_POST['submit'])) {

		if (file_exists($uploadfile) || $_FILES["userfile"]["size"] > 500000) {
			$_SESSION['return']['validate'] = false;
		}

		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			$_SESSION['return']['validate'] = true;
		} else {
			$_SESSION['return']['validate'] = false;
		}

	}

}
?>
    </html>
