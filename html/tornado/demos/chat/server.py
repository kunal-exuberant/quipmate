import sys
sys.path.append('/var/www/common/')
import secret
import hashlib
import tornado.database
import time
import tornado.httpserver
import tornado.ioloop
import tornado.options
import tornado.web
import os.path
import tornado.httpclient
import gc
import tornado.escape
import MySQLdb
from HTMLParser import HTMLParser
from tornado.options import define, options

define("port", default=8888, help="Server Port", type=int)

class Application(tornado.web.Application):
    def __init__(self):
        handlers = [
            (r"/chat/online", OnlineHandler),
			(r"/chat/typing_new", ChatTypingNewHandler),
			(r"/chat/chat_seen", ChatSeenHandler),
            (r"/chat/chat_new", ChatNewHandler),
            (r"/chat/chat_update", ChatUpdateHandler),
            (r"/chat/real_time", RealTimeHandler),
			(r"/chat/offline", OfflineHandler),
        ]
        settings = dict(
            cookie_secret="43oETzKXQAGaYdkL5gEmGeJJFuYh7EQnp2XdTP1o/Vo=",
            login_url="/auth/login",
            template_path=os.path.join(os.path.dirname(__file__), "templates"),
            static_path=os.path.join(os.path.dirname(__file__), "static"),
            xsrf_cookies=False,
        )
        tornado.web.Application.__init__(self, handlers, **settings)

class Database(tornado.database.Connection):
    def connect(self):
	tornado.database.Connection.__init__(self, secret.DB_IP, self.DB_NAME, user = secret.DB_USER, password= secret.DB_PASSWORD)
	return self._cursor()

    def query(self,query,cursor): 
		cursor.execute(query)
		self.close()
		gc.collect()
		return cursor 

class Query(Database):

	def chat_select(self, user, time):
		cursor = self.connect()
		sql_query = "select * from inbox where (ACTIONBY = '%s' or ACTIONON = '%s') and time > '%s' order by ACTIONID desc limit 4" %(user, user, time)
		return self.query(sql_query, cursor)

	def get_globalid(self):	
		cursor = self.connect()
		sql_query = "REPLACE INTO globalid (stub) VALUES ('a')"
		cursor.execute(sql_query)
		sql_query = "SELECT LAST_INSERT_ID() as id"
		return self.query(sql_query,cursor)

	def get_databases(self):
		cursor = self.connect()
		sql_query = "show databases where `database` not IN('mysql','information_schema','performance_schema','session','admin')"
		return self.query(sql_query, cursor)

	def chat_insert(self, actionid, sentby, sentto, message, time):
		cursor = self.connect()
		message = unicode(message,"utf-8")
		sql_query = r"insert into inbox(ACTIONID, ACTIONBY, ACTIONON, MESSAGE, TIME) values( '%s', '%s', '%s', '%s', '%s')" %(actionid, sentby, sentto, message, time)
		return self.query(sql_query, cursor)

	def name_select(self, profileid):
		cursor = self.connect()
		sql_query = "select NAME from bio where PROFILEID = '%s' " %(profileid)
		return self.query(sql_query, cursor)

	def photo_select(self, profileid):
		cursor = self.connect()
		sql_query = "select CDN,FILENAME from profile_image where PROFILEID = '%s' order by imageid desc limit 1" %(profileid)
		cur = self.query(sql_query, cursor)
		if cur.rowcount == 0:
			cursor = self.connect()
			sql_query = "SELECT 'https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/' as CDN,'male.png' AS FILENAME"
			return self.query(sql_query, cursor)
		return cur

	def online_select(self, profileid):
		cursor = self.connect()
		sql_query = "SELECT friend.FRIENDID,callback FROM friend inner join online ON friend.FRIENDID = online.profileid WHERE friend.PROFILEID = '%s' and online.time <> '0' " %(profileid)
		return self.query(sql_query, cursor)

	def online_replace(self, profileid, time, callback=""):
		cursor = self.connect()
		sql_query = "replace into online(profileid, callback, time) values( '%s', '%s', '%s')" %(profileid, callback, time)
		return self.query(sql_query, cursor)

	def new_action_select(self, profileid, last_poll_time):
		cursor = self.connect()
		sql_query = "select a.* from action as a inner join subscribe as sub on CASE WHEN a.PROFILEID <1000000000 THEN a.PROFILEID ELSE a.ACTIONBY END = sub.FRIENDID inner join actiontype on actiontype.actiontypeid = a.ACTIONTYPE where sub.PROFILEID='%s' and actiontype.live_feed ='1' and unix_timestamp(a.TIMESTAMP) > '%s' order by a.ACTIONID desc limit 50" %(profileid, last_poll_time)
		return self.query(sql_query, cursor)
		
	def new_event_test(self, profileid, time):
		cursor = self.connect()
		sql_query = "select unix_timestamp(action.TIMESTAMP) from action inner join friend on action.ACTIONBY = friend.FRIENDID where friend.PROFILEID='%s' and actiontype not in('51','1151') and unix_timestamp(action.TIMESTAMP) > '%s' order by action.ACTIONID desc limit 1" %(profileid, time)
		cursor = self.query(sql_query, cursor)
		if cursor.rowcount == 0:
			return cursor.rowcount
		else:
			for row in cursor:
				return row[0]	
		
	def notice_unread_count(self, profileid,last_poll_time):
		cursor = self.connect()
		sql_query = "select count(*) from notice where READBIT ='0' and PROFILEID = '%s' and ACTIONBY <> '%s' and ACTIONTYPE <> '401' and unix_timestamp(TIMESTAMP) > '%s' " %(profileid, profileid,last_poll_time)
		return self.query(sql_query, cursor)	

	def unread_count(self, profileid,last_poll_time):
		cursor = self.connect()
		sql_query = "select count(distinct actionby) from inbox where READBIT ='0' and ACTIONON = '%s' and TIME > '%s'" %(profileid,last_poll_time)
		
		return self.query(sql_query, cursor)

	def request_unread_count(self, profileid, actiontype1, actiontype2, actiontype3,last_poll_time):
		cursor = self.connect()
		sql_query = "select count(*) from notice where READBIT ='0' and PROFILEID = '%s' and (ACTIONTYPE = '%s' or ACTIONTYPE = '%s' or ACTIONTYPE = '%s') and unix_timestamp(TIMESTAMP) > '%s' " %(profileid, actiontype1, actiontype2, actiontype3,last_poll_time)
		return self.query(sql_query, cursor)

	def offline_replace(self, time,dbname):
		cursor = self.connect()
		sql_query = "delete from  `%s`.`online` where time < '%s' " %(dbname,time)
		return self.query(sql_query, cursor)
	def online_table_select(self, time,dbname):
		cursor = self.connect()
		sql_query = "select profileid from `%s`.`online` where time < '%s' "%(dbname,time)
		return self.query(sql_query, cursor)

	def chat_readbit_update(self, sentby, sentto):
		cursor = self.connect()
		sql_query = "update inbox set READBIT ='1' where ACTIONBY='%s' and ACTIONON='%s'" %(sentby, sentto)
		return self.query(sql_query, cursor)

	def session_read(self, sessionid):
		self.DB_NAME = "session"
		cursor = self.connect()
		sql_query = "select data from session where sessionid = '%s'" %(sessionid)
		return self.query(sql_query, cursor)	
		
class MLStripper(HTMLParser):
    def __init__(self):
        self.reset()
        self.fed = []
    def handle_data(self, d):
        self.fed.append(d)
    def get_data(self):
        return ''.join(self.fed)

def strip_tags(html):
    s = MLStripper()
    s.feed(html)
    return s.get_data()

class BaseHandler(tornado.web.RequestHandler, Query):
	def authenticate(self):
		sessionid = self.get_cookie("PHPSESSID")
		print sessionid
		cursor = self.session_read(sessionid)
		for row in cursor:  
			return row[0]
		return None	
		
	def get_name(self, profileid):
		cursor = self.name_select(profileid)
		for row in cursor:                 
			return row[0]
		 
	def get_photo(self, profileid):
		cursor = self.photo_select(profileid)
		for row in cursor:      
			return row[0]+row[1]	

class RealTimeHandler(BaseHandler):
    online = {}
    @tornado.web.asynchronous
    def post(self):
		self.DB_NAME = self.get_argument("database")
		self.new_action(self.get_argument("database"),self.get_argument("profileid"), self.ret_rtm, self.get_argument("last_poll_time"))

    def new_action(self, database, profileid, callback, last_poll_time):
		cls = RealTimeHandler
		self.online_replace(profileid, time.time())
		cls.online[callback] = profileid
		count = 0
		message_count = 0
		request_count = 0
		response = 0
		action = []
		ack = 0
		if last_poll_time == '-1':
			for callback,u in cls.online.iteritems():
				cursor = self.notice_unread_count(u,last_poll_time)
				rows = cursor.fetchall()
				for row in rows:
					count = row[0]
					ack = 1
					
				cursor = self.unread_count(u,last_poll_time)
				rows = cursor.fetchall()
				for row in rows:
					message_count = row[0]
					ack = 1

				cursor = self.request_unread_count(u,7,501,408,last_poll_time)
				rows = cursor.fetchall()
				for row in rows:
					request_count = row[0]
					ack = 1				
				if ack ==1:
					last_poll_time = time.time()
				try:	
				  callback(response, count, message_count, request_count, database, u, action, last_poll_time)
				except:
				   pass
			cls.online = {}
		else:
			test = self.new_event_test(profileid, last_poll_time) 
			if test == 0:
			   tornado.ioloop.IOLoop.instance().add_timeout(time.time()+60, lambda:callback(response, count, message_count, request_count, database, profileid, action, last_poll_time, callback))
			else:
				cursor = self.notice_unread_count(profileid,last_poll_time)
				rows = cursor.fetchall()
				for row in rows:
					count = row[0]
					ack = 1
		
				cursor = self.unread_count(profileid,last_poll_time)
				rows = cursor.fetchall()
				for row in rows:
					message_count = row[0]
					ack = 1

				cursor = self.request_unread_count(profileid,7,501,408,last_poll_time)
				rows = cursor.fetchall()
				for row in rows:
					request_count = row[0]
					ack = 1				
														
				cursor = self.new_action_select(profileid, last_poll_time)
				rows = cursor.fetchall()
				for row in rows:
					mydict = {}
					mydict['pageid'] =str(row[2])
					mydict['actionby'] = str(row[3])
					mydict['actionid'] = str(row[1])
					mydict['actionon'] = str(row[0])
					mydict['actiontype'] = str( row[4])
					m = hashlib.sha1()
					m.update(str(row[2])+"pass1reset!")
					mydict['life_is_fun'] =m.hexdigest()
					action.append(mydict)
					ack = 1 
				url = "http://127.0.0.1/ajax/news_json.php?polling=polling&database="+database+"&profileid="+profileid+"&last_poll_time="+last_poll_time
				http_client = tornado.httpclient.HTTPClient()
				try:
					response = http_client.fetch(url)	
				except httpclient.HTTPError as e:
					print "Error:", e
				#http_client.close()		
				if ack ==1:
					last_poll_time = time.time();
					try:	
						callback(response, count, message_count, request_count, database, profileid, action, last_poll_time,callback)
					except:
						pass
               			
	
    def ret_rtm(self, response, count, message_count, request_count, database, profileid, action, last_poll_time, callback=None):
		name = {}
		photo = {}
		user = []
		if self.request.connection.stream.closed():
			return	
		if callback:
			del RealTimeHandler.online[callback]	
		cursor = self.online_select(profileid)
		rows = cursor.fetchall()
		ack = 0
		for row in rows:
		   user.append(row[0])	
		   name[int(row[0])] = self.get_name(row[0])
		   photo[int(row[0])] = self.get_photo(row[0])
		   ack = 1	
		for i in action:
			if i['actionby'] not in name:
				name[i['actionby']] = self.get_name(i['actionby'])
				photo[i['actionby']] = self.get_photo(i['actionby'])
			if i['actionon'] not in name:
				name[i['actionon']] = self.get_name(i['actionon'])
				photo[i['actionon']] = self.get_photo(i['actionon']) 
		try:
		   news = {}	
		   if response != 0:
				news = response.body
		   self.finish(dict(ack=ack, user=user, response=news, count=count, message_count=message_count, request_count=request_count, action=action, name=name,photo=photo, last_poll_time=last_poll_time))
		except Exception,e:
			   print e							

class ChatMixin(tornado.web.RequestHandler, Query):
   listener = {}
   def wait(self,database,user,callback):
	   cm = ChatMixin	
	   cm.listener[callback] = database+'_'+user
   def seen(self,chat,name,photo,database):
		cm = ChatMixin
		photo = ""
		action = []
                d = dict(cm.listener)
		for i,v in cm.listener.iteritems(): 
		   if v == database+'_'+chat['sentby']:
                          del d[i]
			  action.append(chat)		  
			  i(action,name,photo)
                cm.listener = d			   
	   
   def typing(self,chat,name,photo,database):
		cm = ChatMixin
		photo = ""
		action = []
                d = dict(cm.listener)
		for i,v in cm.listener.iteritems(): 
		   if v == database+'_'+chat['sentto']:
                          del d[i]
			  action.append(chat)						  
			  i(action,name,photo)
                cm.listener = d		   
       	
   def message(self,chat,name,photo,database):
		cm = ChatMixin
		action = []
                d = dict(cm.listener)
		for i,v in cm.listener.iteritems(): 
		   if v == database+'_'+chat['sentto']:
                          del d[i]
			  action.append(chat)
			  i(action,name,photo)
                cm.listener = d	
		
class ChatNewHandler(BaseHandler, ChatMixin):
    @tornado.web.asynchronous
    def post(self): 
		#if self.authenticate():
			chat = {}
			name = {}
			photo = {}
			action = []
			self.DB_NAME = self.get_argument("database")
			database = self.get_argument("database")
			message = self.get_argument("message").encode("utf-8")
			cursor = self.get_globalid()
			rows = cursor.fetchall()
			for row in rows:
				self.chat_insert(row[0], self.get_argument("profileid"), self.get_argument("userid"), MySQLdb.escape_string(message), time.time())
				chat['actionid'] = row[0]
				chat['sentby'] = self.get_argument("profileid")
				chat['sentto'] = self.get_argument("userid")
				chat['message'] = unicode(message,"utf-8")
				chat['chat_sent_time'] = self.get_argument("chat_sent_time")
				chat['time'] = time.time();
				chat['type'] = 3
				name[chat['sentby']] = self.get_argument("name")
				photo[chat['sentby']] = self.get_argument("photo")
				action.append(chat)
				self.message(chat,name,photo,database)
				self.finish(dict(action=action,name=name,photo=photo))
		#else:
		#	self.finish(dict(action="",name="",photo="",ack="0",msg="authentication failure"))

class ChatUpdateHandler(BaseHandler, ChatMixin):
    @tornado.web.asynchronous
    def post(self):
		self.DB_NAME = self.get_argument("database")
		last_chat_time = self.get_argument("last_chat_time")
		user = self.get_argument("profileid")
		ack = 0
		name = {}
		photo = {}
		action = []
		if last_chat_time != '-1':
			cursor = self.chat_select(user, last_chat_time)
			rows = cursor.fetchall()
			for row in rows:
			   ack = 1	
			   chat = {}
			   chat['actionid'] = row[0]
			   chat['sentto'] = row[2]
			   chat['sentby'] = row[1]
			   chat['message'] = row[3]
			   chat['time'] = row[4]
			   chat['type'] = 3
			   name[int(row[1])] = self.get_name(row[1])
			   photo[int(row[1])] = self.get_photo(row[1])
			   action.append(chat)
		if ack == 1:		 
		   self.retchat(action,name,photo)
		else:		
		     self.wait(self.get_argument("database"), self.get_argument("profileid"), self.retchat)

    def retchat(self,action,name,photo):
        if self.request.connection.stream.closed():
            return	
        try :
		self.finish(dict(name=name,photo=photo,action=action))	
	except Exception,e:
   		print e 

class ChatTypingNewHandler(BaseHandler, ChatMixin):
	@tornado.web.asynchronous
	def post(self):
		chat = {}
		name = {}
		photo = {}
		self.DB_NAME = self.get_argument("database")
		chat['actionid'] = 0
		chat['sentby'] = self.get_argument("profileid")
		chat['sentto'] = self.get_argument("userid")
		chat['message'] = "" 
		chat['time'] = -1
		chat['type'] = 2
		name[int(chat['sentby'])] = self.get_argument("name")
		photo[int(chat['sentby'])] = ""
		self.typing(chat,name,photo,self.get_argument("database"))
		self.finish(dict(act=1))
		
class ChatSeenHandler(BaseHandler, ChatMixin):
	@tornado.web.asynchronous
	def post(self):
		chat = {}
		name = {}
		photo = {}
		self.DB_NAME = self.get_argument("database")
		chat['actionid'] = 0
		chat['sentby'] = self.get_argument("profileid")
		chat['sentto'] = self.get_argument("userid")
		chat['message'] = ""
		chat['time'] = -1
		chat['type'] = 1
		name[int(chat['sentby'])] = self.get_argument("name")
		photo[int(chat['sentby'])] = ""
		self.seen(chat,name,photo,self.get_argument("database"))
		self.chat_readbit_update(self.get_argument("profileid"), self.get_argument("userid"))
		self.finish(dict(act=1))			
		
class OnlineHandler(BaseHandler):
    online = {}
    identifier = []

    @tornado.web.asynchronous
    def post(self):
		self.DB_NAME = self.get_argument("database")
		self.online_user(self.get_argument("profileid"), self.retuser, self.get_argument("random"))

    def online_user(self, profileid, callback, random):
		cls = OnlineHandler
		self.online_replace(profileid, time.time())
		cls.online[callback] = profileid
		if random not in cls.identifier:                             # new user connected
		   cls.identifier.append(random)
		   for callback,u in cls.online.iteritems():
			   try:	
				  callback(u)
			   except:
				   pass
		   cls.online = {}
		else:
		   tornado.ioloop.IOLoop.instance().add_timeout(time.time()+30, lambda:callback(profileid,callback))

    def retuser(self, profileid, callback=None):
		name = {}
		photo = {}
		user = []
		if self.request.connection.stream.closed():
			return
		if callback:
			del OnlineHandler.online[callback]	
		cursor = self.online_select(profileid)
		rows = cursor.fetchall()
		ack = 0
		for row in rows:
		   user.append(row[0])	
		   name[int(row[0])] = self.get_name(row[0])
		   photo[int(row[0])] = self.get_photo(row[0])
		   ack = 1
		try:
		   self.finish(dict(name=name,photo=photo,user=user,ack=ack))
		except Exception,e:
		   print e 
		   
class OfflineHandler(ChatMixin):
    def get(self):
	self.DB_NAME="mysql"
    	cursor = self.get_databases()
	rows = cursor.fetchall()
	for row in rows:
		dbname=row[0]
		self.start_loop(dbname)
    def start_loop(self,dbname):
        tornado.ioloop.IOLoop.instance().add_timeout(time.time()+120, lambda:self.delete_user(dbname))

    def delete_user(self,dbname):
		cursor=self.online_table_select(time.time()-64.0,dbname)
		rows = cursor.fetchall()
		for row in rows:
			profileid = row[0]
			cm = ChatMixin
			for i,v in cm.listener.items(): 
				if v == str(dbname)+'_'+str(profileid):
					del cm.listener[i]
		self.offline_replace(time.time()-64.0,dbname)
		self.start_loop(dbname)		   
 
def main():
    tornado.options.parse_command_line()
    http_server = tornado.httpserver.HTTPServer(Application())
    http_server.listen(options.port)
    tornado.ioloop.IOLoop.instance().start()

if __name__ == "__main__":
    main()
