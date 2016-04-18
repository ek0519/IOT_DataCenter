#!/usr/bin/python

import sqlite3

conn = sqlite3.connect('RFID.db')
print "Opened database successfully";

# creat new db and table
# TABLE list about member(UID,NAME,RACK01,RACK02)
conn.execute('''CREATE TABLE list
       (UID    TEXT PRIMARY KEY  NOT NULL,
        NAME   TEXT              NOT NULL,
        RACK01 INT               NOT NULL,
        RACK02 INT               NOT NULL);''')

# TABLE login about login data(item,time,UID,status)
conn.execute('''CREATE TABLE login
       (item   INTEGER PRIMARY KEY     AUTOINCREMENT,
        time   TEXT                    NOT NULL,
        UID    TEXT                    NOT NULL,
        status TEXT                    NOT NULL);''')
# TABLE log about All date from Arduino

conn.execute('''CREATE TABLE log
       (time    TEXT PRIMARY KEY  NOT NULL,
        ID      TEXT              NOT NULL,
        Door    TEXT              NOT NULL,
        Lock    TEXT              NOT NULL,
        T       REAL              NOT NULL,
        H       REAL              NOT NULL,
        Dow     REAL              NOT NULL);''')
# TABLE command get command from RaspberryPi to Arduino

conn.execute('''CREATE TABLE command 
       (time    TEXT PRIMARY KEY  NOT NULL,
        UID     TEXT              NOT NULL,
        ID      TEXT              NOT NULL,
        Lock    TEXT              NOT NULL);''')

print "Table created successfully";

conn.close()
