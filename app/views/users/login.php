<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col m6 offset-m3">
        <!-- flash messages -->
        <?php flash('register_message'); ?>
        <?php flash('info_message'); ?>
        <div class="card">
            <div class="card-content">
                <h2>Connectez-vous</h2>
                <form action="<?php echo URLROOT; ?>/users/login" method="post">
                    <div class="input-field">
                        <input type="email" id="email" name="email" class="<?php echo !empty($data['email_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['email'] ?>">
                        <label for="email">Courriel<sup>*</sup></label>
                        <span class="helper-text" data-error="<?php echo $data['email_err']; ?>"></span>
                    </div>
                    <div class="input-field">
                        <input type="password" id="password" name="password" class="<?php echo !empty($data['password_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['password'] ?>">
                        <label for="password">Mot de passe<sup>*</sup></label>
                        <span class="helper-text" data-error="<?php echo $data['password_err']; ?>"></span>
                    </div>
                    <div class="row form-footer">
                        <button class="btn black waves-effect waves-light">Connexion</button>
                        <a class="shortcut-link" href="<?php echo URLROOT; ?>/users/register">Vous n'avez pas de compte? Inscrivez-vous! </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>