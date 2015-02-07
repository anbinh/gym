<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
FB.init({
    appId: '607706552694436',
    status: true,
    cookie: true,
    oauth: true
});
var userData = null;

function getUserInfo() {
    FB.api('/me', function(resp) {
        userData = resp;
        console.log(userData);
    });
}
function check(){
	FB.getLoginStatus(function(stsResp) {
	    if(stsResp.authResponse) {	  
	    	getUserInfo();  		        	        
	    } else {	    	
	        FB.login(function(loginResp) {
	            if(loginResp.authResponse) {
	                getUserInfo();
	                console.log('2');
	            } else {
	            	console.log('3');
	                alert('Please authorize this application to use it!');
	            }
	        });
	    }
	});	
}



</script>

<a href="#" onclick="check()">login</a>
<div layout="row" layout-align="center center">
	<div flex="50">
		<h1 class="sub">Sign Up</h1>
		<h2 style="text-align:center; margin-top:0px;">Nice To Meet You</h2>
		<a href="#" class="btn btn-facebook">Log In with Facebook</a>
	</div>
</div>