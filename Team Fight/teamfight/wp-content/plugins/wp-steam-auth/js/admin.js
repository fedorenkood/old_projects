jQuery(document).ready( function($) {
	
	
	// Login Redirect checkbox
	if ($('input[name=wpsapSettings_loginRedirectReferer]').is(':checked') == true){
		$('input[name=wpsapSettings_loginRedirect]').val('').attr('disabled', true).attr('placeholder', '');
	} else {
		$('input[name=wpsapSettings_loginRedirect]').val('').attr('disabled', false).attr('placeholder', 'http://');
	}
	
	$('input[name=wpsapSettings_loginRedirectReferer]').change(function(){
		if ($('input[name=wpsapSettings_loginRedirectReferer]').is(':checked') == true){
			$('input[name=wpsapSettings_loginRedirect]').val('').attr('disabled', true).attr('placeholder', '');
		} else {
			$('input[name=wpsapSettings_loginRedirect]').val('').attr('disabled', false).attr('placeholder', 'http://');
		}
	});
	
	// Logout Redirect checkbox
	if ($('input[name=wpsapSettings_logoutRedirectReferer]').is(':checked') == true){
		$('input[name=wpsapSettings_logoutRedirect]').val('').attr('disabled', true).attr('placeholder', '');
	} else {
		$('input[name=wpsapSettings_logoutRedirect]').val('').attr('disabled', false).attr('placeholder', 'http://');
	}
	
	$('input[name=wpsapSettings_logoutRedirectReferer]').change(function(){
		if ($('input[name=wpsapSettings_logoutRedirectReferer]').is(':checked') == true){
			$('input[name=wpsapSettings_logoutRedirect]').val('').attr('disabled', true).attr('placeholder', '');
		} else {
			$('input[name=wpsapSettings_logoutRedirect]').val('').attr('disabled', false).attr('placeholder', 'http://');
		}
	});
	
	// Popup Enabled Checbox
	if ($('input[name=wpsapOption_popupEnabled]').is(':checked') == true){
		$('div.wpsapSettings_loginRedirect').hide();
		$('div.wpsapSettings_loginRedirect_alt').show();
	} else {
		$('div.wpsapSettings_loginRedirect').show();
		$('div.wpsapSettings_loginRedirect_alt').hide();
	}
	
	$('input[name=wpsapOption_popupEnabled]').change(function(){
		if ($('input[name=wpsapOption_popupEnabled]').is(':checked') == true){
			$('div.wpsapSettings_loginRedirect').hide();
			$('div.wpsapSettings_loginRedirect_alt').show();
		} else {
			$('div.wpsapSettings_loginRedirect').show();
			$('div.wpsapSettings_loginRedirect_alt').hide();
		}
	});
	
	// AppURL
	$('input[name=wpsapSettings_steamAppUrl], input[name=wpsapSettings_steamAppLoginUrl], input[name=wpsapSettings_steamAppSyncUrl], input[name=wpsapSettings_steamAppLogoutUrl]').bind('input', function() {
		$(this).val($(this).val().replace(/[^a-z0-9-]/gi, ''));
	});
	
	$("input[name=wpsapSettings_steamAppUrl]").keyup(function(event) {
		var mirror;
		if($(this).val().length > 0){
			mirror = '/' + $(this).val();
		}else{
			mirror = $(this).val();
		}
		$(".wpsapSettings_steamAppUrl_mirror").text(mirror);
	});
	
	$("input[name=wpsapSettings_steamAppLoginUrl]").keyup(function(event) {
		$(".wpsapSettings_steamAppLoginUrl_mirror").text($(this).val());
	});
	
	$("input[name=wpsapSettings_steamAppSyncUrl]").keyup(function(event) {
		$(".wpsapSettings_steamAppSyncUrl_mirror").text($(this).val());
	});
	
	$("input[name=wpsapSettings_steamAppLogoutUrl]").keyup(function(event) {
		$(".wpsapSettings_steamAppLogoutUrl_mirror").text($(this).val());
	});
	
	
	
	
});