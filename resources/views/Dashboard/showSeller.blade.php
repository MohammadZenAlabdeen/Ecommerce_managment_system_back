
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        .details_container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }
        .details_container div {
            width: max-content;
            text-align: center;
        }
        .details_container span {
            font-size: 16px;
        }
        .details_container h1 {
            font-size: 20px;
        }
        .details_container div span, h1 {
            width: 100%;
        }
        .radio {
            display: flex;
            flex-direction: row-reverse;
            gap: 20px;
            width: 100%;
            margin-top: 20px;
            justify-content: flex-end;
            flex-wrap: wrap;
            padding-right: 20px;
            margin-bottom: 20px;
        }
        .radio form{
            display: flex;
            flex-direction: row-reverse;
            gap: 20px;
            width: 100%;
            margin-top: 20px;
            justify-content: flex-start;
            flex-wrap: wrap;
            padding-right: 20px;
        }
        .radio label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 16px;
            gap: 20px;
        }
        .radio input[type="radio"] {
            margin-left: 10px;
        }
        .radio form button{
        padding: 5px 10px;
        border: none;
        background: rgb(107,170,252);
        background: linear-gradient(90deg, rgba(107,170,252,1) 0%, rgba(48,95,236,1) 100%);
        color: white;
        border-radius: 5px;
        }
        .up_contain{
            width: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }
        .search{
            display: none
        }

        @media screen and (max-width:950px){
            .up{
                align-items: flex-start;
                width: 100%;
                flex-wrap: wrap;
                gap: 20px
            }
            .details_container{
                width: 100%;
                flex-direction: column;
            }
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
    <title>Document</title>
</head>
<body>
    @extends('layouts.sidebar')
    @section('rest_of_page')
    <div class="up">
        <div class="up_contain">
            <div class="search_container">
                <form method="GET" action="{{route('sellerDealsSearch',$seller)}}">
    <input type="search" class="search-input" placeholder="بحث" name="search" dlr="rtl">
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3251 12.8985L19.7048 18.2783C19.8939 18.4676 20.0001 18.7242 20 18.9917C19.9999 19.2592 19.8935 19.5157 19.7043 19.7048C19.5151 19.8939 19.2585 20.0001 18.991 20C18.7235 19.9999 18.467 19.8935 18.2779 19.7043L12.8981 14.3244C11.2899 15.5701 9.26759 16.1563 7.24253 15.9638C5.21748 15.7712 3.34182 14.8145 1.99713 13.2881C0.652446 11.7617 -0.0602623 9.78035 0.00399614 7.74712C0.0682545 5.7139 0.904653 3.78152 2.34304 2.3431C3.78143 0.904675 5.71376 0.0682562 7.74693 0.00399624C9.7801 -0.0602638 11.7614 0.652463 13.2877 1.99718C14.8141 3.3419 15.7708 5.21761 15.9634 7.24271C16.1559 9.26782 15.5697 11.2902 14.3241 12.8985H14.3251ZM8.00037 13.9994C9.5916 13.9994 11.1176 13.3673 12.2428 12.2421C13.368 11.1169 14.0001 9.59084 14.0001 7.99957C14.0001 6.40831 13.368 4.88222 12.2428 3.75702C11.1176 2.63183 9.5916 1.9997 8.00037 1.9997C6.40915 1.9997 4.88309 2.63183 3.75793 3.75702C2.63276 4.88222 2.00065 6.40831 2.00065 7.99957C2.00065 9.59084 2.63276 11.1169 3.75793 12.2421C4.88309 13.3673 6.40915 13.9994 8.00037 13.9994Z" fill="#D2D2D2"/>
        </svg>    
            <input type="radio" id="doneUp" class="search" name="status" value="done" {{ $status == 'done' ? 'checked' : '' }}>
            <input type="radio" id="waitingUp" class="search" name="status" value="waiting" {{ $status == 'waiting' ? 'checked' : '' }}>
            <input type="radio" id="deniedUp" class="search" name="status" value="denied" {{ $status == 'denied' ? 'checked' : '' }}>
    </input>
                </form>
            </div>
            <div class="icon">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>

    <div class="details_container">
        <div>
        <span>اسم المسوق</span>
        <h1>{{$seller->name}}</h1>
    </div>
    <div>
        <span>رقم المسوق</span>
        <h1>{{$seller->number}}</h1>
    </div>
    <div>
        <span>عدد الصفقات المنتهية</span>
        <h1>{{$seller->deals->where('done',1)->count()}}</h1>
    </div>
</div>
    </div>

    <div class="radio">
        <form method="GET" action="{{ route('sellerDeals', $seller) }}">
            <label for="done">
                <input type="radio" id="done" name="status" value="done" {{ $status == 'done' ? 'checked' : '' }}>
                الصفقات المنتهية
            </label>
            <label for="waiting">
                <input type="radio" id="waiting" name="status" value="waiting" {{ $status == 'waiting' ? 'checked' : '' }}>
                الصفقات المعلقة
            </label>
            <label for="denied">
                <input type="radio" id="denied" name="status" value="denied" {{ $status == 'denied' ? 'checked' : '' }}>
                الصفقات المرفوضة
            </label>
            <button type="submit">اظهر</button>
        </form>
    </div>
    @if($deals != null && count($deals) > 0)

    @if($deals[0]->done==1 || $deals[0]->deleted_at!=null)
    <table>
        <thead>
            <tr>
                <th>الرقم</th>
                <th>المسوق</th>
                <th>اسم الزبون</th>
                <th>رقم الزبون</th>
                <th>عنوان الزبون</th>
                <th>اسم المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>النسبة</th>
            </tr>   
        </thead>
        <tbody id="table-body">
                @foreach ($deals as $deal)
                <tr>
                    <td data-cell="رقم الطلب">{{$deal->id}}</td>
                    <td data-cell="اسم المسوق">{{$deal->user->name}}</td>
                    <td data-cell="اسم الزبون">{{$deal->client_name}}</td>
                    <td data-cell="رقم الزبون">{{$deal->client_number}}</td>
                    <td data-cell="عنوان الزبون">{{$deal->address}}</td>
                    <td data-cell="اسم المنتج">{{$deal->product->name}}</td>
                    <td data-cell="الكمية">{{$deal->count}}</td>
                    <td data-cell="السعر">{{$deal->product->price}}</td>
                    <td data-cell="النسبة">{{$deal->product->percentage}}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
@else
<table>
<thead>
    <tr>
        <th>الرقم</th>
        <th>المسوق</th>
        <th>اسم الزبون</th>
        <th>رقم الزبون</th>
        <th>عنوان الزبون</th>
        <th>اسم المنتج</th>
        <th>الكمية</th>
        <th>السعر</th>
        <th>النسبة</th>
        <th>العمليات</th>
    </tr>   
</thead>
<tbody id="table-body">
        @foreach ($deals as $deal)
        <tr>
            <td data-cell="رقم الطلب">{{$deal->id}}</td>
            <td data-cell="اسم المسوق">{{$deal->user->name}}</td>
            <td data-cell="اسم الزبون">{{$deal->client_name}}</td>
            <td data-cell="رقم الزبون">{{$deal->client_number}}</td>
            <td data-cell="عنوان الزبون">{{$deal->address}}</td>
            <td data-cell="اسم المنتج">{{$deal->product->name}}</td>
            <td data-cell="الكمية">{{$deal->count}}</td>
            <td data-cell="السعر">{{$deal->product->price}}</td>
            <td data-cell="النسبة">{{$deal->product->percentage}}</td>
            <td data-cell="العمليات" id="actions">
                <form method="POST" action="{{route('endDeal',$deal)}}">
                    @csrf
                    @method('put')
                    <button type="submit" class="show">انهاء</button>
                </form>
                <a href="{{route('editDeal',$deal)}}" class="edit">تعديل</a>

                <form method="POST" action="{{route('denyDeal',$deal)}}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="delete">رفض</button>
                </form>
            </td>

        </tr>
   
        @endforeach
</tbody>
</table>
@endif
@endif
<footer>
    {{$deals->links('pagination::custom')}}
</footer>
<script>
    let doneMain=document.getElementById('done');
    let waitingMain=document.getElementById('watiting');
    let deniedMain=document.getElementById('denied');
    let done=document.getElementById('doneUp');
    let waiting=document.getElementById('waitingUp');
    let denied=document.getElementById('deniedUp');
    doneMain.addEventListener('click', () => {
    done.checked = true;
    waiting.checked = false;
    denied.checked = false;
});

waitingMain.addEventListener('click', () => {
    waiting.checked = true;
    done.checked = false;
    denied.checked = false;
});

deniedMain.addEventListener('click', () => {
    denied.checked = true;
    waiting.checked = false;
    done.checked = false;
});

</script>
    @endsection
</body>
</html>