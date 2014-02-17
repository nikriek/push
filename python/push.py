#!/usr/bin/env python
# -*- coding: utf-8 -*-

class PushCo(object):
	"""docstring for PushCo"""

	API_URL = "https://api.push.co/1.0/push"
	
	def __init__(self, arg):
		super(PushCo, self).__init__()
		self.arg = arg

	def __sendRequest(self,params,notificationType=None):
		pass
