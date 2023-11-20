<x-app-layout :assets="$assets ?? []">
   <div>
      <?php
         $id = $id ?? null;
      ?>
      @if(isset($id))
      {!! Form::model($data, ['route' => ['categories.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
      @else
      {!! Form::open(['route' => ['categories.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      @endif
      <div class="row">
         <div class="col-xl-3 col-lg-4">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{$id !== null ? 'Update' : 'Add' }} Category</h4>
                  </div>
               </div>
               <div class="card-body">
                     <div class="form-group">
                        <div class="profile-img-edit position-relative">
                        <img src="{{ $profileImage ?? asset('images/avatars/01.png')}}" alt="Category-Profile" class="profile-pic rounded avatar-100">
                           <div class="upload-icone bg-primary">
                              <svg class="upload-button" width="14" height="14" viewBox="0 0 24 24">
                                 <path fill="#ffffff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                              </svg>
                              <input class="file-upload" type="file" accept="image/*" name="logo">
                           </div>
                        </div>
                        <div class="img-extension mt-3">
                           <div class="d-inline-block align-items-center">
                              <span>Only</span>
                              <a href="javascript:void();">.jpg</a>
                              <a href="javascript:void();">.png</a>
                              <a href="javascript:void();">.jpeg</a>
                              <span>allowed</span>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="form-label">Status:</label>
                        <div class="grid" style="--bs-gap: 1rem">
                            <div class="form-check g-col-6">
                                {{ Form::radio('status', 'public',old('status') || true, ['class' => 'form-check-input', 'id' => 'status-public']) }}
                                <label class="form-check-label" for="status-public">
                                    Public
                                </label>
                            </div>
                            <div class="form-check g-col-6">
                                {{ Form::radio('status', 'private',old('status'), ['class' => 'form-check-input', 'id' => 'status-private']) }}
                                <label class="form-check-label" for="status-private">
                                    Private
                                </label>
                            </div>
                        </div>
                     </div>
               </div>
            </div>
         </div>
         <div class="col-xl-9 col-lg-8">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{$id !== null ? 'Update' : 'New' }} Category Information</h4>
                  </div>
                  <div class="card-action">
                        <a href="{{route('categories.index')}}" class="btn btn-sm btn-primary" role="button">Back</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-user-info">
                        <div class="row">
                           
                           <div class="form-group col-md-6">
                              <label class="form-label" for="name">Category Name: <span class="text-danger">*</span></label>
                              {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name' ,'required']) }}
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-label" for="logo">Logo: <span class="text-danger">*</span></label>
                              {{ Form::file('logo', old('logo'), ['class' => 'form-control','required']) }}
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-label" for="thumbnail">Thumbnail: <span class="text-danger">*</span></label>
                              {{ Form::text('thumbnail', old('thumbnail'), ['class' => 'form-control','required']) }}
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-label" for="description">Description: <span class="text-danger">*</span></label>
                              {{ Form::textarea('description', old('description'), ['class' => 'form-control','required']) }}
                           </div>
                          
                        </div>
                        
                        </div>
                        <button type="submit" class="btn btn-primary">{{$id !== null ? 'Update' : 'Add' }} Category</button>
                  </div>
               </div>
            </div>
         </div>
        </div>
        {!! Form::close() !!}
   </div>
</x-app-layout>
