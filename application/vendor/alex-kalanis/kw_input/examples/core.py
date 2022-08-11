# example core loads

from kw_input.input import Inputs
from kw_input.sources import ISource


class Core1:

    def __init__(self):
        self._inputs = None

    # ...

    def set_inputs(self, inputs: Inputs):
        self._inputs = inputs

    # ...


class Core2:

    def __init__(self, cli_args=None):
        self._inputs = Inputs(Basic())
        self._inputs.set_source(cli_args).load_entries()
        # ...

    # ...


class Basic(ISource):
    """
     * Source of values to parse and use
     * each method returns a dict or compatible tuple
    """

    def get(self):
        return None

    def post(self):
        return None

    def files(self):
        return None

    def session(self):
        return None

    def server(self):
        return None

    def env(self):
        return None
