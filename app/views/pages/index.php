<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">

    <div id="main-card" class="card">
        <div class="card-content grey white-text">
            <h1><strong><?php echo $data['title']; ?><strong></h1>
            <p><?php echo $data['description']; ?></p>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>