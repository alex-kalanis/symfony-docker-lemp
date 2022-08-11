import copy
import os
from kw_templates.template import Item, ATemplate, ExternalTemplate, GroupedTemplate, TInputs, TFile, TemplateException
from kw_tests.common_class import CommonTestClass


class MockTemplate1(TInputs, ATemplate):

    def _load_template(self) -> str:
        return 'Testing content for your play - it needs more than simple check'


class MockTemplate2(ATemplate):

    def _fill_inputs(self):
        self._add_input('/fill/', 'known issues')

    def _load_template(self) -> str:
        return 'Another template for fun with /fill/'

    def update_fill(self):
        self._update_item('/fill/', 'lost ideas')

    def get_existing(self):
        return self._get_item('/fill/')

    def get_problematic(self):
        return self._get_item('/none/')


class MockGroupedTemplate1(TInputs, GroupedTemplate):

    def _define_available_templates(self) -> dict:
        return {
            'head': 'available from *what*',
            'ul': 'unordered list: *content*',
        }

    def use_head(self):
        self._reset_items()
        self._select_template('head')
        self._add_input('*what*', 'nowhere', 'every part')

    def use_ul(self):
        self._reset_items()
        self._select_template('ul')
        self._add_input('*content*', 'not found', 'found')

    def use_unknown(self):
        self._reset_items()
        self._select_template('fake')


class MockExternalTemplate1(TInputs, ExternalTemplate):
    pass


class MockFileTemplate1(TInputs, TFile, ATemplate):

    def _template_path(self) -> str:
        dir_path = os.path.dirname(os.path.realpath(__file__))
        return os.path.join(dir_path, '..', 'php-tests', 'dummy_content.txt')


class MockFileTemplate2(TInputs, TFile, ATemplate):

    def _template_path(self) -> str:
        dir_path = os.path.dirname(os.path.realpath(__file__))
        return os.path.join(dir_path, '..', 'php-tests', 'failed_content.txt')


class ItemTest(CommonTestClass):

    def test_simple(self):
        data = self._mock_item()
        assert isinstance(data, Item)
        assert 'testing content' == data.get_key()
        assert 'default content %s' == data.get_default()
        assert 'default content %s' == data.get_value()

        data.set_value('different %s %s')
        assert 'default content %s' != data.get_value()
        assert 'different %s %s' == data.get_value()

        data.update_value('conv', 'val')
        assert 'different conv val' == data.get_value()

        data.set_value(None)
        data.update_value('conv', 'val')
        assert 'default content conv' == data.get_value()

        data2 = copy.copy(data)
        data2.set_data('new test', 'another content %f')
        assert 'new test' == data2.get_key()
        assert 'new test' != data.get_key()


class TemplateTest(CommonTestClass):

    def test_simple(self):
        template = MockTemplate1()
        assert 'Testing content for your play - it needs more than simple check' == template.render()
        template.change('e', 'x')
        assert 'Txsting contxnt for your play - it nxxds morx than simplx chxck' == template.render()
        template.reset()
        assert ' more than s' == template.get_substring(40, 12)

        template.paste('no less', 32, 13)
        assert 'Testing content for your play - no less than simple check' == template.render()

    def test_nothing_found(self):
        try:
            template = MockTemplate1()
            assert 35 == template.position('needs')
            template.position('needs', 45)  # crash - nothing found
            assert False
        except TemplateException:
            assert True

    def test_inputs(self):
        template = MockTemplate2()
        assert 'Another template for fun with known issues' == template.render()
        template.reset()
        template.update_fill()
        assert 'Another template for fun with lost ideas' == template.render()
        item = template.get_existing()
        assert '/fill/' == item.get_key()
        assert 'lost ideas' == item.get_value()
        assert not template.get_problematic()


class GroupTemplateTest(CommonTestClass):

    def test_simple(self):
        template = MockGroupedTemplate1()
        assert not template.render()
        template.use_head()
        assert 'available from every part' == template.render()
        template.use_ul()
        assert 'available from every part' != template.render()
        assert 'unordered list: found' == template.render()

    def test_nothing_found(self):
        try:
            template = MockGroupedTemplate1()
            template.use_unknown()  # crash - nothing found
            assert False
        except TemplateException:
            assert True


class ExternalTemplateTest(CommonTestClass):

    def test_simple(self):
        template = MockExternalTemplate1()
        assert not template.render()
        template.set_template('Testing content for your play - it needs more than simple check')
        assert 'Testing content for your play - it needs more than simple check' == template.render()


class FileTemplateTest(CommonTestClass):

    def test_simple(self):
        template = MockFileTemplate1()
        assert 'Something to test' == template.render()

    def test_unknown(self):
        try:
            MockFileTemplate2()
            assert False
        except TemplateException:
            assert True
