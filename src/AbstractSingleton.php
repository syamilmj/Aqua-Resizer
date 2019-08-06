<?php
/**
 * Abstract Class for Singleton
 */

namespace Sy4mil\AqResize;

/**
 * Class AbstractSingleton
 *
 * @package AqResize
 */
abstract class AbstractSingleton {
	/**
	 * Call this method to get singleton
	 */
	public static function getInstance() {
		static $instance = false;
		if ( $instance === false ) {
			$instance = new static();
		}

		return $instance;
	}

	/**
	 * Make constructor private, so nobody can call "new Class".
	 */
	protected function __construct() {
	}

	/**
	 * Make clone magic method private, so nobody can clone instance.
	 */
	private function __clone() {
	}

	/**
	 * Make sleep magic method private, so nobody can serialize instance.
	 */
	private function __sleep() {
	}

	/**
	 * Make wakeup magic method private, so nobody can unserialize instance.
	 */
	private function __wakeup() {
	}
}
