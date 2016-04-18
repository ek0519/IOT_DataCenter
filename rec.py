#!/usr/bin/env python
# -*- coding: utf8 -*-

import socket
import sys
import sqlite3
from search import get_time

# Create a TCP/IP socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# Bind the socket to the port
server_address = ('localhost', 8090)
print >>sys.stderr, 'starting up on %s port %s' % server_address
sock.bind(server_address)

# Listen for incoming connections
sock.listen(1)

while True:
    # Wait for a connection
    print >>sys.stderr, 'waiting for a connection'
    connection, client_address = sock.accept()

    try:
        print >>sys.stderr, 'connection from', client_address

        # Receive the data in small chunks and retransmit it
        while True:
            data = connection.recv(24)
            print >>sys.stderr, 'received "%s"' % data
            if data:
                print >>sys.stderr, 'sending data back to the client'
                connection.sendall(data)
		clock = get_time()
		data = data.split(',')
		RACK = data[0]
		print (RACK)
		# write to txt
		if RACK == '1':
		  f = open('RACK01.txt','w')
		  print('no.......')
		  f.write(clock+","+data[0]+","+data[1]+","+data[2]+","+data[3]+","+data[4]+","+data[5]+"\n")	
		  f.close
		else:
		  f = open('RACK02.txt','w')
		  print('no.......')
                  f.write(clock+","+data[0]+","+data[1]+","+data[2]+","+data[3]+","+data[4]+","+data[5]+"\n") 
                  f.close
		
		# insert new date
		conn = sqlite3.connect('RFID.db')
		conn.execute("INSERT INTO log (time,ID,Door,Lock,T,H,Dow) VALUES (?,?,?,?,?,?,?)",(clock,data[0],data[1],data[2],data[3],data[4],data[5]))
		conn.commit()
		conn.close()
		
            else:
                print >>sys.stderr, 'no more data from', client_address
                break
            
    finally:
        # Clean up the connection
        connection.close()
