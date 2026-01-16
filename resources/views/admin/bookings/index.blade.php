@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4 text-dark font-weight-bold text-uppercase" style="letter-spacing: 2px;">Manage All Bookings</h1>
    
    <div class="card border-0 shadow-none" style="border-radius: 0; border: 1px solid #eee !important;">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light small font-weight-bold text-uppercase">
                    <tr>
                        <th class="pl-4">Customer</th>
                        <th>Package</th>
                        <th>Date & Time</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="pr-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr class="small">
                        <td class="pl-4 align-middle"><strong>{{ $booking->user->name }}</strong></td>
                        <td class="align-middle">{{ $booking->package->name }}</td>
                        <td class="align-middle">{{ $booking->booking_date->format('d M Y') }} - {{ $booking->booking_time }}</td>
                        <td class="align-middle font-weight-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="align-middle">
                            <span class="badge {{ $booking->status == 'confirmed' ? 'badge-success' : 'badge-dark' }}" style="border-radius: 0;">
                                {{ strtoupper($booking->status) }}
                            </span>
                        </td>
                        <td class="pr-4 text-right align-middle">
                            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="custom-select-sm border-dark" style="border-radius: 0; font-size: 0.6rem;">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>CONFIRM</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>CANCEL</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection