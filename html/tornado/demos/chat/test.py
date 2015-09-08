global test
class hello:
	def testme(self):
		global test
		test = 1
	def hh(self):
		print test

s = hello()
s.testme()
s.hh()
