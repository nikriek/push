#!/usr/bin/env python
# -*- coding: utf-8 -*-

import urllib      
import urllib2

class PushCo(object):
	"""docstring for PushCo"""

	API_URL = "https://api.push.co/1.0/push"
	
	def __init__(self, config):
		super(PushCo, self).__init__()
		self.config = config

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
