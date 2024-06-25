<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function productsApi(Request $request, $page)
{
    $pageSize = 10;
    $offset = ($page - 1) * $pageSize;

    $products = Product::offset($offset)->limit($pageSize)->with('images')->get();


    if ($page > 1) {
        $previousPage = $page - 1;
    } else {
        $previousPage = null;
    }

    if ($products->count() >= $pageSize) {
        $nextPage = $page + 1;
    } else {
        $nextPage = null;
    }

    return response()->json([
        'data' => $products->all(),
        'meta' => [
            'currentPage' => $page,
            'previousPageUrl' => $previousPage ? route('products.list', ['page' => $previousPage]) : null,
            'nextPageUrl' => $nextPage ? route('products.list', ['page' => $nextPage]) : null,
            'totalPages' => ceil(Product::count() / $pageSize),
            'totalProducts' => Product::count(),
        ],
    ]);
}
public function searchApi(Request $request, $page)
{
    $pageSize = 10;
    $searchTerm = $request->input('search');
    $products = Product::where('name', 'LIKE', "%".$searchTerm."%")
        ->with('images')
        ->skip(($page - 1) * $pageSize)
        ->take($pageSize)
        ->get();

    $totalProducts = Product::where('name', 'LIKE', "%{$searchTerm}%")->count();

    if ($page > 1) {
        $previousPage = $page - 1;
    } else {
        $previousPage = null;
    }

    if ($products->count() >= $pageSize) {
        $nextPage = $page + 1;
    } else {
        $nextPage = null;
    }

    return response()->json([
        'data' => $products,
        'meta' => [
            'currentPage' => $page,
            'previousPageUrl' => $previousPage ? route('products.search', ['page' => $previousPage]) : null,
            'nextPageUrl' => $nextPage ? route('products.search', ['page' => $nextPage]) : null,
            'totalPages' => ceil($totalProducts / $pageSize),
            'totalProducts' => $totalProducts,
        ],
    ]);
}
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {

            $products = Product::paginate(4);
            return view('Dashboard.items', compact('products'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->hasRole('admin')) {

            return view('Dashboard.createItem');
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {

            // Validate the request
            $request->validate([
                'name' => 'required',
                'price' => 'required',
                'percentage' => 'required',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            // Create a new product instance
            $product = new Product();
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->percentage = $request->input('percentage');
            $product->save(); // Save the product details

            // Handle the images if there are any
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Generate a unique file name
                    $filename = time() . '-' . $image->getClientOriginalName();

                    // Store the image
                    $path = $image->storeAs('public/images', $filename);

                    // Save image information to the database
                    $product->images()->create([
                        'url' => $filename,
                    ]);
                }
            }

            // Redirect back to the product page with a success message
            return redirect()->route('products')->with('success', 'Product created successfully.');
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if (auth()->check()) {

            return view('Dashboard.showItem', compact('product'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (auth()->user()->hasRole('admin')) {

            return view('Dashboard.editItem', compact('product'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Product $product)
    {
        if (auth()->user()->hasRole('admin')) {

            // Validate the request
            $request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
                'percentage' => 'required|numeric',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Delete selected images
            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageId) {
                    // Find the image in the database
                    $image = $product->images()->findorfail($imageId);

                    // Delete from storage
                    Storage::delete('public/images/' . $image->url);

                    // Delete from database
                    $image->delete();
                }
            }

            // Update product details
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->percentage = $request->input('percentage');
            $product->save(); // Save the updated product details

            // Handle the new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Generate a unique file name
                    $filename = time() . '-' . $image->getClientOriginalName();

                    // Store the image
                    $path = $image->storeAs('public/images', $filename);

                    // Save image information to the database
                    $product->images()->create([
                        'url' => $filename,
                    ]);
                }
            }

            // Redirect back to the product page with a success message
            return redirect()->route('products')->with('success', 'Product updated successfully.');
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }

    public function search (Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
    
            $search = $request->input('search');
    
                    $products = Product::whereAny([
                        'name',
                        'id',
                        'price',
                        'percentage'
                    ], 'LIKE', '%' . $search . '%')
                        ->paginate(4)->withQueryString();
            
    
            return view('Dashboard.items', compact('products'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete(Product $product)
    {
        if (auth()->user()->hasRole('admin')) {

            $product->delete(); // Delete the product
            return redirect()->route('products')->with('success', 'Product deleted successfully.');
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
 
}
