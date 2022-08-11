<?php

namespace kalanis\kw_address_handler\examples;


use kalanis\kw_address_handler\Handler;
use kalanis\kw_address_handler\Sources\ServerRequest;


/**
 * Class Certs
 * @package kalanis\kw_address_handler\examples
 * Authenticate via certificates
 * @codeCoverageIgnore because access external content
 * - public on server, private on client whom manage the site
 *
 * query:
 * http://localhost/web/u:debugger/?pass=asdfghjkl&timestamp=123456&digest=hjkl
 *
 * makes following call:
 * 'hjkl' == md5( '/web/u:debugger/?pass=asdfghjkl&timestamp=123456&salt=99999' . 'xyz' )
 *
 * - it has removed digest value and added locally stored salt
 */
class Certs
{
    /** @var string */
    protected $localKey = '99999';
    /** @var string */
    protected $localSalt = 'xyz';
    /** @var Handler */
    protected $uriHandler = null;

    public function __construct()
    {
        $this->uriHandler = new Handler(new ServerRequest());
    }

    /**
     * @param \ArrayAccess $credentials
     * @throws \Exception
     */
    public function process(\ArrayAccess $credentials): void
    {
        $stamp = $credentials->offsetExists('timestamp') ? $credentials->offsetGet('timestamp') : 0 ;
        if (!empty($stamp)) {
            // now we have public key and salt from our storage, so it's time to check it

            // digest out, salt in
            $digest = $this->uriHandler->getParams()->offsetGet('digest');
            $this->uriHandler->getParams()->offsetUnset('digest');
            $this->uriHandler->getParams()->offsetSet('salt', $this->localSalt);
            $data = $this->uriHandler->getAddress();

            // verify
            $result = strval($digest) === md5(strval($data) . $this->localKey);
            if ($result) {
                // OK
                throw new \Exception('Passed?!');
            }
        }
    }
}
