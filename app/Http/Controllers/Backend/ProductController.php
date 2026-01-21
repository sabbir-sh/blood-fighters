<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Services\Product\ProductService;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index()
    {
        return view('backend.products.index');
    }

    public function getDataTable()
{
    return DataTables::of(Product::latest())
        ->addIndexColumn()

        ->editColumn('thumbnail', function ($p) {
            return $p->thumbnail
                ? '<img src="'.asset('storage/'.$p->thumbnail).'" width="45" style="border-radius:8px">'
                : '-';
        })

        ->editColumn('status', function ($p) {
            return $p->status
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
        })

        ->addColumn('actions', function ($p) {
            return '
                <a href="'.route('product.edit',$p->id).'"
                   class="btn btn-sm btn-warning me-1"
                   data-bs-toggle="tooltip" title="Edit">
                   <i class="fas fa-edit"></i>
                </a>

                <form action="'.route('product.destroy',$p->id).'"
                      method="POST" style="display:inline">
                    '.csrf_field().method_field('DELETE').'
                    <button class="btn btn-sm btn-danger"
                        onclick="return confirm(`Delete this product?`)">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            ';
        })

        ->rawColumns(['thumbnail','status','actions'])
        ->make(true);
}


    public function create()
    {
        return view('backend.products.create');
    }

    public function store(ProductRequest $request)
    {
        $this->productService->store($request->validated());

        return redirect()->route('product.list')
            ->with('success','Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.products.create', compact('product'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->productService->update($product, $request->validated());

        return redirect()->route('product.list')
            ->with('success','Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->productService->delete($product);

        return redirect()->route('product.list')
            ->with('success','Product deleted successfully');
    }
}
