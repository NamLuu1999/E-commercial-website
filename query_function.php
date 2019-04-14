<?php
function get_category ()
{
    global $link;
    $cat_names = array();
    $sql_category = "SELECT `name` FROM `categories`";
    $result = mysqli_query($link, $sql_category);

    while ($ar = mysqli_fetch_assoc($result)){
        $cat_names[] = $ar;
    }
    return $cat_names;
}

$category = get_category();
?>