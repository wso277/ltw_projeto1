$(document).ready(function() {
	var value = $("#op").val();
	var container = document.getElementById('form');
	var inputName = "op2";
	var select = document.getElementById('op');

	 $('select[name=op]').change(function() {
	 	var name = $(this).val();
	 	if (name == "Range")
	 	{
	 		var element = document.createElement("input");
    		//Assign different attributes to the element.
    		element.setAttribute("type", "text");
    		element.setAttribute("name", "op2");
    		element.setAttribute("id", "op2");
			form.insertBefore(element,select);
			var div = document.createElement("div");
			div.setAttribute("id","text_div");
			var text =document.createTextNode("Second Value ");
			form.insertBefore(div,element);
			div.innerText = "Second Value";
			var br = document.createElement("br");
			br.setAttribute("id","br");
			form.insertBefore(br,select);
	 	}
	 	else
	 	{
	 		var e = document.getElementById("op2");
	 		container.removeChild(e);
	 		var div = document.getElementById("text_div");
	 		container.removeChild(div);
	 		var br = document.getElementById("br");
	 		container.removeChild(br);
	 	}
	 });

});