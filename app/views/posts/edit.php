<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <!-- back button -->
    <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['id']; ?>" class="btn white black-text"><i class="material-icons left">arrow_back</i>Retour</a>
    <div class="card">
        <div class="card-content">
            <h2>Modifier un projet</h2>
            <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="post">
                <div class="row">
                    <!-- NAME -->
                    <div class="input-field col m6">
                        <input type="text" name="title" id="title" class="<?php echo !empty($data['title_err']) ? 'invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                        <label for="title">Le nom de votre projet<sup>*</sup></label>
                        <span class="helper-text" data-error="<?php echo $data['title_err']; ?>"></span>
                    </div>
                    <!-- CATEGORY -->
                    <div class="input-field col m6">
                        <select name="categorie">
                            <?php print_r($data['categories']); ?>
                            <?php foreach ($data['categories'] as $categorie) : ?>
                                <?php if ($categorie->id == $data['categorie']) : ?>
                                    <option value="<?php echo $categorie->id; ?>" selected><?php echo $categorie->name; ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $categorie->id; ?>"><?php echo $categorie->name; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <label>Choisissez la cat&eacute;gorie de votre projet</label>
                    </div>
                </div>
                <!-- BODY -->
                <div class="input-field">
                    <textarea name="body" id="body" class="<?php echo !empty($data['body_err']) ? 'invalid' : '' ?> materialize-textarea"><?php echo $data['body']; ?></textarea>
                    <label for="body">Une courte description de votre projet<sup>*</sup></label>
                    <span class="helper-text" data-error="<?php echo $data['body_err']; ?>"></span>
                </div>
                <!-- CONTENT -->
                <div class="input-field">
                    <textarea name="content" id="content" height="10" class="<?php echo !empty($data['content_err']) ? 'invalid' : '' ?> materialize-textarea"><?php echo $data['content']; ?></textarea>
                    <label for="content">Écrivez votre code ici<sup>*</sup></label>
                    <span class="helper-text" data-error="<?php echo $data['content_err']; ?>"></span>
                </div>
                <input type="submit" value="Modifier" class="btn black">
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>