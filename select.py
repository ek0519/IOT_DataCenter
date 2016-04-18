#!/usr/bin/python

import sqlite3

conn = sqlite3.connect('RFID.db')
print "Opened database successfully";

# list

cursor = conn.execute("SELECT UID, NAME, RACK01, RACK02  from list")
for row in cursor:
   print "UID = ", row[0]
   print "NAME = ", row[1]
   print "RACK01 = ", row[2]
   print "RACK02 = ", row[3], "\n"

conn.close
# login

conn = sqlite3.connect('RFID.db')
print "Opened database successfully";

cursor = conn.execute("SELECT item,time,UID,status  from login")
for row in cursor:
   print "item   = ", row[0]
   print "time   = ", row[1]
   print "UID    = ", row[2]	
   print "status = ", row[3],"\n"

# log
conn = sqlite3.connect('RFID.db')
print "Opened database successfully";

cursor = conn.execute("SELECT time,ID,Door,Lock,T,H,Dow from log")
for row in cursor:
   print "time   = ", row[0]
   print "ID     = ", row[1]
   print "Door   = ", row[2]
   print "Lock   = ", row[3]
   print "T      = ", row[4]
   print "H      = ", row[5]
   print "Dow    = ", row[6],"\n"


conn.close()
