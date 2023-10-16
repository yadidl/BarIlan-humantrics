'use strict';

let allcustomers = [];
let dontsendwas = [];
let dontsendsmss = [];
let dontsendrs = [];
let msgs = [];
let rmsgs = [];
let rowscount = [];
let rowscount_compl = [];
let completed = [];
let phonics = [];
let lastphonics = [];
let physioqs = [];
let physmaxdates = [];
let twilios = [];
let twilios_sms = [];
let wams = [];
// let lastoffset = 0;
let curpage = 0;
var MD5 = function(d){var r = M(V(Y(X(d),8*d.length)));return r.toLowerCase()};function M(d){for(var _,m="0123456789ABCDEF",f="",r=0;r<d.length;r++)_=d.charCodeAt(r),f+=m.charAt(_>>>4&15)+m.charAt(15&_);return f}function X(d){for(var _=Array(d.length>>2),m=0;m<_.length;m++)_[m]=0;for(m=0;m<8*d.length;m+=8)_[m>>5]|=(255&d.charCodeAt(m/8))<<m%32;return _}function V(d){for(var _="",m=0;m<32*d.length;m+=8)_+=String.fromCharCode(d[m>>5]>>>m%32&255);return _}function Y(d,_){d[_>>5]|=128<<_%32,d[14+(_+64>>>9<<4)]=_;for(var m=1732584193,f=-271733879,r=-1732584194,i=271733878,n=0;n<d.length;n+=16){var h=m,t=f,g=r,e=i;f=md5_ii(f=md5_ii(f=md5_ii(f=md5_ii(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_ff(f=md5_ff(f=md5_ff(f=md5_ff(f,r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+0],7,-680876936),f,r,d[n+1],12,-389564586),m,f,d[n+2],17,606105819),i,m,d[n+3],22,-1044525330),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+4],7,-176418897),f,r,d[n+5],12,1200080426),m,f,d[n+6],17,-1473231341),i,m,d[n+7],22,-45705983),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+8],7,1770035416),f,r,d[n+9],12,-1958414417),m,f,d[n+10],17,-42063),i,m,d[n+11],22,-1990404162),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+12],7,1804603682),f,r,d[n+13],12,-40341101),m,f,d[n+14],17,-1502002290),i,m,d[n+15],22,1236535329),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+1],5,-165796510),f,r,d[n+6],9,-1069501632),m,f,d[n+11],14,643717713),i,m,d[n+0],20,-373897302),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+5],5,-701558691),f,r,d[n+10],9,38016083),m,f,d[n+15],14,-660478335),i,m,d[n+4],20,-405537848),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+9],5,568446438),f,r,d[n+14],9,-1019803690),m,f,d[n+3],14,-187363961),i,m,d[n+8],20,1163531501),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+13],5,-1444681467),f,r,d[n+2],9,-51403784),m,f,d[n+7],14,1735328473),i,m,d[n+12],20,-1926607734),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+5],4,-378558),f,r,d[n+8],11,-2022574463),m,f,d[n+11],16,1839030562),i,m,d[n+14],23,-35309556),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+1],4,-1530992060),f,r,d[n+4],11,1272893353),m,f,d[n+7],16,-155497632),i,m,d[n+10],23,-1094730640),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+13],4,681279174),f,r,d[n+0],11,-358537222),m,f,d[n+3],16,-722521979),i,m,d[n+6],23,76029189),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+9],4,-640364487),f,r,d[n+12],11,-421815835),m,f,d[n+15],16,530742520),i,m,d[n+2],23,-995338651),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+0],6,-198630844),f,r,d[n+7],10,1126891415),m,f,d[n+14],15,-1416354905),i,m,d[n+5],21,-57434055),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+12],6,1700485571),f,r,d[n+3],10,-1894986606),m,f,d[n+10],15,-1051523),i,m,d[n+1],21,-2054922799),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+8],6,1873313359),f,r,d[n+15],10,-30611744),m,f,d[n+6],15,-1560198380),i,m,d[n+13],21,1309151649),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+4],6,-145523070),f,r,d[n+11],10,-1120210379),m,f,d[n+2],15,718787259),i,m,d[n+9],21,-343485551),m=safe_add(m,h),f=safe_add(f,t),r=safe_add(r,g),i=safe_add(i,e)}return Array(m,f,r,i)}function md5_cmn(d,_,m,f,r,i){return safe_add(bit_rol(safe_add(safe_add(_,d),safe_add(f,i)),r),m)}function md5_ff(d,_,m,f,r,i,n){return md5_cmn(_&m|~_&f,d,_,r,i,n)}function md5_gg(d,_,m,f,r,i,n){return md5_cmn(_&f|m&~f,d,_,r,i,n)}function md5_hh(d,_,m,f,r,i,n){return md5_cmn(_^m^f,d,_,r,i,n)}function md5_ii(d,_,m,f,r,i,n){return md5_cmn(m^(_|~f),d,_,r,i,n)}function safe_add(d,_){var m=(65535&d)+(65535&_);return(d>>16)+(_>>16)+(m>>16)<<16|65535&m}function bit_rol(d,_){return d<<_|d>>>32-_}
function local_time(tm) {
	var newtm = new Date(tm);
	return newtm.toLocaleString();
}
function local_time_only(tm) {
	var newtm = new Date(tm);
	var options = { hour: '2-digit', minute: '2-digit' };
	return newtm.toLocaleTimeString('he-IL', options);
}
window.onbeforeunload = function(e) {
  if ($("body").hasClass("nounload")) {
    return "A Qualtrics process is running! Let the process complete before navigating away!";
  }
};
$(document).ready(function () {
	getTwilios();
	getTwiliosSMS();
	getComplete();
	getCustomers();
	getLibraries();
	$('#phone').inputmask({mask: '+(999) 99 999-999[9]', greedy: false});
	$('#start_time_all').inputmask('99:99');
	$('#start_time_su').inputmask('99:99');
	$('#start_time_mo').inputmask('99:99');
	$('#start_time_tu').inputmask('99:99');
	$('#start_time_we').inputmask('99:99');
	$('#start_time_th').inputmask('99:99');
	$('#start_time_fr').inputmask('99:99');
	$('#start_time_sa').inputmask('99:99');
	$('#end_time_all').inputmask('99:99');
	$('#end_time_su').inputmask('99:99');
	$('#end_time_mo').inputmask('99:99');
	$('#end_time_tu').inputmask('99:99');
	$('#end_time_we').inputmask('99:99');
	$('#end_time_th').inputmask('99:99');
	$('#end_time_fr').inputmask('99:99');
	$('#end_time_sa').inputmask('99:99');
	$.fn.datepicker.language['en'] =  {
		days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
		daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
		daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
		months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
		monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		today: "Today",
		clear: "Clear",
		format: "dd/mm/yyyy",
		titleFormat: "MM yyyy"
	};
	$(".is_date_left").datepicker({
		dateFormat: 'yyyy-mm-dd',
		language: 'en',
		autoClose: true,
		position: "left top",
	});
	$("#roles").submit(function(e) {
		e.preventDefault();
		if (chkFields1()) {
			let data = $("#roles").serialize();
			$("#roles").fadeOut(300);
			$.ajax({
				"async": true,
				"url": "xp_ajax.php",
				"method": "POST",
				"timeout": 125000,
				"dataType": "json",
				"data": "action=roles&method=POST&data=" + encodeURIComponent(data),
			}).done(function(response) {
				$("#roles").fadeIn(300);
				showAlert("success", "Parameters saved successfully");
			}).fail(function(jqXHR, textStatus) {
				showAlert("warning", "Error saving parameters... " + textStatus);
			});
		}
	});
	$("#customers").submit(function(e) {
		e.preventDefault();
		let foo = 0;
		if (chkFields2()) {
			if (foo == 0) {
				$("body").addClass("nounload");
				showAlert("success", "Testing participant ... please wait...");
				let data = $("#customers").serialize();
				// $("#customers").fadeOut(300);
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 500000,
					"dataType": "json",
					"data": "action=customer&method=TEST&data=" + encodeURIComponent(data),
				}).done(function(response) {
					// $("#roles").fadeIn(300);
					$("body").removeClass("nounload");
					console.log(response);
					let html = "<input type=\"hidden\" name=\"survey_id\" value=\"" + response.survey_id + "\" />";
					html = html + "<input type=\"hidden\" name=\"start_date\" value=\"" + response.start_date + "\" />";
					html = html + "<input type=\"hidden\" name=\"days\" value=\"" + response.days + "\" />";
					html = html + "<input type=\"hidden\" name=\"start_time_all\" value=\"" + response.start_time_all + "\" />";
					html = html + "<input type=\"hidden\" name=\"start_time_su\" value=\"" + response.start_time_su + "\" />";
					html = html + "<input type=\"hidden\" name=\"start_time_mo\" value=\"" + response.start_time_mo + "\" />";
					html = html + "<input type=\"hidden\" name=\"start_time_tu\" value=\"" + response.start_time_tu + "\" />";
					html = html + "<input type=\"hidden\" name=\"start_time_we\" value=\"" + response.start_time_we + "\" />";
					html = html + "<input type=\"hidden\" name=\"start_time_th\" value=\"" + response.start_time_th + "\" />";
					html = html + "<input type=\"hidden\" name=\"start_time_fr\" value=\"" + response.start_time_fr + "\" />";
					html = html + "<input type=\"hidden\" name=\"start_time_sa\" value=\"" + response.start_time_sa + "\" />";
					html = html + "<input type=\"hidden\" name=\"end_time_all\" value=\"" + response.end_time_all + "\" />";
					html = html + "<input type=\"hidden\" name=\"end_time_su\" value=\"" + response.end_time_su + "\" />";
					html = html + "<input type=\"hidden\" name=\"end_time_mo\" value=\"" + response.end_time_mo + "\" />";
					html = html + "<input type=\"hidden\" name=\"end_time_tu\" value=\"" + response.end_time_tu + "\" />";
					html = html + "<input type=\"hidden\" name=\"end_time_we\" value=\"" + response.end_time_we + "\" />";
					html = html + "<input type=\"hidden\" name=\"end_time_th\" value=\"" + response.end_time_th + "\" />";
					html = html + "<input type=\"hidden\" name=\"end_time_fr\" value=\"" + response.end_time_fr + "\" />";
					html = html + "<input type=\"hidden\" name=\"end_time_sa\" value=\"" + response.end_time_sa + "\" />";
					html = html + "<input type=\"hidden\" name=\"name\" value=\"" + response.name + "\" />";
					html = html + "<input type=\"hidden\" name=\"lastname\" value=\"" + response.lastname + "\" />";
					html = html + "<input type=\"hidden\" name=\"email\" value=\"" + response.email + "\" />";
					html = html + "<input type=\"hidden\" name=\"phone\" value=\"" + response.phone + "\" />";
					html = html + "<input type=\"hidden\" name=\"lid\" value=\"" + response.lid + "\" />";
					html = html + "<input type=\"hidden\" name=\"dontsendr\" value=\"" + (response.dontsendr?1:0) + "\" />";
					html = html + "<input type=\"hidden\" name=\"dontsendwa\" value=\"" + (response.dontsendwa?1:0) + "\" />";
					html = html + "<input type=\"hidden\" name=\"dontsendsms\" value=\"" + (response.dontsendsms?1:0) + "\" />";
					html = html + "<input type=\"hidden\" name=\"contact_id\" value=\"" + response.contact_id + "\" />";
					html = html + "<input type=\"hidden\" name=\"Dyad_ID\" value=\"" + response.Dyad_ID + "\" />";
					html = html + "<input type=\"hidden\" name=\"mid\" value=\"" + response.mid + "\" />";
					html = html + "<input type=\"hidden\" name=\"rmid\" value=\"" + response.rmid + "\" />";
					html = html + "<input type=\"hidden\" name=\"wamid\" value=\"" + response.wamid + "\" />";
					html = html + "<input type=\"hidden\" name=\"warmid\" value=\"" + response.warmid + "\" />";
					html = html + "<input type=\"hidden\" name=\"smsid\" value=\"" + response.smsid + "\" />";
					html = html + "<input type=\"hidden\" name=\"smsrid\" value=\"" + response.smsrid + "\" />";
					html = html + "<input type=\"hidden\" name=\"distrs_count\" value=\"" + (response.distributions?response.distributions.length:0) + "\" />";
					if (response.comment)
						html = html + "<div class=\"alert_comment\">" + response.comment + "</div>";
					html = html + "<table id=\"timesTable\" class=\"table table-bordered table-striped\"><thead>";
					html = html + "<tr>";
					html = html + "<th>Send time<br />(YYYY-MM-DD HH:MM)</th>";
					html = html + "<th>Reminder send time<br />(YYYY-MM-DD HH:MM)</th>";
					html = html + "<th>Expiration time<br />(YYYY-MM-DD HH:MM)</th>";
					html = html + "<th>&times;</th>";
					html = html + "</tr>";
					if (!response.distributions)
						alert("No distributions set!");
					$.each(response.distributions, function(index, value) {
						// console.log(value);
						html = html + "<tr>";
						html = html + "<td><input name=\"send_time" + index + "\" value=\"" + value.send_time + "\" /></td>";
						html = html + "<td><input name=\"reminder_send_time" + index + "\" value=\"" + value.reminder_send_time + "\" /></td>";
						html = html + "<td><input name=\"expiration_time" + index + "\" value=\"" + value.expiration_time + "\" /></td>";
						html = html + "<td><button type=\"button\" onClick=\"$(this).parent().parent().toggleClass('bg-danger').find('input').attr('disabled', function(index, attr){return attr == 'disabled' ? null : 'disabled';})\">&times;</button></td>";
						html = html + "</tr>";
					});
					html = html + "</thead><tbody>";
					html = html + "</tbody></table>";
					html = html + "<button type=\"submit\">Add it</button>&nbsp;";
					html = html + "<button class=\"js-addbulk\" type=\"button\">Add task to a bulk</button>";
					$("#customers_times").html(html);
					$("#customers_times input").inputmask("9999-99-99 99:99");
					$("#schedule_view").fadeIn(300);
					// showAlert("success", "Participant added... reloading", 1);
				}).fail(function(jqXHR, textStatus) {
					showAlert("warning", "Error testing participant... " + textStatus);
				});
			}
			else
				showAlert("warning", "Error customer add...");
		}
	});
	$("#customers_times").submit(function(e) {
		e.preventDefault();
		let foo = 0;
		if (chkFields3()) {
			if (foo == 0) {
				$("body").addClass("nounload");
				showAlert("success", "Adding participant ... please wait...");
				let data = $("#customers_times").serialize();
				$("#customers_times").parent().parent().fadeOut(300);
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 5000000,
					"dataType": "json",
					"data": "action=customer&method=ADD&data=" + encodeURIComponent(data),
				}).done(function(response) {
					$("#roles").fadeIn(300);
					$("body").removeClass("nounload");
					showAlert("success", "Participant added... reloading", 1);
				}).fail(function(jqXHR, textStatus) {
					showAlert("warning", "Error adding participant... " + textStatus);
				});
			}
			else
				showAlert("warning", "Error customer add...");
		}
	});
	$(document).on("click", "[data-close]", function(event) {
		$(this).parent().fadeOut(300);
	});
	$(document).on("click", "[data-close-parent]", function(event) {
		$(this).parent().parent().fadeOut(300);
	});
	$(document).on("click", ".js-sendbulks", function(event) {
		let sid = $(this).data("sid");
		$.ajax({
			"async": true,
			"url": "xp_ajax.php",
			"method": "POST",
			"timeout": 125000,
			"dataType": "json",
			"data": "method=GET&action=bulks&sid=" + sid,
		}).done(function(response) {
			if (response != null && typeof response.result != "undefined" && typeof response.result.elements != "undefined") {
				$.each(response.result.elements, function(index, value) {
					// console.table(value.bulk);
					$("body").addClass("nounload");
					showAlert("success", "Adding participant ... please wait...");
					$.ajax({
						"async": true,
						"url": "xp_ajax.php",
						"method": "POST",
						"timeout": 5000000,
						"dataType": "json",
						"data": "action=customer&method=ADD&data=" + encodeURIComponent(value.bulk),
					}).done(function(response) {
						// alert(value.surveyId);
						$.ajax({
							"async": true,
							"url": "xp_ajax.php",
							"method": "POST",
							"timeout": 125000,
							"dataType": "json",
							"data": "action=bulk&method=DELETE&sid=" + value.surveyId,
						}).done(function(response) {
							$("#bulks_count").text(0);
							$("#send_bulks").parent().fadeOut(300);
							$("body").removeClass("nounload");
							showAlert("success", "Participant added... reloading", 1);
						}).fail(function(jqXHR, textStatus) {
							showAlert("warning", textStatus);
						});
					}).fail(function(jqXHR, textStatus) {
						showAlert("warning", textStatus);
					});
				});
			}
		}).fail(function(jqXHR, textStatus) {
			// console.log(textStatus);
			showAlert("warning", textStatus);
		});
	});
	$(document).on("click", ".js-tnext", function(event) {
		let surveyId = $(this).data("sid");
		for (let mid in allcustomers[surveyId]) {
			if (typeof rowscount[mid] != "undefined")
				$(".tabletd_" + mid).show().removeAttr("data-exclude");
			else
				$(".tabletd_" + mid).hide().attr("data-exclude", "true");
		}
		curpage++;
		let totalpages = parseInt($("th.tabletd:visible").length/10);
		if (curpage >= totalpages)
			$(".js-tnext").fadeOut(300);
		$(".js-tprev").fadeIn(300);
		$("#headerTable tr").each(function(index, tr) {
			let $tds = $(tr).find(".tabletd:visible");
			let $sliced = $tds.slice(curpage*10, (curpage + 1)*10);
			$(tr).find(".tabletd").fadeOut(300).promise().done(function() {
				$sliced.fadeIn(300);
			});
		});
	});
	$(document).on("click", ".js-tprev", function(event) {
		let surveyId = $(this).data("sid");
		for (let mid in allcustomers[surveyId]) {
			if (typeof rowscount[mid] != "undefined")
				$(".tabletd_" + mid).show().removeAttr("data-exclude");
			else
				$(".tabletd_" + mid).hide().attr("data-exclude", "true");
		}
		curpage--;
		if (curpage < 1)
			$(".js-tprev").fadeOut(300);
		$(".js-tnext").fadeIn(300);
		$("#headerTable tr").each(function(index, tr) {
			let $tds = $(tr).find(".tabletd:visible");
			let $sliced = $tds.slice(curpage*10, (curpage + 1)*10);
			$(tr).find(".tabletd").fadeOut(300).promise().done(function() {
				$sliced.fadeIn(300);
			});
		});
	});
	$(document).on("click", ".js-rebuild", function(event) {
		curpage = 0;
		$(".js-tprev").fadeOut(300);
		let time_start = $("#time_start").val();
		let time_end = $("#time_end").val();
		let participant_start = $("#participant_start").val();
		let participant_end = $("#participant_end").val();
		let sid = $(this).data("sid");
		getPhonic(sid, $("#phonicID").val(), $("#phonic_questionID").val());
	});
	$(document).on("click", ".js-csv", function(event) {
		let sid = $(this).data("sid");
		let mid = $(this).data("mid");
		location.href = "xp_csv.php?sid=" + sid + "&mid=" + mid;
	});
	$(document).on("click", ".js-export", function(event) {
		// let sid = $(this).data("sid");
		TableToExcel.convert(document.getElementById("headerTable"), {
		  name: "surveys.xlsx",
		  sheet: {
			name: "Sheet 1"
		  }
		});
	});
	/*
	$(document).on("click", ".js-nextpage", function(event) {
		curpage = 0;
		let sid = $(this).data("sid");
		let nextPage = $(this).data("next");
		let rowscnt = $(this).data("rowscnt");
		// let lastoffset = $(this).data("lastoffset");
		let offset = getQueryVariable(nextPage, "offset");
		// offset = offset - (100 - lastoffset);
		getDistributions(sid, offset, rowscnt);
	});
	*/
	// $(document).on("click", ".js-send_distr", function(event) {
		// let id = $(this).data("id");
		// makeDistr(id);
	// });
	// $(document).on("click", ".js-send_wa", function(event) {
		// let id = $(this).data("id");
		// makeTwilio(id);
	// });
	$("#lid").on("change", function(event) {
		let slct = document.getElementById('mid');
		let slct1 = document.getElementById('rmid');
		slct.options.length = 1;
		slct1.options.length = 1;
		// alert(msgs[$(this).val()].length);
		// alert(rmsgs[$(this).val()].length);
		for (let i = 0; i < msgs[$(this).val()].length; i++) {
			var opt = document.createElement("option");
			opt.value = msgs[$(this).val()][i]["id"];
			opt.innerHTML = msgs[$(this).val()][i]["desc"];
			slct.appendChild(opt);
		}
		for (let i = 0; i < rmsgs[$(this).val()].length; i++) {
			var opt = document.createElement("option");
			opt.value = rmsgs[$(this).val()][i]["id"];
			opt.innerHTML = rmsgs[$(this).val()][i]["desc"];
			slct1.appendChild(opt);
		}
		$(slct).removeAttr("disabled");
		$(slct1).removeAttr("disabled");
	});
	$(document).on("click", ".js-addbulk", function(event) {
		let bulk = $("#customers_times").serialize();
		// $("#customers_data").fadeOut(300);
		$.ajax({
			"async": true,
			"url": "xp_ajax.php",
			"method": "POST",
			"timeout": 500000,
			"dataType": "json",
			"data": "method=ADD&action=bulk&bulk=" + encodeURIComponent(bulk),
		}).done(function(response) {
			console.log("Customer data follows:");
			// console.table(bulk);
			getBulks($("#survey_id").val());
			$("#schedule_view").fadeOut(300);
			// $("#customers_data").fadeOut(300);
			$("#customers")[0].reset();
		}).fail(function(jqXHR, textStatus) {
			showAlert("warning", "Error bulk add... " + textStatus);
		});
	});
	$(document).on("click", ".js-details", function(event) {
		let id = $(this).data("id");
		let ml_id = $(this).data("ml");
		$("#customer_view_name").text("...");
		$("#cv_contact_id").val("");
		$("#cv_name").val("");
		$("#cv_lastname").val("");
		$("#cv_Dyad_ID").val("");
		$("#cv_email").val("");
		$("#cv_phone").val("");
		$("#cv_start_date").val("");
		$("#cv_days").val("");
		$("#cv_start_time_all").val("");
		$("#cv_start_time_su").val("");
		$("#cv_start_time_mo").val("");
		$("#cv_start_time_tu").val("");
		$("#cv_start_time_we").val("");
		$("#cv_start_time_th").val("");
		$("#cv_start_time_fr").val("");
		$("#cv_start_time_sa").val("");
		$("#customers_view").fadeIn(300);
		let cv_slct = document.getElementById('cv_mid');
		let cv_slct1 = document.getElementById('cv_rmid');
		cv_slct.options.length = 0;
		cv_slct1.options.length = 0;
		$.ajax({
			"async": true,
			"url": "xp_ajax.php",
			"method": "POST",
			"timeout": 150000,
			"dataType": "json",
			"data": "method=GET&action=customer&mid=" + ml_id + "&id=" + id,
		}).done(function(response) {
			console.log("Customer data follows:");
			// console.table(response);
			$("#customer_view_name").text(response.result.id);
			$("#cv_contact_id").val(response.result.embeddedData.contact_id);
			$("#cv_name").val(response.result.firstName);
			$("#cv_lastname").val(response.result.lastName);
			$("#cv_Dyad_ID").val(response.result.embeddedData.Dyad_ID);
			$("#cv_email").val(response.result.email);
			$("#cv_phone").val(response.result.embeddedData.phone);
			$("#cv_start_date").val(response.result.embeddedData.start_date);
			$("#cv_days").val(response.result.embeddedData.days);
			if (response.result.embeddedData.end_time_all != "undefined")
				$("#cv_end_time_all").val(response.result.embeddedData.end_time_all);
			else
				$("#cv_end_time_all").parent().fadeOut(300);
			if (response.result.embeddedData.end_time_su != "undefined")
				$("#cv_end_time_su").val(response.result.embeddedData.end_time_su);
			else
				$("#cv_end_time_su").parent().fadeOut(300);
			if (response.result.embeddedData.end_time_mo != "undefined")
				$("#cv_end_time_mo").val(response.result.embeddedData.end_time_mo);
			else
				$("#cv_end_time_mo").parent().fadeOut(300);
			if (response.result.embeddedData.end_time_tu != "undefined")
				$("#cv_end_time_tu").val(response.result.embeddedData.end_time_tu);
			else
				$("#cv_end_time_tu").parent().fadeOut(300);
			if (response.result.embeddedData.end_time_we != "undefined")
				$("#cv_end_time_we").val(response.result.embeddedData.end_time_we);
			else
				$("#cv_end_time_we").parent().fadeOut(300);
			if (response.result.embeddedData.end_time_th != "undefined")
				$("#cv_end_time_th").val(response.result.embeddedData.end_time_th);
			else
				$("#cv_end_time_th").parent().fadeOut(300);
			if (response.result.embeddedData.end_time_fr != "undefined")
				$("#cv_end_time_fr").val(response.result.embeddedData.end_time_fr);
			else
				$("#cv_end_time_fr").parent().fadeOut(300);
			if (response.result.embeddedData.end_time_sa != "undefined")
				$("#cv_end_time_sa").val(response.result.embeddedData.end_time_sa);
			else
				$("#cv_end_time_sa").parent().fadeOut(300);
			if (response.result.embeddedData.start_time_all != "undefined")
				$("#cv_start_time_all").val(response.result.embeddedData.start_time_all);
			else
				$("#cv_start_time_all").parent().fadeOut(300);
			if (response.result.embeddedData.start_time_su != "undefined")
				$("#cv_start_time_su").val(response.result.embeddedData.start_time_su);
			else
				$("#cv_start_time_su").parent().fadeOut(300);
			if (response.result.embeddedData.start_time_mo != "undefined")
				$("#cv_start_time_mo").val(response.result.embeddedData.start_time_mo);
			else
				$("#cv_start_time_mo").parent().fadeOut(300);
			if (response.result.embeddedData.start_time_tu != "undefined")
				$("#cv_start_time_tu").val(response.result.embeddedData.start_time_tu);
			else
				$("#cv_start_time_tu").parent().fadeOut(300);
			if (response.result.embeddedData.start_time_we != "undefined")
				$("#cv_start_time_we").val(response.result.embeddedData.start_time_we);
			else
				$("#cv_start_time_we").parent().fadeOut(300);
			if (response.result.embeddedData.start_time_th != "undefined")
				$("#cv_start_time_th").val(response.result.embeddedData.start_time_th);
			else
				$("#cv_start_time_th").parent().fadeOut(300);
			if (response.result.embeddedData.start_time_fr != "undefined")
				$("#cv_start_time_fr").val(response.result.embeddedData.start_time_fr);
			else
				$("#cv_start_time_fr").parent().fadeOut(300);
			if (response.result.embeddedData.start_time_sa != "undefined")
				$("#cv_start_time_sa").val(response.result.embeddedData.start_time_sa);
			else
				$("#cv_start_time_sa").parent().fadeOut(300);
			if (typeof response.result.embeddedData.dontsendwa != "undefined" && response.result.embeddedData.dontsendwa == 1)
				$("#cv_dontsendwa").prop("checked", "checked");
			if (typeof response.result.embeddedData.dontsendsms != "undefined" && response.result.embeddedData.dontsendsms == 1)
				$("#cv_dontsendsms").prop("checked", "checked");
			if (typeof response.result.embeddedData.dontsendr != "undefined" && response.result.embeddedData.dontsendr == 1)
				$("#cv_dontsendr").prop("checked", "checked");
			$("#cv_lid").val(response.result.libraryId);
			let cv_slct = document.getElementById('cv_mid');
			let cv_slct1 = document.getElementById('cv_rmid');
			cv_slct.options.length = 0;
			cv_slct1.options.length = 0;
			// alert(msgs[$(this).val()].length);
			// alert(rmsgs[$(this).val()].length);
			for (let i = 0; i < msgs[response.result.libraryId].length; i++) {
				var opt = document.createElement("option");
				opt.value = msgs[response.result.libraryId][i]["id"];
				opt.innerHTML = msgs[response.result.libraryId][i]["desc"];
				cv_slct.appendChild(opt);
			}
			for (let i = 0; i < rmsgs[response.result.libraryId].length; i++) {
				var opt = document.createElement("option");
				opt.value = rmsgs[response.result.libraryId][i]["id"];
				opt.innerHTML = rmsgs[response.result.libraryId][i]["desc"];
				cv_slct1.appendChild(opt);
			}
			$("#cv_mid").val(response.result.embeddedData.mid);
			$("#cv_rmid").val(response.result.embeddedData.rmid);
			$("#cv_wamid").val(response.result.embeddedData.wamid);
			$("#cv_warmid").val(response.result.embeddedData.warmid);
			$("#cv_smsid").val(response.result.embeddedData.smsid);
			$("#cv_smsrid").val(response.result.embeddedData.smsrid);
			// getting messages
			/*
			let lid = response.result.libraryId;
			let mid = response.result.embeddedData.mid;
			let rmid = response.result.embeddedData.rmid;
			console.log("LID: " + lid + " MID: " + mid + " RMID: " + rmid);
			if (typeof mid != "undefined" && typeof rmid != "undefined") {
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 150000,
					"dataType": "json",
					"data": "method=GET&action=libraries/" + lid + "/messages/" + mid,
				}).done(function(response) {
					let msg_text = response.result.messages.he;
					console.log(msg_text);
					$.ajax({
						"async": true,
						"url": "xp_ajax.php",
						"method": "POST",
						"timeout": 150000,
						"dataType": "json",
						"data": "method=GET&action=libraries/" + lid + "/messages/" + rmid,
					}).done(function(response) {
						let rmsg_text = response.result.messages.he;
						console.log(rmsg_text);
						$("#cv_message").html(msg_text);
						$("#cv_reminder_message").html(rmsg_text);
					}).fail(function(jqXHR, textStatus) {
						showAlert("warning", "Error reminder message get... " + textStatus);
					});
				}).fail(function(jqXHR, textStatus) {
					showAlert("warning", "Error message get... " + textStatus);
				});
			}
			*/
		}).fail(function(jqXHR, textStatus) {
			showAlert("warning", "Error customer details view... " + textStatus);
		});
	});
	$(document).on("click", ".js-delfutdistr", function(event) {
		$("body").addClass("nounload");
		$("#get_customers").prop('disabled', true);
		$("#add_new_customer").prop('disabled', true);
		$("#participants_block").fadeOut(300);
		let name = $(this).data("name");
		if (MD5(prompt("Are you sure you want to delete all «" + name + "»'s future distributions?\n\rEnter password:")) == password_md) {
			showAlert("success", "Starting participant future distributions deletion... Please wait");
			let id = $(this).data("id");
			let sid = $(this).data("sid");
			let ml_id = $(this).data("ml");
			// distributions remove
			// removeDistributions(ml_id);
			$.ajax({
				"async": true,
				"url": "xp_ajax.php",
				"method": "POST",
				"timeout": 600000,
				"dataType": "json",
				"data": "method=DELETE&action=futdistr&sid=" + sid + "&ml_id=" + ml_id,
			}).done(function(response) {
				showAlert("success", "Participant future distributions successfully deleted... reloading", 1);
			}).fail(function(jqXHR, textStatus) {
				showAlert("warning", "Error in deletion of participant future distributions...  " + textStatus);
			});
		}
	});
	$(document).on("click", ".js-deldistrs", function(event) {		
		$("body").addClass("nounload");
		$("#get_customers").prop('disabled', true);
		$("#add_new_customer").prop('disabled', true);
		$("#participants_block").fadeOut(300);
		let name = $(this).data("name");
		if (MD5(prompt("Are you sure you want to delete some «" + name + "»'s distributions?\n\rEnter password:")) == password_md) {
			showAlert("success", "Starting participant distributions deletion... Please wait");
			let id = $(this).data("deldistr");
			let sid = $(this).data("sid");
			let ml_id = $(this).data("ml");
			let startdt = $(this).data("");
			let enddt = $(this).data("");
			$.ajax({
				"async": true,
				"url": "xp_ajax.php",
				"method": "POST",
				"timeout": 1200000,
				"dataType": "json",
				"data": "method=DELETE&action=distrs&sid=" + sid + "&ml_id=" + ml_id + "&sendStartDate=" + startdt + "&sendEndDate=" + enddt,
			}).done(function(response) {
				$(".js-deldistrs[data-deldistr=" + id + "]").fadeOut(300);
				showAlert("success", "The participant’s scheduled survey distributions are deleted...");
				$("body").removeClass("nounload");
				showAlert("success", "Some participant's distributions are deleted completely...");
				$("#get_customers").prop('disabled', false);
				$("#add_new_customer").prop('disabled', false);
				$("#participants_block").fadeIn(300);
			}).fail(function(jqXHR, textStatus) {
				showAlert("warning", "Error in deletion of scheduled surveys distributions...  " + textStatus);
			});
		}
		else
			alert("Wrong password! Use your account password, please!");
	});
	$(document).on("click", ".js-delcustomer", function(event) {		
		$("body").addClass("nounload");
		$("#get_customers").prop('disabled', true);
		$("#add_new_customer").prop('disabled', true);
		$("#participants_block").fadeOut(300);
		let name = $(this).data("name");
		if (MD5(prompt("Are you sure you want to delete «" + name + "» and all the participants scheduled surveys?\n\rEnter password:")) == password_md) {
			showAlert("success", "Starting participant deletion... Please wait");
			let id = $(this).data("id");
			let sid = $(this).data("sid");
			let ml_id = $(this).data("ml");
			// distributions remove
			// removeDistributions(ml_id);
			$.ajax({
				"async": true,
				"url": "xp_ajax.php",
				"method": "POST",
				"timeout": 1200000,
				"dataType": "json",
				"data": "method=DELETE&action=distributions&sid=" + sid + "&ml_id=" + ml_id,
			}).done(function(response) {
				showAlert("success", "The participant’s scheduled survey distributions are deleted...");
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 125000,
					"dataType": "json",
					"data": "method=DELETE&action=mailinglists/" + ml_id + "/contacts/" + id,
				}).done(function(response) {
					showAlert("success", "The participant’s contact is deleted...");
					$.ajax({
						"async": true,
						"url": "xp_ajax.php",
						"method": "POST",
						"timeout": 125000,
						"dataType": "json",
						"data": "method=DELETE&action=mailinglists/" + ml_id,
					}).done(function(response) {
						showAlert("success", "The participant’s maillist is deleted...");
						$(".js-delcustomer[data-id=" + id + "]").parent().remove();
						$("#bottom_block").html("");
						$(".all_surveys").prop("selectedIndex", 0);
						$.ajax({
							"async": true,
							"url": "xp_ajax.php",
							"method": "POST",
							"timeout": 125000,
							"dataType": "json",
							"data": "method=DELETE&action=twilio&customer_id=" + id,
						}).done(function(response) {
							$("body").removeClass("nounload");
							showAlert("success", "Participant successfully deleted from Twilio...");
							showAlert("success", "The participant is deleted completely...");
							$("#get_customers").prop('disabled', false);
							$("#add_new_customer").prop('disabled', false);
							$("#participants_block").fadeIn(300);
						}).fail(function(jqXHR, textStatus) {
							showAlert("warning", "Error in Twilio deletion... " + textStatus);
						});
					}).fail(function(jqXHR, textStatus) {
						showAlert("warning", "Error in mail-list deletion in Qualtrics... " + textStatus);
					});
				}).fail(function(jqXHR, textStatus) {
					showAlert("warning", "Error in contact deletion in Qualtrics...  " + textStatus);
				});
			}).fail(function(jqXHR, textStatus) {
				showAlert("warning", "Error in deletion of scheduled surveys distributions...  " + textStatus);
			});
		}
		else
			alert("Wrong password! Use your account password, please!");
	});
	$("#switch_table").on("click", function() {
		$("#bottom_block").fadeToggle(300);
	})
	$("#switch_participants").on("click", function() {
		if ($("#participants_block").is(":visible"))
			$("#customers_view").fadeOut(300);
		$("#participants_block").fadeToggle(300);
	})
	$("#clear_it").on("click", function() {
		clearDistrs();
	});
	$("#get_roles").on("click", function() {
		if ($("#surveyId").val() != "") {
			$("#customers_data").fadeOut(300).promise().done(function() {
				$("#current_data").fadeIn(300);
			});
		}
	})
	$("#get_customers").on("click", function() {
		if ($("#surveyId").val() != "") {
			let send_option = $("[name=send_option]:checked").val();
			if (send_option == 3)
				$('#endtimediv').removeClass("hidden").find("input").attr('required', 'required');
			else
				$('#endtimediv').addClass("hidden").find("input").removeAttr('required');
			$("#current_data").fadeOut(300).promise().done(function() {
				$("#customers_data").fadeIn(300);
			});
		}
	})
	$("#all_surveys").on("change", function(event) {
		let id = $(this).val();
		let name = $(this).find(":selected").text();
		$("#surveyId").val(id);
		$("#survey_id").val(id);
		$("#survey_name").val(name);
		$("#current_data").fadeOut(300);
		$("#customers_data").fadeOut(300);
		$("#participants_block").fadeOut(300);
		$(".js-customer[data-survey]").addClass("hidden");
		$(".js-customer[data-survey=" + id + "]").removeClass("hidden");
		if (id != "") {
			// alert(id + "|" + name);
			getRoles(id, name);
			getBulks(id);
		}
		// console.log("allcustomers vvv");
		// console.table(allcustomers[id]);
		// console.log("allcustomers ^^^");
	})
});
function clearDistrs() {
	let sid = $("#survey_id").val();
	let ts = $("#time_start").val();
	let te = $("#time_end").val();
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 150000,
		"dataType": "json",
		"data": "action=wrong&method=DELETE&sid=" + sid + "&sendStartDate=" + ts + "&sendEndDate=" + te,
	}).done(function(response) {
		showAlert("success", "Wrong distributions deleted!");
	}).fail(function(jqXHR, textStatus) {
		showAlert("warning", "Error deleting wrong distributions! " + textStatus);
	});
}
function chkFields1() {
	let flag = true;
	let send_option = $("[name=send_option]:checked").val();
	let mintime = $("#min_time_between").val();
	let maxtime = $("#max_time_between").val();
	let pause = $("#pause").val();
	if (send_option == 1 && isNaN(pause)) {
		showAlert("warning", "Error: Pause must be numeric!");
		return false;
	}
	if (send_option > 1 && isNaN(mintime)) {
		showAlert("warning", "Error: Min time between distributions must be numeric!");
		return false;
	}
	if (send_option > 1 && isNaN(maxtime)) {
		showAlert("warning", "Error: Max time between distributions must be numeric!");
		return false;
	}
	if (send_option > 1 && parseInt(maxtime) <= parseInt(mintime)) {
		showAlert("warning", "Error: Max time between distributions cannot be less or equal to Min time between distributions!");
		return false;
	}
	$("#roles").find('input:required').each(function () {
		$(this).removeClass('is-invalid');
		$(this).parent().find(".invalid-feedback").text("");
		if ($(this).val() == '') {
			$(this).addClass('is-invalid');
			$(this).parent().find(".invalid-feedback").text("Cannot be empty");
			flag = false;
		}
	});
	return flag;
}
function chkFields2() {
	let flag = true;
	if ($("#survey_id").val() == "") {
		showAlert("warning", "You have to choose SURVEY first!");
		return false;
	}
	let start_date = $("#start_date").val();
	let today = new Date();
	// alert(today.getDay());
	var wds = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thurstday", "Friday", "Saturday"];
	var compstarttime = [];
	var compendtime = [];
	var compstarttime_all = $("#start_time_all").val();
	compstarttime[0] = $("#start_time_su").val();
	compstarttime[1] = $("#start_time_mo").val();
	compstarttime[2] = $("#start_time_tu").val();
	compstarttime[3] = $("#start_time_we").val();
	compstarttime[4] = $("#start_time_th").val();
	compstarttime[5] = $("#start_time_fr").val();
	compstarttime[6] = $("#start_time_sa").val();
	var compendtime_all = $("#end_time_all").val();
	compendtime[0] = $("#end_time_su").val();
	compendtime[1] = $("#end_time_mo").val();
	compendtime[2] = $("#end_time_tu").val();
	compendtime[3] = $("#end_time_we").val();
	compendtime[4] = $("#end_time_th").val();
	compendtime[5] = $("#end_time_fr").val();
	compendtime[6] = $("#end_time_sa").val();

	// check separate for every week day:
	var startingday = today.getDay();
	var daysofweek = 7;
	let days_total = $("#days").val();
	if (parseInt(days_total) < daysofweek)
		daysofweek = parseInt(days_total);
	// console.log(daysofweek);
	// console.log(startingday + daysofweek);
	for (var i = startingday;i < (startingday + daysofweek);i++) {
		let wd = i;
		// alert("WD: " + wd);
		if (wd > 6)
			wd = wd - 7;
		let send_option = $("[name=send_option]:checked").val();
		let max_pause = $("#max_time_between").val();
		let min_pause = $("#min_time_between").val();
		let times = $("#times").val();
		let a = compstarttime[wd].split(':');
		let b = compendtime[wd].split(':');
		let start_time_minutes = (+a[0]) * 60 + (+a[1]);
		let end_time_minutes = (+b[0]) * 60 + (+b[1]);
		let send_date = "";
		let end_date = "";
		console.log("Start time: " + wd + "|" + compstarttime[wd]);
		console.log("End time: " + wd + "|" + compendtime[wd]);
		console.log("Start time all: " + compstarttime_all);
		console.log("End time all: " + compendtime_all);
		if (compstarttime[wd])
			send_date = $("#start_date").val() + ' ' + compstarttime[wd];
		else
			send_date = $("#start_date").val() + ' ' + compstarttime_all;
		
		if (compendtime[wd])
			end_date = $("#start_date").val() + ' ' + compendtime[wd];
		else
			end_date = $("#start_date").val() + ' ' + compendtime_all;
		let diff = end_time_minutes - start_time_minutes;
		// alert(send_date + ": " + wd + " -  " + max_pause*times + " <> " + diff);
		// if (send_option > 1 && min_pause*times > diff) {
			// showAlert("warning", "Error: You can exceed end sending time with " +  times + " times a day inside " + diff + " minutes with min_pause " + min_pause + " for: " + wds[wd] + " (Start time is: " + compstarttime[wd] + ", end time is " + compendtime[wd] + ")!");
			// return false;
		// }
		if (send_option > 1 && diff <= 0) {
			showAlert("warning", "Error: End time must be later than start time: " + send_date + "!");
			return false;
		}
		// alert(today > new Date(send_date));
		// if (today > new Date(send_date)) {
			// showAlert("warning", "Error: the ‘send date and time’ must be set for a future time point: " + send_date + "!");
			// return false;
		// }
	}
	$("#customers").find('input:required').each(function () {
		$(this).removeClass('is-invalid');
		$(this).parent().find(".invalid-feedback").text("");
		if ($(this).val() == '') {
			$(this).addClass('is-invalid');
			$(this).parent().find(".invalid-feedback").text("Cannot be empty");
			flag = false;
		}
	});
	return flag;
	// return false;
}
function chkFields3() {
	let flag = true;

	return flag;
}
function getPhysioqMaxTime() {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=maxphysioqtimes&method=GET",
	}).done(function(response) {
		// console.log(response);
		if (response != null) {
			let els = response;
			for (let i = 0; i < els.length; i++) {
				physmaxdates[els[i].participantID] = els[i].maxdt;
			}
			// console.log(physmaxdates);
		}
	}).fail(function(jqXHR, textStatus) {
		showAlert("warning", "Error in physioq times request... " + textStatus);
	});
}
function getPhonic(sid, phid, phqid) {
	// console.log(phid);
	// console.log(phqid);
	let time_start = $("#time_start").val();
	let time_end = $("#time_end").val();
	if (time_start == '' || typeof time_start == "undefined") {
		time_end = new Date().toISOString().slice(0,10);
		let twoWeeksAgo = new Date();
		twoWeeksAgo.setDate(twoWeeksAgo.getDate() - 14);
		time_start = twoWeeksAgo.toISOString().slice(0,10);
	}
	if (phid != "" && phqid != "")
		{
		$.ajax({
			"async": true,
			"url": "xp_ajax.php",
			"method": "POST",
			"timeout": 125000,
			"dataType": "json",
			"data": "action=phonic&method=GET&phid=" + phid + "&phqid=" + phqid + "&startdate=" + time_start + "&enddate=" + time_end,
		}).done(function(response) {
			// console.log(response.sessions.length);
			if (response) {
				let sessions = response.sessions;
				let responses = response.responses;
				if (sessions)
				for (let i = 0; i < sessions.length; i++) {
					// console.log(sessions[i]);
					let phdata = sessions[i].sessionId.split("|");
					let id = sessions[i]._id;
					let kkk = 0;
					for (let j = 0; j < phdata.length; j++) {
						if (phdata[j].substr(0, 3) == "EMD")
							kkk = phdata[j];
					}
					// console.log(phdata);
					if (kkk != 0) {
						phonics[kkk] = sessions[i].features.completionStatus;
						let lastphonic = "";
						if (responses && responses[i] && responses[i].features && responses[i].features.transcription_items)
						for (let k = 0; k < responses[i].features.transcription_items.length; k++) {
							if (responses[i].features.transcription_items[k].end_time)
								lastphonic = responses[i].features.transcription_items[k].end_time;
						}
						if (lastphonic != "") {
							lastphonics[kkk] = lastphonic;
						}
					}
				}
				console.log(phonics);
				console.log(lastphonics);
				getDistributions(sid);
			}
			else
				getDistributions(sid);
		}).fail(function(jqXHR, textStatus) {
			showAlert("warning", "Error in phonics data get... " + textStatus);
		});
	}
	else
		getDistributions(sid);
}
function getPhysioq(sid, physid) {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=physioq&method=GET&physid=" + physid,
	}).done(function(response) {
		// console.log(response);
		if (response && response.result) {
			let els = response.result.elements;
			for (let i = 0; i < els.length; i++) {
				let hint = "Count: " + els[i].amount + ", Proportion: " + els[i].proportion + ", M: " + els[i].m + ", SD: " + els[i].sd + ", Min: " + els[i].min_val + ", Max: " + els[i].max_val;
				physioqs[els[i].dt.replaceAll("-", "_") + "_" + els[i].participantID] = hint;
			}
			// console.log(physioqs);
		}
	}).fail(function(jqXHR, textStatus) {
		showAlert("warning", "Error in physioqs get... " + textStatus);
	});
}
function getRoles(id, name) {
	$("#surveyId").val("");
	$("#times").val("");
	$("[name=send_option]").removeAttr('checked');
	$("#send_option1").attr('checked', 'checked');
	$('.for_option_2').addClass('hidden');
	$('.for_option_1').removeClass('hidden');
	$('.for_option_2').find('input').removeAttr('required');
	$('.for_option_1').find('input').attr('required', 'required');
	$("#pause").val("");
	$("#max_time_between").val("");
	$("#min_time_between").val("");
	$("#snooze").val("");
	$("#expire").val("");
	$("#email_subj").val("");
	$("#from_name").val("");
	$("#random_interval").val("");
	$("#reply_to").val("");
	$("#phonicID").val("");
	$("#phonic_questionID").val("");
	$("#physioqID").val("");
	$("#surveyName").text("");
	// $("#roles").fadeOut(300);
	$("#roles").fadeIn(300);
	$("#surveyName").text(name);
	$("#surveyId").val(id);
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=roles&method=GET&sid=" + id,
	}).done(function(response) {
		if (response)
		$.each(response.result.elements, function(index, value) {
			console.log(index);
			console.table(value);
			if (index == id) {
				if (!value.send_option)
					value.send_option = 1;
				$("#times").val(value.times);
				$("[name=send_option]").removeAttr('checked');
				$("#send_option" + value.send_option).attr('checked', 'checked');
				if (value.send_option == 2 || value.send_option == 3) {
					$('.for_option_1').addClass('hidden');
					$('.for_option_2').removeClass('hidden');
					$('.for_option_1').find('input').removeAttr('required');
					$('.for_option_2').find('input').attr('required', 'required');
				}
				else {
					$('.for_option_2').addClass('hidden');
					$('.for_option_1').removeClass('hidden');
					$('.for_option_2').find('input').removeAttr('required');
					$('.for_option_1').find('input').attr('required', 'required');
				}
				$("#pause").val(value.pause);
				$("#max_time_between").val(value.max_time_between);
				$("#min_time_between").val(value.min_time_between);
				$("#snooze").val(value.snooze);
				$("#expire").val(value.expire);
				$("#email_subj").val(decodeURIComponent(value.email_subj));
				$("#from_name").val(decodeURIComponent(value.from_name));
				$("#random_interval").val(decodeURIComponent(value.random_interval));
				$("#reply_to").val(decodeURIComponent(value.reply_to));
				$("#phonicID").val(value.phonicID);
				$("#phonic_questionID").val(value.phonic_questionID);
				$("#physioqID").val(value.physioqID);
				let phid = value.phonicID;
				let phqid = value.phonic_questionID;
				let physid = value.physioqID;
				// get distributions inside getPhonic!
				getPhonic(id, phid, phqid);
				if (physid != "") {
					getPhysioq(id, physid);
					getPhysioqMaxTime();
				}
			}
		});
		else
			alert("No roles set for this survey!");
		// $("#current_data").append("<div class=\"send_distr\"><button class=\"btn btn-secondary js-send_distr\" data-id=\"" + id + "\">Send distributions</button></div>");
		// $("#current_data").append("<div class=\"send_wa\"><button class=\"btn btn-secondary js-send_wa\" data-id=\"" + id + "\">Send WhatsApp</button></div>");
	}).fail(function(jqXHR, textStatus) {
		showAlert("warning", "Error in roles get... " + textStatus);
	});
}
function getSurveys() {
	let owID = "";
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 100000,
		"dataType": "json",
		"data": "action=whoami&method=GET",
	}).done(function(response) {
		if (response.meta.httpStatus == "200 - OK") {
			owID = response.result.userId;
		}
		$.ajax({
			"async": true,
			"url": "xp_ajax.php",
			"method": "POST",
			"timeout": 125000,
			"dataType": "json",
			"data": "action=surveys&method=GET",
		}).done(function(response) {
			// console.table(response.result.elements);
			let els = response.result.elements;
			els.sort((a,b) => (a.name > b.name) ? 1 : ((b.name > a.name) ? -1 : 0))
			if (response.meta.httpStatus == "200 - OK") {
				let slct = document.getElementById('all_surveys');
				slct.options.length = 1;
				for (let i = 0; i < els.length; i++) {
					if (els[i].ownerId == owID) {
						var opt = document.createElement("option");
						opt.value = els[i].id;
						opt.innerHTML = els[i].name;
						if (!els[i].isActive)
							opt.disabled = "disabled";
						slct.appendChild(opt);
					}
				}
				$(".after_select").addClass("loaded").addClass("fromsurveys");
				$(slct).removeAttr("disabled");
			}
			else
				$("#survey_data").html(response.meta.httpStatus);
		}).fail(function(jqXHR, textStatus) {
			// console.log(textStatus);
			$("#survey_data").html(textStatus);
		});
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		$("#survey_data").html(textStatus);
	});
}
function getDistributions(surveyId, offset = 0, rowscnt = 0, time_start = '', time_end = '', participant_start = '', participant_end = '', filter_by_participant = false) {
	let ts = $("#time_start").val();
	let te = $("#time_end").val();
	if (time_start == '' && typeof ts != "undefined")
		time_start = ts;
	if (time_end == '' && typeof te != "undefined")
		time_end = te;
	if (time_start == '') {
		time_end = new Date().toISOString().slice(0,10);
		let twoWeeksAgo = new Date();
		twoWeeksAgo.setDate(twoWeeksAgo.getDate() - 14);
		time_start = twoWeeksAgo.toISOString().slice(0,10);
	}
	let ps = $("#participant_start").val();
	let pe = $("#participant_end").val();
	let p_filter = $("#filter_by_participant").prop("checked");
	if (participant_start == '' && typeof ps != "undefined")
		participant_start = ps;
	if (participant_end == '' && typeof pe != "undefined")
		participant_end = pe;
	if (participant_start == '') {
		participant_start = $("#participant_min").val();
		participant_end = $("#participant_max").val();
	}
	$(".js-nextpage").parent().remove();
	if (offset == 0)
		$("#bottom_block").html("<h4>Survey completion table</h4>");
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 1200000,
		"dataType": "json",
		"data": "method=GET&action=distributions&surveyId=" + surveyId + "&sendStartDate=" + time_start + "&sendEndDate=" + time_end + "&sendStartParticipant=" + participant_start + "&sendEndParticipant=" + participant_end + "&distributionRequestType=Invite",
	}).done(function(response) {
		// console.table(response);
		if (response.meta.httpStatus == "200 - OK" && typeof response.result != "undefined") {
			let alldistrs = response.result.elements;
			// alert(alldistrs.length);
			// $("#bottom_block").append("ROW DATA<br /><code>" + JSON.stringify(response) + "</code>");
			let cnt = 0;
			let totalcnt = 0;
			// if (rowscnt != 0)
				// cnt = rowscnt;
			let prev_date = "";
			let dates = [];
			let dates_by_mid = [];
			for (let i = 0; i < alldistrs.length; i++) {
				let dateonly_local = new Date(alldistrs[i].sendDate);
				let dateonly = dateonly_local.getFullYear() + "-" + ("0" + (dateonly_local.getMonth() + 1)).slice(-2) + "-" + ("0" + dateonly_local.getDate()).slice(-2);
				// let dateonly = alldistrs[i].sendDate.substring(0, 10);
				let mid = alldistrs[i].recipients.mailingListId;
				if (alldistrs[i].recipients.mailingListId != null) {
					if (typeof dates_by_mid[dateonly] == "undefined")
						dates_by_mid[dateonly] = [];
					if (typeof dates_by_mid[dateonly][mid] == "undefined")
						dates_by_mid[dateonly][mid] = [];
					dates_by_mid[dateonly][mid][dates_by_mid[dateonly][mid].length] = alldistrs[i];
				}
				// console.log(dateonly + "|" + mid);
			}
			let custnum = 0;
			let lengths = [];
			for (let did in dates_by_mid) {
				for (let mid in dates_by_mid[did]) {
					for (let cid in dates_by_mid[did][mid]) {
						if (typeof dates[did] == "undefined")
							dates[did] = [];
						if (typeof dates[did][cid] == "undefined")
							dates[did][cid] = [];
						dates[did][cid][mid] = dates_by_mid[did][mid][cid];
						// $("#bottom_block").append("<br />" + mid + " (" + dates[did][cid][mid].sendDate.substring(0, 10) + ") DATE ROW DATA<br /><code>" + JSON.stringify(dates_by_mid[did][mid][cid]) + "</code>");
					}
				}
			}
			// for a case we need sorting - need to change following to appropriate logic, not working now
			// dates.sort(function(a, b) {
				// var keyA = new Date(a.sendDate),
					// keyB = new Date(b.sendDate);
				// if(keyA < keyB) return 1;
				// if(keyA > keyB) return -1;
				// return 0;
			// });
			let html = "";
			// if we need only existing customers
			// let localcustomers = [];
			// for (let i = 0; i < alldistrs.length; i++) {
				// if (alldistrs[i].recipients.mailingListId != null && typeof allcustomers[surveyId] != "undefined") {
					// localcustomers[alldistrs[i].recipients.mailingListId] = allcustomers[surveyId][alldistrs[i].recipients.mailingListId];
				// }
			// }
			// sorting...
			var sortable = [];
			var mykeys = [];

			for (var key in allcustomers[surveyId])
				mykeys.push([key, allcustomers[surveyId][key]]);

			mykeys.sort(function(a, b) {
				a = a[1]["created"];
				b = b[1]["created"];

				return a < b ? -1 : (a > b ? 1 : 0);
			});
			// console.table(mykeys);
			for (var i = 0; i < mykeys.length; i++) {
				var key = mykeys[i][0];
				var value = mykeys[i][1];

				sortable[key] = value;
			}
			// console.table(allcustomers[surveyId]);
			// console.table(sortable);
			if (offset == 0) {
				rowscount = [];
				rowscount_compl = [];
				// table header
				html = html + "<input class=\"is_date_right\" type=\"text\" name=\"time_start\" id=\"time_start\" value=\"" + time_start + "\">&nbsp;";
				html = html + "<input class=\"is_date_right\" type=\"text\" name=\"time_end\" id=\"time_end\" value=\"" + time_end + "\">&nbsp;";
				html = html + "<input size=\"6\" name=\"filter_by_participant\" id=\"filter_by_participant\" type=\"checkbox\"  value=\"1\">&nbsp;";
				html = html + "<input size=\"6\" type=\"text\" name=\"participant_start\" id=\"participant_start\" value=\"" + participant_start + "\">&nbsp;";
				html = html + "<input size=\"6\" type=\"text\" name=\"participant_end\" id=\"participant_end\" value=\"" + participant_end + "\">&nbsp;";
				html = html + "<button data-sid=\"" + surveyId + "\" class=\"btn btn-primary js-rebuild\">Update</button><br /><br />";
				html = html + "<button class=\"ph_button\" onClick=\"$('#headerTable').toggleClass('table_ph');\">Show advanced info</button>";
				html = html + "<table id=\"headerTable\" class=\"table table-bordered table-striped\"><thead>";
				html = html + "<tr>";
				html = html + "<th>Date/try/done</th>";
				// for (let mid in localcustomers) { // for local customers only
				for (let mid in sortable) {
					custnum++;
					let physmaxdates_txt = "";
					// console.log(physmaxdates);
					// console.log(allcustomers[surveyId][mid]["c_id"]);
					if (physmaxdates[allcustomers[surveyId][mid]["c_id"]])
						physmaxdates_txt = "Last physioqs date: " + physmaxdates[allcustomers[surveyId][mid]["c_id"]];
					if (!p_filter || (parseInt(allcustomers[surveyId][mid]["c_id"]) >= participant_start && parseInt(allcustomers[surveyId][mid]["c_id"]) <= participant_end))
						html = html + "<th class=\"tabletd tabletd_" + mid +"\" scope=\"col\" title=\"" + mid + " (" + allcustomers[surveyId][mid]["created"] + ")\"><small>" + allcustomers[surveyId][mid]["name"] + "</small><div class=\"compl_perc\" id=\"compl_perc_" + mid + "\"></div><div class=\"adv_ph\">" + physmaxdates_txt + "</div></th>";
				}
				// if we need all the customers, uncomment following:
				// for (let mid in allcustomers[surveyId]) {
					// html = html + "<th scope=\"col\" title=\"" + mid + "\"><small>" + allcustomers[surveyId][mid] + "</small></th>";
				// }
				html = html + "</tr></thead><tbody id=\"table_body\">";
			}
			let exists = 0;
			prev_date = "";
			// let mindate = te;
			let lastdate = "";
			// cycle dates
			// for (let did in dates) {
				// if (did < mindate)
					// mindate = did;
			// }
			// if (mindate == ts)
				// mindate = "";
			for (let did in dates) {
				// check if it is the last date in a set
				if (did != lastdate)
					{
					cnt = 0;
				}
				// if (rowscnt != 0) {
					// cnt = rowscnt;
					// rowscnt = 0;
				// }
				for (let cid in dates[did]) {
					// alert(did + "|" + dates[did].length);
					html = html + "<tr>";
					html = html + "<th scope=\"row\">" + did + String.fromCharCode(97 + cnt++) + "</th>";
					let ccnt = 0;
					for (let mid in sortable) {
						if (!p_filter || (parseInt(allcustomers[surveyId][mid]["c_id"]) >= participant_start && parseInt(allcustomers[surveyId][mid]["c_id"]) <= participant_end)) {
							// console.log(parseInt(allcustomers[surveyId][mid]["c_id"]));
							// console.log(participant_start);
							// console.log(participant_end);
							ccnt++;
							if (typeof (dates[did][cid][mid]) != "undefined" && dates[did][cid][mid].recipients.mailingListId == mid) {
								totalcnt++;
								let yellow = "";
								let green = "";
								let red = "";
								let orange = "";
								let ccolor = "";
								let redborder = "";
								let phonic_border = "";
								let completed_date = "";
								for (let comid in completed) {
									// alert(dates[did][cid][mid].id + "|" + completed[comid].DistributionID);
									if (dates[did][cid][mid].id == completed[comid].DistributionID) {
										// completed_date = completed[comid].CompletedDate;
										let completed_date_local = new Date(completed[comid].CompletedDate.replace(" ", "T") + "Z");
										completed_date = completed_date_local.getFullYear() + "-" + ("0" + (completed_date_local.getMonth() + 1)).slice(-2) + "-" + ("0" + completed_date_local.getDate()).slice(-2) + " " + ("0" + completed_date_local.getHours()).slice(-2) + ":" + ("0" + completed_date_local.getMinutes()).slice(-2) + ":" + ("0" + completed_date_local.getSeconds()).slice(-2);
									}
								}
								let twilio_sent = 0;
								let twilio_sms_sent = 0;
								let twilio_state = 0;
								let twilio_sms_state = 0;
								// console.table(twilios);
								for (let tid in twilios) {
									// console.log(dates[did][cid][mid].id);
									// console.log(tid);
									// console.log(twilios[tid].state);
									if (tid == dates[did][cid][mid].id && (twilios[tid].state == 1 || twilios[tid].state == 'sent' || twilios[tid].state == 'delivered' || twilios[tid].state == 'read' || twilios[tid].state == 'completed')) {
										twilio_sent = 1;
									}
									twilio_state = twilios[tid].state;
								}
								// console.table(twilios_sms);
								for (let tid in twilios_sms) {
									// console.log(dates[did][cid][mid].id);
									// console.log(tid);
									// console.log(twilios_sms[tid].state);
									if (tid == dates[did][cid][mid].id && (twilios_sms[tid].state == 1 || twilios_sms[tid].state == 'sent' || twilios_sms[tid].state == 'delivered' || twilios_sms[tid].state == 'read' || twilios_sms[tid].state == 'completed')) {
										twilio_sms_sent = 1;
									}
									twilio_sms_state = twilios_sms[tid].state;
								}
								// alert(mid + ": " + twilio_sent + "|" + dates[did][cid][mid].stats.sent);
								if (twilio_sent == 1 && dates[did][cid][mid].stats.sent > 0) {
									yellow = "yellow ";
									ccolor = "00FFFF99";
								}
								if (twilio_sms_sent == 1 && dates[did][cid][mid].stats.sent > 0) {
									yellow = "yellow ";
									ccolor = "00FFFF99";
								}
								// if sent, started, opened and finished
								if ((dates[did][cid][mid].stats.sent == 1 && dates[did][cid][mid].stats.started == 1 && dates[did][cid][mid].stats.opened == 1 && dates[did][cid][mid].stats.finished == 1) || completed_date != '') {
									green = "green ";
									ccolor = "0099FF99";
									if (typeof rowscount_compl[mid] == "undefined")
										rowscount_compl[mid] = 0;
									rowscount_compl[mid]++;
								}
								// set completed rowscount_compl
								// if (dates[did][cid][mid].stats.sent == 1 && dates[did][cid][mid].stats.started == 1 && dates[did][cid][mid].stats.opened == 1 && dates[did][cid][mid].stats.finished == 1) {
								// }
								// all the dates goes local now!
								let date = new Date();
								let now = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2) + " " + ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2) + ":" + ("0" + date.getSeconds()).slice(-2);
								let exp_date_local = new Date(dates[did][cid][mid].surveyLink.expirationDate);
								let exp_date = exp_date_local.getFullYear() + "-" + ("0" + (exp_date_local.getMonth() + 1)).slice(-2) + "-" + ("0" + exp_date_local.getDate()).slice(-2) + " " + ("0" + exp_date_local.getHours()).slice(-2) + ":" + ("0" + exp_date_local.getMinutes()).slice(-2) + ":" + ("0" + exp_date_local.getSeconds()).slice(-2);
								let send_date_local = new Date(dates[did][cid][mid].sendDate);
								let send_date = send_date_local.getFullYear() + "-" + ("0" + (send_date_local.getMonth() + 1)).slice(-2) + "-" + ("0" + send_date_local.getDate()).slice(-2) + " " + ("0" + send_date_local.getHours()).slice(-2) + ":" + ("0" + send_date_local.getMinutes()).slice(-2) + ":" + ("0" + send_date_local.getSeconds()).slice(-2);
								// if link expiration time passed and finished
								if (dates[did][cid][mid].stats.finished != 1 && completed_date != "") {
									redborder = "redborder ";
								}
								if (exp_date < now && dates[did][cid][mid].stats.finished != 1 && completed_date == "") {
									red = "red ";
									ccolor = "00FF9999";
								}
								let dontsendwa = 0;
								let dontsendsms = 0;
								let dontsendr = 0;
								if (typeof(dontsendsmss[mid]) != "undefined")
									dontsendsms = dontsendsmss[mid];
								if (typeof(dontsendwas[mid]) != "undefined")
									dontsendwa = dontsendwas[mid];
								if (typeof(dontsendrs[mid]) != "undefined")
									dontsendr = dontsendrs[mid];
								let orange_txt = "";
								let phonic_txt = "";
								let lastphonic_txt = "";
								// if send time passed and twilio still not sent
								if (dontsendsms != 1 && send_date < now && twilio_sms_sent != 1) {
									orange = "orange1 ";
									ccolor = "00FFCC99";
									orange_txt = "Err: SMS ";
								}
								// if send time passed and twilio still not sent
								if (dontsendwa != 1 && send_date < now && twilio_sent != 1) {
									orange = "orange1 ";
									ccolor = "00FFCC99";
									orange_txt = "Err: WhatsApp ";
								}
								// if send time passed and mail still not sent
								if (send_date < now && dates[did][cid][mid].stats.sent != 1) {
									orange = "orange2 ";
									ccolor = "00FFCC99";
									orange_txt = "Err: Qualtrics ";
								}
								// if finished but expiration time passed
								if (completed_date != "" && completed_date > exp_date && dates[did][cid][mid].stats.finished == 1) {
									orange = "orange3 ";
									ccolor = "00FFCC99";
									orange_txt = "Err: expired ";
								}
								// if we have any phonic data
								// console.log(phonics);
								// console.log(dates[did][cid][mid].id);
								// console.log(phonics[dates[did][cid][mid].id]);
								let curphys = "";
								if (cnt == 1) {
									if (typeof physioqs[did.replaceAll("-", "_") + "_" + allcustomers[surveyId][mid]["c_id"]] != "undefined")
										curphys = physioqs[did.replaceAll("-", "_") + "_" + allcustomers[surveyId][mid]["c_id"]] + "<br /><a href=\"xp_aws_csv.php?sid=" + surveyId + "&pnum=" + allcustomers[surveyId][mid]["c_id"] + "&dt=" + send_date.substr(0, 10) + "\">Download csv for " + did + "</a>";
									else
										curphys = "No physioq data available";
								}
								if (phonics[dates[did][cid][mid].id]) {
									phonic_border = "phonic_border ";
									phonic_txt = "Phonic " + phonics[dates[did][cid][mid].id];
									lastphonic_txt = "Last phonic time " + lastphonics[dates[did][cid][mid].id];
									// console.log(phonic_txt);
								}
								if (typeof rowscount[mid] == "undefined")
									rowscount[mid] = 0;
								rowscount[mid]++;
								var phclass = "";
								if (physioqs[did.replaceAll("-", "_") + "_" + allcustomers[surveyId][mid]["c_id"]])
									phclass = " visible";
								html = html + "<td class=\"tabletd tabletd_" + mid + " " + phonic_border + yellow + green + red + orange + redborder + "\" data-fill-color=\"" + ccolor + "\" title=\"" + orange_txt + dates[did][cid][mid].headers.subject + " [" + dates[did][cid][mid].id + " for ML " + mid + "] send: " + send_date + " | compl: " + completed_date + " | now: " + now + " | exp: " + exp_date + " (sent/started/opened/finished)  |" + totalcnt + "| twilio_state = " + twilio_state + ", twilio_sms_state = " + twilio_sms_state + " " + phonic_txt + "\">" + local_time_only(dates[did][cid][mid].sendDate).substring(0, 5) + " (" + dates[did][cid][mid].stats.sent + "/" + dates[did][cid][mid].stats.started + "/" + dates[did][cid][mid].stats.opened + "/" + dates[did][cid][mid].stats.finished + ") " + lastphonic_txt + "<span class=\"adv_ph\">" + curphys + "</span></td>";
							}
							else {
								html = html + "<td class=\"tabletd tabletd_" + mid + "\"></td>";
							}
						}
					}
					html = html + "</tr>";
				}
				// }
				lastdate = did;
			}
			// if (lastoffset == 0)
				// lastoffset = 100;
			// if (nextPage != "") {
				// let but = "<div class\"form-group form-row\"><button class=\"js-nextpage\" data-rowscnt=\"" + cnt + "\" data-sid=\"" + surveyId + "\" data-next=\"" + nextPage + "\">Load more</button></div><br /><br />";
				// $("#button_block").html(but);
			// }
			// else {
				// $("#button_block").html("");
				// lastoffset = 0;
			// }
			// if (offset != 0) {
				// $("#table_body").append(html);
			// }
			// else {
				html = html + "</tbody></table>";
				html = html + "<button data-sid=\"" + surveyId + "\" class=\"js-tnext hidden\">Next page</button>&nbsp;&nbsp;&nbsp;<button data-sid=\"" + surveyId + "\" class=\"js-tprev hidden\">Previous page</button>";
				$("#bottom_block").append(html);
				$(".is_date_right").datepicker({
					dateFormat: 'yyyy-mm-dd',
					autoClose: true,
					language: 'en',
					position: "right top",
				});
			// }
			for (let mid in allcustomers[surveyId]) {
				// alert(mid + ": " + rowscount_compl[mid] + ":" + rowscount[mid]);
				if (typeof rowscount_compl[mid] == "undefined")
					rowscount_compl[mid] = 0;
				// alert(rowscount[mid]);
				if (typeof rowscount[mid] != "undefined") {
					let perc = parseInt(rowscount_compl[mid]/rowscount[mid]*10000)/100;
					$("#compl_perc_" + mid).text(perc + "% (" + rowscount_compl[mid] + " of " + rowscount[mid] + ")");
					$(".tabletd_" + mid).show().removeAttr("data-exclude");
				}
				else {
					$(".tabletd_" + mid).hide().attr("data-exclude", "true");
				}
			}
			let curcols = $("th.tabletd:visible").length;
			// alert(curcols);
			if (curcols > 10) {
				$(".js-tnext").fadeIn(300);
				$("#headerTable tr").each(function(index, tr) {
					let $tds = $(tr).find(".tabletd:visible");
					let $sliced = $tds.slice(0, 10);
					$(tr).find(".tabletd").fadeOut(300).promise().done(function() {
						$sliced.fadeIn(300);
					});
				});
			}
			$("#switch_table").parent().fadeIn(300);
			let but = "<div class\"form-group form-row\"><button class=\"js-export\" data-sid=\"" + surveyId + "\">Export table</button></div><br /><br />";
			$("#button_block").html(but);
		}
		else {
			let html = "Table is empty. Try other dates:<br /><br />";
			html = html + "<input class=\"is_date_right\" type=\"text\" name=\"time_start\" id=\"time_start\" value=\"" + time_start + "\">&nbsp;";
			html = html + "<input class=\"is_date_right\" type=\"text\" name=\"time_end\" id=\"time_end\" value=\"" + time_end + "\">&nbsp;";
			html = html + "<input size=\"6\" name=\"filter_by_participant\" id=\"filter_by_participant\" type=\"checkbox\"  value=\"1\" checked>&nbsp;";
			html = html + "<input size=\"6\" type=\"text\" name=\"participant_start\" id=\"participant_start\" value=\"" + participant_start + "\">&nbsp;";
			html = html + "<input size=\"6\" type=\"text\" name=\"participant_end\" id=\"participant_end\" value=\"" + participant_end + "\">&nbsp;";
			html = html + "<button data-sid=\"" + surveyId + "\" class=\"btn btn-primary js-rebuild\">Update</button><br /><br />";
			$("#bottom_block").html(html);
			$(".is_date_right").datepicker({
				dateFormat: 'yyyy-mm-dd',
				autoClose: true,
				language: 'en',
				position: "right top",
			});
		}
		$("#switch_participants").parent().fadeIn(300);
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		$("#bottom_block").html(textStatus);
	});
}
function getCustomers() {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 250000,
		"dataType": "json",
		"data": "action=mailinglists&method=GET",
	}).done(function(response) {
		// console.table("Maillists: " + JSON.stringify(response));
		$("#participants_block").append("<h4>Participants:</h4>");
		if (response.meta.httpStatus == "200 - OK") {
			/*
			for (let i = 0; i < response.result.elements.length; i++) {
				let ml_id = response.result.elements[i].id;
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 150000,
					"dataType": "json",
					"data": "action=mailinglists/" + ml_id + "/contacts",
				}).done(function(response) {
					// console.table("Contacts for " + ml_id + ": " + JSON.stringify(response));
					// let sid = $("#survey_id").val();
					if (response.meta.httpStatus == "200 - OK") {
						*/
						let html = "";
						let min_cid = 0;
						let max_cid = 1000000;
						for (let k = 0; k < response.result.elements.length; k++) {
							// if (typeof response.result.elements[k].embeddedData != "undefined" && response.result.elements[k].embeddedData != null) {
								let ml_id = "";
								let sid = "UNKNOWN";
								let cid = "UNKNOWN";
								let contact_id = "UNKNOWN";
								let dsms = 1;
								let dsw = 1;
								let dr = 1;
								let did = "";
								// new style get data from db
								var id = response.result.elements[k].c_id;
								var fname = response.result.elements[k].fname;
								ml_id = response.result.elements[k].ml_id;
								sid = response.result.elements[k].s_id;
								if (typeof allcustomers[sid] == "undefined")
									allcustomers[sid] = [];
								if (typeof allcustomers[sid][ml_id] == "undefined")
									allcustomers[sid][ml_id] = [];
								cid = response.result.elements[k].p_number;
								dsw = response.result.elements[k].dwa;
								dr = response.result.elements[k].dr;
								dsms = response.result.elements[k].dsms;
								dontsendsmss[ml_id] = dsms;
								dontsendwas[ml_id] = dsw;
								dontsendrs[ml_id] = dr;
								did = response.result.elements[k].Dyad_ID;
								allcustomers[sid][ml_id]["name"] = decodeURIComponent(fname + " (" + cid + ")");
								allcustomers[sid][ml_id]["created"] = response.result.elements[k].created + " " + response.result.elements[k].start_date + " " + response.result.elements[k].start_time;
								allcustomers[sid][ml_id]["c_id"] = cid;
								if (min_cid == 0 || parseInt(cid) != 0 && parseInt(cid) < min_cid)
									min_cid = cid;
								if (max_cid == 1000000 || parseInt(cid) != 0 && parseInt(cid) > max_cid)
									max_cid = cid;
								// console.log(cid + "|" + min_cid + "|" + max_cid);
								/*
								ml_id = response.result.elements[k].mailinglistID;
								if (response.result.elements[k].embeddedData != null) {
									// old style get from Qualtrics
									var fname = response.result.elements[k].firstName
									sid = response.result.elements[k].embeddedData.surveyID;
									if (typeof allcustomers[sid] == "undefined")
										allcustomers[sid] = [];
									if (typeof allcustomers[sid][ml_id] == "undefined")
										allcustomers[sid][ml_id] = [];
									if (typeof response.result.elements[k].embeddedData.contact_id != "undefined")
										cid = response.result.elements[k].embeddedData.contact_id;
									allcustomers[sid][ml_id]["name"] = decodeURIComponent(response.result.elements[k].firstName + " (" + cid + ")");
									if (typeof response.result.elements[k].embeddedData.dontsendwa != "undefined")
										dsw = response.result.elements[k].embeddedData.dontsendwa;
									dontsendwas[ml_id] = dsw;
									if (typeof response.result.elements[k].embeddedData.Dyad_ID != "undefined")
										did = response.result.elements[k].embeddedData.Dyad_ID;
									if (typeof response.result.elements[k].embeddedData.created != "undefined")
										allcustomers[sid][ml_id]["created"] = response.result.elements[k].embeddedData.created + " " + response.result.elements[k].start_date + " " + response.result.elements[k].start_time;
									else
										allcustomers[sid][ml_id]["created"] = response.result.elements[k].embeddedData.start_date + " " + response.result.elements[k].embeddedData.start_time;
								}
								*/
								// allcustomers[sid][ml_id]["Dyad_ID"] = did;
								// if (response.result.elements[k].embeddedData.surveyID == sid)
								html = html + "<div class=\"js-customer hidden\" data-survey=\"" + sid + "\" data-maillist=\"" + ml_id + "\" data-id=\"" + id + "\">" + decodeURIComponent(fname + " (" + cid + ")") + " <button type=\"button\" title=\"Edit participant\" class=\"close js-details\" data-id=\"" + id + "\" data-ml=\"" + ml_id + "\" aria-label=\"details\"><span aria-hidden=\"true\">&#x270E;</span></button>";
								if (parseInt(response.result.elements[k].num_days) > 3) {
									let counter = Math.ceil(parseInt(response.result.elements[k].num_days)/3);
									for (let l = 0; l < counter; l++) {
										let del_startdate = new Date(response.result.elements[k].start_date);
										let del_enddate = new Date(response.result.elements[k].start_date);
										// console.log(del_startdate);
										// console.log(del_enddate);
										del_startdate.setDate(del_startdate.getDate() + l*3);
										del_enddate.setDate(del_enddate.getDate() + l*3 + 3);
										let start_del_date = del_startdate.toISOString().slice(0, 10);
										let end_del_date = del_enddate.toISOString().slice(0, 10);
										// console.log(start_del_date + "|" + end_del_date);
										// html = html + "<button type=\"button\" title=\"Delete distributions\" class=\"close js-deldistrs\" data-deldistr=\"" + l + "\" data-id=\"" + id + "\" data-sid=\"" + sid + "\" data-ml=\"" + ml_id + "\" data-name=\"" + fname + "\" data-startdel=\"" + start_del_date + "\" data-enddel=\"" + end_del_date + "\" aria-label=\"Close\"><span aria-hidden=\"true\">(&#10006;" + l + ")</span></button>&nbsp;";
									}
								}
								html = html + "<button type=\"button\" title=\"Delete participant\" class=\"close js-delcustomer\" data-id=\"" + id + "\" data-sid=\"" + sid + "\" data-ml=\"" + ml_id + "\" data-name=\"" + fname + "\" aria-label=\"Close\"><span aria-hidden=\"true\">&#10006;</span></button>";
								html = html + "<button type=\"button\" title=\"Delete only future distributions\" class=\"close js-delfutdistr\" data-id=\"" + id + "\" data-sid=\"" + sid + "\" data-ml=\"" + ml_id + "\" data-name=\"" + fname + "\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button> <button type=\"button\" title=\"Download csv for participant\" class=\"close js-csv\" data-sid=\"" + sid + "\" data-mid=\"" + ml_id + "\"><span aria-hidden=\"true\">↓</span></button></div>";
								// console.log(sid + " added at " );
							// }
							// else
								// alert("There is a null participant! Please remove it before adding distributions!");
						}
						$("#participants_block").append(html);
						$("#participant_min").val(min_cid);
						$("#participant_max").val(max_cid);
						/*
					}
					else
						$("#participants_block").html(response.meta.httpStatus);
				}).fail(function(jqXHR, textStatus) {
					// console.log(textStatus);
					$("#participants_block").html(textStatus);
				});
			}
			*/
			getSurveys();
		}
		else
			$("#participants_block").html(response.meta.httpStatus);
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning",  textStatus);
	});
}
function getTwilios() {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=twilio_states",
	}).done(function(response) {
		// console.table(response);
		if (response != null && typeof response.result != "undefined")
			twilios = response.result.elements;
		// $("#bottom_block").append("TWILIO ROW DATA<br /><code>" + JSON.stringify(twilios) + "</code>");
		// showAlert("success", "Got twilio_states succesfully...");
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning", textStatus);
	});
}
function getTwiliosSMS() {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=twilio_sms_states",
	}).done(function(response) {
		// console.table(response);
		if (response != null && typeof response.result != "undefined")
			twilios_sms = response.result.elements;
		// $("#bottom_block").append("TWILIO ROW DATA<br /><code>" + JSON.stringify(twilios) + "</code>");
		// showAlert("success", "Got twilio_states succesfully...");
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning", textStatus);
	});
}
function getComplete() {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=surveys_states",
	}).done(function(response) {
		// console.table(response);
		if (response != null && typeof response.result != "undefined")
			completed = response.result.elements;
		// $("#bottom_block").append("TWILIO ROW DATA<br /><code>" + JSON.stringify(twilios) + "</code>");
		// showAlert("success", "Got surveys_states succesfully...");
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning", textStatus);
	});
}
function getBulks(sid) {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "method=GET&action=bulks&sid=" + sid,
	}).done(function(response) {
		if (response != null && typeof response.result != "undefined" && typeof response.result.elements != "undefined") {
			let bulks = response.result.elements;
			// console.table(bulks);
			if (bulks.length) {
				// alert(bulks.length);
				$("#bulks_count").text(bulks.length);
				$("#send_bulks").attr("data-sid", sid);
				$("#send_bulks").parent().fadeIn(300);
			}
		}
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning", textStatus);
	});
}
function getLibraries() {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "method=GET&action=wams",
	}).done(function(response) {
		// console.table(response);
		if (response != null && typeof response.result != "undefined") {
			wams = response.result.elements;
			// console.table(wams);
			let slct = document.getElementById('wamid');
			let slct1 = document.getElementById('warmid');
			let slct4 = document.getElementById('smsid');
			let slct6 = document.getElementById('smsrid');
			let slct2 = document.getElementById('cv_wamid');
			let slct3 = document.getElementById('cv_warmid');
			let slct5 = document.getElementById('cv_smsid');
			let slct7 = document.getElementById('cv_smsrid');
			slct.options.length = 1;
			slct1.options.length = 1;
			slct2.options.length = 1;
			slct3.options.length = 1;
			slct4.options.length = 1;
			slct5.options.length = 1;
			slct6.options.length = 1;
			slct7.options.length = 1;
			$.each(response.result.elements, function(index, value) {
				var opt = document.createElement("option");
				opt.value = value.wam_id;
				opt.innerHTML = value.wam_name;
				slct.appendChild(opt);
				var opt = document.createElement("option");
				opt.value = value.wam_id;
				opt.innerHTML = value.wam_name;
				slct1.appendChild(opt);
				var opt = document.createElement("option");
				opt.value = value.wam_id;
				opt.innerHTML = value.wam_name;
				slct2.appendChild(opt);
				var opt = document.createElement("option");
				opt.value = value.wam_id;
				opt.innerHTML = value.wam_name;
				slct3.appendChild(opt);
				var opt = document.createElement("option");
				opt.value = value.wam_id;
				opt.innerHTML = value.wam_name;
				slct4.appendChild(opt);
				var opt = document.createElement("option");
				opt.value = value.wam_id;
				opt.innerHTML = value.wam_name;
				slct5.appendChild(opt);
				var opt = document.createElement("option");
				opt.value = value.wam_id;
				opt.innerHTML = value.wam_name;
				slct6.appendChild(opt);
				var opt = document.createElement("option");
				opt.value = value.wam_id;
				opt.innerHTML = value.wam_name;
				slct7.appendChild(opt);
			});
		}
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning", textStatus);
	});
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=libraries",
	}).done(function(response) {
		// console.table(response);
		if (response.meta.httpStatus == "200 - OK") {
			let slct = document.getElementById('lid');
			let cv_slct = document.getElementById('cv_lid');
			for (let i = 0; i < response.result.elements.length; i++) {
				let lid = response.result.elements[i].libraryId;
				msgs[lid] = [];
				rmsgs[lid] = [];
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 125000,
					"dataType": "json",
					"data": "action=libraries/" + lid + "/messages",
				}).done(function(response1) {
					// console.log("Messages:");
					// console.table(response1);
					if (response.meta.httpStatus == "200 - OK") {
						for (let j = 0; j < response1.result.elements.length; j++) {
							let msg = [];
							if (response1.result.elements[j].category == "reminder") {
								msg["id"] = response1.result.elements[j].id;
								msg["desc"] = response1.result.elements[j].description;
								rmsgs[lid][rmsgs[lid].length] = msg;
							}
							else {
								msg["id"] = response1.result.elements[j].id;
								msg["desc"] = response1.result.elements[j].description;
								msgs[lid][msgs[lid].length] = msg;
							}
						}
					}
				}).fail(function(jqXHR, textStatus) {
					// console.log(textStatus);
					showAlert("warning",  textStatus);
				});
				var opt = document.createElement("option");
				opt.value = response.result.elements[i].libraryId;
				opt.innerHTML = response.result.elements[i].libraryName;
				slct.appendChild(opt);
				var opt = document.createElement("option");
				opt.value = response.result.elements[i].libraryId;
				opt.innerHTML = response.result.elements[i].libraryName;
				cv_slct.appendChild(opt);
			}
		}
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning", textStatus);
	});
}
// not ready yet!!!!!!! don't use it! we start them in CUSTOMER ADD function!
function makeDistr(surveyId, maillistId, startDay, days, startTime) {
	// starting test distribution!
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=distributions&method=START&surveyId=" + surveyId + "&maillistId" + maillistId + "&startDay=" + startDay + "&days=" + days + "&startTime" + startTime,
	}).done(function(response) {
		// console.table(response);
		if (response.meta.httpStatus == "200 - OK") {
			showAlert("success", "Creating Distributions on Qualtrics has started...");
		}
		else
			showAlert("success", response.meta.httpStatus);
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning", textStatus);
	});
	// starting event subscriptions!
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=eventsubscriptions&method=START&surveyId=" + surveyId,
	}).done(function(response) {
		// console.table(response);
		if (response.meta.httpStatus == "200 - OK") {
			showAlert("success", "Subscription started...");
		}
		else
			showAlert("success", response.meta.httpStatus);
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning", textStatus);
	});
}
function makeTwilio(surveyId, number, startDay, days, startTime) {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 125000,
		"dataType": "json",
		"data": "action=twilio&method=START&surveyId=" + surveyId,
	}).done(function(response) {
		// console.table(response);
		if (response.meta.httpStatus == "200 - OK") {
			showAlert("success", "Creating Distributions on Twilio has started...");
		}
		else
			showAlert("success", response.meta.httpStatus);
	}).fail(function(jqXHR, textStatus) {
		// console.log(textStatus);
		showAlert("warning", textStatus);
	});
}
function showAlert(state, msg, rel = 0) {
	$(".alert").fadeOut(300).promise().done(function() {
		$("#messages").append(msg + "<br />");
		$("#all_popups").append(msg + "<br />");
		$(".alert").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-danger").removeClass("alert-info").addClass("alert-" + state).fadeIn(300).promise().done(function() {
			setTimeout(function() {
				$(".alert").fadeOut(300);
				if (rel == 1)
					location.reload();
			}, 5000);
			setTimeout(function() {
				$("#messages").html("");
			}, 10000);
		});
	});
}
function removeDistributions(ml_id) {
	$.ajax({
		"async": true,
		"url": "xp_ajax.php",
		"method": "POST",
		"timeout": 600000,
		"dataType": "json",
		"data": "method=DELETE&action=distributions&ml_id=" + ml_id,
	}).done(function(response) {
		showAlert("success", "The participant’s scheduled survey distributions are deleted...");
	}).fail(function(jqXHR, textStatus) {
		showAlert("warning", "Error in deletion of scheduled surveys distributions..." + textStatus);
	});
}
function getQueryVariable(query, variable) {
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (decodeURIComponent(pair[0]) == variable) {
            return decodeURIComponent(pair[1]);
        }
    }
    // console.log('Query variable %s not found', variable);
}
function fnExcelReport() {
    var tab_text="<table border='2px'>";
    var textRange;
	var j=0;
	var newtable = $("#headerTable").clone();
	newtable.insertAfter("#headerTable");
	newtable.attr("id", "headerTable1");
	newtable.find(".tabletd:hidden").remove();
    var tab = document.getElementById("headerTable1"); // id of table

    for (j = 0 ; j < tab.rows.length ; j++) {
		tab_text = tab_text + "<tr>" + tab.rows[j].innerHTML + "</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // removes input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa=txtArea1.document.execCommand("SaveAs",true,"surveys.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

    return (sa);
}
var span = document.getElementById('clock');
function time() {
  var d = new Date();
  var s = d.getSeconds();
  var m = d.getMinutes();
  var h = d.getHours();
  span.textContent = 
    ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
}
setInterval(time, 1000);