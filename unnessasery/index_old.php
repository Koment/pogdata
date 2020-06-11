<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pogoda parser</title>

	  <script src="http://code.jquery.com/jquery-3.1.1.js"></script>

</head>
<body>


<input type="text" name="" id="times" value="2">
<button id="raz" value="Создать скрипты">Создать скрипты</button>

<div id="response"></div>


<div id="gis">

</div>
<button id="gisscr" value="Создать скрипты">Создать GIS скрипты</button>

<div id="GISresponse"></div>


<script>

$('#raz').click(function(){

  $.ajax({

            url: 'getData.php',

            data: {times : $('#times').val()},

            type: 'post',

            // response:'text',

            success: function(response) {

              $('#response').html(response + 'from jquery');

              // console.log(response);

            },

        });
});


$('#gisscr').click(function(){

	var checked = [];

	$('input:checkbox:checked').each(function() {

		checked.push($(this).val());

	});

  $.ajax({

            url: 'getData.php',

            data: {gis : checked},

            type: 'post',

            // response:'text',

            success: function(response) {

              $('#GISresponse').html(response + 'from jquery');

              // console.log(response);

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

	for (var i = 0; i < 8; i += 1) {

		if (day > 7) { day = 1; }

		var date = new Date().getDate() + i;



		// var when;
		//
		// switch (i) {
		//
		// 	case 0:
		// 		when = '';
		// 		break;
		//
		// 	case 1:
		// 		when = 'tomorrow';
		// 		break;
		//
		// 	case 2:
		// 		when = '3-day';
		// 		break;
		//
		// 	case 3:
		// 		when = '4-day';
		// 		break;
		//
		// 	case 4:
		// 		when = '5-day';
		// 		break;
		//
		// 	case 5:
		// 		when = '6-day';
		// 		break;
		//
		// 	case 6:
		// 		when = '7-day';
		// 		break;
		//
		// 	case 7:
		// 		when = '8-day';
		// 		break;
		//
		// 	case 8:
		// 		when = '9-day';
		// 		break;
		//
		// 	case 9:
		// 		when = '10-day';
		// 		break;
		//
		// }

		vals += '<input type="checkbox" value="' + date + '"> ' + weekday[day] + ' ' + date + '<br>';

		$('#gis').html(vals);

		day += 1;

	}

</script>



</body>
</html>
