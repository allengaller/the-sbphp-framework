<?
/**
 * AJAX请求返回json信息
 */
function setAjaxMessage($number, $messages) {
    $arr = array('infoNo' => $number, 'infoStr' => $messages);
    return array_to_json($arr);
}

function checkClass($filename) {
    if (file_exists($filename)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * 数组转json
 */
function array_to_json($array) {
    if (!is_array($array)) {
        return false;
    }
    $associative = count(array_diff(array_keys($array), array_keys(array_keys($array))));
    if ($associative) {
        $construct = array();
        foreach ($array as $key => $value) {
            if (is_numeric($key)) {
                $key = "key_$key";
            }
            $key = '"' . addslashes($key) . '"';
            if (is_array($value)) {
                $value = array_to_json($value);
            } else if (!is_numeric($value) || is_string($value)) {
                $value = '"' . addslashes($value) . '"';
            } else if (is_bool($value)) {
                $value = '"' . $value . '"';
            }
            $construct[] = "$key: $value";
        }

        $result = "{ " . implode(", ", $construct) . " }";

    } else {
        $construct = array();
        foreach ($array as $value) {
            if (is_array($value)) {
                $value = array_to_json($value);
            } else if (!is_numeric($value) || is_string($value)) {
                $value = '"' . addslashes($value) . '"';
            }
            $construct[] = $value;
        }
        $result = "[ " . implode(", ", $construct) . " ]";
    }
    return $result;
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo = true, $label = null, $strict = true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}

/**
 * 自动创建目录
 * $path 绝对路径，如 c:/some/desdir.txt   /root/usr   注意：后面没有 /
 */
function makeDirs($path) {
    if ($path == '')
        return false;
    $path = str_replace('\\', '/', $path);
    $path = preg_replace("&/[^/]*\.[^/]*$&i", "", $path);
    //去掉文件名
    list($root, $pathStr) = explode('/', $path, 2);
    $dirs = explode('/', $pathStr);
    $root .= '/';
    $num = 0;
    for ($i = 0, $count = count($dirs); $i < $count; $i++) {
        $root .= $dirs[$i] . '/';
        if (!is_dir($root)) {
            mkdir($root, 0777);
            writeDataToFile("$root/index.html", "", "rb+", 0);
            $num++;
        }
    }
    return $num;
}

/**
 * 创建tml文件
 * $filePath 为html文件的绝对路径 如： c:/html/2005/06/sample.html  或 /usr/local/fdf.html
 *
 */
function createHtmlFile($filePath, $content) {
    makeDirs($filePath);
    $fd = fopen($filePath, "wb");
    $rs = fwrite($fd, $content);
    fclose($fd);
    return $rs;
    //成功则返回写入的字符数  失败返回 FALSE
}

/**
 * 复制一个目录（包括里面的文件）到另一个目录 ，相同文件会被覆盖
 * @param string $srcDir    /test/srcdir   后面没有/
 * @param string $destDir   /test22        后面没有/   复制完后为 /test22/srcdir
 */
function copyDir($srcDir, $destDir) {
    if (!is_dir($srcDir))
        return false;
    $newDir = str_replace('//', '/', $destDir . '/' . basename($srcDir));
    $result = 0;
    if (!is_dir($newDir)) {
        if (!@mkdir($newDir, 0777))
            return false;
        else
            $result++;
    }
    $fso = @opendir($srcDir);
    while (false !== ($file = @readdir($fso))) {
        $srcFile = "$srcDir/$file";
        $destFile = "$newDir/$file";
        if (@copy($srcFile, $destFile))
            $result++;
    }
    @closedir($fso);
    return $result;
}

/*
 * 清除缓存
 */
function delCache() {
    //echo SMARTY_COMPLIE_DIR.'<br>';
    $dh = opendir(SMARTY_COMPLIE_DIR);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = SMARTY_COMPLIE_DIR . "/" . $file;
            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                //delCache($fullpath);
            }
        }
    }
    closedir($dh);
    //if (rmdir($dir)) {
   //     return true;
   // } else {
   //     return false;
   // }
}
?>
