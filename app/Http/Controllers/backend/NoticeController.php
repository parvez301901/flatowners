<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Notice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NoticeController extends Controller {

    public function NoticeAdd() {
        return view('backend.notice.add_notice');
    }

    public function NoticeStore( Request $request) {

        $data = new Notice();
        $data->noticeTitle = $request->noticeTitle;
        $data->noticeDescription = $request->noticeDescription;
        $data->email_notification = $request->email_notification;
        $data->sms_notification = $request->sms_notification;
        $data->dashboard_notification = $request->dashboard_notification;
        $data->notice_to = $request->notice_to;
        $data->notice_for = $request->notice_for;
        $data->notice_status = $request->notice_status;

        $data->save();

        $notification = array(
            'message' => 'Notice Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('notice.view')->with($notification);

    }

    public function NoticeView() {
        $data['allNoticeData'] = Notice::all();
        return view('backend.notice.view_notice' , $data);
    }
    public function NoticeDetail($id) {
        $data['detailNotice'] = Notice::find($id);
        return view('backend.notice.detail_notice' , $data);
    }


}
