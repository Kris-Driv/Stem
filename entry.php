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

namespace {

	if(\Phar::running(true) !== ""){
		@define('STEM_PATH', \Phar::running(true) . "/");
	}else{
		@define('STEM_PATH', \getcwd() . DIRECTORY_SEPARATOR);
	}

	// Get POCKETMINE_PATH
	// This script by default must be in root of PocketMine-MP server
	@define('POCKETMINE_PATH', dirname(STEM_PATH));

	/*
	 * ----------------------------------------------------------
	 * AUTO-LOADER
	 * ----------------------------------------------------------
	 * 
	 * Require autoloader 
	 *
	 */

	require_once(STEM_PATH . 'src/stem/utils/AutoLoader.php');

	$autoloader = new \stem\utils\AutoLoader();
	$autoloader->addPath(STEM_PATH . "src");
	$autoloader->register(true);

}
namespace stem {

	use stem\console\Kernel;
	use stem\console\input\Input;
	use stem\console\output\Output;

	/*
	 * ----------------------------------------------------------
	 * LAUNCH
	 * ----------------------------------------------------------
	 */

	$kernel = new Kernel();

	$status = $kernel->handle(
		$input = new Input,
		$output = new Output
	);

	/*
	 * ----------------------------------------------------------
	 * SHUTDOWN
	 * ----------------------------------------------------------
	 */

	$kernel->terminate($input, $status);

	exit($status);

}