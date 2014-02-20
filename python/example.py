#!/usr/bin/env python
# -*- coding: utf-8 -*-

from pushco import PushCo

def main():
  	config = {
  		"api_secret" : "api_secret",
  		"api_key" : "api_key"
  	}
  	push = PushCo(config)
  	push.sendUrl("Url","https://google.de")
  	print 'Notification successfully pushed!'

if __name__ == "__main__":
  main()