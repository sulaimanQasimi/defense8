#! /usr/bin/env python

from libs.pysgfplib import *
import argparse
import os
import sys

if '__main__' == __name__:
	parser = argparse.ArgumentParser()
	parser.add_argument('--samples', metavar='path', required=True, help='the path to fingerprint samples folder')
	parser.add_argument('--fingerprint', metavar='path', required=True, help='the path to fingerprint file')
	args = parser.parse_args()

	try:
		compare1 = open(args.fingerprint, 'rb').read()

		sgfplib = PYSGFPLib()
		sgfplib.Create()
		sgfplib.Init(0x4)

		match_found = False

		for fingerprint in os.listdir(args.samples):
			sample_path = os.path.join(args.samples, fingerprint)
			if not os.path.isfile(sample_path):
				continue

			try:
				compare2 = open(sample_path, 'rb').read()

				cMatched = c_bool(False)
				sgfplib.MatchTemplate(compare1, compare2, SGFDxSecurityLevel.SL_NORMAL, byref(cMatched))

				if cMatched.value == True:
					print(fingerprint)
					match_found = True
					break
			except Exception as e:
				sys.stderr.write(f"Error matching with {fingerprint}: {str(e)}\n")
				continue

		sgfplib.Terminate()
		sys.exit(0 if match_found else 1)

	except Exception as e:
		sys.stderr.write(f"Error: {str(e)}\n")
		sys.exit(1)
