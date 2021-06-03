@extends('frontend.layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset('backend/nepdatepicker/css/nepali.datepicker.v3.2.min.css')}}">
@endpush
@section('content')
<main>
    <!-- Whats New Start -->
     <section class="whats-news-area pt-50 pb-20 area-lightgrey">
         <div class="container">

            <div class="row">
                <div class="col-lg-8 bg-white pt-3">
                    <div class="about-right mb-90">
                        <div class="section-tittle mb-30 pt-30">
                            @foreach ($news->category_id as $category)
                                @php
                                    $categories_name = DB::table('categories')->where('id', $category)->first();
                                    $date = $news->created_at;
                                    $reqdate = explode(" ", $date);
                                @endphp

                                <a href="{{route('page.category', $categories_name->slug)}}"><span class="badge bg-success" style="font-size:15px; color: white;padding:10px;"> {{$categories_name->title}}</span></a>
                            @endforeach
                            <h1 class="mt-3" style="color: #002e5b">{{$news->title}}</h1>
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($news->author == null)
                                        <p>प्रकाशित मिति: <span id="requireddate">{{date('F j, Y', strtotime($news->created_at))}}</span> (<i class="fas fa-eye"></i> {{$news->view_count}})</p>
                                    @else
                                        <p>लेखक: <a href="{{route('page.author', $news->author)}}"><span style="color: blue;">{{$news->author}}</span></a> | प्रकाशित मिति : <span id="requireddate">{{$news->created_at}}</span>  (<i class="fas fa-eye"></i> {{$news->view_count}})</p>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <a class="twitter-share-button"
                                        href="https://twitter.com/intent/tweet"
                                        data-layout="button"
                                        data-size="large">
                                        Tweet
                                    </a>
                                </div>
                                <div class="ml-2">

                                    <div class="fb-share-button"
                                    data-href="https://hambalnews.com/{{$categories_name->slug}}/{{$news->slug}}"
                                    data-layout="button"
                                    data-size="large">
                                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fhambalnews.com%2F%257Bcategoryslug%257D%2F%257Bslug%257D&amp;src=sdkpreparse"
                                        class="fb-xfbml-parse-ignore">
                                            Share
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="about-img">
                            <img class="img-fluid" src="{{Storage::disk('uploads')->url($news->image)}}" style="max-width: 100%; height:auto; border-radius:15px;" alt="{{$news->title}}">
                        </div>

                        <div class="about-prea mt-5">
                            <p class="about-pera1">{!! $news->details !!}</p>

                            <div class="blog_right_sidebar mt-2">
                                <aside class="single_sidebar_widget tag_cloud_widget text-center">
                                    <h4 class="widget_title">समाचार ट्यागहरू</h4>
                                    <ul class="list">
                                        @foreach ($tags as $tag)
                                            <li>
                                                <a href="{{route('page.tag', $tag->tags)}}">#{{$tag->tags}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>

             <div class="col-lg-4 bg-white pb-3">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget search_widget">
                        <form action="{{route('page.search')}}" method="GET">
                            @csrf
                            @method("GET")
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="word" placeholder='खोजी गर्नुहोस्'
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'खोजी गर्नुहोस्'">
                                    <div class="input-group-append">
                                        <button class="btns" type="submit" class="form-control"><i class="ti-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            {{-- <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">
                                Search
                            </button> --}}
                        </form>
                    </aside>

                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">समाचार कोटिहरू</h4>
                        <ul class="list cat-list">
                            @foreach ($requiredcategories as $category)
                                <li>
                                    <a href="{{route('page.category', $category->slug)}}" class="d-flex">
                                        <p>{{$category->title}}</p>
                                        <p>
                                            @php
                                                $count = 0;
                                                foreach ($allnews as $newsitem) {
                                                    if (in_array( $category->id, $newsitem->category_id)) {
                                                        $count = $count+1;
                                                    }
                                                }
                                            @endphp
                                            ({{$count}})
                                        </p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </aside>

                    <aside class="single_sidebar_widget popular_post_widget">
                        <h3 class="widget_title">ताजा समाचार</h3>
                        @foreach ($latestnews as $latestnewsitem)
                            <div class="media post_item">
                                @php
                                    $category = DB::table('categories')->where('id', $latestnewsitem->category_id[0])->first();
                                @endphp
                                <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $latestnewsitem->slug])}}"><img src="{{Storage::disk('uploads')->url($latestnewsitem->image)}}" alt="{{$latestnewsitem->title}}" style="max-height: 80px;"></a>
                                <div class="media-body">
                                    <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $latestnewsitem->slug])}}">
                                        <h3>{{$latestnewsitem->title}}</h3>
                                    </a>
                                    <p>{{$latestnewsitem->created_at->diffForHumans()}}</p>
                                </div>
                            </div>
                        @endforeach
                    </aside>

                    <!-- Section Tittle -->
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
                <!-- Flow Socail -->
                {{-- <div class="single-follow mb-45">
                    <div class="single-box">
                        <div class="follow-us d-flex align-items-center">
                            <div class="follow-social">
                                <a href="#"><img src="{{asset('frontend/assets/img/news/icon-fb')}}.png" alt=""></a>
                            </div>
                            <div class="follow-count">
                                <span>8,045</span>
                                <p>Fans</p>
                            </div>
                        </div>
                        <div class="follow-us d-flex align-items-center">
                            <div class="follow-social">
                                <a href="#"><img src="{{asset('frontend/assets/img/news/icon-tw')}}.png" alt=""></a>
                            </div>
                            <div class="follow-count">
                                <span>8,045</span>
                                <p>Fans</p>
                            </div>
                        </div>
                            <div class="follow-us d-flex align-items-center">
                            <div class="follow-social">
                                <a href="#"><img src="{{asset('frontend/assets/img/news/icon-ins')}}.png" alt=""></a>
                            </div>
                            <div class="follow-count">
                                <span>8,045</span>
                                <p>Fans</p>
                            </div>
                        </div>
                        <div class="follow-us d-flex align-items-center">
                            <div class="follow-social">
                                <a href="#"><img src="{{asset('frontend/assets/img/news/icon-yo')}}.png" alt=""></a>
                            </div>
                            <div class="follow-count">
                                <span>8,045</span>
                                <p>Fans</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- New Poster -->

                <div class="news-poster d-lg-block mt-5 owl-ad owl-carousel owl-theme">
                    @foreach ($sidebar_advertisement as $advertisement)
                        <div class="item">
                            <a href="{{$advertisement->link}}" target="_blank"><img src="{{Storage::disk('uploads')->url($advertisement->imagename)}}" alt="" style="max-height: 670px;"></a>
                        </div>
                    @endforeach
                </div>

                    <aside class="single_sidebar_widget popular_post_widget">
                        <h3 class="widget_title">लोकप्रिय समाचार</h3>
                        @foreach ($popularnews as $latestnewsitem)
                            <div class="media post_item">
                                @php
                                    $category = DB::table('categories')->where('id', $latestnewsitem->category_id[0])->first();
                                @endphp
                                <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $latestnewsitem->slug])}}"><img src="{{Storage::disk('uploads')->url($latestnewsitem->image)}}" alt="{{$latestnewsitem->title}}" style="max-height: 80px;"></a>
                                <div class="media-body">
                                    <a href="{{route('page.news', ['categoryslug' => $category->slug, 'slug' => $latestnewsitem->slug])}}">
                                        <h3>{{$latestnewsitem->title}}</h3>
                                    </a>
                                    <p>{{$latestnewsitem->created_at->diffForHumans()}}</p>
                                </div>
                            </div>
                        @endforeach
                    </aside>
                    {{-- <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title">Tag Clouds</h4>
                        <ul class="list">
                            @foreach ($tags as $tag)
                                <li>
                                    <a href="#">{{$tag->tags}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </aside> --}}


                    {{-- <aside class="single_sidebar_widget instagram_feeds">
                        <h4 class="widget_title">Instagram Feeds</h4>
                        <ul class="instagram_row flex-wrap">
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="assets/img/post/post_5.png" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="assets/img/post/post_6.png" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="assets/img/post/post_7.png" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="assets/img/post/post_8.png" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="assets/img/post/post_9.png" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="assets/img/post/post_10.png" alt="">
                                </a>
                            </li>
                        </ul>
                    </aside> --}}


                    {{-- <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">Newsletter</h4>

                        <form action="#">
                            <div class="form-group">
                                <input type="email" class="form-control" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter email'" placeholder='Enter email' required>
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                type="submit">Subscribe</button>
                        </form>
                    </aside> --}}
                </div>
             </div>
            </div>
         </div>
     </section>
     <!-- Whats New End -->

     <hr>
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
     <hr>

     <div class="weekly2-news-area  weekly2-pading pb-4 gray-bg">
        <div class="container">
            <div class="weekly2-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>सम्बन्धित समाचार</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="weekly2-news-active dot-style d-flex dot-style">
                            @foreach ($relatednewsitem as $news)
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
                                        <p>{{date('F j, Y', strtotime($news->created_at))}}</p>
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
     </main>
@endsection
@push('scripts')
    <script src="{{asset('backend/nepdatepicker/js/nepali.datepicker.v3.2.min.js')}}" type="text/javascript"></script>
    <script>
        var date = "{{$reqdate[0]}}";
        var engformat = NepaliFunctions.ConvertToDateObject(date, "YYYY-MM-DD");

        var nepformat = NepaliFunctions.AD2BS(engformat);
        var nepdate = NepaliFunctions.GetBsFullDate(nepformat, true);
        document.getElementById("requireddate").innerHTML = nepdate;
    </script>

@endpush
