#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""	
	Made by Niklas Riekenbrauck
	See license in README.md
"""
import urllib      
import urllib2

class PushCo(object):
	"""
	PushCo is a wrapper for push.co's API, which can send 
	push notifications to your phone 
	"""

	API_URL = "https://api.push.co/1.0/push"

	def __init__(self, config):
		"""
		Connection object constructor
		config dictionary needs 'api_key' and 'api_secret'
		"""
		super(PushCo, self).__init__()
		self.config = config

	def __sendRequest(self,params,notificationType=None):
		"""
		Manages the POST request
		"""
		if self.config == None:
			raise Exception("Configuration data is missing.")

		if notificationType != None:
			params.update(notificationType)
		params.update(self.config)
		data = urllib.urlencode(params)
		req = urllib2.Request(self.API_URL, data)
		urllib2.urlopen(req)
	
	def sendMessage(self,message,notificationType=None):
		"""
		Sends a basic message
		"""
		params = {
			"message": message,
			"view_type": 0
		}
		self.__sendRequest(params,notificationType)
	
	def sendArticle(self,message,article,notificationType=None):
		"""
		Sends an article along with a message
		"""
		params = {
			"message": message,
			"view_type": 0,
			"article":article
		}
		self.__sendRequest(params,notificationType)
	
	def sendImage(self,message,image,notificationType=None):
		"""
		Sends an image along with a message
		"""
		params = {
			"message": message,
			"view_type": 0,
			"image" : image
		}
		self.__sendRequest(params,notificationType)

	def sendArticleAndImage(self,message,article,image,notificationType=None):
		"""
		Sends an image and an article along with a message
		"""
		params = {
			"message": message,
			"view_type": 0,
			"article": article,
			"image" : image
		}
		self.__sendRequest(params,notificationType)

	def sendUrl(self,message,url,notificationType=None):
		"""
		Sends an url along with a message
		"""
		params = {
			"message": message,
			"view_type": 1,
			"url": url
		}
		self.__sendRequest(params,notificationType)

	def sendLocation(self,message,longitude,latitude,notificationType=None):
		"""
		Sends location parameters along with a message
		"""
		params = {
			"message": message,
			"view_type": 2,
			"longitude": str(longitude),
			"latitude" : str(latitude)
		}
		self.__sendRequest(params,notificationType)
