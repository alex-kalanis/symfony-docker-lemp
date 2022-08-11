
from .php import ArrayIteratorProcessor


class IAttributes:
    """
     * Contains constants used across the project which cannot be defined in traits
    """

    ATTR_NAME_CLASS = 'class'
    ATTR_SEP_CLASS = ' '
    ATTR_NAME_STYLE = 'style'
    ATTR_SEP_STYLE = ';'
    ATTR_SET_STYLE = ':'

    def add_attributes(self, attribs):
        """
         * Add array of attributes into current object attributes
         * attribs is array of tuples [(key, val), (key, val), ...] or string
        """
        # import pprint
        # pprint.pprint(vals)
        raise NotImplementedError('TBA')

    def set_attributes(self, attribs):
        """
         * Set attributes, leave nothing from previous ones
        """
        raise NotImplementedError('TBA')

    def get_attributes(self) -> list:
        """
         * Get all available attributes
        """
        raise NotImplementedError('TBA')

    def get_attribute(self, name: str):
        """
         * Get attribute value
        """
        raise NotImplementedError('TBA')

    def set_attribute(self, name: str, value: str):
        """
         * Set attribute value
         * only one allowed
        """
        raise NotImplementedError('TBA')


class IElement(IAttributes):
    """
     * Abstraction of element - included class for passing references onto self
    """

    def get_alias(self):
        """
         * Returns object alias
        """
        raise NotImplementedError('TBA')

    def render(self) -> str:
        """
         * Render element
        """
        raise NotImplementedError('TBA')

    def set_children(self, children=None):
        """
         * Set children of element
        """
        raise NotImplementedError('TBA')

    def get_children(self):
        """
         * Return all children as iterator
        """
        raise NotImplementedError('TBA')


class IHtmlElement(IElement):
    """
     * Abstraction of element - included class for passing references onto self
    """

    def get_alias(self):
        """
         * Returns object alias
        """
        raise NotImplementedError('TBA')

    def render(self) -> str:
        """
         * Render element
        """
        raise NotImplementedError('TBA')

    def add_child(self, child, alias=None, merge: bool = False, inherit: bool = False):
        """
         * Add child on stack end or replace the current one (if they have same alias)
         * @param AHtmlElement|string $child
         * @param string|None $alias - key for lookup; beware of empty strings
         * @param bool $merge merge with original element if already exists
         * @param bool $inherit inherit properties from current element
         * @return $this
        """
        raise NotImplementedError('TBA')

    def merge(self, child: IElement):
        """
         * Merge this element with child and its attributes
         * has param as IElement because python dislikes pointer to self
        """
        raise NotImplementedError('TBA')

    def remove_child(self, child_alias):
        """
         * Remove child by key
        """
        raise NotImplementedError('TBA')

    def last_child(self):
        """
         * Return last child
        """
        raise NotImplementedError('TBA')

    def set_children(self, children=None):
        """
         * Set children of element
        """
        raise NotImplementedError('TBA')

    def get_children(self):
        """
         * Return all children as iterator
        """
        raise NotImplementedError('TBA')


class TAttributes(IAttributes):
    """
     * Trait for work with attributes
     * It's not necessary to have attributes directly in HtmlElement
    """

    def __init__(self):
        self._attributes = []

    def _render_attributes(self, attribs = None) -> str:
        """
         * Returns serialized attributes
         * Use $attributes param if is set
        """
        attribs = self._attributes if not attribs else self.attributes_parse(attribs)

        result = ''
        for (name, value) in tuple(attribs):
            result += ' %s="%s"' % (name, value)

        return result

    def add_attributes(self, attribs):
        """
         * Add array of attributes into current object attributes
         * attribs is array of tuples [(key, val), (key, val), ...] or string
        """
        # import pprint
        # pprint.pprint(vals)
        for (k, v) in self.attributes_parse(attribs):
            self.set_attribute(k, v)

    def attributes_parse(self, attribs) -> list:
        """
         * Change attributes in variable to 2-dimensional array
         * Expects array, discard rest
        """
        attribs = self._attributes_parse_array(attribs) if isinstance(attribs, (list, dict, tuple)) else self.attributes_parse_string(attribs)
        return self.attributes_parse_tuple(attribs)

    def _attributes_parse_array(self, attribs) -> list:
        result = []
        for attrib in attribs:
            k = v = None
            if isinstance(attrib, list):
                k = attrib[0]
                v = attrib[1:]
            elif isinstance(attrib, dict):
                attrib = tuple(attrib)
                k = attrib[0]
                v = attrib[1:]
            elif isinstance(attrib, tuple):
                k = attrib[0]
                v = attrib[1:]
            if k and v:
                result.append((str(k), v))
        return result

    def attributes_parse_tuple(self, attribs) -> list:
        """
         * Change attributes in variable to 2-dimensional array
         * Expects array, discard rest
        """
        array = []
        for (key, value) in attribs:
            if isinstance(key, str):
                array.append((key.lower(), self._reduce_value(value).lower()))
        return array

    def _reduce_value(self, original, joined='') -> str:
        """
         * deep-level solution for problems with multi-layer arrays in python
        """
        if isinstance(original, (str, int, float, enumerate)):
            return str(original)
        elif isinstance(original, (list, dict, tuple)):
            result = []
            for value in original:
                result.append(self._reduce_value(value, ';'))
            return joined.join(result)

    def attributes_parse_string(self, attribs) -> list:
        """
         * Change attributes to 2-dimensional array
         * Expects string like: width="100px" height='150px' style="color:red"
         * Discard rest
        """
        import re
        array = []
        string = str(attribs).strip()
        pattern = r'([a-z]+)\=("|\')?(.+?)(?(2)\2)(\s|$)'
        for matches in re.finditer(pattern, string):
            key = str(matches.group(1)).strip()
            value = str(matches.group(3)).strip()
            array.append((key, value))
        return array

    def set_attributes(self, attribs):
        """
         * Set attributes, leave nothing from previous ones
        """
        self._attributes = []
        self.add_attributes(attribs)

    def get_attributes(self) -> list:
        """
         * Get all available attributes
        """
        return self._attributes

    def get_attribute(self, name: str):
        """
         * Get attribute value
        """
        try:
            return ArrayIteratorProcessor.get(self._attributes, name)
        except ValueError:
            return None

    def set_attribute(self, name: str, value: str):
        """
         * Set attribute value
         * only one allowed
        """
        self._attributes = ArrayIteratorProcessor.set(self._attributes, name, value)

    def remove_attribute(self, name):
        """
         * Remove attribute
        """
        self._attributes = ArrayIteratorProcessor.remove(self._attributes, name)


class TStyles(TAttributes):
    """
     * Trait for work with cascade style sheets - direct access to styles
     * Extend child of AHtmlElement
    """

    def add_css(self, name: str, value: str):
        self._update_css(ArrayIteratorProcessor.set(self._read_css(), name, value))
        return self

    def get_css(self, name: str):
        try:
            return ArrayIteratorProcessor.get(self._read_css(), name)
        except ValueError:
            return None

    def remove_css(self, name: str):
        self._update_css(ArrayIteratorProcessor.remove(self._read_css(), name))
        return self

    def _read_css(self):
        attr_style = self.get_attribute(IAttributes.ATTR_NAME_STYLE)
        if not attr_style:
            return []
        parts = attr_style.split(IAttributes.ATTR_SEP_STYLE)
        styles = []
        for part in parts:
            if part and (IAttributes.ATTR_SET_STYLE in part):
                kv = part.split(IAttributes.ATTR_SET_STYLE)
                styles.append((kv[0], kv[1]))
        return styles

    def _update_css(self, attr_style):
        style = ''
        for (k, v) in attr_style:
            style += '%s%s%s%s' % (k, IAttributes.ATTR_SET_STYLE, v, IAttributes.ATTR_SEP_STYLE)
        self.set_attribute(IAttributes.ATTR_NAME_STYLE, style)


class TCss(TAttributes):
    """
     * Trait for work with cascade style sheets - via classes
     * Extend child of AHtmlElement
    """

    def add_class(self, name: str):
        """
         * Add class into attribute class
        """
        data = self.get_attribute(IAttributes.ATTR_NAME_CLASS)
        if data:
            entries = list(data.split(IAttributes.ATTR_SEP_CLASS))
            if name not in entries:
                entries.append(name)
                self.set_attribute(IAttributes.ATTR_NAME_CLASS, IAttributes.ATTR_SEP_CLASS.join(entries))
        else:
            self.set_attribute(IAttributes.ATTR_NAME_CLASS, name)
        return self

    def remove_class(self, name):
        """
         * Remote class from attribute class
        """
        data = self.get_attribute(IAttributes.ATTR_NAME_CLASS)
        if data:
            entries = list(data.split(IAttributes.ATTR_SEP_CLASS))
            left = []
            for entry in entries:
                if entry != name:
                    left.append(entry)
            self.set_attribute(IAttributes.ATTR_NAME_CLASS, IAttributes.ATTR_SEP_CLASS.join(left))
        return self


class THtml:
    """
     * Trait for describe internal content of element, usually HTML code
     * Extend child of AHtmlElement
    """

    def __init__(self):
        self._inner_html = ''

    def add_inner_html(self, value: str):
        """
         * Set internal content of element
        """
        self._inner_html = value
        return self

    def get_inner_html(self) -> str:
        """
         * Get internal content of element
        """
        return self._inner_html


class TElement(TAttributes):
    """
     * Abstraction of element - included class for passing references onto self
    """

    def __init__(self):
        super().__init__()
        self._template = ''
        self._children = []
        self._child_delimiter = "\n"
        self._alias = None

    def get_alias(self):
        """
         * Returns object alias
        """
        return self._alias

    def render(self) -> str:
        """
         * Render element
        """
        raise NotImplementedError('TBA')

    def set_children(self, children=None):
        """
         * Set children of element
        """
        raise NotImplementedError('TBA')

    def get_children(self):
        """
         * Return all children as iterator
        """
        yield from self._children


class TParent:
    """
     * Trait for work with parenting of html elements
    """

    def __init__(self):
        """
         * Included Trait for work with parenting of html elements
        """
        self._parent = None

    def set_parent(self, parent: TElement = None):
        """
         * Set parent element
        """
        self._parent = parent
        self._after_parent_set()
        return self

    def get_parent(self) -> TElement:
        """
         * Returns parent element
        """
        return self._parent

    def _after_parent_set(self):
        """
         * Change element settings after new parent has been set
        """
        pass

    def append(self, element, alias: str = None):
        """
         * Add $element after current one - if there is any parent
        """
        if isinstance(self._parent, IHtmlElement):
            self._parent.add_child(element, alias)
        return self


class THtmlElement(TElement, TParent, IHtmlElement):
    """
     * Abstraction of HTML element
     * Each HTML element must have a few following things
     * 1. must be able to render self
     * 2. must can tell what children have
     *    it's possible to have 0 - n children
     * 3. must know its parent
     *    can have 0 or 1 parent
     * 4. must know its attributes
     *    can have 0 - n attributes
    """

    def __init__(self):
        """
         * Included Trait for work with parenting of html elements
        """
        super().__init__()
        # super(TElement).__init__()
        # super(TParent).__init__()
        self._parent = None
        self._iter_key = 0

    def render(self) -> str:
        """
         * Render element
        """
        return self._template % (self._render_attributes(), self.render_children())

    def render_children(self) -> str:
        """
         * render children into serialized strings
        """
        return self._child_delimiter.join(map(self._render_child, self._children))

    def _render_child(self, child: IHtmlElement) -> str:
        return child.render()

    def add_child(self, child, alias=None, merge: bool = False, inherit: bool = False):
        """
         * Add child on stack end or replace the current one (if they have same alias)
         * @param IHtmlElement|string $child
         * @param string|None $alias - key for lookup; beware of empty strings
         * @param bool $merge merge with original element if already exists
         * @param bool $inherit inherit properties from current element
        """
        if isinstance(child, (IHtmlElement, THtmlElement, TElement)):
            if not self._check_alias(alias):
                alias = child.get_alias()
        else:
            alias = str(alias) if self._check_alias(alias) else None
            child = Text(str(child), alias)
        child.set_parent(self)

        child = self.merge(child) if merge and ArrayIteratorProcessor.is_set(self._children, alias) else child
        child = self.inherit(child) if inherit else child
        self._children = ArrayIteratorProcessor.set(self._children, alias, child)

    def _check_alias(self, alias) -> bool:
        return not ( (alias is None) or ('' == alias)
                     or (not isinstance(alias, (int, float, enumerate, str)))
                   )

    def merge(self, child: IHtmlElement):
        """
         * Merge this element with child and its attributes
        """
        self.set_children(child.get_children())
        self.set_attributes(child.get_attributes())

    def inherit(self, child: IHtmlElement) -> IHtmlElement:
        """
         * Inheritance - set properties of this object into the child
        """
        import copy
        element = copy.copy(child)
        element.add_attributes(self.get_attributes())
        element.set_children(self.get_children())
        return element

    def remove_child(self, child_alias):
        """
         * Remove child by key
        """
        self._children = ArrayIteratorProcessor.remove(self._children, child_alias)

    def last_child(self):
        """
         * Return last child
        """
        try:
            return self._children[-1]
        except KeyError:
            return None

    def set_children(self, children=None):
        """
         * Set children of element
        """
        if isinstance(children, list):
            for (alias, child) in children:
                self.add_child(
                    child,
                    child.get_alias() if isinstance(alias, (int, float)) and self._check_alias(child.get_alias()) else alias
                )


class AHtmlElement(THtmlElement):
    """
     * Abstraction of HTML element - this is compact class which only needs extending
    """

    def __str__(self):
        return self.render()

    def __contains__(self, item):
        return ArrayIteratorProcessor.is_set(self._children, item)

    def __getattr__(self, item):
        """
         * Automatic access to child via Element->childAlias()
        """
        try:
            return self.item
        except AttributeError:
            try:
                if ArrayIteratorProcessor.is_set(self._children, item):
                    return ArrayIteratorProcessor.get(self._children, item)
                else:
                    raise
            except ValueError:
                return None

    def __setattr__(self, key, value):
        """
         * Set child directly by setting a property of this class
        """
        try:
            setattr(self, key, value)
        except AttributeError:
            self.add_child(value, key)

    def __call__(self, method, *args, **kwargs):
        if 1 == len(args):
            return self.set_attribute(method, args[0])
        elif 0 == len(args):
            return self.get_attribute(method)

    def __delattr__(self, item):
        if not hasattr(self, item):
            self.remove_child(item)

    def __iter__(self):
        self._iter_key = 0
        return self

    def __next__(self):
        key = self._iter_key
        self._iter_key =+ 1
        if self._iter_key > len(self._array):
            raise StopIteration()
        return self._children[key]

    def __len__(self):
        return len(self._children)


class Text(AHtmlElement, THtml):
    """
     * Set text as simple HTML element
    """

    def __init__(self, value: str, alias: str = None):
        super(AHtmlElement).__init__()
        super(THtml).__init__()
        self._alias = alias
        self.add_inner_html(value)

    def render(self) -> str:
        return self.get_inner_html()


class HtmlElement(AHtmlElement, TStyles, TCss):
    """
     * Basic html element - for render simple nodes
    """

    empty_elements = ['img','hr','br','input','meta','area','embed','keygen','link','param','frame']

    @staticmethod
    def init(name: str, attributes: list = None):
        return HtmlElement(name, attributes)

    def __init__(self, name: str, attributes: list = None):
        super().__init__()

        name = name.replace('<','')
        name = name.replace('>','')
        parts = name.split(' ', 2)
        self._name = parts[0]

        if self._name in self.empty_elements:
            self._template = '<' + self._name + '%1$s />'
        else:
            self._template = '<' + self._name + '%1$s>%2$s</' + self._name + '>'

        self.add_attributes(attributes)
        if parts[1]:
            self.add_attributes(parts[1])
