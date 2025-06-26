<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketSetting;
use App\Models\TicketGroup;
use Illuminate\Support\Str;

class TicketSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // Ambil semua setting, bersama relasi ke grup
    $settings = TicketSetting::with('groups')->get();

    return view('admin.tickets.settings', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           $request->merge([
        'groups' => $request->input('groups', []),
    ]);

    $request->validate([
        'total_tickets' => 'required|integer|min:1',
        'use_grouping' => 'required|in:0,1',
        'groups' => 'required_if:use_grouping,1|array',
        'groups.*.group_name' => 'required_if:use_grouping,1|string',
        'groups.*.quota' => 'required_if:use_grouping,1|integer|min:1',
    ]);

    $setting = TicketSetting::create([
        'total_tickets' => $request->total_tickets,
        'use_grouping' => $request->use_grouping,
    ]);

    if ($request->use_grouping == '1') {
        foreach ($request->groups as $group) {
            TicketGroup::create([
                'group_code' => Str::uuid(),
                'group_name' => $group['group_name'],
                'name' => null,
                'quota' => $group['quota'],
                'ticket_setting_id' => $setting->id,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Ticket setting berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        
        $setting = TicketSetting::with('groups')->findOrFail($id);

        // Hapus semua grup terkait jika ada
        if ($setting->groups()->exists()) {
            $setting->groups()->delete();
        }

        // Hapus ticket setting
        $setting->delete();

        return redirect()->back()->with('success', 'Ticket setting berhasil dihapus!');
    }
}
