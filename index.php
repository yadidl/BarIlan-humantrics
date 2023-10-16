<?
require "config.php";
?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
	<title>Survey management</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="robots" content="index, follow">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="imagetoolbar" content="no">
	<meta name="msthemecompatible" content="no">
	<meta name="cleartype" content="on">
	<meta name="HandheldFriendly" content="True">
	<link rel="icon" type="image/png" href="favicon.png" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="app.css">
	<link rel="stylesheet" href="datepicker.min.css">
</head>
<body>
	<div id="clock" class="clock"></div>
<?
if (@$_POST["login"] != "" && @$_POST["passwrd"] != "")
	{
	$_SESSION["s_login"] = mysql_real_escape_string(@$_POST["login"]);
	$_SESSION["s_password"] = md5(mysql_real_escape_string(@$_POST["passwrd"]));
}
$slct = mysql_query("select * from users where user_login = '".mysql_real_escape_string($_SESSION["s_login"])."' and user_password = '".mysql_real_escape_string($_SESSION["s_password"])."'") or die(mysql_error());
if (mysql_num_rows($slct) != 1)
	{
	if (@$_SESSION["index_msg"] != "")
		print "<div class=\"login_error\">".$_SESSION["index_msg"]."</div>";
	$_SESSION["index_msg"] = "";
	?>
	<section class="container-fluid">
		<div class="row">
			<div class="col-4"></div>
			<div class="col-4">
				<form class="text-center border border-light p-5" method="post" action="/">
				<h1>Welcome to the ARLAB Diary Management App</h1>
				<div class="group">
					<div class="login_ttl">Login:</div>
					<div class="login_fld"><input type="text" name="login" size="20" /></div>
				</div>
				<div class="group">
					<div class="login_ttl">Password:</div>
					<div class="login_fld"><input type="password" name="passwrd" size="20" /></div>
				</div>
				<div class="login_enter"><button class="btn btn-info btn-block my-4 waves-effect waves-light" type="submit" name="submitit">enter</button></div>
				</form>
			</div>
			<div class="col-4"></div>
		</div>
	</div>
	<?
	if (@$_POST["login"] != "" || @$_POST["passwrd"] != "")
		{
		?>
		<div class="alert alert-warning" role="alert" style="display: block;">
			<strong id="messages">Wrong login or password</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?
	}
	?>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<?
}
else
	{
	$arr = mysql_fetch_assoc($slct);
	$username = $arr["user_name"];
	$locale = $arr["locale"];
	if ($locale == "")
		$locale = "Asia/Jerusalem";
	date_default_timezone_set($locale);
	?>
	<script>
	const password_md = '<?=$_SESSION["s_password"];?>';
	</script>
	<section class="container-fluid">
		<div class="alert alert-success" role="alert">
			<strong id="messages"></strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="row">
			<div class="col-12"><h1>Survey management</h1><h4>user <?=$username;?> (<?=$locale;?> timezone) [<a href="xp_exit.php">exit</a>]</h4></div>
		</div>
		<div class="row">
			<div class="col-5" id="survey_data">
				<h2>Survey list</h2>
				<div class="form-group form-row after_select">
					<select class="form-control" name="all_surveys" id="all_surveys" disabled>
						<option value="">-= choose survey =-</option>
					</select>
				</div>
				<div class="form-group form-row">
					<button type="button" class="btn btn-primary" name="get_roles" id="get_roles">Set parameters</button>
				</div>
				<div class="form-group form-row">
					<button type="button" class="btn btn-primary" name="get_customers" id="get_customers">Set participants</button>
				</div>
				<div class="form-group form-row hidden">
					<button type="button" class="btn btn-primary" name="switch_table" id="switch_table">Show/hide the report table</button>
				</div>
				<div class="form-group form-row hidden">
					<button type="button" class="btn btn-primary" name="switch_participants" id="switch_participants">Show/hide participants</button>
				</div>
				<div class="form-group form-row<?if ($_GET["clear"] != "CleArDisTrs") {?> hidden<?}?>">
					<button type="button" class="btn btn-primary" name="clear_it" id="clear_it">Clear all wrong distributions</button>
				</div>
				<div class="form-group form-row hidden">
					<button type="button" class="btn btn-primary js-sendbulks" name="send_bulks" id="send_bulks">Send bulks (<span id="bulks_count">0</span>)</button>
				</div>
			</div>
			<div class="col-2">
			</div>
			<div class="col-5" id="current_data" role="current_data">
				<button type="button" class="close" data-close="current_data" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<form id="roles">
					<h4>Parameters for survey <span id="surveyName"></span></h4>
					<br />
					<input type="hidden" name="surveyId" id="surveyId" value="" />
					<div class="form-group row">
						<label for="times" class="col-4">Times a day:</label>
						<input class="form-control col-4" name="times" id="times" value="" required />
						<div class="invalid-feedback col-4" id="times_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="snooze" class="col-4">Snooze, minutes:</label>
						<input class="form-control col-4" name="snooze" id="snooze" value="" required />
						<div class="invalid-feedback col-4" id="snooze_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="expire" class="col-4">Expire in, minutes:</label>
						<input class="form-control col-4" name="expire" id="expire" value="" required />
						<div class="invalid-feedback col-4" id="expire_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="random_interval" class="col-4">Random interval for<br />first send, minutes:</label>
						<input class="form-control col-4" name="random_interval" id="random_interval" value="" required />
						<div class="invalid-feedback col-4" id="random_interval_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="from_name" class="col-4">From name:</label>
						<input class="form-control col-4" name="from_name" id="from_name" value="" />
						<div class="invalid-feedback col-4" id="from_name_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="email_subj" class="col-4">Email subject:</label>
						<input class="form-control col-4" name="email_subj" id="email_subj" value="" />
						<div class="invalid-feedback col-4" id="email_subj_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="reply_to" class="col-4">Reply To:</label>
						<input class="form-control col-4" name="reply_to" id="reply_to" value="" />
						<div class="invalid-feedback col-4" id="reply_to_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="phonicID" class="col-4">Phonic survey ID:</label>
						<input class="form-control col-4" name="phonicID" id="phonicID" value="" />
						<div class="invalid-feedback col-4" id="phonicID_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="phonic_questionID" class="col-4">Phonic question ID:</label>
						<input class="form-control col-4" name="phonic_questionID" id="phonic_questionID" value="" />
						<div class="invalid-feedback col-4" id="phonic_questionID_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="physioqID" class="col-4">Physioq survey ID:</label>
						<input class="form-control col-4" name="physioqID" id="physioqID" value="" />
						<div class="invalid-feedback col-4" id="physioqID_feedback"></div>
					</div>
					<div class="form-group">
						<h4>Send options:</h4>
					</div>
					<div class="form-group row">
						<input type="radio" name="send_option" id="send_option1" value="1" checked onChange="$('.for_option_1').removeClass('hidden'); $('.for_option_2').addClass('hidden'); $('.for_option_3').addClass('hidden'); $('.for_option_1').find('input').attr('required', 'required'); $('.for_option_2').find('input').removeAttr('required'); $('.for_option_3').find('input').removeAttr('required'); $('.wdchend').addClass('hidden').find('input').removeAttr('required').prop('disabled', 'disabled');" /><label for="send_option1">Fixed interval send</label>
					</div>
					<div class="form-group row">
						<input type="radio" name="send_option" id="send_option2" value="2" onChange="$('.for_option_1').addClass('hidden'); $('.for_option_2').removeClass('hidden'); $('.for_option_3').addClass('hidden'); $('.for_option_1').find('input').removeAttr('required'); $('.for_option_2').find('input').attr('required', 'required'); $('.for_option_3').find('input').removeAttr('required'); $('.wdchend').addClass('hidden').find('input').removeAttr('required').prop('disabled', 'disabled');" /><label for="send_option2">Random interval send</label>
					</div>
					<div class="form-group row">
						<input type="radio" name="send_option" id="send_option3" value="3" onChange="$('.for_option_1').addClass('hidden'); $('.for_option_2').removeClass('hidden'); $('.for_option_3').removeClass('hidden'); $('.for_option_1').find('input').removeAttr('required'); $('.for_option_2').find('input').attr('required', 'required'); $('.for_option_3').find('input').attr('required', 'required');" /><label for="send_option3">Random interval with end time</label>
					</div>
					<div class="form-group row for_option_1">
						<label for="pause" class="col-4">Pause, minutes:</label>
						<input class="form-control col-4" name="pause" id="pause" value="" required />
						<div class="invalid-feedback col-4" id="pause_feedback"></div>
					</div>
					<div class="form-group row for_option_2 hidden">
						<label for="min_time_between" class="col-4">Min pause, minutes:</label>
						<input class="form-control col-4" name="min_time_between" id="min_time_between" value="" />
						<div class="invalid-feedback col-4" id="min_time_between_feedback"></div>
					</div>
					<div class="form-group row for_option_2 hidden">
						<label for="max_time_between" class="col-4">Max pause, minutes:</label>
						<input class="form-control col-4" name="max_time_between" id="max_time_between" value="" />
						<div class="invalid-feedback col-4" id="max_time_between_feedback"></div>
					</div>
					<div class="form-group form-row">
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</form>
			</div>
			<div class="col-5" id="customers_data" role="customers_data">
				<button type="button" class="close" data-close="customers_data" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<form id="customers">
					<input type="hidden" name="survey_id" id="survey_id" value="" />
					<input type="hidden" name="survey_name" id="survey_name" value="" />
					<h4>New participant</h4>
					<br />
					<div class="form-group row">
						<label for="contact_id" class="col-4">Participant number:</label>
						<input class="form-control col-4" name="contact_id" id="contact_id" value="" required />
						<div class="invalid-feedback col-4" id="contact_id_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="Dyad_ID" class="col-4">Dyad_ID:</label>
						<input class="form-control col-4" name="Dyad_ID" id="Dyad_ID" value="" />
						<div class="invalid-feedback col-4" id="Dyad_ID_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="dontsendsms" class="col-4">Don't send<br />SMS:</label>
						<div class="col-4">
							<input type="checkbox" class="form-control" name="dontsendsms" id="dontsendsms" value="1" checked />
						</div>
						<div class="invalid-feedback col-4" id="dontsendsms_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="dontsendwa" class="col-4">Don't send<br />WhatsApp:</label>
						<div class="col-4">
							<input type="checkbox" class="form-control" name="dontsendwa" id="dontsendwa" value="1" />
						</div>
						<div class="invalid-feedback col-4" id="dontsendwa_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="dontsendr" class="col-4">Don't send<br />Reminders:</label>
						<div class="col-4">
							<input type="checkbox" class="form-control" name="dontsendr" id="dontsendr" value="1" />
						</div>
						<div class="invalid-feedback col-4" id="dontsendr_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="name" class="col-4">First name:</label>
						<input class="form-control col-4" name="name" id="name" value="" required />
						<div class="invalid-feedback col-4" id="name_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="lastname" class="col-4">Last name:</label>
						<input class="form-control col-4" name="lastname" id="lastname" value="" required />
						<div class="invalid-feedback col-4" id="lastname_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-4">E-mail:</label>
						<input type="email" class="form-control col-4" name="email" id="email" value="" required />
						<div class="invalid-feedback col-4" id="email_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="snooze" class="col-4">Phone number:</label>
						<input class="form-control col-4" name="phone" id="phone" value="" required />
						<div class="invalid-feedback col-4" id="phone_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="lid" class="col-4">Messages library:</label>
						<select class="form-control col-4" name="lid" id="lid" required>
							<option value="">-= choose one =-</option>
						</select>
						<div class="invalid-feedback col-4" id="lid_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="mid" class="col-4">Message:</label>
						<select class="form-control col-4" name="mid" id="mid" required disabled>
							<option value="">-= choose one =-</option>
						</select>
						<div class="invalid-feedback col-4" id="mid_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="rmid" class="col-4">Reminder message:</label>
						<select class="form-control col-4" name="rmid" id="rmid" required disabled>
							<option value="">-= choose one =-</option>
						</select>
						<div class="invalid-feedback col-4" id="rmid_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="wamid" class="col-4">WhatsApp Message:</label>
						<select class="form-control col-4" name="wamid" id="wamid" required>
							<option value="">-= choose one =-</option>
						</select>
						<div class="invalid-feedback col-4" id="wamid_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="warmid" class="col-4">WhatsApp Reminder<br />message:</label>
						<select class="form-control col-4" name="warmid" id="warmid" required>
							<option value="">-= choose one =-</option>
						</select>
						<div class="invalid-feedback col-4" id="warmid_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="smsid" class="col-4">SMS message:</label>
						<select class="form-control col-4" name="smsid" id="smsid" required>
							<option value="">-= choose one =-</option>
						</select>
						<div class="invalid-feedback col-4" id="smsid_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="smsrid" class="col-4">SMS reminder:</label>
						<select class="form-control col-4" name="smsrid" id="smsrid" required>
							<option value="">-= choose one =-</option>
						</select>
						<div class="invalid-feedback col-4" id="smsrid_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="start_date" class="col-4">Start sending date:</label>
						<input class="is_date_left form-control col-4" name="start_date" id="start_date" value="" required />
						<div class="invalid-feedback col-4" id="start_date_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="days" class="col-4">Number of days<br />to send:</label>
						<input type="number" min="1" max="60" class="form-control col-4" name="days" id="days" value="" required />
						<div class="invalid-feedback col-4" id="days_feedback"></div>
					</div>
					<h5>Sending method</h5>
					<div class="form-group row">
						<label for="method0" class="col-4">Simple</label>
						<input type="radio" class="form-control col-4" name="method" id="method0" value="0" checked onClick="setmethod(0);" />
					</div>
					<div class="form-group row">
						<label for="method1" class="col-4">Extended</label>
						<input type="radio" class="form-control col-4" name="method" id="method1" value="1"  onClick="setmethod(1);" />
					</div>
					<div class="form-group row wds">
						<label for="start_time_all" class="col-4">Start sending time<br />for all days:</label>
						<input class="wdsimple form-control col-4" name="start_time_all" id="start_time_all" value="" required />
						<div class="invalid-feedback col-4" id="start_time_all_feedback"></div>
					</div>
					<div class="form-group row wds" id="endtimediv">
						<label for="end_time_all" class="col-4">End sending time<br />for all days:</label>
						<input class="wdsimple form-control col-4" name="end_time_all" id="end_time_all" value="" required />
						<div class="invalid-feedback col-4" id="end_time_all_feedback"></div>
					</div>
					<div>
						<div class="form-group row wdch hidden">
							<label for="start_time_su" class="col-4">Start sending time Su:</label>
							<input class="wdchoose wdstart form-control col-4" name="start_time_su" id="start_time_su" value="" disabled />
							<input type="checkbox" class="form-control small_chk" name="control_for_su" id="control_for_su" value="1" checked onClick="if (this.checked) {$(this).parent().parent().find('.wdchoose').prop('disabled', '').prop('required', 'required');}else{$(this).parent().parent().find('.wdchoose').prop('disabled', 'disabled').prop('required', '');}" />
							<div class="invalid-feedback col-4" id="start_time_su_feedback"></div>
						</div>
						<div class="form-group row wdch wdchend hidden">
							<label for="end_time_su" class="col-4">End sending time Su:</label>
							<input class="wdchoose wdend form-control col-4" name="end_time_su" id="end_time_su" value="" disabled />
							<div class="invalid-feedback col-4" id="end_time_su_feedback"></div>
						</div>
					</div>
					<div>
						<div class="form-group row wdch hidden">
							<label for="start_time_mo" class="col-4">Start sending time Mo:</label>
							<input class="wdchoose wdstart form-control col-4" name="start_time_mo" id="start_time_mo" value="" disabled />
							<input type="checkbox" class="form-control small_chk" name="control_for_su" id="control_for_su" value="1" checked onClick="if (this.checked) {$(this).parent().parent().find('.wdchoose').prop('disabled', '').prop('required', 'required');}else{$(this).parent().parent().find('.wdchoose').prop('disabled', 'disabled').prop('required', '');}" />
							<div class="invalid-feedback col-4" id="start_time_mo_feedback"></div>
						</div>
						<div class="form-group row wdch wdchend hidden">
							<label for="end_time_mo" class="col-4">End sending time Mo:</label>
							<input class="wdchoose wdend form-control col-4" name="end_time_mo" id="end_time_mo" value="" disabled />
							<div class="invalid-feedback col-4" id="end_time_mo_feedback"></div>
						</div>
					</div>
					<div>
						<div class="form-group row wdch hidden">
							<label for="start_time_tu" class="col-4">Start sending time Tu:</label>
							<input class="wdchoose wdstart form-control col-4" name="start_time_tu" id="start_time_tu" value="" disabled />
							<input type="checkbox" class="form-control small_chk" name="control_for_su" id="control_for_su" value="1" checked onClick="if (this.checked) {$(this).parent().parent().find('.wdchoose').prop('disabled', '').prop('required', 'required');}else{$(this).parent().parent().find('.wdchoose').prop('disabled', 'disabled').prop('required', '');}" />
							<div class="invalid-feedback col-4" id="start_time_tu_feedback"></div>
						</div>
						<div class="form-group row wdch wdchend hidden">
							<label for="end_time_tu" class="col-4">End sending time Tu:</label>
							<input class="wdchoose wdend form-control col-4" name="end_time_tu" id="end_time_tu" value="" disabled />
							<div class="invalid-feedback col-4" id="end_time_tu_feedback"></div>
						</div>
					</div>
					<div>
						<div class="form-group row wdch hidden">
							<label for="start_time_we" class="col-4">Start sending time We:</label>
							<input class="wdchoose wdstart form-control col-4" name="start_time_we" id="start_time_we" value="" disabled />
							<input type="checkbox" class="form-control small_chk" name="control_for_su" id="control_for_su" value="1" checked onClick="if (this.checked) {$(this).parent().parent().find('.wdchoose').prop('disabled', '').prop('required', 'required');}else{$(this).parent().parent().find('.wdchoose').prop('disabled', 'disabled').prop('required', '');}" />
							<div class="invalid-feedback col-4" id="start_timewe__feedback"></div>
						</div>
						<div class="form-group row wdch wdchend hidden">
							<label for="end_time_we" class="col-4">End sending time We:</label>
							<input class="wdchoose wdend form-control col-4" name="end_time_we" id="end_time_we" value="" disabled />
							<div class="invalid-feedback col-4" id="end_time_we_feedback"></div>
						</div>
					</div>
					<div>
						<div class="form-group row wdch hidden">
							<label for="start_time_th" class="col-4">Start sending time Th:</label>
							<input class="wdchoose wdstart form-control col-4" name="start_time_th" id="start_time_th" value="" disabled />
							<input type="checkbox" class="form-control small_chk" name="control_for_su" id="control_for_su" value="1" checked onClick="if (this.checked) {$(this).parent().parent().find('.wdchoose').prop('disabled', '').prop('required', 'required');}else{$(this).parent().parent().find('.wdchoose').prop('disabled', 'disabled').prop('required', '');}" />
							<div class="invalid-feedback col-4" id="start_time_th_feedback"></div>
						</div>
						<div class="form-group row wdch wdchend hidden">
							<label for="end_time_th" class="col-4">End sending time Th:</label>
							<input class="wdchoose wdchoose wdend form-control col-4" name="end_time_th" id="end_time_th" value="" disabled />
							<div class="invalid-feedback col-4" id="end_time_th_feedback"></div>
						</div>
					</div>
					<div>
						<div class="form-group row wdch hidden">
							<label for="start_time_fr" class="col-4">Start sending time Fr:</label>
							<input class="wdchoose wdstart form-control col-4" name="start_time_fr" id="start_time_fr" value="" disabled />
							<input type="checkbox" class="form-control small_chk" name="control_for_su" id="control_for_su" value="1" checked onClick="if (this.checked) {$(this).parent().parent().find('.wdchoose').prop('disabled', '').prop('required', 'required');}else{$(this).parent().parent().find('.wdchoose').prop('disabled', 'disabled').prop('required', '');}" />
							<div class="invalid-feedback col-4" id="start_time_fr_feedback"></div>
						</div>
						<div class="form-group row wdch wdchend hidden">
							<label for="end_time_fr" class="col-4">End sending time Fr:</label>
							<input class="wdchoose wdend form-control col-4" name="end_time_fr" id="end_time_fr" value="" disabled />
							<div class="invalid-feedback col-4" id="end_time_fr_feedback"></div>
						</div>
					</div>
					<div>
						<div class="form-group row wdch hidden">
							<label for="start_time_sa" class="col-4">Start sending time Sa:</label>
							<input class="wdchoose wdstart form-control col-4" name="start_time_sa" id="start_time_sa" value="" disabled />
							<input type="checkbox" class="form-control small_chk" name="control_for_su" id="control_for_su" value="1" checked onClick="if (this.checked) {$(this).parent().parent().find('.wdchoose').prop('disabled', '').prop('required', 'required');}else{$(this).parent().parent().find('.wdchoose').prop('disabled', 'disabled').prop('required', '');}" />
							<div class="invalid-feedback col-4" id="start_time_sa_feedback"></div>
						</div>
						<div class="form-group row wdch wdchend hidden">
							<label for="end_time_sa" class="col-4">End sending time Sa:</label>
							<input class="wdchoose wdend form-control col-4" name="end_time_sa" id="end_time_sa" value="" disabled />
							<div class="invalid-feedback col-4" id="end_time_sa_feedback"></div>
						</div>
					</div>
					<div class="form-group form-row">
						<button type="submit" id="add_new_customer" class="btn btn-primary">Add new participant</button>
					</div>
				</form>
			</div>
			<div class="col-5 hidden" id="customers_view">
				<button type="button" class="close" data-close="customers_data" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<h4>Participant <span id="customer_view_name"></span></h4>
				<br />
				<div class="form-group row">
					<label for="cv_contact_id" class="col-4">Participant number:</label>
					<input class="form-control col-4" name="cv_contact_id" id="cv_contact_id" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_Dyad_ID" class="col-4">Dyad_ID:</label>
					<input class="form-control col-4" name="cv_Dyad_ID" id="cv_Dyad_ID" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_dontsendsms" class="col-4">Don't send SMS:</label>
					<div class="col-4">
						<input type="checkbox" class="form-control" name="cv_dontsendsms" id="cv_dontsendsms" value="1" disabled />
					</div>
				</div>
				<div class="form-group row">
					<label for="cv_dontsendwa" class="col-4">Don't send WhatsApp:</label>
					<div class="col-4">
						<input type="checkbox" class="form-control" name="cv_dontsendwa" id="cv_dontsendwa" value="1" disabled />
					</div>
				</div>
				<div class="form-group row">
					<label for="cv_dontsendr" class="col-4">Don't send Reminders:</label>
					<div class="col-4">
						<input type="checkbox" class="form-control" name="cv_dontsendr" id="cv_dontsendr" value="1" disabled />
					</div>
				</div>
				<div class="form-group row">
					<label for="cv_name" class="col-4">First name:</label>
					<input class="form-control col-4" name="cv_name" id="cv_name" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_lastname" class="col-4">Last name:</label>
					<input class="form-control col-4" name="cv_lastname" id="cv_lastname" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_email" class="col-4">E-mail:</label>
					<input type="email" class="form-control col-4" name="cv_email" id="cv_email" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_snooze" class="col-4">Phone number:</label>
					<input class="form-control col-4" name="cv_phone" id="cv_phone" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_lid" class="col-4">Messages library:</label>
					<select class="form-control col-4" name="cv_lid" id="cv_lid" disabled>
						<option value="">-= choose one =-</option>
					</select>
					<div class="invalid-feedback col-4" id="cv_lid_feedback"></div>
				</div>
				<div class="form-group row">
					<label for="cv_mid" class="col-4">Message:</label>
					<select class="form-control col-4" name="cv_mid" id="cv_mid" disabled>
						<option value="">-= choose one =-</option>
					</select>
					<div class="invalid-feedback col-4" id="cv_mid_feedback"></div>
				</div>
				<div class="form-group row">
					<label for="cv_rmid" class="col-4">Reminder message:</label>
					<select class="form-control col-4" name="cv_rmid" id="cv_rmid" disabled>
						<option value="">-= choose one =-</option>
					</select>
					<div class="invalid-feedback col-4" id="cv_rmid_feedback"></div>
				</div>
				<div class="form-group row">
					<label for="cv_wamid" class="col-4">WhatsApp Message:</label>
					<select class="form-control col-4" name="cv_wamid" id="cv_wamid" disabled>
						<option value="">-= choose one =-</option>
					</select>
					<div class="invalid-feedback col-4" id="cv_mid_feedback"></div>
				</div>
				<div class="form-group row">
					<label for="cv_warmid" class="col-4">WhatsApp Reminder<br />message:</label>
					<select class="form-control col-4" name="cv_warmid" id="cv_warmid" disabled>
						<option value="">-= choose one =-</option>
					</select>
					<div class="invalid-feedback col-4" id="cv_warmid_feedback"></div>
				</div>
				<div class="form-group row">
					<label for="cv_smsid" class="col-4">SMS message:</label>
					<select class="form-control col-4" name="cv_smsid" id="cv_smsid" disabled>
						<option value="">-= choose one =-</option>
					</select>
					<div class="invalid-feedback col-4" id="cv_smsid_feedback"></div>
				</div>
				<div class="form-group row">
					<label for="cv_smsrid" class="col-4">SMS reminder:</label>
					<select class="form-control col-4" name="cv_smsrid" id="cv_smsrid" disabled>
						<option value="">-= choose one =-</option>
					</select>
					<div class="invalid-feedback col-4" id="cv_smsrid_feedback"></div>
				</div>
				<div class="form-group row">
					<label for="cv_start_date" class="col-4">Start sending date:</label>
					<input class="is_date_left form-control col-4" name="cv_start_date" id="cv_start_date" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_days" class="col-4">Number of days to send:</label>
					<input type="number" min="1" max="60" class="form-control col-4" name="cv_days" id="cv_days" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_start_time_all" class="col-4">Start sending time:</label>
					<input class="form-control col-4" name="cv_start_time_all" id="cv_start_time_all" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_end_time_all" class="col-4">End sending time:</label>
					<input class="form-control col-4" name="cv_end_time_all" id="cv_end_time_all" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_start_time_su" class="col-4">Start sending time Su:</label>
					<input class="form-control col-4" name="cv_start_time_su" id="cv_start_time_su" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_start_time_mo" class="col-4">Start sending time Mo:</label>
					<input class="form-control col-4" name="cv_start_time_mo" id="cv_start_time_mo" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_start_time_tu" class="col-4">Start sending time Tu:</label>
					<input class="form-control col-4" name="cv_start_time_tu" id="cv_start_time_tu" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_start_time_we" class="col-4">Start sending time We:</label>
					<input class="form-control col-4" name="cv_start_time_we" id="cv_start_time_we" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_start_time_th" class="col-4">Start sending time Th:</label>
					<input class="form-control col-4" name="cv_start_time_th" id="cv_start_time_th" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_start_time_fr" class="col-4">Start sending time Fr:</label>
					<input class="form-control col-4" name="cv_start_time_fr" id="cv_start_time_fr" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_start_time_sa" class="col-4">Start sending time Sa:</label>
					<input class="form-control col-4" name="cv_start_time_sa" id="cv_start_time_sa" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_end_time_su" class="col-4">End sending time Su:</label>
					<input class="form-control col-4" name="cv_end_time_su" id="cv_end_time_su" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_end_time_mo" class="col-4">End sending time Mo:</label>
					<input class="form-control col-4" name="cv_end_time_mo" id="cv_end_time_mo" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_end_time_tu" class="col-4">End sending time Tu:</label>
					<input class="form-control col-4" name="cv_end_time_tu" id="cv_end_time_tu" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_end_time_we" class="col-4">End sending time We:</label>
					<input class="form-control col-4" name="cv_end_time_we" id="cv_end_time_we" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_end_time_th" class="col-4">End sending time Th:</label>
					<input class="form-control col-4" name="cv_end_time_th" id="cv_end_time_th" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_end_time_fr" class="col-4">End sending time Fr:</label>
					<input class="form-control col-4" name="cv_end_time_fr" id="cv_end_time_fr" value="" readonly />
				</div>
				<div class="form-group row">
					<label for="cv_end_time_sa" class="col-4">End sending time Sa:</label>
					<input class="form-control col-4" name="cv_end_time_sa" id="cv_end_time_sa" value="" readonly />
				</div>
				<!--
				<h4>Send options:</h4>
				<div class="form-group row">
					<input type="radio" name="send_option" id="send_option1" value="1" checked disabled /><label for="send_option1">Fixed interval send</label>
				</div>
				<div class="form-group row">
					<input type="radio" name="send_option" id="send_option2" value="2" disabled /><label for="send_option2">Random interval send</label>
				</div>
				<div class="form-group row">
					<input type="radio" name="send_option" id="send_option3" value="3" disabled /><label for="send_option3">Random interval with end time</label>
				</div>
				-->
			</div>
		</div>
		<div class="row">
			<div class="col-12" id="participants_block">
				<input type="hidden" id="participant_min" />
				<input type="hidden" id="participant_max" />
			</div>
		</div>
		<div class="row">
			<div class="col-12" id="bottom_block">
			</div>
		</div>
		<div class="row">
			<div class="col-12" id="button_block">
			</div>
		</div>
		<div class="row">
			<div class="col-12" id="all_popups">
				<h3>All the messages and alerts:</h3>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="jquery.inputmask.min.js"></script>
	<script type="text/javascript" src="datepicker.min.js"></script>
	<script type="text/javascript" src="tableToExcel.js"></script>
	<script type="text/javascript" src="app.js?v=1"></script>
	<script>
		function setmethod(m) {
			if (m == 1) {
				$('.wdsimple').prop('disabled', 'disabled').prop('required', '');
				$('.wdchoose').prop('disabled', '').prop('required', 'required');
				$('.wds').addClass('hidden').promise().done(function() {
					$('.wdch').removeClass('hidden');
				});
				var a = $('#start_time_all').val();
				var b = $('#end_time_all').val();
				$('.wdstart').val(a);
				$('.wdend').val(b);
				let send_option = $('[name=send_option]:checked').val();
				if (send_option == 3) {
					$('.wdchend').each(function() {
						if ($(this).parent().find('input[type=checkbox]').is(':checked'))
							$(this).removeClass('hidden').find('input').attr('required', 'required')
						else
							$(this).parent().find('input:not([type=checkbox])').removeAttr('required').attr('disabled', 'disabled');
					});
				}
				else {
					$('.wdchend').addClass('hidden').find('input').removeAttr('required');
				}
			}
			else {
				$('.wdchoose').prop('disabled', 'disabled').prop('required', '');
				$('.wdsimple').prop('disabled', '').prop('required', 'required');
				$('.wdch').addClass('hidden').promise().done(function() {
					$('.wds').removeClass('hidden');
				});
				let send_option = $('[name=send_option]:checked').val();
				if (send_option == 3) {
					$('#endtimediv').removeClass('hidden').find('input').attr('required', 'required');
				}
				else {
					$('#endtimediv').addClass('hidden').find('input').removeAttr('required');
				}
			}
		}
	</script>
	<iframe id="txtArea1" style="display:none"></iframe>
	<div class="popup hidden" id="schedule_view">
		<div class="popup_in">
			<button type="button" class="close" data-close-parent onClick="$('#customers').fadeIn(300);">
				<span aria-hidden="true">&times;</span>
			</button>
			<form id="customers_times" method="post" action="/"></form>
		</div>
	</div>
	<?
}
?>
</body>
</html>