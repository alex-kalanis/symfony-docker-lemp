<?php

namespace kalanis\kw_paths;


/**
 * Class Path
 * @package kalanis\kw_paths
 * Parsed path data
 * Notes:
 * On web:
 * - documentRoot is usually container for value _SERVER['DOCUMENT_ROOT'] - path to the scripts
 * - staticalPath and virtualPrefix are changeable with documentRoot when the content is sent outside
 * - with all these values and constants inside the interface it's possible to make walk through the file tree
 * In admin:
 * - documentRoot is still basic dir from _SERVER
 * - pathToSystemRoot is then transfer from system root to dir where the user dir is stored
 * - user is name of logged user from some source
 * - path is path to currently processed content; depends on module if it's file or dir
 *
 * On Windows following variables contains backslashes as directory separators:
 * - path
 * - documentRoot
 * - pathToSystemRoot
 */
class Path
{
    /** @var string */
    protected $documentRoot = ''; // document root as set from server
    /** @var string */
    protected $pathToSystemRoot = ''; // because document root could not be every time that dir in which are user data dir
    /** @var string */
    protected $staticalPath = ''; // in browser the path which stay the same and targets the document root from the outside
    /** @var string */
    protected $virtualPrefix = ''; // in browser the separation value between static part and virtual one
    /** @var string */
    protected $user = ''; // user whom content is looked for
    /** @var string */
    protected $lang = ''; // in which language will be content provided, also affects path
    /** @var string */
    protected $path = ''; // the rest of path
    /** @var string */
    protected $module = ''; // basic module which will be used as default one to present the content
    /** @var bool */
    protected $isSingle = false; // is module the master of page and should be there another as wrapper?

    /**
     * @param array<string, string|int|bool> $params
     * @return $this
     */
    public function setData(array $params): self
    {
        $this->user = strval($params['user'] ?? $this->user );
        $this->lang = strval($params['lang'] ?? $this->lang );
        $this->path = Stuff::arrayToPath(Stuff::linkToArray(strval($params['path'] ?? $this->path )));
        $this->module = strval($params['module'] ?? $this->module );
        $this->isSingle = isset($params['single']);
        $this->staticalPath = strval($params['staticalPath'] ?? $this->staticalPath );
        $this->virtualPrefix = strval($params['virtualPrefix'] ?? $this->virtualPrefix );
        return $this;
    }

    public function setDocumentRoot(string $documentRoot): self
    {
        $this->documentRoot = Stuff::arrayToPath(Stuff::linkToArray($documentRoot));
        return $this;
    }

    public function getDocumentRoot(): string
    {
        return $this->documentRoot;
    }

    public function setPathToSystemRoot(string $pathToSystemRoot): self
    {
        $this->pathToSystemRoot = Stuff::arrayToPath(Stuff::linkToArray($pathToSystemRoot));
        return $this;
    }

    public function getPathToSystemRoot(): string
    {
        return $this->pathToSystemRoot;
    }

    public function getStaticalPath(): string
    {
        return $this->staticalPath;
    }

    public function getVirtualPrefix(): string
    {
        return $this->virtualPrefix;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getModule(): string
    {
        return $this->module;
    }

    public function isSingle(): bool
    {
        return $this->isSingle;
    }
}
