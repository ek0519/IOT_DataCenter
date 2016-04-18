#!/usr/bin/python
# -*- coding: utf8 -*-

import sqlite3
from datetime import datetime

def get_time():
   clock = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
   return clock

def UID_Compare(UID):
    conn = sqlite3.connect('RFID.db')
    cursor = conn.execute("select NAME,RACK01,RACK02 from list where UID ='"+UID+"'")	
    clock = get_time()
    check = cursor.fetchone()
    print (check)	
    if check is None:
	f = open("web.txt","w")
        web = str(clock)+","+UID+","+"None"+","+"-1"+","+"-1"+"\n"
	f.write(web)
	print(web)
        f.close
	conn.close()
        return "Denied"	
    else: 
	print 'here'
	web = str(clock)+","+UID+","+str(check[0])+","+str(check[1])+","+str(check[2])+"\n"
	f =open("web.txt","w")
	f.write(web)
	f.close 
        print (web)
	conn.close()
	return "Pass"		

