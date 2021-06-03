<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\RolesPermission;
use App\Models\Setting;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(10, $rolespermission)) {

            if ($request->ajax()) {
                $data = Subcategory::latest()->get();
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
                    ->addColumn('category_id', function ($row) {

                        return $row->category->title;
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

                        $editurl = route('subcategory.edit', $row->id);
                        $deleteurl = route('subcategory.destroy', $row->id);

                        $csrf_token = csrf_token();

                        $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                                <form action='$deleteurl' method='POST' style='display:inline-block;'>
                                    <input type='hidden' name='_token' value='$csrf_token'>
                                    <input type='hidden' name='_method' value='DELETE' />
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>";
                        return $btn;
                    })
                    ->rawColumns(['image', 'category_id', 'status', 'featured', 'action'])
                    ->make(true);
            }
            $setting = Setting::first();
            $categories = Category::where('status', 1)->get();
            return view('backend.subcategories.index', compact('setting', 'categories'));

        } else {
            return view('backend.permissions.permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(10, $rolespermission)) {

            $data = $this->validate($request, [
                'category_id' => 'required',
            ]);

            $setting = Setting::first();
            $category = Category::findorfail($data['category_id']);
            return view('backend.subcategories.create', compact('category', 'setting'));

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
        //
        $data = $this->validate($request, [
            'category_id' => 'required',
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

        $path = $request->file('image')->store('subcategory_images', 'uploads');

        $category = Subcategory::create([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'image' => $path,
            'status' => $status,
            'featured' => $featured,
        ]);

        $category->save();

        return redirect()->route('subcategory.index')->with('success', 'Subcategory information saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(10, $rolespermission)) {



            $setting = Setting::first();
            $subcategory = Subcategory::findorfail($id);
            return view('backend.subcategories.edit', compact('subcategory', 'setting'));

        } else {
            return view('backend.permissions.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        //
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
            Storage::disk('uploads')->delete($subcategory->image);
            $imagename = $request->file('image')->store('subcategory_images', 'uploads');
        } else {
            $imagename = $subcategory->image;
        }

        $subcategory->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'image' => $imagename,
            'status' => $status,
            'featured' => $featured,
        ]);

        return redirect()->route('subcategory.index')->with('success', 'Subcategory information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(10, $rolespermission)) {
            $subcategory = Subcategory::findorFail($id);

            $news = News::get();
            foreach ($news as $newsitem) {
                if($newsitem->subcategory_id != null)
                {
                    if (in_array($subcategory->id, $newsitem->subcategory_id)) {
                        return redirect()->route('subcategory.index')->with('failure', 'Subcategory is used in News. Cannot delete.');
                    }
                }
            }
            Storage::disk('uploads')->delete($subcategory->image);
                        $subcategory->delete();
                        return redirect()->route('subcategory.index')->with('success', 'Subategory deleted successfully.');
        } else {
            return view('backend.permissions.permission');
        }
    }
}
