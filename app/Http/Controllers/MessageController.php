<?php

namespace App\Http\Controllers;

use App\Events\MessageBroadcast;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Hiển thị danh sách các cuộc trò chuyện cho admin.
     */
    public function index()
    {
        $groupedMessages = Message::get()->groupBy(function ($message) {
            $ids = [$message->user_from_id,$message->user_to_id,];
            sort($ids);
            return implode('-', $ids);
        });

        $firstChatKey = $groupedMessages->keys()->first();
        $authUserId = Auth::id();

        return view('admin.pages.message.index',compact('groupedMessages','firstChatKey','authUserId'));
    }

    /**
     * Hiển thị form tạo message.
     */
    public function create()
    {
        //
    }

    /**
     * Gửi tin nhắn.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_to_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        try {

            DB::beginTransaction();
            $userFromId = Auth::id();
            $userToId = $request->user_to_id;
            $message = Message::create([
                'user_from_id' => $userFromId,
                'user_to_id' => $userToId,
                'message' => $request->message,
            ]);

            DB::commit();
            broadcast(new MessageBroadcast($userFromId,$userToId,$request->message));

            return response()->json([
                'status' => 'success',
                'message' => 'Gửi tin nhắn thành công!',
                'data' => $message,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gửi tin nhắn thất bại!',
            ], 500);
        }
    }

    /**
     * Hiển thị một message.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Hiển thị form chỉnh sửa message.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Lấy danh sách message được nhóm theo cuộc trò chuyện.
     */
    public function update()
    {
        $groupedMessages = Message::get()->groupBy(function ($message) {
            $ids = [$message->user_from_id,$message->user_to_id];
            sort($ids);
            return implode('-', $ids);
        });

        return response()->json([
            'status' => 'success',
            'data' => $groupedMessages,
        ], 200);
    }

    /**
     * Xóa message.
     */
    public function destroy(string $id)
    {
        //
    }
}