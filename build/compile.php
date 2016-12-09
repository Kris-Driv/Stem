<?php
/*
 *   Stem: Your friendly helper
 *
 *   Copyright (C) 2016  Chris Prime
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
$started = microtime(true);

$path = null;
foreach(['entry.php', '../entry.php'] as $file) {
	if(file_exists($file)) {
		$path = dirname(realpath($file));
		break;
	}
}
echo $path, PHP_EOL;
if(!$path) die('entry file not found');

if(Phar::canWrite()) {
	$archive = new \Phar($path . '/stem.phar');
	$archive = $archive->convertToExecutable(Phar::PHAR);
	$archive->startBuffering();

	$archive->buildFromDirectory($path);

	$archive->stopBuffering();

	echo "Executable Phar saved to '{$path}/stem' in ".(microtime(true) - $started)." seconds\n";
} else {
	die('can not write on .phar archive. phar.readonly must be 0 in php.ini');
}