@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Expenses</h3>
        </div>
        <div class="card-body">
            <div class="breadcrumb-container position-relative">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-borderless">
                            <thead>
                            <th>Expense Categories</th>
                            <th>Total</th>
                            </thead>
                            <tbody>
                            @if (count($expenses))
                                @foreach($expenses as $expense)
                                    <tr>
                                        <td>{{$expense->category}}</td>
                                        <td>₱{{$expense->total}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2">No Entries.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 text-center d-flex justify-content-center">
                        <div style="width: 65%">
                            <canvas id="myChart" width="100" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: '# of Votes',
                    data: @json($data),
                    backgroundColor: [
                        'rgb(22, 170, 255)',
                        'rgb(247, 185, 36)',
                        'rgb(63, 106, 216)',
                        'rgb(108, 117, 125)',
                        'rgb(58, 196, 125)',
                        'rgb(217, 37, 80)',
                        'rgb(68, 64, 84)',
                        'rgb(121, 76, 138)',
                        'rgb(52, 58, 64)',
                    ],
                    borderColor: [
                        'rgb(22, 170, 255)',
                        'rgb(247, 185, 36)',
                        'rgb(63, 106, 216)',
                        'rgb(108, 117, 125)',
                        'rgb(58, 196, 125)',
                        'rgb(217, 37, 80)',
                        'rgb(68, 64, 84)',
                        'rgb(121, 76, 138)',
                        'rgb(52, 58, 64)',
                    ],
                    borderWidth: 1
                }]
            },
        });
    </script>
@endsection()
