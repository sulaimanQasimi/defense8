# Changelog

## 2023-07-15 - Comprehensive Improvements

### Added
- `simple_match.py`: New cross-platform fingerprint matching implementation with:
  - Support for Windows, Linux, and macOS
  - Fallback to binary comparison when SDK not available
  - Multiple matching methods (SDK-based or binary comparison)
  - Configurable similarity thresholds
  - Improved error handling and diagnostics

- `fix_imports.py`: Utility script to automatically fix import statements in the `libs` directory Python files.

- `copy_secugen_dlls.py`: Utility script to automatically copy SecuGen DLL files from the standard installation path to the local libs directory.

- `check_setup.py`: Diagnostic utility that checks for required DLLs, Python modules, and dependencies.

- Windows helper scripts:
  - Batch files (.bat): `run_setup_check.bat`, `copy_dlls.bat`, `fix_imports.bat`
  - PowerShell scripts (.ps1): `Run-SetupCheck.ps1`, `Copy-SecuGenDLLs.ps1`, `Fix-Imports.ps1`

- `README.md`: Detailed documentation for all scripts including usage instructions and troubleshooting tips.

### Modified
- `match.py`: Enhanced the original matching script with:
  - Better error handling
  - Proper binary file handling
  - Improved command-line interface
  - Security level configuration options
  - Comprehensive docstrings and comments

- `libs/pysgfplib.py`: Fixed import statements to correctly reference modules from the `libs` directory.

- `simple_match.py`: Added support for finding SecuGen DLLs in the standard installation directory (C:\Program Files\SecuGen\SgiBioSrv).

### Improvements
- Better error messages and diagnostics across all scripts
- Cross-platform compatibility (Windows, Linux, macOS)
- Fallback mechanisms when SDK libraries are not available
- Configurable security/similarity thresholds
- Proper resource cleanup
- Exit codes for automation and integration
- Comprehensive documentation
- Simplified setup process with automatic DLL copying
- Advanced diagnostics for system setup troubleshooting
- User-friendly Windows integration with batch and PowerShell scripts
