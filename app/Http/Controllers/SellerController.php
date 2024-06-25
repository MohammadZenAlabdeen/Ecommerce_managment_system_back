<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $sellers = User::role('seller')->paginate(4);

            return view('Dashboard.sellers', compact('sellers'));
        }
    }
    public function show(User $seller)
    {
        if (auth()->user()->hasRole('admin')) {
            $deals = $seller->deals()->where('done', 1)->paginate(4);
            $status = 'done';
            return view('Dashboard.showSeller', compact('seller', 'deals', 'status'));
        }
    }
    public function deals(Request $request, User $seller)
    {
        // Default status if no status is selected
        $status = 'done';

        // Check if a status is selected from the request
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 'done') {
                $deals = $seller->deals()->where('done', 1)->with('product')->paginate(4);
            } elseif ($status == 'waiting') {
                $deals = $seller->deals()->where('done', 0)->with('product')->paginate(2);
            } else {
                $deals = $seller->deals()->onlyTrashed()->with('product')->paginate(4);
            }
        } else {
            // Set initial status based on any logic you have
            // For example, you might want to default to 'done' if there are deals
            $deals = $seller->deals()->where('done', 1)->paginate(4);
            if ($deals->count() > 0) {
                $status = 'done';
            }
        }

        // Fetch deals based on selected status

        // Pass $status along with $seller and $deals to the view
        return view('Dashboard.showSeller', compact('seller', 'deals', 'status'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('admin')) {
            return view('Dashboard.createSeller');
        }
    }
    public function store(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            $validated = $request->validate([
                'name' => 'required|string',
                'number' => 'required|unique:users,number',
                'password' => 'required|min:8',
            ]);
            $role = $request->get('role');
            $user = new User();
            $user->name = $validated['name'];
            $user->number = $validated['number'];
            $user->password = Hash::make($validated['password']);
            $user->save();
            $user->assignRole($role);
            return redirect()->route('home');
        }
    }
    public function edit(User $seller)
    {
        if (auth()->user()->hasRole('admin')) {
            return view('Dashboard.editSeller', compact('seller'));
        }
    }
    public function update(Request $request, User $seller)
    {
        if (auth()->user()->hasRole('admin')) {
            $validated = $request->validate([
                'name' => 'required|string',
                'number' => 'required|unique:users,number',
                'password' => 'required|min:8',
            ]);
            $role = $request->input('role');
            $seller->name = $validated['name'];
            $seller->number = $validated['number'];
            $seller->password = Hash::make($validated['password']);
            $seller->save();
            $seller->assignRole($role);
            return redirect()->route('home');
        }
    }
    public function delete(User $seller)
    {
        if (auth()->user()->hasRole('admin')) {
            $seller->delete();
            return redirect()->route('home');
        }
    }
    public function search (Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
    
            $search = $request->input('search');
    
                    $sellers = User::role('seller')->whereAny([
                        'name',
                        'id',
                        'number',
                    ], 'LIKE', '%' . $search . '%')
                        ->paginate(4)->withQueryString();
            
    
            return view('Dashboard.sellers', compact('sellers'));
        } else {
            return redirect()->back()->withErrors('not authorised');
        }
    }
 public function dealsSearch(Request $request, User $seller)
{
    if (auth()->user()->hasRole('admin')) {
        $status = "done";
        $search = $request->input('search');

        if ($request->has('status')) {
            $status = $request->input('status');

            // Base query for seller's deals
            $query = $seller->deals()->latest('created_at');

            // Add status-specific filters
            if ($status == "done") {
                $query->where('done', 1);
            } elseif ($status == "waiting") {
                $query->where('done', 0);
            } else {
                $query = $seller->deals()->onlyTrashed()->latest('deleted_at');
            }

            // Add search conditions
            $query->where(function ($query) use ($search) {
                $query->where('client_name', 'LIKE', '%' . $search . '%')
                      ->orWhere('id', 'LIKE', '%' . $search . '%')
                      ->orWhere('client_number', 'LIKE', '%' . $search . '%')
                      ->orWhereHas('user', function ($query) use ($search) {
                          $query->where('name', 'LIKE', '%' . $search . '%');
                      })
                      ->orWhereHas('product', function ($query) use ($search) {
                          $query->where('name', 'LIKE', '%' . $search . '%');
                      });
            });

            // Paginate results
            $deals = $query->with(['user', 'product'])->paginate(4)->withQueryString();
        }

        return view('Dashboard.showSeller', compact('seller', 'deals', 'status'));
    } else {
        return redirect()->back()->withErrors('not authorised');
    }
}
public function sellerDealsSearchDashboard(Request $request){
    $status = "done";
    $search = $request->input('search');

    if ($request->has('status')) {
        $status = $request->input('status');
        // Base query for seller's deals
        $query = Deal::where('user_id',auth()->user()->id)->latest('created_at');

        // Add status-specific filters
        if ($status == "done") {
            $query->where('done', 1);
        } elseif ($status == "waiting") {
            $query->where('done', 0);
        } else {
            $query = Deal::where('user_id',auth()->user()->id)->onlyTrashed()->latest('deleted_at');
        }

        // Add search conditions
        $query->where(function ($query) use ($search) {
            $query->where('client_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('id', 'LIKE', '%' . $search . '%')
                  ->orWhere('client_number', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('user', function ($query) use ($search) {
                      $query->where('name', 'LIKE', '%' . $search . '%');
                  })
                  ->orWhereHas('product', function ($query) use ($search) {
                      $query->where('name', 'LIKE', '%' . $search . '%');
                  });
        });

        // Paginate results
        $deals = $query->with(['user', 'product'])->paginate(4)->withQueryString();
    }

    return view('DashboardSellers.deals', compact('deals', 'status'));

}

}
