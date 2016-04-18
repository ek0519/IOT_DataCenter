#!/usr/bin/python

import sqlite3

conn = sqlite3.connect('RFID.db')
print "Opened database successfully";

# insert new date

conn.execute("INSERT INTO list (UID,NAME,RACK01,RACK02) \
      VALUES ('52-143-250-80','Blue',1,0)");

conn.execute("INSERT INTO list (UID,NAME,RACK01,RACK02) \
      VALUES ('36-252-8-106','White',0,1)");

conn.execute("INSERT INTO list (UID,NAME,RACK01,RACK02) \
      VALUES ('239-232-217-36','Ekman',1,1)");

conn.commit()
conn.close()

print 'insert list database successfully'
