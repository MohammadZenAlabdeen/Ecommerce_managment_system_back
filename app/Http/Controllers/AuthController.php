<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;


class AuthController extends Controller
{

    public function showlogin()
    {
        return view('Users.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('showlogin');
    }
    public function home()
    {
        if (auth()->user()->hasRole('admin')) {
            $deals = Deal::where('done', 1)->orderBy('created_at', 'desc')->limit(10)->get();
            $currentYear = Carbon::now()->year; // Get the current year
            $waitingDeals = Deal::where('done', 0)->count();
            $products = Product::count();
            $requested = ProductRequest::count();
            $sellers = User::role('seller')->count();
            // Query to fetch count of completed deals for the current year grouped by month
            $monthlyCounts = Deal::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as deal_count'))
                ->where('done', 1) // Filter deals where done == 1
                ->whereYear('created_at', $currentYear) // Filter by current year
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                ->orderBy('month', 'asc') // Order by month in ascending order
                ->get();
            return view('Dashboard.home', compact('deals', 'monthlyCounts', 'sellers', 'waitingDeals', 'requested', 'products'));
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            "name" => "required",
            "password" => "required",
        ]);
        if (auth()->attempt($request->only(['name', 'password']))) {
            if(auth()->user()->hasRole('admin')){
                return redirect()->route('home');

            }else{
                return redirect()->route('sellerDashboard');
            }
        } else {
            return redirect()->back()->withErrors(['Error' => 'Wrong info entered']);
        }
    }
    public function apiLogin(Request $request){
        $credentials = $request->validate([
            'name' => 'required',
            'password' =>'required'
        ]);
        $user=User::where('name',$credentials['name'])->first();
        if(!$user ||!Hash::check($credentials['password'],$user->password)){
            return response()->json(
                [
                    'status'=>'failed',
                    'message' =>'banned or wrong info or does not exist',
                ],401
            );
        }
        auth()->attempt($request->only(['name', 'password']));
        $token= $user->createToken($credentials['name'])->plainTextToken;
        $response=[
            'status' => 'success',
            'message' => 'user logged in successfully',
            'data' => [
                'token' => $token,
                'user' => $user,
            ],
        ];
        return response()->json($response,201);
    }
    public function landing(){
        return view('DashboardSellers.landing'); 
        }
        public function sellerDashboard(){
            $currentYear = Carbon::now()->year; // Get the current year
            $monthlyCounts = Deal::where('user_id', auth()->user()->id)
            ->where('done', 1) // Filter deals where done == 1
            ->whereYear('created_at', $currentYear) // Filter by current year
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as deal_count'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'), 'asc')
            ->orderBy(DB::raw('MONTH(created_at)'), 'asc') // Order by year and month in ascending order
            ->get();
             return view('DashboardSellers.dashboard',compact('monthlyCounts'));
         }
}
