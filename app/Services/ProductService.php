<?php

namespace App\Services;

use App\Enums\ResponseMessage;
use App\Traits\ResponseTraits;
use App\Interfaces\Repository\ProductRepositoryInterface;
use App\Interfaces\Service\ProductServiceInterface;
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
            if ($stock < $data['quantity'])
            {
                return response()->json(['message' => ResponseMessage::error['order']])->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
            $product->update(['available_stock' => $total]);
            return response()->json(['message' => ResponseMessage::success['order']])->setStatusCode(Response::HTTP_BAD_REQUEST); 
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}