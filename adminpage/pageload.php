<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if (!empty($_GET['page'])) {
        $page = trim($_GET['page']);
        if (file_exists($page)) {
            include($page);
        } else {
            include('404.php');
        }
    } else {
        echo "This anchor tage has no url";
    }
} else exit();
?>