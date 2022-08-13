
class IEntry:
    """
     * Entry interface - this will be shared across the projects
    """

    SOURCE_CLI = 'cli'
    SOURCE_GET = 'get'
    SOURCE_POST = 'post'
    SOURCE_FILES = 'files'
    SOURCE_COOKIE = 'cookie'
    SOURCE_SESSION = 'session'
    SOURCE_SERVER = 'server'
    SOURCE_ENV = 'environment'
    SOURCE_EXTERNAL = 'external'

    def get_source(self) -> str:
        """
         * Return source of entry
        """
        raise NotImplementedError('TBA')

    def get_key(self) -> str:
        """
         * Return key of entry
        """
        raise NotImplementedError('TBA')

    def get_value(self):
        """
         * Return value of entry
         * It could be anything - string, boolean, array - depends on source
        """
        raise NotImplementedError('TBA')


class IFileEntry(IEntry):
    """
     * File entry interface - how to access uploaded files
     * @link https://www.php.net/manual/en/reserved.variables.files.php
    """

    def get_mime_type(self) -> str:
        """
         * Return what mime is that by browser
         * Beware, it is not reliable
        """
        raise NotImplementedError('TBA')

    def get_temp_name(self) -> str:
        """
         * Get name in temp
         * Use it for function like move_uploaded_file()
        """
        raise NotImplementedError('TBA')

    def get_error(self) -> int:
        """
         * Get error code from upload
         * @link https://www.php.net/manual/en/features.file-upload.errors.php
        """
        raise NotImplementedError('TBA')

    def get_size(self) -> int:
        """
         * Get uploaded file size
        """
        raise NotImplementedError('TBA')


class ISource:
    """
     * Source of values to parse
    """

    def cli(self):
        raise NotImplementedError('TBA')

    def get(self):
        raise NotImplementedError('TBA')

    def post(self):
        raise NotImplementedError('TBA')

    def files(self):
        raise NotImplementedError('TBA')

    def cookie(self):
        raise NotImplementedError('TBA')

    def session(self):
        raise NotImplementedError('TBA')

    def server(self):
        raise NotImplementedError('TBA')

    def env(self):
        raise NotImplementedError('TBA')

    def external(self):
        raise NotImplementedError('TBA')


class IInputs:
    """
     * Basic interface which tells us what actions are by default available by inputs
    """

    def set_source(self, source=None):
        """
         * Setting the variable sources - from cli (argv), _GET, _POST, _SERVER, ...
        """
        raise NotImplementedError('TBA')

    def load_entries(self):
        """
         * Load entries from source into the local entries which will be accessible
         * These two calls came usually in pair
         *
         * input.set_source(sys.argv).load_entries()
        """
        raise NotImplementedError('TBA')

    def get_in(self, entry_key: str = None, entry_sources = None):
        """
         * Get iterator of local entries, filter them on way
         * @param string|null $entry_key
         * @param string[] $entry_sources array of constants from Entries.IEntry.SOURCE_*
         * @return iterator
         * @see Entries.IEntry.SOURCE_CLI
         * @see Entries.IEntry.SOURCE_GET
         * @see Entries.IEntry.SOURCE_POST
         * @see Entries.IEntry.SOURCE_FILES
         * @see Entries.IEntry.SOURCE_COOKIE
         * @see Entries.IEntry.SOURCE_SESSION
         * @see Entries.IEntry.SOURCE_SERVER
         * @see Entries.IEntry.SOURCE_ENV
        """
        raise NotImplementedError('TBA')


class IFiltered:
    """
     * Helper interface which allows us access variables from input
    """

    def get_in_array(self, entry_key: str = None, entry_sources = None):
        """
         * Reformat into array with key as array key and value with the whole entry
         * @param string|None entry_key
         * @param string[] entry_sources
         * @return Entries.IEntry[]
         * Also usually came in pair with previous call - but with a different syntax
         * Beware - due any dict limitations there is a limitation that only the last entry prevails
         *
         * entries = variables.get_in_array('example', [Entries.IEntry.SOURCE_GET]);
        """
        raise NotImplementedError('TBA')

    def get_in_object(self, entry_key: str = None, entry_sources = None):
        """
         * Reformat into object with access by key as string key and value with the whole entry
         * @param string|None entry_key
         * @param string[] entry_sources
         * @return Inputs.Input
         * Also usually came in pair with previous call - but with a different syntax
         * Beware - due any dict limitations there is a limitation that only the last entry prevails
         *
         * entries_in_object = variables.get_in_object('example', [Entries.IEntry.SOURCE_GET]);
        """
        raise NotImplementedError('TBA')


class IVariables(IFiltered):
    pass
