<?php

namespace kalanis\kw_paths\Extras;


use Error;
use kalanis\kw_paths\Interfaces\IPATranslations;
use kalanis\kw_paths\PathsException;
use kalanis\kw_paths\Stuff;
use kalanis\kw_paths\Translations;


/**
 * Class ExtendDir
 * low-level work with extended dirs - which contains other params than just files and sub dirs
 */
class ExtendDir
{
    use TRemoveCycle;

    /** @var string */
    protected $webRootDir = ''; # system path to web root dir
    /** @var string */
    protected $descDir = '.txt'; # description dir
    /** @var string */
    protected $descFile = 'index'; # description index filename
    /** @var string */
    protected $descExt = '.dsc'; # description file's extension - add to original name
    /** @var string */
    protected $thumbDir = '.tmb'; # thumbnail dir
    /** @var IPATranslations */
    protected $lang = null;

    public function __construct(string $webRootDir, ?string $descDir = null, ?string $descFile = null, ?string $descExt = null, ?string $thumbDir = null, ?IPATranslations $lang = null)
    {
        $this->webRootDir = $webRootDir;
        $this->descDir = $descDir ?: $this->descDir;
        $this->descFile = $descFile ?: $this->descFile;
        $this->descExt = $descExt ?: $this->descExt;
        $this->thumbDir = $thumbDir ?: $this->thumbDir;
        $this->lang = $lang ?: new Translations();
    }

    public function getWebRootDir(): string
    {
        return $this->webRootDir;
    }

    public function getDescDir(): string
    {
        return $this->descDir;
    }

    public function getDescFile(): string
    {
        return $this->descFile;
    }

    public function getDescExt(): string
    {
        return $this->descExt;
    }

    public function getThumbDir(): string
    {
        return $this->thumbDir;
    }

    /**
     * @param string $path the path inside the web root dir
     * @param string $name
     * @param bool $makeExtra
     * @throws PathsException
     * @return bool
     */
    public function createDir(string $path, string $name, bool $makeExtra = false): bool
    {
        try {
            $target = empty($path) ? '' : Stuff::removeEndingSlash($path) . DIRECTORY_SEPARATOR;
            $targetPath = $target . $name ;
            return mkdir($this->webRootDir . $targetPath)
                && ( $makeExtra ? $this->makeExtended($targetPath) : true );
            // @codeCoverageIgnoreStart
        } catch (Error $ex) {
            throw new PathsException($ex->getMessage(), $ex->getCode(), $ex);
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Make dir with extended properties
     * @param string $path
     * @throws PathsException
     * @return bool
     */
    public function makeExtended(string $path): bool
    {
        $current = Stuff::removeEndingSlash($path) . DIRECTORY_SEPARATOR;
        $descDir = $this->webRootDir . $current . $this->descDir;
        $thumbDir = $this->webRootDir . $current . $this->thumbDir;
        if (is_dir($descDir) && is_dir($thumbDir)) { // already exists
            return true;
        }
        if ((!@mkdir($descDir)) && (!is_dir($descDir))) {
            throw new PathsException($this->lang->paCannotCreateDescDir());
        }
        if ((!@mkdir($thumbDir)) && (!is_dir($thumbDir))) {
            throw new PathsException($this->lang->paCannotCreateThumbDir());
        }
        return true;
    }

    /**
     * @param string $path
     * @throws PathsException
     * @return bool
     */
    public function removeExtended(string $path): bool
    {
        $current = Stuff::removeEndingSlash($path) . DIRECTORY_SEPARATOR;
        $descDir = $this->webRootDir . $current . $this->descDir;
        $thumbDir = $this->webRootDir . $current . $this->thumbDir;

        $this->isWritable($descDir);
        $this->isWritable($thumbDir);
        $this->removeCycle($descDir);
        $this->removeCycle($thumbDir);
        return true;
    }

    /**
     * @param string $path
     * @throws PathsException
     * @return bool
     */
    public function isReadable(string $path): bool
    {
        if (is_dir($path) && is_readable($path)) {
            return true;
        }
        throw new PathsException($this->lang->paCannotAccessWantedDir());
    }

    /**
     * @param string $path
     * @throws PathsException
     * @return bool
     */
    public function isWritable(string $path): bool
    {
        if (is_dir($path) && is_writable($path)) {
            return true;
        }
        throw new PathsException($this->lang->paCannotWriteIntoDir());
    }

    public function isFile(string $path): bool
    {
        return is_file($path);
    }

    public function isDir(string $path): bool
    {
        return is_dir($path);
    }
}
