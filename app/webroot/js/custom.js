$(document).ready(function(){	
	$('.wrap-dd-menu').hover(		
		function() {						
		    $(this).find('ul').addClass('active');
		}, function() {					
			$('.wrap-dd-menu ul').hover(				
				function() {				    
					console.log('1');
					//$(this).addClass('active');
				}, function() {				
					$(this).removeClass('active');
				}	
			);	
			console.log('2');
			//$(this).find('ul').removeClass('active');				
		}
	);
});