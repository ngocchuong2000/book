<?php

namespace App\Models;

class Cart
{
    public $items = null;
    public $totalQty = 0;

    public function __construct($oldCart)
    {
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
        }
    }

    public function add($item, $id, $qty){
        $storedItem = ['qty' => 0, 'price' => (strtotime(date('Y-m-d')) < strtotime($item->start_date) || strtotime(date('Y-m-d')) > strtotime($item->end_date)) ? $item->price : $item->sale_price, 'item' => $item];
        if($this->items){
            if(array_key_exists($id, $this->items)){
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty'] += $qty;
        $storedItem['price'] = ((strtotime(date('Y-m-d')) < strtotime($item->start_date) || strtotime(date('Y-m-d')) > strtotime($item->end_date)) ? $item->price : $item->sale_price) * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty += $qty;
    }

    public function deleteItem($id){
        $this->totalQty -= $this->items[$id]['qty'];
        unset($this->items[$id]);
    }

    public function changeQty($request)
    {
        if ((int) $this->items[$request->id]['qty'] < (int) $request->qty) {
            $currentQty = (int) $request->qty - (int) $this->items[$request->id]['qty'];
            $this->totalQty += $currentQty;
            $this->items[$request->id]['qty'] += (int) $currentQty;
        } else if ((int) $this->items[$request->id]['qty'] > (int) $request->qty) {
            $currentQty = (int) $this->items[$request->id]['qty'] - (int) $request->qty;
            $this->totalQty -= $currentQty;
            $this->items[$request->id]['qty'] -= (int) $currentQty;
        }
        $price = (strtotime(date('Y-m-d')) < strtotime($this->items[$request->id]['item']['start_date']) || strtotime(date('Y-m-d')) > strtotime($this->items[$request->id]['item']['end_date'])) ? $this->items[$request->id]['item']['price'] : $this->items[$request->id]['item']['sale_price'];
        $this->items[$request->id]['price'] = (int) $request->qty * $price;
    }
}
