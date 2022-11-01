<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller {

    public function EmployeeAdd() {
        return view('backend.employee.add_employee');
    }


    public function EmployeeStore( Request $request) {

        $validation = $request->validate([
            'email' => 'required|unique:users',
            'name' => 'required',
        ]);
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->phone = $request->phone;
        $data->presentaddress = $request->presentaddress;
        $data->permanentaddress = $request->permanentaddress;
        $data->nid = $request->nid;
        $data->email_nofication = $request->email_nofication;
        $data->sms_nofication = $request->sms_nofication;
        $data->phone_nofication = $request->phone_nofication;
        $data->religion = $request->religion;
        $data->gender = $request->gender;
        $data->floor = $request->floor;
        $data->unit = $request->unit;
        $data->usertype = $request->usertype;

        $data->salary = $request->salary;
        $data->status = $request->status;
        $data->join_date = $request->join_date;
        $data->resignation_date = $request->resignation_date;

        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/user_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/employee_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Employee Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.add')->with($notification);

    }

}
