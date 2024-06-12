@extends('admin.layout')

@section('content')
    <h1>Most Popular Tutors</h1>
    @include('admin.report_dropdown')

    @if($tutors->isEmpty())
        <p>No data available.</p>
    @else
        <div style="width: 100%; max-width: 800px; margin: 20px auto;">
            <canvas id="mostPopularTutorsChart"></canvas>
        </div>

        <div class="text-center mt-4">
            <button onclick="printChart()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Print PDF
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('mostPopularTutorsChart').getContext('2d');
                var mostPopularTutorsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($tutors->pluck('name')),
                        datasets: [{
                            label: 'Number of Bookings',
                            data: @json($tutors->pluck('bookings_count')),
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
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

            function printChart() {
                var canvas = document.getElementById('mostPopularTutorsChart');
                var canvasImg = canvas.toDataURL('image/png', 1.0); // Get the image from the canvas

                var windowContent = '<!DOCTYPE html>';
                windowContent += '<html>';
                windowContent += '<head><title>Print chart</title></head>';
                windowContent += '<body>';
                windowContent += '<img src="' + canvasImg + '" style="width:100%;">';
                windowContent += '</body>';
                windowContent += '</html>';

                var printWin = window.open('', '', 'width=900,height=650');
                printWin.document.open();
                printWin.document.write(windowContent);
                printWin.document.close();
                printWin.focus();
                printWin.print();
                printWin.close();
            }
        </script>
    @endif
@endsection
