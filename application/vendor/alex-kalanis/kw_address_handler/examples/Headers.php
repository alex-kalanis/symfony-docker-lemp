<?php

////// examples of work with included headers: //////

//// how to create redirect link:

$link = new kalanis\kw_modules\ExternalLink(kalanis\kw_confs\Config::getPath());
$id = '123456789';
$forward = new \kalanis\kw_address_handler\Forward();
$forward->setLink($link->linkVariant('short/edit/?id=' . $id)); // you go there
$forward->setForward($link->linkVariant('short/dashboard'));    // and from there go here (usually back)
echo sprintf('<a href="%s" class="button">%s</a>',
    $forward->getLink(),
    strval($id)
);

// now how to redirect with forward - on page with that link:

$forward = new \kalanis\kw_address_handler\Forward();
$forward->setSource(new \kalanis\kw_address_handler\Sources\ServerRequest());
if (true) { // done something
    $forward->forward(); // forward to passed address in _SERVER_REQUEST
}
$forward->forward(false); // forward to passed address in _SERVER_REQUEST when that internal param came as true


//// redirect directly:

new \kalanis\kw_address_handler\Redirect('/path/where/'); // that's all

// or with timeout after page render - 30 seconds:

new \kalanis\kw_address_handler\Redirect('/path/where/', \kalanis\kw_address_handler\Redirect::TARGET_TEMPORARY, 30);

// on cli it did nothing

//// custom headers:

\kalanis\kw_address_handler\Headers::codeToHeader(202, 500); // set Accepted as header code or Internal server error on fail

\kalanis\kw_address_handler\Headers::codeToHeader(900, 500); // set Internal server error - code 900 is not known

// this is usually good to use with exceptions - just pass correct code

try {
    /// ... do something
} catch (Exception $ex) {
    \kalanis\kw_address_handler\Headers::codeToHeader($ex->getCode(), 500);
    new \kalanis\kw_address_handler\Redirect('/path/where/', \kalanis\kw_address_handler\Redirect::TARGET_TEMPORARY, 20);
}
