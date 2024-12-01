<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Footer;

class FooterController extends Controller
{
    public function edit()
    {
        // Lấy dữ liệu footer từ DB (giả sử có 1 record duy nhất)
        $footer = Footer::first();
        return view('admin.footer.edit', compact('footer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'about_us' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'working_hours' => 'nullable|string',
            'customer_service' => 'nullable|string',
        ]);

        $footer = Footer::first();
        if (!$footer) {
            $footer = new Footer();
        }
        
        // Cập nhật dữ liệu từ form
        $footer->about_us = $request->input('about_us');
        $footer->address = $request->input('address');
        $footer->phone = $request->input('phone');
        $footer->email = $request->input('email');
        $footer->working_hours = $request->input('working_hours');
        $footer->customer_service = $request->input('customer_service');
        
        $footer->save();

        return redirect()->back()->with('success', 'Footer updated successfully.');
    }
}
