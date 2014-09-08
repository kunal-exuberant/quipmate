var deploy = (function()
{
   window.ajax_queue = [];
   var icon_cdn = $('#icon_cdn').attr('value');

   function action_decode(feed_type, value, name, pimage, container, dom_id, instant, append)
   {
      var action_desc;
      var action_object;
      switch (value.actiontype)
      {
      case '1':
         if (feed_type == 'news_feed' || feed_type == 'notice_feed')
         {
            action_desc = ' posted in ';
            action_object = '';
         }
         else if (feed_type == 'live_feed')
         {
            action_desc = ' posted a ';
            action_object = ' status';
         }
         break;
      case '2':
         action_desc = ' commented on ';
         action_object = ' status ';
         if (value.postby != value.actionon) action_object = ' post ';
         break;
      case '3':
         action_desc = ' commented on ';
         action_object = ' a profile update';
         break;
      case '5':
         if (feed_type == 'live_feed' || feed_type == 'notice_feed')
         {
            action_desc = ' added an album ';
            action_object = ' album';
            break;
         }
         else
         {
            action_desc = ' created an album with ' + value.count + ' photo';
            action_object = '';
            break;
         }
      case '6':
         action_desc = ' added a photo ';
         action_object = ' photo';
         break;
      case '8':
         action_desc = ' is now following ';
         action_object = '';
         break;
      case '10':
         action_desc = ' shared ';
         action_object = 'post';
         break;
      case '11':
         if (feed_type == 'notice_feed')
         {
            action_desc = excited_desc;
            action_object = ' status ';
            if (value.postby != value.actionon) action_object = ' post ';
            break;
         }
         else
         {
            action_desc = ' is excited at ';
            action_object = ' status ';
            if (value.postby != value.actionon) action_object = ' post ';
            break;
         }
      case '12':
         if (feed_type == 'notice_feed')
         {
            action_desc = excited_desc;
            action_object = ' album ';
            if (value.postby != value.actionon) action_object = ' album ';
            break;
         }
         else
         {
            action_desc = ' is excited at ';
            action_object = ' album ';
            break;
         }
      case '13':
         if (feed_type == 'notice_feed')
         {
            action_desc = excited_desc;
            action_object = ' profile update ';
            break;
         }
         else
         {
            action_desc = ' is excited at';
            action_object = ' profile update ';
            break;
         }
      case '15':
         if (feed_type == 'notice_feed')
         {
            action_desc = excited_desc;
            action_object = ' photo ';
            break;
         }
         else
         {
            action_desc = ' is excited at ';
            action_object = ' photo ';
         }
         break;
      case '16':
         action_desc = ' new-pinched ';
         break;
      case '17':
         action_desc = ' is excited at ';
         action_object = ' friendship';
         break;
      case '23':
         action_desc = ' commented on ';
         action_object = ' album ';
         break;
      case '24':
         action_desc = ' commented on ';
         action_object = ' photo ';
         break;
      case '25':
         action_desc = ' commented on ';
         action_object = ' profile photo ';
         break;
      case '26':
         action_desc = ' commented on ';
         action_object = ' friendship';
         break;
      case '50':
         if (feed_type == 'live_feed')
         {
            action_desc = ' changed profile photo ';
            action_object = '';
            break;
         }
         else
         {
            if (value.sex == 1) action_desc = ' changed his profile picture ';
            else action_desc = ' changed her profile picture ';
            break;
         }
      case '63':
         action_desc = ' is excited at ';
         action_object = ' comment';
         break;
      case '64':
         action_desc = ' has mentioned you';
         action_object = ' in a comment';
         break;
      case '91':
         action_desc = ' is excited at ';
         action_object = ' joining Quipmate';
         break;
      case '92':
         action_desc = ' commented on ';
         action_object = ' joining Quipmate';
         break;
      case '99':
         action_desc = ' joined Quipmate ';
         action_object = '';
         break;
      case '201':
         action_desc = ' changed the city ';
         action_object = '';
         break;
      case '202':
         action_desc = ' changed the profession ';
         action_object = '';
         break;
      case '203':
         action_desc = ' changed the school ';
         action_object = '';
         break;
      case '204':
         action_desc = ' changed the college ';
         action_object = '';
         break;
      case '205':
         action_desc = ' changed the company ';
         action_object = '';
         break;
      case '206':
         action_desc = ' changed the music ';
         action_object = '';
         break;
      case '207':
         action_desc = ' changed the movie ';
         action_object = '';
         break;
      case '208':
         action_desc = ' changed the books ';
         action_object = '';
         break;
      case '209':
         action_desc = ' changed the sports ';
         action_object = '';
         break;
      case '211':
         action_desc = ' changed the hobby ';
         action_object = '';
         break;
      case '213':
         action_desc = ' changed the relationship status ';
         action_object = '';
         break;
      case '215':
         action_desc = ' changed the mobile number ';
         action_object = '';
         break;
      case '225':
         action_desc = ' changed the nick name ';
         action_object = '';
         break;
      case '230':
         action_desc = ' added a skill ';
         action_object = '';
         break;
      case '231':
         action_desc = ' added a project ';
         action_object = '';
         break;
      case '232':
         action_desc = ' added a certificate ';
         action_object = '';
         break;
      case '233':
         action_desc = ' added a award ';
         action_object = '';
         break;
      case '234':
         action_desc = ' joined the team ';
         action_object = '';
         break;
      case '235':
         action_desc = ' added the major ';
         action_object = '';
         break;
      case '236':
         action_desc = ' added a tool ';
         action_object = '';
         break;
      case '239':
         action_desc = ' changed the designation ';
         action_object = '';
         break;
      case '300':
         action_desc = ' created the group ';
         action_object = '';
         break;
      case '301':
         action_desc = ' posted in ';
         action_object = ' a group';
         break;
      case '306':
         action_desc = ' added a photo ';
         action_object = ' a group';
         break;
      case '308':
         action_desc = ' invited to join a group ';
         action_object = ' group';
         break;
      case '302':
         action_desc = ' commented on ';
         action_object = ' a post in group';
         break;
      case '307':
         action_desc = ' requested to join a group ';
         action_object = '';
         break;
      case '311':
         action_desc = ' is excited at ';
         action_object = ' a post in group';
         break;
      case '316':
         action_desc = ' added a link ';
         action_object = ' a group';
         break;
      case '325':
         action_desc = ' added a video ';
         action_object = ' a group';
         break;
      case '326':
         action_desc = ' added a doc ';
         action_object = ' a group';
         break;
      case '327':
         action_desc = ' added a new version of doc ';
         action_object = ' a group';
         break;
      case '328':
         action_desc = ' asked a question ';
         action_object = ' a group';
         break;
      case '400':
         action_desc = ' created the event ';
         action_object = '';
         break;
      case '403':
         action_desc = ' posted in ';
         action_object = ' an event';
         break;
      case '406':
         action_desc = ' added a photo ';
         action_object = ' an event';
         break;
      case '408':
         action_desc = ' invited to join the event ';
         action_object = 'event';
         break;
      case '410':
         action_desc = ' cancelled the event ';
         action_object = '';
         break;
      case '402':
         action_desc = ' commented on ';
         action_object = ' a post in event';
         break;
      case '411':
         action_desc = ' is excited at ';
         action_object = ' a post in event';
         break;
      case '416':
         action_desc = ' added a link ';
         action_object = ' an event';
         break;
      case '425':
         action_desc = ' added a video ';
         action_object = ' an event';
         break;
      case '426':
         action_desc = ' added a doc ';
         action_object = ' an event';
         break;
      case '501':
         action_desc = ' is being missed by someone';
         action_object = '';
         break;
      case '502':
         action_desc = ' missed back ';
         action_object = ' missu';
         break;
      case '503':
         action_desc = ' commented on ';
         action_object = ' missing by someone';
         break;
      case '511':
         if (feed_type == 'notice_feed')
         {
            action_desc = excited_desc;
            action_object = ' missing by ';
            break;
         }
         else
         {
            action_desc = ' is excited at ';
            action_object = ' missing by ';
            break;
         }
      case '600':
         action_desc = ' published a blog ';
         action_object = '';
         break;
      case '602':
         action_desc = ' commented on ';
         action_object = ' blog ';
         break;
      case '611':
         action_desc = ' is excited at ';
         action_object = ' blog ';
         break;
      case '700':
         action_desc = ' wrote an open letter to the managing director ';
         action_object = '';
         break;
      case '702':
         action_desc = ' commented on ';
         action_object = ' open letter to managing director ';
         break;
      case '711':
         action_desc = ' is excited at ';
         action_object = ' open letter to managing director ';
         break;
      case '800':
         action_desc = ' set the tagline ';
         action_object = '';
         break;
      case '802':
         action_desc = ' commented on ';
         action_object = ' tagline ';
         break;
      case '811':
         action_desc = ' is excited at ';
         action_object = ' tagline ';
         break;
      case '1101':
         action_desc = ' has been added as crush by someone';
         action_object = '';
         break;
      case '1102':
         action_desc = ' has a crush match with ';
         action_object = '';
         break;
      case '1111':
         action_desc = ' is excited at ';
         action_object = ' crush by someone';
         break;
      case '1103':
         action_desc = ' commented on ';
         action_object = ' crush by someone.';
         break;
      case '1201':
         action_desc = ' changed the mood';
         action_object = '';
         break;
      case '1202':
         action_desc = ' commented on ';
         action_object = 'mood';
         break;
      case '1211':
         if (feed_type == 'notice_deploy')
         {
            action_desc = excited_desc;
            action_object = ' mood ';
            break;
         }
         else
         {
            action_desc = ' is excited at ';
            action_object = 'mood';
            break;
         }
      case '1401':
         action_desc = ' sent a gift to ';
         action_object = '';
         break;
      case '1402':
         action_desc = ' commented on ';
         action_object = ' gift';
         break;
      case '1411':
         if (feed_type == 'notice_deploy')
         {
            action_desc = excited_desc;
            action_object = ' gift from';
            break;
         }
         else
         {
            action_desc = ' is excited at ';
            action_object = ' gift';
            break;
         }
      case '1600':
         action_desc = ' shared a link ';
         action_object = '';
         break;
      case '1602':
         action_desc = ' commented on ';
         action_object = ' link. ';
         break;
      case '1611':
         action_desc = ' is excited at ';
         action_object = ' link. ';
         break;
      case '1900':
         action_desc = ' birthday wished ';
         action_object = '';
         break;
      case '1902':
         action_desc = ' commented on ';
         action_object = ' birthday wish';
         break;
      case '1911':
         action_desc = ' is excited at ';
         action_object = ' birthday wish';
         break;
      case '2000':
         action_desc = ' set a new status-song';
         action_object = '';
         break;
      case '2002':
         action_desc = ' commented on ';
         action_object = ' status-song ';
         break;
      case '2011':
         if (feed_type == 'notice_type')
         {
            action_desc = excited_desc;
            action_object = ' status-song ';
            break;
         }
         else
         {
            action_desc = ' is excited at ';
            action_object = ' status-song ';
            break;
         }
      case '2100':
         action_desc = ' is singing a song ';
         action_object = ' for you ';
         break;
      case '2102':
         action_desc = ' commented on a song';
         action_object = ' dedicated by ';
         break;
      case '2111':
         if (feed_type == 'notice_type')
         {
            action_desc = excited_desc + ' a song';
            action_object = ' dedicated by ';
         }
         else
         {
            action_desc = ' is excited at a song dedicated to ';
            action_object = '';
            break;
         }
      case '2400':
         action_desc = ' praised ';
         action_object = '';
         break;
      case '2402':
         action_desc = ' commented on ';
         action_object = ' praise';
         break;
      case '2411':
         action_desc = ' is excited at ';
         action_object = ' praise';
         break;
      case '2500':
         action_desc = ' uploaded a video ';
         action_object = '';
         break;
      case '2502':
         action_desc = ' commented on ';
         action_object = ' video';
         break;
      case '2511':
         action_desc = ' is excited at ';
         action_object = ' video';
         break;
      case '2600':
         action_desc = ' uploaded a document ';
         action_object = '';
         break;
      case '2602':
         action_desc = ' commented on ';
         action_object = ' document';
         break;
      case '2611':
         action_desc = ' is excited at ';
         action_object = ' document';
         break;
      case '2800':
         action_desc = ' asked a question ';
         action_object = '';
         break;
      case '2801':
         action_desc = ' answered ';
         action_object = ' question';
         break;
      case '2802':
         action_desc = ' commented on ';
         action_object = ' question';
         break;
      case '2811':
         action_desc = ' is excited at ';
         action_object = ' question';
         break;
      case '2901':
         action_desc = ' You have a new status broadcast';
         action_object = '';
         break;
      case '2906':
         action_desc = ' You have a new photo broadcast';
         action_object = '';
         break;
      case '2916':
         action_desc = ' You have a new link broadcast';
         action_object = '';
         break;
      case '2925':
         action_desc = ' You have a new video broadcast';
         action_object = '';
         break;
      case '2926':
         action_desc = ' You have a new document broadcast';
         action_object = '';
         break;
      default:
         action_desc = 'some error occured !';
         action_object = ' we are fixing it ';
      }
      $('#' + dom_id).remove();
      if (feed_type != 'live_feed' && feed_type != 'notice_feed')
      {
         if (append == 0)
         {
            $(container).prepend('<div class="nf_post" data="' + value.actionid + '" id="' + dom_id + '"></div>');
         }
         else
         {
            $(container).append('<div class="nf_post" data="' + value.actionid + '" id="' + dom_id + '"></div>');
         }
      }
      else if (feed_type == 'live_feed')
      {
         if (append == 0)
         {
            $('#rtm_container').prepend('<div class="rtm_each chat_unread" id="' + dom_id + '"></div>');
         }
         else
         {
            $('#rtm_container').append('<div class="rtm_each" id="' + dom_id + '"></div>');
         }
      }
      postid = $('#' + dom_id);
      if (value.actiontype == 1)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby != value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a> posted in <a class="ajax_nav" href="profile.php?id=' + value.actionon + '">' + name[value.actionon] + '</a>\'s diary</div>');
            }
            else
            {
               postid.append('<div class="name_50"></div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            if (value.actionby != value.actionon)
            {
               postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + action_object + '</span>');
            }
            else
            {
               postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> posted in ' + name[value.actionon] + ' \'s diary</span>');
            }
         }
         else if (feed_type == 'notice_feed')
         {
            if (value.postby != value.actionon)
            {
               $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + ' posted in your diary</div></div>');
            }
         }
      }
      else if (value.actiontype == 2 || value.actiontype == 11)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby == value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + ' <a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a>\'s ' + action_object + ' </div>')
            }
            else
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a>\'s ' + action_object + ' in<a class="ajax_nav" href="profile.php?id=' + value.actionon + '"> ' + name[value.actionon] + '</a>\'s diary</div>')
            }
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            if (value.postby == value.actionon)
            {
               $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' your ' + action_object + ' </div></div>');
            }
            else
            {
               $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + '' + name[value.postby] + '\'s ' + action_object + ' in your diary</div></div>');
            }
         }
      }
      else if (value.actiontype == 3 || value.actiontype == 13)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + ' a profile update by <a class="ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' ' + action_object + '</div></div>');
         }
      }
      else if (value.actiontype == 5)
      {
         if (feed_type == 'news_feed')
         {
            if (value.actionby != value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a> posted an album in <a class="ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a>\'s diary</div>');
            }
            else
            {
               postid.append('<div class="name_50"></div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            if (value.actionby == value.actionon)
            {
               postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
            }
            else
            {
               postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> posted an album in ' + name[value.actionon] + ' \'s diary</span>');
            }
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' in your diary</div></div>');
         }
      }
      else if (value.actiontype == 6)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby != value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a> posted a photo in <a class="ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a>\'s diary</div>');
            }
            else
            {
               postid.append('<div class="name_50"></div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            if (value.actionby == value.actionon)
            {
               postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
            }
            else
            {
               postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> posted a photo in ' + name[value.actionon] + ' \'s diary</span>');
            }
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' in your diary</div></div>');
         }
      }
      else if (value.actiontype == 8)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + ' is also following you.</div></div>');
         }
      }
      else if (value.actiontype == 10)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a>\'s ' + action_object + '</div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + ' \'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + ' shared your post.</div></div>');
         }
      }
      else if (value.actiontype == 12 || value.actiontype == 23)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby == value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a>\'s ' + action_object + '</div>');
            }
            else
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a>\'s ' + action_object + ' in <a class="ajax_nav" href="profile.php?id=' + value.actionon + '"> ' + name[value.actionon] + '</a>\'s diary</div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            if (value.postby == value.actionon)
            {
               $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' your ' + action_object + ' </div></div>');
            }
            else
            {
               $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + '' + name[value.postby] + '\'s ' + action_object + ' in your diary</div></div>');
            }
         }
      }
      else if (value.actiontype == 15 || value.actiontype == 24 || value.actiontype == 25)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby == value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a>\'s ' + action_object + '</div>');
            }
            else
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a>\'s ' + action_object + ' in <a class="ajax_nav" href="profile.php?id=' + value.actionon + '"> ' + name[value.actionon] + '</a>\'s diary</div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            if (value.postby == value.actionon)
            {
               $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' your ' + action_object + ' </div></div>');
            }
            else
            {
               $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + '' + name[value.postby] + '\'s ' + action_object + ' in your diary</div></div>');
            }
         }
      }
      else if (value.actiontype == 16)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.actionon + '">' + name[value.actionon] + '</a></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' you</div></div>');
         }
      }
      else if (value.actiontype == 17 || value.actiontype == 26)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.actionon + '">' + name[value.actionon] + '</a>\'s' + action_object + '</div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' you.</div></div>');
         }
      }
      else if (value.actiontype == 50)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
         }
      }
      else if (value.actiontype == 63)
      {
         if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.pageid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' your comment.</div></div>');
         }
      }
      else if (value.actiontype == 64)
      {
         if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.pageid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' ' + action_object + '.</div></div>');
         }
      }
      else if (value.actiontype == 91 || value.actiontype == 92)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby != value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a> posted a photo in <a class="ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a>\'s diary</div>');
            }
            else
            {
               postid.append('<div class="name_50"></div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' you ' + action_object + '.</div></div>');
         }
      }
      else if (value.actiontype == 99)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby != value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a> posted a photo in <a class="ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a>\'s diary</div>');
            }
            else
            {
               postid.append('<div class="name_50"></div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
         }
      }
      else if (value.actiontype >= 200 && value.actiontype < 300)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + action_object + '</span>');
         }
      }
      else if (value.actiontype == 300 || value.actiontype == 400)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
         }
      }
      else if (value.actiontype == 302 || value.actiontype == 311 || value.actiontype == 402 || value.actiontype == 411)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' you.</div></div>');
         }
      }
      else if (value.actiontype == 308 || value.actiontype == 408)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + ' invited you to join the ' + action_object + '</div></div>');
         }
      }
      else if (value.actiontype == 301 || value.actiontype == 403 || value.actiontype == 306 || value.actiontype == 406 || value.actiontype == 316 || value.actiontype == 416 || value.actiontype == 325 || value.actiontype == 425 || value.actiontype == 326 || value.actiontype == 327 || value.actiontype == 426 || value.actiontype == 328)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> posted in ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' in ' + action_object + '</div></div>');
         }
      }
      else if (value.actiontype == 307)
      {
         if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '" data="group"><input type="hidden" id=' + value.pageid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + '</div></div>');
         }
      }
      else if (value.actiontype == 2901 || value.actiontype == 2906 || value.actiontype == 2916 || value.actiontype == 2925 || value.actiontype == 2926)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            var page_image = icon_cdn + '/broadcast.png';
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + page_image + '" /><span class="rtm_each_text">New broadcast is available for you .</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            var page_image = icon_cdn + '/broadcast.png';
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '" data="page"><input type="hidden" id=' + value.pageid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + page_image + ' height="50" width="50" /><div class="notice_name">' + action_desc + '</div></div>');
         }
      }
      else if (value.actiontype == 330)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' you.</div></div>');
         }
      }
      else if (value.actiontype == 410)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' you.</div></div>');
         }
      }
      else if (value.actiontype == 501 || value.actiontype == 1101)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionon] + '" /><span class="rtm_each_text"><b>' + name[value.actionon] + '</b> ' + action_desc + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + ' is missing you</div></div>');
         }
      }
      else if (value.actiontype == 502)
      {
         if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' you.</div></div>');
         }
      }
      else if (value.actiontype == 503 || value.actiontype == 511)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' someone\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' you.</div></div>');
         }
      }
      else if (value.actiontype == 802 || value.actiontype == 811 || value.actiontype == 1202 || value.actiontype == 1211 || value.actiontype == 1402 || value.actiontype == 1411)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby == value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a>\'s ' + action_object + '</div>');
            }
            else
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + '<a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a>\'s ' + action_object + ' in <a class="ajax_nav" href="profile.php?id=' + value.actionon + '"> ' + name[value.actionon] + '</a>\'s diary</div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' your ' + action_object + '</div></div>');
         }
      }
      else if (value.actiontype == 1201)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
         }
      }
      else if (value.actiontype == 1401)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + ' </span>');
         }
         else if (feed_type == 'notice_feed')
         {
            if (value.postby != value.actionon)
            {
               $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + ' sent you a gift</div></div>');
            }
         }
      }
      else if (value.actiontype == 1600)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby != value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a> posted a link in <a class="ajax_nav" href="profile.php?id=' + value.actionon + '">' + name[value.actionon] + '</a>\'s diary</div>');
            }
            else
            {
               postid.append('<div class="name_50"></div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            if (value.postby != value.actionon)
            {
               $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + ' posted a link your diary</div></div>');
            }
         }
      }
      else if (value.actiontype == 1602 || value.actiontype == 1611)
      {
         if (feed_type == 'news_feed')
         {
            if (value.postby == value.actionon)
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + ' <a href="' + value.link + '"> a link</a> shared by <a class="ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a></div>');
            }
            else
            {
               postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + ' <a href="' + value.link + '"> a link</a> shared by <a class="ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> in <a class="ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a>\'s diary</div>');
            }
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' your ' + action_object + '</div></div>');
         }
      }
      else if (value.actiontype == 2002 || value.actiontype == 2011)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + ' status-song set by <a class="ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' your ' + action_object + '</div></div>');
         }
      }
      else if (value.actiontype == 2102 || value.actiontype == 2111)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + ' a song dedicated by <a class="ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> to <a class="ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' ' + action_object + '<a class="ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</div></div>');
         }
      }
      else if (value.actiontype == 600 || value.actiontype == 700 || value.actiontype == 800 || value.actiontype == 2500 || value.actiontype == 2600 || value.actiontype == 2800)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + action_desc + '</div></div>');
         }
      }
      else if (value.actiontype == 1900 || value.actiontype == 2400)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + action_desc + ' you</div></div>');
         }
      }
      else if (value.actiontype == 2801)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"></div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s question</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + action_desc + ' your question</div></div>');
         }
      }
      else if (value.actiontype == 602 || value.actiontype == 611 || value.actiontype == 702 || value.actiontype == 711 || value.actiontype == 802 || value.actiontype == 811 || value.actiontype == 1902 || value.actiontype == 1911 || value.actiontype == 2402 || value.actiontype == 2411 || value.actiontype == 2502 || value.actiontype == 2511 || value.actiontype == 2602 || value.actiontype == 2611 || value.actiontype == 2802 || value.actiontype == 2811)
      {
         if (feed_type == 'news_feed')
         {
            postid.append('<div class="news name_50"><a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " >' + name[value.actionby] + '</a>' + action_desc + ' <a class="ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a>\'s ' + action_object + '</div>');
         }
         else if (feed_type == 'live_feed')
         {
            postid.append('<input type="hidden" value="' + value.pageid + '" /><input type="hidden" value="' + value.life_is_fun + '" /><img class="rtm_each_photo" height="30" width="30" src="' + pimage[value.actionby] + '" /><span class="rtm_each_text"><b>' + name[value.actionby] + '</b> ' + action_desc + ' ' + name[value.actionon] + '\'s ' + action_object + '</span>');
         }
         else if (feed_type == 'notice_feed')
         {
            $(container).append('<div class="notice_drop"  id="' + con + value.actionid + value.actiontype + '"><input type="hidden" id=' + value.actionid + ' value="' + value.life_is_fun + '"/><img class="lfloat" src =' + pimage[lastactionby] + ' height="50" width="50" /><div class="notice_name">' + action.name_split(name, value.actionby) + '' + action_desc + ' your ' + action_object + '</div></div>');
         }
      }
   }

   function member_deploy(data)
   {
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var profile_relation = $('#profile_relation_hidden').attr('value');
      $.each(data.action, function(index, value)
      {
         $('#prev').append('<div id="' + value.profileid + '" data="' + value.profileid + '" style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a></div></div>');
         if (profile_relation == 0)
         {
            if (value.profileid == myprofileid)
            {
               if (value.priviledge == 1)
               {
                  $('#' + value.profileid).append('<div style="float:right;"><input type="hidden" value="' + value.profileid + '" /><input id="' + value.profileid + '" class="dedicate_button prompt_positive"  type="submit" value="Admin" /><div>');
               }
            }
            else if (value.priviledge == 0)
            {
               $('#' + value.profileid).append('<div style="float:right;"><input id="' + value.profileid + '" class="add_friend" style="width:9em;height:2.2em;background-color:#ebebeb;color:#333333;font-size:1.1em;cursor:pointer;" type="submit" class="theme_button" onclick="action.group_admin_make(this,1)" value="+Make Admin" /><div>');
               $('#' + value.profileid).append('<div style="float:right;"><input type="hidden" value="' + value.profileid + '" /><input id="' + value.profileid + '" class="dedicate_button prompt_positive theme_button"  type="submit" value="Remove Member"  onclick="action.group_admin_make(this,2)" /><div>');
            }
            else if (value.priviledge == 1)
            {
               $('#' + value.profileid).append('<div style="float:right;"><input type="hidden" value="' + value.profileid + '" /><input id="' + value.profileid + '" class="dedicate_button" style="width:9em;height:2.2em;background-color:#ebebeb;color:#333333;font-size:1.1em;cursor:pointer;" type="submit" class="theme_button" onclick="action.group_admin_make(this,0)" value="-Remove Admin" /><div>');
               $('#' + value.profileid).append('<div style="float:right;"><input type="hidden" value="' + value.profileid + '" /><input id="' + value.profileid + '" class="dedicate_button prompt_positive theme_button"  type="submit" value="Remove Member" onclick="action.group_admin_make(this,2)" /><div>');
            }
         }
         else
         {
            if (value.priviledge == 1)
            {
               $('#' + value.profileid).append('<div style="float:right;"><input type="hidden" value="' + value.profileid + '" /><input id="' + value.profileid + '" class="dedicate_button prompt_positive theme_button"  type="submit" value="Admin" "/><div>');
            }
         }
      });
   }

   function guest_deploy(data, container)
   {
      if (data.action.going.length) $(container).append('<h6 class="page_title">Going</h6>');
      $.each(data.action.going, function(index, value)
      {
         $(container).append('<div id="' + value.profileid + '" style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;padding:1.5em;"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a></div></div>');
      });
      if (data.action.declined.length) $(container).append('<h6 class="page_title">Declined</h6>');
      $.each(data.action.declined, function(index, value)
      {
         $(container).append('<div id="' + value.profileid + '" style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;padding:1.5em;"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a></div></div>');
      });
      if (data.action.no_response.length) $(container).append('<h6 class="page_title">No Response</h6>');
      $.each(data.action.no_response, function(index, value)
      {
         $(container).append('<div id="' + value.profileid + '" style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;padding:1.5em;"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a></div></div>');
      });
   }

   function bio_deploy(data)
   {
      var myprofileid = $('#myprofileid_hidden').attr('value'); 
      var profileid = $('#profileid_hidden').attr('value');
      $('.bio_indiv_container').remove();
      $('#prev').html('<div class="row bio_row"><div style="padding:1em 1em 1em 2em; background-image:linear-gradient(to bottom, #FFFFFF 0%, #ccc 100%), linear-gradient(to bottom, #Fff 0%, #Fff 100%); background-clip: content-box, padding-box;" class="col-md-12"><input type="hidden" value="'+profileid+'" /><input type="hidden" value="50" /><img id="'+data.profile_imageid+'" data="'+data.profile_image+'" class="img-thumbnail lfloat" src="thumbnail.php?file='+data.profile_image+'&height=150&width=150" onclick="action.image_viewer(this)" /><span class="bold left1"><a class="ajax_nav" href="profile.php?id='+profileid+'" style="font-size:1.5em;">'+data.name+'</a></span><div style="margin-top:6em;margin-left:14em;" id="profile_above"><div><span class="glyphicon glyphicon-envelope "></span>:<a href=mailto:'+data.email+' >'+data.email+'</a></div></div></div>');
      if(myprofileid != profileid)
      {
        $('#profile_above').prepend('<div id="parent_con" style="margin-right:2em;"><div><input class="profile_actions_button theme_button rfloat " onclick="ui.message(this)" style="width:7.3em;" type="submit" value="+Message" /></div></div>');
      
      if (data.info.profile_relation != 0  && data.info.friendship_status == -1)
      {
        $('#parent_con').append('<div style="margin-right:8em;"><input class="profile_actions_button theme_button rfloat" id="' + profileid + '" style="width:7.3em;" onclick="action.friend_accept(this,1); this.click=null;" type="submit" value=" +Follow " id="' + profileid + '" data="follow_back"/></div>');
     }
    else if (data.info.friendship_status == 0 && data.info.profile_relation != 3)
    {
        $('#parent_con').append('<div style="margin-right:8em;"><input class="profile_actions_button theme_button rfloat" id="' + profileid + '" style="width:7.3em;" onclick="action.add_friend(this,' + profileid + '); this.click=null;" type="submit" value=" +Follow " id="' + profileid + '"/></div>');
    }
    else if (data.info.friendship_status == 2)
    {
        $('#parent_con').append('<div style="margin-right:8em;"><div><span data-toggle="modal"  data-target="#praisemodalbadge"><input class="profile_actions_button theme_button rfloat" style="width:7.3em;" type="submit" value="Praise" /></span></div></div>');
     }   
    }
      if (data.tagline)
      { 
         $('#profile_above').append('<div><span class="glyphicon glyphicon-tags"></span>:'+data.tagline+'</div>');
      }
      if (myprofileid == profileid)
      {
         $('#profile_above').append('<div><span class="glyphicon glyphicon-camera"></span>:<a href="register.php?hl=profile_picture" >Change Profile Picture</a></div>');
      }
      $('.bio_row').append('<div class="bio_indiv_container"></div>');
      $('.bio_indiv_container').append('<div class="bio_each col-md-6 panel panel-default" id="bio_each_profession"><div class="bio_each_title">Profession</div></div>');
      if (myprofileid == profileid || data.team.length > 0)
      {
    callback.bio_item_deply('bio_each_profession',data.team, data.privacy.team,data.edit,'Team','team_edit_link',234,'Team');
      }
      if (myprofileid == profileid || data.profession.length > 0)
      {
        callback.bio_item_deply('bio_each_profession',data.profession, data.privacy.profession,data.edit,'Profession','profession_edit_link',202,'Profession');
      }
      if (myprofileid == profileid || data.designation.length > 0)
      {
         callback.bio_item_deply('bio_each_profession',data.designation, data.privacy.designation,data.edit,'Designation','designation_edit_link',239,'Designation');
      }
      if (myprofileid == profileid || data.major.length > 0)
      {
          callback.bio_item_deply('bio_each_profession',data.major, data.privacy.major,data.edit,'Major','major_edit_link',235,'Major');
      }
      if (myprofileid == profileid || data.skill.length > 0)
      {
         callback.bio_item_deply('bio_each_profession',data.skill, data.privacy.skill,data.edit,'Skill','skill_edit_link',230,'Skill');
      }
      if (myprofileid == profileid || data.tool.length > 0)
      {
         callback.bio_item_deply('bio_each_profession',data.tool, data.privacy.tool,data.edit,'Tools worked on','tool_edit_link',236,'Tools worked on');
      }
      if (myprofileid == profileid || data.project.length > 0)
      {
         callback.bio_item_deply('bio_each_profession',data.project, data.privacy.project,data.edit,'Project','project_edit_link',231,'Project');
      }
      if (myprofileid == profileid || data.certificate.length > 0)
      {
         callback.bio_item_deply('bio_each_profession',data.certificate, data.privacy.certificate,data.edit,'Certificate','certificate_edit_link',232,'Certificate');
      }
      if (myprofileid == profileid || data.award.length > 0)
      {
         callback.bio_item_deply('bio_each_profession',data.award, data.privacy.award,data.edit,'Award','award_edit_link',233,'Award');
      }
            $('.bio_indiv_container').append('<div class="bio_each col-md-6 panel panel-default" id="bio_each_background"><div class="bio_each_title">Background</div></div>');
      if (myprofileid == profileid || data.company.length > 0)
      {
         callback.bio_item_deply('bio_each_background',data.company, data.privacy.company,data.edit,'Company','company_edit_link',205,'Company');
      }
      if (myprofileid == profileid || data.college.length > 0)
      {
         callback.bio_item_deply('bio_each_background',data.college, data.privacy.college,data.edit,'College','college_edit_link',204,'College');
      }
      if (myprofileid == profileid || data.school.length > 0)
      {
         callback.bio_item_deply('bio_each_background',data.school, data.privacy.school,data.edit,'School','school_edit_link',203,'School');
      }
      if (myprofileid == profileid || data.city.length > 0)
      {
         callback.bio_item_deply('bio_each_background',data.city, data.privacy.city,data.edit,'City','city_edit_link',201,'City');
      }
      $('.bio_indiv_container').append('<div class="bio_each col-md-6 panel panel-default" id="bio_each_contact"><div class="bio_each_title">Contact</div></div>');
      if (data.email)
      {
         $('#bio_each_contact').append('<div class="panel panel-default"><div class="panel-heading" >Email</div><div class="panel-body">' + data.email + '</div></div>');
      }
      if (myprofileid == profileid || data.extension.length > 0)
      {
         callback.bio_item_deply('bio_each_contact',data.extension, data.privacy.extension,data.edit,'Office Extension','extension_edit_link',237,'Office Extension');
      }
      if (myprofileid == profileid || data.mobile.length > 0)
      {
         callback.bio_item_deply('bio_each_contact',data.mobile, data.privacy.mobile,data.edit,'Mobile','mobile_edit_link',215,'Mobile');
      }
      if (myprofileid == profileid)
      {
         $('#bio_each_contact').append('<div class="panel panel-default"><div class="panel-heading" >Birthday</div><div class="panel-body">' + data.birthday + '</div></div>');
      
      } 
   }

   function friend_deploy(data,container)
   {
      $.each(data.action, function(index, value)
      {
         $(container).append('<div id="' + value.profileid + '" class="friend_feed""><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a></div></div>');
         if (value.status == 0)
         {
            $('#' + value.profileid).append('<div style="float:right;"><input id="' + value.profileid + '" class="add_friend theme_button" type="submit" value=" +Follow " " onclick ="action.add_friend(this,' + value.profileid + '); this.onclick=null;" /><div>');
         }
      });
   }

   function message_recent_fetch()
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      $.getJSON('ajax/write.php', {
         action: 'message_recent_fetch'
      }, function(data)
      {
         if (data.ack != 0)
         {
            $('#session_name_hidden').attr('value', JSON.stringify(data.name));
            $('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
            $('#inbox_container').html('');
            var redirecteduser = $('#profileid_hidden').attr('value');
            $.each(data.action, function(index, value)
            {
               if (value.actionby == myprofileid)
               {
                  showuser = value.actionon;
                  showimage = icon_cdn + '/out.png'
               }
               else
               {
                  showuser = value.actionby;
                  showimage = icon_cdn + '/in.png'
               }
               if ((value.message).length > 20) value.message = (value.message).slice(0, 17) + '...';
               $('#show_inbox').append('<div class="inbox_user" data="' + showuser + '" id="' + showuser + '"><img class="online_photo" height="50" width="50" src="' + data.pimage[showuser] + '" /><span class="online_name" style="font-weight:bold;">' + data.name[showuser] + '</span><div><img height="20" width="20" src="' + showimage + '"/>' + value.message + '</div></div>');
               $('#' + showuser).append('<div style="margin-left:6em;margin-top:.15em;color:gray;"><img src="' + icon_cdn + '/clock.png" width="6" /><span style="color:gray;" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></a></div>');
               if (index == 0)
               {
                  if (redirecteduser != myprofileid)
                  {
                     user = redirecteduser;
                  }
                  else user = showuser;
                  $('#inbox_container').html('');
                  $('#inbox_container').append('<h1 id="message_user_name">' + data.name[user] + '</h1>');
                  ui.createMessageUI(user, data.name[user]);
                  action.previous_talk_message(user, 0, 1);
               }
            });
         }
         else
         {
            if (data.ack == 0)
            {
               $('#inbox_container').append('<h1 id="no_message">No message to show<h1>');
            }
         }
         $('.inbox_user').live('click', function()
         {
            $('#inbox_container').html('');
            user = $(this).attr('data');
            $('#inbox_container').append('<h1 id="message_user_name">' + data.name[user] + '</h1>');
            ui.createMessageUI(user, name);
            action.previous_talk_message(user, 0, 1);
         });
      });
   }

   function photo_deploy(data)
   {
      $('table').append('<tr></tr>');
      var i = 0;
      $.each(data.action, function(index, value)
      {
         $('tr:last').append('<td class="photo_feed img-thumbnail thumbnail_td" ><input type="hidden" value="' + value.profileid + '" /><input type="hidden" value="6" /><img onclick="action.image_viewer(this)" id="' + value.actionid + '" data=' + value.file + ' src="thumbnail.php?file=' + value.file + '&height=120&width=120" alt="photo"  /></td>');
         i++;
         if (i % 4 == 0)
         {
            $('table').append('<tr></tr>');
         }
      });
   }

   function file_deploy(data)
   {
    if(data.hasOwnProperty('groupname')) 
    {
        $('.file_center_title').html(''+data.groupname+' - File')
        $('#file_upload_modal_level').html('Upload file in <span style="color:#336699">'+data.groupname+'</span>');
        $('#photo_hidden_profileid').attr('value',data.groupid);
        $('#action_hidden').attr('value','group_photo_upload');
       // param.action ='group_photo_upload';
    }
    else if(data.hasOwnProperty('eventname'))
    {
        $('.file_center_title').html(''+data.eventname+' - File')
        $('#file_upload_modal_level').html('Upload file in <span style="color:#336699">'+data.eventname+'</span>');
        $('#photo_hidden_profileid').attr('value',data.eventid);
        $('#action_hidden').attr('value','event_photo_upload');
    }
    else
    {
        $('#file_upload_modal_level').html('Upload file to All files <br/><span style="font-size:0.5em;color:light gray;">(Uploaded files will be shared with everyone on your network . If you want to share with group or event please select from left menu .)</span>');
        $('#action_hidden').attr('value','photo_upload');
        var myprofileid = $('#myprofileid_hidden').attr('value');
        $('#photo_hidden_profileid').attr('value',myprofileid);
    }
    
      $.each(data.action, function(index, value)
      {
         var ext = value.caption.split('.').pop();
         var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
         $('.file_table_body').append('<tr class="doc_row"><td class="doc_column"><img class="lfloat" src=' + fileimage + ' height="40" width="40" /><div class="ellipsis">' + value.caption + '</div></td><td class="doc_column">'+data.name[value.actionby]+'</td><td class="doc_column">'+value.date+'</td><td class="doc_column">'+value.sharedwith+'</td><td class="doc_column"><table><tbody><tr><td class="action_icons"><a target="_blank" href="https://docs.google.com/viewer?url=' + value.file + '" title="Preview and edit the file"><span class="glyphicon glyphicon-edit"></span></a></td><td class="action_icons"><span class="glyphicon glyphicon-share" title="Share this file"></span></td><td class="action_icons"><a href=' + value.file + ' data="' + value.file + '" target="_blank" title="Download File"><span class="glyphicon glyphicon-download"></span></a></td></tr></tbody></table></td></tr>');
      });
   }
   function video_deploy(data)
   {
    if(data.hasOwnProperty('groupname')) 
    {
        $('.file_center_title').html(''+data.groupname+' - Videos')
        $('#file_upload_modal_level').html('Upload video in <span style="color:#336699">'+data.groupname+'</span>');
        $('#photo_hidden_profileid').attr('value',data.groupid);
        $('#action_hidden').attr('value','group_photo_upload');
       // param.action ='group_photo_upload';
    }
    else if(data.hasOwnProperty('eventname'))
    {
        $('.file_center_title').html(''+data.eventname+' - Videos')
        $('#file_upload_modal_level').html('Upload video in <span style="color:#336699">'+data.eventname+'</span>');
        $('#photo_hidden_profileid').attr('value',data.eventid);
        $('#action_hidden').attr('value','event_photo_upload');
    }
    else
    {
        $('#file_upload_modal_level').html('Upload video to All videos <br/><span style="font-size:0.5em;color:light gray;">(Uploaded video will be shared with everyone on your network . If you want to share with group or event please select from left menu .)</span>');
        $('#action_hidden').attr('value','photo_upload');
        var myprofileid = $('#myprofileid_hidden').attr('value');
        $('#photo_hidden_profileid').attr('value',myprofileid);
    }
    
      $.each(data.action, function(index, value)
      {
         $('.video_table_body').append('<div style="margin-left:8px; display:inline;"><div id="videobox' + value.actionid + '" ></div></div>');
         jwplayer("videobox" + value.actionid).setup(
         {
            file: value.file,
            image: value.thumbnail,
            title: value.caption,
            width: "46%",
            aspectratio: "16:9",
            fallback: "false",
            primary: "flash"
         }); 
/*
$('.video_table_body').append('<tr class="video_tr"><div class="video_in" id="videobox' + value.actionid + '"></div><div>'+value.caption+'</div></tr>');
         jwplayer("videobox" + value.actionid).setup(
         {
            file: value.file,
            image: value.thumbnail,
            title: value.caption,
            width: "41%",
            aspectratio: "16:9",
            fallback: "false",
            primary: "flash"
         }); */
      });
   }

   function album_deploy(data)
   {
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var name;
      var i = 0;
      $.each(data.action, function(index, value)
      {
         name = '#' + 'tr' + i;
         var file;
         if (value.actiontype == 5 || value.actiontype == 6)
         {
            file = 'user_image/' + value.file;
         }
         else if (value.actiontype == 50)
         {
            file = 'upload_pic/' + value.file;
         }
         $(name).append('<div id="' + value.actionid + '" style="padding:.5em;background:#ffffff;margin-bottom:1em;"><imput type="hidden" value="' + value.actionon + '" /><imput type="hidden" value="' + value.actiontype + '" /><a class="ajax_nav" href="profile.php?id=' + value.actionby + '"><img src =' + data.pimage[value.actionby] + ' height="25" width="25" /></a><div style="position:relative;left:3em;top:-2em;margin-bottom:-1em;"><a class="ajax_nav" href="profile.php?id=' + value.actionby + '">' + data.name[value.actionby] + '</a></div><div id="' + value.actionid + '" align="middle"><img class="thumb" style="cursor:pointer;padding:.5em;background:#ffffff;" src="thumbnail.php?file=' + file + '&maxh=1000&maxw=198" alt="photo"  /></div></div>');
         comment_album_decode(value, data.name, data.pimage, myprofileid);
         comment_box_album(value, data.pimage, myprofileid)
         i++;
         i = i % 5;
      });
   }

   function people_deploy(data)
   {
      $.each(data.action, function(index, value)
      {
         $('#prev').append('<div class="user people_each" id="' + value.profileid + '"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" width="100" height="100"></a><div class="name_80"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a></div></div>');
         
         if (value.designation != null)
         {
            $('#' + value.profileid).children().eq(1).append('<div><strong>' +value.designation+ '</strong></div>');
         }
         if (value.email != null)
         {
            $('#' + value.profileid).children().eq(1).append('<div style="margin-top:1em;"><span class="glyphicon glyphicon-envelope"></span>' +value.email+ '</div>');
         }
         if (value.profession != '')
         {
            $('#' + value.profileid).children().eq(1).append('<div title="Profession"><span class="glyphicon glyphicon-briefcase"></span>' +value.profession+ '</div>');
         }
         if (value.team != null)
         {
            $('#' + value.profileid).children().eq(1).append('<div title="Team"><span class="glyphicon glyphicon-tasks"></span>' +value.team+ '</div>');
         } 
         if (value.status == '0')
         {
            $('#' + value.profileid+' '+' .name_80:first').prepend('<input class="profile_actions_button theme_button" onclick="action.add_friend(this,' + value.profileid + '); this.onclick=null;" style="width:7em;" type="submit" value=" +Follow " id="' + value.profileid + '"/>');
         }
      });
   }
   var con = 'nf_post';

   function notice_deploy(data, container)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      $.each(data.action, function(index, value)
      {
         excited_desc = '';
         if (value.actiontype != 63)
         {
            if (value.hasOwnProperty('value.excited') && value.excited.length == 1) excited_desc = ' is excited at ';
            else if ($.inArray(myprofileid, value.excited) > -1 && value.excited.length == 2) excited_desc = ' is excited at ';
            else
            excited_desc = ' are excited at ';
         }
         arr = (value.actionby).split(',');
         len = arr.length;
         lastactionby = arr[len - 1];
         if (container == '#text')
         {
            con = 'notice_post';
         }
         deploy.action_decode('notice_feed', value, data.name, data.pimage, container, '', 0, 1);
         var distinctid = con + value.actionid + value.actiontype;
         $('#' + distinctid).append('<div style="margin-left:6em;margin-top:.5em;color:gray;"><a href="action.php?actionid=' + value.pageid + '&life_is_fun=' + value.life_is_fun + '"><img src="' + icon_cdn + '/clock.png" width="6" /><span style="color:gray;" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></a></div>');
      });
   }

   function ajax_navigation(state, param, lastScrollTopfeed)
   {
      //console.log(window.ajax_queue);
      for (var i = 0; i < window.ajax_queue.length; i++)
      {
         window.ajax_queue[i].abort();
      }
      page = state.page;
      var icon_cdn = $('#icon_cdn').attr('value');
      $('#page_hidden').attr('value', page);
      $('html').css('overflow-y', 'scroll') //hidden in case of inbox 
      $("html,body").animate(
      {
         scrollTop: 0
      }, "slow");
      lastScrollTopfeed = 0;
      $('#load_hidden').remove(); //removing iframe and will append it in the end .
      param.start = 0;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var profileid = 0;
      //-----------------------------------------------------------
      var arr_page = state.url.toString().split('&');
      for (var i = 0; i < arr_page.length; i++)
      {
         if (arr_page[i].indexOf('id=') >= 0)
         {
            pos = arr_page[i].indexOf('id=');
            profileid = $.trim(arr_page[i].slice(pos + 3));
            break;
         }
      }
      for (var i = 0; i < arr_page.length; i++)
      {
         if (arr_page[i].indexOf('hl=') >= 0)
         {
            pos = arr_page[i].indexOf('hl=');
            page = arr_page[i].slice(pos + 3);
            break;
         }
      }
      for (var i = 0; i < arr_page.length; i++)
      {
         if (arr_page[i].indexOf('filter=') >= 0)
         {
            pos = arr_page[i].indexOf('filter=');
            filter = arr_page[i].slice(pos + 7);
            break;
         }
      }
      for (var i = 0; i < arr_page.length; i++)
      {
         if (arr_page[i].indexOf('q=') >= 0)
         {
            pos = arr_page[i].indexOf('q=');
            q = arr_page[i].slice(pos + 2);
            break;
         }
      }
      if (profileid == 0)
      {
         profileid = myprofileid;
      }
      //----------------------------------------------------------------			
      if (state.url.indexOf('hl') >= 0)
      {
         $('.selected').removeClass('selected');
         $("object").parent().append('<img class="ajax_loader" src="' + icon_cdn + '/ajax_loader.gif" style="position:absolute;top:0.34em;right:0em;">');
         $("object").addClass('selected');
      }
      if (state.url.indexOf('/') >= 0)
      {
         page = 'home';
      }
      if (state.url.indexOf('profile.php') >= 0)
      {
         if (state.url.indexOf('hl=') >= 0)
         {
            if (page == 'image')
            {
               page = 'pphoto';
            }
            if (page == 'file')
            {
               page = 'file';
            }
            if (page == 'video')
            {
               page = 'video';
            }
            if (page == 'praise')
            {
               page = 'praise';
            }
            if (page == 'following')
            {
               page = 'following';
            }
            if (page == 'followers')
            {
               page = 'followers';
            }
            else if (page == 'diary')
            {
               page = 'profile_json';
            }
            $('#page_hidden').attr('value', page);
         }
         else
         {
            page = 'bio';
            $('#page_hidden').attr('value', page);
         }
         $('.selected').removeClass('selected');
         $("object").parent().append('<img  class="ajax_loader" src="' + icon_cdn + '/ajax_loader.gif" style="position:absolute;top:0.34em;right:0em;">');
         $("object").addClass('selected');
      }
      if (state.url.indexOf('search.php') >= 0)
      {
         page = 'search';
         $('#page_hidden').attr('value', page);
         $('.selected').removeClass('selected');
         $("object").parent().append('<img  class="ajax_loader" src="' + icon_cdn + '/ajax_loader.gif" style="position:absolute;top:0.34em;right:0em;">');
         $("object").addClass('selected');
      }
      else if (state.url.indexOf('group.php') >= 0)
      {
         if (state.url.indexOf('hl=') >= 0)
         {
            if (page == 'about')
            {
               page = 'group_about';
            }
            else if (page == 'settings')
            {
               page = 'group_settings';
            }
            else if (page == 'file')
            {
               page = 'group_file';
            }
            else if (page == 'video')
            {
               page = 'group_video';
            }
            else if (page == 'member')
            {
               page = 'group_member';
            }
            else
            {
               page = 'group_json';
            }
            $('#page_hidden').attr('value', page);
         }
         else
         {
            page = 'group_json';
            $('#page_hidden').attr('value', page);
         }
         $('.selected').removeClass('selected');
         $("object").parent().append('<img  class="ajax_loader" src="' + icon_cdn + '/ajax_loader.gif" style="position:absolute;top:0.34em;right:0em;">');
         $("object").addClass('selected');
      }
      else if (state.url.indexOf('event.php') >= 0)
      {
         if (state.url.indexOf('hl=') >= 0)
         {
            if (page == 'about')
            {
               page = 'event_about';
            }
            else if (page == 'settings')
            {
               page = 'event_setting';
            }
            else if (page == 'file')
            {
               page = 'event_file';
            }
             else if (page == 'video')
            {
               page = 'event_video';
            }
            else if (page == 'guest')
            {
               page = 'guest';
            }
            else
            {
               page = 'event_json';
            }
            $('#page_hidden').attr('value', page);
         }
         else
         {
            page = 'event_json';
            $('#page_hidden').attr('value', page);
         }
         $('.selected').removeClass('selected');
         $("object").parent().append('<img  class="ajax_loader" src="' + icon_cdn + '/ajax_loader.gif" style="position:absolute;top:0.34em;right:0em;">');
         $("object").addClass('selected');
      }
      else if (state.url.indexOf('page.php') >= 0)
      {
         if (state.url.indexOf('hl=') >= 0)
         {
            if (page == 'about')
            {
               page = 'page_about';
            }
            else if (page == 'post')
            {
               page = 'page_json';
            }
            $('#page_hidden').attr('value', page);
         }
         else
         {
            page = 'page_json';
            $('#page_hidden').attr('value', page);
         }
         $('.selected').removeClass('selected');
         $("object").parent().append('<img  class="ajax_loader" src="' + icon_cdn + '/ajax_loader.gif" style="position:absolute;top:0.34em;right:0em;">');
         $("object").addClass('selected');
      }
      else if (state.url.indexOf('admin.php') >= 0)
      {
         if (state.url.indexOf('hl=') >= 0)
         {
            if (page == 'invite')
            {
               page = 'invite';
            }
            else if (page == 'admin')
            {
               page = 'admin_list';
            }
            else if (page == 'remove_user')
            {
               page = 'remove_user';
            }
            else if (page == 'analytic')
            {
               page = 'analytics';
            }
            else if (page == 'usefullinks')
            {
               page = 'usefullinks';
            }
            else if (page == 'designation')
            {
               page = 'designation';
            }
            else if (page == 'team')
            {
               page = 'team';
            }
            else if (page == 'flashboard')
            {
               page = 'flashboard';
            }
            else if (page == 'sotw')
            {
               page = 'sotw';
            }
            else if (page == 'feature')
            {
               page = 'feature';
            }
            else if (page == 'update')
            {
               page = 'admin_json';
            }
            $('#page_hidden').attr('value', page);
         }
         else
         {
            page = 'admin_json';
            $('#page_hidden').attr('value', page);
         }
         $('.selected').removeClass('selected');
         $("object").parent().append('<img  class="ajax_loader" src="' + icon_cdn + '/ajax_loader.gif" style="position:absolute;top:0.34em;right:0em;">');
         $("object").addClass('selected');
      }
      if (page == 'home')
      {
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'Quipmate', '/');
            }
            else
            {
               window.location.hash = '/';
            }
         }
         $('.row').html('');
         $('.row').append('<div class="col-md-2 left" id="left"></div><div id="center" class="col-md-6 center"></div><div id="right" class="col-md-3 right"></div>');
         page = 'news_json';
         url = 'ajax/write.php';
         param.action = 'news_feed';
         param.start = 0;
         window.increment = 10;
         myprofileid = $('#myprofileid_hidden').attr('value');
         myphoto = $('#myprofileimage_hidden').attr('value');
         myname = $('#myprofilename_hidden').attr('value');
         $('#profileid_hidden').attr('value', myprofileid);
         $('#page_hidden').attr('value', page);
         $('#profilename_hidden').attr('value', myname);
         $(document).attr('title', 'Quipmate');
         $('#left').html('<ul class=" nav nav-pills nav-stacked"><li ><a class="links ajax_nav" id="news_json" href="?hl=update" title="Updates from your followings"><span class="name_20">News Feed</span></a></li><li ><a  class="links ajax_nav" id="inbox" href="?hl=inbox" title="Messages from your friends"><span class="name_20">Messages</span></a></li><li ><a class="links ajax_nav" id="file" href="profile.php?hl=file" title="Central location for all files on your network"><span class="name_20">Knowledge Base</span></a></li><li ><a class="links ajax_nav" id="new_user" href="?hl=new_user" title="Find out who joined Quipmate after you"><span class="name_20">Co-workers</span></a></li></ul><div name="group" style="margin-top:1em;"><span style="font-weight:bold;font-size:1em;color:gray">Groups</span><ul id="groups_append" class="nav nav-pills nav-stacked"></ul></div><div name="event" style="margin-top:1em;"><span style="font-weight:bold;font-size:1em;color:gray">Events</span><ul id="events_append" class="nav nav-pills nav-stacked"></ul></div><div id="friend_event" class="panel panel-default"><div id="friend_event_body" class="panel-body"></div></div><div style="margin-top:1em;padding-top:.5em;border-top:.1em solid #cccccc;"><a href="#" target="_blank"><small>&copy; Quipmate</small></a><span class="separator">|</span><a href="public/help.php" target="_blank"><small>Help</small></a><span class="separator">|</span><a href="#" onclick="ui.feedback(this)"><small>Feedback</small></a></div>');
         $('#right').html('<div id="birthday_today" class="panel panel-default"></div><div id="friend_invite" class="panel panel-default"><div id="friend_invite_heading" class="panel-heading"></div><div id="friend_invite_body" class="panel-body"></div></div>');
/*Removed code 
				<div id="" class="right_item"><a style="cursor:pointer;" onclick="ui.direct_to_md(this,event)">Direct to MD</a></div><div id="blog_write" class="right_item"> <a href="action.php?hl=blog-write" >Write a blog</a></div>
				
				*/
         action.friend_suggest(this, 6);
         ui.friend_invite();
         action.actiontype_preview();
         action.birthday_fetch(this);
         action.group_and_event_select(this);
         $('#news_json').addClass('selected');
         $('#center').html('<div id="news_poll"></div>');
         $('#center').prepend('<div id="sharing_area"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#sharing_area').load('/ajax/write.php?action=actions_load');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
         action.pro_stat(this);
         action.usefullinks_load();
         action.star_of_the_week_fetch();
        // action.flash_board_fetch(); // Removing this feature 
         //action.csv_fetch();
      }
      else if (page == 'search')
      {
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'search.php?filter=' + filter + '&q=' + q + '');
            }
            else
            {
               window.location.hash = 'search.php?filter=' + filter + '&q=' + q + '';
            }
         }
         page = 'search';
         url = 'ajax/write.php';
         param.action = 'search';
         param.filter = filter;
         param.q = q;
         param.start = 0;
         window.increment = 10;
         $('#search_result').html('');
      }
      else if (page == 'admin_json')
      {
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'admin.php?hl=update');
            }
            else
            {
               window.location.hash = 'admin.php?hl=update';
            }
         }
         myprofileid = $('#myprofileid_hidden').attr('value');
         myphoto = $('#myprofileimage_hidden').attr('value');
         myname = $('#myprofilename_hidden').attr('value');
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#left').html('<ul class=" nav nav-pills nav-stacked"><li class="links"><a class="ajax_nav" id="admin_json" href="admin.php?hl=update" title="Posts shared by everyone on your network"><span class="name_20">Admin Feed</span></a></li><li class="links"><a class="ajax_nav" id="invite" href="admin.php?hl=invite" title="Invite fellow assciates to the network"><span class="name_20">Invite Employees</span></a></li><li class="links"><a class="ajax_nav" id="admin_list" href="admin.php?hl=admin" title="List of all admins of this network"><span class="name_20">Admin List</span></a></li><li class="links"><a class="ajax_nav" id="usefullinks" href="admin.php?hl=usefullinks" title="Post Useful Links"><span class="name_20">Useful Links</span></a></li><li class="links"><a class="ajax_nav" id="designation" href="admin.php?hl=designation" title="designation"><span class="name_20">Designation</span></a></li> <li class="links"><a class="ajax_nav" id="team" href="admin.php?hl=team" title="team"><span class="name_20">Team</span></a></li> <li class="links"><a class="ajax_nav" id="sotw" href="admin.php?hl=sotw" title="Star Of The Week"><span class="name_20">Star Of The Week</span></a></li><li class="links"><a class="ajax_nav" id="group_byadmin" href="admin.php?hl=group_byadmin" title="Groups To Suggest"><span class="name_20">Groups To Suggest</span></a></li><li class="links"><a class="ajax_nav" id="remove_user" href="admin.php?hl=remove_user" title="Disable a user account"><span class="name_20">Disable User Account</span></a></li><li class="links"><a class="ajax_nav" href="admin.php?hl=analytics" title="Analytics"><span class="name_20">Analytics</span></a></li><li class="links"><a class="ajax_nav" id="feature" href="admin.php?hl=feature" title="Feature setting"><span class="name_20">Control features</span></a></li></ul><div name="page" style="margin-top:1em;"><span style="font-weight:bold;font-size:1em;color:gray">Pages</span><ul id="page" class="nav nav-pills nav-stacked"></ul></div><div style="margin-top:1em;padding-top:.5em;border-top:.1em solid #cccccc;"><a href="#" target="_blank"><small>&copy; Quipmate</small></a><span class="separator">|</span><a href="public/help.php" target="_blank"><small>Help</small></a><span class="separator">|</span><a href="public/terms.php" target="_blank"><small>Terms of Use</small></a></div>');
      //Removed code  <li class="links"><a class="ajax_nav" id="flashboard" href="admin.php?hl=flashboard" title="Flashboard"><span class="name_20">Flashboard</span></a></li>
         $('#right').html('');
         //append pages on left side .
         url = 'ajax/write.php';
         param.action = 'broadcast_pages_select';
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $.each(data.info, function(index, value)
            {
               $('#page').append('<li class="links"><a class="ajax_nav" href="page.php?id=' + value.pageid + '" title="Pages"><span class="name_20 ellipsis">' + value.pagename + '</span></a></li>');
            });
            $('#page').append('<li ><a href="#" onclick="ui.page_create(this)" title="Create a page to broadcast news to all the employees"><span class="name_20">Create Page</span></a></li>')
         }));
         //action.broadcast_pages_select(this);
         page = 'admin_json';
         url = 'ajax/write.php';
         param.action = 'admin_feed';
         param.start = 0;
         window.increment = 10;
         $('#center').html('');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'invite')
      {
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'admin.php?hl=invite');
            }
            else
            {
               window.location.hash = 'admin.php?hl=invite';
            }
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#center').html('<h1 class="page_title">Invite Employees</h1><div style="margin:3em;"><textarea placeholder="Paste a list of email address separated by comma" id="employee_invite_box" style="border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em;"></textarea><input type="submit" onclick="action.employee_invite(this)" value="Invite" id="employee_invite_button" class="theme_button" title="Invite Employees" /></div><h1 class="page_title">Attach CSV file in outlook\'s csv format.</h1><form id="csvform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea style="border:1px solid #cccccc;height:2.7em;padding:0.5em;margin:0.5em;width:34.6em;margin-left:3em;" type="text" placeholder="Say something about this file" maxlength="200" id="photo_description" name="photo_description"></textarea><input type="file" id="html_btn" size="40" style="margin-top:20px; margin-left:95px;" name="photo_box"/></br><input type="submit" name="upload" class="theme_button" id="csv_upload_button" value="Upload" style="margin-left:3em;"><input type="hidden" name="action" value="employee_invite_file_upload"></form><div id="upload_progress"></div>');
      }
      else if (page == 'usefullinks')
      {
         if (window.history)
         {
            window.history.pushState('https://www.quipmate.com/', 'HTML5', 'admin.php?hl=usefullinks');
         }
         else
         {
            window.location.hash = 'admin.php?hl=usefullinks';
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#center').html('<h1 class="page_title">Post Useful Links</h1><div style="margin:3em;border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em; overflow-y:scroll; overflow-x:hidden;" id="usefullinks_box"></div><textarea id="link_box" placeholder="Paste/type a link here ?"/></textarea><input id="ullink_button" type="submit" class="theme_button" value="Share"></div>');
         action.usefullinks_fetch();
      }
      else if (page == 'team')
      {
         if (window.history)
         {
            window.history.pushState('https://www.quipmate.com/', 'HTML5', 'admin.php?hl=team');
         }
         else
         {
            window.location.hash = 'admin.php?hl=team';
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#center').html('<h1 class="page_title">Teams</h1><div style="margin:3em;border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em; overflow-y:scroll; overflow-x:hidden;" id="team_show_box"></div><input type="text" class="form-control" placeholder="Add a team" style="margin-left:2.80em;width:50%;display:inline" id="team_box"/> 	<input type="submit" onclick="action.team(this)" value="Add" id="team_button" title="Add" />');
         action.team_fetch();
      }
      else if (page == 'sotw')
      {
         if (window.history)
         {
            window.history.pushState('https://www.quipmate.com/', 'HTML5', 'admin.php?hl=sotw');
         }
         else
         {
            window.location.hash = 'admin.php?hl=sotw';
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#center').html('<h1 class="page_title">Star Of The Week</h1><input type="text" id="hso" autocomplete="off" style="width:20em; margin-left:20px; margin-top:20px;" class="form-control" placeholder="Who is the star of the week"> <div id="star_container" width="200px" style="margin-left:20px;" ></div><div id="sotw2" style="width:30em; margin-left:20px;"></div>	');
         action.sotw_load();
      }
      else if (page == 'group_byadmin')
      {
         if (window.history)
         {
            window.history.pushState('https://www.quipmate.com/', 'HTML5', 'admin.php?hl=group_byadmin');
         }
         else
         {
            window.location.hash = 'admin.php?hl=group_byadmin';
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#center').html('<h1 class="page_title">Groups To Suggest</h1>');
         action.groups_fetch();
      }
      else if (page == 'flashboard')
      {
         if (window.history)
         {
            window.history.pushState('https://www.quipmate.com/', 'HTML5', 'admin.php?hl=flashboard');
         }
         else
         {
            window.location.hash = 'admin.php?hl=flashboard';
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#center').html('<h1 class="page_title">Flashboard</h1><form id="flashform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea style="border:1px solid #cccccc;height:2.7em;padding:0.5em;margin:0.5em;" type="text" placeholder="Paste a link here" maxlength="200" id="photo_description" name="photo_description"></textarea><div id="vish_Btn" style="position: relative;top: 10px;font-family: calibri;width: 180px;height:100px;padding-top:35px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border: 1px dashed #BBB; text-align: center;background-color:#DDD;cursor:pointer;margin-left:20px;">Upload Photo</div><input type="file" id="html_btn" size="40" style="margin-top:-20px; margin-left:95px; display:none;" name="photo_box"/></br><input type="submit" name="upload" id="flash_upload_button" value="Upload" style="margin-left:20px;"><img src="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/upload.gif" class="imghide"  id="uploading"/><input type="hidden" name="action" value="flash_board"></form><output id="list"></output>');
         $('#flash_upload_button').click(function()
         {
            var obj = document.getElementById('uploading');
            obj.className = 'imgshow';
         });

         function handleFileSelect(evt)
         {
            var files = evt.target.files;
            for (var i = 0, f; f = files[i]; i++)
            {
               if (!f.type.match('image.*'))
               {
                  continue;
               }
               var reader = new FileReader();
               reader.onload = (function(theFile)
               {
                  return function(e)
                  {
                     var span = document.createElement('span');
                     span.innerHTML = ['<img class="thumb" src="', e.target.result, '" title="', escape(theFile.name), '" width="80px" height="80px"/>'].join('');
                     document.getElementById('list').insertBefore(span, null);
                  };
               })(f);
               reader.readAsDataURL(f);
            }
         }
         document.getElementById('html_btn').addEventListener('change', handleFileSelect, false);
      }
      else if (page == 'designation')
      {
         if (window.history)
         {
            window.history.pushState('https://www.quipmate.com/', 'HTML5', 'admin.php?hl=designation');
         }
         else
         {
            window.location.hash = 'admin.php?hl=designation';
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#center').html('<h1 class="page_title">Designations</h1><div style="margin:3em;border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em; overflow-y:scroll; overflow-x:hidden;" id="designation_show_box"></div><input type="text" class="form-control" placeholder="Add a designation" style="margin-left:2.80em;width:50%;display:inline" id="designation_box"/> 	<input type="submit" onclick="action.designation(this)" value="Add" id="designation_button" class="theme_button" title="Add" /></div>	');
         
 // Removed code 
 //<h1 class="page_title">Managing Director</h1><input type="text" id="mdadd" autocomplete="off" style="width:20em; margin-left:2.80em; margin-top:20px;" class="form-control" placeholder="Who is the managing director"> <div id="md_container" width="200px" style="margin-left:20px;" ></div><div id="md_co" style="width:30em; margin-left:20px;"><input type="submit" class="theme_button" style="margin-top:-34px;" onclick="action.addmd(this)" value="Add MD" id="add_md_button" title="Add MD" />        
         action.designation_fetch();
      }
      else if (page == 'admin_list')
      {
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'admin.php?hl=admin');
            }
            else
            {
               window.location.hash = 'admin.php?hl=admin';
            }
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#center').html('<div class=""><h1 class="page_title">Manage Admins</h1><div style="padding:4em;"><input id="remove_user_email" type="text" placeholder="Enter the email address" value="" style="padding:0.5em;width: 22em;" /><input id="invite_button" class="theme_button" type="submit" onclick="action.user_details(this)" value="Add Admin" data="Add Admin" title="Add as admin" style="width: 7.6em;" /></div></div><div id="fetch_user_details" style="padding:1.5em;"></div><h1 class="page_title">Existing Admins</h1>');
         url = 'ajax/write.php';
         param.action = 'moderator_fetch';
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $.each(data.action, function(index, value)
            {
               $('#center').append('<div style="height:8em;clear:both;padding:1.5em;"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + value.profileid + '"><img class="lfloat" height="80" width="80" src="' + value.image + '" /></a><div class="name_80"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + value.profileid + '">' + value.name + '</a><div style="float:right;"><input id="invite_button" class="theme_button" type="submit" onclick="action.moderator_remove(this,'+value.profileid+')" value="Remove Admin" title="Remove Admin" style=" width:9.3em;margin-top:3em;" /></div></div></div>');
            });
         }));
      }
      else if (page == 'remove_user')
      {
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'admin.php?hl=remove_user');
            }
            else
            {
               window.location.hash = 'admin.php?hl=remove_user';
            }
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         //url = 'ajax/write.php';
         $('#center').html('<div class=""><h1 class="page_title">Disable the account of an user </h1><div style="padding:5em;"><input id="remove_user_email" type="text" placeholder="Enter the email address" value="" style="padding:0.5em;width: 22em;" /><input class="theme_button" type="submit" onclick="action.user_details(this)" value="Disable User" data="Disable User" title="Disable User" /></div><div id="fetch_user_details" style="padding:1.5em;"></div></div>');
      }
      else if (page == 'analytics')
      {
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'admin.php?hl=analytics');
            }
            else
            {
               window.location.hash = 'admin.php?hl=analytics';
            }
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         $('#center').html('<div id="center" class="col-md-6 center"><div class=""><h1 class="page_title">Analytics</h1><div id="analytics"><p >Start Date: <input type="text" name="startdate" id="startdate">   End Date: <input type="text" name="enddate" id="enddate"></p><p>Select Value:<select id="typedata" ><option value="post" selected="selected">Post</option><option value="joined" >Joined</option>option value="comment">Comment</option><option value="visit">Visit</option><option value="view">View</option></select></p><span id="errors" style="display:none; color:#0000">Enter the range</span><input type="button" value="OK" id= "button" onclick="action.getanalyticdetails(this,document.getElementById(' + startdate + ').value,document.getElementById(' + enddate + ').value,document.getElementById(' + typedata + ').value)"><span id="rangeError" style="display:none; color:#0C0">Range should be less than 15 days </span><p id="chart"> </p></div>');
      }
      else if (page == 'feature')
      {
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'admin.php?hl=feature');
            }
            else
            {
               window.location.hash = 'admin.php?hl=feature';
            }
         }
         $(document).attr('title', 'Quipmate - Admin Interface');
         url = 'ajax/write.php';
         param.action = 'setting_feature_select';
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $('#center').html('<h1 class="profile_edit_title" id="basic">Set feature On/Off</h1><div class="setting_each"><span class="setting_category_name">Mood Sharing</span><input type="checkbox" onchange="action.feature_setting_update(this)" class="privacy_drop" data="mood" ' + data.info.mood + '></div><div class="setting_each bgcolor"><span class="setting_category_name">Birthday wish</span><input type="checkbox" onchange="action.feature_setting_update(this)" class="privacy_drop" data="birthday" ' + data.info.birthday + '></div><div class="setting_each"><span class="setting_category_name">Invite a colleague</span><input type="checkbox" onchange="action.feature_setting_update(this)" class="privacy_drop" data="invite_friend" ' + data.info.invite_friend + '></div></div>');
         }));
      }
      else if (page == 'page_json')
      {
         $('#page_pageid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'page.php?id=' + profileid + "&hl=post");
            }
            else
            {
               window.location.hash = 'page.php?id=' + profileid + "&hl=post";
            }
         }
         url = 'ajax/write.php';
         param.action = 'page_details_fetch';
         param.pageid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $('#left').html('<a class="ajax_nav" href="page.php?id=' + profileid + '"><img class="img-thumbnail" src="' + icon_cdn + '/broadcast.png" /></a><div class="text-center""><a class="ajax_nav" href="page.php?id=' + profileid + '" class="ellipsis">' + data.info.pagename + '</a></div><ul class="nav nav-pills nav-stacked"><li class="links"><a class="ajax_nav" id="page_json" href="page.php?hl=post&id=' + profileid + '" title="News broadcasts"><span class="name_20">Page Feed</span></a></li><li class="links"><a  class="ajax_nav" id="about" href="page.php?hl=about&id=' + profileid + '" title="About page"><span class="name_20">About</span></a></li></ul>');
            $('#right').html('<div class="right_item" id="group_description"><div class="subtitle">Page Description</div><div>' + data.info.page_description + '</div></div>');
            $(document).attr('title', data.info.pagename);
         }));
         url = 'ajax/write.php';
         param.action = 'page_feed';
         param.pageid = profileid;
         window.increment = 10;
         $('#news_json').addClass('selected');
         $('#center').html('<div id="news_poll"></div>');
         $('#center').prepend('<div id="sharing_area"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#sharing_area').load('/ajax/write.php?action=actions_load&page=page_json');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'page_about')
      {
         $('#page_pageid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'page.php?id=' + profileid + "&hl=about");
            }
            else
            {
               window.location.hash = 'page.php?id=' + profileid + "&hl=about";
            }
         }
         url = 'ajax/write.php';
         param.action = 'page_details_fetch';
         param.pageid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $('#center').html('<div style="padding:1em;font-size:1.6em;font-weight:bold">' + data.info.pagename + '</div><div style="padding:1em;font-size:1.4em;">' + data.info.page_description + '</div>');
            $(document).attr('title', data.info.pagename);
         }));
         $('#news_json').addClass('selected');
      }
      else if (page == 'group_json')
      {
         $('#profileid_hidden').attr('value', profileid);
         $('#right').html(''); //Because all other components on right side get appended by ajax calls .. So later you can not not decide for which to put .html() and for which to put append . So better put here and rest everywhere put append.
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'group.php?id=' + profileid + "&hl=post");
            }
            else
            {
               window.location.hash = 'group.php?id=' + profileid + "&hl=post";
            }
         }
         url = 'ajax/write.php';
         param.action = 'group_details_fetch';
         param.groupid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $(document).attr('title', data.info.groupname);
            $('#profilename_hidden').attr('value', data.info.groupname);
            $('#left').html('<a class="ajax_nav" href="group.php?id=' + data.info.groupid + '"><img class="img-thumbnail"  src="' + data.info.group_photo + '" /></a><div class="text-center"><a  class="ajax_nav" href="group.php?id=' + data.info.groupid + '" class="ellipsis">' + data.info.groupname + '</a></div><ul class=" nav nav-pills nav-stacked"> <li class="links"><a class="ajax_nav" id="group_json" href="group.php?id=' + data.info.groupid + '" title="Your activities"><span class="name_20">Group Feed</span></a></li><li class="links"><a class="ajax_nav" href="group.php?id=' + data.info.groupid + '&hl=about" title="Your Bio"><span class="name_20">About</span></a></li><li class="links"><a class="ajax_nav" href="group.php?id=' + data.info.groupid + '&hl=member" title="Group Members"><span class="name_20">Members(' + data.info.member_count + ')</span></a></li></ul>');
            if (data.info.priviledge == 0)
            {
               $('#left').children().eq(1).after('<div style="margin-top:0.5em;text-align:center;"><a style="color:#003399;" class="ajax_nav" href="group.php?id=' + data.info.groupid + '&hl=settings">Edit Group Settings</a></div>');
            }
            else if (data.info.priviledge == 1)
            {
               $('#left').append('<div style="margin-top:2em;text-align:center;"><a style="color:#003399;" href="#" class="ellipsis" onclick="ui.group_leave(this)">Leave Group ' + data.info.groupname + '</a></div>');
            }
            if (data.info.priviledge == 0 || data.info.priviledge == 1)
            {
               $('#right').prepend('<div style="clear:both;margin:1em 0em;">You are member of ' + data.info.groupname + '</div>');
               if (data.info.invite == 0 || data.info.priviledge == 1)
               {
                  $('#right').append('<div id="friend_match" style="margin-top:1em;" class="panel panel-default"></div><div id="member_request" class="panel panel-default"></div><div class="panel-body" id="group_invite_info" style="margin:0em 0em 0.8em 0em;"></div><input type="text" id="invite_box" value="" onkeyup="ui.group_friend_invite(this)" placeholder="Add a colleague to this group" /><div style="position:relative;" id="group_friend_invite"></div>');
               }
               $('#right').append('<div class="panel panel-default" id="group_description"><div class="panel-heading">Group Description</div><div class="panel-body">' + data.info.description + '</div></div>');
               if (data.info.link)
               {
                  $('#right').append('<div class="panel panel-default" id="group_link"><div class="panel-heading">Relevant Links</div><div class="panel-body">' + data.info.link + '</div></div>');
               }
            }
            else if (data.info.priviledge == 2)
            {
               $('#right').prepend('<div style="clear:both;margin:1em 0em;">Join request sent to ' + data.info.groupname + '</div>');
            }
            else if (data.info.priviledge == 3)
            {
               $('#right').prepend('<div style="clear:both;margin:1em 0em;">You are not member of ' + data.info.groupname + '</div><span id="add_container" class="profile_actions_container"><input class="profile_actions_button theme_button" id="' + data.info.groupid + '" style="width:8em;" type="submit" onclick="action.group_join(this) ; this.onclick=null;" value="+Join Group" id="' + data.info.groupid + '"/></span>');
            }
            if (data.info.priviledge == 2 || data.info.priviledge == 3)
            {
               page = 'group_about';
               if (window.history)
               {
                  var st =
                  {
                     url: state.url,
                     page: page,
                     param: param,
                     me: "object"
                  };
                  window.history.pushState(st, 'HTML5', 'group.php?id=' + profileid + "&hl=about");
               }
               else
               {
                  window.location.hash = 'group.php?id=' + profileid + "&hl=about";
               }
               $('#center').html('<div style="padding:1em;font-size:1.6em;font-weight:bold">' + data.info.groupname + '</div><div style="padding:1em;font-size:1.4em;">' + data.info.description + '</div><div style="padding:1em;font-size:1.3em;"><a  class="ajax_nav" style="font-size:1em;" href="profile.php?id=' + data.info.createdby + '">' + data.name[data.info.createdby] + '</a> created this group</div>');
            }
            else
            {
               page = 'group_json';
               url = 'ajax/write.php';
               param.start = 0;
               param.action = 'group_feed';
               param.groupid = profileid;
               window.increment = 10;
               action.first_loader(page, param);
               action.group_top_influencer(this);
               var groupid = profileid;
               action.document_fetch(this, groupid);
               action.member_request_fetch(this);
               $('#sharing_area').load('/ajax/write.php?action=actions_load&page=group_json&groupid=' + profileid + '');
            }
         }));
         myprofileid = $('#myprofileid_hidden').attr('value');
         myphoto = $('#myprofileimage_hidden').attr('value');
         myname = $('#myprofilename_hidden').attr('value');
         action.group_suggest(this, 6);
         $('#news_json').addClass('selected');
         $('#center').html('<div id="news_poll"></div>');
         $('#center').prepend('<div id="sharing_area"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'group_about')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'group.php?id=' + profileid + "&hl=group_about");
            }
            else
            {
               window.location.hash = 'group.php?id=' + profileid + "&hl=group_about";
            }
         }
         url = 'ajax/write.php';
         param.action = 'group_details_fetch';
         param.groupid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $(document).attr('title', data.info.groupname);
            $('#center').html('<div style="padding:1em;font-size:1.6em;font-weight:bold">' + data.info.groupname + '</div><div style="padding:1em;font-size:1.4em;">' + data.info.description + '</div><div style="padding:1em;font-size:1.3em;"><a  class="ajax_nav" style="font-size:1em;" href="profile.php?id=' + data.info.createdby + '">' + data.name[data.info.createdby] + '</a> created this group</div>');
         }));
         //action.group_suggest("object",6);
         $('#news_json').addClass('selected');
      }
      else if (page == 'group_file')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'group.php?id=' + profileid + "&hl=file");
            }
            else
            {
               window.location.hash = 'group.php?id=' + profileid + "&hl=file";
            }
         }
         url = 'ajax/write.php';
         param.action = 'group_doc_fetch';
         param.groupid = profileid;
         window.increment = 20;
         $('.file_table_body').html('');
      /*   window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $('.file_center_title').html(''+data.groupname+' - File');
            $('.file_table_body').html('');
           deploy.file_deploy(data);
         })); */
         //action.group_suggest("object",6);
         $('#news_json').addClass('selected');
      }
      else if (page == 'group_video')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'group.php?id=' + profileid + "&hl=video");
            }
            else
            {
               window.location.hash = 'group.php?id=' + profileid + "&hl=video";
            }
         }
         url = 'ajax/write.php';
         param.action = 'group_video_fetch';
         param.groupid = profileid;
         window.increment = 20;
         $('.video_table_body').html('');
      /*   window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $('.file_center_title').html(''+data.groupname+' - File');
            $('.file_table_body').html('');
           deploy.file_deploy(data);
         })); */
         //action.group_suggest("object",6);
         $('#news_json').addClass('selected');
      }
      else if (page == 'group_settings')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'group.php?id=' + profileid + "&hl=group_settings");
            }
            else
            {
               window.location.hash = 'group.php?id=' + profileid + "&hl=group_settings";
            }
         }
         url = 'ajax/write.php';
         param.action = 'group_details_fetch';
         param.groupid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $(document).attr('title', data.info.groupname);
            $('#center').html('<div class="text-center"><h1 class="page_title">Group Settings</h1><div id="group_info"></div><div><span style="margin:1em 0em;padding:0.5em;">Group Name :</span><span style="margin:1em 0em;padding:0.5em;">' + data.info.groupname + '</span></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="group_description" placeholder="What is this group about ?">' + data.info.description + '</textarea></div><div><div style="margin:1em 0em;">Privacy: <select id="group_privacy"><option value="0">Public</option><option value="1">Private</option></select></div><div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="group_link" placeholder="Relevant links">' + data.info.link + '</textarea></div>');
            if (data.info.technical == 1)
            {
               $('#center').append('<div style="margin:1em 0em">This group is for technical discussions</div></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="group_link" placeholder="Relevant links">' + data.info.link + '</textarea></div>');
            }
            if (data.info.invite == 1)
            {
               $('#center').append('<div class="text-center"><input type="checkbox" id="group_invite" checked> Only group admin can add or approve membership requests</div>');
            }
            else
            {
               $('#center').append('<div class="text-center"><input type="checkbox" id="group_invite"> Only group admin can add or approve membership requests</div>');
            }
            $('#center').append('<div class="group_create_button text-center"><input style="margin:0em 1em" type="submit" onclick="action.group_settings_save(this)" value="Save" class="group_create_positive theme_button"></div><h1 class="page_title">Attach Document</h1><form id="flashform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea style="border:1px solid #cccccc;height:2.7em;padding:0.5em;margin:0.5em;width:34.6em;margin-left:3em;" type="text" placeholder="Say something about this file" maxlength="200" id="photo_description" name="doc_description"></textarea><div id="vish_Btn" style="position: relative;top: 10px;font-family: calibri;width: 180px;height:100px;padding-top:35px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border: 1px dashed #BBB; text-align: center;background-color:#DDD;cursor:pointer; margin-left:18em;">Upload Document</div><input type="file" id="html_btn" size="40" style="margin-top:-20px; margin-left:95px; display:none;" name="doc"/></br><input type="submit" name="upload" class="imgshow"  id="flash_upload_button" value="Upload" style="margin-left:18em;"><img src="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/upload.gif" class="imghide"  id="uploading"/><input type="hidden" name="action" value="group_pinned_doc_upload"><input type="hidden" name="doc_hidden_profileid" value="' + profileid + '"></form>');
         }));
         var groupid = profileid;
         action.doc_load(this, groupid);
         //	action.group_suggest("object",6);
         $('#news_json').addClass('selected');
      }
      else if (page == 'group_member')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'group.php?id=' + profileid + "&hl=member");
            }
            else
            {
               window.location.hash = 'group.php?id=' + profileid + "&hl=member";
            }
         }
         url = 'ajax/write.php';
         param.action = 'member_load';
         param.groupid = profileid;
         window.increment = 50;
         var profile_name = $('#profilename_hidden').attr('value');
         $(document).attr('title', profile_name);
         $('#center').html('');
         $('#center').append('<div id="prev"></div>');
         $('#prev').append('<h1 class="page_title">Group Members</h1>');
      }
      else if (page == 'event_json')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'event.php?id=' + profileid + "&hl=diary");
            }
            else
            {
               window.location.hash = 'event.php?id=' + profileid + "&hl=diary";
            }
         }
         url = 'ajax/write.php';
         param.action = 'event_details_fetch';
         param.eventid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $(document).attr('title', data.info.eventname);
            $('#left').html('<a class="ajax_nav" href="event.php?id=' + data.info.eventid + '"><img class="img-thumbnail" src="' + data.info.event_photo + '" /></a><div class="text-center"><a  class="ajax_nav" href="event.php?id=' + data.info.eventid + '" class="ellipsis">' + data.info.eventname + '</a></div></div><ul class=" nav nav-pills nav-stacked"><li class="links"><a class="ajax_nav" href="event.php?id=' + data.info.eventid + '" title="Event posts"><span class="name_20">Event Feed</span></a></li><li class="links"><a  class="ajax_nav" id="about" href="event.php?id=' + data.info.eventid + '&hl=about" title="About the event"><span class="name_20">About</span></a></li><li class="links"><a id="inbox" href="event.php?id=' + data.info.eventid + '&hl=guest" title="Guest expected"><span class="name_20">Guest expected(' + data.info.guest_count + ')</span></a></li></ul>');
            if (data.info.priviledge == 0 && data.info.cancel == 0)
            {
               $('#left').append('<div style="margin-top:2em;text-align:center;"><a style="color:#003399;" href="#" onclick="ui.event_cancel(this)">Cancel Event </a></div>');
            }
            else if (data.info.priviledge == 1)
            {
               $('#left').append('<div style="margin-top:2em;text-align:center;"><a style="color:#003399;" class ="ellipsis" href="#" onclick="ui.event_leave(this)" >Not going to ' + data.info.eventname + '</a></div>');
            }
            if (data.info.priviledge == 0)
            {
               $('#left').children().eq(1).after('<div style="margin-top:0.5em;text-align:center;"><a style="color:#003399;" class="ajax_nav" href="event.php?id=' + data.info.eventid + '&hl=settings">Edit Event Settings</a>');
            }
            $('#right').html('');
            if (data.info.cancel == 1)
            {
               $('#right').html('<div style="clear:both;margin:1em 0em;font-weight:bold;">This event has been cancelled</div>');
            }
            if (data.info.priviledge == 0 || data.info.priviledge == 1)
            {
               $('#right').append('<div style="clear:both;margin:1em 0em;">You are going to ' + data.info.eventname + '</div>');
               if (data.info.cancel == 0 && data.info.groupid == 1)
               {
                  $('#right').append('<div id="group_invite_info" style="margin:0em 0em 0.8em 0em;"></div><input type="text" id="invite_box" value="" onkeyup="ui.event_friend_invite(this)" placeholder="Invite a colleague to this event" /><div style="position:relative;" id="group_friend_invite"></div>');
               }
            }
            else if (data.info.priviledge == 2)
            {
               $('#right').append('<div style="clear:both;margin:1em 0em;">You have been invited to attend ' + data.info.event_name + '</div><div class="subtitle"><div class="friend_request_class"><a class="ajax_nav" href="event.php?id=' + data.info.eventid + '<img class="lfloat" style="margin-right:1em;" src="' + icon_cdn + '/event.png" height="50" width="50"></a><div><a class="bold ajax_nav" href="event.php?id=' + data.info.eventid + '">' + data.info.event_name + '</a><div><input type="submit" class="frequest" data="' + data.info.eventid + '" id="1" value="Going" onclick="action.guest_accept(this, 1)" /><input type="submit" class="frequest theme_button" data="' + data.info.eventid + ' style="margin-left:0.5em;" id="0" value="Decline" onclick="action.guest_accept(this, 0)" /></div></div></div></div>');
            }
            else if (data.info.priviledge == 3)
            {
               $('#right').append('<div style="clear:both;margin:1em 0em;">You have declined to ' + data.info.event_name + '</div><span id="add_container" class="profile_actions_container"><input class="profile_actions_button theme_button" id="' + data.info.eventid + '" style="width:9.5em;" type="submit" onclick="action.event_join(this)" value="+Attend Event" id="' + data.info.eventid + '"/></span>');
            }
            else if (data.info.priviledge == 4)
            {
               $('#right').append('<div style="clear:both;margin:1em 0em;">You are not going to ' + data.info.event_name + '</div><span id="add_container" class="profile_actions_container"><input class="profile_actions_button" id="' + data.info.eventid + '" style="width:9.5em;" type="submit" onclick="action.event_join(this)" value="+Attend Event" id="' + data.info.eventid + '"/></span>');
            }
            $('#right').append('<div class="panel panel-default" id="group_link"><div class="panel-heading">Event Details</div><div class="panel-body"><div>Date: ' + data.info.date + '</div><div>Time: ' + data.info.timing + '</div><div>Venue: ' + data.info.venue + '</div></div></div><div class="panel panel-default" id="group_description"><div class="panel-heading">Event Description</div><div class="panel-body">' + data.info.description + '</div></div>');
            if (data.info.priviledge == 0 || data.info.priviledge == 1)
            {
               page = 'event_json';
               url = 'ajax/write.php';
               param.action = 'event_feed';
               param.eventid = profileid;
               window.increment = 10;
               $('#sharing_area').load('/ajax/write.php?action=actions_load&page=event_json');
               action.first_loader(page, param);
            }
            else
            {
               if (!state.pop)
               {
                  if (window.history)
                  {
                     var st =
                     {
                        url: state.url,
                        page: page,
                        param: param,
                        me: "object"
                     };
                     window.history.pushState(st, 'HTML5', 'event.php?hl=id=' + profileid + "&hl=about");
                  }
                  else
                  {
                     window.location.hash = 'event.php?id=' + profileid + "&hl=about";
                  }
               }
               $(document).attr('title', data.info.eventname);
               $('#center').html('<div id="center" ><div style="padding:1em;font-size:1.6em;font-weight:bold">' + data.info.eventname + '</div><div style="padding:1em;font-size:1.3em;">' + data.info.description + '</div><div style="padding:1em;font-size:1.3em;">On ' + data.info.date + ' at ' + data.info.time + '</div><div style="padding:1em;font-size:1.3em;">At ' + data.info.venue + '</div><div style="padding:1em;font-size:1.3em;">' + data.info.guest_count + ' guests</div><div style="padding:1em;font-size:1.3em;"><a style="font-size:1em;" class="ajax_nav" href="profile.php?id=' + data.host + '"> ' + data.name[data.host] + '</a> is the host</div></div>');
            }
         }));
         myprofileid = $('#myprofileid_hidden').attr('value');
         myphoto = $('#myprofileimage_hidden').attr('value');
         myname = $('#myprofilename_hidden').attr('value');
         action.event_suggest("object", 6);
         $('#news_json').addClass('selected');
         $('#center').html('<div id="news_poll"></div>');
         $('#center').prepend('<div id="sharing_area"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'event_about')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'event.php?id=' + profileid + "&hl=about");
            }
            else
            {
               window.location.hash = 'event.php?id=' + profileid + "&hl=about";
            }
         }
         url = 'ajax/write.php';
         param.action = 'event_details_fetch';
         param.eventid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $(document).attr('title', data.info.eventname);
            $('#center').html('<div id="center" ><div style="padding:1em;font-size:1.6em;font-weight:bold">' + data.info.eventname + '</div><div style="padding:1em;font-size:1.3em;">' + data.info.description + '</div><div style="padding:1em;font-size:1.3em;">On ' + data.info.date + ' at ' + data.info.time + '</div><div style="padding:1em;font-size:1.3em;">At ' + data.info.venue + '</div><div style="padding:1em;font-size:1.3em;">' + data.info.guest_count + ' guests</div><div style="padding:1em;font-size:1.3em;"><a style="font-size:1em;" class="ajax_nav" href="profile.php?id=' + data.host + '"> ' + data.name[data.host] + '</a> is the host</div></div>');
         }));
         param.eventid = $('#profileid_hidden').attr('value');
         myprofileid = $('#myprofileid_hidden').attr('value');
         myphoto = $('#myprofileimage_hidden').attr('value');
         myname = $('#myprofilename_hidden').attr('value');
         action.event_suggest("object", 6);
         $('#news_json').addClass('selected');
      }
       else if (page == 'event_file')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'event.php?id=' + profileid + "&hl=file");
            }
            else
            {
               window.location.hash = 'event.php?id=' + profileid + "&hl=file";
            }
         }
         url = 'ajax/write.php';
         param.action = 'event_doc_fetch';
         param.eventid = profileid;
         window.increment = 20;
         $('.video_table_body').html('');
      /*   window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $('.file_center_title').html(''+data.groupname+' - File');
            $('.file_table_body').html('');
           deploy.file_deploy(data);
         })); */
         //action.group_suggest("object",6);
         $('#news_json').addClass('selected');
      }
        else if (page == 'event_video')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'event.php?id=' + profileid + "&hl=video");
            }
            else
            {
               window.location.hash = 'event.php?id=' + profileid + "&hl=video";
            }
         }
         url = 'ajax/write.php';
         param.action = 'event_video_fetch';
         param.eventid = profileid;
         window.increment = 20;
         $('.file_table_body').html('');
      /*   window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $('.file_center_title').html(''+data.groupname+' - File');
            $('.file_table_body').html('');
           deploy.file_deploy(data);
         })); */
         //action.group_suggest("object",6);
         $('#news_json').addClass('selected');
      }
      else if (page == 'event_setting')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'event.php?id=' + profileid + "&hl=settings");
            }
            else
            {
               window.location.hash = 'event.php?id=' + profileid + "&hl=settings";
            }
         }
         url = 'ajax/write.php';
         param.action = 'event_details_fetch';
         param.eventid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $(document).attr('title', data.info.eventname);
            $('#center').html('<div class="text-center"><h1 class="page_title">Event Settings</h1><div id="group_info"></div><div><span style="margin:1em 0em;padding:0.5em;">Event Name :</span><span style="margin:1em 0em;padding:0.5em;">' + data.info.eventname + '</span></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="group_description" placeholder="What is this group about ?">' + data.info.description + '</textarea></div><div><div style="margin:1em 0em;">Privacy: <select id="group_privacy"><option value="0">Public</option><option value="1">Private</option></select></div></div><div style="margin:1em 0em;">When : <select id="event_day" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Day</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option> <option value="11">11</option><option value="12">12</option><option value="01">13</option><option value="02">14</option><option value="03">15</option><option value="04">16</option><option value="05">17</option><option value="06">18</option><option value="07">19</option><option value="08">20</option><option value="09">21</option> <option value="10">22</option><option value="11">23</option><option value="12">24</option><option value="01">25</option><option value="02">26</option> <option value="03">27</option><option value="04">28</option> <option value="05">29</option><option value="04">30</option><option value="05">31</option></select><select id="event_month" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Month</option> <option value="01">JAN</option><option value="02">FEB</option><option value="03">MAR</option><option value="04">APR</option><option value="05">MAY</option><option value="06">JUN</option> <option value="07">JUL</option><option value="08">AUG</option> <option value="09">SEP</option><option value="10">OCT</option><option value="11">NOV</option> <option value="12">DEC</option></select><select id="event_year" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Year</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select><select id="event_time" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Time</option><option value="09:00:00">09:00 am</option><option value="09:30:00">09:30 am</option><option value="1000">10:00 am</option><option value="10:30:00">10:30 am</option><option value="11:30:00">11:30 am</option><option value="12:00:00">12:00 pm</option><option value="12:30:00">12:30 pm</option><option value="13:00:00">01:00 pm</option><option value="13:30:00">01:30 pm</option><option value="14:00:00">02:00 pm</option><option value="14:30:00">02:30 pm</option><option value="15:00:00">03:00 pm</option><option value="15:30:00">03:30 pm</option><option value="16:00:00">04:00 pm</option><option value="16:30:00">04:30 pm</option><option value="17:00:00">05:00 pm</option><option value="17:30:00">05:30 pm</option><option value="18:00:00">06:00 pm</option><option value="18:30:00">06:30 pm</option><option value="19:00:00">07:00 pm</option><option value="19:30:00">07:30 pm</option><option value="20:00:00">08:00 pm</option><option value="20:30:00">08:30 pm</option><option value="21:00:00">09:00 pm</option><option value="21:30:00">09:30 pm</option><option value="22:00:00">10:00 pm</option><option value="22:30:00">10:30 pm</option><option value="23:00:00">11:00 pm</option><option value="23:30:00">11:30 pm</option><option value="00:00:00">12:00 am</option><option value="00:30:00">12:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="04:00:00">04:00 am</option><option value="04:30:00">04:30 am</option><option value="05:00:00">05:00 am</option><option value="05:30:00">05:30 am</option><option value="06:00:00">06:00 am</option><option value="06:30:00">06:30 am</option><option value="07:00:00">07:00 am</option><option value="07:30:00">07:30 am</option><option value="08:00:00">08:00 am</option><option value="08:30:00">08:30 am</option></select></div><div style="margin:1em 0em;">Where: <input type="text" id="event_where" value="' + data.info.venue + '" placeholder="Venue of this event" style="padding:0.5em;width:22em"/></div></div>');
            if (data.info.invite == 1)
            {
               $('#center').append('<div class="text-center"><input type="checkbox" id="group_invite" checked> Guests can invite their followers</div>');
            }
            else
            {
               $('#center').append('<div class="text-center"><input type="checkbox" id="group_invite"> Guests can invite their followers</div>');
            }
            $('#center').append('<div class="group_create_button text-center"><input style="margin:0em 1em" type="submit" onclick="action.event_settings_save(this)" class="theme_button" value="Save" class="group_create_positive"></div>');
         }));
         page = 'event_json';
         url = 'ajax/write.php';
         param.action = 'event_feed';
         param.eventid = $('#profileid_hidden').attr('value');
         window.increment = 10;
         myprofileid = $('#myprofileid_hidden').attr('value');
         myphoto = $('#myprofileimage_hidden').attr('value');
         myname = $('#myprofilename_hidden').attr('value');
         action.event_suggest("object", 6);
         $('#news_json').addClass('selected');
         $('#center').html('<div id="news_poll"></div>');
         $('#center').prepend('<div id="sharing_area"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#sharing_area').load('/ajax/write.php?action=actions_load&page=event_json');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'guest')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'event.php?id=' + profileid + "&hl=guest");
            }
            else
            {
               window.location.hash = 'event.php?id=' + profileid + "&hl=guest";
            }
         }
         url = 'ajax/write.php';
         param.action = 'guest_load';
         param.eventid = profileid;
         window.increment = 25;
         var profile_name = $('#profilename_hidden').attr('value');
         $(document).attr('title', profile_name + ' - guest');
         $('#center').html('');
         $('#center').append('<div id="prev"></div>');
      }
      else if (page == 'profile')
      {
         $('#profileid_hidden').attr('value', profileid);
         var myprofileid = $('#myprofileid_hidden').attr('value');
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'profile.php?id=' + profileid);
            }
            else
            {
               window.location.hash = 'profile.php?' + profileid;
            }
         }
         $('.row').html('');
         $('.row').append('<div class="col-md-2 left" id="left"></div><div id="center" class="col-md-6 center"></div><div id="right" class="col-md-3 right"></div>');
         url = 'ajax/write.php';
         param.action = 'profile_details_fetch';
         param.profileid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            profile_name = data.info.name;
            $('#profilename_hidden').attr('value', data.info.name);
            $('#profile_relation_hidden').attr('value', data.info.profile_relation);
            $('#profilename_hidden').attr('value', data.info.name);
            $('#left').html('<ul class=" nav nav-pills nav-stacked"><li class="links"><a class="ajax_nav" id="profile_json" href="profile.php?id=' + profileid + '&hl=diary" title="Your activities"><span class="name_20">Diary</span></a></li><li class="links"><a class="ajax_nav" id="bio" href="profile.php?id=' + profileid + '&hl=bio" title="Your Bio"><span class="name_20">Bio</span></a></li><li class="links"><a class="ajax_nav" id="praise" href="profile.php?id=' + profileid + '&hl=praise" title="Your Praises"><span class="name_20">Praises</span></a></li><li class="links"><a class="ajax_nav" id="pphoto" href="profile.php?id=' + profileid + '&hl=image" title="Your Photos"><span class="name_20">Photos</span></a></li><li class="links"><a  class="ajax_nav" id="following" href="profile.php?id=' + profileid + '&hl=following" title="You are following"><span class="name_20">Following (' + data.info.following_count + ')</span></a></li><li class="links"><a  class="ajax_nav" id="followers" href="profile.php?id=' + profileid + '&hl=followers" title="Your followers"><span class="name_20">Followers (' + data.info.followers_count + ')</span></a></li></ul><div id="friend_event" class="right_item" style="margin:1em 0em 0em 0em;padding:0em;"></div>');
            
//removed from left 
            //<div style="text-align:center;"><input type="hidden" value="' + profileid + '" /><input type="hidden" value="50" /><img onclick="action.image_viewer(this)" id="' + data.info.profile_imageid + '" class="img-thumbnail" data="' + data.info.profile_image + '" src="' + data.info.profile_image + '" /></div><div class="text-center"><a  class="ajax_nav"  href="profile.php?id=' + profileid + '">' + data.info.name + '</a></div>
            
            
            $(document).attr('title', data.info.name);
            if (data.info.friendship_status == 2)
            {
               $('#left').append('<div style="margin-top:2em;text-align:center;"><a style="color:#003399;" href="#" onclick="ui.unfriend(this) " >Unfollow ' + data.info.name + '</a></div>');
            }
            if (data.info.profile_relation != 0 )
            {
               if (data.info.friendship_status == -1)
               {
                  $('#right').html('<div style="clear:both;margin:1em 0em;"> ' + data.info.name + ' is following you .</div><span id="add_container" class="profile_actions_container"><input class="profile_actions_button theme_button" id="' + profileid + '" style="width:7.3em;" onclick="action.friend_accept(this,1); this.click=null;" type="submit" value=" +Follow " id="' + profileid + '" data="follow_back"/></span>');
               }
               else if (data.info.friendship_status == 1)
               {
                  $('#right').html('<div style="clear:both;margin:1em 0em;"> You are following ' + data.info.name + '</div>');
               }
               else if (data.info.friendship_status == 2)
               {
                  $('#right').html('<div style="clear:both;margin:1em 0em;">You and ' + data.info.name + ' are following each other.</div>');
               }
            }
            if (data.info.friendship_status == 0 && data.info.profile_relation != 3)
            {
               $('#right').html('<div style="clear:both;margin:1em 0em;">You are not following ' + data.info.name + '</div><span id="add_container" class="profile_actions_container"><input class="profile_actions_button theme_button" id="' + profileid + '" style="width:7.3em;" onclick="action.add_friend(this,' + profileid + '); this.click=null;" type="submit" value=" +Follow " id="' + profileid + '"/></span>');
            }
            if (profileid == myprofileid)
            {
               $('#left').children().eq(1).after('<div style="margin-top:0.5em;text-align:center;"><a style="color:#003399;" href="register.php?hl=profile_picture">Change Profile Picture</a></div>');
               $('#right').html('<span class="profile_actions_container" ><input class="profile_actions_button theme_button" onclick="ui.mood(this)" style="width:7.3em;" type="submit" value="+Mood" /></span><span class="profile_actions_container" ><input class="profile_actions_button theme_button" onclick="ui.tagline(this)" style="width:8em;" type="submit" value="+Tagline" /></span><div style="clear:both;"></div>');
            }
            else
            {
               $('#right').append('<span class="profile_actions_container" ><input class="profile_actions_button theme_button" onclick="ui.message(this)" style="width:7.3em;" type="submit" value="+Message" /></span><div style="clear:both;"></div>');
               if (data.info.friendship_status == 2)
               {
                  $('#left').append('<div style="margin-top:2em;text-align:center;"><a onclick="ui.unfriend(this)" href="#" style="color:#003399;">Unfollow ' + profile_name + '</a></div>');
                  $('#right').append('<div id="" class="right_item" style="margin-bottom:1em;"><a style="cursor:pointer;" onclick="ui.praise(this,event)">Praise/Recommend</a></div>');
               }
               $('#right').append('<div id="friend_match" class="panel panel-default"></div><div id="friend_non_match" class="panel panel-default"></div>');
            }
            $('#news_json').addClass('selected');
            $('#center').html('<div id="sharing_area"></div><div id="news_poll"></div><div id="prev"></div>');
            $('#sharing_area').load('/ajax/write.php?action=actions_load&profile_relation=' + data.info.profile_relation + '');
         }));
         page = 'profile_json';
         url = 'ajax/write.php';
         param.action = 'profile_feed';
         param.profileid = $('#profileid_hidden').attr('value');
         window.increment = 10;
         myprofileid = $('#myprofileid_hidden').attr('value');
         myphoto = $('#myprofileimage_hidden').attr('value');
         myname = $('#myprofilename_hidden').attr('value');
         action.friend_match();
         action.friend_suggest("object", 6);
         if (profileid != myprofileid)
         {
            action.friend_match(this);
         }
         var profile_name = $('#profilename_hidden').attr('value');
         $(document).attr('title', profile_name + ' - Profile');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'news_json' || page == 'update')
      {
         $('#profileid_hidden').attr('value', myprofileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', '?hl=update');
            }
            else
            {
               window.location.hash = 'update';
            }
         }
         $(document).attr('title', 'Quipmate');
         page = 'news_json';
         url = 'ajax/write.php';
         param.action = 'news_feed';
         window.increment = 10;
         $('#center').html('<div id="news_poll"></div>');
         $('#center').prepend('<div id="sharing_area"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#sharing_area').load('/ajax/write.php?action=actions_load');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'profile_json')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               //var st = {url:state.url,page:page,param:param,me:"object"};
               window.history.pushState(st, 'HTML5', 'profile.php?id=' + profileid + "&hl=diary");
            }
            else
            {
               window.location.hash = 'profile.php?id=' + profileid + "&hl=diary";
            }
         }
         var profile_name = $('#profilename_hidden').attr('value');
         var profile_relation = $('#profile_relation_hidden').attr('value');
         url = 'ajax/write.php';
         param.action = 'profile_feed';
         param.profileid = $('#profileid_hidden').attr('value');
         window.increment = 10;
         $('#center').html('<div id="news_poll"></div>');
         $('#center').prepend('<div id="sharing_area"></div>');
         $('#center').append('<div id="prev"></div>');
         $(document).attr('title', profile_name + ' - Profile');
         $('#sharing_area').load('/ajax/write.php?action=actions_load&profile_relation=' + profile_relation + '');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'tech_json' || page == 'technical')
      {
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', '/?hl=technical');
            }
            else
            {
               window.location.hash = '/technical';
            }
         }
         $(document).attr('title', 'Quipmate');
         page = 'tech_json'
         url = 'ajax/write.php';
         param.action = 'technical_feed_fetch';
         window.increment = 10;
         $('#center').html('<div id="news_poll"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'inbox')
      {
         $('#profileid_hidden').attr('value', myprofileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', '?hl=inbox');
            }
            else
            {
               window.location.hash = 'inbox';
            }
         }
         $(document).attr('title', 'Quipmate - Messages');
         $('#center').html('<div id="inbox_container"></div>');
         $('html').css('overflow', 'hidden')
         $('#left').html('');
         $('#left').append('<h1 style="color:gray;">Messages</h1>');
         $('#left').append('<div id="show_inbox"></div>');
         $('#show_inbox').css('height', $(window).height() - 100);
         //$('#left').css('width','206');
         $('#show_inbox').css('overflow', 'auto');
         action.message_recent_fetch();
      }
      else if (page == 'photo' || page == 'image')
      {
         $('#profileid_hidden').attr('value', myprofileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', '?hl=image');
            }
            else
            {
               window.location.hash = 'image';
            }
         }
         $(document).attr('title', 'Quipmate - Photo');
         page = 'photo'
         url = 'ajax/write.php';
         param.action = 'photo_friend_fetch';
         param.start = 0;
         window.increment = 25;
         var profile_name = $('#myprofilename_hidden').attr('value');
         var myprofileid = $('#myprofileid_hidden').attr('value');
         $('#profileid_hidden').attr('value', myprofileid);
         $('#center').html('<div id="prev"></div>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
         $('#prev').html('<h1 class="page_title">' + profile_name + ' - Followings - Photo</h1>');
         $('#prev').append('<table></table>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
      }
      else if (page == 'pphoto')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'profile.php?id=' + profileid + "&hl=image");
            }
            else
            {
               window.location.hash = 'profile.php?id=' + profileid + "&hl=image";
            }
         }
         url = 'ajax/write.php';
         param.action = 'photo_fetch';
         param.profileid = profileid;
         window.increment = 25;
         var profile_name = $('#profilename_hidden').attr('value');
         $(document).attr('title', profile_name + ' - Photo');
         $('#center').html('<div id="prev"></div>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
         $('#prev').html('<h1 class="page_title">' + profile_name + ' - Photo</h1>');
         $('#prev').append('<table></table>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
      }
      else if (page == 'praise')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'profile.php?id=' + profileid + "&hl=praise");
            }
            else
            {
               window.location.hash = 'profile.php?id=' + profileid + "&hl=praise";
            }
         }
         url = 'ajax/write.php';
         param.profileid = profileid;
         window.increment = 25;
         var profile_name = $('#profilename_hidden').attr('value');
         $('#center').html('<h1 class="page_title">' + profile_name + ' - Praises/Recommendations</h1>');
         action.praise_fetch(this, profileid);
      }
      else if (page == 'file')
      {
         $('#profileid_hidden').attr('value', profileid);
         var icon_cdn = $('#icon_cdn').attr('value');
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'profile.php?id=' + profileid + "&hl=file");
            }
            else
            {
               window.location.hash = 'profile.php?id=' + profileid + "&hl=file";
            }
         }
         action.group_and_event_select(this);
         url = 'ajax/write.php';
         param.action = 'file_fetch';
         param.profileid = profileid;
         window.increment = 20;
         var profile_name = $('#profilename_hidden').attr('value');
        // $(document).attr('title', profile_name + ' - Files');
         $('#left').html('<div class="panel-group" id="parentfolder"><div class="panel panel-default"><div class="panel-heading pointer heading_left_padding_off" data-toggle="collapse" data-parent="#parentfolder" href="#allsub" ><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">All</h4></div><div id="allsub" class="panel-collapse collapse in"><div class="panel-body left_right_padding_off"><div class="panel panel-default ajax_nav" href="profile.php?id='+profileid+'&hl=file"><div class="panel-heading pointer"><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">Files</h4></div></div><div class="panel panel-default ajax_nav" href="profile.php?id='+profileid+'&hl=video"><div class="panel-heading pointer"><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">Video</h4></div></div></div></div></div><div class="panel panel-default"><div class="panel-heading pointer heading_left_padding_off" data-toggle="collapse" data-parent="#parentfolder" href="#groupsub"><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">Group</h4></div><div id="groupsub" class="panel-collapse collapse"><div class="panel-body group_body"></div></div></div><div class="panel panel-default"><div class="panel-heading pointer heading_left_padding_off" data-toggle="collapse" data-parent="#parentfolder" href="#eventsub"><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">Event</h4></div><div id="eventsub" class="panel-collapse collapse "><div class="panel-body event_body"></div></div></div></div>'); 
         $('#center').html('<div id="prev"></div>');
         $('#prev').html('<div class="panel-heading top1"><span style="font-size:1.3em;font-weight:bold" class="file_center_title">All Files</span><span data-toggle="modal"  data-target="#uploadfilemodal"><input type="submit" class="theme_button rfloat" style="width:8em;" value="+Upload File" /></span></div><ul role="tablist" class="nav nav-tabs top1"><li class="active"><a class="ajav_nav" href="profile.php?id='+profileid+'&hl=file">Files</a></li>  <li><a class="ajax_nav" href="profile.php?id='+profileid+'&hl=video">Videos</a></li><li><form role="search"><div><input type="text" class="form-control search_doc_form" placeholder="Search"></div></form></li></ul><table style="width:100%"> <thead><tr><th style="width:40%">Name</th><th style="width: 15%;">Last Updated by</th><th style="width: 15%;">Last Updated On</th><th style="width: 15%;">Shared with</th><th style="width: 15%;">Action</th></tr></thead><tbody class="file_table_body"></tbody></table></div>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Files" />');
 
      }
      else if (page == 'video')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'profile.php?id=' + profileid + "&hl=video");
            }
            else
            {
               window.location.hash = 'profile.php?id=' + profileid + "&hl=video";
            }
         }
         url = 'ajax/write.php';
         param.action = 'video_fetch';
         param.profileid = profileid;
         window.increment = 20;
         var profile_name = $('#profilename_hidden').attr('value');
         action.group_and_event_select(this);
         $('#left').html('<div class="panel-group" id="parentfolder"><div class="panel panel-default"><div class="panel-heading pointer heading_left_padding_off" data-toggle="collapse" data-parent="#parentfolder" href="#allsub" ><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">All</h4></div><div id="allsub" class="panel-collapse collapse in"><div class="panel-body left_right_padding_off"><div class="panel panel-default ajax_nav" href="profile.php?id='+profileid+'&hl=file"><div class="panel-heading pointer"><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">Files</h4></div></div><div class="panel panel-default ajax_nav" href="profile.php?id='+profileid+'&hl=video"><div class="panel-heading pointer"><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">Video</h4></div></div></div></div></div><div class="panel panel-default"><div class="panel-heading pointer heading_left_padding_off" data-toggle="collapse" data-parent="#parentfolder" href="#groupsub"><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">Group</h4></div><div id="groupsub" class="panel-collapse collapse"><div class="panel-body group_body"></div></div></div><div class="panel panel-default"><div class="panel-heading pointer heading_left_padding_off" data-toggle="collapse" data-parent="#parentfolder" href="#eventsub"><img src="'+icon_cdn+'/folder.png" width="20" height="20" /><h4 class="panel-title">Event</h4></div><div id="eventsub" class="panel-collapse collapse "><div class="panel-body event_body"></div></div></div></div>'); 
         
         $('#center').html('<div id="prev"></div>');
         $('#center').html('<div id="prev"></div>');
         $('#prev').html('<div class="panel-heading top1"><span style="font-size:1.3em;font-weight:bold" class="file_center_title">All Videos</span><span data-toggle="modal"  data-target="#uploadfilemodal"><input type="submit" class="theme_button rfloat" style="width:8em;" value="+Upload Video" /></span></div><ul role="tablist" class="nav nav-tabs top1"><li ><a class="ajax_nav" href="profile.php?id='+profileid+'&hl=file">Files</a></li>  <li class="active"><a class="ajax_nav" href="profile.php?id='+profileid+'&hl=video">Videos</a></li><li><form role="search"><div><input type="text" class="form-control search_doc_form" placeholder="Search"></div></form></li></ul><table style="width:100%"><tbody class="video_table_body"></tbody></table></div>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Videos" />');
      }
      else if (page == 'new_user')
      {
         $('#profileid_hidden').attr('value', myprofileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', '?hl=new_user');
            }
            else
            {
               window.location.hash = 'new_user';
            }
         }
         url = 'ajax/write.php';
         param.action = 'people_fetch';
         param.new_user = 'new_user';
         window.increment = 10;
         $(document).attr('title', 'Quipmate - People Directory');
         $('#center').html('<div id="prev"></div>');
         $('#prev').html('<h1 class="page_title">Co-workers</h1>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
      }
      else if (page == 'following')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'profile.php?id=' + profileid + "&hl=following");
            }
            else
            {
               window.location.hash = 'profile.php?id=' + profileid + "&hl=friend";
            }
         }
         url = 'ajax/write.php';
         param.action = 'following_load';
         param.profileid = profileid;
         window.increment = 50;
         var profile_name = $('#profilename_hidden').attr('value');
         $(document).attr('title', profile_name + ' - Following');
         $('#center').html('<div id="prev"></div>');
         $('#prev').html('<h1 class="page_title">' + profile_name + ' - Following</h1>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Following" />');
      }
      else if (page == 'followers')
      {
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'profile.php?id=' + profileid + "&hl=followers");
            }
            else
            {
               window.location.hash = 'profile.php?id=' + profileid + "&hl=friend";
            }
         }
         url = 'ajax/write.php';
         param.action = 'followers_load';
         param.profileid = profileid;
         window.increment = 50;
         var profile_name = $('#profilename_hidden').attr('value');
         $(document).attr('title', profile_name + ' - Followers');
         $('#center').html('<div id="prev"></div>');
         $('#prev').html('<h1 class="page_title">' + profile_name + ' - Followers</h1>');
         $('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Followers" />');
      }
      else if (page == 'bio')
      {
/*var pos = state.url.indexOf('id=');
				profileid = state.url.slice(pos+3, pos+13);*/
         $('#profileid_hidden').attr('value', profileid);
         if (!state.pop)
         {
            if (window.history)
            {
               var st =
               {
                  url: state.url,
                  page: page,
                  param: param,
                  me: "object"
               };
               window.history.pushState(st, 'HTML5', 'profile.php?id=' + profileid + "&hl=bio");
            }
            else
            {
               window.location.hash = 'profile.php?hl=id=' + profileid + "&hl=bio";
            }
         }
         url = 'ajax/write.php';
         param.action = 'profile_details_fetch';
         param.profileid = profileid;
         window.ajax_queue.push($.getJSON(url, param, function(data)
         {
            $('#profile_relation_hidden').attr('value', data.info.profile_relation);
            $('#left').html('<ul class=" nav nav-pills nav-stacked"><li class="links"><a class="ajax_nav" id="profile_json" href="profile.php?id=' + profileid + '&hl=diary" title="Your activities"><span class="name_20">Diary</span></a></li><li class="links"><a class="ajax_nav" id="bio" href="profile.php?id=' + profileid + '&hl=bio" title="Your Bio"><span class="name_20">Bio</span></a></li><li class="links"><a class="ajax_nav" id="praise" href="profile.php?id=' + profileid + '&hl=praise" title="Your Praises"><span class="name_20">Praises</span></a></li><li class="links"><a class="ajax_nav" id="pphoto" href="profile.php?id=' + profileid + '&hl=image" title="Your Photos"><span class="name_20">Photos</span></a></li><li class="links"><a  class="ajax_nav" id="following" href="profile.php?id=' + profileid + '&hl=following" title="You are following"><span class="name_20">Following (' + data.info.following_count + ')</span></a></li><li class="links"><a  class="ajax_nav" id="followers" href="profile.php?id=' + profileid + '&hl=followers" title="Your followers"><span class="name_20">Followers (' + data.info.followers_count + ')</span></a></li></ul><div id="friend_event" class="right_item" style="margin:1em 0em 0em 0em;padding:0em;"></div>');
            $('#profilename_hidden').attr('value', data.info.name);
            $(document).attr('value', data.info.name);
            if (data.info.friendship_status == 2)
            {
               $('#left').append('<div style="margin-top:2em;text-align:center;"><a style="color:#003399;" href="#" onclick="ui.unfriend(this) " >Unfollow ' + data.info.name + '</a></div>');
            }
         }));
         var myprofileid = $('#myprofileid_hidden').attr('value');
         if (myprofileid == profileid)
         {
            $('#right').html('');
         }
         url = 'ajax/write.php';
         param.action = 'bio_fetch';
         param.profileid = $('#profileid_hidden').attr('value');
         var profile_name = $('#profilename_hidden').attr('value');
         $(document).attr('title', profile_name + ' - Bio');
         $('#center').html('<div id="prev"></div>');
      }
      if (page != 'inbox')
      {
         action.first_loader(page, param);
      }
      $('.ajax_loader').remove();
      $('body').prepend('<iframe id="load_hidden" style="display:none;" ></iframe>');
      $('#load_hidden').load('ajax/write.php?action=actions_load&page=group_json');
      param.page = page;
      param.lastScrollTopfeed = $(window).scrollTop();
      $('#page_hidden').attr('value', page);
            
        if(page == 'bio' || page == 'file' || page == 'group_file' || page == 'event_file' || page == 'video' || page == 'group_video' || page == 'event_video')
        {
        
        $('#center').removeClass('col-md-6');
        $('#center').addClass('col-md-8');
        $('#right').hide();
        }
        else
        {
        $('#center').removeClass('col-md-8');
        $('#center').addClass('col-md-6');
        $('#right').show();
        }
      
      return false;
   }
   return {
      ajax_navigation: ajax_navigation,
      action_decode: action_decode,
      member_deploy: member_deploy,
      photo_deploy: photo_deploy,
      file_deploy: file_deploy,
      video_deploy: video_deploy,
      people_deploy: people_deploy,
      album_deploy: album_deploy,
      friend_deploy: friend_deploy,
      bio_deploy: bio_deploy,
      notice_deploy: notice_deploy,
      guest_deploy: guest_deploy,
      message_recent_fetch: message_recent_fetch
   }
})();