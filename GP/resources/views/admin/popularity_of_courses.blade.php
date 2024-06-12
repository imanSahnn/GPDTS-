@extends('admin.layout')

@section('content')
    <h1>Popularity of Courses</h1>
    @include('admin.report_dropdown')

    @if($courses->isEmpty())
        <p>No data available.</p>
    @else
        <div style="width: 100%; max-width: 600px; margin: 0 auto;">
            <canvas id="popularityOfCoursesChart"></canvas>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('popularityOfCoursesChart').getContext('2d');
                var popularityOfCoursesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($courses->pluck('name')),
                        datasets: [{
                            label: 'Number of Bookings',
                            data: @json($courses->pluck('bookings_count')),
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endsection
