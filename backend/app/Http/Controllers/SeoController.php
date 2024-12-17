<?php

namespace App\Http\Controllers;

use App\Models\Seo;
use App\Models\Product;
use App\Services\SeoService;
use Illuminate\Http\Request;

class SeoController extends Controller
{

    protected $seoService;
    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $seo = $this->seoService->getAllSeos($search, $perPage);
        return view('admin.seo.index', compact('seo'));
    }

    public function create()

    {
        $products = Product::all();
        return view('admin.seo.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url',
            'product_id' => 'nullable|array',
            'product_id.*' => 'exists:products,id',
            'is_active'     =>'nullable'
            // 'post_id' => 'nullable|array',
            // 'post_id.*' => 'exists:products,id',
        ]);

        $seo = Seo::create($data);
        // if ($seo->is_active) {
        //     // Cập nhật tất cả các bản ghi khác có is_active = true thành false
        //     Seo::where('id', '!=', $seo->id)
        //         ->where('is_active', true)
        //         ->update(['is_active' => false]);
        // }

        if (!empty($data['product_id'])) {
            $seo->products()->attach($data['product_id']);
        }

        return redirect()->route('admin.seo.index')->with('success', 'Thêm SEO thành công!');
    }



    public function edit(string $id)
    {
        $products = Product::all();
        $seo = Seo::findOrFail($id);
        return view('admin.seo.edit', compact('seo', 'products'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url',
            'product_id' => 'nullable|array',
            'product_id.*' => 'exists:products,id',
            'is_active'     =>'nullable'
        ]);

        $seo = Seo::findOrFail($id);
        $seo->update([
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'meta_keywords' => $data['meta_keywords'],
            'canonical_url' => $data['canonical_url'],
        ]);

        if ($request->has('product_id')) {
            $seo->products()->sync($data['product_id']);
        }

        return redirect()->route('admin.seo.index')->with('success', 'Cập nhật SEO thành công!');
    }
    public function destroySeo(int $id)
    {
        $data = SEO::findOrFail($id);
        if (!$data) {
            return abort(404);
        }
        $data->delete();
        foreach ($data->products as $product) {
            $data->products()->updateExistingPivot($product->id, ['deleted_at' => now()]);
        }
        if ($data->trashed()) {
            return redirect()->route('admin.seo.index')->with('success', 'Thuộc tính mềm đã được xóa thành công');
        }

        return redirect()->route('admin.seo.index')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }

    public function showSotfDelete(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $seo = $this->seoService->show_soft_delete($search, $perPage);
        return view('admin.seo.delete', compact('seo'));
    }
    public function restore($id)
    {
        try {
            $this->seoService->restore_delete($id);
            return redirect()->route('admin.seo.deleted')->with('success', 'Khôi phục thuộc tính thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.seo.deleted')->with('error', 'Không thể khôi phục thuộc tính: ' . $e->getMessage());
        }
    }
    public function hardDeleteSeo(int $id)
    {
        $data = $this->seoService->getIdWithTrashed($id);
        if (!$data) {
            return redirect()->route('admin.seo.index')->with('success', 'Thuộc tính đã được xóa không thành công');
        }
        $data->forceDelete();
        return redirect()->route('admin.seo.deleted')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
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
                    case 'soft_delete_seo':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->seoService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroySeo($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_seo':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->seoService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeleteSeo($id);
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
    public function getProductsBySeo($id)
    {
        $seo = SEO::findOrFail($id);
        $products = $seo->products;
        return response()->json([
            'products' => $products
        ]);
    }
}
