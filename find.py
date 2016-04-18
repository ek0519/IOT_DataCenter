#!/usr/bin/python

import sqlite3

conn = sqlite3.connect('RFID.db')
print("opened db ");

id = '52-143-250-80'
cursor = conn.execute("SELECT * FROM list WHERE UID='"+id+"'")

for row in cursor:
	print 'UID    = ', row[0]
	print 'NAME   = ', row[1]
	print 'RACK01 = ', row[2]
	print 'RACK02 = ', row[3]

conn.close()
