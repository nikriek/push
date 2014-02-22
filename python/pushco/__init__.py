#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
	The MIT License (MIT)

	Copyright (c) 2014 Niklas Riekenbrauck

	Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
"""
import urllib      
import urllib2

class PushCo(object):
	"""
		PushCo is a wrapper for push.co's API, which can send 
		push notifications to your phone 
	"""

	API_URL = "https://api.push.co/1.0/push"

	"""
		Connection object constructor
		config dictionary needs 'api_key' and 'api_secret'
	"""
	def __init__(self, config):
		super(PushCo, self).__init__()
		self.config = config

	"""
		Manages the POST request
	"""
	def __sendRequest(self,params,notificationType=None):
		if self.config == None:
			raise Exception("Configuration data is missing.")

		if notificationType != None:
			params.update(notificationType)
		params.update(self.config)
		data = urllib.urlencode(params)
		req = urllib2.Request(self.API_URL, data)
		try:
			response = urllib2.urlopen(req)
		except urllib2.HTTPError, e:
			if e.code == 401:
				raise Exception("You are not authorized.")
			else:
				raise Exception("Unkown error")
	"""
		A function to send a basic message
	"""
	def sendMessage(self,message,notificationType=None):
		params = {
			"message": message,
			"view_type": 0
		}
		self.__sendRequest(params,notificationType)

	def sendArticle(self,message,article,notificationType=None):
		params = {
			"message": message,
			"view_type": 0,
			"article":article
		}
		self.__sendRequest(params,notificationType)

	def sendImage(self,message,image,notificationType=None):
		params = {
			"message": message,
			"view_type": 0,
			"image" : image
		}
		self.__sendRequest(params,notificationType)

	def sendArticleAndImage(self,message,article,image,notificationType=None):
		params = {
			"message": message,
			"view_type": 0,
			"article": article,
			"image" : image
		}
		self.__sendRequest(params,notificationType)

	def sendUrl(self,message,url,notificationType=None):
		params = {
			"message": message,
			"view_type": 1,
			"url": url
		}
		self.__sendRequest(params,notificationType)

	def sendLocation(self,message,longitude,latitude,notificationType=None):
		params = {
			"message": message,
			"view_type": 2,
			"longitude": str(longitude),
			"latitude" : str(latitude)
		}
		self.__sendRequest(params,notificationType)
