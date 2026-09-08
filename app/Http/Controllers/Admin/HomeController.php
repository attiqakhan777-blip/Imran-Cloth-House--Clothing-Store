<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\Customer;

class HomeController extends Controller
{
    // =========================
    // HOME PAGE BUILDER (FIXED)
    // =========================
    public function index()
    {
        // ❌ FIX: you were not passing sections
        $sections = HomeSection::orderBy('sort_order', 'asc')->get();

        return view('admin.home.index', compact('sections'));
    }

    // =========================
    // DASHBOARD
    // =========================
    public function dashboard()
    {
    $totalProducts = Product::count();
    $totalCustomers = Customer::count();
    $totalOrders = DB::table('customer_orders')->count();

    // Revenue from delivered (confirmed) orders — column is `total`, not `total_amount`
    $totalRevenue = (float) DB::table('customer_orders')
        ->where('status', 'delivered')
        ->sum('total');

    $pendingOrders = DB::table('customer_orders')
        ->where('status', 'pending')
        ->count();

    $deliveredOrders = DB::table('customer_orders')
        ->where('status', 'delivered')
        ->count();

    $returnedOrders = DB::table('customer_orders')
        ->where('status', 'returned')
        ->count();

    $averageOrderValue = $deliveredOrders > 0
        ? $totalRevenue / $deliveredOrders
        : 0;

    $recentOrders = DB::table('customer_orders')
        ->latest()
        ->take(6)
        ->get();

    // =========================
    // BEST SELLING PRODUCTS
    // =========================

    $bestSellingProducts = DB::table('customer_order_items')
        ->select(
            'product_name',
            DB::raw('SUM(quantity) as total_quantity')
        )
        ->groupBy('product_name')
        ->orderByDesc('total_quantity')
        ->take(8)
        ->get();

    // =========================
    // DAILY ORDERS (LAST 7 DAYS)
    // =========================

    $dailyOrdersRaw = DB::table('customer_orders')
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', now()->subDays(6))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get();

    $dailyLabels = [];
    $dailyData = [];

    for ($i = 6; $i >= 0; $i--) {

        $date = now()->subDays($i)->format('Y-m-d');

        $dailyLabels[] = now()->subDays($i)->format('d M');

        $found = $dailyOrdersRaw->firstWhere('date', $date);

        $dailyData[] = $found ? $found->total : 0;
    }

    return view('admin.dashboard', compact(
        'totalProducts',
        'totalCustomers',
        'totalOrders',
        'totalRevenue',
        'pendingOrders',
        'deliveredOrders',
        'returnedOrders',
        'averageOrderValue',
        'recentOrders',
        'bestSellingProducts',
        'dailyLabels',
        'dailyData'
    ));
    }

    // =========================
    // EDIT SECTION
    // =========================
    public function edit($section)
    {
        $section = HomeSection::where('section_name', $section)->firstOrFail();

        return view('admin.home.edit', compact('section'));
    }

    // =========================
    // UPDATE SECTION
    // =========================
    public function update(Request $request, $section)
    {
        $homeSection = HomeSection::where('section_name', $section)->firstOrFail();

        $homeSection->title = $request->title;
        $homeSection->subtitle = $request->subtitle;
        $homeSection->is_active = $request->has('is_active');

        $processed = [];

        // ================= HERO =================
        if ($section === 'hero') {

            foreach ($request->slides ?? [] as $i => $slide) {

                $item = [];

                if ($request->hasFile("slides.$i.new_image")) {
                    $path = $request->file("slides.$i.new_image")
                        ->store('uploads/home/hero', 'public');

                    $item['image'] = 'storage/' . $path;
                } else {
                    $item['image'] = $slide['image'] ?? null;
                }

                if (!$item['image']) continue;

                $item['title'] = $slide['title'] ?? null;
                $item['subtitle'] = $slide['subtitle'] ?? null;
                $item['link'] = $slide['link'] ?? '#';

                $processed[] = $item;
            }
        }

        // ================= COLLECTIONS =================
        elseif ($section === 'collections') {

            foreach ($request->collections ?? [] as $i => $item) {

                $data = [];

                if ($request->hasFile("collections.$i.new_image")) {
                    $path = $request->file("collections.$i.new_image")
                        ->store('uploads/home/collections', 'public');

                    $data['image'] = 'storage/' . $path;
                } else {
                    $data['image'] = $item['image'] ?? null;
                }

                if (!$data['image']) continue;

                $data['title'] = $item['title'] ?? null;
                $data['link'] = $item['link'] ?? '#';
                $data['sale'] = isset($item['sale']);

                $processed[] = $data;
            }
        }

        // ================= OTHER SECTIONS =================
        else {

            foreach ($request->items ?? [] as $i => $item) {

                $data = [];

                if ($request->hasFile("items.$i.new_image")) {
                    $path = $request->file("items.$i.new_image")
                        ->store('uploads/home/sections', 'public');

                    $data['image'] = 'storage/' . $path;
                } else {
                    $data['image'] = $item['image'] ?? null;
                }

                if (!$data['image']) continue;

                $data['title'] = $item['title'] ?? null;
                $data['subtitle'] = $item['subtitle'] ?? null;
                $data['link'] = $item['link'] ?? '#';

                $processed[] = $data;
            }
        }

        $homeSection->data = $processed;
        $homeSection->save();

        return redirect()
            ->route('admin.home.manage')
            ->with('success', 'Section updated successfully!');
    }

    // =========================
    // STORE SECTION
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'section_name' => 'required|string|max:255|unique:home_sections,section_name',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
        ]);

        HomeSection::create([
            'section_name' => Str::slug($request->section_name, '_'),
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'data' => [],
            'sort_order' => HomeSection::max('sort_order') + 1,
            'is_active' => 1,
        ]);

        return redirect()
            ->route('admin.home.manage')
            ->with('success', 'Homepage section created successfully!');
    }

    // =========================
    // DELETE SECTION
    // =========================
    public function destroy($section)
    {
        $homeSection = HomeSection::where('section_name', $section)->firstOrFail();

        if (in_array($homeSection->section_name, ['hero', 'collections'])) {
            return back()->with('error', 'Hero and Collections cannot be deleted.');
        }

        $homeSection->delete();

        return back()->with('success', 'Section deleted successfully!');
    }
}