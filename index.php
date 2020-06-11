<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pogoda parser</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	  <script src="http://code.jquery.com/jquery-3.1.1.js"></script>

</head>
<body style="margin: 15px;">

<div id="checkx">


</div>

<div class="form-row">

<div class="col-md-2">
	<button class="btn btn-primary" id="ya" value="Создать скрипты">YA parse</button>
</div>

<div class="col-md-2">
	<button class="btn btn-primary" id="gis" value="Создать скрипты">GIS parse</button>
</div>

</div>

<div id="response"></div>

<script>

function disGis () {

	var sendbtn = document.getElementById('gis');

	var chexs = $('input:checkbox:checked');

	chexs.each(function() {

		var id = $(this).attr('id');

		if (id[id.length - 1] > 1){

			sendbtn.disabled = !!this.checked;

		} else {

			$('#gis').removeAttr('disabled');

		}


	});

}


$('#ya').click(function(){

	var selected = [];

	$('input:checkbox:checked').each(function() {
	    selected.push($(this).attr('value'));
	});

  $.ajax({

            url: 'factoryTest.php',

            data: {ya : selected},

            type: 'post',

            success: function(response) {

              $('#response').html(response + 'from jquery');

            },

        });
});


$('#gis').click(function(){

	var selected = [];

	$('input:checkbox:checked').each(function() {
	    selected.push($(this).attr('value'));
	});

  $.ajax({

            url: 'factoryTest.php',

            data: {gis : selected},

            type: 'post',

            success: function(response) {

              $('#response').html(response + 'from jquery');

            },

        });
	});

	</script>

<script>

var vals = '';

var weekday = new Array(7);

weekday[1] = "Понедельник";
weekday[2] = "Вторник";
weekday[3] = "Среда";
weekday[4] = "Четверг";
weekday[5] = "Пятница";
weekday[6] = "Суббота";
weekday[7] = "Воскресенье";

var day = new Date().getDay() || 7;

for (var i = 0; i < 5; i += 1) {

	if (day > 7) { day = 1; }

	var date = new Date();

	date = date.setDate(date.getDate() + i);

	var month = new Date(date).getMonth()+1;

	vals += '<div class="form-check">' +

						'<input class="form-check-input" type="checkbox" onclick="disGis()" value="' + date + '" id="check' + i + '">' +

						'<label class="form-check-label" for="check' + i + '">' +

								weekday[day] + ' ' + new Date(date).getDate() +

							'</label></div>';

	$('#checkx').html(vals);

	day += 1;

}

</script>

<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
