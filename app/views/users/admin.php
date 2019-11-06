<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col m10 offset-m1">
        <table>
            <thead>
                <tr>
                    <th>Pr&eacute;nom</th>
                    <th>Nom</th>
                    <th>Courriel</th>
                    <th>Niveau de l'utilisateur</th>
                    <th>Nombre de projets</th>
                    <th>Nombre de commentaires</th>
                    <th>Date de création</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data['users'] as $user) : ?>
                    <tr>
                        <td><?php echo $user->fName ?></td>
                        <td><?php echo $user->lName ?></td>
                        <td><?php echo $user->email ?></td>
                        <?php if ($user->level == 3) {
                                $level = 'Administrateur';
                            } elseif ($user->level == 2) {
                                $level = 'Mod&eacute;rateur';
                            } else {
                                $level = 'Utilisateur';
                            }  ?>
                        <td><?php echo $level ?></td>
                        <td><?php echo $user->countPosts ?></td>
                        <td><?php echo $user->countComments ?></td>
                        <td><?php echo $user->created ?></td>
                        <td><?php if (!($user->userId != $_SESSION['user_id'] && $user->level == 3)) : ?> <a href="<?php echo URLROOT; ?>/users/settings/<?php echo $user->userId; ?>"><i class="material-icons">edit</i></a> <?php endif; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>



<?php /*foreach($data['users'] as $user): ?>
        <p><?php print_r($user) ?></p>
    <?php endforeach; */ ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>