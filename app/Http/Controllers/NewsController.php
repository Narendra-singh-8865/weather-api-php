<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\news_data;
use App\Models\news_rajasthan;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index()
    {
        $rssFeedUrl = 'https://www.bhaskar.com/rss-v1--category-1739.xml';
        $newsItems = $this->fetchAndStoreNews($rssFeedUrl, new news_data());

        if ($newsItems !== false) {
            return view('rssdata', compact('newsItems'));
        }

        return view('rssdata', ['error' => 'Unable to fetch news items']);
    }

    public function rj()
    {
        $rssFeedUrl = 'https://www.bhaskar.com/rss-v1--pratapgarhcategory-1740.xml';
        $newsItems = $this->fetchAndStoreNews($rssFeedUrl, new news_rajasthan());

        if ($newsItems !== false) {
            return view('rajasthan', compact('newsItems'));
        }

        return view('rajasthan', ['error' => 'Unable to fetch news items']);
    }

    private function fetchAndStoreNews($rssFeedUrl, $modelInstance)
    {
        try {
            $response = Http::get($rssFeedUrl);

            if (!$response->successful()) {
                Log::error("Failed to fetch RSS feed from URL: $rssFeedUrl");
                return false;
            }

            $rss = simplexml_load_string($response->body());

            if (!$rss) {
                Log::error("Invalid RSS XML format from URL: $rssFeedUrl");
                return false;
            }

            foreach ($rss->channel->item as $item) {
                $title = (string) $item->title;
                $existing = $modelInstance->where('title', $title)->first();

                if (!$existing) {
                    $imageUrl = null;
                    if ($item->children('media', true)->content) {
                        $imageContent = $item->children('media', true)->content;
                        $imageUrl = (string) $imageContent->attributes()->url;
                    }

                    $news = clone $modelInstance;
                    $news->title = $title;
                    $news->link = (string) $item->link;
                    $news->description = (string) $item->description;
                    $news->published_at = date('Y-m-d H:i:s', strtotime((string) $item->pubDate));
                    $news->image_url = $imageUrl ?: 'default-image.jpg';
                    $news->save();

                    Log::info("Saved news: $title");
                }
            }

            return $modelInstance->where('published_at', '>=', Carbon::now()->subDay())
                                 ->orderBy('published_at', 'desc')
                                 ->get();
        } catch (\Exception $e) {
            Log::error("Exception while processing RSS feed: " . $e->getMessage());
            return false;
        }
    }
}
