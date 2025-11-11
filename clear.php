<?php
if(file_exists('index.html') && is_file('index.html')) {
    unlink('index.html');
}

function deleteAll($dir) {
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file))
            deleteAll($file);
        else
            unlink($file);
    }
    rmdir($dir);
}

deleteAll('runtime/cache');
?>