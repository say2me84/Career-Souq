/*
 * Flexigrid for jQuery - New Wave Grid
 *
 * Copyright (c) 2008 Paulo P. Marinas (webplicity.net/flexigrid)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * $Date: 2008-04-01 00:09:43 +0800 (Tue, 01 Apr 2008) $
 */
 

 
var editGridRow = function(id){
	
	var column_index=1;
	
	var actionindex=0;
	
	var counter=0;
	$(".hDivBox table tr").children().each(function(){
		//alert($(this).attr("abbr"));
		attr_ibute=$(this).attr("abbr");
		if(attr_ibute.toString()=='actions')
		{
			actionindex=counter;	
		}
		counter++;
	});
	
	
	counter=0;
	$("#row"+id).children().each(function(){
		//Create first text box
		
		if(actionindex==counter)
		{
			//add action column like add edit	
			//Add save or cancel button in row while editing

			var addedithtml='<a href="javascript:saveedits('+id+');"><img src="images/saveicon.png" border="0" /></a>&nbsp;&nbsp;<a href="javascript:canceledits('+id+');"><img src="images/cancelicon.png" border="0" /></a>';
			$(this).children().html(addedithtml);
		}
		else
		{			
			var txt=document.createElement("input");
			txt.setAttribute("id","col"+column_index);
			txt.setAttribute("value",$(this).children().html());
			txt.setAttribute("style","width:"+($(this).children().width()-5)+"px");
			if(column_index==1)
				txt.setAttribute("readonly","readonly");	
				
			//Append child
			$(this).children().html(txt);
		}
		column_index++;
		counter++;
	});
	
	
	
}


var deleteGridRow = function(id){
	if(confirm("Are you sure, you want to delete this record?"))
	{
		itemlist=id;
		
		ajaxpage("delete.php","items="+itemlist,"");
		
		/*$.ajax({
			   type: "POST",
			   dataType: "json",
			   url: "delete.php",
			   data: "items="+itemlist,
			   success: function(data){  
			    	$("#flex1").flexReload();
			   }
			 });*/
	}
}

var canceledits = function(id){
	$("#flex1").flexReload();		
}



var saveedits = function(id){
	
	// Get columns name from header row
	header_array=new Array();
	
	var actionindex=0;
	
	var counter=0;
	$(".hDivBox table tr").children().each(function(){
		attr_ibute=$(this).attr("abbr");
		if(attr_ibute.toString()=='actions')
		{
			actionindex=counter;	
		}
		
		header_array[counter++]=$(this).attr("abbr");	
	});

	value_array=new Array();
	var column_index=1;
	counter=0;
	$("#row"+id).children().each(function(){
		
		if(actionindex==counter)
		{
			//add action column like add edit	
			//Add save or cancel button in row while editing
			var addedithtml='<a href="javascript:editGridRow('+id+');"><img src="images/edit.png" border="0" /></a>&nbsp;&nbsp;<a href="javascript:deleteGridRow('+id+');"><img src="images/deleteicon.png" border="0" /></a>';
			$(this).children().html(addedithtml);
			actionindex=-1;
		}	
		else
		{							  
			//get text box value
			column_value=$("#col"+column_index).val();
			value_array[counter++]=column_value;
			//insert value in column
			$(this).children().html(column_value);
		}
		column_index++;
	});	
	
	header_array[counter]="main_id";
	value_array[counter++]=id;
	
	var query_string='';
	for(i=0;i<header_array.length;i++)
	{
		if(header_array[i]!="undefined" && value_array[i]!="undefined")
		{
			query_string+=header_array[i]+"="+value_array[i]+"&";
		}
		
	}

	ajaxpage("save.php",query_string,"");
	
	
	/*$.ajax({
			   type: "POST",
			   dataType: "json",
			   url: "save.php",
			   data: query_string,
			   success: function(data){  
					//alert("Hello Query: "+data.query+" - Total affected rows: "+data.total);
			    	//$("#flex1").flexReload();
			  }
		});*/
	
	
	//Add save or cancel button in row while editing
	
	
	//$("#row"+id+" td:last").children().html(addedithtml);
}


var adddata = function(){
	if((typeof(document.getElementById("dataadddiv"))!="undefined" && document.getElementById("dataadddiv")!=null))
	{
		$("#dataadddiv").slideToggle("slow");
		return false;
	}
	else
	{
		mydiv=document.createElement("div");
		mydiv.setAttribute("id","dataadddiv");
		mydiv.style.width=$(".tDiv").width()+"px";
		mydiv.style.height="auto";
		mydiv.style.borderTop="#CCCCCC solid 1px";
		mydiv.style.display="none";
		mydiv.style.backgroundColor="#FAFAFA";
		mydiv.style.padding="10px";
		mydiv.style.paddingLeft="50px";
		mydiv.minHeight="100px";
		
		myform=document.createElement("form");
		myform.setAttribute("name","myaddform");
		myform.setAttribute("id","myaddform");
		myform.setAttribute("method","post");
		
		//create form
		column_index=1;
		$(".hDivBox table tr").children().each(function(){
			attr_ibute=$(this).attr("abbr");
			htmlname=$(this).children().html();
			if(attr_ibute.toString()=='actions')
			{
				a=0;
			}
			else
			{
				div1=document.createElement("div");
				div1.setAttribute("style","width:200px; float:left;");
				div1.setAttribute("align","left");
				div1.innerHTML=$(this).children().html();
				
				div2=document.createElement("div");
				div2.setAttribute("style","width:210px; float:left;");
				div2.setAttribute("align","center");
				txthtml='<input type="text" name="'+attr_ibute+'" id="col'+column_index+'" abbr="'+htmlname+'" />';
				div2.innerHTML=": "+txthtml;
				
				div3=document.createElement("div");
				div3.setAttribute("style","clear:both;");
				div3.setAttribute("align","left");
								
				
				
				//div3.innerHTML(txthtml);
				
				column_index++;
				
				myform.appendChild(div1);
				myform.appendChild(div2);
				myform.appendChild(div3);
				//div3.innerHTML=$(this).children().html();
			}			
		});
		
		
		cleardiv=document.createElement("div");
		cleardiv.setAttribute("style","clear:both");
		myform.appendChild(cleardiv);
		
		//save cancel button
		//button div
		div1=document.createElement("div");
		div1.setAttribute("style","width:200px; float:left; height:10px;");
		div1.setAttribute("align","left");
		
		
		div2=document.createElement("div");
		div2.setAttribute("style","width:210px; float:left; margin-top:10px;");
		div2.setAttribute("align","center");
		buttonhtml='<a href="javascript:saveadds(0);"><img src="images/saveicon.png" border="0" title="Save" /></a>&nbsp;&nbsp;<a href="javascript:canceladd();" title="Cancel"><img src="images/cancelicon.png" border="0"  /></a>';
		
		div2.innerHTML=buttonhtml;
		
		div3=document.createElement("div");
		div3.setAttribute("style","clear:both;");
		div3.setAttribute("align","left");
		
		myform.appendChild(div1);
		myform.appendChild(div2);
		myform.appendChild(div3);
		
		mydiv.appendChild(myform);
		
		$(".tDiv").append(mydiv);
		$("#dataadddiv").slideToggle("slow");
	}
}

var canceladd=function(){
		$("#dataadddiv").slideToggle("slow");
}

//function for saving new records
var saveadds=function(id){
	//myformelements=document.getElementById("myaddform").elements;
	header_array=new Array();
	value_array=new Array();
	
	var $inputs = $('#myaddform :input');
  
  	counter=0;
	var errormsg='';
	$inputs.each(function() {
		header_array[counter]=$(this).attr("name");
		value_array[counter]=$(this).val();
		
		if($(this).val()=="")
		{
			errormsg+='     Please enter '+$(this).attr("abbr")+"\n";
		}
		counter++;
    });
	
	if(errormsg!="")
	{
		alert("Following error occured while saving\n\n"+errormsg);
		return;
	}
	var query_string='';

	for(i=0;i<header_array.length;i++)
	{
		query_string+=header_array[i]+"="+value_array[i]+"&";
		//alert(header_array[i]+" : "+value_array[i]);	
	}
	ajaxpage("save.php",query_string,"");
//	alert(query_string);

}














function ajaxpage(pageurl, querystring , containerid)
{
	var page_request = false;
	
	if (window.XMLHttpRequest) // if Mozilla, Safari etc
		page_request = new XMLHttpRequest()
	else if (window.ActiveXObject){ // if IE
	
		try {
			page_request = new ActiveXObject("Msxml2.XMLHTTP")
			
		} 
		catch (e){
			try{
				page_request = new ActiveXObject("Microsoft.XMLHTTP")
				
			}
			catch (e){}
			}
		}
	else
		return false
	page_request.onreadystatechange=function(){
	loadpage(page_request, containerid)
	}
	

	
	page_request.open('POST', pageurl, true);
	page_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	page_request.setRequestHeader("Content-length", querystring.length);
	page_request.setRequestHeader("Connection", "close");	
	page_request.send(querystring);
}

function loadpage(page_request, containerid){
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
	{
		var $inputs = $('#myaddform :input');

		$inputs.each(function() {
			$(this).val("");
		});
		$("#dataadddiv").slideToggle("slow");
		$("#flex1").flexReload();	
	}
}