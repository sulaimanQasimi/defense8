# Installing SecuGen Fingerprint Libraries on Windows

This guide explains how to install the SecuGen fingerprint libraries on Windows systems.

## Overview

The SecuGen fingerprint libraries are required to use fingerprint scanners from SecuGen. This package includes:
- Linux shared libraries (`.so` files)
- Installation scripts for both Linux and Windows
- Several installation options for Windows users

## Prerequisites

- Windows 10 or later
- Administrative privileges
- SecuGen fingerprint scanner connected to your system
- SecuGen Windows SDK (requires download from SecuGen)

## Installation Options

There are several ways to install the SecuGen libraries on Windows:

### Option 1: Using the Windows SDK (Recommended)

1. Download the SecuGen Windows SDK from [SecuGen's website](https://secugen.com/download)
   - You may need to register or contact SecuGen for access
   - The SDK is proprietary and requires proper licensing

2. Extract the SDK and locate the DLL files:
   - `sgfdu03.dll`
   - `sgfpamx.dll`
   - `sgfplib.dll`
   - `sgnfiq.dll`
   - `pysgfplib.dll`
   - `sgfdu06.dll`

3. Create a `libs_win` directory in the `FingerprintMatch` folder and copy the DLL files there.

4. Run the `install.bat` script as Administrator (right-click and select "Run as Administrator").

### Option 2: Using the Enhanced Batch Script

We've provided an enhanced batch script (`install.bat`) that:
1. Checks if the DLL files exist
2. Provides clear instructions if they're missing
3. Installs the DLLs to the System32 directory

To use this script:
1. Right-click on `install.bat`
2. Select "Run as Administrator"
3. Follow the on-screen instructions

### Option 3: Converting Linux Libraries (Experimental)

If you don't have access to the Windows SDK, we've provided an experimental script that attempts to convert the Linux `.so` files to Windows `.dll` files:

1. Right-click on `convert_and_install.bat`
2. Select "Run as Administrator"
3. Follow the on-screen instructions

**Note:** This method is experimental and may not work correctly. It's provided only as a last resort and not recommended for production use.

### Option 4: PowerShell Download Script

For a more automated approach, we provide a PowerShell script that can assist with downloading and installing the libraries:

1. Right-click on `download_and_install.ps1`
2. Select "Run with PowerShell as Administrator"
3. Follow the on-screen instructions

This script will attempt to guide you through the download process and can open the SecuGen website for you.

## Troubleshooting

If you encounter issues during installation:

1. **"Access denied" errors:** Make sure you're running the scripts as Administrator.

2. **"File not found" errors:** Verify that you've downloaded the correct SDK and copied the DLL files to the right location.

3. **Application crashes after installation:** The converted Linux libraries may not be compatible with Windows. Try to obtain the official Windows SDK from SecuGen.

4. **Scanner not detected:** Make sure your device is properly connected and that you have the correct drivers installed.

## Getting Support

If you continue to experience issues, please:

1. Visit [SecuGen's support page](https://secugen.com/support)
2. Contact your system administrator
3. Create an issue in the project repository

## License

The SecuGen fingerprint libraries are proprietary software owned by SecuGen Corporation. Usage of these libraries is subject to SecuGen's licensing terms. 
