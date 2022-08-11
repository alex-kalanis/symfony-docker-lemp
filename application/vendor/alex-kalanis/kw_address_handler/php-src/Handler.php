<?php

namespace kalanis\kw_address_handler;


/**
 * Class Handler
 * @package kalanis\kw_address_handler
 * Class for basic work with address. It allows access for aboject manipulating the address. updating params when they come from string representation.
 * It has internal representation of address.
 */
class Handler
{
    /** @var Sources\Sources|null */
    protected $source = null;
    /** @var Params */
    protected $params = null;

    public function __construct(?Sources\Sources $address = null)
    {
        $this->params = new Params();
        $this->setSource($address);
    }

    public function setSource(?Sources\Sources $sources): self
    {
        if (empty($sources)) {
            return $this;
        }
        $this->source = $sources;
        $this->parse();
        return $this;
    }

    protected function parse(): void
    {
        $parts = parse_url($this->source->/** @scrutinizer ignore-call */getAddress());
        if ((false !== $parts) && isset($parts['path'])) {
            $this->source->/** @scrutinizer ignore-call */setPath($parts['path']);
            if (!isset($parts['query'])) {
                $parts['query'] = '';
            }
            $this->params->setParamsData(static::http_parse_query($parts['query']));
        }
    }

    /**
     * Returns an address inside the object.
     * @return Sources\Sources|null
     */
    public function getSource(): ?Sources\Sources
    {
        return $this->source;
    }

    /**
     * Returns object accessing parsed params inside the address
     * @return Params
     */
    public function getParams(): Params
    {
        return $this->params;
    }

    /**
     * Get address if there is anything to parse
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->source ? $this->rebuild()->source->/** @scrutinizer ignore-call */getAddress() : null;
    }

    protected function rebuild(): self
    {
        $parts = parse_url($this->source->/** @scrutinizer ignore-call */getAddress());
        if (false !== $parts) {
            if (!isset($parts['query'])) {
                $parts['query'] = '';
            }
            $queryArray = static::http_parse_query($parts['query']);
            foreach ($this->params->getParamsData() as $paramName => $paramValue) {
                $queryArray[$paramName] = $paramValue;
            }
            foreach ($queryArray as $paramName => $paramValue) {
                if (!$this->params->offsetExists($paramName)) {
                    unset($queryArray[$paramName]);
                }
            }
            $parts['query'] = http_build_query($queryArray);
            $this->source->/** @scrutinizer ignore-call */setAddress($this->buildAddress($parts));
        }
        return $this;
    }

    /**
     * Parses http query string into an array
     *
     * @author Alxcube <alxcube@gmail.com>
     *
     * @param string $queryString String to parse
     * @param non-empty-string $argSeparator Query arguments separator
     * @param integer $decType Decoding type
     * @return array<int, string>
     * @codeCoverageIgnore for now - external source
     */
    public static function http_parse_query(string $queryString, string $argSeparator = '&', int $decType = PHP_QUERY_RFC1738): array
    {
        if (empty($queryString)) { return []; }
        $result = [];
        $parts  = explode($argSeparator, $queryString);

        foreach ($parts as $part) {
            list($paramName, $paramValue) = array_pad(explode('=', $part, 2), 2, '');

            switch ($decType) {
                case PHP_QUERY_RFC3986:
                    $paramName  = rawurldecode($paramName);
                    $paramValue = rawurldecode($paramValue);
                    break;

                case PHP_QUERY_RFC1738:
                default:
                    $paramName  = urldecode($paramName);
                    $paramValue = urldecode($paramValue);
                    break;
            }


            if (preg_match_all('/\[([^\]]*)\]/m', $paramName, $matches)) {
                $paramName = substr($paramName, 0, intval(strpos($paramName, '[')));
                $keys = array_merge([$paramName], $matches[1]);
            } else {
                $keys = [$paramName];
            }

            $target = &$result;

            foreach ($keys as $index) {
                if ('' === $index) {
                    if (isset($target)) {
                        if (is_array($target)) {
                            $intKeys = array_filter(array_keys($target), 'is_int');
                            $index   = count($intKeys) ? max($intKeys)+1 : 0;
                        } else {
                            $target = [$target];
                            $index  = 1;
                        }
                    } else {
                        $target = [];
                        $index  = 0;
                    }
                } elseif (isset($target[$index]) && !is_array($target[$index])) {
                    $target[$index] = [$target[$index]];
                }

                $target = &$target[$index];
            }

            if (is_array($target)) {
                $target[] = $paramValue;
            } else {
                $target = $paramValue;
            }
        }

        return $result;
    }

    /**
     * Build an address from parse_url parts. The generated address will be a relative address if a scheme or host are not provided.
     * @param array<string, int|string> $parts array of parse_url parts
     * @return string
     * @codeCoverageIgnore for now
     */
    protected function buildAddress(array $parts): string
    {
        $url = $scheme = '';

        if (isset($parts['scheme'])) {
            $scheme = $parts['scheme'];
            $url .= $scheme . ':';
        }

        if (isset($parts['host'])) {
            $url .= '//';
            if (isset($parts['user'])) {
                $url .= $parts['user'];
                if (isset($parts['pass'])) {
                    $url .= ':' . $parts['pass'];
                }
                $url .= '@';
            }

            $url .= $parts['host'];

            // Only include the port if it is not the default port of the scheme
            if (isset($parts['port'])
                && !(('http' == $scheme && 80 == $parts['port']) || ('https' == $scheme && 443 == $parts['port']))
            ) {
                $url .= ':' . $parts['port'];
            }
        }

        // Add the path component if present
        if (isset($parts['path']) && (0 !== strlen(strval($parts['path'])))) {
            // Always ensure that the path begins with '/' if set and something is before the path
            if ($url && strval($parts['path'])[0] != '/' && '/' != substr($url, -1)) {
                $url .= '/';
            }
            $url .= $parts['path'];
        }

        // Add the query string if present
        if (isset($parts['query'])) {
            $url .= '?' . $parts['query'];
        }

        // Ensure that # is only added to the url if fragment contains anything.
        if (isset($parts['fragment'])) {
            $url .= '#' . $parts['fragment'];
        }

        return $url;
    }
}
