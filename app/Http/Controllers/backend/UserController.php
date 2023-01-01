<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Floor;
use App\Models\backend\Unit;
use App\Models\User;
use App\Models\backend\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserView() {

        $data['alluserdarta'] = User::where('usertype','flatowner')->with(['units.floor'])->get();
        $data['allUnitData'] = Unit::all();
        $data['allFloorData'] = Floor::all();
        //dd($data);
        return view('backend.user.view_user' , $data);

    }

    public function UserAdd() {
        $data['allFloorlist'] = Floor::all();
        $data['allUnitLis'] = Unit::all();
        return view('backend.user.add_user' , $data);
    }

    public function UserStore( Request $request) {

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
        $data->usertype = $request->usertype;

        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/user_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('user.view')->with($notification);

    }

    public function UserEdit($id) {
        $editData = User::find($id);
        return view('backend.user.edit_user', compact('editData'));
    }

    public function UserUpdate(Request $request, $id){

        $data = User::find($id);
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

        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/user_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('user.detail' , $id)->with($notification);

    }

    public function UserDetail($id) {
        $data['detailData'] = User::find($id);
        $data['allUnitData'] = Unit::all();
        $data['allFloorlist'] = Floor::all();
        return view('backend.user.detail_user', $data );
    }

    public function UserAssign() {
        $data['allUserData'] = User::where('usertype','flatowner')->get();
        $data['allUnitData'] = Unit::all();
        $data['allFloorlist'] = Floor::all();
        return view('backend.user.assign_user', $data );
    }

    public function AssignStore( Request $request ) {
        $id = $request->unit;
        $data = Unit::find($id);
        $data->user_id = $request->user;

        $data->save();

        $notification = array(
            'message' => 'Flat Assigned Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('user.assign_flat')->with($notification);
    }




}
