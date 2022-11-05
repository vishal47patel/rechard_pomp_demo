<?php
include 'includes-nct/config-nct.php';
echo extension_loaded('pgsql') ? 'yes':'no';
echo phpinfo();
?>