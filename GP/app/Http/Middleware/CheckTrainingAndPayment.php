<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTrainingAndPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        // Calculate the total training hours
        $totalTrainingHours = $student->bookings()
            ->where('status', 'present')
            ->sum('duration');

        // Check if the student has completed 10 hours of training
        $totalTrainingHours = $totalTrainingHours * 1.5; // Each class is 1.5 hours

        // Check if the student has paid the full course price
        $hasPaidFullCoursePrice = $student->payments()
            ->where('status', 'approved')
            ->sum('total_payment') >= $student->courses->sum('price');

        if ($totalTrainingHours < 10 || !$hasPaidFullCoursePrice) {
            return redirect()->route('dashboard')->with('error', 'You need to complete 10 hours of training and pay the full course price.');
        }

        return $next($request);
    }
}
