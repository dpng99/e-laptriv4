# Workflow — Build Calculation Engine

1. Resolve indicator + measurement context.
2. Jika formula status UNRESOLVED → stop.
3. Jika MANDIRI:
   - load formula;
   - load raw inputs;
   - invoke FormulaRegistry.
4. Jika AGREGATIF:
   - load explicit FORMULA_COMPONENT/configured dependency;
   - invoke roll-up strategy.
5. Jika ORG_AGGREGATION:
   - apply configured organizational aggregation method.
6. Resolve target.
7. Calculate achievement.
8. Resolve dashboard status.
9. Persist result + target snapshot + formula version snapshot.
10. Never average all performance children.
