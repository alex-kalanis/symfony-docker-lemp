
from .interfaces import IEntry, IFileEntry


class Entry(IEntry):
    """
     * Simple entry from source
     * For setting numeric value just re-type set by strval()
     * For setting boolean value just expand previous - strval(intval())
    """

    _available_sources = [
        IEntry.SOURCE_CLI,
        IEntry.SOURCE_GET,
        IEntry.SOURCE_POST,
        # IEntry::SOURCE_FILES,  # has own class
        IEntry.SOURCE_COOKIE,
        IEntry.SOURCE_SESSION,
        IEntry.SOURCE_SERVER,
        IEntry.SOURCE_ENV,
        IEntry.SOURCE_EXTERNAL,
    ]

    def __init__(self):
        self._key = ''
        self._value = ''
        self._source = ''

    def __str__(self):
        return str(self.get_value())

    def set_entry(self, source: str, key: str, value=None):
        self._key = key
        self._value = value
        self._source = self._available_source(source)
        return self

    def _available_source(self, source: str) -> str:
        return source if source in Entry._available_sources else self._source

    def get_source(self) -> str:
        return self._source

    def get_key(self) -> str:
        return self._key

    def get_value(self):
        return self._value


class FileEntry(IFileEntry, Entry):
    """
     * Input is file and has extra values
    """

    def __init__(self):
        super().__init__()
        self._mime_type = ''
        self._temp_name = ''
        self._error = 0
        self._size = 0

    def set_file(self, file_name: str, temp_name: str, mime_type: str, error: int, size: int):
        self._value = file_name
        self._mime_type = mime_type
        self._temp_name = temp_name
        self._error = error
        self._size = size
        return self

    def get_source(self) -> str:
        return self.SOURCE_FILES

    def get_mime_type(self) -> str:
        return self._mime_type

    def get_temp_name(self) -> str:
        return self._temp_name

    def get_error(self) -> int:
        return self._error

    def get_size(self) -> int:
        return self._size
