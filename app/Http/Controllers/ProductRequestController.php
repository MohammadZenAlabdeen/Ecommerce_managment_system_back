<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {

            $requests = ProductRequest::latest('created_at')->paginate(4);
            return view('Dashboard.requests', compact('requests'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    public function search (Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
    
            $search = $request->input('search');
    
                    $requests = ProductRequest::whereAny([
                        'name',
                        'id',
                        'price',
                        'percentage'
                    ], 'LIKE', '%' . $search . '%')
                        ->paginate(4)->withQueryString();
            
    
            return view('Dashboard.requests', compact('requests'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    public function requestsSearch(Request $request){
        $search = $request->input('search');
    
        $requests = ProductRequest::where('user_id',auth()->user()->id)->whereAny([
            'name',
            'id',
            'price',
            'percentage'
        ], 'LIKE', '%' . $search . '%')
            ->paginate(4)->withQueryString();
            return view('DashboardSellers.requests',compact('requests'));
    }

    public function accept(ProductRequest $productRequest)
    {
        if (auth()->user()->hasRole('admin')) {

            // Create a new Product instance
            $product = new Product();

            // Assign values from the ProductRequest to the Product instance
            $product->name = $productRequest->name;
            $product->price = $productRequest->price;
            $product->percentage = $productRequest->percentage;

            // Save the Product instance to the database
            $product->save();

            // Process images from the ProductRequest
            foreach ($productRequest->images() as $image) {
                // Generate a unique filename for the image
                $filename = time() . '_' . $image->getClientOriginalName();

                // Move the image to a storage directory (e.g., public/images/products)
                $path = $image->storeAs('public/images', $filename);

                // Save the image path to the Product's images relationship (if applicable)
                $product->images()->create(['url' => $filename]);
            }
            foreach ($productRequest->images() as $image) {
                // Find the image in the database

                // Delete from storage
                Storage::delete('public/images/' . $image->url);

                // Delete from database
                $image->delete();
            }


            // Delete the ProductRequest instance (assuming this is the desired behavior)
            $productRequest->delete();

            // Redirect the user after processing to a specific route (assuming 'requests' is a valid route)
            return redirect()->route('requests');
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(ProductRequest $productRequest)
    {
        if (auth()->user()->hasRole('admin')) {

            return view('Dashboard.showRequest', compact('productRequest'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function edit(ProductRequest $productRequest)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->id == $productRequest->user_id) {

            return view('Dashboard.editRequest', compact('productRequest'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    public function update(Request $request, ProductRequest $productRequest)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->id == $productRequest->user_id) {

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
                    $image = $productRequest->images()->findorfail($imageId);

                    // Delete from storage
                    Storage::delete('public/images/' . $image->url);

                    // Delete from database
                    $image->delete();
                }
            }

            // Update product details
            $productRequest->name = $request->input('name');
            $productRequest->price = $request->input('price');
            $productRequest->percentage = $request->input('percentage');
            $productRequest->save(); // Save the updated product details

            // Handle the new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Generate a unique file name
                    $filename = time() . '-' . $image->getClientOriginalName();

                    // Store the image
                    $path = $image->storeAs('public/images', $filename);

                    // Save image information to the database
                    $productRequest->images()->create([
                        'url' => $filename,
                    ]);
                }
            }
            if(auth()->user()->hasRole('admin')){
              return redirect()->route('requests'); 
              }else{
              return redirect()->route('sellerDashboardRequests');
              }
             
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
     public function sellerRequests(Request $request){
        $requests=ProductRequest::where('user_id',auth()->user()->id)->paginate(4);
        return view('DashboardSellers.requests',compact('requests'));
     }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductRequest $productRequest)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->id == $productRequest->user_id) {

            $productRequest->delete();
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    public function create(){
        return view('DashboardSellers.RequestProduct');        
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'percentage' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product= new ProductRequest();
        $product->name=$request->input('name');
        $product->price=$request->input('price');
        $product->percentage=$request->input('percentage');
        $product->user_id=auth()->user()->id;
        $product->save();
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
        return Redirect()->route('landing');
    }
}
