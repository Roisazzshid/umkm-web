<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->store;
        $storeId = $store->id;

        // Base reviews query for this store
        $baseQuery = Review::whereHas('product', function ($q) use ($storeId) {
            $q->where('store_id', $storeId);
        });

        // 1. Calculate stats
        $totalReviews = (clone $baseQuery)->count();
        $averageRating = (clone $baseQuery)->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 1) : 0.0;

        // Count per rating
        $counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        $ratingGroups = (clone $baseQuery)
            ->select('rating', \DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->get();

        foreach ($ratingGroups as $group) {
            $counts[$group->rating] = $group->total;
        }

        // Percentage for UI progress bars
        $percentages = [];
        foreach ($counts as $star => $count) {
            $percentages[$star] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
        }

        // 2. Fetch list of reviews with filters
        $listQuery = Review::whereHas('product', function ($q) use ($storeId) {
            $q->where('store_id', $storeId);
        })->with(['customer', 'product'])->orderBy('created_at', 'desc');

        if ($request->filled('bintang') && $request->bintang !== 'semua') {
            $listQuery->where('rating', $request->bintang);
        }

        $reviews = $listQuery->get();

        return view('umkm.ulasan', compact(
            'totalReviews',
            'averageRating',
            'counts',
            'percentages',
            'reviews'
        ));
    }
}
