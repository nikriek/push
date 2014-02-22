#!/usr/bin/env python
# -*- coding: utf-8 -*-
import sys
from pushco import PushCo

def main():
  	config = {
  		"api_secret" : "YOUR_API_SECRET_HERE",
  		"api_key" : "YOUR_API_KEY_HERE"
  	}
  	push = PushCo(config)
  	push.sendMessage(sys.argv[1])
  	print 'Notification has been successfully pushed!'

if __name__ == "__main__":
  main()