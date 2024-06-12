@extends('admin.layout')

@section('content')
    <h1>Ratings of Tutors</h1>
    <canvas id="ratingsOfTutorsChart"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('ratingsOfTutorsChart').getContext('2d');
            var ratingsOfTutorsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($tutors->pluck('name')),
                    datasets: [{
                        label: 'Average Rating',
                        data: @json($tutors->pluck('ratings_avg_rate')),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
