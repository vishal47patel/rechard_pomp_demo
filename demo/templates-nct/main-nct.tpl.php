<!DOCTYPE html>
<html lang="en">
	<head>
		%HEAD%
	</head>
	<body class="%LOAD_CLASS% %LANG_CLASS%">
		<div class="page-wrap">
			%SITE_HEADER%
			%LOAD_CSS%
			%BODY%
		</div>
		%FOOTER%
		%LOAD_JS_VARIABLE%
		%LOAD_JS%
		<script src="{SITE_JS}bootstrap-toastr/toastr.min.js"></script>
		<script>
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"positionClass": "toast-top-full-width",
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut",
				"preventDuplicates": true,
				"preventOpenDuplicates": true
			}
		</script>
		%MESSAGE_TYPE%
	</body>
</html>
