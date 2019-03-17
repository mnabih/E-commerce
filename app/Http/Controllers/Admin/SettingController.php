<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Setting;

class SettingController extends Controller
{
    public function setting(){
    	return view('admin.setting',['title' => trans('admin.setting')]);
    }

    public function setting_save(){

    	$data = $this->validate(request(),[
					    						'logo'                  => v_images(),
                                                'icon'                  => v_images(),
                                                'sitename_ar'           => '', // must be here to return there data in $data
                                                'sitename_en'           => '',
                                                'email'                 => '',
                                                'description'           => '',
                                                'keywords'              => '',
                                                'main_lang'             => '',
                                                'status'                => '',
					    						'message_maintenance'   => '',
					    					],[],[

					    						'logo' => trans('admin.logo'),
					    						'icon' => trans('admin.icon'),
					    					]);

    	// if (request()->hasFile('logo')) {
    	// 	!empty(setting()->logo)? Storage::delete(setting()->logo): '';
    	// 	$data['logo'] = request()->file('logo')->store('settings');
    	// }

        // if (request()->hasFile('icon')) {
        //  !empty(setting()->logo)? Storage::delete(setting()->icon): '';
        //  $data['icon'] = request()->file('icon')->store('settings');
        // }

        # use upload class & helper function for use model
        if (request()->hasFile('logo')) {
            $data['logo'] = up()->upload([
                    'file'        => 'logo',
                    'path'        => 'settings',
                    'upload_type' => 'single',
                    'delete_file' => setting()->logo,
                ]);
        }

    	

        if (request()->hasFile('icon')) {
            $data['icon'] = up()->upload([
                    'file'        => 'icon',
                    'path'        => 'settings',
                    'upload_type' => 'single',
                    'delete_file' => setting()->icon,
                ]);
        }

    	Setting::orderBy('id','desc')->update($data);
    	return redirect(aurl('setting'))->with('success', trans('admin.record_updated'));
    }
}
