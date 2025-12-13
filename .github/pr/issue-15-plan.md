# Plan for fixing Larastan issue #15

This branch contains a short implementation plan and checklist for adding missing Eloquent relations referenced by Larastan in issue #15 (Relation Does Not Exist in Model).

Planned tasks

- Inspect models referenced in the issue (Category, Handover, related Detail models).
- Add missing relationship methods such as `items()`, `details()`, `staff()` with proper return type hints and docblocks.
- Add/adjust PHPDoc on models so static analyzers recognize relations.
- Add minimal tests or assertions where appropriate.

Acceptance criteria

- Larastan relationExistence warnings for the modified classes are resolved.
- No breaking changes to runtime behavior.

Notes

- Copilot is assigned to this issue and can implement these changes; please review PR commits before merging.
