#!/usr/bin/env python
"""
Fix imports in the libs directory

This script updates the import statements in all Python files in the libs directory
to use proper relative imports, helping resolve ModuleNotFoundError issues.
"""

import os
import re
import sys

def fix_imports(directory):
    """
    Fix import statements in all Python files in the specified directory

    Args:
        directory (str): Directory containing Python files to fix
    """
    print(f"Fixing imports in {directory}...")

    # Make sure the directory exists
    if not os.path.isdir(directory):
        print(f"Error: Directory not found: {directory}")
        return False

    # Get all Python files in the directory
    python_files = [f for f in os.listdir(directory) if f.endswith('.py')]

    if not python_files:
        print(f"No Python files found in {directory}")
        return False

    # Count of fixed files
    fixed_count = 0

    # Process each file
    for filename in python_files:
        filepath = os.path.join(directory, filename)

        try:
            # Read the file content
            with open(filepath, 'r') as file:
                content = file.read()

            # Find and replace import statements
            # 1. from xxx import * -> from libs.xxx import *
            # But only if xxx is another file in the same directory

            # Get base name (without .py) of all Python files in the directory
            module_names = [os.path.splitext(f)[0] for f in python_files]

            # Regular expression to find imports
            import_pattern = r'from\s+(\w+)\s+import'

            # Find all imports
            imports = re.findall(import_pattern, content)

            # Flag to track if we made any changes
            changes_made = False

            # For each import, check if it's a local module and fix it
            for module in imports:
                if module in module_names and f"from {module} import" in content:
                    # Replace the import
                    content = content.replace(f"from {module} import", f"from libs.{module} import")
                    changes_made = True
                    print(f"  Fixed import of '{module}' in {filename}")

            # If changes were made, write the file back
            if changes_made:
                with open(filepath, 'w') as file:
                    file.write(content)
                fixed_count += 1

        except Exception as e:
            print(f"Error processing {filename}: {str(e)}")

    print(f"Fixed imports in {fixed_count} of {len(python_files)} files.")
    return True

if __name__ == '__main__':
    # Get the libs directory path
    script_dir = os.path.dirname(os.path.abspath(__file__))
    libs_dir = os.path.join(script_dir, 'libs')

    # Fix the imports
    if fix_imports(libs_dir):
        print("Import fixes complete! You can now try running your script again.")
    else:
        print("Failed to fix imports. Please check the error messages above.")

    # Wait for user input before exiting
    input("Press Enter to exit...")
