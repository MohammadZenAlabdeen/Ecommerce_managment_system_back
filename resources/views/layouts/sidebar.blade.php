<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="sylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="outter" >
    <div class="container_custom">
    <div class="rest_of_page">
        @yield('rest_of_page')
    </div>
    <div class="sidebar">
        <div class="cross">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <form method="POST" action="{{route('logout')}}">
            @csrf
            <button type="submit" id="logout">
                <img src="{{asset('img/fluent_power-24-filled.svg')}}" src="logout">

            </button>
            </form>    
            @if(auth()->user()->hasRole('admin'))        
        <ul>
            <li>
                <a href="{{route('home')}}">            <span>الصفحة الرئيسية</span>
                    <img src="{{asset('img/Dashboard.svg')}}" alt="homepage"></a>

            </li>
            <li>
                <a href="{{route('deals')}}">                <span>الطلبات</span></span>
                    <img src="{{asset('img/Deals.svg')}}" alt="deals"></a>


            </li>
            <li>
                <a href="{{route('products')}}">    <span>المنتجات</span>
                    <img src="{{asset('img/Products.svg')}}" alt="Products"></a>


</li>
            <li>
                <a href="{{route('sellers')}}">
                <span>المسوقين</span>
                <img src="{{asset('img/Seller.svg')}}" alt="Sellers">
            </a>
            </li>
            <li>
                <a href="{{route('requests')}}">                <span>المنتجات المقترحة</span>
                    <img src="{{asset('img/Requested.svg')}}" alt="requested products"></a>


            </li>
        </ul>
        @else
        <ul>
            <li>
                <a href="{{route('sellerDashboard')}}">            <span>الصفحة الرئيسية</span>
                    <img src="{{asset('img/Dashboard.svg')}}" alt="homepage"></a>

            </li>
            <li>
                <a href="{{route('sellerDashboardDeals')}}">                <span>الطلبات</span></span>
                    <img src="{{asset('img/Deals.svg')}}" alt="deals"></a>


            </li>


            <li>
                <a href="{{route('sellerDashboardRequests')}}">                <span>المنتجات المقترحة</span>
                    <img src="{{asset('img/Requested.svg')}}" alt="requested products"></a>


            </li>
        </ul>
        @endif
    </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
<script src="{{asset('js/sidebar.js')}}"></script>

</body>
</html>