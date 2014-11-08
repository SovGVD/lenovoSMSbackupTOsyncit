lenovoSMSbackupTOsyncit
=======================

restore old sms.vmsg to new syncit format

old Lenovo sms backup to new sms restore (SYNCit)
(test on Lenovo p780 4.2 -> 4.4)

alpha v 0.0.0.0.0.0.1 =)

HOW TO
======
 1. create sms backup on 4.4 and unpack it,
 2. in backup file (json format) look at your ordinary service_center and set it below !!!, may be the same with local_time (doesn't check!)
 3. copy sms.vmsg from 4.2 in the same folder as this script
 4. run this script and save output to 4.4 backup file (for linux something like 'php sms2json.php > 2014-11-08-1415466010727-SMS-backup.zip.0.txt')
 5. in new file look at value local_number and set the same in info.mt
 6. zip files back and replace created backup
 7. restore as the any other new backup

!!!WARNING!!!
=============
 - wrong date/time and sim card after restore
 - SMS from new backup did not restore, but it may be will be save after restore... realy don't know

