## [0.3.0] - 2018-11-22
### Changed
- Totally reworked `AbstractEnumType`:
  - Removed constant `NAME` and replaced by `getTypeName` method.
  - Removed constant `BASE_ENUM_CLASS` and replaced by `getEnumClass` method.
  - Removed `AbstractEnumType::getEnumDeclaration` method as redundant.
  - Added possibility for set enum values manually.
### Removed
- Removed `AbstractEnum` class as redundant.

## [0.2.0] - 2018-11-13
### Added
- Added possibility for use `doctrine:schema:update` with the ENUM's filed type.

## [0.1.0] - 2018-09-11
### Added
- First release of this component.
