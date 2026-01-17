protected function schedule(Schedule $schedule) {
    $schedule->call(function () {
        Booking::where('status', 'pending')
               ->where('created_at', '<', now()->subHours(24))
               ->update(['status' => 'expired']);
    })->daily();
}