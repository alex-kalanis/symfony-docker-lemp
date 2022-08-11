#!/usr/bin/php
<?php

echo "\e[1;33mtest path from cwd\e[0m" . PHP_EOL;
echo "\e[32m cwd: \e[0m\e[35m" . getcwd() . "\e[0m" . PHP_EOL;
echo "\e[32m dir: \e[0m\e[35m" . __DIR__ . "\e[0m" . PHP_EOL;
