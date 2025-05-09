# Fingerprint Matching Utilities

This directory contains scripts for fingerprint template matching using the SecuGen SDK.

## Scripts Overview

### `match.py`
The main fingerprint matching script using the SecuGen SDK via the pysgfplib Python wrapper.

```
python match.py --samples <samples_folder> --fingerprint <fingerprint_file> --security <1-4>
```

**Parameters:**
- `--samples`: Directory containing fingerprint template samples
- `--fingerprint`: Path to the fingerprint template file to match
- `--security`: Security level (1=lowest, 2=normal, 3=high, 4=highest)

### `simple_match.py`
An alternative fingerprint matching implementation with better cross-platform support and fallback options.

```
python simple_match.py --samples <samples_folder> --fingerprint <fingerprint_file> [options]
```

**Parameters:**
- `--samples`: Directory containing fingerprint template samples
- `--fingerprint`: Path to the fingerprint template file to match
- `--method`: Matching method - `auto` (default), `sdk`, or `binary`
- `--threshold`: Similarity threshold for binary matching (0-100, default: 80)
- `--security`: Security level (1=lowest, 2=normal, 3=high, 4=highest)

### `fix_imports.py`
Utility script to fix import statements in the `libs` directory Python files.

```
python fix_imports.py
```

### `copy_secugen_dlls.py`
Utility script to copy SecuGen DLL files from the standard installation directory (C:\Program Files\SecuGen\SgiBioSrv) to the local libs directory.

```
python copy_secugen_dlls.py
```

### `check_setup.py`
Diagnostic utility that checks for required DLLs, Python modules, and dependencies.

```
python check_setup.py
```

### Windows Helper Scripts

For Windows users, both batch files and PowerShell scripts are provided for easier execution:

#### Batch Files (.bat)
- `run_setup_check.bat` - Runs the setup check utility
- `copy_dlls.bat` - Runs the DLL copy utility
- `fix_imports.bat` - Runs the import fix utility

#### PowerShell Scripts (.ps1)
- `Run-SetupCheck.ps1` - Runs the setup check utility
- `Copy-SecuGenDLLs.ps1` - Runs the DLL copy utility
- `Fix-Imports.ps1` - Runs the import fix utility

## Setup on Windows

1. Check your setup to identify any missing components. You can use any of the following methods:
   ```
   run_setup_check.bat
   ```
   or
   ```
   powershell -ExecutionPolicy Bypass -File Run-SetupCheck.ps1
   ```
   or
   ```
   python check_setup.py
   ```

2. Make sure SecuGen SDK is installed (typically in C:\Program Files\SecuGen\SgiBioSrv).

3. Run the DLL copy script to copy the required DLL files to your libs directory. You can use any of the following methods:
   ```
   copy_dlls.bat
   ```
   or
   ```
   powershell -ExecutionPolicy Bypass -File Copy-SecuGenDLLs.ps1
   ```
   or
   ```
   python copy_secugen_dlls.py
   ```

4. Fix potential import issues by running one of the following:
   ```
   fix_imports.bat
   ```
   or
   ```
   powershell -ExecutionPolicy Bypass -File Fix-Imports.ps1
   ```
   or
   ```
   python fix_imports.py
   ```

5. You should now be able to run the fingerprint matching scripts.

## Troubleshooting

If you encounter import errors when running `match.py`, try the following steps:

1. Run the import fix script using one of the methods described above.

2. If that doesn't solve the issue, try using `simple_match.py` instead, which has better error handling and cross-platform support:
   ```
   python simple_match.py --samples <samples_folder> --fingerprint <fingerprint_file>
   ```

3. On Windows, make sure the SecuGen SDK DLLs are properly installed and accessible in your system path or in the `libs` directory. You can use the DLL copy script to copy these files automatically.

4. On Linux, ensure the SecuGen library files (.so) are installed correctly.

5. Run the setup check script to diagnose any issues with your installation using one of the methods described above.

## Return Codes

- `0`: Success - match found
- `1`: Error in execution
- `2`: No match found (in simple_match.py)

## Dependencies

- Python 3.6 or higher
- SecuGen SDK with appropriate drivers for your operating system

## Library Files

The necessary library files should be present in the `libs` directory. For Windows, the DLL files should be properly registered or available in the system path.
