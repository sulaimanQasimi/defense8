#!/usr/bin/env python
"""
Copy SecuGen DLLs

This utility script copies the SecuGen DLL files from the standard installation directory
to the local 'libs' directory, making it easier to use the fingerprint matching scripts
without modifying system paths.
"""

import os
import sys
import shutil
import platform

def copy_dlls():
    """
    Copy SecuGen DLL files from standard installation paths to the local libs directory
    """
    # Get script directory and libs directory
    script_dir = os.path.dirname(os.path.abspath(__file__))
    libs_dir = os.path.join(script_dir, 'libs')

    # Make sure libs directory exists
    if not os.path.isdir(libs_dir):
        try:
            os.makedirs(libs_dir)
            print(f"Created libs directory: {libs_dir}")
        except Exception as e:
            print(f"Error creating libs directory: {str(e)}")
            return False

    system = platform.system()

    if system == "Windows":
        # Define possible SecuGen installation paths
        secugen_paths = [
            os.path.join("C:", os.sep, "Program Files", "SecuGen", "SgiBioSrv"),
            os.path.join("C:", os.sep, "Program Files (x86)", "SecuGen", "SgiBioSrv")
        ]

        # Files to copy
        files_to_copy = [
            "sgfplib.dll",
            "sgfdu04.dll",
            "sgfdu03.dll",
            "sgfdu02.dll",
            "sgfpamx.dll",
            "sgimgapi.dll",
            "sgmatch.dll"
        ]

        # Try to find and copy each file
        found_path = None
        copied_files = []

        # Find the first valid SecuGen path
        for path in secugen_paths:
            if os.path.isdir(path):
                found_path = path
                print(f"Found SecuGen installation at: {path}")
                break

        if not found_path:
            print("Error: Could not find SecuGen installation directory.")
            print("Please ensure SecuGen is installed or manually copy the DLL files.")
            return False

        # Copy each file if it exists
        for file in files_to_copy:
            source_file = os.path.join(found_path, file)
            dest_file = os.path.join(libs_dir, file)

            if os.path.isfile(source_file):
                try:
                    shutil.copy2(source_file, dest_file)
                    copied_files.append(file)
                    print(f"Copied {file} to {libs_dir}")
                except Exception as e:
                    print(f"Error copying {file}: {str(e)}")
            else:
                print(f"Warning: {file} not found in {found_path}")

        # Report results
        if copied_files:
            print(f"\nSuccessfully copied {len(copied_files)} of {len(files_to_copy)} files to {libs_dir}")
            return True
        else:
            print("\nNo files were copied. Please check your SecuGen installation.")
            return False

    else:
        print(f"This script is designed for Windows. Your system ({system}) is not supported.")
        return False

if __name__ == "__main__":
    print("SecuGen DLL Copy Utility")
    print("------------------------")

    success = copy_dlls()

    if success:
        print("\nDLLs have been copied successfully. You should now be able to run the fingerprint matching scripts.")
    else:
        print("\nFailed to copy some or all DLLs. You may need to manually copy them or install the SecuGen SDK.")

    # Wait for user input before exiting
    input("\nPress Enter to exit...")
