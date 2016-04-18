#!/usr/bin/env python
# -*- coding: utf8 -*-

import RPi.GPIO as GPIO
import MFRC522
import signal
import time
import requests
import sqlite3
from datetime import datetime
from search import UID_Compare
continue_reading = True
import string

# Capture SIGINT for cleanup when the script is aborted
def end_read(signal,frame):
    global continue_reading
    print "Ctrl+C captured, ending read."
    continue_reading = False
    GPIO.cleanup()

# Hook the SIGINT
signal.signal(signal.SIGINT, end_read)

# Create an object of the class MFRC522
MIFAREReader = MFRC522.MFRC522()

# Welcome message
print "Please Pass your RFID Card closer to Reader."

# This loop keeps checking for chips. If one is near it will get the UID and authenticate
while continue_reading:
    
    # Scan for cards    
    (status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
    # If a card is found
    if status == MIFAREReader.MI_OK:
        print "Card detected"
    # Get the UID of the card
    (status,uid) = MIFAREReader.MFRC522_Anticoll()
   
    # If we have the UID, continue
    if status == MIFAREReader.MI_OK:

        # Print UID
	UID = str(uid[0])+"-"+str(uid[1])+"-"+str(uid[2])+"-"+str(uid[3])
        print "Card read UID: "+ UID
        # check UID whether in DB
    	conn = sqlite3.connect('RFID.db')
    	cursor = conn.execute("select UID from list where UID ='"+UID+"'")
   	card = cursor.fetchone()
	print (card)
    	if card is None:
    	# Add member to RDIF.db
		NAME = raw_input('Please enter member name:')
		print('choose permissions for RACK,1 was accept,0 was denied')
		RACK01 = input('RACK01:')
		RACK02 = input('RACK02:')
        	conn =sqlite3.connect('RFID.db')
        	conn.execute("insert into list (UID,NAME,RACK01,RACK02) VALUES (?,?,?,?);",(UID,NAME,RACK01,RACK02))
		print 'write db finish'	
		conn.commit()
		conn.close()
	else:
		print 'This card was already used! please select other'
	while   (status ==0):		
		(status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
		(status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
    		time.sleep(0.1)
    	print "Please Pass your RFID Card closer to Reader"
