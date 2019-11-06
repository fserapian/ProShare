<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col m6 offset-m3">
        <!-- flash messages -->
        <?php flash('message'); ?>
        <?php flash('upload_message'); ?>
        <div class="card">
            <div class="card-content">
                <!-- change parameters -->
                <h2>Paramètres</h2>
                <form action="<?php echo URLROOT; ?>/users/settings" method="post">
                    <div class="row">
                        <div class="input-field col m6">
                            <input type="text" name="firstName" id="firstName" class="<?php echo !empty($data['first_name_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['fName']; ?>">
                            <label for="firstName">Prénom<sup>*</sup></label>
                            <span class="helper-text" data-error="<?php echo $data['first_name_err']; ?>"></span>
                        </div>
                        <div class="input-field col m6">
                            <input type="text" name="lastName" id="lastName" class="<?php echo !empty($data['last_name_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['lName']; ?>">
                            <label for="lastName">Nom<sup>*</sup></label>
                            <span class="helper-text" data-error="<?php echo $data['last_name_err']; ?>"></span>
                        </div>
                    </div>
                    <div class="input-field">
                        <input type="email" id="email" name="email" class="<?php echo !empty($data['email_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['email'] ?>">
                        <label for="email">Email<sup>*</sup></label>
                        <span class="helper-text" data-error="<?php echo $data['email_err']; ?>"></span>
                    </div>
                    <div class="row">
                        <div class="input-field col m6">
                            <input type="password" id="password" name="password" autocomplete="new-password" class="<?php echo !empty($data['password_err']) ? 'invalid' : ''; ?>" value="">
                            <label for="password">Mot de passe<sup>*</sup></label>
                            <span class="helper-text" data-error="<?php echo $data['password_err']; ?>"></span>
                        </div>
                        <div class="input-field col m6">
                            <input type="password" id="confirmPassword" name="confirmPassword" class="<?php echo !empty($data['confirm_password_err']) ? 'invalid' : ''; ?>" value="">
                            <label for="confirmPassword">Confirmez le mot de passe<sup>*</sup></label>
                        </div>
                    </div>
                    <?php if ($_SESSION['level'] != $data['level']) : ?>
                        <div class="input-field col s12">
                            <select id="level" name="level">
                                <option value="1" <?php if ($data['level'] == 1) : ?> selected <?php endif; ?>>Utilisateur</option>
                                <option value="2" <?php if ($data['level'] == 2) : ?> selected <?php endif; ?>>Modérateur</option>
                            </select>
                            <label>Sélectionnez le niveau d'accès de l'utilisateur</label>
                        </div>
                    <?php else : ?>
                        <input type="hidden" id="level" name="level" value="<?php echo $data['level'] ?>">
                    <?php endif; ?><br>
                    <div class="row">
                        <button type="submit" class="btn black waves-effect waves-light" formaction="<?php echo URLROOT; ?>/users/settings/<?php echo $data['id']; ?>">Sauvegarder</button>
                    </div>
                </form>
                <br><br>
                <!-- upload profile pic form -->
                <h5>Changer l'image de profil</h5><br>
                <div class="row">
                    <div class="col s4 center">
                        <?php if (!empty($data['image'])) : ?>
                            <img class="profPic" src="<?php echo URLROOT; ?>/img/<?php echo $data['image']; ?>">
                            <small class="light">Image de profil présente</small>
                        <?php else : ?>
                            <span class="light">Pas d'image <?php echo $data['image'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="col s8">
                        <div class="bottomtext">
                            <form action="<?php echo URLROOT ?>/users/upload/<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data">
                                <div class="file-field input-field">
                                    <div class="btn white black-text">
                                        <span>Parcourir</span>
                                        <input type="file" name="file">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" name="text">
                                    </div>
                                </div>
                                <button type="submit" class="btn black waves-effect waves-light" name="upload">Téléverser</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>