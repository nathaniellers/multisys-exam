<?php

namespace App\Interfaces\Repository;

interface ProductRepositoryInterface
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