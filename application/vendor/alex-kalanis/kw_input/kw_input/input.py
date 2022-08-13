
from kw_input.interfaces import IInputs, IEntry, ISource, IVariables
from kw_input.loaders import Factory as LoaderFactory
from kw_input.parsers import Factory as ParserFactory
from kw_input.php import ArrayIteratorProcessor


class Input:
    """
     * Abstraction of inputs - this is access which can be implemented without the whole bloat of kw_input
     * but still passed into processing libraries
    """

    def __init__(self, content):
        self._content = content

    def __contains__(self, item):
        return ArrayIteratorProcessor.is_set(self._content, item)

    def __getattr__(self, item):
        """
         * Automatic access to child via Element.childAlias()
        """
        if ArrayIteratorProcessor.is_set(self._content, item):
            return ArrayIteratorProcessor.get(self._content, item)
        else:
            return None

    def __setattr__(self, key, value):
        if '_content' != key:
            self._content = ArrayIteratorProcessor.set(self._content, key, value)

    def __delattr__(self, item):
        if '_content' != item:
            self._content = ArrayIteratorProcessor.remove(self._content, item)

    def __iter__(self):
        self._iter_key = 0
        return self

    def __next__(self):
        key = self._iter_key
        self._iter_key =+ 1
        if self._iter_key > len(getattr(self, '_content')):
            raise StopIteration()
        return self._content[key]

    def __len__(self):
        return len(getattr(self, '_content'))


class Inputs(IInputs):
    """
     * Base class for passing info from inputs into objects
    """

    def __init__(self):
        self._entries = []
        self._source = None
        self._parser_factory = ParserFactory()
        self._loader_factory = LoaderFactory()

    def set_source(self, source=None):
        if source and isinstance(source, ISource):
            self._source = source
        elif hasattr(self._source, 'set_cli') \
                and callable(getattr(self._source, 'set_cli')) \
                and isinstance(source, (list, dict, tuple)):
            self._source.set_cli(source)
        return self

    def load_entries(self):
        if not isinstance(self._source, ISource):
            raise AttributeError('Unknown source for reading values. Please, set something!')
        self._entries = self._load_input(IEntry.SOURCE_GET, self._source.get()) \
            + self._load_input(IEntry.SOURCE_EXTERNAL, self._source.external()) \
            + self._load_input(IEntry.SOURCE_POST, self._source.post()) \
            + self._load_input(IEntry.SOURCE_CLI, self._source.cli()) \
            + self._load_input(IEntry.SOURCE_COOKIE, self._source.cookie()) \
            + self._load_input(IEntry.SOURCE_SESSION, self._source.session()) \
            + self._load_input(IEntry.SOURCE_FILES, self._source.files()) \
            + self._load_input(IEntry.SOURCE_ENV, self._source.env()) \
            + self._load_input(IEntry.SOURCE_SERVER, self._source.server())

    def _load_input(self, source: str, input_array=None):
        if not input_array:
            return []
        parser = self._parser_factory.get_loader(source)
        loader = self._loader_factory.get_loader(source)
        return loader.load_vars(source, parser.parse_input(input_array))

    def get_in(self, entry_key: str = None, entry_sources = None):
        for entry in self._entries:
            allowed_by_key = (not entry_key) or (entry.get_key() == entry_key)
            allowed_by_source = (not entry_sources) or (entry.get_source() in entry_sources)
            if allowed_by_key and allowed_by_source:
                yield entry
