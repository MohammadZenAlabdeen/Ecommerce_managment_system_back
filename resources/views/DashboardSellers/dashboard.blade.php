<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Document</title>
</head>
<style>
    .results {
        position: absolute;
        padding: 0 15px;
        z-index: 13123123123213;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        background-color: white;
    }
    #nav-list, #nav-list li, #nav-list li a {
        width: 100%;
    }
    #nav-list li a {
        display: flex;
        flex-direction: row-reverse;
    }
    .relative {
        position: relative;
    }
    .results #nav-list li a {
        text-align: right;
        text-decoration: none;
        color: black;
    }
</style>
<body>
    @extends('layouts.sidebar')

    @section('rest_of_page')
    <div class="nav_custom">
      <div class="relative">
        <div class="search_container">
            <input type="search" class="search-input" id="search-input" placeholder="بحث">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3251 12.8985L19.7048 18.2783C19.8939 18.4676 20.0001 18.7242 20 18.9917C19.9999 19.2592 19.8935 19.5157 19.7043 19.7048C19.5151 19.8939 19.2585 20.0001 18.991 20C18.7235 19.9999 18.467 19.8935 18.2779 19.7043L12.8981 14.3244C11.2899 15.5701 9.26759 16.1563 7.24253 15.9638C5.21748 15.7712 3.34182 14.8145 1.99713 13.2881C0.652446 11.7617 -0.0602623 9.78035 0.00399614 7.74712C0.0682545 5.7139 0.904653 3.78152 2.34304 2.3431C3.78143 0.904675 5.71376 0.0682562 7.74693 0.00399624C9.7801 -0.0602638 11.7614 0.652463 13.2877 1.99718C14.8141 3.3419 15.7708 5.21761 15.9634 7.24271C16.1559 9.26782 15.5697 11.2902 14.3241 12.8985H14.3251ZM8.00037 13.9994C9.5916 13.9994 11.1176 13.3673 12.2428 12.2421C13.368 11.1169 14.0001 9.59084 14.0001 7.99957C14.0001 6.40831 13.368 4.88222 12.2428 3.75702C11.1176 2.63183 9.5916 1.9997 8.00037 1.9997C6.40915 1.9997 4.88309 2.63183 3.75793 3.75702C2.63276 4.88222 2.00065 6.40831 2.00065 7.99957C2.00065 9.59084 2.63276 11.1169 3.75793 12.2421C4.88309 13.3673 6.40915 13.9994 8.00037 13.9994Z" fill="#D2D2D2"/>
            </svg>
            </input>
        </div>
        <div class="results" id="res">
            <ul id="nav-list"></ul>
        </div>
      </div>

        <div class="iconContain">
            <h1 class="username">{{ auth()->user()->name }}</h1>
            <div class="icon">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>
    <div class="down">
        <div class="card_container">
            <div class="card_custom" id="card_one">
                <span>عدد الطلبات المنتهية</span>
                <h1>{{ auth()->user()->deals()->where('done', 1)->count() }}</h1>
            </div>
            <div class="card_custom" id="card_two">
                <span>عدد الطلبات المعلقة</span>
                <h1>{{ auth()->user()->deals()->where('done', 0)->count() }}</h1>
            </div>
            <div class="card_custom" id="card_three">
                <span>عدد الطلبات المرفوضة</span>
                <h1>{{ auth()->user()->deals()->onlyTrashed()->count() }}</h1>
            </div>
            <div class="card_custom" id="card_four">
                <span>عدد المنتجات المقترحة</span>
                <h1>{{ auth()->user()->requests()->count() }}</h1>
            </div>
        </div>
        <div class="info_container">
            <div class="last_deals">
                <table>
                    <tr>
                        <th>اسم المسوق</th>
                        <th>اسم الزبون</th>
                        <th>رقم الطلب</th>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>النسبة</th>
                    </tr>
                    @foreach ($deals = auth()->user()->deals()->latest('created_at')->limit(5)->get() as $deal)
                    <tr>
                        <td data-cell="اسم المسوق">{{ $deal->user->name }}</td>
                        <td data-cell="اسم الزبون">{{ $deal->client_name }}</td>
                        <td data-cell="رقم الطلب">{{ $deal->id }}</td>
                        <td data-cell="المنتج">{{ $deal->product->name }}</td>
                        <td data-cell="السعر">{{ $deal->product->price }}</td>
                        <td data-cell="النسبة">{{ $deal->product->percentage }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="chart">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('myChart').getContext('2d');

            const arabicMonths = [
                'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
                'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
            ];

            const dealsData = [
                @foreach ($monthlyCounts as $monthlyCount)
                    { month: '{{ $monthlyCount->month }}', count: {{ $monthlyCount->deal_count }} },
                @endforeach
            ];

            const fullYearData = [];
            for (let monthIndex = 1; monthIndex <= 12; monthIndex++) {
                const monthName = arabicMonths[monthIndex - 1];
                const dealCount = dealsData.find(item => parseInt(item.month) === monthIndex)?.count || 0;
                fullYearData.push({ month: monthName, count: dealCount });
            }

            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: fullYearData.map(item => item.month),
                    datasets: [{
                        label: 'عدد الطلبات المنهية',
                        data: fullYearData.map(item => item.count),
                        borderColor: 'rgba(255,0,0,0.5)',
                        backgroundColor: 'rgba(255,0,0,0.5)',
                        fill: true,
                        borderWidth: 2,
                        borderCapStyle: 'round',
                        borderJoinStyle: 'round'
                    }]
                },
                options: {
        scales: {
            yAxes: [{
                display: false
            }],
            xAxes: [{
                display: false
            }]
        },
        legend: {
            display: false
        },
        elements: {
            line: {
                tension: 0.4,
                borderWidth: 2,
                borderCapStyle: 'round',
                borderJoinStyle: 'round'
            }
        },
        tooltips: {
            callbacks: {
                title: function(tooltipItem, data) {
                    // Get the month index from the tooltipItem
                    const monthIndex = tooltipItem[0].index;
                    // Return the Arabic month name corresponding to the index
                    return fullYearData[monthIndex].month;
                }
            }
        }
                    },
                }
            );
        });

        const searchJson = [
            { name: 'الصفحة الرئيسية', link: '{{ route('sellerDashboard') }}' },
            { name: 'الطلبات', link: '{{ route('sellerDashboardDeals') }}' },
            { name: 'المنتجات المقترحة', link: '{{ route('sellerDashboardRequests') }}' }
        ];

        function search(searchJson, query) {
            return searchJson.filter(item => item.name.toLowerCase().includes(query.toLowerCase()));
        }

        const searchInput = document.getElementById("search-input");
        const res = document.getElementById('res');
        searchInput.addEventListener("input", (event) => {
            if (res.style.display != 'flex') {
                res.style.display = 'flex';
            }
            const query = event.target.value;
            const results = search(searchJson, query);

            const ul = document.getElementById("nav-list");
            ul.innerHTML = "";

            results.forEach((item) => {
                const li = document.createElement("li");
                li.innerHTML = `<a href="${item.link}"><span>${item.name}</span></a>`;
                ul.appendChild(li);
            });
        });

        window.addEventListener('click', (event) => {
            if (res.style.display == 'flex') {
                if (event.target != searchInput && !searchInput.contains(event.target)) {
                    res.style.display = 'none';
                }
            }
        });
    </script>
    @endsection
</body>
</html>
