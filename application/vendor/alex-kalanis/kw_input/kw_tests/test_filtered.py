from kw_input.interfaces import IEntry, ISource
from kw_input.input import Inputs
from kw_input.entries import Entry
from kw_input.filtered import Variables, SimpleArrays, EntryArrays
from kw_tests.common_class import CommonTestClass


class FilteredTest(CommonTestClass):

    def test_basics(self):

        input = MockInputs()
        input.set_source(self.cli_dataset())  # direct cli

        source = MockSource()
        source.set_remotes(self.entry_dataset(), None, self.cli_dataset())
        input.set_source(source).load_entries()
        helper = Variables(input)

        assert 0 < len(list(input.get_cli()))
        assert 0 < len(list(input.get_get()))
        assert 1 > len(list(input.get_post()))
        assert 1 > len(list(input.get_session()))
        assert 1 > len(list(input.get_cookie()))
        assert 1 > len(list(input.get_files()))  # paths not translated into files
        # assert 0 < len(list(input.get_files()))  # seems strange, but there are files from Cli
        assert 1 > len(list(input.get_server()))
        assert 1 > len(list(input.get_env()))
        assert 0 < len(list(input.get_basic()))
        assert 1 > len(list(input.get_system()))
        assert 1 > len(list(input.get_external()))

        entries = helper.get_in_array(None, [IEntry.SOURCE_GET])
        assert entries

        assert 'foo' in entries.keys()
        entry = entries['foo']
        assert 'foo' == entry.get_key()
        assert 'val1' == entry.get_value()
        assert IEntry.SOURCE_GET == entry.get_source()

        assert 'bar' in entries.keys()
        entry = entries['bar']
        assert 'bar' == entry.get_key()
        assert 'bal1' == entry.get_value()[0]
        assert 'bal2' == entry.get_value()[1]
        assert IEntry.SOURCE_GET == entry.get_source()

        assert 'baz' in entries.keys()
        entry = entries['baz']
        assert 'baz' == entry.get_key()
        assert True == entry.get_value()
        assert IEntry.SOURCE_GET == entry.get_source()

        assert 'aff' in entries.keys()
        entry = entries['aff']
        assert 'aff' == entry.get_key()
        assert 42 == entry.get_value()
        assert IEntry.SOURCE_GET == entry.get_source()

    def test_files(self):

        source = MockSource()
        source.set_remotes(self.entry_dataset(), None, None, self.file_dataset())

        input = MockInputs()
        input.set_source(source).load_entries()
        helper = Variables(input)

        assert 1 > len(list(input.get_cli()))
        assert 0 < len(list(input.get_get()))
        assert 1 > len(list(input.get_post()))
        assert 1 > len(list(input.get_session()))
        assert 1 > len(list(input.get_cookie()))
        assert 0 < len(list(input.get_files()))
        assert 1 > len(list(input.get_server()))
        assert 1 > len(list(input.get_env()))
        assert 0 < len(list(input.get_basic()))
        assert 1 > len(list(input.get_system()))
        assert 1 > len(list(input.get_external()))

        entries = helper.get_in_array(None, [IEntry.SOURCE_FILES])
        assert entries

        assert 'files' in entries.keys()
        entry = entries['files']
        assert 'files' == entry.get_key()
        assert 'facepalm.jpg' == entry.get_value()
        assert IEntry.SOURCE_FILES == entry.get_source()

        assert 'download[file1]' in entries.keys()
        entry = entries['download[file1]']
        assert 'download[file1]' == entry.get_key()
        assert 'MyFile.txt' == entry.get_value()
        assert IEntry.SOURCE_FILES == entry.get_source()

        assert 'download[file2]' in entries.keys()
        entry = entries['download[file2]']
        assert 'download[file2]' == entry.get_key()
        assert 'MyFile.jpg' == entry.get_value()
        assert IEntry.SOURCE_FILES == entry.get_source()

    # def test_object(self):
    #
    #     input = MockInputs()
    #     input.set_source(self.cli_dataset())  # direct cli
    #
    #     source = MockSource()
    #     source.set_remotes(self.entry_dataset())
    #     input.set_source(source).load_entries()
    #     helper = Variables(input)
    #
    #     assert 0 < len(list(input.get_get()))
    #
    #     entries = helper.get_in_object(None, [IEntry.SOURCE_GET])
    #     assert entries
    #
    #     assert entries.baz
    #     assert 'baz' == entries.baz.get_key()
    #     assert entries.baz.get_value()
    #     assert IEntry.SOURCE_GET == entries.baz.get_source()
    #
    #     entry = entries.aff
    #     delattr(entries, 'aff')
    #     assert 'aff' not in entries
    #     setattr(entries, entry.get_key(), entry)
    #     assert entries.aff

    def test_entries(self):

        variables = EntryArrays([
            ExEntry.init(IEntry.SOURCE_GET, 'foo', 'val1'),
            ExEntry.init(IEntry.SOURCE_GET, 'bar', ['bal1', 'bal2']),
            ExEntry.init(IEntry.SOURCE_GET, 'baz', True),
            ExEntry.init(IEntry.SOURCE_GET, 'aff', 42),
            ExEntry.init(IEntry.SOURCE_EXTERNAL, 'uhb', 'feaht'),
        ])

        entries = variables.get_in_array(None, [IEntry.SOURCE_GET])
        assert entries

        assert 'foo' in entries.keys()
        entry = entries['foo']
        assert 'foo' == entry.get_key()
        assert 'val1' == entry.get_value()
        assert IEntry.SOURCE_GET == entry.get_source()

        assert 'bar' in entries.keys()
        entry = entries['bar']
        assert 'bar' == entry.get_key()
        assert 'bal1' == entry.get_value()[0]
        assert 'bal2' == entry.get_value()[1]
        assert IEntry.SOURCE_GET == entry.get_source()

        assert 'baz' in entries.keys()
        entry = entries['baz']
        assert 'baz' == entry.get_key()
        assert True == entry.get_value()
        assert IEntry.SOURCE_GET == entry.get_source()

        assert 'aff' in entries.keys()
        entry = entries['aff']
        assert 'aff' == entry.get_key()
        assert 42 == entry.get_value()
        assert IEntry.SOURCE_GET == entry.get_source()

        assert 'uhb' not in entries.keys()

    def test_simple_array(self):

        variables = SimpleArrays({
            'foo': 'val1',
            'bar': ['bal1', 'bal2'],
            'baz': True,
            'aff': 42,
        }, IEntry.SOURCE_POST)

        entries = variables.get_in_array(None, [IEntry.SOURCE_GET])
        assert entries

        assert 'foo' in entries.keys()
        entry = entries['foo']
        assert 'foo' == entry.get_key()
        assert 'val1' == entry.get_value()
        assert IEntry.SOURCE_POST == entry.get_source()

        assert 'bar' in entries.keys()
        entry = entries['bar']
        assert 'bar' == entry.get_key()
        assert 'bal1' == entry.get_value()[0]
        assert 'bal2' == entry.get_value()[1]
        assert IEntry.SOURCE_POST == entry.get_source()

        assert 'baz' in entries.keys()
        entry = entries['baz']
        assert 'baz' == entry.get_key()
        assert True == entry.get_value()
        assert IEntry.SOURCE_POST == entry.get_source()

        assert 'aff' in entries.keys()
        entry = entries['aff']
        assert 'aff' == entry.get_key()
        assert 42 == entry.get_value()
        assert IEntry.SOURCE_POST == entry.get_source()


class MockSource(ISource):

    def __init__(self):
        self._mock_cli = None
        self._mock_get = None
        self._mock_post = None
        self._mock_files = None
        self._mock_cookie = None
        self._mock_session = None

    def set_remotes(self, get, post=None, cli=None, files=None, cookie=None, session=None):
        self._mock_cli = cli
        self._mock_get = get
        self._mock_post = post
        self._mock_files = files
        self._mock_cookie = cookie
        self._mock_session = session
        return self

    def cli(self):
        return self._mock_cli

    def get(self):
        return self._mock_get

    def post(self):
        return self._mock_post

    def files(self):
        return self._mock_files

    def cookie(self):
        return self._mock_cookie

    def session(self):
        return self._mock_session

    def server(self):
        return None

    def env(self):
        return None

    def external(self):
        return None


class MockInputs(Inputs):

    def get_basic(self):
        return self.get_in(None, (
            IEntry.SOURCE_CLI,
            IEntry.SOURCE_GET,
            IEntry.SOURCE_POST,
        ))

    def get_system(self):
        return self.get_in(None, (
            IEntry.SOURCE_SERVER,
            IEntry.SOURCE_ENV,
        ))

    def get_cli(self):
        return self.get_in(None, IEntry.SOURCE_CLI)

    def get_get(self):
        return self.get_in(None, IEntry.SOURCE_GET)

    def get_post(self):
        return self.get_in(None, IEntry.SOURCE_POST)

    def get_session(self):
        return self.get_in(None, IEntry.SOURCE_SESSION)

    def get_cookie(self):
        return self.get_in(None, IEntry.SOURCE_COOKIE)

    def get_files(self):
        return self.get_in(None, IEntry.SOURCE_FILES)

    def get_server(self):
        return self.get_in(None, IEntry.SOURCE_SERVER)

    def get_env(self):
        return self.get_in(None, IEntry.SOURCE_ENV)

    def get_external(self):
        return self.get_in(None, IEntry.SOURCE_EXTERNAL)


class ExEntry(Entry):

    @staticmethod
    def init(source: str, key: str, value = None) -> Entry:
        lib = Entry()
        lib.set_entry(source, key, value)
        return lib

