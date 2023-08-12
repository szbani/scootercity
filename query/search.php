<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if (!empty($_POST['search'])) {
        if (!isset($db)) {
            define('ACCESS_ALLOWED', true);
            require_once 'conn.php';
            $db = new dataBase();
        }

        $search = $_POST['search'];

        $sql = "SELECT t.id,t.nev,t.ar, 
    (SELECT file_name FROM kepek k 
    WHERE k.termek_id = t.id 
    ORDER BY img_order LIMIT 1)as image 
    FROM `termekek` t WHERE t.nev LIKE '%{$search}%' LIMIT 5; ";

        $result = $db->Select($sql);
//        var_dump($result);
        $html = '';
        if (!empty($result)){
            foreach ($result as $item){
                $image = 'product-placeholder.png';
                if ($item['image'] != null) {
                    $image = $item['image'];
                }
                $html .= "<li class='list-group-item mb-2'>
                            <a class='row g-0' href='/bolt/termek/" . $item['id'] . "/" . $item['nev'] . "'>
                             <div class='col-3'>
                                <img src='/media/products/" . $image . "'>
                             </div>
                             <div class='col-9'>
                                <div class='w-100'>" . $item['nev'] . "</div>
                                <div class='w-100'>" . $item['ar'] . "</div>
                             </div>
                            </a>
                           </li>";
            }
        }else {
            $html .= '<li class="list-group-item d-flex justify-content-center align-items-center h-auto">
                        <p>Nincs találat!</p>
                      </li>';
        }

        echo $html;
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    exit("Access restricted - AJAX requests only");
}
?>