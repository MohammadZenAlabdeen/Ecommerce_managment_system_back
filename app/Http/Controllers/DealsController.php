<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Deals;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {

            $deals = Deal::where('done', 0)->latest('created_at')->paginate(4)->withQueryString();
            $status = "waiting";
            return view('Dashboard.deals', compact('deals', 'status'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    public function deals(Request $request)
    {
        // Default status if no status is selected
        if (auth()->user()->hasRole('admin')) {


            // Check if a status is selected from the request
   
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    public function end(Deal $deal)
    {
        if (auth()->user()->hasRole('admin')) {

            $deal->done = 1;
            $deal->save();
            return redirect()->route('showSeller', $deal->user->id);
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('DashboardSellers.CreateDeal',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Product $product)
    {
        $request->validate([
            'client_name'=>'required|string',
            'client_number'=>'required|string',
            'address'=>'required|string',
            'count'=>'required',
        ]);
        $deal=new Deal();
        $deal->client_name=$request->input('client_name');
        $deal->client_number=$request->input('client_number');
        $deal->address=$request->input('address');
        $deal->count=$request->input('count');
        $deal->done=0;
        $deal->user_id=auth()->user()->id;
        $deal->product_id=$product->id;
        $deal->save();
        return redirect()->route('sellerDashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deal $deal)
    {
        if (auth()->user()->hasRole('admin')) {

            return view('Dashboard.showDeal', compact('deal'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deal $deal)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->id == $deal->user_id) {

            return view('Dashboard.editDeal', compact('deal'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    public function sellerDealsDashboard(Request $request){
        $deals=Deal::where('user_id',auth()->user()->id);
        $status='waiting';
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 'done') {
                $deals = $deals->where('done', 1)->latest('created_at')->with('product')->paginate(4)->withQueryString();
            } elseif ($status == 'waiting') {
                $deals = $deals->where('done', 0)->latest('created_at')->with('product')->paginate(2)->withQueryString();
            } else {
                $deals = $deals->onlyTrashed()->latest('created_at')->with('product')->paginate(4)->withQueryString();
            }
        } else {
            // Set initial status based on any logic you have
            // For example, you might want to default to 'done' if there are deals
            $deals = $deals->where('done', 0)->latest('created_at')->paginate(4);
            if ($deals->count() > 0) {
                $status = 'waiting';
            }
        }
        return view('DashboardSellers.deals', compact('deals', 'status'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->id == $deal->user_id) {

            $request->validate([
                'client_name' => 'required|string',
                'client_number' => 'required',
                'address' => 'required|string',
                'count' => 'required'
            ]);
            $deal->client_name = $request->input('client_name');
            $deal->client_number = $request->input('client_number');
            $deal->address = $request->input('address');
            $deal->count = $request->input('count');
            $deal->save();
            if(auth()->user()->hasRole('admin')){
                return redirect()->route('deals');
            }else{
                return redirect()->route('sellerDashboardDeals');
            }
        } else {
            return redirect()->back()->withErrors('not authorise');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Deal $deal)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->id == $deal->user_id) {

            $id = $deal->user->id;
            $deal->delete();
            if(auth()->user()->hasRole('admin')){
                return redirect()->route('showSeller', $id);
            }else{
            return redirect()->route('sellerDashboardDeals');
            }
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
    public function search(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            $status = "done";
    
            $search = $request->input('search');
            if ($request->has('status')) {
                $status = $request->input('status');
                if ($status == "done") {
                    $deals = Deal::where('done',1)->latest('created_at')->whereAny([
                        'client_name',
                        'id',
                        'client_number',
                    ], 'LIKE', '%' . $search . '%')
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'LIKE', '%' . $search . '%');
                        })->orWhereHas('product',function ($query) use ($search){
                            $query->whereAny(['name','price','percentage'], 'LIKE' , '%' . $search . '%');
                        })
                        ->with(['user', 'product'])
                        ->paginate(4)->withQueryString();
                } else if ($status == "waiting") {
                    $deals = Deal::where('done',0)->latest('created_at')->whereAny([
                        'client_name',
                        'id',
                        'client_number',
                    ], 'LIKE', '%' . $search . '%')
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'LIKE', '%' . $search . '%');
                        })->orWhereHas('product',function ($query) use ($search){
                            $query->whereAny(['name','price','percentage'], 'LIKE' , '%' . $search . '%');
                        })
                        ->with(['user', 'product'])
                        ->paginate(2)->withQueryString();
                } else {
                    $deals = Deal::onlyTrashed()->latest('deleted_at')->whereAny([
                        'client_name',
                        'id',
                        'client_number',
                    ], 'LIKE', '%' . $search . '%')
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'LIKE', '%' . $search . '%');
                        })->orWhereHas('product',function ($query) use ($search){
                            $query->whereAny(['name','price','percentage'], 'LIKE' , '%' . $search . '%');
                        })
                        ->with(['user', 'product'])
                        ->paginate(4)->withQueryString();
                }
            }
    
            return view('Dashboard.deals', compact('deals', 'status'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
}
