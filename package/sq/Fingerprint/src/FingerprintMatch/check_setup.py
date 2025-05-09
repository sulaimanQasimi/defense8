#!/usr/bin/env python
"""
Check Fingerprint Matching Setup

This utility script checks for the required DLLs and dependencies needed
for the fingerprint matching scripts to function properly.
"""

import os
import sys
import platform
import importlib.util
import ctypes
import time

def check_dll(dll_name, search_paths=None):
    """
    Check if a DLL can be loaded from the specified search paths or system paths

    Args:
        dll_name (str): Name of the DLL file (e.g., 'sgfplib.dll')
        search_paths (list, optional): List of paths to search for the DLL

    Returns:
        tuple: (found_path, status) where found_path is the path where the DLL
               was found (or None if not found) and status is True if successfully
               loaded, False otherwise
    """
    if search_paths is None:
        search_paths = []

    # Try to find the DLL file
    found_path = None

    # First check if it exists in any of the search paths
    for path in search_paths:
        full_path = os.path.join(path, dll_name)
        if os.path.exists(full_path):
            found_path = full_path
            break

    # If not found in search paths, see if it can be loaded from system paths
    if found_path is None:
        try:
            # Try to load the DLL using ctypes (this will search system paths)
            dll = ctypes.CDLL(dll_name)
            found_path = "System Path"
            return found_path, True
        except Exception:
            return None, False

    # If found, try to load it to verify it's valid
    try:
        dll = ctypes.CDLL(found_path)
        return found_path, True
    except Exception:
        return found_path, False

def check_python_module(module_name):
    """
    Check if a Python module can be imported

    Args:
        module_name (str): Name of the module to import

    Returns:
        bool: True if the module can be imported, False otherwise
    """
    try:
        spec = importlib.util.find_spec(module_name)
        if spec is not None:
            return True
        return False
    except ModuleNotFoundError:
        return False

def find_secugen_installation():
    """
    Find the SecuGen installation directory

    Returns:
        str or None: Path to the SecuGen installation directory, or None if not found
    """
    if platform.system() != "Windows":
        return None

    possible_paths = [
        os.path.join("C:", os.sep, "Program Files", "SecuGen", "SgiBioSrv"),
        os.path.join("C:", os.sep, "Program Files (x86)", "SecuGen", "SgiBioSrv"),
        os.path.join("C:", os.sep, "Program Files", "SecuGen", "FDx SDK Pro"),
        os.path.join("C:", os.sep, "Program Files (x86)", "SecuGen", "FDx SDK Pro")
    ]

    for path in possible_paths:
        if os.path.isdir(path):
            # Look for a key DLL to confirm it's a valid SecuGen installation
            if os.path.exists(os.path.join(path, "sgfplib.dll")):
                return path

    return None

def main():
    """Main function to check the setup"""
    print("Fingerprint Matching Setup Check")
    print("===============================")

    script_dir = os.path.dirname(os.path.abspath(__file__))
    libs_dir = os.path.join(script_dir, "libs")

    system = platform.system()
    print(f"Operating System: {platform.platform()}")
    print(f"Python Version: {platform.python_version()}")
    print()

    # Check if the libs directory exists
    print(f"Checking libs directory: {libs_dir}")
    if os.path.isdir(libs_dir):
        print("✓ libs directory exists")
    else:
        print("✗ libs directory not found")
    print()

    # Check for Python dependencies
    print("Checking Python Dependencies:")
    python_deps = {
        "ctypes": "Required for DLL loading",
        "argparse": "Required for command-line parsing",
        "os": "Required for file and path operations",
        "sys": "Required for system operations",
        "platform": "Required for system information"
    }

    for module, description in python_deps.items():
        if check_python_module(module):
            print(f"✓ {module}: {description}")
        else:
            print(f"✗ {module}: {description} - NOT FOUND")
    print()

    # Check for SecuGen installation on Windows
    if system == "Windows":
        print("Checking for SecuGen Installation:")
        secugen_path = find_secugen_installation()
        if secugen_path:
            print(f"✓ SecuGen installation found at: {secugen_path}")
        else:
            print("✗ SecuGen installation not found")
        print()

        # Check for required DLLs
        print("Checking for Required DLLs:")
        required_dlls = {
            "sgfplib.dll": "SecuGen Fingerprint Library",
            "sgfdu03.dll": "SecuGen FDU03 Driver",
            "sgfpamx.dll": "SecuGen FPAMX Library"
        }

        search_paths = [libs_dir]
        if secugen_path:
            search_paths.append(secugen_path)

        all_dlls_found = True
        for dll, description in required_dlls.items():
            path, status = check_dll(dll, search_paths)
            if status:
                print(f"✓ {dll}: {description} - Found at {path}")
            elif path:
                print(f"⚠ {dll}: {description} - Found at {path} but could not be loaded")
                all_dlls_found = False
            else:
                print(f"✗ {dll}: {description} - NOT FOUND")
                all_dlls_found = False

        if not all_dlls_found:
            print("\nSome DLLs are missing or cannot be loaded.")
            print("You can try running the copy_secugen_dlls.py script to copy them from the SecuGen installation.")

    elif system == "Linux":
        # Check for required shared libraries on Linux
        print("Checking for Required Libraries:")
        required_libs = {
            "libsgfplib.so": "SecuGen Fingerprint Library",
        }

        search_paths = [
            libs_dir,
            "/usr/lib",
            "/usr/local/lib"
        ]

        all_libs_found = True
        for lib, description in required_libs.items():
            path, status = check_dll(lib, search_paths)
            if status:
                print(f"✓ {lib}: {description} - Found at {path}")
            elif path:
                print(f"⚠ {lib}: {description} - Found at {path} but could not be loaded")
                all_libs_found = False
            else:
                print(f"✗ {lib}: {description} - NOT FOUND")
                all_libs_found = False

    # Check for Python modules in libs directory
    print("\nChecking for Required Python Modules in libs directory:")
    required_modules = [
        "pysgfplib.py",
        "sgfdxerrorcode.py",
        "sgfdxdevicename.py",
        "sgfdxsecuritylevel.py"
    ]

    all_modules_found = True
    for module in required_modules:
        module_path = os.path.join(libs_dir, module)
        if os.path.exists(module_path):
            print(f"✓ {module} found")
        else:
            print(f"✗ {module} NOT FOUND")
            all_modules_found = False

    # Summary and recommendations
    print("\nSummary and Recommendations:")
    if system == "Windows" and not secugen_path:
        print("- SecuGen SDK not found. Please install it or specify the correct path.")

    if not all_dlls_found and system == "Windows":
        print("- Run the copy_secugen_dlls.py script to copy the DLLs from the SecuGen installation.")

    if not all_modules_found:
        print("- Make sure all required Python modules are in the libs directory.")

    print("- Run fix_imports.py to ensure proper import statements in the Python modules.")
    print("- Try using simple_match.py which has better error handling and fallback methods.")

    print("\nDone!")

if __name__ == "__main__":
    main()
    input("\nPress Enter to exit...")
