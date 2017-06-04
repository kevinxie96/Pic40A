$(document).ready(function() {
	prepare_event();
	populate_calendar();
});

var toggle = true;

//----------------------PREPARE DIALOGS-----------------------------
function prepare_event()
{
	$("#create_event").load("create_event.html").dialog({
		autoOpen: false,
		modal: true,
		width: 600,
		closeText : "",
		dialogClass: "create",
		show: 
		{
			effect: "fold",
			duration: 600
		},
		close: function(event, ui)
		{
			$("#create_event").dialog("destroy");
			prepare_event();
		}
	});	
}

function prepare_calendar_event(dialog_id, poi, timestamp, eventtitle, eventdetails, height1) {
	var border_height_add = parseInt(height1);
	var height = (54)*height1 + border_height_add;
	var width = 257;
	$("#" + dialog_id).dialog({
		autoOpen: false, 
		modal: false,
		width: width,
		height: height,
		resizable: true, 
		draggable: false,
		closeText : "",
		dialogClass: "calendar",
		show: 
		{
			effect: "slide",
			duration: 600
		},
		beforeClose: function(event, ui)
		{
			var yes_or_no = confirm("Are you sure you want to delete this event?");
			if (yes_or_no)
			{
				$("#" + dialog_id).dialog("destroy").remove();
				$.ajax({
					url: 'delete.php',
					type: 'POST',
					data: 
					{
						person: poi,
						time_stamp: timestamp,
						event_title: eventtitle,
						event_details: eventdetails,
						height: height1
					},
					contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
					success: function(result, status)
					{
						alert("Successfully deleted!");
					},
					error: function() {
						alert("error delete");
					}

				});

			}
			else 
			{
				return false;
			}
		}
	});

	$("#" + dialog_id).click(function (){
		if (toggle)
		{
			$("#" + dialog_id).dialog({width: width*1.5, height: 75+height*2});
			toggle = false;
		}
		else
		{
			$("#" + dialog_id).dialog({width: width,height: height});
			toggle = true;
		}

	});
}

//---------------------CREATE DIALOGS----------------------------------
function create_event(name, js_date, js_start_time, js_end_time)
{
	var radio_array = document.getElementsByName("person");
	for (var i = 0; i < radio_array.length; i++)
	{
		if (radio_array[i].value == name)
		{
			radio_array[i].checked = true;
		}
	}
	var date = document.getElementById("date");
	date.value = js_date;
	var start_time = document.getElementById("start_time");
	start_time.value = js_start_time;
	var end_time = document.getElementById("end_time");
	end_time.value = js_end_time;
	$("#create_event").dialog("open");

}
//----------------HELPER FUNCTION FOR AJAX-----------------------------
function open_and_position_event(result_array)
{
	var insert = document.getElementById("create_dialog");
	var div = document.createElement("div");
	var dialog_id = result_array[0]+result_array[3]+result_array[1]+result_array[6];
	div.setAttribute("id", dialog_id);
	div.setAttribute("title", result_array[4] + "-" + result_array[5] + " " + result_array[1]);
	div.style.padding = 0;
	div.style.margin = 0;
	var input_text = document.createTextNode(result_array[2]);
	div.appendChild(input_text);
	insert.appendChild(div);
	var id = result_array[0] + "_" + result_array[3];
	var target = document.getElementById(id);
	var offset = 100 * parseInt(result_array[6])/60;
	offset = offset + "%";
	prepare_calendar_event(dialog_id, result_array[0], result_array[3], result_array[1], result_array[2], result_array[7]);
	$("#" + dialog_id).dialog( "option", "position", { my: "left top", at: "left top+" + offset, of: target} );
	$( "#" + dialog_id).dialog("open");
}
//----------------RETRIEVE FROM DATABASE WITH AJAX---------------------------
function populate_calendar()
{
	var tds = $("td");
	var lower_bound = tds[1].id.split("_")[2];
	var upper_bound = tds[51].id.split("_")[2];
	$.ajax({
			url: 'retrieve.php',
			type: 'POST',
			data: 
			{
				lower_bound: lower_bound,
				upper_bound: upper_bound
			},
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
			success: function(result, status)
			{
				if (result == "")
				{
					return;
				}
				var super_result_array = result.split("-");
				for (var i = 0; i < super_result_array.length-1; i++)
				{
					var result_chunk = super_result_array[i];
					var result_array = result_chunk.split(",");
					open_and_position_event(result_array);
				}
			},
			error: function() {
				alert("error retrieve");
			}

		});
}


//---------------------------INSERT INTO DATABASE WITH AJAX----------------------
function process_form() 
{
	var tds = $("td");
	var lower_bound = tds[1].id.split("_")[2];
	var upper_bound = tds[51].id.split("_")[2];
	var radio_array = document.getElementsByName("person");
	var poi = null;
	for (var i = 0; i < radio_array.length; i++)
	{
		if (radio_array[i].checked == true)
		{
			poi = radio_array[i].value;
		}
	}
	$.ajax({
		url: 'insert.php',
		type: 'POST',
		data: 
		{
			person: poi,
			start_time: document.getElementById("start_time").value,
			end_time: document.getElementById("end_time").value,
			event_title: document.getElementById("event_title").value,
			event_details: document.getElementById("event_details").value,
			date: document.getElementById("date").value,
			lower_bound: lower_bound,
			upper_bound: upper_bound
		},
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
		success: function(result, status)
		{
			var result_array = result.split(",");
			$("#create_event").dialog("destroy");
			prepare_event();
			if (result_array[8] == 3)
			{
				return;
			}
			open_and_position_event(result_array);
		},
		error: function() {
			alert("error insert");
		}

	});
}


//----------------------------COOKIES------------------------------------------
function saveEvent() {
	var person = "";
	var radio_array = document.getElementsByName("person");
	for (var i = 0; i < radio_array.length; i++)
	{
		if (radio_array[i].checked == true)
		{
			person = radio_array[i].value;
		}
	}
	document.cookie = "person=" + person;
	document.cookie = "date=" + document.getElementById("date").value;
	document.cookie = "start_time=" + document.getElementById("start_time").value;
	document.cookie = "end_time=" + document.getElementById("end_time").value;
	document.cookie = "event_title=" + document.getElementById("event_title").value;
	document.cookie = "event_details=" + document.getElementById("event_details").value;

}

function clearEvent() {
	var radio_array = document.getElementsByName("person");
	for (var i = 0; i < radio_array.length; i++)
	{
		if (radio_array[i].checked == true)
		{
			radio_array[i].checked = false;
		}
	}
	document.getElementById("date").value = "";
	document.getElementById("start_time").value = "";
	document.getElementById("end_time").value = "";
	document.getElementById("event_title").value = "";
	document.getElementById("event_details").value = "";
}

function loadEventHelper(cname) 
{
    var name = cname + "=";
    var cookie_array = document.cookie.split(';');
    for(var i = 0; i < cookie_array.length; i++) {
        var cookie = cookie_array[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) == 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
}

function loadEvent() {
	var radio_array = document.getElementsByName("person");
	for (var i = 0; i < radio_array.length; i++)
	{
		if (radio_array[i].value == loadEventHelper("person"))
		{
			radio_array[i].checked = true;
		}
	}
	document.getElementById("date").value = loadEventHelper("date");
	document.getElementById("start_time").value = loadEventHelper("start_time");
	document.getElementById("end_time").value = loadEventHelper("end_time");
	document.getElementById("event_title").value = loadEventHelper("event_title");
	document.getElementById("event_details").value = loadEventHelper("event_details");
}