<h1>Liste des posts</h1>
<?php foreach ($vars as $post) : ?>
<div>
    <h2><?= $post->getTitle() ?></h2>
    <h4><?= $post->getAuthor()->getLastName() ?></h4>
    <a href="/post?id="<?= $post->getId() ?>>En lire plus</a>
</div>
<?php endforeach; ?>
<?php
var_dump($vars);
