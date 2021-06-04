@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success' )}}</div>
    @endif
    @if(session()->has('failure'))
        <div class="alert alert-danger">{{ session('failure' )}}</div>
    @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <section class="col-lg-12 connectedSortable mt-3">
                            <h1 class="text-center">{{$setting->sitename}}</h1>
                            <p class="text-center">{{date('F j, Y')}}</p>
                        </section>
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-3">
                                    <div class="metric">
                                        <div class="row">
                                                <div class="col-md-12">

                                                    <p class="h5 text-center">User Shortcuts</p>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-3">

                                            <div class="col-md-12">
                                                   <a href="{{route('user.index')}}"> <span class="icon" style="background-color: red;"><i class="fa fa-eye"></i></span>
                                                <p>
                                                    <span class="title" style="color:black;">View All Users</span>
                                                </p></a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                    <a href="{{route('user.create')}}"><span class="icon" style="background-color: green;"><i class="fa fa-plus"></i></span>
                                                <p>
                                                    <span class="title" style="color:black;">Create New User</span>
                                                </p></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <div class="row">
                                                <div class="col-md-12">

                                                    <p class="h5 text-center">Category Shortcuts</p>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-3">

                                            <div class="col-md-12">
                                                   <a href="{{route('category.index')}}"> <span class="icon" style="background-color: red;"><i class="fa fa-eye"></i></span>
                                                <p>
                                                    <span class="title" style="color:black;">View All Categories</span>
                                                </p></a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                    <a href="{{route('category.create')}}"><span class="icon" style="background-color: green;"><i class="fa fa-plus"></i></span>
                                                <p>
                                                    <span class="title" style="color:black;">Create New Category</span>
                                                </p></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <div class="row">
                                                <div class="col-md-12">

                                                    <p class="h5 text-center">News Shortcuts</p>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-3">

                                            <div class="col-md-12">
                                                   <a href="{{route('news.index')}}"> <span class="icon" style="background-color: red;"><i class="fa fa-eye"></i></span>
                                                <p>
                                                    <span class="title" style="color:black;">View All News</span>
                                                </p></a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                    <a href="{{route('news.create')}}"><span class="icon" style="background-color: green;"><i class="fa fa-plus"></i></span>
                                                <p>
                                                    <span class="title" style="color:black;">Create New News</span>
                                                </p></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <div class="row">
                                                <div class="col-md-12">

                                                    <p class="h5 text-center">Multimedia Shortcuts</p>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-3">

                                            <div class="col-md-12">
                                                   <a href="{{route('multimedia.index')}}"> <span class="icon" style="background-color: red;"><i class="fa fa-eye"></i></span>
                                                <p>
                                                    <span class="title" style="color:black;">View All Multimedia</span>
                                                </p></a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                    <a href="{{route('multimedia.create')}}"><span class="icon" style="background-color: green;"><i class="fa fa-plus"></i></span>
                                                <p>
                                                    <span class="title" style="color:black;">Create New Multimedia</span>
                                                </p></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>




                        </div>
                    </div>


                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-newspaper"></i></span>
                                        <p>
                                            <span class="number">{{$totalnews->count()}}</span>
                                            <span class="title">Total News</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-user"></i></span>
                                        <p>
                                            <span class="number">{{$totalsubscribers->count()}}</span>
                                            <span class="title">Total Subscribers</span>
                                        </p>
                                    </div>
                                </div>
                            <div class="col-md-4">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-eye"></i></span>
                                    <p>
                                        <span class="number">{{$total_views}}</span>
                                        <span class="title">Total Views Count</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!--END OVERVIEW -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Latest 10 News</h2>
                    </div>
                    <div class="card-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">News Id</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Trending</th>
                                        <th class="text-center">View Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($news->count() == 0)
                                        <tr>
                                            <td colspan="5">There are no news yet.</td>
                                        </tr>
                                    @else
                                        @foreach ($news as $newsitem)
                                            <tr>
                                                <td>{{$newsitem->id}}</td>
                                                <td>
                                                    <img src="{{Storage::disk('uploads')->url($newsitem->image)}}" alt="{{$newsitem->title}}" style="max-height: 100px;">
                                                </td>
                                                <td>
                                                    {{$newsitem->title}}
                                                </td>
                                                <td>
                                                    @php
                                                        foreach ($newsitem->category_id as $category) {
                                                            $categories = DB::table('categories')->where('id', $category)->first();
                                                            echo '<span class="badge bg-green">'.$categories->title.'</span> ';
                                                        }
                                                    @endphp
                                                </td>
                                                <td>
                                                    @if ($newsitem->is_trending == 1)
                                                        Trending
                                                    @else
                                                        Not Trending
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$newsitem->view_count}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-right"><a href="{{route('news.index')}}" class="btn btn-primary">View All News</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Latest 10 Drafts</h2>
                    </div>
                    <div class="card-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">News Id</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center" colspan="2">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($draftnews->count() == 0)
                                        <tr>
                                            <td colspan="5">There are no drafts yet.</td>
                                        </tr>
                                    @else
                                        @foreach ($draftnews as $draftnewsitem)
                                            <tr>
                                                <td>{{$draftnewsitem->id}}</td>
                                                <td>
                                                    @if ($draftnewsitem->image == null)
                                                        <img src="{{Storage::disk('uploads')->url('noimage.jpg')}}" alt="{{$draftnewsitem->title}}" style="max-height: 100px;">
                                                    @else
                                                        <img src="{{Storage::disk('uploads')->url($draftnewsitem->image)}}" alt="{{$draftnewsitem->title}}" style="max-height: 100px;">
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($draftnewsitem->title == null)
                                                        No title
                                                    @else
                                                        {{$draftnewsitem->title}}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($draftnewsitem->category_id == null)
                                                        No Category
                                                    @else
                                                        @php
                                                            foreach ($draftnewsitem->category_id as $category) {
                                                                $categories = DB::table('categories')->where('id', $category)->first();
                                                                echo '<span class="badge bg-green">'.$categories->title.'</span> ';
                                                            }
                                                        @endphp
                                                    @endif

                                                </td>
                                                <td>
                                                    <a href={{route('draftnews.edit', $draftnewsitem->id)}} class='edit btn btn-primary btn-sm px-3' style='margin-top: 3px;'>Edit</a>

                                                    <form action={{route('draftnews.destroy', $draftnewsitem->id)}} method='POST' style='display:inline-block; margin-top: 3px;'>
                                                        @csrf
                                                        @method('DELETE')
                                                            <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-right"><a href="{{route('news.index')}}" class="btn btn-primary">View All News</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Last 10 Subscribers</h2>
                    </div>
                    <div class="card-body no-padding table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Subscriber Email</th>
                                    <th class="text-center">Subscribed Date</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($subscribers->count() == 0)
                                    <tr>
                                        <td colspan="5">There are no subscribers yet.</td>
                                    </tr>
                                @else
                                    @foreach ($subscribers as $subscriber)
                                        <tr>
                                            <td>
                                                {{$subscriber->email}}
                                            </td>
                                            <td>
                                                {{date('F j, Y', strtotime($subscriber->created_at))}}
                                            </td>
                                            <td>
                                                @if ($subscriber->is_verified == 0)
                                                    <span class="badge bg-yellow" style="font-size: 12px;">Not verified</span>
                                                @else
                                                    <span class="badge bg-green" style="font-size: 12px;">Verified</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-right"><a href="{{route('subscriber.index')}}" class="btn btn-primary">View All Subscribers</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
