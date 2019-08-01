/*************************Tabs*******************/
	var h1;
function tabs1(id){
				 document.getElementById(id).className;
	if(h1){
		if(h1 == id){
			var style = document.getElementById(id+"1").style.display;
			if(style=="block")
			{
				document.getElementById(id+"1").style.display = "block"; 
				
			}else{
				document.getElementById(id+"1").style.display = "block"; 
			}
		}else {
			document.getElementById(id+"1").style.display = "block"; 
			document.getElementById(h1+"1").style.display = "none"; 
			document.getElementById(h1).className = "deactive";
			document.getElementById(id).className = "active";
		}
	}else{
		document.getElementById("tabs11").style.display = "none";
		document.getElementById(id+"1").style.display = "block";
		document.getElementById("tabs1").className = "deactive";
		document.getElementById(id).className = "active";

		
	}
	h1 = id;
	
}

