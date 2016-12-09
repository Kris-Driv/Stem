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

namespace stem\utils;

/**
 * @author PocketMine Team
 */
class AutoLoader {

	protected $lookup = [];
	protected $classes = [];

    /**
     * Adds a path to the lookup list
     *
     * @param string $path
     */
    public function addPath($path){
        foreach($this->lookup as $p){
            if($p === $path){
                return;
            }
        }
        $this->lookup[] = $path;
    }
    
    /**
     * Removes a path from the lookup list
     *
     * @param $path
     */
    public function removePath($path){
        foreach($this->lookup as $i => $p){
            if($p === $path){
                unset($this->lookup[$i]);
            }
        }
    }

    /**
     * Returns an array of the classes loaded
     *
     * @return string[]
     */
    public function getClasses(){
		$classes = [];
		foreach($this->classes as $class){
			$classes[] = $class;
		}
        return $classes;
    }

    /**
     * Attaches the ClassLoader to the PHP runtime
     *
     * @param bool $prepend
     *
     * @return bool
     */
    public function register($prepend = false){
        spl_autoload_register([$this, "loadClass"], true, $prepend);
    }

    /**
     * Called when there is a class to load
     *
     * @param string $name
     *
     * @return bool
     */
    public function loadClass($name){
        $path = $this->findClass($name);
        if($path !== null){
            include($path);
            if(!class_exists($name, false) and !interface_exists($name, false) and !trait_exists($name, false)){
		          throw new \Exception("Class $name not found");
            }
	        if(method_exists($name, "onClassLoaded") and (new ReflectionClass($name))->getMethod("onClassLoaded")->isStatic()){
		        $name::onClassLoaded();
	        }
	        
	        $this->classes[] = $name;
            return true;
        }
	    throw new \Exception("Class $name not found");
        return false;
    }

    /**
     * Returns the path for the class, if any
     *
     * @param string $name
     *
     * @return string|null
     */
    public function findClass($name){
        $components = explode("\\", $name);
        $baseName = implode(DIRECTORY_SEPARATOR, $components);
        foreach($this->lookup as $path){
            if(PHP_INT_SIZE === 8 and file_exists($path . DIRECTORY_SEPARATOR . $baseName . "__64bit.php")){
                return $path . DIRECTORY_SEPARATOR . $baseName . "__64bit.php";
            }elseif(PHP_INT_SIZE === 4 and file_exists($path . DIRECTORY_SEPARATOR . $baseName . "__32bit.php")){
                return $path . DIRECTORY_SEPARATOR . $baseName . "__32bit.php";
            }elseif(file_exists($path . DIRECTORY_SEPARATOR . $baseName . ".php")){
                return $path . DIRECTORY_SEPARATOR . $baseName . ".php";
            }
        }
        return null;
    }

}