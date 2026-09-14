# Workflow — Build Dynamic Input UI

1. GET input schema dari Laravel.
2. Render hanya field `editable=true`.
3. Gunakan label dan tooltip dari canonical formula component.
4. Jangan tampilkan role teknis numerator/denominator.
5. Untuk AGREGATIF, tampilkan read-only dependency status.
6. Submit raw input.
7. Refresh computed result.
8. Display:
   - target;
   - realization;
   - achievement;
   - status.
9. Validation error harus menggunakan label bisnis.
