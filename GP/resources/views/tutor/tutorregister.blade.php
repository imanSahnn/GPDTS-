<!DOCTYPE html>
<html lang="en" x-data="{ open: false }">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tutor Register</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
</head>
<body>
    <section class="bg-blue-100 min-h-screen flex items-center justify-center">
        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-lg xl:p-0 mx-4 md:mx-auto">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <div class="flex justify-center items-center">
                    <img src="{{ Storage::url('public/adminpage/gplogo.png') }}" alt="Gentian Padu Driving School Logo" class="h-12 w-12 mr-2">
                    <h1 class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-3xl text-center">
                        Gentian Padu Driving School
                    </h1>
                </div>
                <h2 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                    Create Tutor Account
                </h2>
                <form action="{{ route('tregister.save') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Your name</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name" required="">
                            @error('name')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" required="">
                            @error('email')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                            @error('password')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                            @error('password_confirmation')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label for="ic" class="block mb-2 text-sm font-medium text-gray-900">Your IC</label>
                            <input type="text" name="ic" id="ic" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="020700012033" required="">
                            @error('ic')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Your phone number</label>
                            <input type="text" name="number" id="number" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="01139144048" required="">
                            @error('number')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label for="course_id" class="block mb-2 text-sm font-medium text-gray-900">Course</label>
                            <select name="course_id" id="course_id" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                                <option value="">Select a Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="picture" class="block mb-2 text-sm font-medium text-gray-900">Profile Picture</label>
                            <input type="file" name="picture" id="picture" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            @error('picture')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-start mt-4">
                        <div class="flex items-center h-5">
                            <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300" required="">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-light text-gray-500">I accept the <a @click.prevent="open = true" class="font-medium text-primary-600 hover:underline" href="#">Terms and Conditions</a></label>
                        </div>
                    </div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create an account</button>
                    <p class="text-sm font-light text-gray-500">
                        Already have an account? <a href="{{ route('tlogin') }}" class="font-medium text-primary-600 hover:underline">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Terms and Conditions</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    <!-- Insert your terms and conditions content here -->
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="open = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
