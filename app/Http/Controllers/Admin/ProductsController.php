<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\ProductsDatatable;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Size;
use App\Model\Weight;
use Illuminate\Http\Request;
use Storage;
use App\File;
class ProductsController extends Controller {
	
	public function index(ProductsDatatable $product) {
		return $product->render('admin.products.index', ['title' => trans('admin.products')]);
	}
	
	public function create() {
		$product = Product::create(['title' => '',]);
		if(!empty($product)){
			return redirect(aurl('products/' . $product->id . '/edit'));
		}
	}

	// start dropzone
	
	# multi upload from dropzone
	public function upload_file($id){
		if (request()->hasFile('file')) {

			$fid = up()->upload([
					'file'        => 'file',
					'path'        => 'products',
					'upload_type' => 'files',
					'file_type' => 'product',
					'relation_id' => $id,
				]);

				return response(['status' => true, 'id' => $fid],200);
		}
	}

	public function delete_file(){
		if(request()->has('id')){
			$file = File::find(request('id'));
			if(!empty($file)){
				Storage::delete($file->full_file);
				$file->delete();
				return response(['status' => true, 'msg' => "Deleted" ],200);				
			}		
		}		
	}

	public function update_product_image($id){
		Product::where('id',$id)->update([

			$product = 'photo'=> up()->upload([
												'file'        => 'file',
												'path'        => 'products',
												'upload_type' => 'single',
												'delete_file' => '',
											]),
			]);
		return response(['status' => true],200);
		// , 'photo' => $product->photo
	}

	public function delete_main_image($id){
		$product = Product::find($id);
			if(!empty($product)){
				Storage::delete($product->photo);
				$product->photo = null;
				$product->save();
				return response(['status' => true, 'msg' => "Deleted" ],200);			
			}
	}

	// end dropzone

	// ajax weight & size
	public function prepare_weight_size(){
		if(request()->ajax() and request()->has('dep_id')){

			$parentIds = getAllParents(request('dep_id'));
			$sizes_1 = Size::where('is_public', 'yes')->whereIn('department_id', $parentIds)->pluck('name_'.session('lang'), 'id')->toarray();
			$sizes_2 = Size::where('department_id', request('dep_id'))->pluck('name_'.session('lang'), 'id')->toarray();
			$sizes = array_merge($sizes_1,$sizes_2);
			$weights = Weight::pluck('name_'.session('lang'), 'id');
			return view('admin.products.ajax.size_weight',compact('sizes','weights'))->render(); // for html data
		}else{
			return ' برجاء اختيار القسم   ' ;
		}
	}

	public function store() {
		$data = $this->validate(request(),
			[
				'' => '',
				

			], [], [
				'' => trans('admin.'),
				
			]);
		if (request()->hasFile('logo')) {
			$data['logo'] = up()->upload([
					'file'        => 'logo',
					'path'        => 'countries',
					'upload_type' => 'single',
					'delete_file' => '',
				]);
		}
		Product::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('products'));
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$product = Product::find($id);
		return view('admin.products.product', ['title' => trans('admin.edit_create_product', ['title' => $product->title]),'product' => $product]);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $r, $id) {
		$data = $this->validate(request(),
			[
				'' => 'required',
				
				'logo'            => 'sometimes|nullable|'.v_images(),
			], [], [
				'' => trans('admin.'),
				
				'logo'            => trans('admin.logo'),
			]);
		if (request()->hasFile('logo')) {
			$data['logo'] = up()->upload([
					'file'        => 'logo',
					'path'        => 'countries',
					'upload_type' => 'single',
					'delete_file' => Country::find($id)->logo,
				]);
		}
		Product::where('id', $id)->update($data);
		session()->flash('success', trans('admin.record_updated'));
		return redirect(aurl('products'));
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$product = Product::find($id);
		Storage::delete($product->logo);
		$product->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}
	public function multi_delete() {
		if (is_array(request('item'))) {
			foreach (request('item') as $id) {
				$product = Product::find($id);
				Storage::delete($product->logo);
				$product->delete();
			}
		} else {
			$product = Product::find(request('item'));
			Storage::delete($product->logo);
			$product->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}
}