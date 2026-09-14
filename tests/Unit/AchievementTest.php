<?php

namespace Tests\Unit;

use App\Services\Calculation\AchievementService;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    private AchievementService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AchievementService();
    }

    public function test_positive_indicator_achievement(): void
    {
        // Realisasi 84, Target 85 -> 84/85 * 100 = 98.82%
        $capaian = $this->service->calculate(84.0, 85.0, 'MAXIMIZE', precision: 2);
        $this->assertSame(98.82, $capaian);
    }

    public function test_achievement_caps_when_cap_is_set(): void
    {
        // Realisasi 120, Target 100 -> 120%, but cap is 110%
        $capaian = $this->service->calculate(120.0, 100.0, 'MAXIMIZE', cap: 110.0);
        $this->assertSame(110.0, $capaian);
    }

    public function test_zero_target_returns_null(): void
    {
        $capaian = $this->service->calculate(80.0, 0.0, 'MAXIMIZE');
        $this->assertNull($capaian);
    }

    public function test_null_realization_returns_null(): void
    {
        $capaian = $this->service->calculate(null, 85.0, 'MAXIMIZE');
        $this->assertNull($capaian);
    }
}
