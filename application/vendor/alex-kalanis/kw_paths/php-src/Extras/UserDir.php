<?php

namespace kalanis\kw_paths\Extras;


use InvalidArgumentException;
use kalanis\kw_paths\Interfaces\IPaths;
use kalanis\kw_paths\Interfaces\IPATranslations;
use kalanis\kw_paths\Path;
use kalanis\kw_paths\PathsException;
use kalanis\kw_paths\Stuff;
use kalanis\kw_paths\Translations;
use UnexpectedValueException;


/**
 * Class UserDir
 * low-level work with user dirs
 */
class UserDir
{
    use TRemoveCycle;

    /** @var string */
    protected $userName = ''; # obtained user's name (when need)
    /** @var string */
    protected $userPath = ''; # system path to user's home dir
    /** @var string */
    protected $webRootDir = ''; # system path to web root dir
    /** @var string */
    protected $workDir = ''; # relative path to user's work dir (from web dir)
    /** @var string */
    protected $homeDir = ''; # relative path to user's home dir (from web dir)
    /** @var string */
    protected $realPath = ''; # real path as derived from user path - without added slashes
    /** @var bool */
    protected $canUseHomeDir = true; # if use sub dirs or is it directly in user's home dir
    /** @var bool */
    protected $canUseDataDir = true; # if use user dir or is it anywhere else directly from web root
    /** @var IPATranslations */
    protected $lang = null;

    public function __construct(Path $path, ?IPATranslations $lang = null)
    {
        $this->lang = $lang ?: new Translations();
        $this->webRootDir =
            Stuff::removeEndingSlash($path->getDocumentRoot()) . DIRECTORY_SEPARATOR
            . Stuff::removeEndingSlash($path->getPathToSystemRoot()) . DIRECTORY_SEPARATOR;
    }

    public function getWebRootDir(): string
    {
        return $this->webRootDir;
    }

    /**
     * Return relative path to home dir for accessing special dirs
     * @return string
     */
    public function getHomeDir(): string
    {
        return $this->homeDir;
    }

    /**
     * Return relative path to working dir
     * @return string
     */
    public function getWorkDir(): string
    {
        return $this->workDir;
    }

    /**
     * Return real path to working dir
     * @return string
     */
    public function getRealDir(): string
    {
        return $this->realPath;
    }

    /**
     * Set username as base for generating user dir
     * @param string $name
     * @throws InvalidArgumentException
     * @return UserDir
     */
    public function setUserName(string $name): self
    {
        if (empty($name)) {
            throw new InvalidArgumentException($this->lang->paUserNameIsShort());
        }
        if (false !== strpbrk($name, '.: /~')) {
            throw new InvalidArgumentException($this->lang->paUserNameContainsChars());
        }
        $this->userName = $name;
        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * Use home as data dir?
     * @param bool $set
     * @return UserDir
     */
    public function wantHomeDir(bool $set): self
    {
        $this->canUseHomeDir = $set;
        return $this;
    }

    public function usedHomeDir(): bool
    {
        return $this->canUseHomeDir;
    }

    /**
     * Use sub dirs?
     * @param bool $set
     * @return UserDir
     */
    public function wantDataDir(bool $set): self
    {
        $this->canUseDataDir = $set;
        return $this;
    }

    public function usedDataDir(): bool
    {
        return $this->canUseDataDir;
    }

    /**
     * Set obtained path as basic user dir
     * @param string $path
     * @return bool
     */
    public function setUserPath(string $path): bool
    {
        if (false !== strpbrk($path, ':')) {
            return false;
        }
        $this->canUseHomeDir = DIRECTORY_SEPARATOR != substr($path, 0, 1); # may use data dir - does not start with slash
        $this->canUseDataDir = DIRECTORY_SEPARATOR != substr($path, -1, 1); # may use sub dirs - does not end with slash
        $this->userPath = $path;
        return true;
    }

    public function getUserPath(): string
    {
        return $this->userPath;
    }

    /**
     * Fill user dir from obtained params, must run every time
     * @return $this
     */
    public function process(): self
    {
        if (empty($this->userPath)) {
            $this->userPath = $this->makeFromUserName();
        }

        $this->realPath = Stuff::sanitize($this->userPath);
        $this->homeDir = $this->canUseHomeDir
            ? Stuff::removeEndingSlash(IPaths::DIR_USER . DIRECTORY_SEPARATOR . $this->realPath) . DIRECTORY_SEPARATOR
            : $this->realPath . DIRECTORY_SEPARATOR;
        $this->workDir = $this->canUseDataDir
            ? $this->homeDir . IPaths::DIR_DATA . DIRECTORY_SEPARATOR
            : $this->homeDir;
        return $this;
    }

    protected function makeFromUserName(): string
    {
        if (empty($this->userName)) {
            throw new UnexpectedValueException($this->lang->paUserNameNotDefined());
        }
        $userPath = $this->userName;
        if (!$this->canUseHomeDir) {
            $userPath = DIRECTORY_SEPARATOR . $userPath;
        }
        if (!$this->canUseDataDir) {
            $userPath = $userPath . DIRECTORY_SEPARATOR;
        }
        return $userPath;
    }

    /**
     * Create inner path tree
     * @throws PathsException
     * @return string with inner path
     */
    public function createTree(): string
    {
        if (empty($this->homeDir)) {
            throw new PathsException($this->lang->paCannotDetermineUserDir());
        }
        $userDir = Stuff::removeEndingSlash($this->homeDir);
        if (!@mkdir($this->webRootDir . $userDir)) {
            if (!is_dir($this->webRootDir . $userDir)) {
                throw new PathsException($this->lang->paCannotCreateUserDir());
            }
        }
        if ($this->canUseDataDir) {
            mkdir($this->webRootDir . $this->homeDir . IPaths::DIR_DATA);
            mkdir($this->webRootDir . $this->homeDir . IPaths::DIR_CONF);
            mkdir($this->webRootDir . $this->homeDir . IPaths::DIR_STYLE);
        }
        return $userDir;
    }

    /**
     * Remove data in user's work dir
     * @throws PathsException
     * @return bool
     */
    public function wipeWorkDir(): bool
    {
        if (empty($this->workDir)) {
            throw new PathsException($this->lang->paCannotDetermineUserDir());
        }
        if (3 > strlen($this->workDir)) {
            return false; # urcite se najde i blbec, co bude chtit cistku roota
        }
        $this->removeCycle($this->webRootDir . $this->workDir);
        return true;
    }

    /**
     * Remove everything in user's special sub dirs
     * @throws PathsException
     * @return bool
     */
    public function wipeConfDirs(): bool
    {
        if (empty($this->homeDir)) {
            throw new PathsException($this->lang->paCannotDetermineUserDir());
        }
        if (!$this->canUseDataDir) {
            return false;
        }
        if (3 > strlen($this->homeDir)) {
            return false; # urcite se najde i blbec, co bude chtit cistku roota
        }
        $this->removeCycle($this->webRootDir . $this->homeDir . IPaths::DIR_CONF);
        $this->removeCycle($this->webRootDir . $this->homeDir . IPaths::DIR_STYLE);
        return true;
    }

    /**
     * Remove everything in user's home dir and that home dir itself
     * @throws PathsException
     * @return bool
     */
    public function wipeHomeDir(): bool
    {
        if (empty($this->homeDir)) {
            throw new PathsException($this->lang->paCannotDetermineUserDir());
        }
        if (4 > strlen($this->workDir)) {
            return false; # urcite se najde i blbec, co bude chtit wipe roota (jeste blbejsi napad, nez jsme doufali) - tudy se odinstalace fakt nedela!
        }
        $this->removeCycle($this->webRootDir . $this->homeDir);
        $dirPath = $this->webRootDir . Stuff::removeEndingSlash($this->homeDir);
        if (is_dir($dirPath)) {
            rmdir($dirPath);
        }
        $this->workDir = '';
        $this->homeDir = '';
        return true;
    }
}

/*
//// how it works ////

// create user, its dir, subdirs will be made auto
$u = new UserDir();
$u->setUserName("nom");
$u->process();
$u->createTree();

// when you do not need subdirs; sometimes necessary
$u->wantDataDir(false);

// user removal
$u = new UserDir();
$u->setUserName("nom"); || $u->setUserPath("dat/dumb/dir");
$u->process();
$u->wipeWorkDir(); || $u->wipeConfDirs(); || $u->wipeHomeDir(); // dle pozadavku a nalady

// create subdirs when they aren't
$u = new UserDir();
$u->setUserName("nom"); || $u->setUserPath("dat/dumb/dir");
$u->wantDataDir(true);
$u->process();
$u->createTree();

// then it's good idea to write that updated form into password file - or the user will see strange things
$where = $u->getUserPath();

// current user and its files
$u = new UserDir();
$u->setUserName("nom"); || $u->setUserPath("dat/dumb/dir");
$u->process();
$kam = $u->getUserPath();

// did that user have home dir and/or subdirs?
$homedir = $u->usedHomeDir(); // beware, returns bool
$subdirs = $u->usedDataDir(); // beware, returns bool
*/

