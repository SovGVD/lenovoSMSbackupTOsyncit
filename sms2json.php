<?php
/*
sovgvd@gmail.com just4fun 2014
=================================================
old Lenovo sms backup to new sms restore (SYNCit)
(test on Lenovo p780 4.2 -> 4.4)
=================================================
alpha v 0.0.0.0.0.0.1 =)
=================================================
HOW TO
1) create sms backup on 4.4 and unpack it,
1.1) in backup file (json format) look at your ordinary service_center and set it below !!!, may be the same with local_time (doesn't check!)
2) copy sms.vmsg from 4.2 in the same folder as this script
3) run this script and save output to 4.4 backup file (for linux something like 'php sms2json.php > 2014-11-08-1415466010727-SMS-backup.zip.0.txt')
4) in new file look at value local_number and set the same in info.mt
5) zip files back and replace created backup
6) restore as the any other new backup

!!!WARNING!!!
 - wrong date/time and sim card after restore
 - SMS from new backup did not restore, but it may be will be save after restore... realy don't know
*/

$service_center="+79262000331";		// SET YOUR service_center HERE
$j=array();
$i=0;
$d=explode("END:VMSG",str_replace("\r","",file_get_contents("sms.vmsg")));
foreach ($d as $m) {
    $m=explode("END:VBODY",$m);
    $m=explode("Subject;",$m[0]);
    $m[0]=explode("\n",$m[0]);
    foreach ($m[0] as $v) {
	$v=explode(":",$v);
	if (isset($v[1])) {
		$k=$v[0];
		array_shift($v);
		$j[$i][$k]=implode(":",$v);
		if ($k=='Date') {
			$j[$i]['ts']=strtotime($j[$i][$k]);
		}
	}
    }
    $m[1]=explode(":",str_replace("\n","",$m[1]));
    if ($m[1][0]=='ENCODING=QUOTED-PRINTABLE;CHARSET=UTF-8') {
	$j[$i]['body']=urldecode(str_replace("=","%",str_replace("==","=",$m[1][1])));
    } else {
	//print "[ERROR]\n";
	//var_dump($m[1]);
	//die("\n");
    }
    $i++;
}


$msgs=array("data"=>array(), "local_time"=>1415466010727, "local_number"=>0, "pid"=>"-1", "device_id"=>"-1", "local_catogary"=>"sms");
$i=0;
foreach ($j as $m) {
    $i++;
    if ($m['TEL']=='') {
	var_dump($m);
	die("\n\nEE\n\n");
    }
    $msgs['data'][]=array(
		"body"=>$m['body'],
		"service_center"=>$service_center,
		"status"=>-1,
		"address"=>$m['TEL'],
		"read"=>1,
		"locked"=>0,
		"client_id"=>$i,
		"type"=>1,
		"date"=>$m['ts']+1414058185052
	);
}
$msgs['local_number']=$i;

print json_encode($msgs,JSON_UNESCAPED_UNICODE);
//die("\n");
?>
