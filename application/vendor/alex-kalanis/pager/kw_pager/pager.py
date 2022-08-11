"""
Main classes for using this kind of pager
"""

from .interfaces import IPager, IRenderEngine


class BasicPager(IPager):

    def __init__(self):
        self._max_results = 0
        self._actual_page = 0
        self._limit_per_page = 0

    def set_max_results(self, max_results: int):
        self._max_results = max_results
        return self

    def get_max_results(self) -> int:
        return self._max_results

    def set_actual_page(self, page: int):
        self._actual_page = page
        return self

    def get_actual_page(self) -> int:
        return self._actual_page

    def set_limit(self, limit: int):
        self._limit_per_page = limit
        return self

    def get_limit(self) -> int:
        return self._limit_per_page

    def get_offset(self) -> int:
        page = int(self._actual_page - 1)
        if self.page_exists(page):
            return int(page * self._limit_per_page)
        else:
            return 0

    def get_pages_count(self) -> int:
        if 0 >= self._max_results:
            return 1
        last_page_items = self._max_results % self._limit_per_page
        page = int(self._max_results / self._limit_per_page)
        return page + 1 if last_page_items > 0 else page

    def page_exists(self, page: int) -> bool:
        return (0 < page) and (page <= self.get_pages_count())
