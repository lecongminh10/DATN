<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Services\PageService;
use App\Events\AdminActivityLogged;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $pages = $this->pageService->getAllPages($search, $perPage);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'is_active' => 'required|in:1,0',
            'template' => 'required|string|in:default,coming_soon,blog',
            'permalink' => 'required|string|max:255|unique:pages,permalink',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ]);
        $page = Page::create($data);

        if ($request->hasFile('image')) {
            $page->image = $request->file('image')->store('pages', 'public');
            $page->save();
        }
        $logDetails = sprintf(
            'Thêm Trang: Tên - %s',
            $page->name
        );

        event(new AdminActivityLogged(
            auth()->user()->id,
            'Thêm',
            $logDetails
        ));
        // dd($page);
        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully');
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
        $pages = $this->pageService->getById($id);
        // dd($tags);
        return view('admin.pages.edit', [
            'pages' => $pages,
            'seo_title' => $page->seo_title ?? '',
            'seo_description' => $page->seo_description ?? ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate request data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permalink' => 'required|string|max:255|unique:pages,permalink,' . $id,
            'is_active' => 'required|in:0,1',
            'template' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $page = Page::findOrFail($id);
        $page->update($data);

        if ($request->hasFile('image')) {
            $page->image = $request->file('image')->store('images', 'public');
        }
        $page->save();
        $logDetails = sprintf(
            'Sủa Trang: Tên - %s',
            $page->name
        );

        event(new AdminActivityLogged(
            auth()->user()->id,
            'Sửa',
            $logDetails
        ));

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully!');
    }
    public function destroyPage(int $id)
    {
        $data = $this->pageService->getById($id);

        if (!$data) {
            return abort(404);
        }
        $data->delete();
        $logDetails = sprintf(
            'Xóa Trang: Tên - %s',
            $data->name
        );

        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa Mềm',
            $logDetails
        ));
        if ($data->trashed()) {
            return redirect()->route('admin.pages.index')->with('success', 'Thuộc tính mềm đã được xóa không thành công');
        }
        return redirect()->route('admin.pages.index')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }
    public function showSotfDelete(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $pages = $this->pageService->show_soft_delete($search, $perPage);
        return view('admin.pages.delete', compact('pages'));
    }
    public function restore($id)
    {
        try {
        $this->pageService->restore_delete($id);
            return redirect()->route('admin.pages.deleted')->with('success', 'Khôi phục thuộc tính thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.pages.deleted')->with('error', 'Không thể khôi phục thuộc tính: ' . $e->getMessage());
        }
    }
    public function hardDeletePage(int $id)
    {
        $data = $this->pageService->getIdWithTrashed($id);
        if (!$data) {
            return redirect()->route('admin.pages.index')->with('success', 'Thuộc tính đã được xóa không thành công');
        }
        $data->forceDelete();
        $logDetails = sprintf(
            'Xóa vĩnh viễn Trang: Tên - %s',
            $data->name
        );

        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa Cứng',
            $logDetails
        ));
        return redirect()->route('admin.pages.deleted')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }

    /**
     * Remove the specified resource from storage.
     */
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
                    case 'soft_delete_pages':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->pageService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroyPage($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_pages':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->pageService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeletePage($id);
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
