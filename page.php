<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="js/angular.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="css/bootstrap-responsive.css">

<div ng-app="myApp">
    <div ng-controller="myController">
        <div>Search :<form class="form-inline"><input type="search" ng-model="search"></form></div>
        <table class="table table-bordered table-striped">
            <thead>
                <th>username</th>
                <th>Email</th>
                <th>Age</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr ng-repeat="user in users | filter:search"><td>{{ user.username}}</td><td>{{user.email}}</td><td>{{user.age}}</td><td ng-show="user.status">Active</td><td ng-hide="user.status">In-Active</td><td><button class="btn btn-info" ng-click=editUser(user.id)>Edit</button> <button class="btn btn-danger" ng-click="deleteUser(user.id)">Delete</button></td></tr></tbody>
        </table>



        <hr>

        <div  style="padding:20px;">
            <button ng-click="showAddUserForm()" class="btn btn-success">{{showaddbuttonlabel}}</button>

            <form  name="createUser" class="form-horizontal" ng-show="showaddform" novalidate><h3>{{formlabel}}</h3>
                <div class="control-group">
                    <label  class="control-label"> User name:</label>
                    <div class="controls">
                        <input type="text" name="username" class="form-control" ng-model="userdetail.username"  required>
                        <span style="color:red" ng-show="createUser.username.$dirty && createUser.username.$invalid">
                            <span ng-show="createUser.username.$error.required">Username is required.</span>
                        </span>
                    </div>
                </div>

                <div class="control-group"><label class="control-label">Email:</label>
                    <div class="controls"><input type="email" name="email" id="email" ng-model="userdetail.email" required>
                        <span style="color:red" ng-show="createUser.email.$dirty && createUser.email.$invalid">
                            <span ng-show="createUser.email.$error.required">Email is required.</span>
                            <span ng-show="createUser.email.$error.email">Invalid Email.</span>
                        </span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Age:</label>
                    <div class="controls"> <input type="number" name="age" ng-model="userdetail.age" id="age"> <span style="color:red" ng-show="createUser.age.$dirty && createUser.age.$invalid">
                        <span ng-show="createUser.age.$error.required">Age is required.</span>
                        <span ng-show="createUser.age.$error.number">Invalid Age.</span>
                        </span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">status:</label><div  class="controls"><select ng-model="userdetail.status"><option value="1">Active</option><option value="0">In Active</option></select>
                    </div>
                </div>
                <div class="control-group">
                    <div  class="controls"><input type="hidden" name="userid" id="userid" ng-model="userdetail.id"> <button ng-disabled="createUser.username.$dirty && createUser.username.$invalid || createUser.email.$dirty && createUser.email.$invalid || createUser.age.$dirty && createUser.age.$invalid " class="btn btn-success" ng-click="saveData()" >Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    myapp=angular.module('myApp',[]);
    myapp.controller('myController',function($scope,$http){
        $http.get('mydata.php').success(function(data){
            $scope.users=data;
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
                    // console.log(data);
                    $scope.users= $scope.users.concat(data);
                    // console.log($scope.users);
                }else{
                  //  console.log($scope.userdetail.id-1);
                    $scope.users[$scope.users.indexOf($scope.userdetail.id)]=data;
                }
                //$scope.userdetail=$scope.resetf;

            })


        }
        
        $scope.editUser=function(userid){
           console.log(userid);
            $scope.formlabel="Update User";
            $scope.showaddform=true;
            $scope.userdetail.username= $scope.users[userid-1].username;
            $scope.userdetail.email= $scope.users[userid-1].email;
            $scope.userdetail.age= parseInt($scope.users[userid-1].age);
            $scope.userdetail.id= parseInt($scope.users[userid-1].id);
            // console.log($scope.userdetail.age);
            $scope.userdetail.status= $scope.users[userid-1].status;

        }

        $scope.deleteUser=function(userid){
            $http({
                method:"post",
                url:"savedata.php",
                data:$.param({"action":"delete","userid":userid}),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }).success(function(data){

                if(data==1){
                    //$index= $scope.users[userid].indexOf;
                    // $scope.users.splice(userid,1);
                    $scope.users.splice( $scope.users.indexOf(userid), 1);

                    console.log($scope.users);
                }

            })
        }

    });

    /* myapp.controller('formController',function($scope,$http){
        $scope.userdetail={};
        $scope.userdetail.username="";
        $scope.userdetail.email="";
        $scope.userdetail.age="";
        $scope.userdetail.status="1";
        $scope.showaddbuttonlabel="Show Add User Form";
        $scope.showaddform=false;
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

                   $scope.users=data;
               })


        }
    });*/
</script>