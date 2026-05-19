<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsappLog;
use Illuminate\Http\Request;

class WhatsappLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Tarik data log terbaru dengan pagination agar query tidak berat
        $logs = WhatsappLog::query()
            ->when($search, function ($query, $search) {
                $query->where('target', 'like', "%{$search}%")
                      ->orWhere('recipient_name', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.whatsapp_logs.index', compact('logs', 'search'));
    }
}