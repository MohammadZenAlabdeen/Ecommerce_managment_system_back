<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .show, .delete{
        width: 120px !important;
    }
    .update{
        color: white;
        text-decoration: none;
        margin: 0 auto;
    }
    .update span{
        display: flex;
        width: 120px;
        padding: 10px 20px;
        border-radius: 5px;
        background: rgb(107,170,252);
        background: linear-gradient(90deg, rgba(107,170,252,1) 0%, rgba(48,95,236,1) 100%);
        justify-content: center;
        margin: 0 auto;
        align-items: center;
    }
    
</style>
<body>
    @extends('layouts.sidebar')
    @section('rest_of_page')
    <div class="up">
        <div class="search_container">
            <form method="GET" action="{{route('requestsSearch')}}">
                <input type="search" name="search" class="search-input" placeholder="بحث">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3251 12.8985L19.7048 18.2783C19.8939 18.4676 20.0001 18.7242 20 18.9917C19.9999 19.2592 19.8935 19.5157 19.7043 19.7048C19.5151 19.8939 19.2585 20.0001 18.991 20C18.7235 19.9999 18.467 19.8935 18.2779 19.7043L12.8981 14.3244C11.2899 15.5701 9.26759 16.1563 7.24253 15.9638C5.21748 15.7712 3.34182 14.8145 1.99713 13.2881C0.652446 11.7617 -0.0602623 9.78035 0.00399614 7.74712C0.0682545 5.7139 0.904653 3.78152 2.34304 2.3431C3.78143 0.904675 5.71376 0.0682562 7.74693 0.00399624C9.7801 -0.0602638 11.7614 0.652463 13.2877 1.99718C14.8141 3.3419 15.7708 5.21761 15.9634 7.24271C16.1559 9.26782 15.5697 11.2902 14.3241 12.8985H14.3251ZM8.00037 13.9994C9.5916 13.9994 11.1176 13.3673 12.2428 12.2421C13.368 11.1169 14.0001 9.59084 14.0001 7.99957C14.0001 6.40831 13.368 4.88222 12.2428 3.75702C11.1176 2.63183 9.5916 1.9997 8.00037 1.9997C6.40915 1.9997 4.88309 2.63183 3.75793 3.75702C2.63276 4.88222 2.00065 6.40831 2.00065 7.99957C2.00065 9.59084 2.63276 11.1169 3.75793 12.2421C4.88309 13.3673 6.40915 13.9994 8.00037 13.9994Z" fill="#D2D2D2"/>
                    </svg>                
            </input>
            </form>

        </div>
        <div class="title">
            <h1>المنتجات المقترحة</h1>
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
        <th>تعديل</th>
        <th>قبول المنتج</th>
        <th>رفض المنتج</th>
    </tr>
            @foreach ($requests as $request)
                <tr>
                    <td data-cell="رقم المنتج المقترح">{{$request->id}}</td>
                    <td data-cell="اسم المنتج">{{$request->name}}</td>
                    <td data-cell="سعر المنتج">{{$request->price}}</td>
                    <td data-cell="نسبة المنتج">{{$request->percentage}}</td>
                    <td data-cell="تعديل المنتج" class="update-cell">
                        <a href="{{route('editRequest',$request->id)}}" class="update">
                            <span>تعديل المنتج</span></a>
                    </td>
                    <td data-cell="قبول المنتج"> <form method="POST" action="{{route('acceptRequest',$request)}}" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="show" style="width: max-content;">قبول المنتج</button>
                    </form></td>
                    <td data-cell="رفض المنتج"><form method="POST" action="{{route('deleteRequest',$request)}}" >
                        @csrf
                        @method('delete')
                        <button type="submit" class="delete">رفض المنتج</button>
                    </form></td>
                </tr>
            @endforeach
    </table>
<footer>
    {{$requests->links('pagination::custom')}}
</footer>
    @endsection
    
</body>
</html>