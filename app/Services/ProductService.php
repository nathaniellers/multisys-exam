<?php

namespace App\Services;

use App\Enums\ResponseMessage;
use App\Traits\ResponseTraits;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductServiceInterface;
use Illuminate\Http\Response;

class ProductService implements ProductServiceInterface
{
    use ResponseTraits;
    
    private $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function order($data)
    {
        try {
            $product = $this->repository->show($data['product_id']);
            $stock = $product->available_stock;
            $total = ($stock - $data['quantity']);
            $product->update(['available_stock' => $total]);
            if ($stock < $data['quantity'])
            {
                return $this->error(ResponseMessage::error['order'], Response::HTTP_BAD_REQUEST);
            }
            return $this->success(ResponseMessage::success['base'], $product, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}