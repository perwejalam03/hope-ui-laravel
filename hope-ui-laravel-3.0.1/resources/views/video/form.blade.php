<x-app-layout :assets="$assets ?? []">
    <div>
        <?php
            $id = $id ?? null;
        ?>
        @if(isset($id))
        {!! Form::model($data, ['route' => ['videos.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
        @else
        {!! Form::open(['route' => ['videos.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{$id !== null ? 'Update' : 'New' }} Video Information</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{route('videos.index')}}" class="btn btn-sm btn-primary" role="button">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="status">Status: <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control">
                                            <option value="public" {{ old('status', $data->status ?? '') === 'public' ? 'selected' : '' }}>Public</option>
                                            <option value="private" {{ old('status', $data->status ?? '') === 'private' ? 'selected' : '' }}>Private</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="title">Title: <span class="text-danger">*</span></label>
                                    {{ Form::text('title', old('title', $data->title ?? ''), ['class' => 'form-control', 'placeholder' => 'title' ,'required']) }}
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="category">Category: <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category', $data->category ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="thumbnail">Thumbnail: <span class="text-danger">*</span></label>
                                    {{ Form::text('thumbnail', old('thumbnail', $data->thumbnail ?? ''), ['class' => 'form-control','required']) }}
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="description">Description: <span class="text-danger">*</span></label>
                                    {{ Form::text('description', old('description', $data->description ?? ''), ['class' => 'form-control','required']) }}
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="media">Media: <span class="text-danger">*</span></label>
                                    {{ Form::file('media', old('media'), ['class' => 'form-control','required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{$id !== null ? 'Update' : 'Add' }} Video</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</x-app-layout>
