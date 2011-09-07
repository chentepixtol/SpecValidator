<?php

namespace Schema\Validator;

interface Validator
{

	/**
	 *
	 * @return boolean
	 */
	public function isValid($value);

	/**
	 *
	 * @param Validator $validator
	 * @return Validator
	 */
	public function addAND($validator);

	/**
	 *
	 * @param Validator $validator
	 * @return Validator
	 */
	public function addOR($validator);

	/**
	 *
	 * @return Validator
	 */
	public function not();

	/**
	 *
	 * @return array
	 */
	public function getErrors();

}