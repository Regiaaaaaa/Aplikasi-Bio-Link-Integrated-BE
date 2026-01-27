<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    // =========================
    // GET ALL LOG BUNDLES (USER)
    // =========================
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
                ->orderByDesc('log_bundles.created_at')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logBundles,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch log bundles',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // GET ALL LOG LINKS (USER)
    // =========================
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
                ->orderByDesc('log_links.created_at')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logLinks,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch log links',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =================================
    // GET LOG BUNDLES BY BUNDLE ID
    // =================================
    public function getLogBundlesByBundleId(Request $request, $bundleId)
    {
        try {
            $userId = $request->user()->id;

            $bundle = DB::table('bundles')
                ->where('id', $bundleId)
                ->where('user_id', $userId)
                ->first();

            if (! $bundle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bundle not found',
                ], 404);
            }

            $logs = DB::table('log_bundles')
                ->where('bundle_id', $bundleId)
                ->select('id', 'bundle_id', 'ip_address', 'user_agent', 'created_at')
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logs,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch bundle logs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // ================================
    // GET LOG LINKS BY BUNDLE ID
    // ================================
    public function getLogLinksByBundleId(Request $request, $bundleId)
    {
        try {
            $userId = $request->user()->id;

            $bundle = DB::table('bundles')
                ->where('id', $bundleId)
                ->where('user_id', $userId)
                ->first();

            if (! $bundle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bundle not found',
                ], 404);
            }

            $logs = DB::table('log_links')
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
                ->orderByDesc('log_links.created_at')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logs,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch link logs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // DASHBOARD STATS
    // =========================
    public function getStats(Request $request)
    {
        try {
            $userId = $request->user()->id;

            $bundleIds = DB::table('bundles')
                ->where('user_id', $userId)
                ->pluck('id');

            return response()->json([
                'success' => true,
                'data' => [
                    'total_bundle_clicks' => DB::table('log_bundles')
                        ->whereIn('bundle_id', $bundleIds)
                        ->count(),

                    'total_link_clicks' => DB::table('log_links')
                        ->join('links', 'log_links.link_id', '=', 'links.id')
                        ->whereIn('links.bundle_id', $bundleIds)
                        ->count(),

                    'clicks_per_bundle' => DB::table('log_bundles')
                        ->whereIn('bundle_id', $bundleIds)
                        ->select('bundle_id', DB::raw('COUNT(*) as clicks'))
                        ->groupBy('bundle_id')
                        ->pluck('clicks', 'bundle_id'),
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
