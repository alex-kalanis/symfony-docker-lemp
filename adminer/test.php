<?php

// display only with pass

if (isset($_GET['diorama']) && ('1ipany' == $_GET['diorama'])) {
    phpinfo();
} else {
    header('HTTP/1.1 418 I\'m a teapot');
    print '<h1>I am a teapot</h1>';
}
