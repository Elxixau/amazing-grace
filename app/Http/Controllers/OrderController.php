<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

use App\Mail\BookingConfirmation;
use App\Mail\TicketMail;

use App\Models\Post;
use App\Models\Ticket;
use App\Models\QrAccess;
use App\Models\TicketGroup;
use App\Models\TicketSetting;



class OrderController extends Controller
{
    function home(){

       $post = Post::where('status', 'published')
                ->where('show', true)
                ->with('tags')
                ->orderByDesc('published_at')
                ->first(); // hanya ambil satu

        return view('index', compact('post'));
    }

    function create()
    {
         $post = Post::where('show', true)->first();    

        $seatOptions = ['1', '2', '3'];

        // Ambil grup dengan kuota tersisa > 0
        $seatGroup = TicketGroup::where('quota', '>', 0)->get();

        // Ambil total tiket dari ticket_settings (opsional, misalnya pakai yang terbaru)
        $totalTickets = TicketSetting::latest()->first()->total_tickets ?? 0;

         
        return view('booking', [ 'title' => 'Booking Tiket'], compact('seatOptions', 'seatGroup', 'totalTickets', 'post'));
    }


   
public function store(Request $request)
{
     $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'seat_count' => 'required|integer|min:1|max:3',
        'seat_group' => 'required|uuid|exists:ticket_groups,group_code',
    ]);

    // Ambil grup yang dipilih user
    $group = TicketGroup::where('group_code', $request->seat_group)->first();

    // Cek apakah kuota cukup
    if ($group->quota < $request->seat_count) {
        return redirect()->back()->withErrors([
            'seat_group' => 'Kuota grup tidak mencukupi untuk jumlah seat yang dipilih.',
        ])->withInput();
    }

    // Buat ticket_id unik
    $ticketId = uniqid('TCKT-');

    // Simpan tiket
    $ticket = Ticket::create([
        'ticket_id' => $ticketId,
        'name' => $request->name,
        'email' => $request->email,
        'seat_count' => $request->seat_count,
        'seat_group' => $request->seat_group,
        'status' => 'UNSCANNED',
    ]);

    // Kurangi kuota grup
    $group->decrement('quota', $request->seat_count);

    // Buat data QR
    $qrData = route('admin.ticket.scan', ['ticket_id' => $ticketId]);
    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrData);

    // Simpan QR
    QrAccess::create([
        'ticket_id' => $ticket->ticket_id,
        'qr_path' => $qrUrl,
        'scanned_by' => 'UNKNOWN',
        'is_scanned' => false,
    ]);

    // Kirim email tiket
    Mail::to($request->email)->send(new TicketMail($ticket, $qrUrl));

    return redirect()->route('create')->with('success', 'Tiket berhasil dipesan. Cek email Anda (atau folder SPAM).');
}

}
