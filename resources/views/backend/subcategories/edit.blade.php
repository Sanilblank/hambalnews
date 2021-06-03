@extends('backend.layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <a href="{{route('subcategory.index')}}" class="btn btn-danger mt-3">Back</a>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Edit Subcategory => {{$subcategory->title}} </h2>
                    </div>

                    <div class="card-body">
                        <form action="{{route('subcategory.update', $subcategory->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="Title">Title</label>
                                <input type="text" name="title" class="form-control {{($errors->any() && $errors->first('title')) ? 'is-invalid' : ''}}" value="{{old('title', $subcategory->title) }}" placeholder="Subcategory Title">
                                @if($errors->any())
									<p class="invalid-feedback">{{$errors->first('title')}}</p>
								@endif
                            </div>

                            <div class="form-group">
                                <label for="Image">Select an image</label>
                                <input type="file" name="image" class="form-control {{($errors->any() && $errors->first('image')) ? 'is-invalid' : ''}}">
                                <div class="text-danger">Note*: Dont select new image if you want previous image.</div>
                                @if($errors->any())
									<p class="invalid-feedback">{{$errors->first('image')}}</p>
								@endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="status" value="1"
                                        {{ ($subcategory->status == 1 ? 'checked' : '')}}>
                                        <label for="Status">Status</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="featured" class="form-check-input" value="1"
                                        {{ ($subcategory->featured == 1 ? 'checked' : '')}}>
                                        <label for="Featured">Featured</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
