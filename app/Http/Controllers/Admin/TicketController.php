<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\QrAccess;
use App\Models\TicketGroup;
use App\Models\TicketSetting;
use App\Mail\TicketMail;

class TicketController extends Controller
{
  public function index(Request $request)
{
        



    $totalTicket = Ticket::count();

    // Pakai relasi dengan penamaan sesuai method di model
    $query = Ticket::query()->with('qrAccess');

    // Pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Ambil data ticket terbaru
    $ticket = $query->latest()->paginate(10);

    $seatOptions = ['1', '2', '3'];
    
        // Ambil grup dengan kuota tersisa > 0
        $seatGroup = TicketGroup::where('quota', '>', 0)->get();


    return view('admin.tickets.index', compact('ticket', 'seatOptions', 'seatGroup', 'totalTicket'));
}


    // Ticket Edit Page
    public function edit($ticket_id){
   

         $ticket = Ticket::with('QrAccess')->where('ticket_id', $ticket_id)->firstOrFail();
        return view('admin.tickets.edit', compact('ticket'));
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

    return redirect()->route('admin.ticket.edit')->with('success', 'Tiket berhasil dipesan. Cek email Anda (atau folder SPAM).');
}

    // Update the Ticket
    public function update(Request $request, $id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,',
        'divisi' => 'required|in:inti,acara,pubdok,perlengkapan,humas',
        'password' => 'nullable',
        ]);

        
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email =$request->email;
        $user->divisi =$request->divisi;
        $user->password = bcrypt($request->password);

        $user->save();

        return redirect()->route('admin.ticket.edit', $user->id)->with('success', 'Data Ticket berhasil diubah.');
    }

    //Delete the ticket
    public function delete($ticket_id)
    {
        
         $ticket = Ticket::with('QrAccess')->where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->delete();

        return redirect()->route('admin.ticket.index')->with('success', 'Data Ticket - '.$ticket->ticket_id. ' - berhasil dihapus.');
    }
}
