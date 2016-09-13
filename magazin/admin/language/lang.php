<?php
if (!isset($argv[1]) || !is_dir($argv[1]) || in_array($argv[1], array('.', '..'))) {
	throw new Exception("First argument must be valid directory", 1);
}
if (!isset($argv[2]) || !is_dir($argv[2]) || in_array($argv[2], array('.', '..'))) {
	throw new Exception("Second argument must be valid directory", 1);
}

$lang1 = $argv[1];
$lang2 = $argv[2];

echo 'language 1: ' . $lang1 . PHP_EOL;
echo 'language 2: ' . $lang2 . PHP_EOL;

$d = new RecursiveDirectoryIterator($lang1);
$iterator = new RecursiveIteratorIterator($d);

foreach ($iterator as $it) {
	if (!is_file($it) || $it->getExtension() != 'php') {
		continue;
	}
	$file_lang1 = (string)$it;
	$file_lang2 = preg_replace('~' . $lang1 . '~', $lang2, $file_lang1);
	$dir_lang2 = preg_replace('~' . $lang1 . '~', $lang2, $it->getPath());
	if (is_file($file_lang2)) {
		$_ = array();
		include($file_lang1);
		$strings_lang1 = $_;
		$_ = array();
		include($file_lang2);
		$strings_lang2 = $_;
		$diff = array_diff_key($strings_lang1, $strings_lang2);
		if (count($diff) > 0) {
			$txt = PHP_EOL . "<?php" . PHP_EOL;
			$txt .= "// ==================== copied from " . $lang1 . " below ==================== //" . PHP_EOL;
			foreach ($diff as $k => $v) {
				$txt .= "\$_['" . $k . "'] = '" . $v . "';" . PHP_EOL;
			}
			$txt .= "?>" . PHP_EOL;
			file_put_contents($file_lang2, $txt, FILE_APPEND);
			echo 'missing vars copied ' . $file_lang1 . ' -> ' . $file_lang2 . PHP_EOL;
			editFile($file_lang2);
		} else {
			echo 'no changes for ' . $file_lang2 . PHP_EOL;
		}
	} else {
		if (!is_dir($dir_lang2)) {
			mkdir($dir_lang2, 0755, true);
			echo 'created directory ' . $dir_lang2 . PHP_EOL;
		}
		copy ($file_lang1, $file_lang2);
		echo 'missing file copied ' . $file_lang1 . ' -> ' . $file_lang2 . PHP_EOL;
		editFile($file_lang2);
	}
}
// placeholder lazy solution
function editFile($file)
{
	exec(str_replace("/", "\\", $file));
}
exit();