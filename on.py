#!/usr/bin/env python
# -*- coding: utf8 -*-

import RPi.GPIO as GPIO
import time

print("on")
GPIO.setmode(GPIO.BOARD) 
GPIO.setup(7, GPIO.OUT)
GPIO.output(7,1)
time.sleep(3)
GPIO.output(7,0) 
GPIO.setwarnings(False)

print("on")
