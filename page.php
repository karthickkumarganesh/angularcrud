<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="js/angular.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<link type="text/css" rel="stylesheet" href="css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="css/bootstrap-responsive.css">

<div ng-app="myApp">
<div ng-view></div>
  
</div>
<script type="text/javascript">
    myapp=angular.module('myApp',['ngRoute','']);
	
	var viewControllerApp=angular.module('viewController',[]);
    viewControllerApp.controller('viewController',['$scope','$http',function($scope,$http){
        $http.get('mydata.php').success(function(data){
            $scope.users=data;
            //console.log($scope.users);
        });
        $scope.showaddbuttonlabel="Show Add User Form";
        $scope.showaddform=false;
        $scope.formlabel="Create User";
        $scope.userdetail={};
        $scope.resetf=angular.copy($scope.userdetail);
        $scope.userdetail.username="";
        $scope.userdetail.email="";
        $scope.userdetail.age="";
        $scope.userdetail.status="1";
        $scope.userdetail.id=0;


        $scope.showAddUserForm=function(){
            if(!$scope.showaddform){
                $scope.showaddbuttonlabel="Hide Add User Form";
                $scope.showaddform=true;
            }else{
                $scope.showaddbuttonlabel="Show Add User Form";
                $scope.showaddform=false; 
            }
        }
        $scope.saveData=function(){

            $http({
                method:"post",
                url:"savedata.php",
                data:$.param($scope.userdetail),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }).success(function(data){
                if($scope.userdetail.id==0){

                    if($scope.users=="null"){
                       
                        $scope.users=[];
                        $scope.users.push(data);
                    } else{
                        
                        $scope.users.push(data);
                        
                    }

                }else{
                     //console.log(data);
                    ind= _.findIndex($scope.users,{id:data.id}) ;
                   
					$scope.users[ind]=data;
                }


            })


        }

        $scope.editUser=function(userid){            
            $scope.formlabel="Update User";
            $scope.showaddform=true;
            $scope.userdetail.username= $scope.users[userid].username;
            $scope.userdetail.email= $scope.users[userid].email;
            $scope.userdetail.age= parseInt($scope.users[userid].age);
            $scope.userdetail.id= parseInt($scope.users[userid].id);
            // console.log($scope.userdetail.age);
            $scope.userdetail.status= $scope.users[userid].status;

        }

        $scope.deleteUser=function(userid){
            $http({
                method:"post",
                url:"savedata.php",
                data:$.param({"action":"delete","userid":userid}),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }).success(function(data){

                if(data==1){
                    index= _.findIndex($scope.users,{id:userid});
                    // $scope.users.splice(userid,1);
                    $scope.users.splice(index,1);

                    console.log($scope.users);
                }

            });
        }
		
		$scope.changeOrderEmail=function (){
			
			$scope.users=_.sortBy($scope.users, 'email');
			console.log($scope.users);
		}

    }]);


</script>