from kw_input.interfaces import IEntry
from kw_input.loaders import ALoader
from kw_input.loaders import Factory, File, Entry, CliEntry
from kw_input.parsers import Cli
from kw_tests.common_class import CommonTestClass


class LoaderTest(CommonTestClass):

    def test_factory(self):
        factory = Factory()
        loader1 = factory.get_loader(IEntry.SOURCE_GET)
        loader2 = factory.get_loader(IEntry.SOURCE_GET)  # intentionally same
        loader3 = factory.get_loader(IEntry.SOURCE_FILES)

        assert isinstance(loader1, Entry)
        assert isinstance(loader2, Entry)
        assert isinstance(loader3, File)
        assert loader1 == loader2
        assert loader3 != loader2

    def test_entry(self):
        data = Entry()
        assert isinstance(data, ALoader)

        entries = data.load_vars(IEntry.SOURCE_GET, self.entry_dataset())

        assert IEntry.SOURCE_GET == entries[0].get_source()
        assert 'foo' == entries[0].get_key()
        assert 'val1' == entries[0].get_value()

        assert IEntry.SOURCE_GET == entries[1].get_source()
        assert 'bar' == entries[1].get_key()
        ### how to check array?!
        # assert ['bal1', 'bal2'] == entries[1].get_value()

        assert IEntry.SOURCE_GET == entries[2].get_source()
        assert 'baz' == entries[2].get_key()
        assert True == entries[2].get_value()

        assert IEntry.SOURCE_GET == entries[3].get_source()
        assert 'aff' == entries[3].get_key()
        assert 42 == entries[3].get_value()

    def test_file(self):
        data = File()
        assert isinstance(data, ALoader)

        entries = data.load_vars(IEntry.SOURCE_FILES, self.file_dataset())

        assert IEntry.SOURCE_FILES == entries[0].get_source()
        assert 'files' == entries[0].get_key()
        assert 'facepalm.jpg' == entries[0].get_value()
        assert 'image/jpeg' == entries[0].get_mime_type()
        assert '/tmp/php3zU3t5' == entries[0].get_temp_name()
        assert 0 == entries[0].get_error()
        assert 591387 == entries[0].get_size()

        assert IEntry.SOURCE_FILES == entries[1].get_source()
        assert 'download[file1]' == entries[1].get_key()
        assert 'MyFile.txt' == entries[1].get_value()
        assert 'text/plain' == entries[1].get_mime_type()
        assert '/tmp/php/phpgj46fg' == entries[1].get_temp_name()
        assert 7 == entries[1].get_error()
        assert 816 == entries[1].get_size()

        assert IEntry.SOURCE_FILES == entries[2].get_source()
        assert 'download[file2]' == entries[2].get_key()
        assert 'MyFile.jpg' == entries[2].get_value()
        assert 'image/jpeg' == entries[2].get_mime_type()
        assert '/tmp/php/php7s4ag4' == entries[2].get_temp_name()
        assert 3 == entries[2].get_error()
        assert 3075 == entries[2].get_size()

    def test_cli_file(self):
        import os
        # import pprint
        data = CliEntry()
        data.set_basic_path(os.getcwd() + os.sep.join(('', '..', 'php-tests')))  # to php data files

        assert isinstance(data, ALoader)

        entries = data.load_vars(IEntry.SOURCE_CLI, Cli().parse_input(self.cli_dataset()))
        # pprint.pprint(entries[0].get_value())

        assert IEntry.SOURCE_CLI == entries[0].get_source()
        assert 'testing' == entries[0].get_key()
        assert 'foo' == entries[0].get_value()

        assert IEntry.SOURCE_CLI == entries[1].get_source()
        assert 'bar' == entries[1].get_key()
        assert 'baz' == entries[1].get_value()

        assert IEntry.SOURCE_FILES == entries[2].get_source()
        assert 'file1' == entries[2].get_key()
        assert './data/tester.gif' == entries[2].get_value()

        assert IEntry.SOURCE_FILES == entries[3].get_source()
        assert 'file2' == entries[3].get_key()
        assert 'data/testing.1.txt' == entries[3].get_value()

        assert IEntry.SOURCE_CLI == entries[4].get_source()
        assert 'file3' == entries[4].get_key()
        assert './data/testing.2.txt' == entries[4].get_value()
