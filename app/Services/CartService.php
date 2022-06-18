<?php
namespace App\Services;
use App\Models\Product;

class CartService
{
    public function checkProduct()
	{
		$cart = session()->get('cart', []);

        $product = Product::select('id','price','discount','is_in_stock')
            ->whereIn('id', array_column($cart, 'id'))
            ->get();
        $productArr = $product->mapWithKeys(function ($item, $key) {
            return [$item['id'] => ['price' =>$item['price'],
                'discount' =>$item['discount'],
                'status' =>$item['is_in_stock']]];
        });
        foreach ($cart as $key => $value) {

            $productPrice = number_format(
                $productArr[$value['id']]['price'] - ($productArr[$value['id']]['price'] * 
                ($productArr[$value['id']]['discount']/100)), 2);

            if($value['price'] != $productPrice) {
                $cart[$key]['price'] = $productPrice;
                session()->put('cart', $cart);
            }
            if ($productArr[$value['id']]['status'] == 0) {
                unset($cart[$key]);
                session()->put('cart', $cart);
            }
        }
	}
}