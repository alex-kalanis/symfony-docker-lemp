
class TemplateException(Exception):

    def __init__(self, message: str = '', code: int = 0):

        self._message = message
        self._code = code

    def get_message(self) -> str:
        return self._message

    def get_code(self) -> int:
        return self._code


class Item:

    def __init__(self):
        self._key = ''
        self._default = ''
        self._value = None

    def set_data(self, key: str, default: str = ''):
        self._key = key
        self._default = default
        return self

    def set_value(self, value: str = None):
        self._value = value
        return self

    def update_value(self, *args):
        # equalize params counter, zero fucks about real format - that's programmer's problem
        positions = len(args)
        args = list(args)
        points = self.get_value().count('%')
        if points > positions:
            i = points - positions
            while points > i:
                args.append('')
                i += 1
        elif positions > points:
            i = positions - points
            while positions > i:
                args.pop()
                i += 1
        self._value = self.get_value() % tuple(args)
        return self

    def get_key(self) -> str:
        return self._key

    def get_default(self) -> str:
        return self._default

    def get_value(self) -> str:
        return self._value if self._value else self._default


class TInputs:
    """
     * Trait TInputs
     * Trait for "filling" input values
    """
    def _fill_inputs(self):
        pass


class TFile:
    """
     * Trait TFile
     * Trait for loading templates from files, not from code
    """

    def _load_template(self) -> str:
        path = self._template_path()
        fp = None
        try:
            fp = open(path, 'r')
            result = fp.read(100000)  # ALWAYS specify a max size (in bytes).
            fp.seek(0)
        except FileNotFoundError:
            if fp:
                fp.close()
            raise TemplateException('Template file %s not found' % path)
        except PermissionError:
            if fp:
                fp.close()
            raise TemplateException('Bad permissions for read file %s' % path)
        fp.close()
        return result

    def _template_path(self) -> str:
        raise NotImplementedError('TBA')


class ATemplate:
    """
     * Class ATemplate
     * Main work with templates - process them as either string in object or blob with points of interests
    """

    def __init__(self):
        self._template = ''
        self._default_template = ''
        self._items = []

        self._set_template(self._load_template())
        self._fill_inputs()

    def _set_template(self, content: str):
        self._default_template = content
        self.reset()
        return self

    def _load_template(self) -> str:
        """
         * Here directly set or load template from external source
        """
        raise NotImplementedError('TBA')

    def _fill_inputs(self):
        """
         * Fill inputs when need - usually at the start
        """
        raise NotImplementedError('TBA')

    def _add_input(self, key: str, default: str = '', value: str = None):
        item = Item()
        item.set_data(key, default).set_value(value)
        self._add_item(item)
        return self

    def _get_item(self, key: str):
        for item in self._items:
            if item.get_key() == key:
                return item
        return None

    def _update_item(self, key: str, value: str = None):
        item = self._get_item(key)
        if item:
            item.set_value(value)
        return self

    def _add_item(self, item: Item):
        self._items.append(item)
        return self

    def render(self) -> str:
        """
         * Render template with inserted inputs
        """
        self._process_items()
        return self.get()

    def _process_items(self):
        """
         * Process items inputs in template
        """
        for item in self._items:
            self._template = self._template.replace(item.get_key(), item.get_value())

    def change(self, which: str, to: str):
        """
         * replace part in template with another one
        """
        self._template = self._template.replace(which, to)

    def get_substring(self, begin: int, length: int = None) -> str:
        """
         * get part of template
        :param begin: int $begin where may begin
        :param length: int $length how long it is
        :return:
        """
        if begin < 0:
            begin = begin + len(self._template)
        if not length:
            return self._template[begin:]
        elif length > 0:
            return self._template[begin:begin + length]
        else:
            return self._template[begin:length]

    def position(self, what: str, begin: int = 0) -> int:
        """
         * get position of sub-string
        :param what: string $what looking for
        :param begin: int $begin after...
        :return:
        """
        try:
            return self._template.index(what, begin) if begin else self._template.index(what)
        except ValueError:
            raise TemplateException('Not found')

    def paste(self, new_string: str, from_begin: int, skipped: int = 0):
        """
         * paste (include) content on position - can rewrite old one
        :param new_string: string $newString
        :param from_begin: int $fromBeing in original string
        :param skipped: int $skip in original string
        :return:
        """
        # prepare
        from_begin = abs(from_begin)
        skipped = abs(skipped)
        # run
        left_from_begin = self._template[0: from_begin]
        left_from_end = self._template[from_begin:] if 0 == skipped else self._template[from_begin + skipped:]
        self._template = left_from_begin + new_string + left_from_end

    def get(self) -> str:
        """
         * return actual template
        """
        return self._template

    def reset(self):
        """
         * reload the template
        """
        self._template = '' + self._default_template + ''  # COPY!!!
        return self


class ExternalTemplate(ATemplate):
    """
     * Class ExternalTemplate
     * Load external source as template
    """

    def _load_template(self) -> str:
        return ''

    def set_template(self, content: str):
        return self._set_template(content)


class GroupedTemplate(ATemplate):
    """
     * Class GroupedTemplate
     * Load external source as template
    """

    known_templates = {}

    def _load_template(self) -> str:
        if len(GroupedTemplate.known_templates) < 1:
            GroupedTemplate.known_templates = self._define_available_templates()
        return ''

    def _define_available_templates(self) -> dict:
        """
         * Define templates available from this class
         * dict key is to select one, value is for content
        """
        raise NotImplementedError('TBA')

    def _reset_items(self):
        self._items = []
        return self

    def _select_template(self, key: str):
        """
         * Call only from method in extending class and be prepared for resetting items due unavailability some of them
        """
        try:
            self._set_template(GroupedTemplate.known_templates[key])
        except KeyError:
            raise TemplateException('Unknown template %s from group %s' % (key, type(self).__name__))
        return self
