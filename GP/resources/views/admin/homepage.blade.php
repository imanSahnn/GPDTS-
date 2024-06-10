<!-- resources/views/home.blade.php -->
@extends('admin.layout')

@section('title', 'Home')

@section('content')
    <div class="grid">
        <section>
            <hgroup>
                <h2>Welcome to My Laravel App</h2>
                <h3>Home Page</h3>
            </hgroup>
            <p>This is the home page of your Laravel application.</p>
            <figure>
                <img src="https://via.placeholder.com/600x400" alt="Placeholder Image">
                <figcaption><a href="https://unsplash.com" target="_blank">Image Source</a></figcaption>
            </figure>
            <h3>Section Heading</h3>
            <p>Some more content goes here.</p>
            <h3>Another Heading</h3>
            <p>Even more content goes here.</p>
        </section>
    </div>
    <section aria-label="Subscribe example">
        <div class="container">
            <article>
                <hgroup>
                    <h2>Subscribe to our newsletter</h2>
                    <h3>Stay updated with our latest news</h3>
                </hgroup>
                <form class="grid">
                    <input type="text" id="firstname" name="firstname" placeholder="First Name" aria-label="First Name" required />
                    <input type="email" id="email" name="email" placeholder="Email Address" aria-label="Email Address" required />
                    <button type="submit" onclick="event.preventDefault()">Subscribe</button>
                </form>
            </article>
        </div>
    </section>
@endsection
