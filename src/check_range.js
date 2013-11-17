$(document).ready(function() {
	var value = $("#op").val();
	var container = document.getElementById('form');
	var inputName = "value2";
	var select = document.getElementById('op');
	var type = $('input[name=value1]').attr('type');
	

	 $('select[name=op]').change(function() {
	 	var name = $(this).val();
	 	if (name == "Range")
	 	{
	 		
	 		var element = document.createElement("input");
    		//Assign different attributes to the element.
    		if(type == "date") element.setAttribute("type", "date");
			else element.setAttribute("type", "text");
    		element.setAttribute("name", inputName);
    		element.setAttribute("id", inputName);
			form.insertBefore(element,select);
			var div = document.createElement("div");
			div.setAttribute("id","text_div");
			var text;
			if(type == "date" ) text = document.createTextNode("Second Date");
			else text = document.createTextNode("Second Value ");
			form.insertBefore(div,element);
			div.appendChild(text);
			var br = document.createElement("br");
			br.setAttribute("id","br");
			form.insertBefore(br,select);
	 	}
	 	else
	 	{

	 		var e;
	 		if ( (e = document.getElementById(inputName)) != null) {
	 		container.removeChild(e);
	 		var div = document.getElementById("text_div");
	 		container.removeChild(div);
	 		var br = document.getElementById("br");
	 		container.removeChild(br);
	 		}
	 	}
	 });

});