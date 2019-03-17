<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AdminDatatable;
use App\Admin;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminDatatable $admin)
    {
        return $admin->render('admin.admins.index', ['title' => trans('admin.adminpanel')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.create', ['title' => trans('admin.create_admin')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate(request(),[
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
        ],[],[
            'name' => trans('admin.name'),
            'email' => trans('admin.email'),
            'password' => trans('admin.password'),
        ]);

        $data['password'] = bcrypt(request('password'));
        Admin::create($data);
        return redirect(aurl('admin'))->with('success', trans('admin.record_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::find($id);
        $title = trans('admin.edit');
        return view('admin.admins.edit',compact('admin','title'));
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
        $data = $this->validate(request(),[
            'name' => 'required',
            'email' => 'required|email|unique:admins,id,' . $id,
            'password' => 'sometimes|nullable|min:6',
        ],[],[
            'name' => trans('admin.name'),
            'email' => trans('admin.email'),
            'password' => trans('admin.password'),
        ]);

        if(request()->has('password')){
            $data['password'] = bcrypt(request('password'));            
        }
        Admin::where('id',$id)->update($data);
        return redirect(aurl('admin'))->with('success', trans('admin.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::find($id)->delete();
        return redirect(aurl('admin'))->with('success', trans('admin.deleted_record'));
    }

    public function destroy_all(){
        if(is_array(request('item'))){
            Admin::destroy(request('item'));
        }else{
            Admin::find(request('item'))->delete();
        }
        return redirect(aurl('admin'))->with('success', trans('admin.deleted_record'));
    }
}
