
from kw_templates.template import ATemplate, TFile
import os


class HeaderTmpl(ATemplate, TFile):

    def _template_path(self) -> str:
        # get path to file - shared between languages
        dir_path = os.path.dirname(os.path.realpath(__file__))
        return os.path.join(dir_path, '..', 'shared-example', 'header.html')

    def _fill_inputs(self):
        # set which keys will be looked for and what default values they will need
        # usually it's good thing to set default values as some main language
        self._add_input('{TITLE}', 'Example for %s', 'Example for loading')
        self._add_input('{ENCODING}', 'utf-8')
        self._add_input('{CONTENT}', 'HTML page - example of filling with these templates.')

    def set_data(self):
        # this is example how to update values
        self._get_item('{ENCODING}').set_value('win-1250')
        # another way is re-set them
        self._update_item('{CONTENT}', 'HTML - updated after load, not before')
        # last one is to change values depending on state of code
        input = self._get_item('{ENCODING}')
        input.set_value(input.get_default() % 'running')
        input.update_value(tuple('trash'))

        # now just call HeaderTmpl.render() and dump output where you wish
