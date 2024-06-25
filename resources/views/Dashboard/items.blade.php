<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<body>
    @extends('layouts.sidebar')
    @section('rest_of_page')
    <div class="up">
        <div class="search_container">
            <form method="GET" action="{{route('productsSearch')}}">
                <input type="search" class="search-input" placeholder="بحث" name="search" dlr="rtl">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3251 12.8985L19.7048 18.2783C19.8939 18.4676 20.0001 18.7242 20 18.9917C19.9999 19.2592 19.8935 19.5157 19.7043 19.7048C19.5151 19.8939 19.2585 20.0001 18.991 20C18.7235 19.9999 18.467 19.8935 18.2779 19.7043L12.8981 14.3244C11.2899 15.5701 9.26759 16.1563 7.24253 15.9638C5.21748 15.7712 3.34182 14.8145 1.99713 13.2881C0.652446 11.7617 -0.0602623 9.78035 0.00399614 7.74712C0.0682545 5.7139 0.904653 3.78152 2.34304 2.3431C3.78143 0.904675 5.71376 0.0682562 7.74693 0.00399624C9.7801 -0.0602638 11.7614 0.652463 13.2877 1.99718C14.8141 3.3419 15.7708 5.21761 15.9634 7.24271C16.1559 9.26782 15.5697 11.2902 14.3241 12.8985H14.3251ZM8.00037 13.9994C9.5916 13.9994 11.1176 13.3673 12.2428 12.2421C13.368 11.1169 14.0001 9.59084 14.0001 7.99957C14.0001 6.40831 13.368 4.88222 12.2428 3.75702C11.1176 2.63183 9.5916 1.9997 8.00037 1.9997C6.40915 1.9997 4.88309 2.63183 3.75793 3.75702C2.63276 4.88222 2.00065 6.40831 2.00065 7.99957C2.00065 9.59084 2.63276 11.1169 3.75793 12.2421C4.88309 13.3673 6.40915 13.9994 8.00037 13.9994Z" fill="#D2D2D2"/>
                    </svg>  
            </form>

        </div>
        <div class="title">
            <h1>المنتجات</h1>
            <a href="{{ route('addProduct') }}">إضافة منتج</a>
            <div class="icon">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>
    <table><tr>
        <th>الرقم</th>
        <th>اسم المنتج</th>
        <th>السعر</th>
        <th>النسبة</th>
        <th>التفاصيل</th>
        <th>تعديل</th>
        <th>حذف</th>
    </tr>
            @foreach ($products as $product)
                <tr>
                    <td data-cell="رقم المنتج">{{$product->id}}</td>
                    <td data-cell="اسم المنتج">{{$product->name}}</td>
                    <td data-cell="سعر المنتج">{{$product->price}}</td>
                    <td data-cell="نسبة المنتج">{{$product->percentage}}</td>
                    <td data-cell="التفاصيل"><a href="{{route('showProduct',$product)}}" class="show">تفاصيل</a></td>
                    <td data-cell="تعديل"><a href="{{route('editProduct',$product)}}" class="edit">تعديل</a></td>
                    <td data-cell="حذف"><form method="POST" action="{{route('deleteProduct',$product)}}" >
                        @csrf
                        @method('delete')
                        <button type="submit" class="delete">حذف</button>
                    </form></td>
                </tr>
            @endforeach
    </table>
<div>

</div>
<footer>
    {{ $products->onEachSide(1)->links('pagination::custom') }}
</footer>
    @endsection
    
</body>
</html>