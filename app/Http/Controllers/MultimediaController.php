<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use App\Models\RolesPermission;
use App\Models\Setting;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class MultimediaController extends Controller
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
        if (in_array(6, $rolespermission)) {
            if ($request->ajax()) {

                $data = Multimedia::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $editurl = route('multimedia.edit', $row->id);
                        $deleteurl = route('multimedia.destroy', $row->id);

                        $csrf_token = csrf_token();

                        $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                                <form action='$deleteurl' method='POST' style='display:inline-block;'>
                                    <input type='hidden' name='_token' value='$csrf_token'>
                                    <input type='hidden' name='_method' value='DELETE' />
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            $setting = Setting::first();
            return view('backend.multimedia.index', compact('setting'));
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
        if (in_array(6, $rolespermission)) {
            $setting = Setting::first();
            return view('backend.multimedia.create', compact('setting'));
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
            'link' => 'required',
        ]);

        $multimedia = Multimedia::create([
            'title' => $data['title'],
            'link' => $data['link'],
        ]);

        $multimedia->save();
        return redirect()->route('multimedia.index')->with('success', 'Multimedia has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Multimedia  $multimedia
     * @return \Illuminate\Http\Response
     */
    public function show(Multimedia $multimedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Multimedia  $multimedia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(6, $rolespermission)) {
            $multimedia = Multimedia::findorFail($id);
            $setting = Setting::first();
            return view('backend.multimedia.edit', compact('multimedia', 'setting'));
        } else {
            return view('backend.permissions.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Multimedia  $multimedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Multimedia $multimedia)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'link' => 'required',
        ]);

        $multimedia->update([
            'title' => $data['title'],
            'link' => $data['link'],
        ]);

        return redirect()->route('multimedia.index')->with('success', 'Multimedia information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Multimedia  $multimedia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roles_permission = RolesPermission::where('role_id', Auth::user()->role_id)->get();
        $rolespermission = [];
        foreach ($roles_permission as $rolepermission) {
            array_push($rolespermission, $rolepermission->permission_id);
        }
        if (in_array(6, $rolespermission)) {
            $multimedia = Multimedia::findorFail($id);
            $multimedia->delete();
            return redirect()->back()->with('success', 'Multimedia information deleted successfully.');
        } else {
            return view('backend.permissions.permission');
        }
    }
}
