<?php $title = 'Accueil'; ?>

<?php ob_start(); ?>

<div class="container content">
    <?php if ($_SESSION)
    {
    ?>
        <a href="index.php?action=addPost" class="btn btn-primary btn-lg active" role="button"><i class="fas fa-pen-nib"></i> Ajouter un article</a>
    <?php
    }
    ?>


        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-hover table-bordered categories_list">
                    <thead>
                        <tr>
                            <th colspan="2">
                                <div class="category">Les catégories</div>
                            </th>
                        </tr>
                    </thead>
            
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <th><a href="index.php?action=category&categoryId=<?= $category['id'] ?>"><?= $category['title'] ?></a></th>
                            <th><?= $category['description'] ?></th>
                        </tr>
                        <?php endforeach ?>  
                    </tbody>             
                </table>
            </div>
        </div>

 
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-hover table-bordered last_posts">
                    <thead>
                        <tr>
                            <th colspan="4">
                                <div class="category">Les derniers articles</div>
                            </th>
                        </tr>
                    </thead>
            
                    <tbody>
                        <tr>
                            <th></th>
                            <th>Catégorie</th>
                            <th>Créé par</th>
                            <th>Vrai oufo ?</th>
                        </tr>


                        <?php foreach ($posts as $post):

                            $tdClass = null;

                            if (!isset($_SESSION['id']))
                            {
                                $vraioufo = '<td><a href="index.php?action=connection">Voter</a></td>';
                            }
                            else
                            { 
                                $vote = null;
                                $tdClass = 'class="table-warning"';
                                switch($post['true_value'])
                                {
                                    case 0:
                                        $true_value = 'Faux';
                                    break;

                                    case 1:
                                        $true_value = 'Vrai';
                                    break;

                                    default: $true_value = null;
                                }

                                if ($post['user_id'] == $_SESSION['id'])
                                {
                                    $tdClass = 'class="table-primary"';
                                    $vraioufo = 
                                    '<td>
                                        <div>Mon post est : ' . $true_value . '</div>
                                    </td>';
                                }
                                elseif ($post['vote'] != null)
                                {
                                    switch($post['vote'])
                                    {
                                        case 0:
                                            $vote = 'Faux';
                                        break;

                                        case 1:
                                            $vote = 'Vrai';
                                        break;
                                    }

                                    if ($vote == $true_value)
                                    {
                                        $tdClass = 'class="table-success"';
                                    }
                                    else
                                    {
                                        $tdClass = 'class="table-danger"';
                                    }

                                    $vraioufo = 
                                        '<td>
                                            <div>Réponse : ' . $true_value . '</div>
                                            <div>J\'ai voté : ' . $vote . '</div>
                                        </td>';
                                }
                                else
                                {                           
                                    $vraioufo = 
                                    '<td>
                                        <div>
                                            <form action="index.php?action=vote&postId=' . $post['id'] . '" method="post">
                                                <button type="submit" name="vote" value="1"><i class="fas fa-check-circle"></i></button>
                                            </form>
                                            <form action="index.php?action=vote&postId=' . $post['id'] . '" method="post">
                                                <button type="submit" name="vote" value="0"><i class="fas fa-times-circle"></i></button>
                                            </form>
                                        </div>
                                    </td>';
                                }
                            }                        
                        ?>

                        <tr 
                            <?php if ($tdClass)
                            {
                                echo $tdClass;
                            }?> 
                        >
                            <td>
                                <div class="title"><i class="fas fa-comment"></i><?= htmlspecialchars($post['title']) ?></div>
                                <div><?= htmlspecialchars($post['content']) ?></div>
                            </td>
                            <td>
                                <div class="title"><a href="index.php?action=category&categoryId=<?= $post['category_id'] ?>"><?= htmlspecialchars($post['category_title']) ?></a></div>
                            </td>
                            <td>
                                <div><?= htmlspecialchars($post['pseudo']) ?>
                                <br /><small><?= date('d/m/Y à H:i', strtotime($post['created'])) ?></small>
                                </div>
                            </td>

                            <?= $vraioufo ?>
                        </tr>
                        <?php
                        endforeach
                        ?>
                    </tbody>             
                </table>
            </div>
        </div>
    </div>



<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>