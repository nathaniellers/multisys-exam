<?php

namespace App\Repositories;

use App\Interfaces\ApiRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ApiRepository implements ApiRepositoryInterface
{

   /**
	 * @var Model
	 * model property on class instances
	 */
	private $model;

	/**
	 * RestRepository constructor.
	 * @param Model $model
	 * Constructor bind to model
	 */
	public function __construct(User $model)
	{
		$this->model = $model;
	}

    // more functions for Collections

	/**
	 * @return mixed
	 * Get all instance of model
	 */
	public function all()
	{
		return $this->model->all()->toArray();
	}

	/**
	 * @param array $data
	 * @return mixed
	 * Create new record in database
	 */
	public function create(array $data) : array
	{
		return $this->model->create($data)->toArray();
	}

	/**
	 * @param $id
	 * @return mixed
	 * Get row in database
	 */
	public function show($id)
	{
		return $this->model->findOrFail($id);
	}

	/**
	 * @return Model
	 * Get
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * @param $model
	 * @return $this
	 * Set Model
	 * insights disregard
	 */
	public function setModel($model)
	{
		$this->model = $model;
		return $this;
	}
}

?>