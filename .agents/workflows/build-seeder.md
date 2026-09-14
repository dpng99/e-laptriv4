# Workflow — Build Seeder

1. Baca database architecture.
2. Pastikan migration/unique keys sesuai.
3. Gunakan canonical code sebagai natural key.
4. Seed SP/IKP/SK/IKK.
5. Seed relation dengan semantics explicit.
6. Seed formula.
7. Seed formula components/input fields.
8. Seed targets.
9. Jalankan `CascadingArchitectureSeeder` untuk normalization/assertion.
10. Jalankan automated tests.
11. Seeder wajib idempotent.
12. Jangan menjalankan legacy `PohonKinerjaSeeder` pada canonical path.
