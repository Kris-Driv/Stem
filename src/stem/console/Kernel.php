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

namespace stem\console;

use stem\console\input\Input;
use stem\console\output\Output;

class Kernel {

	const STATUS_OK = 0;

	/**
	 * Handles command input
	 * @param Input $input
	 * @param Output &$output
	 * @return int
	 */
	public function handle(Input $input, Output $output) : int {
		return self::STATUS_OK;
	}

	public function terminate(Input $input, int $status) {
		echo "exit $status\n";
	}

}