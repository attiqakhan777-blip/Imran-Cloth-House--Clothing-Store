<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                'shipping_charges' => 630,
                'tax_charges' => 0,
                'handling_charges' => 0,
            ]);
        }

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'shipping_charges' => 'required|numeric',
            'tax_charges' => 'required|numeric',
            'handling_charges' => 'required|numeric',
        ]);

        $setting = Setting::first();

        $setting->update($request->all());

        return back()->with('success', 'Settings updated successfully');
    }
}