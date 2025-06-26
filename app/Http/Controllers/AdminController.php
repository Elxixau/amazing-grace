<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QrAccess;
use App\Models\Ticket;
use App\Models\TicketGroup;
use App\Models\Post;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik umum
        $reservedTickets = Ticket::whereHas('qrAccess', function ($query) {
            $query->whereNull('is_scanned')->orWhere('is_scanned', false);
        })->count();
        $totalTickets = Ticket::count();
        $usedTickets = QrAccess::where('is_scanned', true)->count();
        $remainingQuota = TicketGroup::sum('quota');
        $groupCount = TicketGroup::count();

        // Statistik untuk admin saat ini
        $myScannedCount = QrAccess::where('is_scanned', true)
            ->where('scanned_by', $user->id)
            ->count();

        $myRecentScans = QrAccess::with('ticket')
            ->where('is_scanned', true)
            ->where('scanned_by', $user->id)
            ->latest('scanned_at')
            ->take(5)
            ->get();

        // Admin scan summary
        $scanningAdmins = User::whereIn('id', QrAccess::pluck('scanned_by'))
            ->withCount(['qrAccess as total_scans' => function ($query) {
                $query->where('is_scanned', true);
            }])
            ->orderByDesc('total_scans')
            ->get();

        $totalScanningAdmins = $scanningAdmins->count();
        $totalTicketsScanned = QrAccess::where('is_scanned', true)->count();

        // Post Info aktif
        $post = Post::where('show', 1)->latest()->first();

        return view('admin.dashboard', compact(
            'totalTickets',
            'reservedTickets',
            'usedTickets',
            'remainingQuota',
            'groupCount',
            'myScannedCount',
            'myRecentScans',
            'post',
            'scanningAdmins',
            'totalScanningAdmins',
            'totalTicketsScanned'
        ));
    }
}
