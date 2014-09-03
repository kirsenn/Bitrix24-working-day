Bitrix24-working-day
The script for auto start/end/pause working day in Bitrix 24

If you are lazy enough or just forgetful to start/end your working day in Bitrix 24, use this script. Just add command to your crontab as follows:

`php korportal.php action`

To add some randomness use next command in cron:
sleep ${RANDOM:0:1}m; php korportal.php action

It adds pause for random time between 1-10 minutes before posting.

available actions:

'open': start your working day

'pause': pause (if you gonna go for lunch or something)

'reopen': continue your working day after you've paused it

'close': end your working day

'update': retrieves status information
