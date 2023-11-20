<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\VideoDataTable;
use App\Models\Video;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\VideoRequest;
use App\Models\Category;
use File;
class VideoController extends Controller
{
    public function index(VideoDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('users.title2')] );
        $auth_category = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('videos.create').'" class="btn btn-sm btn-primary" role="button">Add Video</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_category','assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = Role::where('status',1)->get()->pluck('title', 'id');
        $categories = Category::all();

        // return view('your.view', compact('categories'));
        
        return view('video.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $existingVideo = Video::where('title', $request->input('title'))->first();
        if ($existingVideo) {
            return redirect()->back()->with('error', 'This title is already registered. Please choose a different one.');
        } else {
            $cp_id = "TXTSDP" . random_int(1, 9999);
            $request['cp_id'] = $cp_id;
    
            $media = $request->file('media');
            if (!empty($media) && in_array($media->getClientOriginalExtension(), ['mp4','MP4', 'mkv','MKV' ,'3gp','3GP','WEBM', 'webm'])) {
                $filename = $media->getClientOriginalName();
                $name = Category::where('id', $request->category)->first();
                $uploadpath = 'uploads' . '/' . $name->name;
                $media->move($uploadpath, $filename);
                Video::create(array_merge($request->except('media'), ['media' => $filename]));
            } else {
                return redirect()->back()->with('error', 'Media file is required, and it must be in MP4, MKV, 3GP, or WEBM format.');
            }
    
            return redirect()->route('videos.index')->withSuccess(__('message.msg_added', ['name' => __('video')]));
        }
    }
    

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $categories = Category::all();
        $data = Video::findOrFail($id);
        return view('video.form',compact('data', 'categories','id'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

     public function update(Request $request, $id)
     {
         $video = Video::findOrFail($id);
         $oldCategory = Category::where('id', $video->category)->first();
         $media = $request->file('media');
         if (!empty($media)) {
             $filename = $media->getClientOriginalName();
             $oldCategoryFolder = 'uploads/' . $oldCategory->name;
             $oldFilePath = $oldCategoryFolder . '/' . $video->media;
             if (file_exists($oldFilePath)) {
                 unlink($oldFilePath);
             }
                $newCategory = Category::where('id', $request->category)->first();
                $newCategoryFolder = 'uploads/' . $newCategory->name;
                $media->move($newCategoryFolder, $filename);
                $video->category = $request->category;
                $video->media = $filename;
        }
            $video->fill($request->only(['title', 'thumbnail', 'description', 'status']));
            $video->save();
            return redirect()->route('videos.index')->withSuccess(__('message.msg_updated', ['name' => __('video')]));
     }
     
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $status = 'errors';
        $message = __('global-message.delete_form', ['form' => __('users.title2')]);

        if (!empty($video)) {
            $category = Category::where('id', $video->category)->first();
            $filePath = 'uploads/' . $category->name . '/' . $video->media;

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $video->delete();
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => __('users.title2')]);
        }

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);
    }
}

