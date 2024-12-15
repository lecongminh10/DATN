<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\DB;
use App\Events\AdminActivityLogged;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    public function index(TagRequest $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $tags = $this->tagService->getAllTags($search, $perPage);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $data = $this->tagService->saveOrUpdate([
                'name' => $validatedData['name'],
            ]);
            $logDetails = sprintf(
                'Thêm Tag: Tên - %s',
                $data['name']
            );

            event(new AdminActivityLogged(
                auth()->user()->id,
                'Thêm Mới',
                $logDetails
            ));
            DB::commit();
            return redirect()->route('admin.tags.index')->with('success', 'Thêm mới thẻ thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi thêm carrier: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tags = $this->tagService->getById($id);
        // dd($tags);
        return view('admin.tags.edit', compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, string $id)
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();
            $tags = $this->tagService->getById($id);
            $tags->update([
                'name' => $validatedData['name'],
            ]);
            $logDetails = sprintf(
                'Sửa Tag: Tên - %s',
                $tags['name']
            );

            event(new AdminActivityLogged(
                auth()->user()->id,
                'Sửa',
                $logDetails
            ));
            DB::commit();
            return redirect()->route('admin.tags.index')->with('success', 'Cập nhật thẻ thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi cập nhật tags: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyTag(int $id)
    {
        $data = $this->tagService->getById($id);

        if (!$data) {
            return abort(404);
        }
        $logDetails = sprintf(
            'Xóa Tag: Tên - %s',
            $data['name']
        );

        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa',
            $logDetails
        ));
        
        $data->deleted_by = Auth::id(); // Lưu ID của người xóa
        $data->save();
        $data->delete();
        if ($data->trashed()) {
            return redirect()->route('admin.tags.index')->with('success', 'Thẻ đã được xóa mềm thành công');
        }

        return redirect()->route('admin.tags.index')->with('success', 'Thẻ đã bị xóa vĩnh viễn');
    }
    public function restore($id)
    {
        try {
            // Gọi service để khôi phục Tag
            $data = $this->tagService->restore_delete($id);

            // Chuẩn bị nội dung log
            $logDetails = sprintf(
                'Khôi phục Tag: Tên - %s',
                $data['name']
            );

            // Ghi lại hoạt động admin
            event(new AdminActivityLogged(
                auth()->user()->id,
                'Khôi phục',
                $logDetails
            ));

            // Lưu thông báo vào session và chuyển hướng
            session()->flash('success', 'Khôi phục thẻ thành công!');
            return redirect()->route('admin.tags.deleted')->with([
                'success' => 'Khôi phục thành công'
            ]);
        } catch (\Exception $e) {
            // Lưu thông báo lỗi vào session và chuyển hướng
            session()->flash('error', 'Không thể khôi phục thẻ: ' . $e->getMessage());
            return redirect()->route('admin.tags.deleted');
        }
    }

    public function showSotfDelete(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $tags = $this->tagService->show_soft_delete($search, $perPage);
        return view('admin.tags.delete', compact('tags'));
    }
    public function hardDeleteTag(int $id)
    {
        $data = $this->tagService->getIdWithTrashed($id);
        if (!$data) {
            return redirect()->route('admin.tags.index')->with('success', 'Thẻ đã được xóa không thành công');
        }
        $data->forceDelete();
        return redirect()->route('admin.tags.index')->with('success', 'Thẻ đã bị xóa vĩnh viễn');
    }
    public function deleteMuitpalt(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'action' => 'required|string',
        ]);

        $ids = $request->input('ids');
        $action = $request->input('action');

        if (count($ids) > 0) {
            switch ($action) {
                case 'soft_delete_tags':
                    foreach ($ids as $id) {
                        $isSoftDeleted = $this->tagService->isSoftDeleted($id);
                        if (!$isSoftDeleted) {
                            $this->destroyTag($id);
                        }
                    }
                    // Trả về thông báo thành công cho xóa mềm
                    return response()->json(['message' => 'Thẻ đã được xóa mềm thành công.']);
                    break;

                case 'hard_delete_tags':
                    foreach ($ids as $id) {
                        $isSoftDeleted = $this->tagService->isSoftDeleted($id);
                        if ($isSoftDeleted) {
                            $this->hardDeleteTag($id);
                        }
                    }
                    // Trả về thông báo thành công cho xóa cứng
                    return response()->json(['message' => 'Thẻ đã được xóa cứng thành công.']);
                    break;

                default:
                    // Trả về thông báo lỗi nếu hành động không hợp lệ
                    return response()->json(['message' => 'Hành động không hợp lệ.'], 400);
            }
        } else {
            // Trả về thông báo lỗi nếu không có thẻ nào được chọn
            return response()->json(['message' => 'Không có thẻ nào được cung cấp để xóa.'], 400);
        }
    }
}
