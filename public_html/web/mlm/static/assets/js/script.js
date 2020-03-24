$(function(){

	var note = $('#note'),
		//ts = new Date(2014, 8, 6),
		ts = new Date(2019, 1, 10),
		newYear = true;

	if((new Date()) > ts){
		// The new year is here! Count towards something else.
		// Notice the *1000 at the end - time must be in milliseconds
		var date = new Date();
		date_d = date.getDay();
		date_h = date.getHours()+2;
		date_m = date.getMinutes();
		d_date = 30*24*60*60*1000-(date_d)*24*60*60*1000-date_h*60*60*1000-date_m*60*1000;
// 		ts = (new Date()).getTime() + d_date;
		ts = (new Date()).getTime() + d_date;
		newYear = false;
	}

	$('#countdown').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){

			var message = "";

			message += days + " day" + ( days==1 ? '':'s' ) + ", ";
			message += hours + " hour" + ( hours==1 ? '':'s' ) + ", ";
			message += minutes + " minute" + ( minutes==1 ? '':'s' ) + " and ";
			message += seconds + " second" + ( seconds==1 ? '':'s' ) + " <br />";

			if(newYear){
				message += "left until the new year!";
			}
			else {
				message += "left to 10 days from now!";
			}

			note.html(message);
		}
	});

});
