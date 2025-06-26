<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\QrAccess;


class QrAccessController extends Controller
{
    public function scanner()
    {
         $scannedTickets = QrAccess::with('ticket')
        ->where('is_scanned', true)
        ->where('scanned_by', Auth::id())
        ->latest('scanned_at')
        ->paginate(10); 

        return view('admin.scan.index', compact('scannedTickets'));
    }

    public function markAsScanned($id)
    {
        $qr = QrAccess::where('ticket_id', $id)->first();

        if (!$qr) {
            return response()->json(['message' => 'QR tidak ditemukan.'], 404);
        }

        if ($qr->is_scanned) {
            return response()->json(['message' => 'QR sudah pernah discan.'], 403);
        }

        $qr->update([
            'is_scanned' => true,
            'scanned_by' => Auth::id(), // Simpan ID admin
            'scanned_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'QR berhasil discan.']);
    }
}
