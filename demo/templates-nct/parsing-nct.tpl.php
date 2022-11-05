<?php


	$main->set("module", $module);

	/*if($rand_numers != $_SESSION['rand_d_numers']  || ($rand_numers == '' || $_SESSION['rand_d_numers'] == '') ){msg_odl();exit;}*/

	/* for head  start*/
	$replace_head = array('%METATAG%'=>$metaTag,'%TITLE%'=>$winTitle);
	$head_content = get_view(DIR_TMPL."head-nct.tpl.php",$replace_head);
	/* for head  end*/

	/*display the loader where page is load start*/
	$showLoad = isset($_REQUEST['showLoad']) && $_REQUEST['showLoad'] != "" ? $_REQUEST['showLoad'] : NULL;

	$cls = '';

	if($showLoad == 'show_loading'){
		$cls = 'load';
	}
	/*display the loader where page is load end*/

	/*load css and js from module start*/
		$js_var = load_js_variable($js_variables);
		$js =  load_js($scripts);
		$css =  load_css($styles);
	/*load css and js from module end*/

	/*create class for main body based on selected language*/
	$langName = getTableValue('tbl_language','languageName',array('id'=>$lId));
	$langClass = 'lang-'.Slug(strtolower($langName));
	/*create class for main body based on selected language*/

	/* Outputting the data to the end user */
	$replace = array(
				'%LOAD_CLASS%'=>$cls,
				'%LANG_CLASS%'=>$langClass,
				'%HEAD%'=>$head_content,
				'%SITE_HEADER%'=>$objHome->getHeaderContent(),
				'%BODY%'=>$pageContent,
				'%FOOTER%'=>$objHome->getFooterContent($module),
				'%MESSAGE_TYPE%'=>$msgType,
				'%LOAD_CSS%'=>$css,
				'%LOAD_JS%'=>$js,
				'%LOAD_JS_VARIABLE%'=>$js_var,
			);

	/* Loading template files */
	$page_content = get_view(DIR_TMPL."main-nct.tpl.php",$replace);

	echo ($page_content);
	exit;
