<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Vré ù Fô">
        <meta name="keywords" content="Vré ù Fô, Vrai ou Faux, Vrai, Faux, Deviner, Voter, Blague, Humour, Drôle, Articles à thèmes" />

        <title><?= $title ?></title>
        <link rel="icon" sizes="192x192" href="public/img/vreufo_favicon.png">
        
        <!-- Bootstrap 4.5.3 modifié pour passer la validation CSS -->
        <link type="text/css" rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="public/css/style.css" />
        
        <script src="https://kit.fontawesome.com/d9058ae961.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        
    </head>
    <body id="top">
        <header class="menu">
            <nav class="navbar navbar-expand-md navbar-light fixed-top menu">
                <a class="navbar-brand mr-auto" href="index.php?action=homepage">
                    <h1 class="site-title text-uppercase">&iquest;Vé ù Fô?</h1>
                    <small class="site-subtitle">La vie n'aura plus aucun secret pour vous ! Votez !</small> 
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <ul class="connect-subscr">
                                <li>
                                    <a class="nav-link text-uppercase" href="index.php?action=logout">Se déconnecter</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php?action=homepage">RETOUR AU SITE</a>
                                </li>
                            </ul>                                
                        </li>                               
                    </ul>
                </div>
            </nav>                   
        </header>
        <?php if (isset($message[0])): ?>
            <div class="alert-danger text-center"><?= $message[0] ?></div>
        <?php endif;
        if (isset($message[1])): ?>
            <div class="alert-success text-center"><?= $message[1] ?></div>
        <?php endif ?>

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