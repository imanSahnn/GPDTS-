@extends('admin.layout')

@section('title', 'Home')

@section('content')


    <!-- Pending Approvals Section -->
    <section aria-label="Pending Approvals">
        <div class="container">
            <article>
                <hgroup>
                    <h2>Pending Approvals</h2>
                </hgroup>
                <div class="grid">
                    @foreach($pendingApprovals as $student)
                        <div class="approval-item">
                            <h3>{{ $student->name }}</h3>
                            <p>Date: {{ $student->lesen_picture_date }}</p>
                            <figure>
                                <img src="{{ Storage::url('lesen_picture/' . $student->lesen_picture) }}" alt="Lesen Picture">
                            </figure>
                            <form action="{{ route('admin.approve', $student->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="approve" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                                <button type="submit" name="action" value="reject" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reject</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>
@endsection
