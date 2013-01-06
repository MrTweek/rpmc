<?php

$query = urlencode($_GET['query']);

$f = file_get_contents("https://gdata.youtube.com/feeds/api/videos?q=$query&max-results=50&v=2&alt=json");

$data = json_decode($f);

?>
<html>
    <head>
       <title>Himbeerchen</title> 
       <link rel='stylesheet' href='main.css' type='text/css' />
    </head>
    <body>
        <form action='<?= $_SERVER['PHP_SELF'] ?>' method='GET'>
            <input type='text' name='query' />
            <input type='submit' value='Search' />
        </form>

<?php foreach ($data->feed->entry as $e): ?>
        <div class='ytitem'>
            <a href="/?youtube=<?= urlencode($e->content->src) ?>">
                <img src='<?= $e->{'media$group'}->{'media$thumbnail'}[1]->url ?>' style='float:left;' />
                <h3><?= $e->title->{'$t'} ?></h3>
                <?= $e->{'media$group'}->{'media$thumbnail'}[0]->time ?><br />
            </a>
        </div>
<?php endforeach; ?>
    </body>
</html>
