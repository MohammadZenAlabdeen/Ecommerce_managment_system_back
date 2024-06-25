<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .pagination-wrap{
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
.pagination{
    display: flex;
    gap: 10px;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}
.pagination li a{
    text-decoration: none;
}
.pagination .page{

background-color: white;
color: black;
padding: 3px;
border: 1px solid black;
border-radius: 5px;

}.pagination .page span{
    width: 30px;
    height: 30px;
    display: flex;
align-items: center;
justify-content: center;
}
.pagination .page a{
    width: 25px;
    height: 25px;
    display: flex;
align-items: center;
color: black;
justify-content: center;
}
.pagination .active{
    color: white;
    background-color: black;
}
.next, .prev{
    border: 1px solid black;
    border-radius:5px;
    padding: 3px; 
    width: 25px;
    height: 25px;
    display: flex;
align-items: center;
justify-content: center;
text-decoration: none;
color: black;
background-color: white;
}
.info{
    color: darkgrey;
    width: 200px;
    text-align: center;
}
</style>
<body>
    <div class="pagination-wrap">
        @if($paginator->count()>0)
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="disabled"><span> < </span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="prev"> < </a></li>
            @endif
    
            @foreach (range(1, $paginator->lastPage(), 1) as $page)
                @if ($page == $paginator->currentPage())
                    <li class="active page"><span>{{ $page }}</span></li>
                @elseif (($page >= $paginator->currentPage() - 1) && ($page <= $paginator->currentPage() + 1))
                    <li class="page"><a href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endforeach
    
            @if ($paginator->hasMorePages())
                @if ($paginator->currentPage() !== $paginator->lastPage())
                    <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="next"> > </a></li>
                @else
                    <li class="disabled"><span> > </span></li>
                @endif
            @endif
        </ul>
        <p class="info">
            {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of {{ $paginator->total() }}
        </p>
        @else
        <p class="info">
            لا توجد بيانات ليتم عرضها
        </p>
        @endif
    </div>
    
</body>
</html>