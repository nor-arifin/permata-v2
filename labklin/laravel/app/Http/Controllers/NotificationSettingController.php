<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use App\Services\FonnteService;
use Illuminate\Http\Request;

class NotificationSettingController extends Controller
{
    public function edit()
    {
        $menu = 'setting';
        $submenu = 'notification';
        $setting = NotificationSetting::firstOrCreate([], [
            'api_token' => '',
            'fallback_number' => '',
            'is_active' => false,
        ]);

        return view('pages.notification_setting.edit', compact('setting', 'menu', 'submenu'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'api_token' => 'nullable|string',
            'fallback_number' => 'nullable|string|max:20',
            'is_active' => 'required|in:0,1',
        ]);

        $setting = NotificationSetting::firstOrCreate([], [
            'api_token' => '',
            'fallback_number' => '',
            'is_active' => false,
        ]);

        $setting->update([
            'api_token' => $request->api_token,
            'fallback_number' => $request->fallback_number,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('notification.setting')->with('success', 'Notification setting updated successfully.');
    }

    public function test(Request $request)
    {
        $setting = NotificationSetting::first();

        if (!$setting || !$setting->api_token || !$setting->fallback_number) {
            return redirect()->route('notification.setting')->with('error', 'Please configure API Token and Fallback Number first.');
        }

        $response = FonnteService::send($setting->fallback_number, 'Test notification from LabKlin Systems.');
        $data = json_decode($response, true);

        if ($data && isset($data['status']) && $data['status']) {
            return redirect()->route('notification.setting')->with('success', 'Test notification sent successfully.');
        }

        $error = $data['detail'] ?? 'Failed to send test notification. Please check your API Token.';
        return redirect()->route('notification.setting')->with('error', $error);
    }
}
