
from kw_input.interfaces import IEntry


class AParser:
    """
     * Parse any input for problematic chars
    """

    def parse_input(self, array):
        """
         * Parse input into usable array, remove problematic things
        """
        raise NotImplementedError('TBA')

    """
     * Clear Null bytes
     * Do not use on files - they are usually valid
     * @link https://resources.infosecinstitute.com/null-byte-injection-php/
    """
    def _remove_null_bytes(self, string: str, null_to = ''):
        return string.replace(chr(0), null_to)


class Basic(AParser):
    """
     * Parse any input for problematic chars
    """

    def parse_input(self, array):
        if not isinstance(array, (dict, list, tuple)):
            if isinstance(array, (bool, int, float)):
                return array
            else:
                return self._remove_null_bytes(str(array).strip())

        trim_array = []
        for parsed in array:
            if isinstance(parsed, dict):
                parsed = tuple(parsed)
                trim_array.append((self._remove_null_bytes(parsed[0]), self.parse_input(parsed[1])))
            elif isinstance(parsed, tuple):
                trim_array.append((self._remove_null_bytes(parsed[0]), self.parse_input(parsed[1])))
            elif isinstance(parsed, list):
                trim_array.append(self.parse_input(parsed))
            elif isinstance(parsed, (bool, int, float)):
                trim_array.append(parsed)
            else:
                trim_array.append(self._remove_null_bytes(str(parsed).strip()))
        return trim_array


class Cli(AParser):
    """
     * Parse input from command line
    """

    DELIMITER_LONG_ENTRY = '--'
    DELIMITER_SHORT_ENTRY = '-'
    DELIMITER_PARAM_VALUE = '='
    UNSORTED_PARAM = 'param_'

    AVAILABLE_LETTERS = ('a','b','c','d','e','f','g','h','i','j','k','l','m',
                         'n','o','p','q','r','s','t','u','v','w','x','y','z')

    def parse_input(self, array):
        """
         * @param array $array is $argv in boot time
        """
        clear_array = []
        unsorted = 0
        for posted in array:
            if Cli.DELIMITER_LONG_ENTRY == posted[0:len(Cli.DELIMITER_LONG_ENTRY)]:
                # large params
                if Cli.DELIMITER_PARAM_VALUE in posted:
                    entry = posted[len(Cli.DELIMITER_LONG_ENTRY):]
                    inside = entry.split(Cli.DELIMITER_PARAM_VALUE, 2)
                    add_key = self._remove_null_bytes(inside[0])
                    add_value = self._remove_null_bytes(inside[1])
                else:
                    add_key = self._remove_null_bytes(posted)
                    add_value = True

                if add_key in dict(clear_array).keys():
                    new_array = []
                    for key, value in clear_array:
                        if key == add_key:
                            new_value = value if isinstance(value, list) else [value]
                            new_value.append(add_value)
                            new_array.append((key, new_value))
                        else:
                            new_array.append((key, value))
                    clear_array = new_array
                else:
                    clear_array.append((add_key, add_value))

            elif Cli.DELIMITER_SHORT_ENTRY == posted[0:len(Cli.DELIMITER_SHORT_ENTRY)]:
                # just by letters
                entry = self._remove_null_bytes(posted[len(Cli.DELIMITER_SHORT_ENTRY)-1:])
                letters = len(entry)
                for i in range(1, letters):
                    if entry[i].lower() in Cli.AVAILABLE_LETTERS:
                        clear_array.append((entry[i], True))
            else:
                # rest of the world
                key = Cli.UNSORTED_PARAM + str(unsorted)
                clear_array.append((key, self._remove_null_bytes(posted)))
                unsorted =+ 1
        return clear_array


class Files(AParser):
    """
     * Parse files input
     * Check only names, the rest is usually valid
    """

    def parse_input(self, array):
        trim_array = []
        for (key, posted) in array:
            internals = []
            for (locate, content) in posted:
                if 'name' == locate:
                    content = self._clear(content)
                internals.append((locate, content))
            trim_array.append((self._remove_null_bytes(str(key).strip()), internals))
        return trim_array

    def _clear(self, value):
        if isinstance(value, (dict, tuple, list)):
            result = []
            for posted in value:
                result.append(self._clear(posted))
            return tuple(result)
        else:
            return self._remove_null_bytes(str(value).strip())


class Factory:
    """
     * Loading factory
    """

    _loaders = {}

    def get_loader(self, source: str) -> AParser:
        if source in Factory._loaders.keys():
            return Factory._loaders[source]

        loader = self._select(source)
        Factory._loaders[source] = loader
        return loader

    def _select(self, source: str) -> AParser:
        if IEntry.SOURCE_CLI == source:
            return Cli()
        elif IEntry.SOURCE_FILES == source:
            return Files()
        else:
            return Basic()
