# Agentic AI Package — e-LKjIP Pembinaan / JAMBIN V3

Paket ini memisahkan skill perencanaan dan skill programming agar agent tidak mencampur substansi SAKIP dengan implementasi aplikasi.

## Struktur

```text
AGENT_RULES.md

skills/
├── sakip-jambin-planner/
│   └── SKILL.md
└── elkjip-laravel-react-programmer/
    └── SKILL.md

knowledge/
├── cascading-jambin-v3-canonical.md
├── formula-registry.md
├── input-schema.md
├── database-architecture.md
└── testing-rules.md

workflows/
├── build-cascading.md
├── build-seeder.md
├── build-calculation-engine.md
├── build-input-ui.md
└── audit-indicator.md
```

## Agent Start Sequence

Setiap coding task:

1. `AGENT_RULES.md`
2. relevant skill
3. relevant knowledge docs
4. relevant workflow
5. task user

## Key Principle

`performance hierarchy != calculation dependency`

Node MANDIRI dapat mempunyai child.

Hanya dependency formula yang eksplisit boleh digunakan calculation engine.

## Recommended Repository Placement

Contoh:

```text
docs/agent/
  AGENT_RULES.md
  skills/
  knowledge/
  workflows/
```

atau root `.ai/`.

Jika menggunakan agent yang mendukung project instructions, jadikan `AGENT_RULES.md` sebagai mandatory project instruction.

## Additional Canonical Files

- `PROJECT_RULES.md`
- `skills/sicana-jambin-cascading/SKILL.md`
- `knowledge/jambin-bureau-map.md`
- `knowledge/laravel-react-reference.md`
- `knowledge/canonical-enums.json`
