
from kw_templates.html_element import TAttributes, TStyles, TCss, AHtmlElement
from kw_tests.common_class import CommonTestClass


class AttributeTest(CommonTestClass):
    """
     * How to check traits? Python in fact has nothing like that.
    """

    def test_simple(self):
        data = TAttributes()
        assert not data.get_attributes()
        assert not data.get_attribute('foo')
        data.set_attribute('foo', 'bar')
        assert 'bar' == data.get_attribute('foo')
        data.set_attribute('foo', 'baz')
        assert 'baz' == data.get_attribute('foo')
        data.remove_attribute('foo')
        assert not data.get_attribute('foo')
        assert not data.get_attributes()

    def test_extend(self):
        data = TAttributes()
        assert not data.get_attributes()
        data.set_attribute('foo', 'bar')
        data.set_attribute('ijn', 'ujm')
        data.add_attributes([
                ('ijn', 'zgv'),
                ('edc', 'rdx'),
            ])
        assert 'zgv' == data.get_attribute('ijn')
        data.add_attributes([(
                'ojv', [
                    'lkj',
                    'nbv',
                    'gfd',
                ],
            )])
        assert 'lkj;nbv;gfd' == data.get_attribute('ojv')

        data.set_attributes([])
        assert not data.get_attributes()

    def test_string_input(self):
        data = TAttributes()
        assert not data.get_attributes()
        data.add_attributes('avail="from:left;insecure:15em;"')
        assert 'from:left;insecure:15em;' == data.get_attribute('avail')
        data.set_attribute('avail', 'xrb')
        assert 'xrb' == data.get_attribute('avail')

    def test_render(self):
        data = TAttributes()
        assert not data.get_attributes()
        data.add_attributes('avail="from:left;insecure:15em;"')
        data.set_attribute('foo', 'bar')
        data.set_attribute('ijn', 'ujm')
        assert ' avail="from:left;insecure:15em;" foo="bar" ijn="ujm"' == data._render_attributes()


class StylesTest(CommonTestClass):
    """
     * How to check traits? Extend them.
    """

    def test_simple(self):
        data = TStyles()
        assert not data.get_attributes()
        assert not data.get_attribute('style')
        data.add_css('foo', 'snt')
        data.add_css('bar', 'fgs')
        data.add_css('baz', 'sdf')
        assert 'sdf' == data.get_css('baz')
        assert 'foo:snt;bar:fgs;baz:sdf;' == data.get_attribute('style')
        data.remove_css('bar')
        assert 'foo:snt;baz:sdf;' == data.get_attribute('style')


class CssTest(CommonTestClass):

    def test_simple(self):
        data = TCss()
        assert not data.get_attributes()
        assert not data.get_attribute('class')
        data.add_class('foo')
        data.add_class('bar')
        data.add_class('baz')
        assert 'foo bar baz' == data.get_attribute('class')
        data.remove_class('bar')
        assert 'foo baz' == data.get_attribute('class')


class Element(AHtmlElement):

    def __init__(self, alias: str = ''):
        super().__init__()
        self._template = '--%s-- %s'
        self._alias = alias


class SomeChild(AHtmlElement):

    def __init__(self, alias: str = ''):
        super().__init__()
        self._template = '::poiuztrewq %s %s'


class ElseChild(AHtmlElement):

    def __init__(self, alias: str = ''):
        super().__init__()
        self._template = '::lkjhgfdsa %s %s'


class NextChild(AHtmlElement):

    def __init__(self, alias: str = ''):
        super().__init__()
        self._template = 'mnbvcxy %s %s'


class ElementTest(CommonTestClass):

    def test_simple(self):
        data = Element('exe')
        assert 'exe' == data.get_alias()

    def test_attributes(self):
        data = Element('exe')
        assert not data.dummy()
        data.dummy('resggs')
        assert 'resggs' == data.dummy()
        data.remove_attribute('dummy')
        assert not data.dummy()
        data.foo('fkhlg', 'fpklasg')
        assert not data.foo()

    def test_children(self):
        data = Element('exe')
        assert not data.get_children()
        data.set_children([
            (0, SomeChild()),
            ('dome', ElseChild()),
        ])
        assert not data.dummy
        data.dummy = 'resggs'
        assert isinstance(data.dummy, AHtmlElement)
        assert isinstance(data.dome, AHtmlElement)
        assert isinstance(data.__getattr__(0), AHtmlElement)
        data.__setattr__('or', NextChild())
        data.remove_child('dome')
        assert not data.__contains__('dome')
        assert 'dome' not in data

    def test_inheritance(self):
        original = Element('exe')
        original.set_attributes([
            ('cde', 'zfx'),
            ('vfr', 'ohv'),
        ])
        sender = SomeChild()
        result = original.inherit(sender)

        assert 'ohv' == result.get_attribute('vfr')
        assert 'zfx' == result.get_attribute('cde')
        assert result != original

    def test_merge(self):
        data = Element('exe')
        data.set_attributes([
            ('cde', 'zfx'),
            ('vfr', 'ohv'),
        ])
        result = SomeChild()
        result.merge(data)

        assert 'ohv' == result.get_attribute('vfr')
        assert 'zfx' == result.get_attribute('cde')

    def test_render(self):
        data = Element('exe')
        data.set_attributes([
            ('cde', 'zfx'),
            ('vfr', 'ohv'),
        ])
        data1 = SomeChild()
        data1.setAttributes([
            ('vfr', 'ohv'),
        ])
        data2 = ElseChild()
        data2.set_attributes([
            ('cde', 'zfx'),
        ])

        data.add_child(data1)
        data.add_child(data2)

        assert '-- cde="zfx" vfr="ohv"-- ::poiuztrewq  vfr="ohv" ' + "\n" + '::lkjhgfdsa  cde="zfx" ' == data.render()
