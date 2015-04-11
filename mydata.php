<?php
error_reporting(0);
$conn=mysql_connect('localhost','root','') or die("cant connect");
mysql_select_db('angular',$conn);
$select=mysql_query("select * from users");
//$result=mysql_fetch_assoc($select);
$i=0;
while($row=mysql_fetch_assoc($select)){
    $results[]=$row;
    $i++;
}
print_r(json_encode($results));

