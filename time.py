#!/usr/bin/env python
import  sqlite3

conn = sqlite3.connect('RFID.db')
time = conn.execute("select datetime('now','localtime')")
print time.fetchone()[0]
conn.close()
