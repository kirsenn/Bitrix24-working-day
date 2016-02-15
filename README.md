Bitrix24
Авто начало и конец рабочего дня.

If you are lazy enough or just forgetful to start/end your working day in Bitrix 24, use this script. Just add command to your crontab as follows:

`php korportal.php action`

To add some randomness in seconds use $randomSleep variable in options.php

---
Available actions:

* 'open': start your working day
* 'pause': pause (if you gonna go for lunch or something)
* 'reopen': continue your working day after you've paused it
* 'close': end your working day
* 'update': retrieves status information
