@extends('tutor.layout')

@section('title', 'Homepage')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Students List</h1>
    <div class="d-flex justify-content-center">
        <div class="table-responsive w-100">
            <table class="table table-bordered table-hover table-lg text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Picture</th>
                        <th scope="col">Name</th>
                        <th scope="col" class="d-none d-md-table-cell">IC</th>
                        <th scope="col">Number</th>
                        <th scope="col" class="d-none d-md-table-cell">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td class="align-middle ">
                                <img src="{{ asset('storage/' . $student->picture) }}" alt="Profile Picture" class="rounded-circle" style="width: 60px; height: 60px;">
                            </td>
                            <td class="align-middle">{{ $student->name }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ $student->ic }}</td>
                            <td class="align-middle">{{ $student->number }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ $student->email }}</td>
                            <td class="align-middle">
                                <a href="{{ route('studentdetail', ['id' => $student->id]) }}" class="btn btn-primary">View Booking</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<style>
    .table {
        max-width: 90%;
        border-collapse: collapse;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        margin: auto;
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: center;
    }

    .table thead th {
        background-color: #343a40;
        color: #ffffff;
    }

    .table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .table tbody tr:last-of-type {
        border-bottom: 2px solid #343a40;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .rounded-circle {
        border: 2px solid #343a40;
    }
    @media (max-width: 948px) {
        .table th, .table td {
            font-size: 12px;
            padding: 10px;
        }

        .table th.d-md-table-cell, .table td.d-md-table-cell {
            display: none;
        }

        .btn-primary {
            padding: 3px 8px;
            font-size: 12px;
        }
    }
    @media (max-width: 768px) {
        .table th, .table td {
            font-size: 12px;
            padding: 10px;
        }

        .table th.d-md-table-cell, .table td.d-md-table-cell {
            display: none;
        }

        .btn-primary {
            padding: 3px 8px;
            font-size: 12px;
        }
    }
</style>
