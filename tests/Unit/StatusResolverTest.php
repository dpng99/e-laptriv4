<?php

namespace Tests\Unit;

use App\Services\Calculation\StatusResolver;
use Tests\TestCase;

class StatusResolverTest extends TestCase
{
    private StatusResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new StatusResolver();
    }

    public function test_capaian_100_or_higher_is_tercapai(): void
    {
        $this->assertSame('TERCAPAI', $this->resolver->resolve(100.0, 1, 85.0));
        $this->assertSame('TERCAPAI', $this->resolver->resolve(105.0, 4, 90.0));
    }

    public function test_capaian_under_100_in_tw1_to_3_is_belum_tercapai(): void
    {
        $this->assertSame('BELUM_TERCAPAI', $this->resolver->resolve(98.82, 1, 84.0));
        $this->assertSame('BELUM_TERCAPAI', $this->resolver->resolve(95.00, 2, 80.0));
        $this->assertSame('BELUM_TERCAPAI', $this->resolver->resolve(90.00, 3, 75.0));
    }

    public function test_capaian_under_100_in_tw4_is_tidak_tercapai(): void
    {
        $this->assertSame('TIDAK_TERCAPAI', $this->resolver->resolve(98.82, 4, 84.0));
    }

    public function test_null_realization_is_belum_diinput(): void
    {
        $this->assertSame('BELUM_DIINPUT', $this->resolver->resolve(null, 1, null));
    }
}
