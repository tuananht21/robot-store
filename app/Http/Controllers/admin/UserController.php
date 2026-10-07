<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    // Hiển thị danh sách khách hàng, hỗ trợ tìm kiếm và phân trang.
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('role', 0)
            ->withCount('orders')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
                });
            })->latest()->paginate(10)->appends(['search' => $search]);
        return view('admin.pages.users.index', compact('users', 'search'));
    }

    // Hiển thị thông tin chi tiết và lịch sử đơn hàng của khách hàng.
    public function show(string $id)
    {
        $user = User::where('role', 0)->with(['orders' => function ($query) {
            $query->latest();
        }])->withCount('orders')->findOrFail($id);

        return view('admin.pages.users.show', compact('user'));
    }

    // Xóa tài khoản khách hàng.
    public function destroy(string $id)
    {
        $user = User::where('role', 0)->findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Không thể xóa tài khoản đang đăng nhập.');
        }

        $user->delete();

        return back()->with('success', 'Xóa người dùng thành công.');
    }
}
