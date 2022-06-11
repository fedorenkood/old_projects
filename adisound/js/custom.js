$(document).ready(function() {

	$('#mysend').click(function() {
		if ($('#email').val() == "" && $('#myname').val() != "Ваше имя..." && $('#myphone').val() != "Ваш номер телефона..." && $('#mytext').val() != "Адрес. Индекс, город, улица, дом, квартира...") {
			document.getElementById('form').submit();
		}  else {
			alert("Необходимо заполнить все поля!");
		}
	});

	$('#mysend1').click(function() {
		if ($('#email1').val() == "" && $('#myname1').val() != "Ваше имя..." && $('#myphone1').val() != "Ваш номер телефона..." && $('#mytext1').val() != "Адрес. Индекс, город, улица, дом, квартира...") {
			document.getElementById('form1').submit();
		} else {
			alert("Необходимо заполнить все поля!");
		}
	});

	$('#mysend2').click(function() {
		if ($('#email2 ').val() == "" && $('#myname2').val() != "Ваше имя..." && $('#myphone2').val() != "Ваш номер телефона..." && $('#mytext2').val() != "Адрес. Индекс, город, улица, дом, квартира...") {
			document.getElementById('form2').submit();
		} else {
			alert("Необходимо заполнить все поля!");
		}
	});

	$('#mysend3').click(function() {
		if ($('#email3').val() == "" && $('#myname3').val() != "Ваше имя..." && $('#myphone3').val() != "Ваш номер телефона..." && $('#mytext3').val() != "Адрес. Индекс, город, улица, дом, квартира...") {
			document.getElementById('form3').submit();
		} else {
			alert("Необходимо заполнить все поля!");
		}
	});

});
$(function(){
	
	var myDate = new Date ();

	var note = $('#note'),
		
		ts = new Date(myDate.getFullYear(), myDate.getMonth(), myDate.getDate()+7); //,
		//ts = myDate.setDate(tmpdate),
		//newYear = true;
	
	if((new Date()) <= ts) { ts = new Date(myDate.getFullYear(), myDate.getMonth(), myDate.getDate()+7); }


//	if((new Date()) > ts){
//		ts = (new Date()).getTime() + 7*24*60*60*1000;
//		newYear = false;
//	}
		
	$('#countdown').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){
			
			var message = "";
			
			message += "Дней: " + days +", ";
			message += "часов: " + hours + ", ";
			message += "минут: " + minutes + " и ";
			message += "секунд: " + seconds + " <br />";
			
			note.html(message);
		}
	});
$('#countdown-1').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){
			
			var message = "";
			
			message += "Дней: " + days +", ";
			message += "часов: " + hours + ", ";
			message += "минут: " + minutes + " и ";
			message += "секунд: " + seconds + " <br />";
			
			note.html(message);
		}
	});
	
    $('#countdown-2').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){
			
			var message = "";
			
			message += "Дней: " + days +", ";
			message += "часов: " + hours + ", ";
			message += "минут: " + minutes + " и ";
			message += "секунд: " + seconds + " <br />";
			
			note.html(message);
		}
	});
	$('#countdown-3').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){
			
			var message = "";
			
			message += "Дней: " + days +", ";
			message += "часов: " + hours + ", ";
			message += "минут: " + minutes + " и ";
			message += "секунд: " + seconds + " <br />";
			
			note.html(message);
		}
	});
	
});

