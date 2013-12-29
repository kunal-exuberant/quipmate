
var deploy = (function(){	

		    function action_decode(feed_type,value,name,pimage,container,dom_id,instant,append)
			{
				var action_desc;
				var action_object;
				switch(value.actiontype)
				{
					case '1': if(feed_type == 'news_feed' || feed_type == 'notice_feed'){action_desc = ' posted in '; action_object='';} else if(feed_type == 'live_feed') {action_desc = ' posted a '; action_object=' status'; } break;
					case '2': action_desc = ' commented on '; action_object=' status '; if(value.postby != value.actionon) action_object=' post '; break;
					case '3': action_desc = ' commented on '; action_object=' a profile update'; break; 
					case '5': if(feed_type == 'live_feed') { action_desc = ' added a album '; action_object=' album'; break; } else { action_desc = ' created an album with '+value.count+' photos';action_object=''; break; }
					case '6': action_desc = ' added a photo '; action_object=' photo'; break; 
					case '8': action_desc = ' is now friend with '; action_object=''; break; 
					case '11': if(feed_type == 'notice_feed') { action_desc = excited_desc; action_object=' status '; if(value.postby != value.actionon) action_object=' post '; break;} else {action_desc = ' is excited at '; action_object=' status '; if(value.postby != value.actionon) action_object=' post '; break;}
					case '12': if(feed_type == 'notice_feed') { action_desc = excited_desc; action_object=' album '; if(value.postby != value.actionon) action_object=' album '; break;} else {action_desc = ' is excited at '; action_object=' album '; break;}
					case '13': if(feed_type == 'notice_feed') { action_desc = excited_desc; action_object=' profile update '; break;} else{ action_desc = ' is excited at'; action_object=' profile update '; break;}	
					case '15': if(feed_type == 'notice_feed') { action_desc = excited_desc; action_object=' photo '; break;} else{action_desc = ' is excited at '; action_object=' photo ';} break;
					case '16': action_desc = ' new-pinched '; break;
					case '17': action_desc = ' is excited at '; action_object=' friendship'; break; 
					case '23': action_desc = ' commented on '; action_object=' album ';break;
					case '24': action_desc = ' commented on '; action_object=' photo '; break;
					case '25': action_desc = ' commented on '; action_object=' profile photo '; break;
					case '26': action_desc = ' commented on '; action_object=' friendship'; break; 
					case '50': if(feed_type == 'live_feed') { action_desc = ' changed profile photo '; action_object=''; break; } else { if(value.sex == 1) action_desc = ' changed his profile picture '; else action_desc = ' changed her profile picture '; break; }
					case '63': action_desc = ' is excited at '; action_object=' comment'; break; 	
					case '91': action_desc = ' is excited at '; action_object=' joining Quipmate'; break; 	
					case '92': action_desc = ' commented on '; action_object=' joining Quipmate'; break; 	
					case '99': action_desc = ' joined Quipmate '; action_object=''; break; 
					case '201': action_desc = ' changed the city '; action_object=''; break;
					case '202': action_desc = ' changed the profession '; action_object=''; break;
					case '203': action_desc = ' changed the school '; action_object=''; break;
					case '204': action_desc = ' changed the college '; action_object=''; break;
					case '205': action_desc = ' changed the company '; action_object=''; break;
					case '206': action_desc = ' changed the music '; action_object=''; break;
					case '207': action_desc = ' changed the movie '; action_object=''; break;
					case '208': action_desc = ' changed the books '; action_object=''; break;
					case '209': action_desc = ' changed the sports '; action_object=''; break;
					case '211': action_desc = ' changed the hobby '; action_object=''; break;
					case '213': action_desc = ' changed the relationship status '; action_object=''; break;
					case '215': action_desc = ' changed the mobile number '; action_object=''; break;
					case '225': action_desc = ' changed the nick name '; action_object=''; break;
					case '230': action_desc = ' added a skill '; action_object=''; break;
					case '231': action_desc = ' added a project '; action_object=''; break;
					case '232': action_desc = ' added a certificate '; action_object=''; break;
					case '233': action_desc = ' added a award '; action_object=''; break;
					case '234': action_desc = ' joined the team '; action_object=''; break;
					case '235': action_desc = ' added the major '; action_object=''; break;
					case '236': action_desc = ' added a tool '; action_object=''; break;
					
					case '300': action_desc = ' created the group '; action_object=''; break;
					case '301': action_desc = ' posted in '; action_object=' a group';  break;		
					case '306': action_desc = ' added a photo in the group ';action_object=''; break;		
					case '308': action_desc = ' invited to join the group ';action_object=''; break;
					case '302': action_desc = ' commented on '; action_object=' post in group'; break;
					case '311': action_desc = ' is excited at '; action_object=' post in group'; break;
					case '316': action_desc = ' added a link '; action_object=' group'; break;
					case '328': action_desc = ' asked a question '; action_object=' group'; break;
					
					case '400': action_desc = ' created the event '; action_object=''; break;
					case '403': action_desc = ' posted in '; action_object=' an event'; break;		
					case '406': action_desc = ' added a photo in the event ';action_object=''; break;
					case '408': action_desc = ' invited to join the event ';action_object=''; break;
					case '410': action_desc = ' cancelled the event ';action_object=''; break;
					case '402': action_desc = ' commented on '; action_object=' post in event'; break;
					case '411': action_desc = ' is excited at '; action_object=' post in event'; break;
					case '416': action_desc = ' added a link '; action_object=' event'; break;
					
					case '501': action_desc = ' is being missed by someone'; action_object=''; break;
					case '502': action_desc = ' missed back '; action_object=' missu'; break;
					case '503': action_desc = ' commented on '; action_object=' missing by someone'; break;
					case '511': if(feed_type == 'notice_feed') { action_desc = excited_desc; action_object=' missing by '; break;} else{ action_desc = ' is excited at '; action_object=' missing by '; break;}
					
					case '600': action_desc = ' published a blog '; action_object=''; break;
					case '602': action_desc = ' commented on '; action_object=' blog '; break;
					case '611': action_desc = ' is excited at '; action_object=' blog '; break;
					case '700': action_desc = ' wrote an open letter to the managing director '; action_object=''; break;
					case '702': action_desc = ' commented on '; action_object=' open letter to managing director '; break;
					case '711': action_desc = ' is excited at '; action_object=' open letter to managing director '; break;
					
					case '800': action_desc = ' set the tagline '; action_object=''; break;
					case '802': action_desc = ' commented on '; action_object=' tagline '; break;
					case '811': action_desc = ' is excited at '; action_object=' tagline '; break;	
					case '1101': action_desc = ' has been added as crush by someone'; action_object=''; break;
					case '1102': action_desc = ' has a crush match with '; action_object=''; break;
					case '1111': action_desc = ' is excited at '; action_object=' crush by someone'; break;
					case '1103': action_desc = ' commented on '; action_object=' crush by someone.'; break;	
					case '1201': action_desc = ' changed the mood'; action_object=''; break;
					case '1202': action_desc = ' commented on '; action_object='mood'; break;						
					case '1211': if(feed_type == 'notice_deploy'){action_desc = excited_desc; action_object=' mood '; break;} else {action_desc = ' is excited at '; action_object='mood'; break;}	
					case '1401': action_desc = ' sent a gift to '; action_object=''; break;
					case '1402': action_desc = ' commented on '; action_object=' gift'; break;						
					case '1411': if(feed_type == 'notice_deploy'){action_desc = excited_desc; action_object=' gift from'; break;} else{action_desc = ' is excited at '; action_object=' gift'; break;}	
					
					case '1600': action_desc = ' shared a link '; action_object=''; break;
					case '1602': action_desc = ' commented on '; action_object=' link. '; break;						
					case '1611': action_desc = ' is excited at '; action_object=' link. '; break;
					
					case '1900': action_desc = ' birthday-bombed '; action_object=''; break;
					case '1902': action_desc = ' commented on '; action_object=' birthday-bomb'; break;		
					case '1911': action_desc = ' is excited at '; action_object=' birthday-bomb'; break;
			
					case '2000': action_desc = ' set a new status-song'; action_object=''; break;		
					case '2002': action_desc = ' commented on '; action_object=' status-song '; break;				
					case '2011': if(feed_type == 'notice_type'){action_desc = excited_desc; action_object=' status-song '; break;} else {action_desc = ' is excited at '; action_object=' status-song '; break;}	
					case '2100': action_desc = ' is singing a song '; action_object=' for you '; break;
					case '2102': action_desc = ' commented on a song'; action_object=' dedicated by '; break;
					case '2111': if(feed_type == 'notice_type') {action_desc = excited_desc+' a song' ; action_object=' dedicated by ';} else {action_desc = ' is excited at a song dedicated to ' ; action_object=''; break; }		
					
					case '2400': action_desc = ' praise '; action_object=''; break;
					case '2402': action_desc = ' commented on '; action_object=' praise'; break;		
					case '2411': action_desc = ' is excited at '; action_object=' praise'; break;

					case '2500': action_desc = ' uploaded a video '; action_object=''; break;
					case '2502': action_desc = ' commented on '; action_object=' video'; break;		
					case '2511': action_desc = ' is excited at '; action_object=' video'; break;

					case '2600': action_desc = ' uploaded a document '; action_object=''; break;
					case '2602': action_desc = ' commented on '; action_object=' document'; break;		
					case '2611': action_desc = ' is excited at '; action_object=' document'; break;	

					case '2800': action_desc = ' asked a question '; action_object=''; break;
					case '2801': action_desc = ' answered '; action_object=' question'; break;
					case '2802': action_desc = ' commented on '; action_object=' question'; break;		
					case '2811': action_desc = ' is excited at '; action_object=' question'; break;	
								
					default: action_desc = 'some error occured !'; action_object=' we are fixing it ';
					
				}
				
				$('#'+dom_id).remove();
				if(feed_type != 'live_feed' && feed_type != 'notice_feed')
				{
					if(append == 0)
					{
						$(container).prepend('<div class="nf_post" data="'+value.actionid+'" id="'+dom_id+'"></div>');
					}
					else
					{
						$(container).append('<div class="nf_post" data="'+value.actionid+'" id="'+dom_id+'"></div>');		
					}
				}
				else if(feed_type == 'live_feed')
				{
					if(append == 0)
					{
						$('#rtm_container').prepend('<div class="rtm_each chat_unread" id="'+dom_id+'"></div>');
					}
					else
					{
						$('#rtm_container').append('<div class="rtm_each" id="'+dom_id+'"></div>');
					}	
				}
				postid = $('#'+dom_id);
				if(value.actiontype == 1)
				{
					if(feed_type == 'news_feed')
					{
						if(value.postby != value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a> posted in <a href="profile.php?id=' +value.actionon+ '">' +name[value.actionon]+ '</a>\'s diary</div>');
						}
						else
						{
							postid.append('<div class="name_50"></div>');
						}
					}
					else if(feed_type == 'live_feed')
					{	
						if(value.postby != value.actionon)
						{
							postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+action_object+'</span>');
						}
						else
						{
							postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> posted in '+name[value.actionon]+' \'s diary</span>');		
						}
					}
					else if(feed_type == 'notice_feed')
					{
						if(value.postby != value.actionon)
						{
							$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ' posted in your diary</div></div>');
						}
					}
				}
				else if(value.actiontype == 2 || value.actiontype == 11)
				{
					if(feed_type == 'news_feed')
					{
						if(value.postby == value.actionon)
						{  
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+' <a href="profile.php?id=' +value.postby+ '">' +name[value.postby]+ '</a>\'s '+action_object+' </div>')
						}
						else 
						{   
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+'<a href="profile.php?id=' +value.postby+ '">' +name[value.postby]+ '</a>\'s '+action_object+' in<a href="profile.php?id=' +value.actionon+ '"> ' +name[value.actionon]+ '</a>\'s diary</div>')
						}
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s '+action_object+'</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						if(value.postby == value.actionon)
						{  
							$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+''+action_desc+' your '+action_object+' </div></div>');
						}
						else 
						{
							$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+'' +name[value.postby]+ '\'s '+action_object+' in your diary</div></div>');
						}
					}
				}
				else if(value.actiontype == 3 || value.actiontype == 13)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+' a profile update by <a href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a></div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s '+action_object+'</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' '+action_object+'</div></div>');
					}	
				}
				else if(value.actiontype == 5)
				{	
					if(feed_type == 'news_feed')
					{
						if(value.postby != value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a> posted an album in <a href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a>\'s diary</div>');
						}
						else
						{
							postid.append('<div class="name_50"></div>');			
						}
					}
					else if(feed_type == 'live_feed')
					{
						if(value.postby == value.actionon)
						{	
							postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +'</span>');
						}	
						else
						{ 
							postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> posted in '+name[value.actionon]+' \'s diary</span>');		
						}
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' in your diary</div></div>');
					}
				}	
				else if(value.actiontype == 6)
				{	
					if(feed_type == 'news_feed')
					{
						if(value.postby != value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a> posted a photo in <a href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a>\'s diary</div>');
						}
						else
						{
							postid.append('<div class="name_50"></div>');			
						}
					}
					else if(feed_type == 'live_feed')
					{
						if(value.postby == value.actionon)
					  {	
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +'</span>');
					  }	
					  else
					  { 
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> posted in '+name[value.actionon]+' \'s diary</span>');		
					  }
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' in your diary</div></div>');
					}
				}
				else if(value.actiontype == 8)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');
					}	
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'</span>');
					}	
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ' and you are friends now.</div></div>');
					}
				}
				else if(value.actiontype == 12 || value.actiontype == 23)
				{
					if(feed_type == 'news_feed')
					{
						if(value.postby == value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+'<a href="profile.php?id=' +value.postby+ '">' +name[value.postby]+ '</a>\'s '+action_object+'</div>');
						}
						else 
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+'<a href="profile.php?id=' +value.postby+ '">' +name[value.postby]+ '</a>\'s '+action_object+' in <a href="profile.php?id=' +value.actionon+ '"> ' +name[value.actionon]+ '</a>\'s diary</div>');
						}
					}
					else if(feed_type == 'live_feed')
					{
						   postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s '+action_object+'</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						if(value.postby == value.actionon)
						{  
							$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(data,value.actionby)+''+action_desc+' your '+action_object+' </div></div>');
						}
						else 
						{
							$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+'' +name[value.postby]+ '\'s '+action_object+' in your diary</div></div>');
						}
					}
				}				
				else if(value.actiontype == 15 || value.actiontype == 24 || value.actiontype == 25)
				{
					if(feed_type == 'news_feed')
					{
						if(value.postby == value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+'<a href="profile.php?id=' +value.postby+ '">' +name[value.postby]+ '</a>\'s '+action_object+'</div>');
						}
						else 
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+'<a href="profile.php?id=' +value.postby+ '">' +name[value.postby]+ '</a>\'s '+action_object+' in <a href="profile.php?id=' +value.actionon+ '"> ' +name[value.actionon]+ '</a>\'s diary</div>');
						}
					}
					else if(feed_type == 'live_feed')
					{
						   postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s '+action_object+'</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						if(value.postby == value.actionon)
						{  
							$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+''+action_desc+' your '+action_object+' </div></div>');
						}
						else 
						{
							$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+'' +name[value.postby]+ '\'s '+action_object+' in your diary</div></div>');
						}
					}	
				}
				else if(value.actiontype == 16)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+'<a href="profile.php?id=' +value.actionon+ '">' +name[value.actionon]+ '</a></div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'</span>');	
					}	
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you</div></div>');
					}	
				}
				else if(value.actiontype == 17 || value.actiontype == 26)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+'<a href="profile.php?id=' +value.actionon+ '">' +name[value.actionon]+ '</a>\'s'+action_object+'</div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'</span>');	
					}	
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you.</div></div>');
					}	
				}
				else if(value.actiontype == 50)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');			
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +'</span>');
					}
				}
				else if(value.actiontype == 63)
				{	
					if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionby]+' '+ action_object +'</span>');
					}	
				}
				else if(value.actiontype == 91 || value.actiontype == 92)
				{	
					if(feed_type == 'news_feed')
					{
						if(value.postby != value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a> posted a photo in <a href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a>\'s diary</div>');
						}
						else
						{
							postid.append('<div class="name_50"></div>');			
						}
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +''+action_object+'</span>');
					}
				}
				else if(value.actiontype == 99)
				{	
					if(feed_type == 'news_feed')
					{
						if(value.postby != value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a> posted a photo in <a href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a>\'s diary</div>');
						}
						else
						{
							postid.append('<div class="name_50"></div>');			
						}
					}
					else if(feed_type == 'live_feed')
					{
						if(value.postby == value.actionon)
					  {	
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +'</span>');
					  }	
					  else
					  { 
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +'</span>');		
					  }
					}
				}
				else if(value.actiontype >= 200 && value.actiontype < 300)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+action_object+'</span>');	
					}
				}
				else if(value.actiontype == 300 || value.actiontype == 400)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');			
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+action_desc+'</span>');		
					}
				}	
				else if(value.actiontype == 301 || value.actiontype == 403)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');			
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> posted in an event</span>');		
					}
					else if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' '+action_object+'</div></div>');
					}	
				}
				else if(value.actiontype == 302 || value.actiontype == 311 || value.actiontype == 402 || value.actiontype == 411)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');			
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> posted in '+name[value.actionon]+' \'s diary</span>');		
					}
					else if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you.</div></div>');
					}	
				}	
				else if(value.actiontype == 306 || value.actiontype == 406)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');			
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b>'+action_desc+'</span>');		
					}
					else if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you.</div></div>');
					}	
				}					
				else if(value.actiontype == 308 || value.actiontype == 408)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+action_desc+'</span>');
					}
					else if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you.</div></div>');
					}						
				}
				else if(value.actiontype == 316 || value.actiontype == 416)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');			
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> posted in an event</span>');		
					}
					else if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you.</div></div>');
					}	
				}
				else if(value.actiontype == 328)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');			
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> posted in an event</span>');		
					}
					else if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you.</div></div>');
					}	
				}
				else if(value.actiontype == 410)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');			
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> posted in '+name[value.actionon]+' \'s diary</span>');		
					}
					else if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you.</div></div>');
					}	
				}
				else if(value.actiontype == 501 || value.actiontype == 1101)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');
					}
					else if(feed_type == 'live_feed')
					{
						 postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionon]+'" /><span class="rtm_each_text"><b>'+name[value.actionon]+'</b> '+ action_desc +'</span>');
					}
					else if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ' is missing you</div></div>');
					}						
				}
				else if(value.actiontype == 502)
				{	
					if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you.</div></div>');
					}					
				} 
				else if(value.actiontype == 503 || value.actiontype == 511)
				{	
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="name_50"></div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' someone\'s '+action_object+'</span>');
					}
					else if(feed_type == 'notice_feed')
					{						
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' you.</div></div>');
					}					
				}  
				else if(value.actiontype == 802 || value.actiontype == 811 || value.actiontype == 1202 || value.actiontype == 1211 || value.actiontype == 1402 || value.actiontype == 1411)
				{
					if(feed_type == 'news_feed')
					{
						if(value.postby == value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+'<a href="profile.php?id=' +value.postby+ '">' +name[value.postby]+ '</a>\'s '+action_object+'</div>');
						}
						else 
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+'<a href="profile.php?id=' +value.postby+ '">' +name[value.postby]+ '</a>\'s '+action_object+' in <a href="profile.php?id=' +value.actionon+ '"> ' +name[value.actionon]+ '</a>\'s diary</div>');
						}
					}
					else if(feed_type == 'live_feed')
					{
						 postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s '+action_object+'</span>');	
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' your '+action_object+'</div></div>');
					}
				}				
				else if(value.actiontype == 1201)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="news name_50"></div>'); 
					}	
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +'</span>');
					}	
				}
				else if(value.actiontype == 1401)
				{
					if(feed_type == 'news_feed')
					{
							postid.append('<div class="name_50"></div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +'</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						if(value.postby != value.actionon)
						{
							$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ' posted a link your diary</div></div>');
						}
					}
				}
				else if(value.actiontype == 1600)
				{
					if(feed_type == 'news_feed')
					{
						if(value.postby != value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a> posted a link in <a href="profile.php?id=' +value.actionon+ '">' +name[value.actionon]+ '</a>\'s diary</div>');
						}
						else
						{
							postid.append('<div class="name_50"></div>');
						}
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +'</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						if(value.postby != value.actionon)
						{
							$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ' posted a link your diary</div></div>');
						}
					}
				}
				else if(value.actiontype == 1602 || value.actiontype == 1611)
				{
					if(feed_type == 'news_feed')
					{
						if(value.postby == value.actionon)
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+' <a href="'+value.link+'"> a link</a> shared by <a href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a></div>');
						}
						else
						{
							postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+' <a href="'+value.link+'"> a link</a> shared by <a href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> in <a href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a>\'s diary</div>');			
						}
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s '+action_object+'</span>');	
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' your '+action_object+'</div></div>');
					}	
				}
				else if(value.actiontype == 2002 || value.actiontype == 2011)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+' status-song set by <a href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a></div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s '+action_object+'</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' your '+action_object+'</div></div>');
					}	
				}
				else if(value.actiontype == 2102 || value.actiontype == 2111)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+' a song dedicated by <a href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> to <a href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a></div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s '+action_object+'</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' '+action_object+'<a href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</div></div>');
					}
					
				}
				else if(value.actiontype == 600 || value.actiontype == 700 || value.actiontype == 800 || value.actiontype == 1900 || value.actiontype == 2400 || value.actiontype == 2500 || value.actiontype == 2600 || value.actiontype == 2800)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="news name_50"></div>'); 
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +'</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ action_desc +'</div></div>');
					}
				}
				else if(value.actiontype == 2801)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="news name_50"></div>'); 
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s question</span>');
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ action_desc +'</div></div>');
					}
				}
				else if(value.actiontype == 602 || value.actiontype == 611 || value.actiontype == 702 || value.actiontype == 711 || value.actiontype == 802 || value.actiontype == 811 || value.actiontype == 1902 || value.actiontype == 1911 || value.actiontype == 2402 || value.actiontype == 2411 || value.actiontype == 2502 || value.actiontype == 2511 || value.actiontype == 2602 || value.actiontype == 2611 || value.actiontype == 2802 || value.actiontype == 2811)
				{
					if(feed_type == 'news_feed')
					{
						postid.append('<div class="news name_50"><a href="profile.php?id=' +value.actionby+' " >' +name[value.actionby]+ '</a>'+action_desc+' <a href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a>\'s '+action_object+'</div>');
					}
					else if(feed_type == 'live_feed')
					{
						postid.append('<input type="hidden" value="'+value.pageid+'" /><input type="hidden" value="'+value.life_is_fun+'" /><img class="rtm_each_photo" height="30" width="30" src="'+pimage[value.actionby]+'" /><span class="rtm_each_text"><b>'+name[value.actionby]+'</b> '+ action_desc +' '+name[value.actionon]+'\'s '+action_object+'</span>');	
					}
					else if(feed_type == 'notice_feed')
					{
						$(container).append('<div class="notice_drop"  id="'+value.actionid+value.actiontype+'"><input type="hidden" id='+value.actionid+' value="'+value.life_is_fun+'"/><img class="lfloat" src =' +pimage[lastactionby]+ ' height="50" width="50" /><div class="notice_name">' +name_split(name,value.actionby)+ ''+action_desc+' your '+action_object+'</div></div>');
					}	
				}
			}

		function member_deploy(data)
		{
			var myprofileid = $('#myprofileid_hidden').attr('value');
			var profile_relation = $('#profile_relation_hidden').attr('value');
			$.each(data.action,function(index,value){
				$('#prev').append('<div id="'+value.profileid +'" data="'+value.profileid +'" style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;padding:1.5em;"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div></div>');
				if(profile_relation == 0)
				{
					if(value.profileid == myprofileid)
					{
						if(value.priviledge == 1)
						{
							$('#'+value.profileid).append('<div style="float:right;"><input type="hidden" value="'+value.profileid+'" /><input id="'+value.profileid +'" class="dedicate_button" style="width:6em;height:2.2em;background:#336699;color:#fff;font-size:1.1em;cursor:pointer;" type="submit" value="Admin" /><div>');
						}			
					}
					else if(value.priviledge == 0)
					{
						$('#'+value.profileid).append('<div style="float:right;"><input id="'+value.profileid +'" class="add_friend" style="width:9em;height:2.2em;background:#336699;color:#fff;font-size:1.1em;cursor:pointer;" type="submit" onclick="action.group_admin_make(this,1)" value="+Make Admin" /><div>');
						$('#'+value.profileid).append('<div style="float:right;"><input type="hidden" value="'+value.profileid+'" /><input id="'+value.profileid +'" class="dedicate_button" style="width:10em;height:2.2em;margin-right:1em;background:#336699;color:#fff;font-size:1.1em;cursor:pointer;" type="submit" value="Remove Member"  onclick="action.group_admin_make(this,2)" /><div>');
					}
					else if(value.priviledge == 1)
					{
						$('#'+value.profileid).append('<div style="float:right;"><input type="hidden" value="'+value.profileid+'" /><input id="'+value.profileid +'" class="dedicate_button" style="width:9em;height:2.2em;background:#336699;color:#fff;font-size:1.1em;cursor:pointer;" type="submit"  onclick="action.group_admin_make(this,0)" value="-Remove Admin" /><div>');
						$('#'+value.profileid).append('<div style="float:right;"><input type="hidden" value="'+value.profileid+'" /><input id="'+value.profileid +'" class="dedicate_button" style="width:10em;height:2.2em;margin-right:1em;background:#336699;color:#fff;font-size:1.1em;cursor:pointer;" type="submit" value="Remove Member" onclick="action.group_admin_make(this,2)" /><div>');
					}
				}
				else
				{
					if(value.priviledge == 1)
					{
						$('#'+value.profileid).append('<div style="float:right;"><input type="hidden" value="'+value.profileid+'" /><input id="'+value.profileid +'" class="dedicate_button" style="width:6em;height:2.2em;background:#336699;color:#fff;font-size:1.1em;cursor:pointer;" type="submit" value="Admin" "/><div>');
					}	
				}
			});
		}
		
		function guest_deploy(data,container)
		{
			if(data.action.going.length) $(container).append('<h6 class="page_title">Going</h6>');
			$.each(data.action.going,function(index,value){
				$(container).append('<div id="'+value.profileid +'" style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;padding:1.5em;"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div></div>');
			});
			if(data.action.declined.length) $(container).append('<h6 class="page_title">Declined</h6>');
			$.each(data.action.declined,function(index,value){
				$(container).append('<div id="'+value.profileid +'" style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;padding:1.5em;"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div></div>');
			});
			if(data.action.no_response.length) $(container).append('<h6 class="page_title">No Response</h6>');
			$.each(data.action.no_response,function(index,value){
				$(container).append('<div id="'+value.profileid +'" style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;padding:1.5em;"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div></div>');
			});
		}

		function friend_deploy(data)
		{
			$.each(data.action,function(index,value){
				$('#prev').append('<div id="'+value.profileid +'" style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;padding:1.5em;"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div></div>');
				if(value.status == 0)
				{
					$('#'+value.profileid).append('<div style="float:right;"><input id="'+value.profileid +'" class="add_friend" style="width:7em;height:2.2em;background:#336699;color:#fff;font-size:1.1em;font-weight:bold;cursor:pointer;" type="submit" value="+Friend" "/><div>');
				}
			});
		}
		
		function photo_deploy(data)
		{
			$('table').append('<tr></tr>');
			var i = 0;
			$.each(data.action,function(index,value){ 
				$('tr:last').append('<td class="photo_feed" style="text-align:center;height:11em;width:11em;background-color:#f9f9f9;vertical-align:middle;" ><input type="hidden" value="'+value.profileid+'" /><input type="hidden" value="6" /><img class="viewable" style="cursor:pointer;max-height:11em;max-width:11em;" id="'+value.actionid +'" data='+value.file+' src="thumbnail.php?file='+value.file+'&height=120&width=120" alt="photo"  /></td>');
			i++;	
			if(i%4==0)
			{
				$('table').append('<tr></tr>');
			}		
			});
		}
		
		function album_deploy(data)
		{
			var myprofileid = $('#myprofileid_hidden').attr('value');
			var name;
			var i = 0; 
			$.each(data.action,function(index,value){
			name = '#'+'tr'+i; 
			var file;
			if(value.actiontype == 5 || value.actiontype == 6)
			{
				file = 'user_image/'+value.file;
			}
			else if(value.actiontype == 50)
			{
				file = 'upload_pic/'+value.file;
			}
				$(name).append('<div id="'+value.actionid +'" style="padding:.5em;background:#ffffff;margin-bottom:1em;"><imput type="hidden" value="'+value.actionon+'" /><imput type="hidden" value="'+value.actiontype+'" /><a href="profile.php?id='+value.actionby+'"><img src =' +data.pimage[value.actionby]+ ' height="25" width="25" /></a><div style="position:relative;left:3em;top:-2em;margin-bottom:-1em;"><a href="profile.php?id='+value.actionby+'">'+data.name[value.actionby]+'</a></div><div id="'+value.actionid +'" align="middle"><img class="thumb" style="cursor:pointer;padding:.5em;background:#ffffff;" src="thumbnail.php?file='+file+'&maxh=1000&maxw=198" alt="photo"  /></div></div>');
				comment_album_decode(value,data.name,data.pimage,myprofileid);
				comment_box_album(value,data.pimage,myprofileid)
				i++;
				i = i%5; 
			});
		}

		function people_deploy(data)
		{  
			$.each(data.action,function(index,value){
				$('#center').append('<div class="user people_each" id="'+value.profileid+'"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" width="80" height="80"></a><div class="name_80"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div></div>');
				if(value.cyear != null) 
				{
				   $('#'+value.profileid).children().eq(1).append('<div>Passing Year:'+value.cyear+'</div>');
				}
				if(value.profession != null)
				{
				   $('#'+value.profileid).children().eq(1).append('<div>'+value.profession+'</div>');
				}
				if(value.company != null)
				{
				   $('#'+value.profileid).children().eq(1).append('<div>'+value.company+'</div>');
				}
				if(value.status == '0')
				{
					$('#'+value.profileid).children().eq(1).append('<input class="add_friend" onclick="action.add_friend(this,'+value.profileid+')" style="width:7em;" type="submit" value="+Friend" id="'+value.profileid+'"/>');
				}	
			});
		}
		
		function notice_deploy(data,container)
		{
			var myprofileid = $('#myprofileid_hidden').attr('value');
			$.each(data.action,function(index,value){
				excited_desc ='';
				if (value.excited.length == 1)
					 excited_desc =' is excited at ';
				else if($.inArray(myprofileid,value.excited) > -1 && value.excited.length == 2) 
					   excited_desc =' is excited at ';
				else 
					   excited_desc =' are excited at ';	
				arr = (value.actionby).split(',');	
				len = arr.length;
				lastactionby = arr[len - 1];	   
				deploy.action_decode('notice_feed',value,data.name,data.pimage,container,'',0,1);	
				var distinctid=value.actionid+value.actiontype;
				$('#'+distinctid).append('<div style="margin-left:6em;margin-top:.5em;color:gray;"><a href="action.php?actionid='+value.pageid+'&life_is_fun='+value.life_is_fun+'"><img src="http://icon.qmcdn.net/clock.png" width="6" /><span style="color:gray;" data="'+value.time+'">'+time_difference(value.time)+'</span></a></div>');
			});
		}
		
			return {
				action_decode : action_decode,
				member_deploy : member_deploy, 
				photo_deploy : photo_deploy,
				people_deploy : people_deploy,
				album_deploy : album_deploy,
				friend_deploy : friend_deploy,
				notice_deploy : notice_deploy,
				guest_deploy : guest_deploy
			}

			})();