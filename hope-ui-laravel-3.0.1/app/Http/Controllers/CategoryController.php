<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index(CategoryDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('users.title1')] );
        $auth_category = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('categories.create').'" class="btn btn-sm btn-primary" role="button">Add Category</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_category','assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('status',1)->get()->pluck('title', 'id');

        return view('category.form', compact('roles'));
    }

    public function store(Request $request)
    {
        $existingCategory = Category::where('name', $request->name)->first();
    
        if ($existingCategory) {
            return redirect()->back()->with('error', 'This name is already registered. Please choose a different one.');
        } else {
            $logo = $request->file('logo');
            if (!empty($logo) && in_array($logo->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
                $filename = $logo->getClientOriginalName();
                $uploadpath = 'uploads' . '/' . 'logo';
                $logo->move($uploadpath, $filename);
                Category::create(array_merge($request->except('logo'), ['logo' => $filename]));
            } else {
                return redirect()->back()->with('error', 'Logo is required, and it must be in JPG, JPEG, or PNG format.');
            }
    
            return redirect()->route('categories.index')->withSuccess(__('message.msg_added', ['name' => __('category')]));
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
        $data = Category::findOrFail($id);
        return view('category.form',compact('data', 'id'));
        
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
    $existingCategory = Category::where('name', $request->name)->where('id', '!=', $id)->first();

    if ($existingCategory) {
        return redirect()->back()->with('error', 'This name is already registered. Please choose a different one.');
    } else {
        $category = Category::findOrFail($id);

        $logo = $request->file('logo');
        if (!empty($logo) && in_array($logo->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
            $filename = $logo->getClientOriginalName();
            $uploadpath = 'uploads' . '/' . 'logo';
            $oldLogoPath = $uploadpath . '/' . $category->logo;
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }
            $logo->move($uploadpath, $filename);
            $category->fill($request->except('logo'));
            $category->update(['logo' => $filename]);
        } else {
            $category->update($request->except('logo'));
        }

        return redirect()->route('categories.index')->withSuccess(__('message.msg_updated', ['name' => __('category')]));
    }
}

     
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $status = 'errors';
        $message = __('global-message.delete_form', ['form' => __('users.title1')]);

        if ($category != '') {
            $logoPath = public_path('uploads/logo/' . $category->logo);
            if (File::exists($logoPath)) {
                File::delete($logoPath);
            }
            $category->delete();
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => __('users.title1')]);
        }

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);
    }

}
