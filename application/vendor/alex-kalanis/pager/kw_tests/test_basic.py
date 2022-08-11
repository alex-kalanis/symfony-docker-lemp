from kw_tests.common_class import CommonTestClass
from kw_pager.input_pager import DefaultSettings, InputPager
from kw_pager.interfaces import IActualInput
from kw_pager.pager import BasicPager


class BasicTest(CommonTestClass):

    def test_basics(self):
        pager = BasicPager()
        pager.set_max_results(75).set_limit(12).set_actual_page(4)

        assert pager.page_exists(6)
        assert pager.page_exists(7)
        assert not pager.page_exists(8)
        assert not pager.page_exists(-2)
        assert 7 == pager.get_pages_count()

        assert 75 == pager.get_max_results()
        assert 12 == pager.get_limit()
        assert 4 == pager.get_actual_page()
        assert 36 == pager.get_offset()

        # fun begins
        assert 0 == pager.set_actual_page(1).get_offset()  # okay
        assert 12 == pager.set_actual_page(2).get_offset()  # okay
        assert 0 == pager.set_actual_page(0).get_offset()  # outside - too low
        assert 0 == pager.set_actual_page(9).get_offset()  # outside - too high

        # change limits
        assert 15 == pager.set_limit(5).get_pages_count()
        assert 40 == pager.set_actual_page(9).get_offset()

    def test_results(self):
        pager = BasicPager()
        pager.set_max_results(0).set_limit(12).set_actual_page(7)

        assert 1 == pager.get_pages_count()
        assert 0 == pager.get_offset()

    def test_input(self):
        pager = InputPager(DefaultSettings(12, 75), MockInput())

        assert pager.page_exists(6)
        assert pager.page_exists(7)
        assert not pager.page_exists(8)
        assert not pager.page_exists(-2)
        assert 7 == pager.get_pages_count()

        assert 75 == pager.get_max_results()
        assert 12 == pager.get_limit()
        assert 4 == pager.get_actual_page()
        assert 36 == pager.get_offset()


class MockInput(IActualInput):

    def get_actual_page(self) -> int:
        return 4
