<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\DB;
use App\Events\AdminActivityLogged;

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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $tags = $this->tagService->getAllTags($search, $perPage);
        return view('admin.tags.index',compact('tags'));
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
            return redirect()->route('admin.tags.index')->with('success', 'Thêm mới tag thành công');
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
        return view('admin.tags.edit',compact('tags'));
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
            return redirect()->route('admin.tags.index')->with('success', 'Cập nhật thành công');
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
        $data->delete();
        if ($data->trashed()) {
            return redirect()->route('admin.tags.index')->with('success', 'Thuộc tính mềm đã được xóa không thành công');
        }

        return redirect()->route('admin.tags.index')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }
    public function restore($id)
    {
        try {
            $data = $this->tagService->restore_delete($id);
            $logDetails = sprintf(
                'Khôi phục Tag: Tên - %s',
                $data['name']
            );

            event(new AdminActivityLogged(
                auth()->user()->id,
                'Khôi phục',
                $logDetails
            ));
            return redirect()->route('admin.tags.deleted')->with('success', 'Khôi phục thuộc tính thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.tags.deleted')->with('error', 'Không thể khôi phục thuộc tính: ' . $e->getMessage());
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
            return redirect()->route('admin.tags.index')->with('success', 'Thuộc tính đã được xóa không thành công');
        }
        $logDetails = sprintf(
            'Xóa Tag: Tên - %s',
            values: $data->name
        );

        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa',
            $logDetails
        ));
        $data->forceDelete();
        return redirect()->route('admin.tags.deleted')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }
    public function deleteMuitpalt(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'action' => 'required|string',
        ]);

        $ids = $request->input('ids');
        $action = $request->input('action');

        if (count($ids) > 0) {
            foreach ($ids as $id) {

                switch ($action) {
                    case 'soft_delete_tags':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->tagService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroyTag($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_tags':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->tagService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeleteTag($id);
                            }
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);
                    default:
                        return response()->json(['message' => 'Invalid action'], 400);
                }
            }
            return response()->json(['message' => 'Categories deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Error: No IDs provided'], 500);
        }
    }

}
