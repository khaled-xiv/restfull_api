<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $buyers=Buyer::has('transactions')->get();
        return $this->showAll($buyers);
    }

    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer);
    }

    public function buyerTransactions(Buyer $buyer)
    {
        $transactions=$buyer->transactions;
        return $this->showAll($transactions);
    }

    public function buyerProducts(Buyer $buyer)
    {
        $products=$buyer->transactions()
            ->with('product')
            ->get()
            ->pluck('product');
        return $this->showAll($products);
    }

    public function buyerSellers(Buyer $buyer)
    {
        $sellers=$buyer->transactions()
            ->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values()
        ;
        return $this->showAll($sellers);
    }

    public function buyerCategories(Buyer $buyer)
    {
        $sellers=$buyer->transactions()
            ->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse()
            ->unique('id')
            ->values()
        ;
        return $this->showAll($sellers);
    }
}
