<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .rest_of_page {
            display: flex;
            width: 100%;
            justify-content: center;
            align-items: center;
            height: 100% !important;
        }
        .form-container {
            width: 100%;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-floating label {
            padding: 0.75rem 1rem;
        }
        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .form-container h3 {
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }
        .text-right {
            text-align: right;
        }
        @media screen and (max-width:950px){
            .rest_of_page{
                height: 100%;
            }
            .container_custom{
                height: 100% !important;
            }
        }
    </style>
    <title>Document</title>
</head>
<body>
    @extends('layouts.sidebar')
    @section('rest_of_page')
    <div class="form-container">
        <h3 class="mb-4">انشاء</h3>
        <form method="POST" action="{{ route('storeDeal',$product) }}">
            @csrf
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" id="client_name" class="form-control text-right"  name="client_name" placeholder="اسم الزبون"/>
                        <label for="client_name" class="text-right">اسم الزبون</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" id="client_number" class="form-control text-right"  name="client_number" placeholder="هاتف الزبون"/>
                        <label for="client_number" class="text-right">هاتف الزبون</label>
                    </div>
                </div>
            </div>
          
            <div class="form-floating mb-4">
                <input type="text" id="address" class="form-control text-right"  name="address" placeholder="عنوان الزبون"/>
                <label for="address" class="text-right">عنوان الزبون</label>
            </div>
          
            <div class="form-floating mb-4">
                <input type="number" id="count" class="form-control text-right" name="count"  placeholder="الكمية"/>
                <label for="count" class="text-right">الكمية</label>
            </div>
          
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mb-4">إنشاء الطلب</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @endsection
</body>
</html>
