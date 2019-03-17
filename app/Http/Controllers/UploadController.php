<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Storage;

class UploadController extends Controller
{
    
	public function upload($data = []) {
		if (in_array('new_name', $data)) {
			$new_name = null === $data['new_name']? time() : $data['new_name'];
		}

		if (request()->hasFile($data['file']) && $data['upload_type'] == 'single') {
			
			Storage::has($data['delete_file'])?Storage::delete($data['delete_file']):'';
			return request()->file($data['file'])->store($data['path']);

		}elseif (request()->hasFile($data['file']) && $data['upload_type'] == 'files') {

			$file = request()->file($data['file']);
			$size = $file->getSize();
			$mimType = $file->getMimeType();
			$name = $file->getClientOriginalName();
			$hashName = $file->hashName();

			$file->store($data['path']);

			$add = File::create([
				'name' 					=> $name,
				'size' 					=> $size,
				'file' 					=> $hashName,
				'path' 					=> $data['path'],
				'full_file' 			=> $data['path'] .'/'. $hashName,
				'mime_type' 			=> $mimType,
				'file_type' 			=> $data['file_type'],
				'relation_id' 			=> $data['relation_id'],
			]);
			return $add->id;
		}
	}
}
