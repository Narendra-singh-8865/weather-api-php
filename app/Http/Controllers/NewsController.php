<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\news_data;
use App\Models\news_rajasthan;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index()
    {
        $rssFeedUrl = 'https://www.bhaskar.com/rss-v1--category-1739.xml';
        $rssContent = @file_get_contents($rssFeedUrl);

        if ($rssContent) {
            $rss = simplexml_load_string($rssContent);

            if ($rss) {
                foreach ($rss->channel->item as $item) {
                    $imageUrl = null;
                    if ($item->children('media', true)->content) {
                        $imageContent = $item->children('media', true)->content;
                        $imageUrl = (string) $imageContent->attributes()->url;
                    }

                    Log::info("Fetched Image URL: " . $imageUrl);

                    $existingNews = news_data::where('title', (string)$item->title)->first();
                    if (!$existingNews) {
                        $newsdatasav = new news_data();
                        $newsdatasav->title = (string)$item->title;
                        $newsdatasav->link = (string)$item->link;
                        $newsdatasav->description = (string)$item->description;
                        $newsdatasav->published_at = date('Y-m-d H:i:s', strtotime((string)$item->pubDate));
                        $newsdatasav->image_url = $imageUrl ?? 'default-image.jpg';
                        $newsdatasav->save();
                    }
                }

                $newsItems = news_data::where('published_at', '>=', Carbon::now()->subDays(1))
                            ->orderBy('published_at', 'desc')
                            ->get();

                return view('rssdata', compact('newsItems'));
            }
        }

        return view('rssdata', ['error' => 'Unable to fetch news items']);
    }

    public function rj()
    {
        $rssFeedUrl = 'https://www.bhaskar.com/rss-v1--pratapgarhcategory-1740.xml'; 
        $rssContent = @file_get_contents($rssFeedUrl);

        if ($rssContent) {
            $rss = simplexml_load_string($rssContent);

            if ($rss) {
                foreach ($rss->channel->item as $item) {
                    $imageUrl = null;
                    if ($item->children('media', true)->content) {
                        $imageContent = $item->children('media', true)->content;
                        $imageUrl = (string) $imageContent->attributes()->url;
                    }

                    Log::info("Fetched Image URL: " . $imageUrl);

                    $existingNews = news_rajasthan::where('title', (string)$item->title)->first();
                    if (!$existingNews) {
                        $newsdatasav = new news_rajasthan();
                        $newsdatasav->title = (string)$item->title;
                        $newsdatasav->link = (string)$item->link;
                        $newsdatasav->description = (string)$item->description;
                        $newsdatasav->published_at = date('Y-m-d H:i:s', strtotime((string)$item->pubDate));
                        $newsdatasav->image_url = $imageUrl ?? 'default-image.jpg';
                        $newsdatasav->save();
                    }
                }

             
                $newsItems = news_rajasthan::where('published_at', '>=', Carbon::now()->subDays(1))
                                ->orderBy('published_at', 'desc')
                                ->get();

                return view('rajasthan', compact('newsItems'));
            }
        }

        return view('rajasthan', ['error' => 'Unable to fetch news items']);
    }
}
