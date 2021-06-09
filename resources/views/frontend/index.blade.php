@extends('frontend.layouts.app')

@section('content')
<main>
    <!-- Trending Area Start -->
    <div class="trending-area fix area-lightgrey">
        <div class="container">
            @if(session()->has('success'))
                <div class="alert alert-success mt-2">{{ session('success' )}}</div>
            @endif
            @if(session()->has('failure'))
                <div class="alert alert-danger mt-2">{{ session('failure' )}}</div>
            @endif
            <div class="trending-main">
                <!-- Trending Tittle -->
                <div class="row mt-3 mb-3">
                    <div class="col-lg-8 bg-white">
                        <div class="trending-tittle">
                            <strong>प्रचलन समाचार</strong>
                            <!-- <p>Rem ipsum dolor sit amet, consectetur adipisicing elit.</p> -->
                            <div class="trending-animated">
                                <ul id="js-news" class="js-hidden">
                                    @foreach ($todaytrendingnews as $newsitem)
                                    @php
                                        $category = DB::table('categories')->where('id', $newsitem->category_id[0])->first();
                                    @endphp
                                        <li class="news-item"><a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $newsitem->slug])}}">{{$newsitem->title}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 bg-white">
                        <div class="blog_right_sidebar">
                            <aside class="single_sidebar_widget search_widget">
                                <form action="{{route('page.search')}}" method="GET">
                                    @csrf
                                    @method("GET")
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="word" placeholder='खोजी गर्नुहोस्'
                                                onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'खोजी गर्नुहोस्'">
                                            <div class="input-group-append">
                                                <button class="btns" type="submit" class="form-control"><i class="ti-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </aside>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-lg-8 bg-white pt-3 ">
                        <!-- Featured Top -->
                        <div class="trending-top mb-30">
                            <div class="trend-top-img">
                                    @php
                                        $category = DB::table('categories')->where('id', $trendingone->category_id[0])->first();
                                    @endphp
                                <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug'=> $trendingone->slug])}}"><img src="{{Storage::disk('uploads')->url($trendingone->image)}}" alt="{{$trendingone->title}}"></a>
                                <div class="trend-top-cap">
                                    @foreach ($trendingone->category_id as $category)
                                        @php
                                            $categories_name = DB::table('categories')->where('id', $category)->first();
                                        @endphp

                                        <span class="color1">{{$categories_name->title}}</span>
                                    @endforeach

                                    <h2><a href="{{route('page.news', ['categoryslug' => $categories_name->slug, 'slug' => $trendingone->slug])}}">{{$trendingone->title}}</a></h2>
                                </div>
                            </div>
                        </div>
                        <!-- Featured Bottom -->
                        <div class="trending-bottom">
                            <div class="row">
                                @foreach ($trendingthree as $news)
                                    <div class="col-lg-4 bg-white">
                                        <div class="single-bottom mb-35">
                                            <div class="trend-bottom-img mb-30">
                                                @php
                                                    $category = DB::table('categories')->where('id', $news->category_id[0])->first();
                                                @endphp
                                                <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $news->slug])}}"><img src="{{Storage::disk('uploads')->url($news->image)}}" alt="{{$news->title}}"></a>
                                            </div>
                                            <div class="trend-bottom-cap">
                                                @foreach ($news->category_id as $category)
                                                    @php
                                                        $categories_name = DB::table('categories')->where('id', $category)->first();
                                                    @endphp

                                                    <span class="color1">{{$categories_name->title}}</span>
                                                @endforeach

                                                <h4><a href="{{route('page.news', ['categoryslug' => $categories_name->slug, 'slug' => $news->slug])}}">{{$news->title}}</a></h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Right Featured content -->
                    <div class="col-lg-4 bg-white pt-3">
                        @foreach ($trendingfive as $news)
                            <div class="trand-right-single d-flex">
                                <div class="trand-right-img">
                                    @php
                                        $category = DB::table('categories')->where('id', $news->category_id[0])->first();
                                    @endphp
                                    <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $news->slug])}}"><img src="{{Storage::disk('uploads')->url($news->image)}}" alt="{{$news->title}}" style="max-height: 100px;"></a>
                                </div>
                                <div class="trand-right-cap">
                                    @foreach ($news->category_id as $category)
                                        @php
                                            $categories_name = DB::table('categories')->where('id', $category)->first();
                                        @endphp

                                        <span class="color1">{{$categories_name->title}}</span>
                                    @endforeach
                                    <h4><a href="{{route('page.news', ['categoryslug' => $categories_name->slug, 'slug' => $news->slug])}}">{{$news->title}}</a></h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Trending Area End -->
    <!--   Weekly-News start -->
    <div class="weekly-news-area pt-50">
        <div class="container">
           <div class="weekly-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>लोकप्रिय समाचार</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="weekly-news-active dot-style d-flex dot-style">
                            @foreach ($popularnews as $news)
                                <div class="weekly-single">
                                    <div class="weekly-img">
                                        @php
                                            $category = DB::table('categories')->where('id', $news->category_id[0])->first();
                                        @endphp
                                        <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $news->slug])}}"><img src="{{Storage::disk('uploads')->url($news->image)}}" alt="{{$news->title}}"></a>
                                    </div>
                                    <div class="weekly-caption">
                                        @foreach ($news->category_id as $category)
                                            @php
                                                $categories_name = DB::table('categories')->where('id', $category)->first();
                                            @endphp

                                            <span class="color1">{{$categories_name->title}}</span>
                                        @endforeach
                                        <h4><a href="{{route('page.news', ['categoryslug' => $categories_name->slug, 'slug' => $news->slug])}}">{{$news->title}}</a></h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
    <!-- End Weekly-News -->
   <!-- Whats New Start -->
    <section class="whats-news-area pt-15 pb-20 area-lightgrey">
        <div class="container">
            <div class="row">
            <div class="col-lg-8 bg-white pt-3">
                <div class="row d-flex justify-content-between">
                    <div class="col-lg-3 col-md-3">
                        <div class="section-tittle mb-30">
                            <h3>ताजा समाचार</h3>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <div class="properties__button">
                            <!--Nav Button  -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">All</a>

                                     @foreach ($downmenucategories as $category)
                                        <a class="nav-item nav-link" id="nav-{{$category['slug']}}-tab" data-toggle="tab" href="#nav-{{$category['slug']}}" role="tab" aria-controls="nav-{{$category['slug']}}" aria-selected="false">{{$category['title']}}</a>
                                    @endforeach
                                    {{-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Travel</a>
                                    <a class="nav-item nav-link" id="nav-last-tab" data-toggle="tab" href="#nav-last" role="tab" aria-controls="nav-contact" aria-selected="false">Fashion</a>
                                    <a class="nav-item nav-link" id="nav-Sports" data-toggle="tab" href="#nav-nav-Sport" role="tab" aria-controls="nav-contact" aria-selected="false">Sports</a>
                                    <a class="nav-item nav-link" id="nav-technology" data-toggle="tab" href="#nav-techno" role="tab" aria-controls="nav-contact" aria-selected="false">Technology</a> --}}
                                </div>
                            </nav>
                            <!--End Nav Button  -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- Nav Card -->
                        <div class="tab-content" id="nav-tabContent">
                            <!-- card one -->
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="whats-news-caption">
                                    <div class="row">
                                        @if (count($categoryallnews) == 0)
                                                            <div class="col-lg-12 text-center">
                                                                <h4>No news</h4>
                                                            </div>
                                                        @endif
                                        @foreach ($categoryallnews as $news)
                                            <div class="col-lg-6 col-md-6">
                                                <div class="single-what-news mb-100">
                                                    <div class="what-img">
                                                        @php
                                                            $category = DB::table('categories')->where('id', $news->category_id[0])->first();
                                                        @endphp
                                                        <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $news->slug])}}"><img src="{{Storage::disk('uploads')->url($news->image)}}" alt="{{$news->title}}"></a>
                                                    </div>
                                                    <div class="what-cap">

                                                        @foreach ($news->category_id as $category)
                                                            @php
                                                                $categories_name = DB::table('categories')->where('id', $category)->first();
                                                            @endphp

                                                            <span class="color1">{{$categories_name->title}}</span>
                                                        @endforeach
                                                        <h4><a href="{{route('page.news', ['categoryslug' => $categories_name->slug, 'slug' => $news->slug])}}">{{$news->title}}</a></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @foreach ($downmenucategories as $category)
                                <div class="tab-pane fade" id="nav-{{$category['slug']}}" role="tabpanel" aria-labelledby="nav-{{$category['slug']}}-tab">
                                    <div class="whats-news-caption">
                                        <div class="row">
                                            @php
                                                $categoryrelatednews = [];
                                                foreach($allthenews as $newsitemcategory) {
                                                    if(in_array($category['id'], $newsitemcategory->category_id )) {
                                                        array_push($categoryrelatednews, $newsitemcategory);
                                                        if(count($categoryrelatednews) == 4){
                                                            break;
                                                        }
                                                    }
                                                }
                                                // dd($categoryrelatednews);
                                            @endphp
                                            @if (count($categoryrelatednews) == 0)
                                                <div class="col-lg-12 text-center">
                                                    <h4>No news under "{{$category['title']}}"</h4>
                                                </div>
                                            @else
                                                @foreach ($categoryrelatednews as $news)
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="single-what-news mb-100">
                                                            <div class="what-img">
                                                                @php
                                                                    $requiredcategory = DB::table('categories')->where('id', $news->category_id[0])->first();
                                                                @endphp
                                                                <a href="{{route('page.news', ['categoryslug' => $requiredcategory->slug, 'slug' => $news->slug])}}"><img src="{{Storage::disk('uploads')->url($news->image)}}" alt="{{$news->title}}"></a>
                                                            </div>
                                                            <div class="what-cap">
                                                                @foreach ($news->category_id as $thiscategory)
                                                                    @php
                                                                        $categories_name = DB::table('categories')->where('id', $thiscategory)->first();
                                                                    @endphp

                                                                    <span class="color1">{{$categories_name->title}}</span>
                                                                @endforeach
                                                                <h4><a href="{{route('page.news', ['categoryslug' => $categories_name->slug, 'slug' => $news->slug])}}">{{$news->title}}</a></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    <!-- End Nav Card -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4 bg-white pt-3">
                <!-- Section Tittle -->
                <div class="section-tittle mb-2 text-center">
                    <h3>हामीलाई पछ्याउनुहोस</h3>
                    <div class="fb-page"
                            data-href="https://www.facebook.com/Hambalnews-104095081894740/"
                            data-tabs=""
                            data-width="300"
                            data-height=""
                            data-small-header="true"
                            data-adapt-container-width="false"
                            data-hide-cover="true"
                            data-show-facepile="false">
                                <blockquote cite="https://www.facebook.com/Hambalnews-104095081894740/"
                                    class="fb-xfbml-parse-ignore">
                                </blockquote>
                        </div>
                </div>

                <div class="news-poster d-lg-block mt-5 owl-ad owl-carousel owl-theme">
                    @foreach ($sidebar_advertisement as $advertisement)
                        <div class="item">
                            <a href="{{$advertisement->link}}" target="_blank"><img src="{{Storage::disk('uploads')->url($advertisement->imagename)}}" alt="" style="max-height: 670px;"></a>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>
        </div>
    </section>
    <!-- Whats New End -->
    <!--   Weekly2-News start -->
    <div class="weekly2-news-area  weekly2-pading">
        <div class="container">
            <div class="weekly2-wrapper pb-5">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>प्रचलन समाचार</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="weekly2-news-active dot-style d-flex dot-style">
                            @foreach ($trendingnewsall as $news)
                                <div class="weekly2-single">
                                    <div class="weekly2-img">
                                        @php
                                            $category = DB::table('categories')->where('id', $news->category_id[0])->first();

                                        @endphp
                                        <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $news->slug])}}"><img src="{{Storage::disk('uploads')->url($news->image)}}" alt="{{$news->title}}"></a>
                                    </div>
                                    <div class="weekly2-caption">
                                        @foreach ($news->category_id as $category)
                                            @php
                                                $categories_name = DB::table('categories')->where('id', $category)->first();
                                            @endphp

                                            <span class="color1">{{$categories_name->title}}</span>
                                        @endforeach

                                        <h4><a href="{{route('page.news', ['categoryslug' => $categories_name->slug, 'slug' => $news->slug])}}">{{$news->title}}</a></h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="recent-articles area-lightgrey py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center owl-ad owl-carousel owl-theme">
                    @foreach ($bottom_advertisement as $advertisement)
                        <div class="item">
                            <a href="{{$advertisement->link}}" target="_blank"><img src="{{Storage::disk('uploads')->url($advertisement->imagename)}}" alt="" class="img-fluid" style="max-height: 550px;"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container bg-white mt-3">
           <div class="recent-wrapper pt-3">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>भर्खरको लेखहरू</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="recent-active dot-style d-flex dot-style">
                            @foreach ($recentnews as $news)
                                <div class="single-recent mb-100">
                                    <div class="what-img">
                                        @php
                                            $category = DB::table('categories')->where('id', $news->category_id[0])->first();
                                        @endphp
                                        <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $news->slug])}}"><img src="{{Storage::disk('uploads')->url($news->image)}}" alt="{{$news->title}}"></a>
                                    </div>
                                    <div class="what-cap">
                                        @foreach ($news->category_id as $category)
                                            @php
                                                $categories_name = DB::table('categories')->where('id', $category)->first();
                                            @endphp

                                            <span class="color1">{{$categories_name->title}}</span>
                                        @endforeach
                                        <h6><a href="{{route('page.news', ['categoryslug' => $categories_name->slug, 'slug' => $news->slug])}}">{{$news->title}}</a></h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
    <!--Start pagination -->
    {{-- <div class="pagination-area pb-45 text-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="single-wrap d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-start">
                              <li class="page-item"><a class="page-link" href="#"><span class="flaticon-arrow roted"></span></a></li>
                                <li class="page-item active"><a class="page-link" href="#">01</a></li>
                                <li class="page-item"><a class="page-link" href="#">02</a></li>
                                <li class="page-item"><a class="page-link" href="#">03</a></li>
                              <li class="page-item"><a class="page-link" href="#"><span class="flaticon-arrow right-arrow"></span></a></li>
                            </ul>
                          </nav>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End pagination  -->
    </main>
@endsection
