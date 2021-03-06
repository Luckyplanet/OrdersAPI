<?php

namespace App\Repositories;

# app/repositories/EloquentOrderRepository.php

use App\Models\Order;
use App\Repositories\OrderRepositoryInterface;

class OrderEloquentRepository implements OrderRepositoryInterface
{

    public function create($input)
    {
        return Order::create($input);
    }

    public function take($id)
    {
        return Order::where(['id' => $id, 'status' => Order::STATUS_UNASSIGNED])->update(['status' => Order::STATUS_ASSIGNED, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    function list($page, $limit) {
        $ordersList = Order::select('id', 'distance', 'status')->paginate($limit);
        $ordersList->appends(['limit' => $limit, 'page' => $page]);
        return $ordersList->items();
    }

    public function show($id)
    {
        return Order::findOrFail($id);
    }

}
