<?php

namespace App\Http\Controllers;

use App\Mail\RegisterSubscriber;
use App\Mail\SubscriberMail;
use App\Models\Advertisement;
use App\Models\BottomAdvertisements;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\HeaderAdvertisements;
use App\Models\News;
use App\Models\Seo;
use App\Models\Setting;
use App\Models\Subscribers;
use App\Models\SidebarAdvertisements;
use App\Models\Tags;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FrontController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $header_advertisement = HeaderAdvertisements::latest()->where('status', 1)->get();
        $sidebar_advertisement = SidebarAdvertisements::latest()->where('status', 1)->get();
        $bottom_advertisement = BottomAdvertisements::latest()->where('status', 1)->get();
        $leftcategory = [];
        $categories = Category::all()->toArray();
        $menucategories = Category::take(7)->get()->toArray();
        $downmenucategories = Category::take(3)->get()->toArray();
        foreach ($categories as $category) {
            if (in_array($category, $menucategories)) {
            } else {
                array_push($leftcategory, $category);
            }
        }
        $advertisement = Advertisement::first();
        $categoryallnews = News::latest()->where('draft', 0)->whereDate('created_at', date('Y-m-d'))->take(4)->get();
        $allthenews = News::latest()->where('featured', '1')->where('draft', 0)->whereDate('created_at', date('Y-m-d'))->get();
        $todaytrendingnews = News::latest()->where('is_trending', 1)->where('draft', 0)->whereDate('created_at', date('Y-m-d'))->take(5)->get();
        $popularnews = News::orderby('view_count', 'DESC')->where('draft', 0)->take(5)->get();
        $trendingone = News::latest()->where('is_trending', 1)->where('draft', 0)->first();
        $trendingthree = News::where('is_trending', 1)->where('draft', 0)->take(3)->get();
        $trendingfive = News::latest()->where('is_trending', 1)->where('draft', 0)->take(5)->get();
        $recentnews = News::latest()->where('draft', 0)->take(5)->get();
        return view('frontend.index', compact('setting', 'leftcategory','header_advertisement', 'sidebar_advertisement', 'bottom_advertisement',  'trendingone', 'trendingthree', 'trendingfive', 'downmenucategories', 'menucategories', 'popularnews', 'advertisement', 'allthenews', 'recentnews', 'categoryallnews', 'todaytrendingnews'));
    }

    public function aboutus()
    {
        $setting = Setting::first();
        $header_advertisement = HeaderAdvertisements::latest()->where('status', 1)->get();
        $sidebar_advertisement = SidebarAdvertisements::latest()->where('status', 1)->get();
        $bottom_advertisement = BottomAdvertisements::latest()->where('status', 1)->get();
        $advertisement = Advertisement::first();
        $leftcategory = [];
        $categories = Category::all()->toArray();
        $menucategories = Category::take(7)->get()->toArray();;
        foreach ($categories as $category) {
            if (in_array($category, $menucategories)) {
            } else {
                array_push($leftcategory, $category);
            }
        }
        $requiredcategories = Category::take(6)->get();
        $allnews = News::latest()->where('draft', 0)->get();
        $popularnews = News::orderby('view_count', 'DESC')->where('draft', 0)->take(4)->get();
        $latestnews = News::latest()->where('draft', 0)->take(4)->get();
        return view('frontend.aboutus', compact('setting', 'leftcategory','header_advertisement', 'sidebar_advertisement', 'bottom_advertisement',  'menucategories', 'advertisement', 'requiredcategories', 'allnews', 'popularnews', 'latestnews'));
    }

    public function pageCategory($slug)
    {
        $setting = Setting::first();
        $header_advertisement = HeaderAdvertisements::latest()->where('status', 1)->get();
        $sidebar_advertisement = SidebarAdvertisements::latest()->where('status', 1)->get();
        $bottom_advertisement = BottomAdvertisements::latest()->where('status', 1)->get();
        $advertisement = Advertisement::first();
        $leftcategory = [];
        $categories = Category::all()->toArray();
        $menucategories = Category::take(7)->get()->toArray();;
        foreach ($categories as $category) {
            if (in_array($category, $menucategories)) {
            } else {
                array_push($leftcategory, $category);
            }
        }
        $category = Category::where('slug', $slug)->first();
        $requiredcategories = Category::take(6)->get();
        SEOMeta::setTitle($category->title);
        $allnews = News::latest()->where('draft', 0)->get();
        $popularnews = News::orderby('view_count', 'DESC')->where('draft', 0)->take(4)->get();
        $latestnews = News::latest()->where('draft', 0)->take(4)->get();
        $news = News::whereJsonContains('category_id',"$category->id")->latest()->where('draft', 0)->simplePaginate(20);
        $onenews = News::whereJsonContains('category_id',"$category->id")->where('draft', 0)->first();
        // $news = [];
        // $onenews = '';
        // foreach ($allnews as $newsitem) {
        //     if (in_array($category->id, $newsitem->category_id)) {
        //         $onenews = $newsitem;
        //         array_push($news, $newsitem);
        //     }
        // }
        return view('frontend.category', compact('setting', 'allnews','header_advertisement', 'sidebar_advertisement', 'bottom_advertisement',  'onenews', 'requiredcategories', 'latestnews', 'advertisement', 'popularnews', 'leftcategory', 'menucategories', 'category', 'news'));
    }

    public function pageSubcategory($id, $slug)
    {
        $setting = Setting::first();
        $header_advertisement = HeaderAdvertisements::latest()->where('status', 1)->get();
        $sidebar_advertisement = SidebarAdvertisements::latest()->where('status', 1)->get();
        $bottom_advertisement = BottomAdvertisements::latest()->where('status', 1)->get();
        $advertisement = Advertisement::first();
        $leftcategory = [];
        $categories = Category::all()->toArray();
        $menucategories = Category::take(7)->get()->toArray();;
        foreach ($categories as $category) {
            if (in_array($category, $menucategories)) {
            } else {
                array_push($leftcategory, $category);
            }
        }
        $category = Subcategory::where('slug', $slug)->first();
        $requiredcategories = Category::take(6)->get();
        SEOMeta::setTitle($category->title);
        $allnews = News::latest()->where('draft', 0)->get();
        // $subcategorynews = News::whereJsonContains('subcategory_id',$id)->latest()->where('draft', 0)->get();
        $popularnews = News::orderby('view_count', 'DESC')->where('draft', 0)->take(4)->get();
        $latestnews = News::latest()->where('draft', 0)->take(4)->get();
        $news = News::whereJsonContains('subcategory_id',$id)->where('draft', 0)->latest()->simplePaginate(20);
        $onenews = News::whereJsonContains('subcategory_id',$id)->where('draft', 0)->first();
        // foreach ($allnews as $newsitem) {
        //     if (in_array($category->id, $newsitem->category_id)) {
        //         $onenews = $newsitem;
        //         array_push($news, $newsitem);
        //     }
        // }
        return view('frontend.subcategory', compact('setting', 'allnews','header_advertisement', 'sidebar_advertisement', 'bottom_advertisement',  'onenews', 'requiredcategories', 'latestnews', 'advertisement', 'popularnews', 'leftcategory', 'menucategories', 'category', 'news'));
    }

    public function pageNews($categoryslug, $slug)
    {
        $setting = Setting::first();
        $header_advertisement = HeaderAdvertisements::latest()->where('status', 1)->get();
        $sidebar_advertisement = SidebarAdvertisements::latest()->where('status', 1)->get();
        $bottom_advertisement = BottomAdvertisements::latest()->where('status', 1)->get();
        $advertisement = Advertisement::first();
        $leftcategory = [];
        $categories = Category::all()->toArray();
        $menucategories = Category::take(7)->get()->toArray();;
        foreach ($categories as $category) {
            if (in_array($category, $menucategories)) {
            } else {
                array_push($leftcategory, $category);
            }
        }
        $requiredcategories = Category::take(6)->get();
        $latestnews = News::latest()->where('draft', 0)->take(4)->get();
        $news = News::where('slug', $slug)->first();
        $popularnews = News::orderby('view_count', 'DESC')->where('draft', 0)->take(4)->get();
        $allnews = News::where('draft', 0)->get();

        $relatednewsitem = [];
        for ($i = 0; $i < count($news->category_id); $i++) {
            $categoryname = Category::where('id', $news->category_id[$i])->first();
            foreach ($allnews as $relatednews) {
                if (in_array($categoryname->id, $relatednews->category_id)) {
                    array_push($relatednewsitem, $relatednews);
                }
            }
        }

        $seo_info = Seo::where('news_id', $news->id)->first();
        $tags = Tags::where('news_id', $news->id)->get();
        $keywords = [];
        foreach ($tags as $tag) {
            array_push($keywords, $tag->tags);
        }

        $url = Storage::disk('uploads')->url($news->image);

        SEOMeta::setTitle($seo_info->seotitle);
        SEOMeta::setDescription($seo_info->seodescription);
        SEOMeta::addKeyword($keywords);
        SEOMeta::setCanonical('https://hambalnews.com' . '/' . $categoryslug . '/' . $slug);
        OpenGraph::setTitle($seo_info->seotitle);
        OpenGraph::setDescription($seo_info->seodescription);
        OpenGraph::setUrl('https://hambalnews.com' . '/' . $categoryslug . '/' . $slug);
        OpenGraph::addProperty('type', 'articles');
        OpenGraph::addImage($url);

        TwitterCard::setTitle($seo_info->seotitle);
        TwitterCard::setSite('@AnishGu70482739');
        TwitterCard::setImage($url);

        $news->update([
            'view_count' => $news->view_count + 1,
        ]);
        return view('frontend.news', compact('setting', 'advertisement','header_advertisement', 'sidebar_advertisement', 'bottom_advertisement',  'leftcategory', 'popularnews', 'news', 'tags', 'menucategories', 'relatednewsitem', 'latestnews', 'allnews', 'requiredcategories'));
    }

    public function pageAuthor($name)
    {

        SEOMeta::setTitle($name);
        $leftcategory = [];
        $categories = Category::all()->toArray();
        $menucategories = Category::take(7)->get()->toArray();;
        foreach ($categories as $category) {
            if (in_array($category, $menucategories)) {
            } else {
                array_push($leftcategory, $category);
            }
        }
        $setting = Setting::first();
        $header_advertisement = HeaderAdvertisements::latest()->where('status', 1)->get();
        $sidebar_advertisement = SidebarAdvertisements::latest()->where('status', 1)->get();
        $bottom_advertisement = BottomAdvertisements::latest()->where('status', 1)->get();
        $advertisement = Advertisement::first();
        $authornews = News::latest()->where('author', $name)->where('draft', 0)->get();
        $requiredcategories = Category::take(6)->get();
        $latestnews = News::latest()->where('draft', 0)->take(4)->get();
        $popularnews = News::orderby('view_count', 'DESC')->where('draft', 0)->take(4)->get();
        $allnews = News::where('draft', 0)->get();
        return view('frontend.authorarticles', compact('authornews', 'name','header_advertisement', 'sidebar_advertisement', 'bottom_advertisement',  'leftcategory', 'menucategories', 'requiredcategories', 'latestnews', 'popularnews', 'allnews', 'setting', 'advertisement'));
    }

    public function pageTag($tag)
    {
        SEOMeta::setTitle('#' . $tag);
        $leftcategory = [];
        $categories = Category::all()->toArray();
        $menucategories = Category::take(7)->get()->toArray();;
        foreach ($categories as $category) {
            if (in_array($category, $menucategories)) {
            } else {
                array_push($leftcategory, $category);
            }
        }
        $setting = Setting::first();
        $header_advertisement = HeaderAdvertisements::latest()->where('status', 1)->get();
        $sidebar_advertisement = SidebarAdvertisements::latest()->where('status', 1)->get();
        $bottom_advertisement = BottomAdvertisements::latest()->where('status', 1)->get();
        $advertisement = Advertisement::first();
        $requiredcategories = Category::take(6)->get();
        $latestnews = News::latest()->where('draft', 0)->take(4)->get();
        $popularnews = News::orderby('view_count', 'DESC')->where('draft', 0)->take(4)->get();
        $allnews = News::where('draft', 0)->get();
        $tagnews = [];
        $tagslug = Str::slug($tag);
        $tags = Tags::where('slug', $tagslug)->get();
        foreach ($tags as $tagitem) {
            $tagnewsitem = News::where('id', $tagitem->news_id)->first();
            array_push($tagnews, $tagnewsitem);
        }
        return view('frontend.tagsnews', compact('tag', 'leftcategory', 'tagnews','header_advertisement', 'sidebar_advertisement', 'bottom_advertisement',  'menucategories', 'requiredcategories', 'latestnews', 'popularnews', 'allnews', 'setting', 'advertisement'));
    }

    public function pageSearch(Request $request)
    {
        $searchword = $request['word'];
        // $searchednews = News::where('title', 'LIKE', '%' . $searchword . '%')->orWhere('details', 'LIKE', '%' . $searchword . '%')->orWhere('slug', 'LIKE', '%' . $searchword . '%')->get();

        $searchednews = News::where('draft', 0)
           ->where(function ($query) use ($searchword) {
               $query->where('title', 'LIKE', '%' . $searchword . '%')
                     ->orWhere('details', 'LIKE', '%' . $searchword . '%')
                     ->orWhere('slug', 'LIKE', '%' . $searchword . '%');
           })
           ->get();

        SEOMeta::setTitle($searchword);
        $leftcategory = [];
        $categories = Category::all()->toArray();
        $menucategories = Category::take(7)->get()->toArray();;
        foreach ($categories as $category) {
            if (in_array($category, $menucategories)) {
            } else {
                array_push($leftcategory, $category);
            }
        }
        $setting = Setting::first();
        $header_advertisement = HeaderAdvertisements::latest()->where('status', 1)->get();
        $sidebar_advertisement = SidebarAdvertisements::latest()->where('status', 1)->get();
        $bottom_advertisement = BottomAdvertisements::latest()->where('status', 1)->get();
        $advertisement = Advertisement::first();
        $requiredcategories = Category::take(6)->get();
        $latestnews = News::latest()->where('draft', 0)->take(4)->get();
        $popularnews = News::orderby('view_count', 'DESC')->where('draft', 0)->take(4)->get();
        $allnews = News::where('draft', 0)->get();
        return view('frontend.searchednews', compact('searchword', 'leftcategory','header_advertisement', 'sidebar_advertisement', 'bottom_advertisement',  'searchednews', 'menucategories', 'requiredcategories', 'latestnews', 'popularnews', 'allnews', 'setting', 'advertisement'));
    }

    public function registerSubscriber(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $existing_subscriber = Subscribers::where('email', $request['email'])->where('is_verified', 1)->first();

        if ($existing_subscriber != null) {
            return redirect()->route('index')->with('success', 'You have already subscribed. Thank you!!');
        } else {
            $subscriber = Subscribers::create([
                'email' => $request['email'],
                'verification_code' => sha1(time())
            ]);
            $subscriber->save();
            $mailData = [
                'verification_code' => $subscriber->verification_code,
            ];

            Mail::to($request['email'])->send(new RegisterSubscriber($mailData));
            return redirect()->route('index')->with('success', 'We have sent a confirmation code to your gmail account for subscription. Please Check your email.');
        }
    }

    public function confirmSubscribtion()
    {
        $verification_code = \Illuminate\Support\Facades\Request::get('code');
        $subscriber = Subscribers::where('verification_code', $verification_code)->first();
        if ($subscriber != null) {
            $subscriber->is_verified = 1;
            $subscriber->save();
            return redirect()->route('index')->with('success', 'Thank you for subscribing.');
        }
        return redirect()->route('index')->with('error', 'Sorry, Your subscribtion is not confirmed. Please try again!');
    }

    public static function sendNews($news, $category)
    {
        $setting = Setting::first();
        $url = 'https://hambalnews.com/' . $category->slug . '/' . $news->slug;
        $mailData = [
            'news' => $news,
            'url' => $url,
            'setting' => $setting
        ];

        $subscribers = Subscribers::where('is_verified', 1)->get();
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new SubscriberMail($mailData));
        }
    }

    public function privacypolicy()
    {
        $setting = Setting::first();
        $header_advertisement = HeaderAdvertisements::latest()->where('status', 1)->get();
        $sidebar_advertisement = SidebarAdvertisements::latest()->where('status', 1)->get();
        $bottom_advertisement = BottomAdvertisements::latest()->where('status', 1)->get();
        $advertisement = Advertisement::first();
        $leftcategory = [];
        $categories = Category::all()->toArray();
        $menucategories = Category::take(7)->get()->toArray();;
        foreach ($categories as $category) {
            if (in_array($category, $menucategories)) {
            } else {
                array_push($leftcategory, $category);
            }
        }
        $requiredcategories = Category::take(6)->get();
        $allnews = News::latest()->where('draft', 0)->get();
        $popularnews = News::orderby('view_count', 'DESC')->where('draft', 0)->take(4)->get();
        $latestnews = News::latest()->where('draft', 0)->take(4)->get();
        return view('frontend.privacypolicy', compact('setting', 'leftcategory','header_advertisement', 'sidebar_advertisement', 'bottom_advertisement',  'menucategories', 'advertisement', 'requiredcategories', 'allnews', 'popularnews', 'latestnews'));
    }
}
