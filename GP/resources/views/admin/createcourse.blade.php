<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Courses and Skills</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">
@extends('admin.layout')

@section('title', 'Add Course')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Manage Courses and Skills</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-8 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-bold mb-4 text-black">Add New Course and Skills</h2>
            <form id="addCourseForm" method="POST" action="{{ route('admin.storecourse') }}" class="space-y-6" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="picture" class="block text-gray-700 mb-2">Course Image</label>
                    <input type="file" id="picture" name="picture" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="courseName" class="block text-gray-700 mb-2">Course Name</label>
                    <input type="text" id="courseName" name="name" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="price" class="block text-gray-700 mb-2">Price</label>
                    <input type="text" id="price" name="price" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="minimum_hour" class="block text-gray-700 mb-2">Minimum Hours</label>
                    <input type="text" id="minimum_hour" name="minimum_hour" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="details" class="block text-gray-700 mb-2">Details</label>
                    <textarea id="details" name="detail" rows="4" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div id="skillsContainer" class="space-y-4 relative">
                    <div class="skill-field">
                        <label for="skillName" class="block text-gray-700 mb-2">Skill Name</label>
                        <div class="flex items-center space-x-2">
                            <input type="text" name="skills[]" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="button" class="text-blue-500 hover:text-blue-600" onclick="addSkillField(event)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                            <button type="button" class="text-red-500 hover:text-red-600 hidden" onclick="removeSkillField(event)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="warning" class="text-red-500 hidden mt-4">Please fill in all fields before submitting.</div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">Add Course</button>
            </form>
        </div>
    </div>
@endsection

<script>
    function addSkillField(event) {
        event.preventDefault();
        var skillsContainer = document.getElementById('skillsContainer');
        var newSkillField = document.createElement('div');
        newSkillField.className = 'skill-field';
        newSkillField.innerHTML = `
            <label for="skillName" class="block text-gray-700 mb-2">Skill Name</label>
            <div class="flex items-center space-x-2">
                <input type="text" name="skills[]" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="button" class="text-blue-500 hover:text-blue-600" onclick="addSkillField(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
                <button type="button" class="text-red-500 hover:text-red-600" onclick="removeSkillField(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </button>
            </div>
        `;
        skillsContainer.appendChild(newSkillField);
        updateRemoveButtons();
    }

    function removeSkillField(event) {
        event.preventDefault();
        var skillField = event.target.closest('.skill-field');
        skillField.remove();
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        var skillFields = document.querySelectorAll('.skill-field');
        var removeButtons = document.querySelectorAll('.skill-field button:nth-child(3)');
        if (skillFields.length > 1) {
            removeButtons.forEach(function(button) {
                button.classList.remove('hidden');
            });
        } else {
            removeButtons.forEach(function(button) {
                button.classList.add('hidden');
            });
        }
    }

    // Initial call to updateRemoveButtons to set the correct visibility on page load
    updateRemoveButtons();
</script>
</body>
</html>
