<?php 

error_reporting(E_ALL);

include "config.inc.php";

if (isset($_GET['video'])) {
    file_put_contents('/tmp/play', ($videopath.'/'.basename(trim($_GET['video']))));
    chmod('/tmp/play', 666);
    header('Location: /');
    die();
}
if (isset($_GET['youtube'])) {
    file_put_contents('/tmp/youtube', trim($_GET['youtube']));
    chmod('/tmp/youtube', 666);
    header('Location: /');
    die();
}
if (isset($_GET['stop'])) {
    file_put_contents('/tmp/stop', 'stop');
    header('Location: /');
    die();
}

function n($s) {
    $s = preg_replace('!_!', ' ', $s);
    return $s;
}

if (file_exists('/tmp/tagesschau')) {
    $tagesschau = file('/tmp/tagesschau');
}

$list = scandir($videopath);

?><html>
    <head>
       <title>RPMC</title> 
       <link rel='stylesheet' href='main.css' type='text/css' />
    </head>
    <body style='background-image: url(raspberry.png)'>
        <h1>Raspberry Pi Media Centre</h2>
        <div class='windowcontent'>
        <div class='control'>
            <a href='/?stop'>STOP</a>
        </div>
        <br />
        <table>
        <form action='/' method='GET'>
            <tr>
                <td>Direct Video URL:</td>
                <td><input type='text' name='video' /></td>
                <td><input type='submit' value='Play' /></td>
            </tr>
        </form>
        <form action='/' method='GET'>
            <tr>
                <td>Youtube URL:</td>
                <td><input type='text' name='youtube' /></td>
                <td><input type='submit' value='Play' /></td>
            </tr>
        </form>
        <form action='/youtube.php' method='GET'>
            <tr>
                <td>
                    <a href='/youtube.php'>Youtube Suche</a>
                </td>
                <td><input type='text' name='query' /></td>
                <td><input type='submit' value='Suchen' /></td>
            </tr>
        </form>
        </table>
        <br />
<?php if (isset($tagesschau)): ?>
        <h2>Tagesschau</h2>
        <br />
        <a href='/?video=<?= urlencode($tagesschau[1]) ?>'><?= $tagesschau[0] ?></a>
        <br />
        <br />
<?php endif; ?>
        <div class='files'>
        <h2>Available files</h2>
<?php foreach ($list as $l) if ($l[0] != '.'): ?>
<?php if (preg_match('!\.part!', $l)): ?>
        <?= $l ?>
<?php else: ?>
        <a href='/?video=<?= urlencode($l) ?>'><?= n($l) ?></a>
<?php endif; ?>
<?php endif; ?>
        </div>
        </div>
    </body>
</html>
