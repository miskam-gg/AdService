<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::query();


        if ($request->has('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($sort === 'date_asc') {
                $query->orderBy('created_at', 'asc');
            } elseif ($sort === 'date_desc') {
                $query->orderBy('created_at', 'desc');
            }
        }


        $ads = $query->get()->map(function ($ad) {
            return [
                'title' => $ad->title,
                'main_photo' => $ad->photos[0] ?? null,
                'price' => $ad->price,
            ];
        });


        $paginatedAds = $this->paginate($ads, 10);


        return response()->json($paginatedAds);
    }

    public function show($id, Request $request)
    {
        $ad = Ad::findOrFail($id);

        $response = [
            'title' => $ad->title,
            'price' => $ad->price,
            'main_photo' => $ad->photos[0] ?? null,
        ];

        if ($request->has('fields')) {
            $fields = explode(',', $request->input('fields'));
            if (in_array('description', $fields)) {
                $response['description'] = $ad->description;
            }
            if (in_array('photos', $fields)) {
                $response['photos'] = $ad->photos;
            }
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'photos' => 'nullable|array|max:3',
            'photos.*' => 'url',
            'price' => 'required|numeric|min:0',
        ]);

        $ad = Ad::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'photos' => $validated['photos'] ?? [],
            'price' => $validated['price'],
        ]);

        return response()->json(['id' => $ad->id, 'status' => 'success'], 201);
    }


    protected function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
