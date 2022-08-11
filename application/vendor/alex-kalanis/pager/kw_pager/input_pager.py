"""
Classes and interfaces for using this pager with external input
"""

from .interfaces import IActualInput, ISettings
from .pager import BasicPager


class DefaultSettings(ISettings):

    def __init__(self, limit_per_page: int, max_results: int):
        self._max_results = max_results
        self._limit_per_page = limit_per_page

    def get_max_results(self) -> int:
        return self._max_results

    def get_limit(self) -> int:
        return self._limit_per_page


class InputPager(BasicPager):

    def __init__(self, setting: ISettings, page: IActualInput):
        super().__init__()
        self.set_max_results(setting.get_max_results())
        self.set_actual_page(page.get_actual_page())
        self.set_limit(setting.get_limit())
