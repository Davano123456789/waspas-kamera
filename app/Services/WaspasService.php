<?php

namespace App\Services;

use App\Models\Kamera;
use App\Models\Kriteria;
use App\Models\Evaluasi;

class WaspasService
{
    /**
     * Calculate WASPAS rankings.
     *
     * @param array|null $customWeights Optional custom weights [kriteria_id => weight] for User personalization
     * @param float $lambda Default 0.5
     * @param array|null $kameraIds Optional subset of kamera IDs to include (default: all)
     * @return array
     */
    public function calculate(?array $customWeights = null, float $lambda = 0.5, ?array $kameraIds = null): array
    {
        $kriterias = Kriteria::orderBy('kode')->get();
        $kameraQuery = Kamera::with('evaluasi')->orderBy('kode');
        if ($kameraIds) {
            $kameraQuery->whereIn('id', $kameraIds);
        }
        $kameras = $kameraQuery->get();

        if ($kriterias->isEmpty() || $kameras->isEmpty()) {
            return [
                'kriterias' => $kriterias,
                'kameras' => $kameras,
                'matrixX' => [],
                'matrixR' => [],
                'q1' => [],
                'q2' => [],
                'qi' => [],
                'rankings' => [],
            ];
        }

        // 1. Calculate Weights (Normalized)
        $weights = [];
        if ($customWeights) {
            $totalCustomWeight = array_sum($customWeights);
            foreach ($kriterias as $kr) {
                $rawW = $customWeights[$kr->id] ?? $kr->bobot;
                $weights[$kr->id] = $totalCustomWeight > 0 ? ($rawW / $totalCustomWeight) : $kr->bobot_normalisasi;
            }
        } else {
            foreach ($kriterias as $kr) {
                $weights[$kr->id] = (float) $kr->bobot_normalisasi;
            }
        }

        // 2. Build Matrix Decision X & Find Max/Min per Criteria
        $matrixX = [];
        $maxVal = [];
        $minVal = [];

        foreach ($kriterias as $kr) {
            $maxVal[$kr->id] = -INF;
            $minVal[$kr->id] = INF;
        }

        foreach ($kameras as $kam) {
            foreach ($kriterias as $kr) {
                $ev = $kam->evaluasi->firstWhere('kriteria_id', $kr->id);
                $val = $ev ? (float) $ev->nilai : 1.0;
                $matrixX[$kam->id][$kr->id] = $val;

                if ($val > $maxVal[$kr->id]) {
                    $maxVal[$kr->id] = $val;
                }
                if ($val < $minVal[$kr->id]) {
                    $minVal[$kr->id] = $val;
                }
            }
        }

        // 3. Normalize Matrix R
        $matrixR = [];
        foreach ($kameras as $kam) {
            foreach ($kriterias as $kr) {
                $x = $matrixX[$kam->id][$kr->id];

                if ($kr->atribut === 'benefit') {
                    // Benefit: r = x / max(x)
                    $max = $maxVal[$kr->id] > 0 ? $maxVal[$kr->id] : 1.0;
                    $matrixR[$kam->id][$kr->id] = $x / $max;
                } else {
                    // Cost: r = min(x) / x
                    $min = $minVal[$kr->id];
                    $matrixR[$kam->id][$kr->id] = $x > 0 ? ($min / $x) : 1.0;
                }
            }
        }

        // 4. Calculate Q1 (WSM) & Q2 (WPM) & Qi (WASPAS)
        $q1 = [];
        $q2 = [];
        $qi = [];
        $rankings = [];

        foreach ($kameras as $kam) {
            $sumWSM = 0.0;
            $prodWPM = 1.0;

            foreach ($kriterias as $kr) {
                $r = $matrixR[$kam->id][$kr->id];
                $w = $weights[$kr->id];

                // WSM: sum(r * w)
                $sumWSM += ($r * $w);

                // WPM: prod(r ^ w)
                $prodWPM *= pow($r, $w);
            }

            $q1[$kam->id] = $sumWSM;
            $q2[$kam->id] = $prodWPM;

            // WASPAS Qi = lambda * Q1 + (1 - lambda) * Q2
            $finalQ = ($lambda * $sumWSM) + ((1.0 - $lambda) * $prodWPM);
            $qi[$kam->id] = $finalQ;

            $rankings[] = [
                'kamera_id' => $kam->id,
                'kamera' => $kam,
                'q1' => $sumWSM,
                'q2' => $prodWPM,
                'qi' => $finalQ,
            ];
        }

        // 5. Sort Rankings descending by Qi
        usort($rankings, function ($a, $b) {
            return $b['qi'] <=> $a['qi'];
        });

        // Assign rank number
        foreach ($rankings as $index => &$item) {
            $item['rank'] = $index + 1;
        }

        return [
            'kriterias' => $kriterias,
            'kameras' => $kameras,
            'weights' => $weights,
            'matrixX' => $matrixX,
            'matrixR' => $matrixR,
            'q1' => $q1,
            'q2' => $q2,
            'qi' => $qi,
            'rankings' => $rankings,
            'lambda' => $lambda,
        ];
    }
}
