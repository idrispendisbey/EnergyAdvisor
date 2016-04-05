<!DOCTYPE html>
<html>
    <head>
        <title>
            Energy Advisor
        </title>
        <link href="res/css/bootstrap.css" rel="stylesheet">
            <script src="res/js/jquery.js">
            </script>
            <script src="res/js/bootstrap.min.js">
            </script>
            <meta charset="utf-8">
            </meta>
        </link>
    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button aria-controls="navbar" aria-expanded="false" class="navbar-toggle collapsed" data-target="#navbar" data-toggle="collapse" type="button">
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
                <div class="navbar-collapse collapse" id="navbar">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="predictions.php">
                                Prédiction
                            </a>
                        </li>
                        <li>
                            <a href="historic.php">
                                Historique
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="settings.php">
                                Paramètres
                            </a>
                        </li>
                        <li>
                            <a href="team.php">
                                L'équipe
                            </a>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
          
          <?php
            if(isset($_POST['zone'])){ 

                $file = 'bin/iter.txt';
                $buffer = file_get_contents($file);
                $buffer = $_POST['zone'];
                file_put_contents($file, $buffer);

              ?>
        
              <div class="page-header"><h1>Paramètres</h1></div>

              <div class="container"><h2>Merci</h2>
              <p>Votre modification a bien été prise en compte et sera effective à la prochaine mise à jour.</p></div>
            <?php }

            else{
          ?>


          <div class="page-header"><h1>Paramètres</h1></div>
          
          <div class="container">
            
          <form action="settings.php" method="post">
          <fieldset class="form-group">
            
            <label for="exampleSelect1">Sélectionnez le nombre d'itérations à exécuter lors de la prochaine mise à jour</label>
            <select class="form-control" id="zone" name="zone">
              <option>2</option>
              <option>5</option>
              <option>10</option>
              <option>20</option>
              <option>100</option>
              <option>500</option>
            </select>
            </fieldset>

            <input type="submit" value="Valider" class="btn btn-primary">
        </form>

          </div>
          <?php } ?>
        </div>

        <div class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <p class="navbar-text pull-left">
                2016 - PPE 1535 - ECE Paris
            </p>
            <a href="https://github.com/EnergyAdvisorECE/EnergyAdvisor" class="navbar-btn btn-info btn pull-right">
                GitHub Repo
            </a>
        </div>
    </div>

    </body>
</html>
