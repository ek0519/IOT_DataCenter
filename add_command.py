#!/usr/bin/python

import sqlite3
from search import get_time

conn = sqlite3.connect('RFID.db')
print "Opened database successfully";

clock = get_time()
f= open('web.txt')
line = f.readline().split(',')

ID = input('enter rack id :')
Lock = input('enter Lock status (0:Close;1:Open) :')

# insert new date

conn.execute("INSERT INTO command (time,UID,ID,Lock) VALUES (?,?,?,?);",(clock,line[1],ID,Lock))

conn.commit()
conn.close()


print 'insert list database successfully'
