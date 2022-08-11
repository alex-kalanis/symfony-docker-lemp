
# port things from PHP


class ArrayIteratorProcessor:
    """
     * Work with arrays in practically near php-way as possible.
     * The best thing on php arrays is their work with indexes as hashes.
     * On the other side python has 3 nearly similar structures.
     * For simplify life this one saves the arrays as list of tuples.
     * Each tuple contains key and content - it could be anything
     * from simple str, int, object to another array list.
    """

    @staticmethod
    def set(array: list, key, value) -> list:
        ArrayIteratorProcessor.check_key(key)
        update = []
        updated = False
        last_index = 0
        for (k, v) in array:
            if isinstance(k, (int, float)):
                last_index = max(last_index, k)
            if key and k == key:
                v = value
                updated = True
            update.append((k, v))
        if not updated:
            if isinstance(key, (int, float)):
                update.append((last_index + 1, value))
            else:
                update.append((key, value))
        return update

    @staticmethod
    def is_set(array: list, key) -> bool:
        ArrayIteratorProcessor.check_key(key)
        for (k, v) in array:
            if k == key:
                return True
        return False

    @staticmethod
    def get(array: list, key):
        ArrayIteratorProcessor.check_key(key)
        for (k, v) in array:
            if k == key:
                return v
        raise ValueError('Entry %s not found' % key)

    @staticmethod
    def remove(array: list, key) -> list:
        ArrayIteratorProcessor.check_key(key)
        update = []
        for (k, v) in array:
            if k != key:
                update.append((k, v))
        return update

    @staticmethod
    def check_key(key) -> bool:
        if key is None:
            return True
        if not isinstance(key, (int, float, str)):
            raise KeyError('Incorrect key format, need int or string')
        return True


class ArrayIterator:
    """
     * Practically port ArrayIterator from PHP
    """

    def __init__(self, array: list = None):
        self._array = array if array else []
        self._iter_key = 0

    def __contains__(self, key):
        return self.is_set(key)

    def __getattr__(self, key):
        """
         * Automatic access to child via Element.alias()
        """
        return self.get(key)

    def __setattr__(self, key, value):
        """
         * Set child directly by setting a property of this class
        """
        self.set(key, value)

    def __delattr__(self, key):
        self.remove(key)

    def __len__(self):
        return len(self._array)

    def __iter__(self):
        self._iter_key = 0
        return self

    def __next__(self):
        key = self._iter_key
        self._iter_key =+ 1
        if self._iter_key > len(self._array):
            raise StopIteration()
        return self._array[key]

    def set(self, key, value):
        self._array = ArrayIteratorProcessor.set(self._array, key, value)

    def is_set(self, key) -> bool:
        return ArrayIteratorProcessor.is_set(self._array, key)

    def get(self, key):
        try:
            return ArrayIteratorProcessor.get(self._array, key)
        except ValueError:
            return None

    def remove(self, key):
        self._array = ArrayIteratorProcessor.remove(self._array, key)
