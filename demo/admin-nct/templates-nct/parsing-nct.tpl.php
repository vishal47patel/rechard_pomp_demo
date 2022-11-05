<?php
	$main->set("module", $module);
	$main->set("breadcrumb",$objHome->getBreadcrumb($breadcrumb));
	require_once(DIR_ADMIN_THEME.'theme.template-nct.php');

	$head->styles  = $styles;
	$head->scripts = $scripts;
	$head->title   = $winTitle;
	$head->metaTag = $metaTag;

	$head        =  $head->parse();
	$site_header = ($header_panel!=false)?$site_header->parse():'';
	$left        = ($left_panel!=false)?$objHome->getLeftMenu():'';
	$body        =  $pageContent;
	$footer      = ($footer_panel!=false)?$footer->parse():'';

	/*add class and div based on admin login contdition*/
	if($adminUserId>0){
		$f_cond   = '<div class="page-container">';
		$s_cond   = '<div class="page-content">';
		$t_cond   = $ft_cond = '</div>';
		$lg_class = "page-header-fixed";
	} else {
		$f_cond   = $s_cond = $t_cond = $ft_cond = '';
		$lg_class = "login";
	}
	/*add class and div based on admin login contdition*/

	/*load js*/
	$load_home = "";
	$loadJs    = load_js($scripts);
		/*load js for home page on top*/

		if($module == 'home-nct'){
			$load_home = $loadJs;
			$loadJs    = "";
		}
		/*load js for home page on top*/

	/*load js*/

			$addoverlay = '';
			$removeoverlay = '';
		if($module == 'language-nct' || $module == 'currency-nct'){
			$addoverlay = 'addOverlay();';
			$removeoverlay = 'removeOverlay();';
		}

	$search = array('%HEAD%','%SITE_HEADER%','%LEFT%','%BODY%','%FOOTER%','%F_COND%','%S_COND%','%T_COND%','%FT_COND%','%LG_CLASS%','%LOAD_JS%','%HOME_JS%','%TOASTR_MSG%','%ADD_OVERLAY%','%REMOVE_OVERLAY%');
	$replace = array($head,$site_header,$left,$body,$footer,$f_cond,$s_cond,$t_cond,$ft_cond,$lg_class,$loadJs,$load_home,$toastr_message,$addoverlay,$removeoverlay);
	$page_content=str_replace($search,$replace,$page->parse());
	echo $page_content;
	exit;