#!/usr/bin/env php
<?php
set_time_limit(0);

require __DIR__.'/GenCalendarFile.php';

exit(GenCalendarFile::getCalendar($argv[1]));