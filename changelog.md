# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased] - 2026-02-18

### Added
- **Directory Structure**: Created `src/` for source code and `tests/` for tests.
- **Composer**: Added `composer.json` with PSR-4 autoloading (`DataStructures\` -> `src/`) and `phpunit/phpunit` dev dependency.
- **Testing**: Added `phpunit.xml` configuration and `tests/TupleTest.php` covering `Tuple` and `TypedTuple`.
- **Git**: Added `.gitignore` with standard PHP and OS exclusions.

### Changed
- **File Location**: Moved `Tuple.php` to `src/Tuple.php`.
- **Refactoring**: Renamed `TypedTuple::make()` to `TypedTuple::create()` to resolve a method signature compatibility error with the parent `Tuple` class.
- **Scripts**: Updated `access_patterns_demo.php` and `examples.php` to:
    - Use Composer's `vendor/autoload.php` instead of manual `require_once`.
    - Use the new `TypedTuple::create()` method.
    - Fixed a syntax error in `access_patterns_demo.php` regarding immediate closure invocation.
- **Validation**: Enforced that `Tuple::make()` requires at least one argument, throwing `ArgumentCountError` otherwise.
