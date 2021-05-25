var crashplanTimestampToMoment = function(col, row){
	var cell = $('td:eq('+col+')', row)
	var checkin = parseInt(cell.text());
	if (checkin > 0){
		if(checkin > 3000000000){
			var date = new Date(checkin);
			cell.html('<span title="'+date+'">'+moment(date).fromNow()+'</span>');
		} else if (checkin < 1000000000){ // Format for full seconds in duration column
	        cell.html('<span title="'+checkin+' seconds">'+moment.duration(parseInt(checkin), "seconds").humanize()+'</span>');
		} else {
			var date = new Date(checkin * 1000);
			cell.html('<span title="'+date+'">'+moment(date).fromNow()+'</span>');
		}
	} else {
		cell.text("")
	}
}