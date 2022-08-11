"""
Main interfaces for using this kind of pager
"""

class IPager:
    """
     * Interface IPager
    """

    def set_max_results(self, max_results: int):
        """
         * Set maximum available results for paging
        """
        raise NotImplementedError('TBI')

    def get_max_results(self) -> int:
        """
         * Returns maximum available results for paging
        """
        raise NotImplementedError('TBI')

    def set_actual_page(self, page: int):
        """
         * Set current page number
        """
        raise NotImplementedError('TBI')

    def get_actual_page(self) -> int:
        """
         * Returns current page number
        """
        raise NotImplementedError('TBI')

    def set_limit(self, limit: int):
        """
         * Set limit of items on one page
        """
        raise NotImplementedError('TBI')

    def get_limit(self) -> int:
        """
         * Returns limit of items on one page
        """
        raise NotImplementedError('TBI')

    def get_offset(self) -> int:
        """
         * Returns calculated offset
        """
        raise NotImplementedError('TBI')

    def get_pages_count(self) -> int:
        """
         * Returns number of available pages
        """
        raise NotImplementedError('TBI')

    def page_exists(self, page: int) -> bool:
        """
         * Have we that page?
        """
        raise NotImplementedError('TBI')


class IRenderEngine:
    """
     * Interface IRenderEngine
     * How to display
    """

    def set_display_inputs_count(self, number: int):
        """
         * If rendering area has this option - how many page inputs will show themselves
        """
        raise NotImplementedError('TBI')

    def set_pager(self, pager: IPager = None):
        """
         * Set used pager
        """
        raise NotImplementedError('TBI')

    def get_pager(self):
        """
         * Get pager known to object
        """
        raise NotImplementedError('TBI')

    def render(self) -> str:
        """
         * Render content to output (cli or html)
        """
        raise NotImplementedError('TBI')


"""
Interfaces for using this pager with external input
"""


class IActualInput:
    """
     * Info from inputs on which page we are
    """

    def get_actual_page(self) -> int:
        """
         * Returns current page number
         * @return int
        """
        raise NotImplementedError('TBI')


class ISettings:
    """
     * Default settings for paging through records
    """

    def get_max_results(self) -> int:
        """
         * Returns maximum available results for paging on following objects
        """
        raise NotImplementedError('TBI')

    def get_limit(self) -> int:
        """
         * Returns limit of items on one page
        """
        raise NotImplementedError('TBI')

