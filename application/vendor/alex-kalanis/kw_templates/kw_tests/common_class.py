import unittest
from kw_templates.template import Item


class CommonTestClass(unittest.TestCase):

    def _mock_item(self) -> Item:
        return Item().set_data(
            'testing content',
            'default content %s'
        )
