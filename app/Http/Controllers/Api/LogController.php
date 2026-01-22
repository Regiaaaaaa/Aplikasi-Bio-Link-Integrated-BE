<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    // Get all log bundle
    public function getLogBundles(Request $request)
    {
        try {
            $userId = $request->user()->id;

            $logBundles = DB::table('log_bundles')
                ->join('bundles', 'log_bundles.bundle_id', '=', 'bundles.id')
                ->where('bundles.user_id', $userId)
                ->select(
                    'log_bundles.id',
                    'log_bundles.bundle_id',
                    'log_bundles.ip_address',
                    'log_bundles.user_agent',
                    'log_bundles.created_at'
                )
                ->orderBy('log_bundles.created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logBundles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch log bundles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    // Get all log links for authenticated user
    public function getLogLinks(Request $request)
    {
        try {
            $userId = $request->user()->id;

            $logLinks = DB::table('log_links')
                ->join('links', 'log_links.link_id', '=', 'links.id')
                ->join('bundles', 'links.bundle_id', '=', 'bundles.id')
                ->where('bundles.user_id', $userId)
                ->select(
                    'log_links.id',
                    'log_links.link_id',
                    'links.bundle_id',
                    'log_links.ip_address',
                    'log_links.user_agent',
                    'log_links.created_at'
                )
                ->orderBy('log_links.created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logLinks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch log links',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    // Get log bundles by bundle ID 
    public function getLogBundlesByBundleId(Request $request, $bundleId)
    {
        try {
            $userId = $request->user()->id;

            // Verify bundle belongs to user
            $bundle = DB::table('bundles')
                ->where('id', $bundleId)
                ->where('user_id', $userId)
                ->first();

            if (!$bundle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bundle not found'
                ], 404);
            }

            $logBundles = DB::table('log_bundles')
                ->where('bundle_id', $bundleId)
                ->select(
                    'id',
                    'bundle_id',
                    'ip_address',
                    'user_agent',
                    'created_at'
                )
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logBundles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch log bundles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    // Get log links by bundle ID 
    public function getLogLinksByBundleId(Request $request, $bundleId)
    {
        try {
            $userId = $request->user()->id;

            // Verify bundle belongs to user
            $bundle = DB::table('bundles')
                ->where('id', $bundleId)
                ->where('user_id', $userId)
                ->first();

            if (!$bundle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bundle not found'
                ], 404);
            }

            $logLinks = DB::table('log_links')
                ->join('links', 'log_links.link_id', '=', 'links.id')
                ->where('links.bundle_id', $bundleId)
                ->select(
                    'log_links.id',
                    'log_links.link_id',
                    'links.bundle_id',
                    'log_links.ip_address',
                    'log_links.user_agent',
                    'log_links.created_at'
                )
                ->orderBy('log_links.created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logLinks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch log links',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    // Get statistics for dashboard
    public function getStats(Request $request)
    {
        try {
            $userId = $request->user()->id;

            // Get bundle IDs for this user
            $bundleIds = DB::table('bundles')
                ->where('user_id', $userId)
                ->pluck('id');

            // Count total bundle clicks
            $totalBundleClicks = DB::table('log_bundles')
                ->whereIn('bundle_id', $bundleIds)
                ->count();

            // Count total link clicks (join through links table)
            $totalLinkClicks = DB::table('log_links')
                ->join('links', 'log_links.link_id', '=', 'links.id')
                ->whereIn('links.bundle_id', $bundleIds)
                ->count();

            // Get clicks per bundle
            $clicksPerBundle = DB::table('log_bundles')
                ->whereIn('bundle_id', $bundleIds)
                ->select('bundle_id', DB::raw('COUNT(*) as clicks'))
                ->groupBy('bundle_id')
                ->get()
                ->pluck('clicks', 'bundle_id');

            return response()->json([
                'success' => true,
                'data' => [
                    'total_bundle_clicks' => $totalBundleClicks,
                    'total_link_clicks' => $totalLinkClicks,
                    'clicks_per_bundle' => $clicksPerBundle
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}