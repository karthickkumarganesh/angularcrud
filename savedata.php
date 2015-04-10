<?php
error_reporting(0);
$conn=mysql_connect('localhost','root','') or die("cant connect");
mysql_select_db('angular',$conn);

$username=$_POST['username'];
$email=$_POST['email'];
$age=$_POST['age'];
$status=$_POST['status'];
$userid=$_POST['id'];
if(isset($_POST['action'])){
    if($_POST['action']=="delete"){
        $userid=$_POST['userid'];
        deleteUser($userid);
    }
}else{
    if($userid==0){
        $insert="insert into users (`username`,`email`,`age`,`status`) values  ('$username','$email','$age','$status')";
        if(mysql_query($insert)){
            fetchDataSingle(mysql_insert_id($conn));
        }
    }else{
        $update="update users set username='$username',email='$email',age='$age',status='$status' where id='$userid'";
        if(mysql_query($update)){
            fetchDataSingle($userid);
        }
    }
}


function fetchData(){
    $select=mysql_query("select * from users");
    //$result=mysql_fetch_assoc($select);
    $i=0;
    while($row=mysql_fetch_assoc($select)){
        $result[$row['id']]=row;
        $i++;
    }
    print_r(json_encode($result));
}

function fetchDataSingle($userid){
    $select=mysql_query("select * from users where id='$userid'");
    $result=mysql_fetch_object($select);   

    print_r(json_encode($result));
}
function deleteUser($userid){
    $delete="delete from users where id='$userid'";
    if(mysql_query($delete)){
        echo 1;
    }else{
        echo 0;
    }
}