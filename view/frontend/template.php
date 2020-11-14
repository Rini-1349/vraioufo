<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="https://kit.fontawesome.com/d9058ae961.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="public/css/bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="public/css/style.css" />
        <title><?= $title ?></title>
    </head>
    <body>
        <div class="container">
            <header>
                <nav class="navbar navbar-light justify-content-between">
                    <a class="navbar-brand" href="index.php?action=homepage">
                        <h1 class="site-title">VRAI OUFO</h1>
                        <small id="bobard">Bobard Land</small> 
                    </a>
                    <ul class="nav justify-content-end">
                            <?php if ($_SESSION)
                            {
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
                <div class="col-12">
                    <?php if (isset($error))
                    {
                    ?>
                        <div class="col-12 text-danger"><?= $error ?></div>
                    <?php
                    }
                    if (isset($success))
                    {
                    ?>
                        <div class="col-12 text-success"><?= $success ?></div>
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