(function(){

'use strict';
var app = angular.module('App', ['ngMaterial','ngDropdowns','ui.bootstrap','ngMessages']);

app.controller('ExerciseDetailController', function($scope,$http) {
    var exercise_id = window.location.search;
    exercise_id = exercise_id.substr(exercise_id.indexOf("=") + 1);
    $scope.isSelected = false;
    $http.get('/Apis/getExerciseDetail/' + exercise_id +'.json')
        .then(function(res){
            console.log(res);
            if(res.data.isVote == 1)
                $scope.isSelected = true;
            if(res.data.message == "NoUserLogin")
            {
                $scope.id = 0;
            }
        });
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/star_blank.png";
        }
    };

    $scope.toggleSelection = function() {
        if($scope.id == 0)
        {
            window.location='/Users/login';
        }
        else
        {
            $scope.toggleStar();
        }
    };

    $scope.toggleStar = function(){
        $scope.isSelected = ! $scope.isSelected;
        if ( $scope.isSelected ) {
            $http.get('/Apis/likeExerciseByUser/' + exercise_id +'.json')
                .then(function(res){
                    console.log(res);
                });
        } else {
            $http.get('/Apis/unlikeExerciseByUser/' + exercise_id +'.json')
                .then(function(res){
                    console.log(res);
                });
        }
    };
});

app.controller('headerController', function($scope,$http){
    $scope.ddSelectSelected = {}; // Must be an object
    $scope.ddMenuSelected = {};
    $http.get('/Apis/getMenuHeaderFile.json')
        .then(function(res){
            console.log(res);
            $scope.ddLoginSelectOptions = res.data.data.user;
            $scope.ddSelectOptions = res.data.data.language;
            $scope.ddMenuOptions = res.data.data.menu;
        });

    $scope.toggleLanguageClick = function($value)
    {
        console.log($value.value);
        $http.get('/Apis/toggleLanguage/' +  $value.value +'.json')
            .then(function(res){
                console.log(res);
                window.location.reload();
            });
    };
    $scope.toggleLoginClick = function($value)
    {
        window.location = $value.value;
    };
    $scope.programClick = function(){
        window.location='/Programs/index';
    };
    $scope.exerciseClick = function(){
        window.location='/Exercises/index';
    };
    $scope.loginClick = function(){
        window.location='/Users/login';
    };
});

app.controller('ListController', ['$scope', '$http', function($scope, $http){
    $scope.results=[];
    $scope.search = function(){

        $http({
            method: 'GET',
            url:'https://api.flickr.com/services/rest',
            params:{
                method: 'flickr.photos.search',
                api_key:'b31499089ba318a6d834eb86f1a5d49e',
                text: $scope.searchTerm,
                format:'json',
                nojsoncallback:1
            }
        }).success(function(data){
            $scope.results=data;
        }).error(function(error){
            console.log(error);
        });
    };
}
]);

app.controller('UserController', function($scope,$http) {
    $scope.user = [];
    $scope.exercises_list = [];
    $scope.exercises_like = [];
    $http.get('/apis/getUserProfileAndExerciseById/' + id +'.json')
        .then(function(res){
            console.log(res);
            $scope.user = res.data.user;
            if(res.data.user.picture.trim().length == 0)
                $scope.user.picture = '/img/images/avarta.png';
            if(res.data.user.language == "?")
                $scope.user.language = "No Language Selected";
            $scope.exercises_list = angular.copy(res.data.exercises_like);
            $scope.exercises_like = angular.copy(res.data.exercises_like);
        });
    $scope.edit = function() {
        window.location='/Users/edit_profile';
    };
    $scope.editProgram = function() {
        $scope.isEdit = true;
    };
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/star_blank.png";
        }
    };
    // like star handler
    $scope.deselectFriend = function( exercise ) {
        var index = $scope.exercises_like.indexOf( exercise );
        if ( index >= 0 ) {
            $scope.exercises_like.splice( index, 1 );
        }
    };
    $scope.selectFriend = function( exercise ) {
        $scope.exercises_like.push( exercise );
    };

    $scope.toggleMyProgram = function(){
        $scope.isProgramShow = !$scope.isProgramShow;
    };
    $scope.toggleExercise = function(){
        $scope.isExerciseShow = !$scope.isExerciseShow;
    };
    $scope.isExerciseShow = true;
    $scope.isProgramShow = true;
    $scope.isEdit = false;
    $scope.isSelected = true;
});

app.controller('UserProfileController', function($scope,$http){
    $scope.formData = [];
    $http.get('/language.json').success(function(response) {
        $scope.options = response;
    });
    $http.get('/datetime.json').success(function(response) {
        $scope.optionDays = response.day;
        $scope.optionMonths = response.month;
        $scope.optionYears = response.year;
        $scope.day = $scope.optionDays[0];
        $scope.month = $scope.optionMonths[0];
        $scope.year = $scope.optionYears[0];
    });

    
    $scope.formData.language = {name: "English", value:"English"};
    $scope.message = '';
    $scope.isHasPicture = false;
    $scope.imgURL = "/img/images/add_picture_icon.png";
    if(id != 0)
    {
        $http.get('/apis/getUserProfileAndExerciseById/' + id +'.json')
            .then(function(res){
                console.log(res);
                
                $scope.formData = res.data.user;
                //$scope.formData.birthday = new Date(res.data.user.birthday);
                if($scope.formData.picture.length > 0)
                {
                    $scope.isHasPicture = true;
                    $scope.imgURL = $scope.formData.picture;
                }
                $scope.formData.language = {name: res.data.user.language, value:res.data.user.language};                
                var splitBirthday = res.data.user.birthday.split("-");
                if(splitBirthday.length > 0)
                {
                    $scope.day = {name: splitBirthday[0], value:splitBirthday[0]};
                    $scope.month = {name: splitBirthday[1], value:splitBirthday[1]};
                    $scope.year = {name: splitBirthday[2], value:splitBirthday[2]};                    
                }
                $scope.exercises_list = angular.copy(res.data.exercises_like);
                $scope.exercises_like = angular.copy(res.data.exercises_like);
                $scope.fb_id = res.data.user.fb_id;
                $scope.id = res.data.user.id;
                $scope.picture = res.data.user.picture;
                $scope.password = res.data.user.password;
            });
    }
    else
    {
        $http.get('/apis/getRegisterUser.json')
            .then(function(res){
                console.log(res);
                $scope.formData = res.data.user;
                var split_fullname = res.data.user.fullname.split(" ");
                var lastname = "";
                if (split_fullname.length > 1) {
                    $scope.formData.firstname = split_fullname[0];
                    var i = 0;
                    for(i;i<split_fullname.length;i++)
                    {
                        if(i == 0)
                            continue;
                        lastname = lastname + split_fullname[i] + " ";
                    }
                } else
                    $scope.formData.firstname = res.data.user.fullname;
                $scope.formData.lastname = lastname;
                $scope.password = res.data.user.password;
            });
    }

    $scope.getClassBtnAddPicture= function(isHasPicture){
        if(isHasPicture)
            return "hasProfilePicture";
        else
            return "hasNoPicture";
    }
    
    $scope.cancel = function() {
        window.location='/Users/index';
    };

    $scope.changePassword = function(){
        window.location='/Users/change_password';
    };

    $scope.editProgram = function() {
        $scope.isEdit = true;
    };
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/star_blank.png";
        }
    };
    // like star handler
    $scope.deselectFriend = function( exercise ) {
        var index = $scope.exercises_like.indexOf( exercise );
        if ( index >= 0 ) {
            $scope.exercises_like.splice( index, 1 );
        }
    };
    $scope.selectFriend = function( exercise ) {
        $scope.exercises_like.push( exercise );
    };

    $scope.toggleMyProgram = function(){
        $scope.isProgramShow = !$scope.isProgramShow;
    };
    $scope.toggleExercise = function(){
        $scope.isExerciseShow = !$scope.isExerciseShow;
    };
    $scope.isExerciseShow = true;
    $scope.isProgramShow = true;
    $scope.isEdit = false;
    $scope.isSelected = true;
});

app.controller('signupController', function($scope,$http){
    $scope.formData = {};
    $scope.message = '';
    $scope.next = function() {
        var data = $scope.formData;
        console.log(data);
        $http({
            method  : 'POST',
            url     : '/Apis/registerByUsername.json',            
            data    : $scope.formData,  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {
                console.log(data);  
                if(data.message == "success")
                    window.location='/Users/edit_profile';
                else
                    $scope.message = data.message;
            })
    };
    $scope.signIn = function() {
        window.location='/Users/login';
    }
});

app.controller('LoginController', function($scope,$http,$location){
    $scope.formData = {};
    $scope.message = '';
    $scope.signIn = function() {
        var data = $scope.formData;
        console.log(data);
        $http({
            method  : 'POST',
            url     : '/Apis/loginByEmailAndPassword.json',
            data    : $scope.formData,  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {
                console.log(data);
                if(data.message == 'success')
                    window.location='/Users/index';
                else
                    $scope.message = data.message;
            })
    };
    $scope.signUp = function() {
        window.location='/Users/signup';
    }
});

app.controller('ExerciseController', function($scope,$http,$filter){
    $scope.exercises_list_backup = [];
    $scope.exercises_beforefilter_backup = [];
    $scope.exercises_list = [];
    // get list exercise
    $http.get('/Apis/getListExercise.json')
        .then(function(res){
            console.log(res);
            $scope.exercises_like = res.data.exercises_like;
            $scope.exercises_list = angular.copy(res.data.exercises_list);
            $scope.exercises_list_backup = angular.copy(res.data.exercises_list);
        });
    // get list part body for select
    $http.get('/Apis/getListBodyPart.json')
        .then(function(res){
            console.log(res);
            $scope.body_part_items = res.data.body_list;
        });

    // like star handler
    $scope.deselectFriend = function( exercise ) {
        var index = $scope.exercises_like.indexOf( exercise );
        if ( index >= 0 ) {
            $scope.exercises_like.splice( index, 1 );
        }
    };
    $scope.selectFriend = function( exercise ) {
        $scope.exercises_like.push( exercise );
    };

    // filter action click
    $scope.muscleClick = function() {
        if($scope.isMuscleSelected)
        {
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.exercises_list = angular.copy($scope.exercises_list_backup);
        }
        else
        {
            var temp = angular.copy($scope.exercises_list_backup);
            $scope.exercises_list = angular.copy($filter('exerciseOptionFilter')(temp,1));
            $scope.isMuscleSelected = true;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
        }
        $scope.exercises_beforefilter_backup = angular.copy($scope.exercises_list);
        $scope.selectedBodyPartItem = "";
    }
    $scope.stretchingClick = function() {
        if($scope.isStretchingSelected)
        {
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.exercises_list = angular.copy($scope.exercises_list_backup);
        }
        else
        {
            var temp = angular.copy($scope.exercises_list_backup);
            $scope.exercises_list = angular.copy($filter('exerciseOptionFilter')(temp,2));
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = true;
            $scope.isCardioSelected = false;
        }
        $scope.exercises_beforefilter_backup = angular.copy($scope.exercises_list);
        $scope.selectedBodyPartItem = "";
    }
    $scope.cardioClick = function() {
        if($scope.isCardioSelected)
        {
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.exercises_list = angular.copy($scope.exercises_list_backup);
        }
        else
        {
            var temp = angular.copy($scope.exercises_list_backup);
            $scope.exercises_list = angular.copy($filter('exerciseOptionFilter')(temp,3));
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = true;
        }
        $scope.exercises_beforefilter_backup = angular.copy($scope.exercises_list);
        $scope.selectedBodyPartItem = "";
    }
    $scope.isMuscleSelected = false;
    $scope.isStretchingSelected = false;
    $scope.isCardioSelected = false;

    // select body part change
    $scope.changedValue=function(item){
        if(item.length > 0)
        {
            var temp = angular.copy($scope.exercises_beforefilter_backup);
            if($scope.isMuscleSelected)
            {
                $scope.exercises_list = angular.copy($filter('exerciseOptionBodyPartFilter')(temp,1,item));
                return;
            }
            if($scope.isStretchingSelected)
            {
                $scope.exercises_list = angular.copy($filter('exerciseOptionBodyPartFilter')(temp,2,item));
                return;
            }
            if($scope.isCardioSelected)
            {
                $scope.exercises_list = angular.copy($filter('exerciseOptionBodyPartFilter')(temp,3,item));
                return;
            }
            temp = angular.copy($scope.exercises_list_backup);
            $scope.exercises_list = angular.copy($filter('exerciseOptionBodyPartFilter')(temp,4,item));
            return;
        }
        else
        {
            var mode = 0;
            if($scope.isMuscleSelected)
                mode = 1;
            if($scope.isStretchingSelected)
                mode = 2;
            if($scope.isCardioSelected)
                mode = 3;
            if(mode != 0)
            {
                var temp = angular.copy($scope.exercises_list_backup);
                $scope.exercises_list = angular.copy($filter('exerciseOptionFilter')(temp,mode));
            }
            else
            {
                $scope.exercises_list = angular.copy($scope.exercises_list_backup);
            }
            return;
        }
    }


});

app.controller('ItemExerciseController', function($scope,$http,$filter,$modal,$window){
    $scope.toggleSelection = function() {
        if(id == 0)
        {
            var modalInstance = $modal.open({
              templateUrl:'login_modal.ctp',
              controller: 'LoginModalInstanceCtrl',
              backdropClass: 'backdropClass_custom'                    
            });            
            modalInstance.result.then(function (Id) {
                console.log(Id);
                $http.get('/Apis/likeExerciseByUser/' + $scope.exercise.Exercise.id +'.json')
                    .then(function(res){
                        console.log(res);
                        $window.location.reload();
                    });
            }, function () {
            });
        }
        else
        {
            $scope.toggleStar();
        }        
    };

    $scope.toggleStar = function(){
        $scope.isSelected = ! $scope.isSelected;
        if ( $scope.isSelected ) {
            $http.get('/Apis/likeExerciseByUser/' + $scope.exercise.Exercise.id +'.json')
                .then(function(res){
                    console.log(res);
                });
            $scope.selectFriend( $scope.exercise );
        } else {
            $http.get('/Apis/unlikeExerciseByUser/' + $scope.exercise.Exercise.id +'.json')
                .then(function(res){
                    console.log(res);
                });
            $scope.deselectFriend( $scope.exercise );
        }
    };
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/star_blank.png";
        }
    };

    if ( $filter('checkExerciseIsLike')($scope.exercises_like, $scope.exercise.Exercise.id))
        $scope.isSelected = true;
    else
        $scope.isSelected = false;
});


app.controller('ProgramListController', function($scope,$http,$filter,$modal,$window){
    $scope.programs_list_backup = [];
    $scope.programs_list = [];
    // get list exercise
    $http.get('/Apis/getListProgram.json')
        .then(function(res){
            console.log(res);
            $scope.programs_list = res.data.programs_list;
            $scope.programs_list_backup = angular.copy(res.data.programs_list);
        });
    // get list part body for select
    $http.get('/Apis/getListObjective.json')
        .then(function(res){
            console.log(res);
            $scope.objective_items = res.data.objective_list;
        });

    $scope.changedValue=function(item){        
        if(item.length > 0)
        {
            var temp = angular.copy($scope.programs_list_backup);
            $scope.programs_list = angular.copy($filter('programOptionFilter')(temp,item));
        }
        else
        {
            $scope.programs_list = angular.copy($scope.programs_list_backup);
        }
    }
}
);

app.controller('ItemProgramController', function($scope,$http,$filter,$modal,$window){

});

app.controller('ProgramController', ['$scope', '$http', function($scope, $http){
    $scope.selectedIndex = 0;
}
]);

app.controller('ForgetPasswordController', ['$scope', '$http' , '$sce' , function($scope,$http,$sce){
    $scope.message = "";
    $scope.isReset = true;
    $scope.showLoader = false;
    $scope.reset = function(){
        $scope.showLoader = true;
        $http({
            method  : 'POST',
            url     : '/Apis/resetPassword.json',
            data    : {'email' : $scope.email},  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {
                $scope.showLoader = false;
                console.log(data);
                if(data.message == "success")
                    $scope.isReset = false;
                else
                    $scope.message = $sce.trustAsHtml(data.message);
            })
    }
}
]);

app.controller('LoginModalInstanceCtrl', function($scope,$modalInstance, $http){
    $scope.formData = {};
    $scope.message = '';
    $scope.signIn = function() {
        var data = $scope.formData;
        console.log(data);
        $http({
            method  : 'POST',
            url     : '/Apis/loginByEmailAndPassword.json',
            data    : $scope.formData,  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {                
                if(data.message == 'success')                
                    $modalInstance.close(data.id);                        
                else
                    $scope.message = data.message;
            })
    };
    $scope.signUp = function() {
        window.location='/Users/signup';
    };

    FB.init({
        appId: '607706552694436',
        //appId: '609280322537059', // gym.miratik.com account test
        status: true,
        cookie: true,
        oauth: true
    });

    $scope.login = function ()
    {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                FB.api('/me', function(response1) {
                    console.log(response1);
                    $http({
                        method  : 'GET',
                        url     : '/Apis/loginByFbId/' + response1.id +'.json'
                    })
                        .success(function(data) {
                            if(data.message == 'success')
                                $modalInstance.close("123");
                        })
                });
            } else {
                FB.login(function(response) {
                 if (response.authResponse)
                 {
                     FB.api('/me', function(response1) {
                     console.log(response1);
                     $http({
                         method  : 'GET',
                         url     : '/Apis/loginByFbId/' + response1.id +'.json'
                         })
                         .success(function(data) {
                         if(data.message == 'success')
                              $modalInstance.close();
                         else
                             window.location='/Users/signup';
                         })
                     });
                 } else
                 {
                     console.log('User cancelled login or did not fully authorize.');
                 }
                 },{scope: 'email,publish_actions,user_friends'});
                 //window.location='/Users/signup';
            }
        })
    }
}
);
app.controller('ChangepassController', function($http, $scope, $timeout){
    var model = this;
    $scope.showLoader = false;

    model.message = "";    
    model.user = {    
      password: "",
      confirmPassword: ""
    };

    $scope.cancel = function(){
        window.location = '/Users/edit_profile';
    }

    $scope.save = function() {
        $scope.showLoader = true;
        $http({
                method  : 'POST',
                url     : '/Apis/changePassword.json',
                data    : {'password' : model.user.password},  // pass in data as strings
                headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
            })
            .success(function(data) {
                $scope.showLoader = false;
                if(data.message == "success")
                    model.message = "Change password successful!"
                else
                    model.message = "Change password failed!"

                $timeout(function(){
                    model.message = "";
                }, 3000);
            })

        };
});
app.directive('compareTo', function(){
    return {
          require: "ngModel",
          scope: {
            otherModelValue: "=compareTo"
          },
          link: function(scope, element, attributes, ngModel) {

            ngModel.$validators.compareTo = function(modelValue) {
              return modelValue == scope.otherModelValue;
            };

            scope.$watch("otherModelValue", function() {
              ngModel.$validate();
            });
          }
    };
});
app.controller('DeleteaccountController', function($http, $scope, $mdDialog, $timeout){
    var model = this;
    model.email = "";
    model.message = "";
    $scope.showLoader = false;
    model.submit = function(isValid){
         if(isValid && model.email!=""){
             var confirm = $mdDialog.confirm()
              .title('Would you like to delete your account?')
              .content('')
              .ariaLabel('Lucky day')
              .ok('OK')
              .cancel('Cancel')
              .targetEvent();
            $mdDialog.show(confirm).then(function() {  
                $scope.showLoader = true;        
                $http({
                    method  : 'POST',
                    url     : '/Apis/deleteAccount.json',
                    data    : {'email' : model.email},  
                    headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
                })
                .success(function(data) {         
                    $scope.showLoader = false;
                    if(data.message == "email_does_not_match"){
                        model.message = "Your email does not match!";   
                        $timeout(function(){
                            model.message = "";
                        }, 3000);
                    }
                    else{
                        model.message = "Delete account successful!";
                        window.location='/Users/login';
                    }
                     
                }) 
            }, function() {          
                // do code here when click on cancel button
            });
        }else{

        }
        // $scope.showLoader = true;
        // if(isValid){
        //     $http({
        //         method  : 'POST',
        //         url     : '/Apis/deleteAccount.json',
        //         data    : {'email' : model.email},  
        //         headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        //     })
        //     .success(function(data) {         
        //         $scope.showLoader = false;
        //         if(data.message == "email_does_not_match"){
        //             model.message = "Your email does not match!";   
        //         }
        //         else{
        //             model.message = "Delete account successful!";
        //         }
                 
        //     }) 
        // }else{

        // }
    };
});
// Filter part
app.filter('checkExerciseIsLike', function() {
    return function(input, id) {
        var i=0, len=input.length;
        for (i; i<len; i++) {
            if (input[i].Exercise.id == id) {
                return true;
            }
        }
        return false;
    }
});

app.filter('exerciseOptionFilter', function() {
    return function(input , mode) {
        var i=0, len=input.length;
        var option = "";
        var offset = 0;
        switch (mode)
        {
            case 1:
                option = "body_building";
                break;
            case 2:
                option = "stretching";
                break;
            case 3:
                option = "cardio";
                break;
            default :
                return input;
        }
        for (i; i<len; i++) {
            if (input[i - offset].Exercise[option].length == 0 || input[i - offset].Exercise[option] == null) {
                input.splice( i - offset, 1 );
                offset++ ;
            }
        }
        return input;
    }
});

app.filter('exerciseOptionBodyPartFilter', function() {
    return function(input , mode , body_part_id) {
        var i=0, len=input.length;
        var option = "";
        var offset = 0;
        switch (mode)
        {
            case 1:
                option = "body_building";
                break;
            case 2:
                option = "stretching";
                break;
            case 3:
                option = "cardio";
                break;
            default :
                break;
        }

        if(option == "")
        {
            for (i; i<len; i++) {
                console.log(i);
                if (input[i - offset].Exercise["body_building"].length > 0)
                {
                    if(input[i - offset].Exercise["body_building"][0]['bodypart'] == body_part_id)
                    {
                        continue;
                    }
                }
                if (input[i - offset].Exercise["stretching"].length > 0)
                {
                    if(input[i - offset].Exercise["stretching"][0]['bodypart'] == body_part_id)
                    {
                        continue;
                    }
                }
                if (input[i - offset].Exercise["cardio"].length > 0)
                {
                    if(input[i - offset].Exercise["cardio"][0]['bodypart'] == body_part_id)
                    {
                        continue;
                    }
                }
                input.splice( i - offset, 1 );
                offset++ ;
            }
        }
        else
        {
            for (i; i<len; i++) {
                console.log(i);
                if (input[i - offset].Exercise[option].length > 0) {
                    if (input[i - offset].Exercise[option][0]['bodypart'] != body_part_id) {
                        input.splice(i - offset, 1);
                        offset++;
                    }
                }
            }
        }
        return input;
    }
});

app.filter('programOptionFilter', function() {
    return function(input , item) {
        var i=0, len=input.length;
        var option = "";
        var offset = 0;        
        for (i; i<len; i++) {
            if (input[i - offset].Program["objective"] != item ) {
                input.splice( i - offset, 1 );
                offset++ ;
            }
        }
        return input;
    }
});

app.controller('TestController', function($scope,$http,$filter){
        $scope.tests = [
            {
                id: '123',
                mp4: '/Exercise_list/1109/1109_s.mp4',
                jpg: '/img/images/6035.jpeg'
            },
            {
                id: '124',
                mp4: '/Exercise_list/1109/1119_s.mp4',
                jpg: '/img/images/6035.jpeg'
            }
        ];

        $scope.hoverIn = function(){
            console.log('in');
        };
        $scope.hoverOut = function(){
            console.log('out');
        };
    }
);

app.controller('TestRepeatController', function($scope){
        $scope.hoverIn = function(e){
            var videoElements = angular.element(e.srcElement);
            videoElements[0].play();
            console.log('in');
        };
        $scope.hoverOut = function(){
            console.log('out');
        };
    }
);

app.directive('uiVideo', function () {
    return {
        template: [
            '<div class="video">',
            '<video class="img-responsive" preload="none"',
            ' src="{{video.mp4}}"',
            ' poster="{{video.jpg}}"',
            ' width="240" height="120">',
            '</video>',
            '</div>'
        ].join(''),
        scope: {
            video: '=video'
        },
        link: function (scope, element, attrs) {
            $(element).find("video").on("ended", function () {
                var v = this.src;
                this.src='';
                this.src=v;
            });
        }
    };
});


}());