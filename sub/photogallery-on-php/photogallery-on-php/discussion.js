function submit(event) {
	// get values from form
	var url = "./handler_discussion.php";
	var name = document.getElementById("name").value;
	var commentary = document.getElementById("commentary").value;
	var params = "name=" + name + "&commentary=" + commentary;
	var request = new XMLHttpRequest();
	request.open("POST", url, true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	request.onreadystatechange = function() {
		if(request.readyState == 4 && request.status == 200) {
			response_datetime = JSON.parse(request.responseText).datetime;
			response_name = JSON.parse(request.responseText).name;
			response_commentary = JSON.parse(request.responseText).commentary;
			
			var table = document.getElementById("list_of_comments");
			var row = table.insertRow(0);
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			cell1.innerHTML = "<div class=\"commentary_name\">" + response_name + "</div><div class=\"commentary_time\">" + response_datetime + "</div>";
			cell2.innerHTML = "<div class=\"commentary_post\">" + response_commentary + "</div>";
		}
	}
	request.send(params);
	
	// clean form
	document.getElementById("name").value = "";
	document.getElementById("commentary").value = "";				
}