<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
 
.task{


  padding: 30px 40px;
}

        .small-img-group{
  display: flex;
  gap: 15px;
}
.single-pro-img {
    display: flex;
    width: 500px;
    height: 350px;
    gap: 10px;
    align-items: center;
}
.single-pro-img > img{
  width: 400px;
  height: 100%;
   
}
.small-img-group {
    display: flex;
    gap: 5px;
    flex-direction: column;
}
.small-img-group .small-col{
border: 1px solid #ddd;
border-radius: 5px;
cursor: pointer;
display: flex;
justify-content: center;
align-items: center;
width: 70px;
height: 70px;
}
.info{
    display: flex;
    align-items: center;
    flex-direction: row-reverse;
    justify-content: center;
    background: white;
}
.info .details{
    text-align: right;
    padding: 120px 80px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

}
.details h1{
    color: blue;
}
.rest_of_page{
    display: flex;
    align-items: center;
    justify-content: center;
}
.action{
display: flex;
flex-direction: column;
gap: 10px;
justify-content: center;
}
.action div{
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}
.edit{
    padding: 10px 20px;
    border-radius: 5px;
    color: white;
    border: none;
    text-decoration: none;
    background: rgb(107,170,252);
background: linear-gradient(90deg, rgba(107,170,252,1) 0%, rgba(48,95,236,1) 100%);
  }
  .delete{
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    color: white;
    text-align: center;
    background: rgb(239,94,122);
    background: linear-gradient(90deg, rgba(239,94,122,1) 0%, rgba(211,83,133,1) 100%);
  }
  @media screen and (max-width:950px){
.info{
    flex-wrap: wrap;
    flex-direction: column-reverse;
}
    .single-pro-img {
    display: flex;
    width: 300px;
    height: 200px;
    gap: 10px;
    align-items: center;
}
.single-pro-img > img{
  width: 280px;
  height: 100%;
}
.contain{
    display: flex;
    flex-direction: column;
    gap: 20px;
    align-items: flex-end;
    padding: 0 10px;
}
.icon{
    width: 15px;
    height: 15px;
}
.task{
    padding: 30px 20px;
}
.details{
    width: 100%;
}
}
    </style>
    <title>Document</title>
</head>
<body>
    @extends('layouts.sidebar')

    @section('rest_of_page')
    <div class="contain">

    <div class="icon">
        <i class="fa-solid f   a-bars"></i>
    </div>
    <div class="info">
        <div class="details">
            <div>
                <span>
                    اسم المنتج
                </span>
                <h1>
                    {{$product->name}}
                </h1>
            </div>
            <div>
                <span>
                    سعر المنتج
                </span>
                <h1>
                    {{$product->price}}
                </h1>
            </div>
            <div>
                <span>
                    نسبة المنتج
                </span>
                <h1>
                    {{$product->percentage}}
                </h1>
            </div>
            <div class="action">
                @if(auth()->user()->hasRole('admin'))
                <span>
                    الأجرائات
                </span>
                <div>
                    <a href="{{route('editProduct',$product)}}" class="edit">تعديل</a>
                    <form method="POST" action="{{route('deleteProduct',$product)}}">
                       @csrf
                       @method('DELETE')
                        <button type="submit" class="delete">حذف</button>
                    </form>
                </div>
                @else
                <span>انشاء طلب</span>
                <div>
                    <a href="{{route('createDeal',$product)}}" class="edit">انشاء</a>
                </div>
                @endif
            </div>

        </div>
        <div class="task task-seven">
            <div class="single-pro-img">
                  <div class="small-img-group">
                    @foreach ($product->images as $image)
                    <div class="small-col">
                        <img src="{{asset('storage/images/' . $image->url)}}" alt="" class="small-img" width="100%">
                      </div>
                    @endforeach
                  </div>
                    <img src="{{asset('storage/images/' . $product->images->first()->url)}}" alt="" id="mainImg" width="100%">
            </div>
            </div>
    </div>
</div>
    <script>
        const headphone=document.querySelectorAll(".small-img");
const big=document.querySelector("#mainImg");
for(let i=0;i<headphone.length;i++){
    headphone[i].addEventListener("click",function (){
    big.src=headphone[i].src;
    })
}
    </script>
    @endsection
</body>
</html>