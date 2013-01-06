<?php 

include "config.inc.php";

if (isset($_GET['video'])) {
    file_put_contents('/tmp/play', escapeshellarg($videopath.'/'.basename(trim($_GET['video']))));
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
        </table>
        <a href='/youtube.php'>Youtube Suche</a><br />
<?php if (isset($tagesschau)): ?>
        <h2>Tagesschau</h2>
        <a href='/?video=<?= urlencode($tagesschau[1]) ?>'><?= $tagesschau[0] ?></a>
<?php endif; ?>
        <div class='files'>
        <h2>Available files</h2>
<?php foreach ($list as $l) if ($l[0] != '.'): ?>
<?php if (preg_match('!\.part!', $l)): ?>
        <?= $l ?><br />
<?php else: ?>
        <a href='/?video=<?= urlencode($l) ?>'><?= n($l) ?></a><br />
<?php endif; ?>
<?php endif; ?>
        </div>
    </body>
</html>
