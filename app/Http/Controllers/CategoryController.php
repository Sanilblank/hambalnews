<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\RolesPermission;
use App\Models\Setting;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        if (in_array(4, $rolespermission)) {
            if ($request->ajax()) {
                $data = Category::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function ($row) {
                        if ($row->image == 'post.jpg') {
                            $imagename = Storage::disk('uploads')->url('noimage.jpg');
                        } else {
                            $imagename = Storage::disk('uploads')->url($row->image);
                        }
                        $image = "<img src='$imagename' style='max-height: 100px;'>";
                        return $image;
                    })
                    ->addColumn('status', function ($row) {
                        $status = $row->status;
                        if ($status == 1) {
                            $status = "Approved";
                        } else {
                            $status = "Not Approved";
                        }
                        return $status;
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
                    ->addColumn('action', function ($row) {

                        $editurl = route('category.edit', $row->id);
                        $deleteurl = route('category.destroy', $row->id);

                        $csrf_token = csrf_token();

                        $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                                <form action='$deleteurl' method='POST' style='display:inline-block;'>
                                    <input type='hidden' name='_token' value='$csrf_token'>
                                    <input type='hidden' name='_method' value='DELETE' />
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>";
                        return $btn;
                    })
                    ->rawColumns(['image', 'status', 'featured', 'action'])
                    ->make(true);
            }
            $setting = Setting::first();
            return view('backend.categories.index', compact('setting'));
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
        if (in_array(4, $rolespermission)) {
            $setting = Setting::first();
            return view('backend.categories.create', compact('setting'));
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
        $data = $this->validate($request, [
            'title' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

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

        $path = $request->file('image')->store('category_images', 'uploads');

        $category = Category::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'image' => $path,
            'status' => $status,
            'featured' => $featured,
        ]);

        $category->save();

        return redirect()->route('category.index')->with('success', 'Category information saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(4, $rolespermission)) {
            $category = Category::findorFail($id);
            $setting = Setting::first();
            return view('backend.categories.edit', compact('category', 'setting'));
        } else {
            return view('backend.permissions.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $this->validate($request, [
            'title' => 'required',
        ]);

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
            Storage::disk('uploads')->delete($category->image);
            $imagename = $request->file('image')->store('category_images', 'uploads');
        } else {
            $imagename = $category->image;
        }

        $category->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'image' => $imagename,
            'status' => $status,
            'featured' => $featured,
        ]);

        return redirect()->route('category.index')->with('success', 'Category information updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(4, $rolespermission)) {
            $category = Category::findorFail($id);

            $subcategory = Subcategory::where('category_id', $id)->first();
            if($subcategory)
            {
                return redirect()->route('category.index')->with('failure', 'Category is used in Subcategory. Cannot delete.');
            }
            $news = News::get();
            if(count($news) > 0)
            {
                foreach ($news as $newsitem) {
                    if (in_array($category->id, $newsitem->category_id)) {
                        return redirect()->route('category.index')->with('failure', 'Category is used in News. Cannot delete.');
                    }
                }
            }

            Storage::disk('uploads')->delete($category->image);
            $category->delete();
            return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
        } else {
            return view('backend.permissions.permission');
        }
    }
}
