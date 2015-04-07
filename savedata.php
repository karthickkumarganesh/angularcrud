<?php
error_reporting(0);
$conn=mysql_connect('localhost','root','') or die("cant connect");
mysql_select_db('angular',$conn);

$username=$_POST['username'];
$email=$_POST['email'];
$age=$_POST['age'];
$status=$_POST['status'];
$insert="insert into users (`username`,`email`,`age`,`status`) values  ('$username','$email','$age','$status')";
if(mysql_query($insert)){
    $select=mysql_query("select * from users");
//$result=mysql_fetch_assoc($select);
$i=0;
while($row=mysql_fetch_assoc($select)){
    $result[$i]=$row;
    $i++;
}
print_r(json_encode($result));
}