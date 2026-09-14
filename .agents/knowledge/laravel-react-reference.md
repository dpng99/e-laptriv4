# Laravel Reference Architecture

## Controllers

### InputKinerjaController

Responsibilities:

- resolve authorized indicator;
- return input schema;
- accept validated raw input;
- call PengukuranService.

Do not calculate formula.

### PengukuranController

Responsibilities:

- show measurement;
- submit;
- reopen if authorized.

### ReviewPengukuranController

Responsibilities:

- approve;
- request revision.

### DashboardKinerjaController

Responsibilities:

- query read models/service;
- return aggregated presentation data.

## Services

### InputSchemaService

Build dynamic UI schema from:

- indicator;
- rumus_indikator;
- komponen_rumus;
- target;
- existing pengukuran.

### PengukuranService

Transaction coordinator:

1. create/update measurement;
2. save raw inputs;
3. call CalculationEngine;
4. save result;
5. return Resource.

### CalculationEngine

Pseudo:

```php
public function calculate(IndicatorContract $indicator, MeasurementContext $context): CalculationResult
{
    if ($indicator->formulaStatus()->isUnresolved()) {
        throw FormulaNotResolved::for($indicator);
    }

    if ($indicator->isAgregatif()) {
        return $this->rollupService->calculate($indicator, $context);
    }

    $formula = $this->formulaRegistry->resolve($indicator->formulaKey());

    return $formula->calculate(
        $this->inputRepository->forContext($indicator, $context)
    );
}
```

### AchievementService

Positive indicator:

`realization / target * 100`

Do not mix with formula realization.

### StatusResolver

```php
if ($achievement >= 100) return TERCAPAI;

if ($quarter < 4) return BELUM_TERCAPAI;

return TIDAK_TERCAPAI;
```

## Suggested Routes

```php
Route::prefix('kinerja')->middleware('auth')->group(function () {
    Route::get('/input/{level}/{kode}', [InputKinerjaController::class, 'show']);
    Route::post('/input/{level}/{kode}', [InputKinerjaController::class, 'store']);

    Route::get('/pengukuran/{pengukuran}', [PengukuranController::class, 'show']);
    Route::post('/pengukuran/{pengukuran}/submit', [PengukuranController::class, 'submit']);

    Route::post('/pengukuran/{pengukuran}/approve', [ReviewPengukuranController::class, 'approve']);
    Route::post('/pengukuran/{pengukuran}/revision', [ReviewPengukuranController::class, 'revision']);
});
```

## React

Suggested:

```text
resources/js/
├── Pages/Kinerja/
│   ├── Input/
│   │   ├── Index.jsx
│   │   └── Show.jsx
│   ├── Review/
│   └── Dashboard/
├── Components/Kinerja/
│   ├── DynamicInputForm.jsx
│   ├── FormulaSummary.jsx
│   ├── MeasurementResult.jsx
│   ├── ChildDependencyStatus.jsx
│   └── StatusBadge.jsx
└── hooks/
    └── useKinerjaInput.js
```

React never determines formulas.
