<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Vrai Oufo">

        <title><?= $title ?></title>
        <link rel="icon" sizes="192x192" href="public/img/vraioufo_favicon.png">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="public/css/style.css" />
        
        <script src="https://kit.fontawesome.com/d9058ae961.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        
    </head>
    <body>
        <div class="container">
            <header>
                <nav class="navbar navbar-light justify-content-between">
                    <a class="navbar-brand" href="index.php?action=homepage">
                        <h1 class="site-title">&iquest;VR&Eacute; &Ugrave; F&Ocirc;?</h1>
                        <small id="bobard">Bobard Land</small> 
                    </a>
                    <ul class="nav justify-content-end">
                            <?php if ($_SESSION)
                            {
                                if ($_SESSION['role'])
                                {
                            ?>
                                <li class="nav-item"><a class="nav-link" href="index.php?action=admin">Administration</a></li>
                            <?php
                                }
                            ?>
                                <li class="nav-item"><a class="nav-link" href="index.php?action=logout"><i class="fas fa-user-circle"></i> Se déconnecter</a></li>
                            <?php                       
                            }
                            else
                            {
                            ?>
                                <li class="nav-item"><a class="nav-link" href="index.php?action=connection">Se connecter</a></li>
                                <li class="nav-item"><a class="nav-link" href="index.php?action=subscription">S'inscrire</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                </nav>
            </header>
        </div>
        <div class="container">
            <div class="row">
                <div class="row">
                    <?php if (isset($message[0]))
                    {
                    ?>
                        <div class="col-12">
                            <div class="text-danger"><?= $message[0] ?></div>
                        </div>
                    <?php
                    }
                    if (isset($message[1]))
                    {
                    ?>
                        <div class="col-12">
                            <div class="text-success"><?= $message[1] ?></div>
                        </div>
                    <?php
                    }
                    if (isset($message[2]))
                    {
                    ?>
                        <div class="col-12">
                            <div class="text-warning"><?= $message[2] ?></div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?= $content ?>
        </div>
        <footer>
            <div class="col-2 offset-10">
            <a href=""><i class="fas fa-angle-double-up fa-2x"></i></a>
            </div>
            
        </footer>
    </body>
</html>