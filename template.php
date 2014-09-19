<!doctype html>

<html>
    <head>
        <title><?= $data->name ?> at Fake Social Network</title>
        <link rel="stylesheet" href="./social.css"/>
    </head>
<body>
    <div class="container">
        <div class="header">Web-crawling test site</div>
        <h1><?= $data->name ?></h1>
        <p class="birthday">Born: <?= $data->birthday ?></p>
        <p class="occupation">Occupation: <?= $data->occupation ?></p>
        <p class="wealth">Net worth: $<?= number_format($data->wealth, 0, '.', '\'') ?></p>
        <div class="friends">
            <h3>Friends: <?= count($data->friends) ?></h3>
            <?php foreach ($data->friends as $friend) : ?>
                <a href="./<?= $friend->url ?>.html"><?= $friend->name ?></a>
            <?php endforeach; ?>
        </div>
        <div class="wall">
            <h3>The Wall</h3>
            <?php foreach ($data->wall as $note) : ?>
                <div>
                    <a href="./<?= $note->url ?>.html"><?= $note->name ?></a><br/>
                    <span><?= $note->text ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="clear">&nbsp;</div>
        <div class="footer">Copyright info omitted</div>
    </div>
</body>
