from kw_input.interfaces import IEntry, IFileEntry
from kw_input.entries import Entry, FileEntry
from kw_tests.common_class import CommonTestClass


class EntryTest(CommonTestClass):

    def test_entry(self):
        data = Entry()
        assert isinstance(data, IEntry)
        assert not data.get_source()
        assert not data.get_key()
        assert not data.__str__()

        data.set_entry('different', 'foz', 'wuz')
        assert not data.get_source()
        assert 'foz' == data.get_key()
        assert 'wuz' == data.get_value()

        data.set_entry(IEntry.SOURCE_GET, 'ugg', 'huu')
        assert IEntry.SOURCE_GET == data.get_source()
        assert 'ugg' == data.get_key()
        assert 'huu' == data.get_value()

        data.set_entry(IEntry.SOURCE_POST, 'aqq')
        assert IEntry.SOURCE_POST == data.get_source()
        assert 'aqq' == data.get_key()
        assert not data.get_value()

    def test_file(self):
        data = FileEntry()
        assert isinstance(data, IEntry)
        assert isinstance(data, IFileEntry)

        assert IEntry.SOURCE_FILES == data.get_source()
        assert not data.get_key()
        assert not data.get_value()
        assert not data.get_mime_type()
        assert not data.get_temp_name()
        assert not data.get_error()
        assert not data.get_size()

        data.set_entry('different', 'foz', 'wuz')
        assert IEntry.SOURCE_FILES == data.get_source()
        assert 'foz' == data.get_key()
        assert 'wuz' == data.get_value()
        assert not data.get_mime_type()
        assert not data.get_temp_name()
        assert not data.get_error()
        assert not data.get_size()

        data.set_entry(IEntry.SOURCE_GET, 'ugg', 'huu')
        data.set_file('foo', 'uff', 'octet', 15, 20)
        assert IEntry.SOURCE_FILES == data.get_source()
        assert 'ugg' == data.get_key()
        assert 'foo' == data.get_value()
        assert 'octet' == data.get_mime_type()
        assert 'uff' == data.get_temp_name()
        assert 15 == data.get_error()
        assert 20 == data.get_size()
