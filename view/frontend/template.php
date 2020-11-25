<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Vré ù Fô">

        <title><?= $title ?></title>
        <link rel="icon" sizes="192x192" href="public/img/vreufo_favicon.png">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="public/css/style.css" />
        
        <script src="https://kit.fontawesome.com/d9058ae961.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        
    </head>
    <body id="top">
        
        <header class="menu">
            <nav class="navbar navbar-expand-md navbar-light fixed-top menu">
                <a class="navbar-brand mr-auto" href="index.php?action=homepage">
                    <h1 class="site-title">&iquest;VR&Eacute; &Ugrave; F&Ocirc;?</h1>
                    <small class="site-subtitle">La vie n'aura plus aucun secret pour vous ! Votez !</small> 
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <?php if ($_SESSION)
                            {
                            ?>
                                <li class="nav-item">
                                    <ul class="connect-subscr">
                                        <li>
                                            <a class="nav-link" href="index.php?action=logout">SE D&Eacute;CONNECTER</a>
                                        </li>
                                        <?php if ($_SESSION['role'])
                                            {
                                        ?>
                                            <li class="nav-item">
                                                <a class="nav-link" href="index.php?action=admin">ADMINISTRATION</a>
                                            </li>
                                        <?php
                                            } ?>
                                    </ul>                                
                                </li>
                            <?php                       
                            }
                            else
                            {
                            ?>
                                <li class="nav-item">
                                    <ul class="connect-subscr">
                                        <li>
                                            <a class="nav-link" href="index.php?action=connection">SE CONNECTER</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="index.php?action=subscription">S'INSCRIRE</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" target="_blank" href="https://www.youtube.com/watch?v=TkBLWgSOV18">PARTIR... VITE !</a>
                                        </li>
                                    </ul>                                
                                </li>
                            <?php
                            }
                        ?>
                        
                        
                    </ul>
                </div>
            </nav>                   
        </header>
        <?php if (isset($message[0]))
                {
                ?>
                    <div class="alert-danger text-center"><?= $message[0] ?></div>

                <?php
                }
                if (isset($message[1]))
                {
                ?>
                    <div class="alert-success text-center"><?= $message[1] ?></div>
                <?php
                }
        ?>

        <div class="container-fluid">
            <?= $content ?>   
        </div>    
        <footer>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <p class="text-center">Copyright 2020 &copy;BaronDeCarrese</p>
                    </div>
                </div>              
            </div>        
        </footer>     
    </body>
</html>