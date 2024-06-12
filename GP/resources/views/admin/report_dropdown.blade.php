<div class="form-group">
    <label for="report_type">Choose a report type:</label>
    <select id="report_type" class="form-control" onchange="location = this.value;">
        <option value="#">Select a report</option>
        <option value="{{ route('admin.popularityOfCourses') }}">Popularity of Courses</option>
        <option value="{{ route('admin.highestPaidCourse') }}">Highest Paid Course</option>
        <option value="{{ route('admin.mostPopularTutor') }}">Most Popular Tutor</option>
        <option value="{{ route('admin.ratingOfTutors') }}">Rating of Tutors</option>
        <option value="{{ route('admin.commentsForTutors') }}">Comments for Tutors</option>
        <option value="{{ route('admin.mostBookedTime') }}">Most Booked Time</option>
    </select>
</div>
