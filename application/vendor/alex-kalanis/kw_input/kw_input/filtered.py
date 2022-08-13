
from kw_input.interfaces import IInputs, IEntry, IFiltered
from kw_input.input import Input
from kw_input.entries import Entry


class Variables(IFiltered):
    """
     * Helping class for passing info from inputs into objects
    """

    def __init__(self, inputs: IInputs):
        self._inputs = inputs

    def get_in_object(self, entry_key: str = None, entry_sources = None):
        return Input(self.get_in_array(entry_key, entry_sources))

    def get_in_array(self, entry_key: str = None, entry_sources = None):
        return self._into_key_object_array(self._inputs.get_in(entry_key, entry_sources))

    def _into_key_object_array(self, entries):
        result = []
        for entry in entries:
            result.append((entry.get_key(), entry))
        return dict(result)


class SimpleArrays(IFiltered):
    """
     * Helping class for passing info from simple arrays into objects
    """

    def __init__(self, inputs: dict, source: str = IEntry.SOURCE_EXTERNAL):
        self._inputs = inputs
        self._source = source

    def get_in_object(self, entry_key: str = None, entry_sources = None):
        return Input(self.get_in_array(entry_key, entry_sources))

    def get_in_array(self, entry_key: str = None, entry_sources = None):
        result = []
        for key in self._inputs:
            if (entry_key is None) or (key == entry_key):
                entry = Entry()
                entry.set_entry(self._source, str(key), self._inputs[key])
                result.append((str(key), entry))
        return dict(result)


class EntryArrays(IFiltered):
    """
     * Helping class for passing info from entry arrays into objects
    """

    def __init__(self, inputs: list):
        self._inputs = inputs

    def get_in_object(self, entry_key: str = None, entry_sources = None):
        return Input(self.get_in_array(entry_key, entry_sources))

    def get_in_array(self, entry_key: str = None, entry_sources = None):
        result = []
        for entry in self._inputs:
            pass_source = pass_key = False
            if (entry_sources is None) or (entry.get_source() in entry_sources):
                pass_source = True
            if (entry_key is None) or (entry.get_key() in entry_key):
                pass_key = True
            if pass_source and pass_key:
                result.append((entry.get_key(), entry))
        return dict(result)
