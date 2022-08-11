from kw_input.interfaces import IEntry
from kw_input.parsers import AParser
from kw_input.parsers import Factory, Basic, Files, Cli
from kw_tests.common_class import CommonTestClass


class ParserTest(CommonTestClass):

    def test_factory(self):
        factory = Factory()
        loader1 = factory.get_loader(IEntry.SOURCE_GET)
        loader2 = factory.get_loader(IEntry.SOURCE_GET)  # intentionally same
        loader3 = factory.get_loader(IEntry.SOURCE_CLI)
        loader4 = factory.get_loader(IEntry.SOURCE_FILES)

        assert isinstance(loader1, Basic)
        assert isinstance(loader2, Basic)
        assert isinstance(loader4, Files)
        assert isinstance(loader3, Cli)
        assert loader1 == loader2
        assert loader3 != loader2
        assert loader3 != loader4
        assert loader2 != loader4

    def test_basics(self):
        # import pprint
        # pprint.pprint(entries)

        data = Basic()
        assert isinstance(data, AParser)
        entries = data.parse_input(self.entry_dataset())

        assert 'foo' == entries[0][0]
        assert 'val1' == entries[0][1]

        assert 'bar' == entries[1][0]
        assert 'bal1' == entries[1][1][0]
        assert 'bal2' == entries[1][1][1]

        assert 'baz' == entries[2][0]
        assert True == entries[2][1]

        assert 'aff' == entries[3][0]
        assert 42 == entries[3][1]

    def test_strange(self):
        data = Basic()
        assert isinstance(data, AParser)
        entries = data.parse_input(self.strange_entry_dataset())

        assert 'foo  ' == entries[0][0]
        assert 'val1' == entries[0][1]

        assert 'bar' == entries[1][0]
        assert "<script>alert('XSS!!!')</script>" == entries[1][1][0]
        assert 'bal2' == entries[1][1][1]

        assert 'b<a>z' == entries[2][0]
        assert False == entries[2][1]

        assert 'a**ff' == entries[3][0]
        assert '<?php echo "ded!";' == entries[3][1]

    def test_file(self):
        data = Files()
        assert isinstance(data, AParser)
        entries = data.parse_input(self.file_dataset())

        assert 'files' == entries[0][0]
        entry = entries[0][1]
        assert 'name' == entry[0][0]
        assert 'facepalm.jpg' == entry[0][1]
        assert 'type' == entry[1][0]
        assert 'image/jpeg' == entry[1][1]
        assert 'tmp_name' == entry[2][0]
        assert '/tmp/php3zU3t5' == entry[2][1]
        assert 'error' == entry[3][0]
        assert 0 == entry[3][1]
        assert 'size' == entry[4][0]
        assert 591387 == entry[4][1]

        assert 'download' == entries[1][0]
        entry = entries[1][1]
        assert 'name' == entry[0][0]
        assert 'file1' == entry[0][1][0][0]
        assert 'MyFile.txt' == entry[0][1][0][1]
        assert 'file2' == entry[0][1][1][0]
        assert 'MyFile.jpg' == entry[0][1][1][1]
        assert 'type' == entry[1][0]
        assert 'file1' == entry[1][1][0][0]
        assert 'text/plain' == entry[1][1][0][1]
        assert 'file2' == entry[1][1][1][0]
        assert 'image/jpeg' == entry[1][1][1][1]
        assert 'tmp_name' == entry[2][0]
        assert 'file1' == entry[2][1][0][0]
        assert '/tmp/php/phpgj46fg' == entry[2][1][0][1]
        assert 'file2' == entry[2][1][1][0]
        assert '/tmp/php/php7s4ag4' == entry[2][1][1][1]
        assert 'error' == entry[3][0]
        assert 'file1' == entry[3][1][0][0]
        assert 7 == entry[3][1][0][1]
        assert 'file2' == entry[3][1][1][0]
        assert 3 == entry[3][1][1][1]
        assert 'size' == entry[4][0]
        assert 'file1' == entry[4][1][0][0]
        assert 816 == entry[4][1][0][1]
        assert 'file2' == entry[4][1][1][0]
        assert 3075 == entry[4][1][1][1]

    def test_strange_file(self):
        data = Files()
        assert isinstance(data, AParser)
        entries = data.parse_input(self.strange_file_dataset())

        assert 'files' == entries[0][0]
        entry = entries[0][1]
        assert 'name' == entry[0][0]
        assert 'facepalm.jpg' == entry[0][1]
        assert 'type' == entry[1][0]
        assert 'image<?= \'/\'; ?>jpeg' == entry[1][1]
        assert 'tmp_name' == entry[2][0]
        assert '/tmp/php3zU3t5' == entry[2][1]
        assert 'error' == entry[3][0]
        assert 0 == entry[3][1]
        assert 'size' == entry[4][0]
        assert '591387' == entry[4][1]

        assert 'download' == entries[1][0]
        entry = entries[1][1]
        assert 'name' == entry[0][0]
        assert 'file1' == entry[0][1][0][0]
        assert 'C:\System\MyFile.txt' == entry[0][1][0][1]
        assert 'file2' == entry[0][1][1][0]
        assert 'A:\MyFile.jpg' == entry[0][1][1][1]

    def test_cli(self):
        data = Cli()
        assert isinstance(data, AParser)
        entries = data.parse_input(self.cli_dataset())

        assert 'testing' == entries[0][0]
        assert 'foo' == entries[0][1]
        assert 'bar' == entries[1][0]
        assert 'baz' == entries[1][1]
        assert 'file1' == entries[2][0]
        assert './data/tester.gif' == entries[2][1]
        assert 'file2' == entries[3][0]
        assert 'data/testing.1.txt' == entries[3][1]
        assert 'file3' == entries[4][0]
        assert './data/testing.2.txt' == entries[4][1]
        assert 'a' == entries[5][0]
        assert 'b' == entries[6][0]
        assert 'c' == entries[7][0]
        assert 'known' == entries[8][1]
        assert 'what' == entries[9][1]

    def test_strange_cli(self):
        data = Cli()
        assert isinstance(data, AParser)
        entries = data.parse_input(self.strange_cli_dataset())

        assert 'testing' == entries[0][0]
        assert 'f<o>o' == entries[0][1]
        assert '-bar' == entries[1][0]
        assert 'b**a**z' == entries[1][1]
        assert 'a' == entries[2][0]
        assert 'c' == entries[3][0]
