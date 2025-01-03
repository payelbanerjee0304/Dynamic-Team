<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Session;

use App\Models\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NewsUserController extends Controller
{
    public function seeAllNews()
    {
        $currentDate = (int) Carbon::now()->format('Ymd');
        $allNews = News::where('startDate', '<=', $currentDate)->where('endDate', '>=', $currentDate)->where('isDeleted',false)->orderBy('created_at', 'desc')->get();
        // echo "<pre>";
        // print_r($allNews);die;
        return view('user.seeAllNews',  compact('allNews'));
    }

    public function newsDetails($newsId)
    {
            $currentDate = (int) Carbon::now()->format('Ymd');
            $news = News::where(['_id' => $newsId])->first();
            return view('user.newsDetails',  compact('news'));

    }
}
