$(document).ready(function(){	
	$('.wrap-dd-menu').hover(		
		function() {		
			//ishover = false;
		    $(this).find('ul').addClass('active');
		    $(this).find('ul').addClass('show-drop-list');
		  // alert($(this).parent().html());
		}, function() {				
			$('ul').hover(
				function() {				    
					//ishover = true;	
					//alert('1');
				}, function() {				
					$(this).removeClass('active');		
					$(this).removeClass('show-drop-list');			
					//alert('1');
				}	
			);
			//alert('2');
			//$(this).find('ul').removeClass('active');				
			// console.log('2');
			// if(!ishover){
			// 	$(this).parent().find('ul').removeClass('active');			
			// }		
			
			$(this).find('ul').removeClass('active');
			$(this).find('ul').removeClass('show-drop-list');
		}
	);
});