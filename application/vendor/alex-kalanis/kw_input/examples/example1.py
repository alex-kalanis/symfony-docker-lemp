from .core import Basic, Core1
from kw_input.input import Inputs
import sys

# ...

# init inputs - they are on the verge for using as global variable
inputs = Inputs(Basic())
inputs.set_source(sys.argv).load_entries() # argv is for params from cli

# ...

# init core
system = Core1()

# ...

system.set_inputs(inputs)  # and kwcms3 core got every input value that came in the same defined way

# ...
