<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatsController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('stats', now()->addHour(), function () {
            return [
                'total_users' => User::count(),
                'total_posts' => Post::count(),
                'users_with_zero_posts' => User::has('posts', '=', 0)->count(),
            ];
        });

        return response()->json($stats);
    }
}
