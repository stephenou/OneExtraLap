$(document).ready(function(){

	$("#mytags").tagit({});
	
	$('#usernamefield').keyup(function() {
		validate_username();
	});
	
	$('#usernamefield').blur(function() {
		validate_username();
	});
	
	$('#fullnamefield').blur(function() {
		validate_fullname();
	});
	
	$('#newpasswordfield').blur(function() {
		validate_password();
	});
	
	$('#emailfield').blur(function() {
		validate_email();
	});
	
	$('#biofield').blur(function() {
		validate_bio();
	});
	
	$('#websitefield').blur(function() {
		validate_website();
	});
	
	$('#twitterfield').blur(function() {
		validate_twitter();
	});
	
	$('#avatarfield_e').click(function() {
		add_gravatar();
	});
	
	$('#avatarfield_t').click(function() {
		add_twavatar();
	});
	
	$('#avatarfield_n').click(function() {
		add_avatar();
	});
	
	$('#hide_setup').click(function() {
		hide_setup();
	});
	
	$('.message_container').click(function() {
		toggle_message();
		clearTimeout(t);
	});
	
	$('#settingsform').submit(function() {
		validate_all();
	});
	
	$("#createform").submit(function(){
		var q_number = 1;
		var q_amount = $("#id").val();
		var fullname = $("#hiddenfullname").val();
		var error = "";
		var repeat = "";
		q_amount = q_amount - 1;
		if ($("#quiz_title").val().replace(/ /g, '') == "") {
			error += "The quiz title\n";
		}
		while (q_number <= q_amount) {
			var a_number = "A";
			var a_amount = $("#id"+q_number).val();
			a_amount = a_amount.charCodeAt(0);
			a_amount = a_amount - 1;
			a_amount = String.fromCharCode(a_amount);
			var repeat_number = 1;
			while (repeat_number <= q_amount) {
				if (repeat_number != q_number) {
					if ($("#inputquestion"+q_number).val() == $("#inputquestion"+repeat_number).val()) {
						repeat += "Question #"+q_number+" is the same as question #"+repeat_number+"\n";
					}
				}
				repeat_number++;
			}
			if ($("#inputquestion"+q_number).val().replace(/ /g, '') == "") {
				error += "Question for #"+q_number+"\n";
			}
			while (a_number <= a_amount) {
				var repeat_answer = "A";
				while (repeat_answer <= a_amount) {
					if (repeat_answer != a_number) {
						if ($("#input"+a_number+q_number).val() == $("#input"+repeat_answer+q_number).val()) {
							repeat += "Answer "+a_number+" is the same as answer "+repeat_answer+" in question #"+q_number+"\n";
						}
					}
					repeat_answer = repeat_answer.charCodeAt(0);
					repeat_answer = repeat_answer + 1;
					repeat_answer = String.fromCharCode(repeat_answer);
				}
				if ($("#input"+a_number+q_number).val().replace(/ /g, '') == "") {
					error += "Answer "+a_number+" for #"+q_number+"\n";
				}
				a_number = a_number.charCodeAt(0);
				a_number = a_number + 1;
				a_number = String.fromCharCode(a_number);
			}
			if (!$("input:radio[name=answer"+q_number+"]:checked").val()) {
				error += "Answer choice for #"+q_number+"\n";
			}
			q_number++;
		}
		if (error == 0 && repeat == 0) {
			return true;
		}
		else if (error != 0) {
			alert("Hello "+fullname+",\n\nOur robot thinks you are just a little bit too excited to move forward but you didn't fill in the following field(s):\n\n"+error+"\nSimply fill them in and you are good to go! :)");
			return false;
		}
		else if (repeat != 0) {
			alert("Hello "+fullname+",\n\nOur robot just found out that:\n\n"+repeat+"\nSimply correct them in and you are good to go! :)");
			return false;
		}
	});
	
	$("#quizform").submit(function(){
		var number = 1;
		var amount = $("#amount").val();
		var fullname = $("#hiddenfullname").val();
		var error = "";
		while (number <= amount) {
			if (!$("input:radio[name="+number+"]:checked").val()) {
				error += "Question #"+number+"\n";
			}
			number++;
		}
		if (error != 0) {
			alert("Hello "+fullname+",\n\nOur robot thinks you are just a little bit too excited to move forward but you didn't answer the following questions:\n\n"+error+"\nAnswer them and you are good to go! :)");
			return false;
		}
		else {
			return true;
		}
	});

});

function validate_username() {

	var username = $('#usernamefield').val();
	$.post("/ajax/username", {'username': username, 'hell_yeah': 52012}, function(data) {
		$('#username').html(data.result);
	}, "json");

}

function validate_fullname() {

	var fullname = $('#fullnamefield').val();
	$.post("/ajax/fullname", {'fullname': fullname, 'hell_yeah': 52012}, function(data) {
		$('#fullname').html(data.result);
	}, "json");
	
}

function validate_password() {

	var password = $('#newpasswordfield').val();
	$.post("/ajax/password", {'password': password, 'hell_yeah': 52012}, function(data) {
		$('#newpassword').html(data.result);
	}, "json");

}

function validate_email() {

	var email = $('#emailfield').val();
	var username = $('#hiddenusername').val();
	$.post("/ajax/email", {'email': email, 'username': username, 'hell_yeah': 52012}, function(data) {
		$('#email').html(data.result);
	}, "json");

}

function validate_bio() {

	var bio = $('#biofield').val();
	$.post("/ajax/bio", {'bio': bio, 'hell_yeah': 52012}, function(data) {
		$('#bio').html(data.result);
	}, "json");

}

function validate_website() {

	var website = $('#websitefield').val();
	$.post("/ajax/website", {'website': website, 'hell_yeah': 52012}, function(data) {
		$('#website').html(data.result);
	}, "json");

}

function validate_twitter() {

	var twitter = $('#twitterfield').val();
	$.post("/ajax/twitter", {'twitter': twitter, 'hell_yeah': 52012}, function(data) {
		$('#twitter').html(data.result);
	}, "json");

}

function add_gravatar() {

	var email = $('#hiddenemail').val();
	$.post("/ajax/avatar", {'avatar': 'gravatar', 'email': email, 'hell_yeah': 52012}, function(data) {
		$('#avatar').html(data.result);
	}, "json");

}

function add_twavatar() {

	var twitter = $('#hiddentwitter').val();
	$.post("/ajax/avatar", {'avatar': 'twavatar', 'twitter': twitter, 'hell_yeah': 52012}, function(data) {
		$('#avatar').html(data.result);
	}, "json");

}

function add_avatar() {

	$.post("/ajax/avatar", {'avatar': 'none', 'hell_yeah': 52012}, function(data) {
		$('#avatar').html(data.result);
	}, "json");

}

function hide_setup() {

	$.post("/ajax/hidesetup", {'hide_setup': 0, 'hell_yeah': 52012}, function(data) {
		$('#hide_setup').html(data.result);
		toggle('setup_guide');
	}, "json");

}

function validate_all() {

	validate_username();
	validate_fullname();
	validate_email();
	validate_password();
	validate_bio();
	validate_website();
	validate_twitter();

}

function initialize(number, focus) {

	toggle_message_in(number);
	t = setTimeout("toggle_message()", 4000);
	validate_all();
	if (focus == 1) {
		add_focus("newpasswordfield");
		add_focus("emailfield");
		add_focus("usernamefield");
		add_focus("fullnamefield");
	}

}

function toggle(field) {

	$('#'+field).slideToggle('slow');

}

function toggle_message_in(number) {

	number = number * 43;
	$(".message_container").animate({height: number+"px"}, 500);

}

function toggle_message() {

	$(".message_container").animate({height: "0"}, 500);

}

function add_focus(field) {

	$("#"+field).focus();

}

function formfocus(text) {

	if ($("#search").val() == text) {
		$("#search").attr("value", "");
	}

}

function formblur(text) {

	if ($("#search").val() == '') {
		$("#search").attr("value", text);
	}

}

function peoplechange() {

	document.searchform.action = "/search/people/"+encodeURI($("#search").val());
	
}

function quizzeschange() {

	document.searchform.action = "/search/quizzes/"+encodeURI($("#search").val());
	
}

function tagschange() {

	document.searchform.action = "/search/tags/"+encodeURI($("#search").val());
	
}

function createchange() {

	$("#createpreform").attr("action", "/create/"+encodeURI($("#quiz_title").val()));
	
}

function createchangeagain() {

	input = encodeURI($("#quiz_title").val());
	$("#g_link").attr("href","http://www.google.com/search?q="+input);
	$("#w_link").attr("href","http://en.wikipedia.org/wiki/"+input);
	$("#t_link").attr("href","http://http://twitter.com/#search?q="+input);
	
}

function follow(following, follower, page) {
	$.post("/ajax/follow", {'following': following, 'follower': follower, 'page': page, 'hell_yeah': 52012}, function(data) {
		$('#follow_'+follower).html(data.result);
		if (data.type == 1) {
			$('#following').html(data.followingnumber);
			$('#follower').html(data.followernumber);
			if (data.followernumber == 1) {
				$('#sss').html('');
			}
			else {
				$('#sss').html('s');
			}
		}
	}, "json");
}

function addQuestion() {
	var id = $("#id").val();
	if (id < 10) {
		$("#add").before("<li><div class='left'><div class='prompt'>Plus One!</div><div class='question' id='q"+id+"'><div id='"+id+"question'><div class='left'><span class='question'>Question: </span></div><div class='right'><input type='text' name='question"+id+"' class='input question answerinput' id='inputquestion"+id+"'></div><div class='clear'></div></div><div id='"+id+"A'><div class='left'><span class='A'>Choice A: </span></div><div class='right'><input type='text' name='A"+id+"' class='input answerinput' value='' id='inputA"+id+"'></div><div class='clear'></div></div><div id='"+id+"B'><div class='left'><span class='B'>Choice B: </span></div><div class='right'><input type='text' name='B"+id+"' class='input answerinput' value='' id='inputB"+id+"'></div><div class='clear'></div></div><div id='"+id+"C'><div class='left'><span class='C'>Choice C: </span></div><div class='right'><input type='text' name='C"+id+"' class='input answerinput' value='' id='inputC"+id+"'></div><div class='clear'></div></div></div><div class='rightanswer'><div class='button_menu'><input type='hidden' id='id"+id+"' name='id"+id+"' value='D'><input type='button' class='button green' id='add"+id+"' value='+' onclick='addAnswer("+id+"); return false'><input type='button' class='button red' id='add"+id+"' value='-' onclick='deleteAnswer("+id+"); return false'></div><div class='answerlabel' id='answerlabel"+id+"'><div class='text'>Answer:</div> <span id='labelA"+id+"'><input type='radio' value='A' name='answer"+id+"' id='A"+id+"' onclick='answerChoose(\"A\", "+id+")'> <label for='A"+id+"'><span class='A'>A</span></label> </span><span id='labelB"+id+"'><input type='radio' value='B' name='answer"+id+"' id='B"+id+"' onclick='answerChoose(\"B\", "+id+")'> <label for='B"+id+"'><span class='B'>B</span></label> </span><span id='labelC"+id+"'><input type='radio' value='C' name='answer"+id+"' id='C"+id+"' onclick='answerChoose(\"C\", "+id+")'> <label for='C"+id+"'><span class='C'>C</span></label> </span></div></div></div><div class='right circle'>"+id+"</div><div class='clear'></div></li>");
		id++;
		$("#id").attr("value", id);
	}
	else {
		alert("Maybe you missed the tips on the left, you can only have 9 questions maximum per quiz.");
	}
}

function addAnswer(question) {
	var id = $("#id"+question).val();
	if (id < "J") {
		$("#q"+question).append("<div id='"+question+""+id+"'><div class='left'><span class='"+id+"'>Choice "+id+": </span></div><div class='right'><input type='text' name='"+id+""+question+"' class='input answerinput' value='' id='input"+id+""+question+"'></div><div class='clear'></div></div>");
		$("#answerlabel"+question).append(" <span id='label"+id+""+question+"'><input type='radio' value='"+id+"' name='answer"+question+"' id='"+id+""+question+"' onclick=\"answerChoose('"+id+"', '"+question+"')\"> <label for='"+id+""+question+"'><span class='"+id+"'>"+id+"</span></label></span>");
		id = id.charCodeAt(0);
		id++;
		id = String.fromCharCode(id);
		$("#id"+question).attr("value", id);
	}
	else {
		alert("Maybe you missed the tips on the left, you can only have 9 answers maximum per question.");
	}
}

function deleteAnswer(question) {
	var id = $("#id"+question).val();
	if (id > "C") {
		id = id.charCodeAt(0);
		id = id - 1;
		id = String.fromCharCode(id);
		$("#"+question+""+id).remove();
		$("#label"+id+""+question).remove();
		$("#id"+question).attr("value", id);
	}
	else {
		alert("Maybe you missed the tips on the left, you can only have 2 answers minimum per question.");
	}
}

function answerChoose(id, question) {
	$("#inputA"+question).removeClass('answerchoose');
	$("#inputB"+question).removeClass('answerchoose');
	$("#inputC"+question).removeClass('answerchoose');
	$("#inputD"+question).removeClass('answerchoose');
	$("#inputE"+question).removeClass('answerchoose');
	$("#inputF"+question).removeClass('answerchoose');
	$("#inputG"+question).removeClass('answerchoose');
	$("#inputH"+question).removeClass('answerchoose');
	$("#inputI"+question).removeClass('answerchoose');
	$("#input"+id+question).addClass('answerchoose');
}

function answerUnchoose(id) {
	$("#input"+id).removeClass('answerchoose');
}

function addterm(term) {
	var exist = $("#quiz_title").val();
	if (exist == term) {
		$("#quiz_title").attr("value","");
	}
	else {
		$("#quiz_title").attr("value",term);
	}
	createchangeagain();
}