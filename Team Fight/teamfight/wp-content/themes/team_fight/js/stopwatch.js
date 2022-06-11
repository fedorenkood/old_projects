function StopWatch(start = '') {
  
  var minutes = 00; 
  var seconds = 00; 
  var appendSeconds = document.getElementById("seconds")
  var appendMinutes = document.getElementById("minutes")
  var buttonStart = document.getElementById('button-start');
  var buttonReset = document.getElementById('button-reset');
  var buttonClose = document.getElementById('button-close');
  var Interval;
  var search_int;
  var search_link = "wp-content/themes/team_fight/libs/xhr/search_team.php";
  var chat_link = "wp-content/themes/team_fight/libs/xhr/chat.php";

	if (start == 'start') {
		startSearch();
	}

	buttonStart.onclick = function() {
		startSearch();
	}


	buttonReset.onclick = function() {
		cancelSearch();
	}
  

	buttonClose.onclick = function() {
		cancelSearch();
	}

	
	function startSearch() {
		if ($("#cs_go").is(':visible')) {
			var cs_go_st = 'yes';
			var ret_data = '';
			var search_st = 0;
			search_int = setInterval(
				function () {
					if (search_st == 0) {
						$.post(search_link, {
							search_st: search_st,
							cs_go_st: cs_go_st
						}, function(data, status) {
							ret_data = data;
							if (ret_data != '' && ret_data != false) {
								clearInterval(search_int);
								$.post(chat_link, {
									hash: ret_data
								}, function(data, status) {
									$("section .container").html(data);
									$("section .container").addClass("chat_con");
									$(".mfp-ready").remove();
								});
							}

						});
					} 
					else if (search_st > 0) {
						$.post(search_link, {
							search_st: search_st,
							cs_go_st: cs_go_st
						}, function(data, status) {
							ret_data = data;
							if (ret_data != '' && ret_data != false) {
								clearInterval(search_int);
								$.post(chat_link, {
									hash: ret_data
								}, function(data, status) {
									$("section .container").html(data);
									$("section .container").addClass("chat_con");
									$(".mfp-ready").remove();
								});
							}
						});
					}
					search_st++;
				}

			, 3000);
		} else if ($("#dota").is(':visible')) {
			var dota_st = 'yes';
			var ret_data = '';
			var search_st = 0;
			search_int = setInterval(
				function () {
					if (search_st == 0) {
						$.post(search_link, {
							search_st: search_st,
							dota_st: dota_st
						}, function(data, status) {
							ret_data = data;
							if (ret_data != '' && ret_data != false) {
								clearInterval(search_int);
								$.post(chat_link, {
									hash: ret_data
								}, function(data, status) {
									$("section .container").html(data);
									$("section .container").addClass("chat_con");
									$(".mfp-ready").remove();
								});
							}

						});
					} 
					else if (search_st > 0) {
						$.post(search_link, {
							search_st: search_st,
							dota_st: dota_st
						}, function(data, status) {
							ret_data = data;
							if (ret_data != '' && ret_data != false) {
								clearInterval(search_int);
								$.post(chat_link, {
									hash: ret_data
								}, function(data, status) {
									$("section .container").html(data);
									$("section .container").addClass("chat_con");
									$(".mfp-ready").remove();
								});
							}
						});
					}
					search_st++;
				}

			, 3000);
		}
		$(".search_sel").css("display","block");
		$("#button-start").css("display","none");
		clearInterval(Interval);
		Interval = setInterval(startTimer, 1000);
	}

	function cancelSearch() {
		clearInterval(search_int);
		if ($("#cs_go").is(':visible')) {
			var cs_go_st = 'no';
			$.post(search_link, {
				cs_go_st: cs_go_st
			});
		} else if ($("#dota").is(':visible')) {
			var dota_st = 'no';
			$.post(search_link, {
				dota_st: dota_st
			});
		}
		$(".search_sel").css("display","none");
		$("#button-start").css("display","block");
		clearInterval(Interval);
		seconds = "00";
		minutes = "00";
		appendSeconds.innerHTML = seconds;
		appendMinutes.innerHTML = minutes;
	}


  function startTimer () {
    seconds++; 
    
    if(seconds <= 9){
      appendSeconds.innerHTML = "0" + seconds;
    }
    
    if (seconds > 9){
      appendSeconds.innerHTML = seconds;
      
    } 
    
    if (seconds > 59) {
      minutes++;
      appendMinutes.innerHTML = "0" + minutes;
      seconds = 0;
      appendSeconds.innerHTML = "0" + 0;
    }
    
    if (minutes > 9){
      appendMinutes.innerHTML = minutes;
    }
  
  }
  
}


function PlayTime() {

	var minutes = 00; 
	var seconds = 00; 
	var appendSeconds = document.getElementById("playSec")
	var appendMinutes = document.getElementById("playMin")
	var SecInterval;
	var search_int;
	
	clearInterval(SecInterval);
	SecInterval = setInterval(startTimer, 1000);

	function startTimer () {
		seconds++; 

		if(seconds <= 9){
			appendSeconds.innerHTML = "0" + seconds;
		}

		if (seconds > 9){
			appendSeconds.innerHTML = seconds;
		} 

		if (seconds > 59) {
			minutes++;
			appendMinutes.innerHTML = "0" + minutes;
			seconds = 0;
			appendSeconds.innerHTML = "0" + 0;
		}

		if (minutes > 9){
			appendMinutes.innerHTML = minutes;
		}
	}

}
