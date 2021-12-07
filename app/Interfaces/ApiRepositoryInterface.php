<?php

namespace App\Interfaces;

interface ApiRepositoryInterface
{
    /**
	 * @return mixed
	 */
	public function all();

	/**
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data);

	/**
	 * @param array $data
	 * @return mixed
	 */

	public function show(int $id);
}