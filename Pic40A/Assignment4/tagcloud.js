function makeCloud() 
{
	var text_area = document.getElementById("tags");
	var sorted_array_tags = text_area.value.split(' ').sort();
	var unique_tags = [];
	var frequency = [];
	for (var i = 0; i < sorted_array_tags.length; i++)
	{
		var value = sorted_array_tags[i];
		var index = unique_tags.indexOf(value)
		if (index == -1)
		{
			unique_tags.push(value);
			frequency.push(1);
		}
		else 
		{
			frequency[index] += 1;
		}
	}
	manipulateDOM(unique_tags, frequency, maxFreq(frequency));
}

function maxFreq(freq)
{
	var max = freq[0];
	for (var i = 1; i < freq.length; i++)
	{
		if (freq[i] > max)
		{
			max = freq[i];
		}
	}
	return max;
}

function manipulateDOM(unique_tags, freq, maxFreq) 
{
	var new_div = document.createElement("div");
	for (var i = 0; i < unique_tags.length; i++)
	{
		var span = document.createElement("span");
		var span_text = document.createTextNode(unique_tags[i] + " ");
		span.appendChild(span_text);
		span.style.fontSize = assignSize(freq[i], maxFreq);
		span.onclick = function(i) 
		{
			return function() {
				alert(unique_tags[i] + ": " + freq[i] + " occurrences");
			};
		}(i);
		new_div.appendChild(span);
	}
	new_div.style.border = ".1em solid silver";
	new_div.style.backgroundColor = "blue";
	new_div.style.color = "silver";
	new_div.style.fontSize = "x-large";
	new_div.style.fontFamily = "Serif";
	var div = document.getElementsByTagName("div")[0];
	div.parentNode.replaceChild(new_div, div);
}

function assignSize(freq, maxFreq)
{
	var size = Math.round((freq/maxFreq)*20) + 15;
	return size + "pt";
}

function saveForm() {
	document.cookie = "tags=" + document.getElementById("tags").value;
}

function loadForm() 
{
    var name = "tags=";
    var cookie_array = document.cookie.split(';');
    for(var i = 0; i < cookie_array.length; i++) {
        var cookie = cookie_array[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) == 0) {
            document.getElementById("tags").value = cookie.substring(name.length, cookie.length);
        }
    }
}

function clearForm() 
{
	document.getElementById("tags").value = "";
}