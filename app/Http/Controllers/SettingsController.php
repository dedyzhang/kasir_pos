<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Tables;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index() : View {
        $tables = Tables::orderBy('sort','asc')->get();
        $settings = Settings::all();
        return view('settings.index',compact('tables','settings'));
    }
    /**
     * Tables - create Tables
     */
    public function tableCreate(Request $request) {
        $request->validate([
            'table_name' => 'required',
            'table_color' => 'required',
        ]);
        $table_count = Tables::count() + 1;
        Tables::create([
            'name' => $request->table_name,
            'color' => $request->table_color,
            'sort' => $table_count,
            'status' => 'empty'
        ]);
        return redirect()->back()->with('success_table','Successfully Add Table');
    }
    /**
     * Tables - Sort Tables
     */
    public function tableSort(Request $request) {
        $tables = $request->urutan;

        Tables::upsert($tables, 'uuid', ['sort','name','color']);

        return response()->json(['success' => true,'message' => 'Successfully Sorted the table']);
    }
    /**
     * Tables - Delete Tables
     */
    public function tableDelete(String $uuid) {
        $table = Tables::findOrFail($uuid)->delete();

        return response()->json(['success' => true, "message" => 'Successfully Deleted Table']);
    }
    public function paymentTaxUpdate(Request $request) {
        $request->validate([
            'tax' => 'required|numeric|min:0'
        ]);

        Settings::updateOrCreate(
            ['jenis' => 'payment_tax'],
            ['nilai' => $request->tax]
        );

        return redirect()->back()->with('success_tax','Successfully Updated Payment Tax');
    }
    public function restaurantUpdate(Request $request) {
        $request->validate([
            'restaurant_name' => 'required|string|max:255',
        ]);
        // dd($request->all());
        $oldSetting = Settings::where('jenis','restaurant_logo')->first();
        $file = $request->file('picture');
        if($file == null && $request->is_changed == 0) {
            
        } else if ($file == null && $request->is_changed == 1) {
            if($oldSetting->nilai != "") {
                $oldPath = storage_path('app/public/') . $oldSetting->nilai;
                unlink($oldPath);
            }
            Settings::updateOrCreate(
                ['jenis' => 'restaurant_logo'],
                ['nilai' => '']
            );
        } else if($file != null && $request->is_changed == 1) {
            if($oldSetting->nilai != "") {
                $oldPath = storage_path('app/public/') . $oldSetting->nilai;
                unlink($oldPath);
            }

            $imagePath = $request->file('picture');
            $filename = $imagePath->hashName();
            $imagePath->storeAs('', $filename);
            Settings::updateOrCreate(
                ['jenis' => 'restaurant_logo'],
                ['nilai' => $filename]
            );
        } else {
            if($oldSetting->nilai != "") {
                $oldPath = storage_path('app/public/') . $oldSetting->nilai;
                unlink($oldPath);
            }
            $imagePath = $request->file('picture');
            $filename = $imagePath->hashName();
            $imagePath->storeAs('', $filename);
            Settings::updateOrCreate(
                ['jenis' => 'restaurant_logo'],
                ['nilai' => $filename]
            );
        }
        $restaurant_setting = array(
            'name' => $request->restaurant_name,
            'location' => $request->restaurant_location
        );

        Settings::updateOrCreate(
            ['jenis' => 'restaurant_settings'],
            ['nilai' => serialize($restaurant_setting)]
        );

        return redirect()->back()->with('success_restaurant','Successfully Updated Restaurant Data');
    }
}
