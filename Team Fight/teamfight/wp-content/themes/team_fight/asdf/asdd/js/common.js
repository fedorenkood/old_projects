var save_user_inform_link = "wp-content/themes/team_fight/libs/xhr/save_user_inform.php";

$(document).ready(function() {
	
	// Scripts for pop ups
	$(".popup_content").magnificPopup({
		type:"inline",
		midClick: true
	});

	$(".game_card").each(function(i) {
		$(this).find("a").first().attr("href", "#game_" + i)
		$(this).find(".modal_team_find").attr("id", "game_" + i)
	});


	// Load functions
	dropdownCsGo();
	dotaDataSave();

	// Function to keep user be constantly online
	// Updating last visit 
	setInterval(function() {
		if (navigator.onLine) {
			var active = 'yes';
			$.post(save_user_inform_link, {
				active: active
			});
		} else {
			var active = 'no';
			$.post(save_user_inform_link, {
				active: active
			});
		}
	}, 3000); 

	// Function for changing active state when you leave page
	window.onbeforeunload = function() {
		var st = 'no';
		console.log(
			$.post(save_user_inform_link, {
				st_off: st
			})
		);
	};


	
});


// Loader
$(window).load(function() {

	$(".loader_inner").fadeOut();
	$(".loader").delay(400).fadeOut("slow");

	$(".top_text h1").animated("fadeInDown", "fadeOutUp");
	$(".top_text p").animated("fadeInUp", "fadeOutDown");

}); 




// Function for selecting number of team players
function selectTeamNum(object) {
	if (!$('.stopwatch').is(':visible')) {
		var team_num = object.value;
		if (team_num == 2) {
			$('.num_new[value="5"]').removeClass("selected");
			$('.num_new[value="2"]').addClass("selected");
		} else if (team_num == 5) {
			$('.num_new[value="2"]').removeClass("selected");
			$('.num_new[value="5"]').addClass("selected");
		}
		
		$.post(save_user_inform_link, {
			team_num: team_num
		});
	}
}




// Selecting CS:GO rank
function dropdownCsGo() {
	//Selecting a rank from the game in a dropdown
	//Vallue of the rank will be used in search
	var a=0;
	$(".value").each(function(i) {
		i=i+1;
		a=a+1;
		if (a>18) {
			a=1;
		}
		$(this).html("rank_" + a);
	});
	a=0;
	$(".rank").each(function(i) {
		i=i+1;
		a=a+1;
		if (a>18) {
			a=1;
		}
		$(this).attr("src", "wp-content/themes/team_fight/img/ranks_cs/" + a + ".png");
	});

	$(".dropdown img.rank").addClass("rank_visibility");


	$(".dropdown dt a").click(function() {
		if (!$('.stopwatch').is(':visible')) {
	   		$(".dropdown dd ul").toggle();
		}
	});
	            
	$(".dropdown dd ul li a").click(function() {
		if (!$('.stopwatch').is(':visible')) {
			var text = $(this).html();
			$(".dropdown dt a span").html(text);
			$(".dropdown dd ul").hide();
			var cs_rank=$("dt a span.rank_sec").find('span').html();
			$.post(save_user_inform_link, {
				cs_go: cs_rank
			});
		}
	});


	$(document).bind('click', function(e) {
	    var $clicked = $(e.target);
	    if (! $clicked.parents().hasClass("dropdown"))
	        $(".dropdown dd ul").hide();
	});

	$(".dropdown img.rank").toggleClass("rank_visibility"); 
}




// Save Dota 2 data functions
function dotaDataSave() {
	$(".save_stats_btn").click(function() {
		if (!$('.stopwatch').is(':visible')) {
			var dota=$('input[name="dota"]').val();
			if (dota.length !== 0) {
				$.post(save_user_inform_link, {
					dota: dota
				}, function(data, status) {
					if (status=="success") {
						$("#complete").html("MMR saved");
						$("#complete").slideDown();
						setTimeout(function () {
							$("#complete").slideUp();
						}, 3000)
					} else {
						$("#error").html(data);
						$("#error").slideDown();
						setTimeout(function () {
							$("#error").slideUp();
						}, 3000)
					}
				});
			} else {
				$("#error").html("Fill in MMR");
				$("#error").slideDown();
				setTimeout(function () {
					$("#error").slideUp();
				}, 3000)
			}
		}
	});
}




// Sva data at profile page
function saveData(){
	var cs_rank=$("dt a span.rank_sec").find('span').html();
	var dota=$('input[name="dota"]').val();
	var age=$('input[name="age"]').val();
	var lang=$('#language').val();
	if (lang != "" && dota.length !== 0 && age.length !== 0) {
		$.post(save_user_inform_link, {
			cs_go: cs_rank,
			dota: dota,
			age: age,
			lang: lang
		}, function(data, status) {
			if (status=="success") {
				$("#complete").html("Data saved");
				$("#complete").slideDown();
				setTimeout(function () {
					$("#complete").slideUp();
				}, 3000)
			} else {
				$("#error").html(data);
				$("#error").slideDown();
				setTimeout(function () {
					$("#error").slideUp();
				}, 3000)
			}
		});
	} else {
		$("#error").html("Fill in all the fields");
		$("#error").slideDown();
		setTimeout(function () {
			$("#error").slideUp();
		}, 3000)
	}
}




// Functions for profile page
function maxLengthCheck (object) {
	if (object.value.length > object.max.length)
		object.value = object.value.slice(0, object.max.length)
}

function isNumeric (evt) {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode (key);
	var regex = /[0-9]|\./;
	if ( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}




// Start of functions for voice chat
function changeVol (elem) {
	$(elem).find("i").toggleClass("fa-volume-up");
	$(elem).find("i").toggleClass("fa-volume-off");
}

function changeMicr (elem) {
	$(elem).find("i").toggleClass("fa-microphone");
	$(elem).find("i").toggleClass("fa-microphone-slash");
}



