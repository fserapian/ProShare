<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col m6 offset-m3">
        <div class="card">
            <div class="card-content">

                <h2>Créer un compte</h2>
                <p class="mb-4">Veuillez remplir le formulaire pour vous cr&eacute;er un compte.</p>
                <form action="<?php echo URLROOT; ?>/users/register" method="post">
                    <div class="row squeeze">
                        <div class="input-field col m6">
                            <input type="text" name="firstName" id="firstName" class="<?php echo !empty($data['first_name_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['first_name']; ?>">
                            <label for="firstName">Prénom<sup>*</sup></label>
                            <span class="helper-text" data-error="<?php echo $data['first_name_err']; ?>"></span>
                        </div>
                        <div class="input-field col m6">
                            <input type="text" name="lastName" id="lastName" class="<?php echo !empty($data['last_name_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['last_name']; ?>">
                            <label for="lastName">Nom<sup>*</sup></label>
                            <span class="helper-text" data-error="<?php echo $data['last_name_err']; ?>"></span>
                        </div>
                    </div>
                    <div class="input-field">
                        <input type="email" name="email" id="email" class="<?php echo !empty($data['email_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['email'] ?>">
                        <label for="email">Email<sup>*</sup></label>
                        <span class="helper-text" data-error="<?php echo $data['email_err']; ?>"></span>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password" id="password" class="<?php echo !empty($data['password_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['password'] ?>">
                        <label for="password">Mot de passe<sup>*</sup></label>
                        <span class="helper-text" data-error="<?php echo $data['password_err']; ?>"></span>
                    </div>
                    <div class="input-field">
                        <input type="password" name="confirmPassword" id="confirmPassword" class="<?php echo !empty($data['confirm_password_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['confirm_password'] ?>">
                        <label for="confirmPassword">Confirmez le mot de passe<sup>*</sup></label>
                        <span class="helper-text" data-error="<?php echo $data['confirm_password_err']; ?>"></span>
                    </div>
                    <div class="row form-footer">
                        <button class="btn black white-text waves-effect waves-light">S'inscrire</button>
                        <a class="shortcut-link" href="<?php echo URLROOT; ?>/users/login">Vous avez déjà un compte? Connectez-vous!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>