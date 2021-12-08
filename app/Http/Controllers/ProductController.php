<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Interfaces\Service\ProductServiceInterface;

class ProductController extends Controller
{
    
    /**
     * Order Product
     * 
     * @return Illumintate\Http\Response
     */

    public function __construct(ProductServiceInterface $service)
    {
        $this->service = $service; 
    }

    public function order(OrderRequest $request)
    {
        return $this->service->order($request->validated());
    }
}
