# Plan for fixing Larastan issue #14

This branch contains a short implementation plan and checklist for addressing the Larastan errors reported in issue #14 (Cannot Access Non-Object Property on Eloquent Model).

Planned tasks

- Review the reported locations and add appropriate type narrowing and guards.
- Update method signatures or add `@var` phpdoc where necessary to help static analysis.
- Add minimal unit/feature tests covering the code paths to prevent regressions.
- Run `vendor/bin/pint` and ensure code style.

Acceptance criteria

- Larastan no longer reports the specific non-object property access errors for the modified files.
- Tests pass for changed code paths.

Notes

- Copilot is assigned to this issue and can implement the changes in small commits. Please review changes before merging.
