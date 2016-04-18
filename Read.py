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
from search import get_time
continue_reading = True

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

  	# check Card permission
	card = UID_Compare(UID)
	print(card)	
		
	# get time
	clock = get_time()

	# wrtie to file
    	f = open("UID.txt","a")
	f.write(str(clock)+","+UID+"\n")
	f.close		

	# wrtie to RDIF.db
	conn =sqlite3.connect('RFID.db')
	conn.execute("insert into login (time,UID,status) VALUES (?,?,?);",(clock,UID,card))
	print 'write db finish'	
	conn.commit()
	conn.close()
	
	while   (status ==0):		
		(status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
		(status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
    		time.sleep(0.1)
	# Welcome message again
    	print "Please Pass your RFID Card closer to Reader."
