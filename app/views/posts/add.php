<?php require APPROOT . '/views/inc/header.php'; ?>

        <div class="container">
        <!-- back button -->
        <a href="<?php echo URLROOT; ?>/posts" class="btn white black-text"><i class="material-icons left">arrow_back</i>Retour</a>
        <div class="card">
            <div class="card-content">
                <h2>Ajouter un projet</h2>
                <p>Veuillez remplir le formulaire pour ajouter votre projet</p>
                <form action="<?php echo URLROOT; ?>/posts/add" method="post">
                    <div class="row">
                        <!-- NAME -->
                        <div class="input-field col m6">
                            <input type="text" name="title" id="title" class="<?php echo !empty($data['title_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                            <label for="title">Nom du projet<sup>*</sup></label>
                            <span class="helper-text" data-error="<?php echo $data['title_err']; ?>"></span>
                        </div>
                        <!-- CATEGORY -->
                        <div class="input-field col m6">
                            <select name="categorie">
                                <option value="0" style="color: red">Catégorie</option>
                                <?php foreach ($data['categories'] as $categorie) : ?>
                                    <option value="<?php echo $categorie->id; ?>"><?php echo $categorie->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- BODY -->
                    <div class="input-field">
                        <textarea name="body" id="body" class="<?php echo !empty($data['body_err']) ? 'invalid' : '' ?> materialize-textarea"></textarea>
                        <label for="body">Une courte description de votre projet<sup>*</sup></label>
                        <span class="helper-text" data-error="<?php echo $data['body_err']; ?>"></span>
                    </div>
                    <!-- CONTENT -->
                    <div class="input-field">
                        <textarea name="content" id="content" height="10" class="<?php echo !empty($data['content_err']) ? 'invalid' : '' ?> materialize-textarea"></textarea>
                        <label for="content">Écrivez votre code ici<sup>*</sup></label>
                        <span class="helper-text" data-error="<?php echo $data['content_err']; ?>"></span>
                    </div>
                    <button class="btn black waves-effect waves-light">Ajouter</button>
                </form>
            </div>
        </div>
        </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>