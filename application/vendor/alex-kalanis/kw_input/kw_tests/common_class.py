import unittest


class CommonTestClass(unittest.TestCase):
    """
    Used format is list of tuples where first item is string key and second is mixed value
    Total madness by typing, but something tells me it's correct pythonic way
    """

    def entry_dataset(self):
        return [
            ('foo', 'val1'),
            ('bar', ['bal1', 'bal2']),
            ('baz', True),
            ('aff', 42),
        ]

    def strange_entry_dataset(self):
        return [
            ('foo  ', ' val1 '),
            ('ba' + chr(0) + 'r', ["<script>alert('XSS!!!')</script>", 'bal2']),
            ('b<a>z', False),
            ('a**ff', '<?php echo "ded!";'),
        ]

    def file_dataset(self):
        return [
            ('files', [  # simple upload
                ('name', 'facepalm.jpg'),
                ('type', 'image/jpeg'),
                ('tmp_name', '/tmp/php3zU3t5'),
                ('error', 0),
                ('size', 591387),
            ]),
            ('download', [  # multiple upload
                ('name', [
                    ('file1', 'MyFile.txt'),
                    ('file2', 'MyFile.jpg'),
                ]),
                ('type', [
                    ('file1', 'text/plain'),
                    ('file2', 'image/jpeg'),
                ]),
                ('tmp_name', [
                    ('file1', '/tmp/php/phpgj46fg'),
                    ('file2', '/tmp/php/php7s4ag4'),
                ]),
                ('error', [
                    ('file1', 7),
                    ('file2', 3),
                ]),
                ('size', [
                    ('file1', 816),
                    ('file2', 3075),
                ]),
            ]),
        ]

    def strange_file_dataset(self):
        return [
            ('fi' + chr(0) + 'les', [  # simple upload
                ('name', 'face' + chr(0) + 'palm.jpg'),
                ('type', 'image<?= \'/\'; ?>jpeg'),
                ('tmp_name', '/tmp/php3zU3t5'),
                ('error', 0),
                ('size', '591387'),
            ]),
            ('download', [  # multiple upload
                ('name', [
                    ('file1', 'C:\System\MyFile.txt'),
                    ('file2', 'A:\MyFile.jpg'),
                ]),
                ('type', [
                    ('file1', 'text/plain'),
                    ('file2', 'image/jpeg'),
                ]),
                ('tmp_name', [
                    ('file1', '/tmp/php/phpgj46fg'),
                    ('file2', '/tmp/php/php7s4ag4'),
                ]),
                ('error', [
                    ('file1', 7),
                    ('file2', 3),
                ]),
                ('size', [
                    ('file1', 816),
                    ('file2', 6874),
                ]),
            ]),
        ]

    def cli_dataset(self):
        return [
            '--testing=foo',
            '--bar=baz',
            '--file1=./data/tester.gif',
            '--file2=data/testing.1.txt',
            '--file3=./data/testing.2.txt',
            '-abc',
            'known',
            'what',
        ]

    def strange_cli_dataset(self):
        return [
            '--tes' + chr(0) + 'ting=f<o>o',
            '---bar=b**a**z',
            '-a-*c',
        ]
