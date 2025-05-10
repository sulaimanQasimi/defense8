#!/usr/bin/env python
"""
Simple Fingerprint Match Utility

This script provides a straightforward way to match a fingerprint template against
templates stored in the database. It uses direct binary comparison or a similarity
threshold to find matches.
"""

import ctypes
import argparse
import os
import sys
import platform
import base64
import mysql.connector
from mysql.connector import Error
import logging
from dotenv import load_dotenv

# Load environment variables from .env file
load_dotenv()

# Configure logging
logging.basicConfig(level=logging.INFO,
                   format='%(asctime)s - %(levelname)s - %(message)s')
logger = logging.getLogger(__name__)

# Security level constants
SL_LOWEST = 1
SL_NORMAL = 2
SL_HIGH = 3
SL_HIGHEST = 4

def get_db_connection():
    """
    Create a connection to the MySQL database using environment variables

    Returns:
        mysql.connector.connection.MySQLConnection: Database connection object
    """
    try:
        connection = mysql.connector.connect(
            host=os.getenv('DB_HOST', 'localhost'),
            database=os.getenv('DB_DATABASE', 'defense8'),
            user=os.getenv('DB_USERNAME', 'root'),
            password=os.getenv('DB_PASSWORD', ''),
            port=int(os.getenv('DB_PORT', '3306'))
        )
        if connection.is_connected():
            logger.info("Successfully connected to database")
            return connection
    except Error as e:
        logger.error(f"Error connecting to database: {e}")
        return None

def get_templates_from_db(connection, template_type='TemplateBase64'):
    """
    Retrieve all templates from the biometric_data table

    Args:
        connection: Database connection
        template_type: Type of template to retrieve (TemplateBase64, ISOTemplateBase64, or BMPBase64)

    Returns:
        list: List of tuples containing (id, template_data)
    """
    try:
        cursor = connection.cursor()
        query = f"SELECT id, {template_type} FROM biometric_data WHERE {template_type} IS NOT NULL"
        cursor.execute(query)
        templates = cursor.fetchall()
        cursor.close()
        return templates
    except Error as e:
        logger.error(f"Error retrieving templates: {e}")
        return []

def match_template_against_db(template_data, templates, threshold=80):
    """
    Match a template against all templates in the database

    Args:
        template_data (bytes): Template data to match
        templates (list): List of (id, template) tuples from database
        threshold (int): Similarity threshold (0-100)

    Returns:
        tuple: (matching_id, similarity_score) or (None, 0) if no match
    """
    best_match = None
    best_similarity = 0

    for template_id, db_template in templates:
        if not db_template:
            continue

        try:
            # Decode base64 template from database
            db_template_bytes = base64.b64decode(db_template)

            # For exact match
            if template_data == db_template_bytes:
                return template_id, 100

            # Calculate similarity for partial match
            max_len = max(len(template_data), len(db_template_bytes))
            min_len = min(len(template_data), len(db_template_bytes))

            # Skip if size difference is too large
            if min_len / max_len < threshold / 100:
                continue

            # Compare the common bytes
            matching_bytes = sum(a == b for a, b in zip(template_data[:min_len], db_template_bytes[:min_len]))
            similarity = (matching_bytes / min_len) * 100

            if similarity > best_similarity and similarity >= threshold:
                best_similarity = similarity
                best_match = template_id

        except Exception as e:
            logger.error(f"Error comparing template {template_id}: {e}")
            continue

    return best_match, best_similarity

def match_fingerprint(template_input, template_type='TemplateBase64', threshold=80):
    """
    Match a fingerprint template against templates in the database

    Args:
        template_input (str): Path to the fingerprint template file or base64 template data
        template_type (str): Type of template to match against
        threshold (int): Similarity threshold (0-100)

    Returns:
        tuple: (matching_id, similarity_score) or (None, 0) if no match
    """
    # Get template data either from file or direct input
    try:
        if os.path.exists(template_input):
            # If input is a file path, read the file
            with open(template_input, 'rb') as f:
                template_data = f.read()
        else:
            # If input is direct template data, decode it
            template_data = base64.b64decode(template_input)
    except Exception as e:
        logger.error(f"Error processing template input: {e}")
        return None, 0

    # Connect to database
    connection = get_db_connection()
    if not connection:
        return None, 0

    try:
        # Get all templates from database
        templates = get_templates_from_db(connection, template_type)

        # Match against database templates
        match_id, similarity = match_template_against_db(template_data, templates, threshold)

        return match_id, similarity

    finally:
        if connection.is_connected():
            connection.close()
            logger.info("Database connection closed")

def main():
    """Main function to run the fingerprint matching script"""
    parser = argparse.ArgumentParser(description='Match a fingerprint against templates in database')
    parser.add_argument('--fingerprint', required=True, help='Path to the fingerprint file or base64 template data')
    parser.add_argument('--type', choices=['TemplateBase64', 'ISOTemplateBase64', 'BMPBase64'],
                      default='TemplateBase64', help='Type of template to match against')
    parser.add_argument('--threshold', type=int, default=80,
                      help='Threshold percentage for match (0-100)')

    args = parser.parse_args()

    # Match the fingerprint
    match_id, similarity = match_fingerprint(args.fingerprint, args.type, args.threshold)

    # Print the result
    if match_id:
        logger.info(f"Match found: ID {match_id} (similarity: {similarity:.1f}%)")
        sys.exit(0)
    else:
        logger.info("No match found")
        sys.exit(2)

if __name__ == '__main__':
    main()
