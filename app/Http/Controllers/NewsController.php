<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\NewsImage;
use App\Models\RolesPermission;
use App\Models\Seo;
use App\Models\Tags;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Notifications\NewsWasPublished;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(5, $rolespermission)) {
            if ($request->ajax()) {
                $data = News::latest()->where('draft', 0)->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category', function ($row) {
                        $categories = $row->category_id;
                        $categorys = '';
                        foreach ($categories as $category) {
                            $category_name = Category::where('id', $category)->first();
                            $categorys .= '<span class="badge bg-green">' . $category_name->title . '</span>' . ' ';
                        }
                        return $categorys;
                    })
                    ->addColumn('featured', function ($row) {
                        $featured = $row->featured;
                        if ($featured == 1) {
                            $featured = "Featured";
                        } else {
                            $featured = "Not Featured";
                        }
                        return $featured;
                    })
                    // ->addColumn('status', function ($row) {
                    //     $status = $row->status;
                    //     if ($status == 1) {
                    //         $status = "Approved";
                    //     } else {
                    //         $status = "Not Approved";
                    //     }
                    //     return $status;
                    // })

                    ->addColumn('is_trending', function ($row) {
                        $is_trending = $row->is_trending;
                        if ($is_trending == 1) {
                            $is_trending = "Trending";
                        } else {
                            $is_trending = "Not Trending";
                        }
                        return $is_trending;
                    })
                    ->addColumn('image', function ($row) {
                        if ($row->image == 'post.jpg') {
                            $imagename = Storage::disk('uploads')->url('noimage.jpg');
                        } else {
                            $imagename = Storage::disk('uploads')->url($row->image);
                        }
                        $image = "<img src='$imagename' style='max-height: 100px;'>";
                        return $image;
                    })
                    ->addColumn('action', function ($row) {

                        $editurl = route('news.edit', $row->id);
                        $deleteurl = route('news.destroy', $row->id);

                        $csrf_token = csrf_token();

                        $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm' style='margin-top: 3px;'>Edit</a>
                                <form action='$deleteurl' method='POST' style='display:inline-block; margin-top: 3px;'>
                                    <input type='hidden' name='_token' value='$csrf_token'>
                                    <input type='hidden' name='_method' value='DELETE' />
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>";
                        return $btn;
                    })
                    ->rawColumns(['status', 'featured', 'image', 'category', 'action'])
                    ->make(true);
            }
            $setting = Setting::first();
            return view('backend.news.index', compact('setting'));
        } else {
            return view('backend.permissions.permission');
        }
    }

    public function draftnews(Request $request)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(5, $rolespermission)) {
            if ($request->ajax()) {
                $data = News::latest()->where('draft', 1)->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category', function ($row) {
                        $categories = $row->category_id;
                        if($categories == null)
                        {
                            $categorys = "Empty";
                        }
                        else
                        {
                            $categorys = '';
                            foreach ($categories as $category) {
                                $category_name = Category::where('id', $category)->first();
                                $categorys .= '<span class="badge bg-green">' . $category_name->title . '</span>' . ' ';
                            }
                        }

                        return $categorys;
                    })

                    ->addColumn('featured', function ($row) {
                        $featured = $row->featured;
                        if ($featured == 1) {
                            $featured = "Featured";
                        } else {
                            $featured = "Not Featured";
                        }
                        return $featured;
                    })
                    // ->addColumn('status', function ($row) {
                    //     $status = $row->status;
                    //     if ($status == 1) {
                    //         $status = "Approved";
                    //     } else {
                    //         $status = "Not Approved";
                    //     }
                    //     return $status;
                    // })

                    ->addColumn('is_trending', function ($row) {
                        $is_trending = $row->is_trending;
                        if ($is_trending == 1) {
                            $is_trending = "Trending";
                        } else {
                            $is_trending = "Not Trending";
                        }
                        return $is_trending;
                    })
                    ->addColumn('image', function ($row) {
                        if ($row->image == null) {
                            $imagename = Storage::disk('uploads')->url('noimage.jpg');
                        } else {
                            $imagename = Storage::disk('uploads')->url($row->image);
                        }
                        $image = "<img src='$imagename' style='max-height: 100px;'>";
                        return $image;
                    })
                    ->addColumn('title', function ($row) {
                        if($row->title == null)
                        {
                            return 'Empty';
                        }
                        else
                        {
                            return $row->title;
                        }
                    })

                    ->addColumn('action', function ($row) {

                        $editurl = route('draftnews.edit', $row->id);
                        $deleteurl = route('draftnews.destroy', $row->id);

                        $csrf_token = csrf_token();

                        $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm' style='margin-top: 3px;'>Edit</a>
                                <form action='$deleteurl' method='POST' style='display:inline-block; margin-top: 3px;'>
                                    <input type='hidden' name='_token' value='$csrf_token'>
                                    <input type='hidden' name='_method' value='DELETE' />
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>";
                        return $btn;
                    })
                    ->rawColumns(['status', 'featured', 'image', 'category', 'action'])
                    ->make(true);
            }
            $setting = Setting::first();
            return view('backend.news.draftindex', compact('setting'));
        } else {
            return view('backend.permissions.permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(5, $rolespermission)) {
            $categories = Category::all();
            $subcategories = Subcategory::where('status', 1)->get();
            $images = NewsImage::where('news_id', 0)->get();
            $setting = Setting::first();
            return view('backend.news.create', compact('categories', 'images', 'setting', 'subcategories'));
        } else {
            return view('backend.permissions.permission');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $this->validate($request, [
                'file' => 'required|max:500'
            ]);
            $name = $request->file->store('newsdetails_images', 'uploads');
            $i = new NewsImage;
            $i->images = $name;
            $i->news_id = 1;
            $i->title = '';
            $i->save();

            return response()->json(['url' => Storage::disk('uploads')->url($name), 'id' => $i->id]);
        };


        if(empty($request['title']) || empty($request['image']) ||empty($request['category']) ||empty($request['details']) ||empty($request['seotitle']) ||empty($request['seodescription']) ||empty($request['tags']) || $request->has('draft'))
        {
            $draft = 1;
        }
        else
        {
            $draft = 0;
        }


        // $data = $this->validate($request, [
        //     'title' => 'required',
        //     'image' => 'mimes:jpg,jpeg,png',
        //     'category' => 'required',
        //     'details' => 'required',
        //     'tags' => 'required',
        //     'seotitle' => 'required',
        //     'seodescription' => 'required',
        // ]);

        if($request['subcategory'] != null)
        {
            foreach($request['subcategory'] as $sub)
            {
                $subcategory = Subcategory::where('id', $sub)->first();
                if(!in_array($subcategory->category_id, $request['category']))
                {
                    return redirect()->back()->with('failure', 'Subcategory does not exist in selected categories. Please check');
                }
            }
        }


        if(!empty($request['tags']))
        {
            $tags = explode(",", $request['tags']);
        }


        if (isset($request->status)) {
            $status = true;
        } else {
            $status = false;
        }

        if (isset($request->featured)) {
            $featured = true;
        } else {
            $featured = false;
        }

        if(!empty($request['image']))
        {
            $path = $request->file('image')->store('news_images', 'uploads');
        }
        else
        {
            $path = null;
        }

        $news = News::create([
            'title' => $request['title'],
            'author' => $request['author'],
            'slug' => Str::slug($request['title']),
            'image' => $path,
            'category_id' => $request['category'],
            'subcategory_id' => $request['subcategory'],
            'details' => $request['details'],
            'status' => $status,
            'featured' => $featured,
            'is_trending' => $request['trending'],
            'draft' => $draft,
        ]);

        $images = NewsImage::where('news_id', 1)->get();
        foreach ($images as $image) {
            $image->title = $request['title'];
            $image->news_id = $news['id'];
            $image->save();
        }

        if(!empty($request['tags']))
        {
            foreach ($tags as $tag) {
                $tag_info = Tags::create([
                    'news_id' => $news['id'],
                    'tags' => $tag,
                    'slug' => Str::slug($tag),
                ]);
                $tag_info->save();
            }
        }

        $news->save();

        if(!empty($request['seotitle']) && !empty($request['seodescription']))
        {
            $seo_info = Seo::create([
                'news_id' => $news['id'],
                'seotitle' => $request['seotitle'],
                'seodescription' => $request['seodescription'],
            ]);
            $seo_info->save();
        }


        if($draft == 0)
        {
            $category = Category::where('id', $news->category_id[0])->first();
            // $news->notify(new NewsWasPublished($news));
            FrontController::sendNews($news, $category);
            return redirect()->route('news.index')->with('success', 'News information saved successfully.');
        }
        else
        {
            return redirect()->route('news.index')->with('success', 'Some information was empty so, News information saved successfully as draft.');
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(5, $rolespermission)) {
            $news = News::findorfail($id);
            $categories = Category::all();
            $subcategories = Subcategory::where('status', 1)->get();
            $tags_info = Tags::where('news_id', $id)->get();
            $setting = Setting::first();
            $seo_info = Seo::where('news_id', $news->id)->first();
            $tags = '';
            foreach ($tags_info as $tag) {
                $tags .= $tag->tags . ',';
            }
            return view('backend.news.edit', compact('news', 'tags', 'categories', 'subcategories', 'seo_info', 'setting'));
        } else {
            return view('backend.permissions.permission');
        }
    }

    public function draftnewsedit($id)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(5, $rolespermission)) {
            $news = News::findorfail($id);
            $categories = Category::all();
            $subcategories = Subcategory::where('status', 1)->get();
            $tags_info = Tags::where('news_id', $id)->get();
            $setting = Setting::first();
            $seo_info = Seo::where('news_id', $news->id)->first();
            $tags = '';
            if(count($tags_info) > 0)
            {

                foreach ($tags_info as $tag) {
                    $tags .= $tag->tags . ',';
                }
            }


            return view('backend.news.draftedit', compact('news', 'tags', 'categories', 'subcategories', 'seo_info', 'setting'));
        } else {
            return view('backend.permissions.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function draftnewsupdate(Request $request, $id)
    {
        $news = News::findorfail($id);

        if(empty($request['title']) ||empty($request['category']) ||empty($request['details']) ||empty($request['seotitle']) ||empty($request['seodescription']) ||empty($request['tags']) || $request->has('draft'))
        {
            $draft = 1;
        }
        else
        {
            $draft = 0;
        }

        // $data = $this->validate($request, [
        //     'title' => 'required',
        //     'category' => 'required',
        //     'details' => 'required',
        //     'tags' => 'required',
        //     'seotitle' => 'required',
        //     'seodescription' => 'required'
        // ]);

        if($request['subcategory'] != null)
        {
            foreach($request['subcategory'] as $sub)
            {
                $subcategory = Subcategory::where('id', $sub)->first();
                if(!in_array($subcategory->category_id, $request['category']))
                {
                    return redirect()->back()->with('failure', 'Subcategory does not exist in selected categories. Please check');
                }
            }
        }

        if(!empty($request['tags']))
        {
            $tag_info = Tags::where('news_id', $news->id)->get();
            if(count($tag_info) > 0)
            {
                foreach ($tag_info as $tags) {
                    $tags->delete();
                }

            }
            $tags = explode(",", $request['tags']);
        }


        if (isset($request->status)) {
            $status = true;
        } else {
            $status = false;
        }

        if (isset($request->featured)) {
            $featured = true;
        } else {
            $featured = false;
        }

        $imagename = '';
        if ($request->hasFile('image')) {
            Storage::disk('uploads')->delete($news->image);
            $imagename = $request->file('image')->store('news_images', 'uploads');
        } else {
            $imagename = $news->image;
        }

        if($imagename == null)
        {
            $draft = 1;
        }

        $news->update([
            'title' => $request['title'],
            'author' => $request['author'],
            'slug' => Str::slug($request['title']),
            'image' => $imagename,
            'category_id' => $request['category'],
            'subcategory_id' => $request['subcategory'],
            'details' => $request['details'],
            'status' => $status,
            'featured' => $featured,
            'is_trending' => $request['trending'],
            'draft' => $draft,
        ]);

        if(!empty($request['tags']))
        {
            foreach ($tags as $tag) {
                $tag_info = Tags::create([
                    'news_id' => $news->id,
                    'tags' => $tag,
                    'slug' => Str::slug($tag),
                ]);
                $tag_info->save();
            }
        }
        if(!empty($request['seotitle']) && !empty($request['seodescription']))
        {
            $seo_info = Seo::where('news_id', $news->id)->first();
            if($seo_info)
            {
                $seo_info->update([
                    'seotitle' => $request['seotitle'],
                    'seodescription' => $request['seodescription'],
                ]);
            }
            else
            {
                $seoinfo = Seo::create([
                    'news_id' => $news->id,
                    'seotitle' => $request['seotitle'],
                    'seodescription' => $request['seodescription'],
                ]);
                $seoinfo->save();
            }

        }

        if($draft == 0)
        {
            $category = Category::where('id', $news->category_id[0])->first();
            // $news->notify(new NewsWasPublished($news));
            FrontController::sendNews($news, $category);
            return redirect()->route('draftnews.index')->with('success', 'News information updated successfully as non draft.');
        }
        else
        {
            return redirect()->route('draftnews.index')->with('success', 'Some fields were empty so, News information updated as draft.');

        }

    }

    public function update(Request $request, News $news)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'details' => 'required',
            'tags' => 'required',
            'seotitle' => 'required',
            'seodescription' => 'required'
        ]);

        if($request['subcategory'] != null)
        {
            foreach($request['subcategory'] as $sub)
            {
                $subcategory = Subcategory::where('id', $sub)->first();
                if(!in_array($subcategory->category_id, $data['category']))
                {
                    return redirect()->back()->with('failure', 'Subcategory does not exist in selected categories. Please check');
                }
            }
        }

        $tag_info = Tags::where('news_id', $news['id'])->get();
        foreach ($tag_info as $tags) {
            $tags->delete();
        }

        $tags = explode(",", $request['tags']);

        if (isset($request->status)) {
            $status = true;
        } else {
            $status = false;
        }

        if (isset($request->featured)) {
            $featured = true;
        } else {
            $featured = false;
        }

        $imagename = '';
        if ($request->hasFile('image')) {
            Storage::disk('uploads')->delete($news->image);
            $imagename = $request->file('image')->store('news_images', 'uploads');
        } else {
            $imagename = $news->image;
        }

        $news->update([
            'title' => $data['title'],
            'author' => $request['author'],
            'slug' => Str::slug($data['title']),
            'image' => $imagename,
            'category_id' => $data['category'],
            'subcategory_id' => $request['subcategory'],
            'details' => $data['details'],
            'status' => $status,
            'featured' => $featured,
            'is_trending' => $request['trending']
        ]);

        foreach ($tags as $tag) {
            $tag_info = Tags::create([
                'news_id' => $news['id'],
                'tags' => $tag,
                'slug' => Str::slug($tag),
            ]);
            $tag_info->save();
        }

        $seo_info = Seo::where('news_id', $news['id'])->first();
        $seo_info->update([
            'seotitle' => $data['seotitle'],
            'seodescription' => $data['seodescription'],
        ]);

        return redirect()->route('news.index')->with('success', 'News information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(5, $rolespermission)) {
            $news = News::findorFail($id);
            Storage::disk('uploads')->delete($news->image);
            $tags = Tags::where('news_id', $news->id)->get();
            foreach ($tags as $tag) {
                $tag->delete();
            }
            $seo_info = Seo::where('news_id', $news->id)->first();
            $seo_info->delete();
            $news->delete();
            return redirect()->back()->with('success', 'News information deleted successfully.');
        } else {
            return view('backend.permissions.permission');
        }
    }

    public function draftnewsdestroy($id)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(5, $rolespermission)) {
            $news = News::findorFail($id);
            Storage::disk('uploads')->delete($news->image);
            $tags = Tags::where('news_id', $news->id)->get();
            if(count($tags) > 0)
            {
                foreach ($tags as $tag) {
                    $tag->delete();
                }
            }

            $seo_info = Seo::where('news_id', $news->id)->first();
            if($seo_info)
            {
                $seo_info->delete();
            }
            $news->delete();
            return redirect()->back()->with('success', 'Draft deleted successfully.');
        } else {
            return view('backend.permissions.permission');
        }
    }
}
