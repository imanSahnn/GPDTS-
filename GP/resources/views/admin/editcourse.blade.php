@extends('admin.layout')

@section('title', 'Edit course')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-3xl">
        Edit Course
    </h1>
    <form action="{{ route('admin.cupdate', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-8">
        @csrf
        <div class="flex flex-col md:flex-row md:items-center">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 md:w-1/4">Course Name</label>
            <input type="text" name="name" value="{{ old('name', $course->name) }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full md:w-3/4 p-2.5" required>
            @error('name')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex flex-col md:flex-row md:items-center">
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 md:w-1/4">Price</label>
            <input type="number" name="price" value="{{ old('price', $course->price) }}" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full md:w-3/4 p-2.5" required>
            @error('price')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex flex-col md:flex-row md:items-center">
            <label for="detail" class="block mb-2 text-sm font-medium text-gray-900 md:w-1/4">Detail</label>
            <textarea name="detail" id="detail" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full md:w-3/4 p-2.5" required>{{ old('detail', $course->detail) }}</textarea>
            @error('detail')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col md:flex-row md:items-center">
            <label for="skills" class="block mb-2 text-sm font-medium text-gray-900 md:w-1/4">Skills</label>
            <div id="skills-wrapper" class="w-full md:w-3/4">
                @foreach($course->skills as $skill)
                    <div class="flex items-center mb-2">
                        <input type="text" name="skills[]" value="{{ $skill->skill_name }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 mr-2" required>
                        <button type="button" class="remove-skill text-red-500 hover:text-red-700"><i class="fas fa-minus-circle"></i></button>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-end md:justify-start">
            <button type="button" id="add-skill" class="text-green-500 hover:text-green-700"><i class="fas fa-plus-circle"></i> Add Skill</button>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
        </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('add-skill').addEventListener('click', function() {
                var wrapper = document.getElementById('skills-wrapper');
                var newField = document.createElement('div');
                newField.classList.add('flex', 'items-center', 'mb-2');
                newField.innerHTML = `
                    <input type="text" name="skills[]" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 mr-2" required>
                    <button type="button" class="remove-skill text-red-500 hover:text-red-700"><i class="fas fa-minus-circle"></i></button>
                `;
                wrapper.appendChild(newField);

                newField.querySelector('.remove-skill').addEventListener('click', function() {
                    wrapper.removeChild(newField);
                });
            });

            document.querySelectorAll('.remove-skill').forEach(function(button) {
                button.addEventListener('click', function() {
                    var field = this.closest('.flex');
                    field.parentNode.removeChild(field);
                });
            });
        });
    </script>
@endsection
