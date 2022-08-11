from kw_input.interfaces import IEntry
from kw_input.entries import Entry as EntryItem
from kw_input.entries import FileEntry as FileEntryItem


class ALoader:
    """
     * Load input arrays into normalized entries
    """

    def load_vars(self, source: str, array):
        """
         * Transform input values to something more reliable
         * @return Entry[]
        """
        raise NotImplementedError('TBA')


class Entry(ALoader):
    """
     * Load input arrays into normalized entries
    """

    def load_vars(self, source: str, array):
        """
         * Transform input values to something more reliable
         * @return Entry[]
        """
        result = []
        for (key, val) in array:
            result.append(EntryItem().set_entry(source, key, val))
        return result


class File(ALoader):
    """
     * Load file input array into normalized entries
     * @link https://www.php.net/manual/en/reserved.variables.files.php
    """

    def load_vars(self, source: str, array):
        result = []
        for (posted_key, posted) in array:
            post_dict = dict(posted)
            if isinstance(post_dict['name'], (list, dict, tuple)):
                for (key, value) in post_dict['name']:
                    entry = FileEntryItem()
                    entry.set_entry(source, '%s[%s]' % (posted_key, key))
                    tmp_name_dict = dict(post_dict['tmp_name'])
                    type_dict = dict(post_dict['type'])
                    error_dict = dict(post_dict['error'])
                    size_dict = dict(post_dict['size'])
                    entry.set_file(
                        value,
                        tmp_name_dict[key],
                        type_dict[key],
                        int(error_dict[key]),
                        int(size_dict[key])
                    )
                    result.append(entry)
            else:
                entry = FileEntryItem()
                entry.set_entry(source, posted_key)
                entry.set_file(
                    post_dict['name'],
                    post_dict['tmp_name'],
                    post_dict['type'],
                    int(post_dict['error']),
                    int(post_dict['size'])
                )
                result.append(entry)
        return result


class CliEntry(ALoader):
    """
     * Load input arrays into normalized entries - CLI entries which could be also files
    """

    _basic_path = ''

    @staticmethod
    def set_basic_path(path):
        CliEntry._basic_path = path

    def load_vars(self, source: str, array):
        """
         * Transform input values to something more reliable
         * @return EntryItem[]|FileEntryItem[]
        """
        result = []
        for (key, val) in array:
            full_path = self._check_file(val)
            if full_path:
                result.append(FileEntryItem().set_entry(IEntry.SOURCE_FILES, key).set_file(
                    val, full_path, self._get_type(full_path), 0, self._get_size(full_path)
                ))
            else:
                result.append(EntryItem().set_entry(source, key, val))

        return result

    def _check_file(self, path) -> str:
        import os

        if not isinstance(path, str):
            return None

        is_full = os.sep == path[0]
        known = os.path.realpath(path if is_full else CliEntry._basic_path + os.sep + path)
        return known if os.path.exists(known) else None

    def _get_type(self, path) -> str:
        import mimetypes

        f_type = 'application/octet-stream'
        f_res = mimetypes.guess_type(path, False)
        if f_res[0] and isinstance(f_res[0], str):
            f_type = f_res[0]
        return f_type

    def _get_size(self, path) -> int:
        import os
        return os.path.getsize(path)


class Factory:
    """
     * Loading factory
    """

    _loaders = {}

    def get_loader(self, source: str) -> ALoader:
        if source in Factory._loaders.keys():
            return Factory._loaders[source]

        loader = self._select(source)
        Factory._loaders[source] = loader
        return loader

    def _select(self, source: str) -> ALoader:
        if IEntry.SOURCE_FILES == source:
            return File()
        elif IEntry.SOURCE_CLI == source:
            return CliEntry()
        else:
            return Entry()
