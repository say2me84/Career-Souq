function divremove(no){
//document.getElementbyId('msgdiv'+id).style.display='none';
//$('#box'+v).show();
$('#msgdiv'+no).fadeTo("slow",0.0);
$('#msgdiv'+no).hide('slow');
}
$(document).ready( function() {
		var tmp='';					
		try{
			if(document.getElementById('hd')){
				alert('i am  here');
				callAjaxstate();
			}
		}
		catch(e){
			tmp=1;
		}				
							
	 $(".mlsdelete").bind("click", function(){ 
		var id = $(this).attr('id');
		var controllers = $(this).attr('controllers');
		var actions = $(this).attr('actions');
		jConfirm('Are you sure you want to Delete this record ?',null,function(result){
			if(result) {
				$("#mlsid").val(id);
				document.getElementById("mlsform").action =  APPLICATION_URL+ controllers + "/" + actions ;	
				$("#mlsform").submit();
					}
				});
		});
 
	  $(".faqdelete").bind("click", function(){ 
		var id = $(this).attr('id');
		var controllers = $(this).attr('controllers');
		var actions = $(this).attr('actions');
		jConfirm('Are you sure to Delete this Catagory ?',null,function(result){
			if(result) {
				$("#catId").val(id);
				document.getElementById("faqlistform").action =  APPLICATION_URL+ controllers + "/" + actions ;	
				$("#faqlistform").submit();
					}
				});
		});
	 
	  $(".faqlist").bind("click", function(){ 
		var id = $(this).attr('id');
		var controllers = $(this).attr('controllers');
		var actions = $(this).attr('actions');
		jConfirm('Are you sure to Delete this Question ?',null,function(result){
			if(result) {
				$("#catId").val(id);
				document.getElementById("faqlistform").action =  APPLICATION_URL+ controllers + "/" + actions ;	
				$("#faqlistform").submit();
					}
				});
		});
	  $(".fieldstatus").bind("click", function(){ 
		var id = $(this).attr('id');
		var controllers = $(this).attr('controllers');
		var actions = $(this).attr('actions');
	//alert(id);
	//alert(controllers);
	//alert(actions);
		
				document.getElementById("fieldform").action =  APPLICATION_URL+ controllers + "/" + actions ;	
				$("#fieldform").submit();
					
		});
		
});