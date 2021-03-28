<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class VendorController extends Controller
{
    public function search(Request $request)
    {
        $name = $request['vendor'];
        $postal = $request['postal'] ?? '';
        $vendors = collect(config('vendors'))->filter(function($item) use ($name, $postal) {
            return stripos($item['name'],$name) !== false ||
                   stripos($item['postal'],$postal) !== false;
        });
        $vendors = $this->paginate($vendors, $perPage = 15, $page = null, $options = []);
        return response()->json($vendors);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
