@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Category</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('category.update', $category->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Include the form fields here, similar to your add category form -->
        <!-- {{csrf_field()}} -->
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <label for="full-name" class="form-label">Category Name</label>
                                    <input id="name"  name="category_name"  class="form-control" type="text" placeholder=" "  required autofocus >
                                 </div>
                              </div>
                             
                              <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status">
                                    <option value="option1">Public</option>
                                    <option value="option2">Private</option>
                                    </select>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input class="form-control" type="file" name="logo" placeholder=" ">
                                 </div>
                              </div>
                           <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary"> {{ __('add category') }}</button>
                           </div>
    </form>
</div>
@endsection
