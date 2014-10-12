var feed = (function()
{
   var icon_cdn = $('#icon_cdn').attr('value');
   var image_cdn = $('#image_cdn').attr('value');
   var page_value = $('#page_hidden').attr('value');

   function news_deploy(data, container, instant, append)
   {
      var myprofileid = data.myprofileid;
      if (data.action.length > 0)
      {
         $.each(data.action, function(index, value)
         {
            if (instant == 1)
            {
               dom_id = 'if_post_' + value.actionid;
            }
            else if (instant == 99)
            {
               dom_id = 'share_post_' + value.actionid;
            }
            else
            {
               dom_id = 'nf_post_' + value.actionid;
            }
            deploy.action_decode('news_feed', value, data.name, data.pimage, container, dom_id, instant, append);
            if (value.actiontype == 1 || value.actiontype == 10 || value.actiontype == 2 || value.actiontype == 11)
            {
               page_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 3 || value.actiontype == 13 || (value.actiontype >= 200 && value.actiontype < 300))
            {
               profile_edit_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 5 || value.actiontype == 12 || value.actiontype == 23)
            {
               moment_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 6 || value.actiontype == 24 || value.actiontype == 15)
            {
               image_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 8)
            {
               friendship_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 16 || value.actiontype == 50 || value.actiontype == 25)
            {
               profile_image_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 17 || value.actiontype == 26)
            {
               friendship_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 99 || value.actiontype == 91 || value.actiontype == 92)
            {
               quipmate_joined_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 300)
            {
               group_created_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 301)
            {
               group_page_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 306)
            {
               group_image_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 308)
            {
               group_joined_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 316)
            {
               group_link_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 325)
            {
               group_video_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 326)
            {
               group_doc_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 328)
            {
               group_question_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 330)
            {
               group_event_created_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 400)
            {
               event_created_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 403)
            {
               event_page_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 406)
            {
               event_image_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 408)
            {
               event_joined_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 410)
            {
               event_cancelled_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 416)
            {
               event_link_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 425)
            {
               event_video_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 426)
            {
               event_doc_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 501 || value.actiontype == 503 || value.actiontype == 511)
            {
               missu_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 600 || value.actiontype == 602 || value.actiontype == 611)
            {
               blog_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 700 || value.actiontype == 702 || value.actiontype == 711)
            {
               direct_letter_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 800 || value.actiontype == 802 || value.actiontype == 811)
            {
               tagline_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 1201 || value.actiontype == 1202 || value.actiontype == 1211)
            {
               mood_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 1401 || value.actiontype == 1402 || value.actiontype == 1411)
            {
               gift_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 1600 || value.actiontype == 1602 || value.actiontype == 1611)
            {
               link_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 1900 || value.actiontype == 1902 || value.actiontype == 1911)
            {
               birthday_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2000 || value.actiontype == 2002 || value.actiontype == 2011)
            {
               status_song_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2100 || value.actiontype == 2102 || value.actiontype == 2111)
            {
               song_dedication_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2400 || value.actiontype == 2402 || value.actiontype == 2411)
            {
               praise_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 900 || value.actiontype == 902 || value.actiontype == 911)
            {
               star_decode(value, data.name, data.pimage, container, dom_id);
            }            
            else if (value.actiontype == 2500 || value.actiontype == 2511 || value.actiontype == 2502)
            {
               video_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2600 || value.actiontype == 2611 || value.actiontype == 2602)
            {
               doc_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2800 || value.actiontype == 2801 || value.actiontype == 2811 || value.actiontype == 2802)
            {
               question_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2901)
            {
               page_page_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2906)
            {
               page_image_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2916)
            {
               page_link_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2925)
            {
               page_video_decode(value, data.name, data.pimage, container, dom_id);
            }
            else if (value.actiontype == 2926)
            {
               page_doc_decode(value, data.name, data.pimage, container, dom_id);
            }
            if (instant != 99) // When Re-sharing a post someone has shared
            {
               time_tag_decode(value, data.tag, dom_id);
               response_decode(value, data.name, dom_id);
               comment_decode(value, data.name, data.pimage, myprofileid, dom_id);
               if (!(value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
               {
                  // If this is not adming feed then only commentbox will be displayed .
                  comment_box(value, data.pimage, myprofileid, dom_id);
               }
            }
         });
      }
      else
      {
/*$('#prev').append('<div style="text-align:center;">No Posts to show</div>');
					$('#prev').append('<div style="border-bottom: 0.1em solid #CCCCCC;border-top: 0.1em solid #CCCCCC; height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="height:4em;width:20em;" value="Find friends" onclick="ui.redirect_friend_suggest()"/></div>');
					$('#prev').append('<div style="border-bottom: 0.1em solid #CCCCCC;border-top: 0.1em solid #CCCCCC; height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="height:4em;width:20em;" value="Join Group" onclick="ui.redirect_group_suggest()"/></div>');*/
         $('#prev').append('<div style="text-align:center;"><img width="136" height="136" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/noposts.png" alt=""><div style="font-size:2.4em;color:#adb2bb;font-weight:bold;">No posts to show</div><div style="margin-top:1.45em;"><a style="float:left;margin-left:4em;" class="really_group_join" href="/register.php?hl=friend_suggest">Find Friends</a><a style="margin-right:4em;" class="really_group_join" href="/register.php?hl=group_suggest">Join Groups</a></div></div>');
      }
   }

   function page_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + '"><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a><div class="pclass_json"><pre>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</pre></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function profile_edit_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var pronoun = 'his';
      if (value.sex == 0) pronoun = 'her';
      var str = 'changed ' + pronoun + ' ' + value.edit_field + ' to ' + value.edit_value;
      if (value.actiontype == 206 || value.actiontype == 207 || value.actiontype == 208 || value.actiontype == 209 || value.actiontype == 211 || value.actiontype == 235 || value.actiontype == 230 || value.actiontype == 231 || value.actiontype == 232 || value.actiontype == 233 || value.actiontype == 235 || value.actiontype == 235 || value.actiontype == 236)
      {
         str = 'added ' + value.edit_value + ' to ' + pronoun + ' ' + value.edit_field;
      }
      else if (value.actiontype == 234)
      {
         str = 'joined  ' + value.edit_value + ' ' + value.edit_field;
      }
      postid.append('<div data="' + value.actionid + '" class="pageclass_json"><input type="hidden" value="' + value.actionon + '" /><input type="hidden" value="' + value.parenttype + '"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> ' + str + '<div class="pclass_json"></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function birthday_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1900"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.actionon + '"><img class="lfloat" src =' + pimage[value.actionon] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.actionon + '">' + name[value.actionon] + '</a> was birthday wished by <a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a></div><div class="pclass_json"><pre>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</pre></div></div>');
      if (value.actionby == myprofileid)
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function friendship_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="8"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' "><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> is now following <a class="ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a></div><div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function group_created_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="300"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' "><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> created the group <a class="ajax_nav" href="group.php?id=' + value.groupid + '">' + value.group_name + '</a></div><div><div style="margin:0.5em 0em">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.group_description))) + '</div></div></div>');
   }

   function quipmate_joined_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="99"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' "><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a> joined <a href="/">Quipmate</a></div></div>');
   }

   function group_joined_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="308"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.actionon + ' "><img class="lfloat" src =' + pimage[value.actionon] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.actionon + '">' + name[value.actionon] + '</a> was invited by <a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a> to <a class="ajax_nav" href="group.php?id=' + value.groupid + '">' + value.group_name + '</a></div><div></div></div>');
   }

   function event_cancelled_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="400"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' "><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> cancelled the event <a class="ajax_nav" href="event.php?id=' + value.eventid + '">' + value.event_name + '</a></div><div><div style="margin:0.5em 0em">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.event_description))) + '</div><div style="margin:0.5em 0em">' + value.date + ' ' + value.timing + '</div><div style="margin:0.5em 0em">' + value.venue + '</div></div></div>');
   }

   function group_event_created_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.pageid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="400"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' "><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> invited group <a class="ajax_nav" href="group.php?id=' + value.groupid + '">' + value.group_name + '</a> to the event <a class="ajax_nav" href="event.php?id=' + value.eventid + '">' + value.event_name + '</a></div><div><div style="margin:0.5em 0em">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.event_description))) + '</div><div style="margin:0.5em 0em">' + value.date + ' ' + value.timing + '</div><div style="margin:0.5em 0em">' + value.venue + '</div></div></div>');
   }

   function event_created_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.pageid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="400"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' "><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> created the event <a class="ajax_nav" href="event.php?id=' + value.eventid + '">' + value.event_name + '</a></div><div><div style="margin:0.5em 0em">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.event_description))) + '</div><div style="margin:0.5em 0em">' + value.date + ' ' + value.timing + '</div><div style="margin:0.5em 0em">' + value.venue + '</div></div></div>');
   }

   function event_joined_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="408"/></div>');
      if (value.postby != value.actionon)
      {
         postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' "><img class="lfloat" src =' + pimage[value.actionon] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a> was invited by <a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a> to <a class="ajax_nav" href="event.php?id=' + value.eventid + '">' + value.event_name + '</a></div><div></div></div>');
      }
      else
      {
         postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' "><img class="lfloat" src =' + pimage[value.actionon] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a> joined <a class="ajax_nav" href="event.php?id=' + value.eventid + '">' + value.event_name + '</a></div><div></div></div>');
      }
   }

   function missu_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      postid.append('<div data="' + value.actionid + '" class="pageclass_json"><input type="hidden" value="' + value.actionon + '" /><input type="hidden" value="501"/><a class="ajax_nav" href="profile.php?id=' + value.actionon + ' " ><img class="lfloat" src =' + pimage[value.actionon] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a> is being missed by <a style="color:#003399" href="#">someone</a></div></div>');
   }

   function gift_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var file = image_cdn + '/' + value.file;
      postid.append('<div data="' + value.actionid + '" class="pageclass_json"><input type="hidden" value="' + value.actionon + '" /><input type="hidden" value="1401"/><a class="ajax_nav" href="profile.php?id=' + value.actionon + ' " ><img class="lfloat" src =' + pimage[value.actionon] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.actionon + ' " >' + name[value.actionon] + '</a> received ' + value.gift + ' as gift from <a class="acolor ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a></div><div><div class="pclass_json">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><img src="' + file + '" /></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function mood_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var file = image_cdn + '/' + value.file;
      var pronoun = 'his';
      if (value.sex == 0) pronoun = 'her';
      postid.append('<div data="' + value.actionid + '" class="pageclass_json"><input type="hidden" value="' + value.actionon + '" /><input type="hidden" value="1201"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> changed ' + pronoun + ' mood to ' + value.mood + '</div><div><div style="margin-top:0.5em;">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><img src="' + file + '" /></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function moment_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /><input type="hidden" value="5"/><a class="ajax_nav" href="profile.php?id=' + value.postby + '"><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added ' + value.count + ' photo to the album ' + value.mname + '<div class="pclass_json"><input type="hidden" value=' + value.life_is_fun + ' /><div>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.desc))) + '</div></div></div></div>');
      $.each(value.photo, function(i, v)
      {
         var f = v.file;
         postid.children().eq(1).children().eq(3).children().eq(1).append('<img class="album-image" onclick="action.image_viewer(this)" data="' + f + '"src ="thumbnail.php?file=' + f + '&maxw=180&maxh=180" style="margin:0em 0.25em 0em 0em;cursor:pointer;height:15em;max-width:16.6em;" id="' + v.actionid + ' " />');
      });
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function blog_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var file = value.file;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="6"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> published a blog<div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.blog_title))) + '</div><img src ="thumbnail.php?file=' + file + '&maxw=368&maxh=400"class="nf_thumb" data="' + file + '"  onclick="action.image_viewer(this)" id="' + value.pageid + ' " /><div class="pclass_json"><pre>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.blog_content))) + '</pre></div></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function group_image_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var file = value.file;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /><input type="hidden" value="6"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added a photo in the group <a class="ajax_nav" href="group.php?id=' + value.groupid + ' " >' + value.group_name + '</a></div><div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><img src ="thumbnail.php?file=' + file + '&maxw=368&maxh=400"class="nf_thumb" data="' + file + '" onclick="action.image_viewer(this)" id="' + value.pageid + ' " /></div></div></div>');
      if (value.postby == myprofileid || value.remove == 1 || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function group_video_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var file = value.file;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="2500"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added a video in the group <a class="ajax_nav" href="group.php?id=' + value.groupid + ' " >' + value.group_name + '</a></div><div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div id="' + dom_id + 'video_' + value.actionid + '"></div></div></div></div>');
      jwplayer(dom_id + "video_" + value.actionid).setup(
      {
         file: value.file,
         title: value.page,
         image: value.caption,
         width: "100%",
         aspectratio: "16:9",
         fallback: "false",
         primary: "flash"
      });
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function page_image_decode(value, name, pimage, container, dom_id)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      var postid = $('#' + dom_id);
      var file = value.file;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var page_image = icon_cdn + '/broadcast.png';
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /><input type="hidden" value="6"/><a class="ajax_nav" href="page.php?id=' + value.page_pageid + ' " ><img class="lfloat" src =' + page_image + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="page.php?id=' + value.page_pageid + ' " >' + value.page_name + '</a></div><div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><img src ="thumbnail.php?file=' + file + '&maxw=368&maxh=400"class="nf_thumb" data="' + file + '"  onclick="action.image_viewer(this)" id="' + value.pageid + ' " /></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function page_video_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var icon_cdn = $('#icon_cdn').attr('value');
      var file = value.file;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var page_image = icon_cdn + '/broadcast.png';
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="2500"/><a class="ajax_nav" href="page.php?id=' + value.page_pageid + ' " ><img class="lfloat" src =' + page_image + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="page.php?id=' + value.page_pageid + ' " >' + value.page_name + '</a></div><div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div id="' + dom_id + 'video_' + value.actionid + '"></div></div></div></div>');
      jwplayer(dom_id + "video_" + value.actionid).setup(
      {
         file: value.file,
         title: value.page,
         image: value.caption,
         width: "100%",
         aspectratio: "16:9",
         fallback: "false",
         primary: "flash"
      });
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function page_doc_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var ext = value.caption.split('.').pop();
      var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
      var page_image = icon_cdn + '/broadcast.png';
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="2600"/><a class="ajax_nav" href="page.php?id=' + value.page_pageid + ' " ><img class="lfloat" src =' + page_image + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="page.php?id=' + value.page_pageid + ' " >' + value.page_name + '</a></div><div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><img class="lfloat" src=' + fileimage + ' height="50" width="50" /><div id="doc_name"><a href=' + value.file + ' data="' + value.file + '" target="_blank">' + value.caption + '</a></div><br class="bclear"></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function event_doc_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var ext = value.caption.split('.').pop();
      var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="2600"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added a doc in the event <a class="ajax_nav" href="event.php?id=' + value.eventid + ' " >' + value.event_name + '</a></div><div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><img class="lfloat" src=' + fileimage + ' height="50" width="50" /><div id="doc_name"><a href=' + value.file + ' data="' + value.file + '" target="_blank">' + value.caption + '</a></div><br class="bclear"></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function group_doc_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="2600"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added a doc in the group <a class="ajax_nav" href="group.php?id=' + value.groupid + ' " >' + value.group_name + '</a></div><div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><br class="bclear"></div></div></div>');
      var doc_number = value.version.length;      
      $.each(value.version, function(i, v)
      {
         var ext = v.caption.split('.').pop();
         var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
         postid.children().children().children().eq(2).append('<a href="https://docs.google.com/viewer?url=' + v.file + '" target="_blank"><img class="lfloat" src=' + fileimage + ' height="50" width="50" /></a><div id="doc_name" style="margin-bottom:2em;"><a href="https://docs.google.com/viewer?url=' + v.file + '" data="' + v.file + '" target="_blank">' + v.caption + '</a></div><div style="margin:1em 0em 0em 5.4em;" id="version_'+value.pageid+'"><a style="color:#808080;" target="_blank" href="https://docs.google.com/viewer?url=' + v.file + '">Preview</a><a style="color:#808080;margin-left:1em;" href=' + v.file + ' data="' + v.file + '" target="_blank">Download</a></div>');
         doc_number = doc_number - 1;
         if(doc_number == 0)
         {
            console.log(doc_number);
            $('#version_'+value.pageid).append('<a style="color:#808080;margin-left:1em;" class="new_version" href="#" onclick="action.new_version_upload(this,event)">Upload new version</a><form action="/ajax/write.php" enctype="multipart/form-data" style="display:none;" method="post" id="pform"><input type="file" id="photo_box" name="photo_box" size="30"><input type="submit" value="Upload" id="new_version_upload_button" name="upload"><input type="hidden" value="' + value.groupid + '" name="photo_hidden_profileid" id="photo_hidden_profileid"><input type="hidden" value="new_version_upload" name="action"><input type="hidden" value="' + value.pageid + '" name="pageid"></form>');
         }
         
      });
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function doc_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var ext = value.caption.split('.').pop();
      var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="2600"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added a doc<div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><img class="lfloat" src=' + fileimage + ' height="50" width="50" /><div id="doc_name"><a href=' + value.file + ' data="' + value.file + '" target="_blank">' + value.caption + '</a></div><br class="bclear"></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function event_image_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var file = value.file;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="6"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added a photo in the event <a class="ajax_nav" href="event.php?id=' + value.eventid + ' " >' + value.event_name + '</a></div><div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><img src ="thumbnail.php?file=' + file + '&maxw=368&maxh=400" class="nf_thumb" data="' + file + '"  onclick="action.image_viewer(this)" id="' + value.pageid + ' " /></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function event_video_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var file = value.file;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="2500"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added a video in the event <a class="ajax_nav" href="event.php?id=' + value.eventid + ' " >' + value.event_name + '</a><div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div id="' + dom_id + 'video_' + value.actionid + '"></div></div></div></div>');
      jwplayer(dom_id + "video_" + value.actionid).setup(
      {
         file: value.file,
         title: value.page,
         image: value.caption,
         width: "100%",
         aspectratio: "16:9",
         fallback: "false",
         primary: "flash"
      });
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function video_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var file = value.file;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="2500"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added a video<div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div id="' + dom_id + 'video_' + value.actionid + '"></div></div></div></div>');
      jwplayer(dom_id + "video_" + value.actionid).setup(
      {
         file: value.file,
         image: value.caption,
         title: value.page,
         width: "100%",
         aspectratio: "16:9",
         fallback: "false",
         primary: "flash"
      });
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function feed_video_decode(value, dom_id)
   {
      var postid = $('#' + dom_id);
      jwplayer(dom_id + "video_" + value.actionid).setup(
      {
         file: value.file,
         image: value.caption,
         width: "100%",
         aspectratio: "16:9",
         fallback: "false",
         primary: "flash"
      });
   }

   function image_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var file = value.file;
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="6"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> added a photo<div><input type="hidden" value="' + value.life_is_fun + '" /><div class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><img src ="thumbnail.php?file=' + file + '&maxw=368&maxh=400" class="nf_thumb" data="' + file + '"  onclick="action.image_viewer(this)" id="' + value.pageid + ' " /></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function profile_image_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var file = value.file;
      var pronoun = 'his';
      if (value.sex == 0) pronoun = 'her';
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="50"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> changed ' + pronoun + ' profile photo<div style="margin-top:1em;"><input type="hidden" value="' + value.life_is_fun + '" /><img src ="thumbnail.php?file=' + file + '&maxw=368&maxh=400"class="nf_thumb" data="' + file + '"  onclick="action.image_viewer(this)" id="' + value.pageid + ' "/></div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function tagline_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var file = icon_cdn + '/tag.gif';
      var pronoun = 'his';
      if (value.sex == 0) pronoun = 'her';
      postid.append('<div data="' + value.actionid + '" class="pageclass_json"><input type="hidden" value="' + value.actionon + '" /><input type="hidden" value="800"/><a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> changed ' + pronoun + ' tagline <div class="pclass_json"><img src="' + file + '" /> ' + ui.get_smiley(ui.see_more(ui.link_highlight(value.tagline))) + '</div></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function direct_letter_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + '"><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a> wrote an open letter to the Managing Director<div class="pclass_json"><pre class="nf_page">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.letter_title))) + '</pre><pre  class="nf_page" style="margin:0.5em 0em;display:block;">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.letter_content))) + '</pre></div></div>');
      if (value.postby == myprofileid)
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function praise_decode(value, name, pimage, container, dom_id)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var file = icon_cdn+'/'+value.file;
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.actionon + '"><img class="lfloat" src =' + pimage[value.actionon] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.actionon + '">' + name[value.actionon] + '</a> was praised by <a class="ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a></div><div class="lfloat"><img src="'+file+'" width="70" height="70" /><div class="text-center"><strong>'+value.mood+'</strong></div></div><div class="praise_texts"><pre class="nf_page"><strong>For: '+ ui.get_smiley(ui.see_more(ui.link_highlight(value.letter_title))) + '</strong></pre><pre style="margin:0.5em 0em;display:block;"><strong>Praise: </strong>'+ ui.get_smiley(ui.see_more(ui.link_highlight(value.letter_content))) + '</pre></div></div>');
      
      
      if (value.postby == myprofileid)
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }
   function star_decode(value, name, pimage, container, dom_id)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var file = icon_cdn+'/'+'star.png';
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.actionon + '"><img class="lfloat" src =' + pimage[value.actionon] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.actionon + '">' + name[value.actionon] + '</a> was awarded as <strong>Star of the week</strong></div><div class="lfloat"><img src="'+file+'" width="90" height="90" /></div><div class="praise_texts"><pre class="nf_page">'+ ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</pre></div></div>');
      
      
      if (value.postby == myprofileid)
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }
   function group_page_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + '"><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a> posted in the group <a class="ajax_nav" href="group.php?id=' + value.groupid + ' " >' + value.group_name + '</a></div><div class="pclass_json"><pre>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</pre></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function page_page_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var page_image = icon_cdn + "/broadcast.png";
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="page.php?id=' + value.page_pageid + '"><img class="lfloat" src =' + page_image + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="page.php?id=' + value.page_pageid + '">' + value.page_name + '</a></div><div class="pclass_json"><pre>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</pre></div></div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function group_question_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /><input type="hidden" value="2801"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + '"><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a> asked a question to the group <a class="ajax_nav" href="group.php?id=' + value.groupid + ' " >' + value.group_name + '</a></div><div class="pclass_json"><pre style="margin-bottom:0.6em;">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.question))) + '</pre></div></div>');
      $.each(value.option, function(i, v)
      {
         if (v.mine == 1)
         {
            postid.children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><div class="option_percentage" id =' + v.optid + '><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, ' + value.actionid + ', ' + v.optid + ')" checked/>' + ui.get_smiley(ui.see_more(ui.link_highlight(v.opt))) + '<span class="rfloat tcolor" onclick="action.answer_people_fetch(this,' + v.optid + ')">' + v.count + ' vote, ' + (Math.round(v.percent * 100) / 100) + '% </span></div></div>');
         }
         else
         {
            postid.children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><div class="option_percentage" id =' + v.optid + '><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, ' + value.actionid + ', ' + v.optid + ')"/>' + ui.get_smiley(ui.see_more(ui.link_highlight(v.opt))) + '<span class="rfloat tcolor" onclick="action.answer_people_fetch(this,' + v.optid + ')">' + v.count + ' vote, ' + v.percent + '% </span></div></div>');
         }
         if (v.percent > 0)
         {
            $('#' + v.optid).css(
            {
               "width": v.percent + '%',
               "background": "#808080"
            });
         }
      });
      postid.children().eq(1).children().eq(3).children().eq(1).append('<div><input type="text" placeholder="+Add answer" value="" class="option" onkeydown="action.option_add(this,event)"><div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function event_page_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /><input type="hidden" value="1"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + '"><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a> posted in the event <a class="ajax_nav" href="event.php?id=' + value.eventid + ' " >' + value.event_name + '</a></div><div class="pclass_json"><pre>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</pre></div></div>');
      if (value.postby == myprofileid)
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function event_link_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1600"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> shared <a href="' + value.link + '" target="_blank">' + value.title + '</a> in the event <a class="ajax_nav" href="event.php?id=' + value.eventid + ' " > ' + value.event_name + '</a></div></div>');
      if (value.video)
      {
         postid.children().eq(1).children().eq(3).append('<div class="rposition"><input type="hidden" value="' + value.file + '" /><img class="video_play lfloat nf_video"  onclick="action.image_viewer(this)" id="' + value.actionid + '" src="https://img.youtube.com/vi/' + value.file + '/default.jpg" /><img class="video_play nf_video_icon"  onclick="action.image_viewer(this)" id="' + value.actionid + '" src="' + icon_cdn + '/video_play_icon.png" /><div style="margin:2em 0em 0em 0em;"><div>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div>' + value.title + '</div><a href="' + value.link + '" target="_blank">' + value.host + '</a><div>' + value.meta + '</div></div><br class="bclear"/></div>');
      }
      else
      {
         postid.children().eq(1).children().eq(3).append('<div style="margin:1em 0em 0em 0em;">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div><img class="lfloat nf_link_thumb" src="' + value.file + '" ><div class="link_title">' + value.title + '</div><div ><a href="' + value.link + '"  target="_blank">' + value.host + '</a></div><div class="link_meta">' + value.meta + '</div></div></div>');
      }
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function page_link_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var page_image = icon_cdn + '/broadcast.png';
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1600"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="page.php?id=' + value.page_pageid + ' " ><img class="lfloat" src =' + page_image + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="page.php?id=' + value.page_pageid + ' " >' + value.page_name + '</a></div></div>');
      if (value.video)
      {
         postid.children().eq(1).children().eq(3).append('<div class="rposition"><input type="hidden" value="' + value.file + '" /><img class="video_play lfloat nf_video"  onclick="action.image_viewer(this)" id="' + value.actionid + '" src="https://img.youtube.com/vi/' + value.file + '/default.jpg" /><img class="video_play nf_video_icon"  onclick="action.image_viewer(this)" id="' + value.actionid + '" src="' + icon_cdn + '/video_play_icon.png" /><div style="margin:2em 0em 0em 0em;"><div>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div>' + value.title + '</div><a href="' + value.link + '" target="_blank">' + value.host + '</a><div>' + value.meta + '</div></div><br class="bclear"/></div>');
      }
      else
      {
        postid.children().eq(1).children().eq(3).append('<div style="margin:1em 0em 0em 0em;">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div><img class="lfloat nf_link_thumb" src="' + value.file + '" ><div class="link_title">' + value.title + '</div><div ><a href="' + value.link + '"  target="_blank">' + value.host + '</a></div><div class="link_meta">' + value.meta + '</div></div></div>');
      }
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function group_link_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1600"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> shared <a href="' + value.link + '" target="_blank">' + value.title + '</a> in the group <a class="ajax_nav" href="group.php?id=' + value.groupid + ' " >' + value.group_name + '</a></div></div>');
      if (value.video)
      {
         postid.children().eq(1).children().eq(3).append('<div class="rposition"><input type="hidden" value="' + value.file + '" /><img class="video_play lfloat nf_video"  onclick="action.image_viewer(this)" id="' + value.actionid + '" src="https://img.youtube.com/vi/' + value.file + '/default.jpg" /><img class="video_play nf_video_icon"  onclick="action.image_viewer(this)" id="' + value.actionid + '" src="' + icon_cdn + '/video_play_icon.png" /><div style="margin:2em 0em 0em 0em;"><div>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div>' + value.title + '</div><a href="' + value.link + '" target="_blank">' + value.host + '</a><div>' + value.meta + '</div></div><br class="bclear"/></div>');
      }
      else
      {
         postid.children().eq(1).children().eq(3).append('<div style="margin:1em 0em 0em 0em;">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div><img class="lfloat nf_link_thumb" src="' + value.file + '" ><div class="link_title">' + value.title + '</div><div ><a href="' + value.link + '"  target="_blank">' + value.host + '</a></div><div class="link_meta">' + value.meta + '</div></div></div>');
      }
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function link_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="1600"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + ' " ><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.postby + ' " >' + name[value.postby] + '</a> shared <a href="' + value.link + '" target="_blank">' + value.title + '</a></div></div>');
      if (value.video)
      {
         postid.children().eq(1).children().eq(3).append('<div class="rposition"><input type="hidden" value="' + value.file + '" /><img class="video_play lfloat nf_video"  onclick="action.image_viewer(this)" id="' + value.actionid + '" src="https://img.youtube.com/vi/' + value.file + '/default.jpg" /><img class="video_play nf_video_icon"  onclick="action.image_viewer(this)" id="' + value.actionid + '" src="' + icon_cdn + '/video_play_icon.png" /><div style="margin:2em 0em 0em 0em;"><div>' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div class="link_title">' + value.title + '</div><a href="' + value.link + '" target="_blank">' + value.host + '</a><div class="link_meta">' + value.meta + '</div></div><br class="bclear"/></div>');
      }
      else
      {
         postid.children().eq(1).children().eq(3).append('<div style="margin:1em 0em 0em 0em;">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.page))) + '</div><div><img class="lfloat nf_link_thumb" src="' + value.file + '" ><div class="link_title">' + value.title + '</div><div ><a href="' + value.link + '"  target="_blank">' + value.host + '</a></div><div class="link_meta">' + value.meta + '</div></div></div>');
      }
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function question_decode(value, name, pimage, container, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      postid.append('<div data=' + value.actionid + ' class="pageclass_json"><input type="hidden" value=' + value.actionon + ' /> <input type="hidden" value="2801"/></div>');
      postid.children().eq(1).append('<a class="ajax_nav" href="profile.php?id=' + value.postby + '"><img class="lfloat" src =' + pimage[value.postby] + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.postby + '">' + name[value.postby] + '</a> asked a question<div class="pclass_json"><pre style="margin-bottom:0.6em;">' + ui.get_smiley(ui.see_more(ui.link_highlight(value.question))) + '</pre></div></div>');
      $.each(value.option, function(i, v)
      {
         if (v.mine == 1)
         {
            postid.children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><div class="option_percentage" id =' + v.optid + '><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, ' + value.actionid + ', ' + v.optid + ')" checked/>' + ui.see_more(ui.get_smiley(ui.link_highlight(v.opt))) + '<span class="rfloat tcolor" onclick="action.answer_people_fetch(this,' + v.optid + ')">' + v.count + ' vote, ' + (Math.round(v.percent * 100) / 100) + '% </span></div></div>');
         }
         else
         {
            postid.children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><div class="option_percentage" id =' + v.optid + ' ><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, ' + value.actionid + ', ' + v.optid + ')"/>' + ui.see_more(ui.get_smiley(ui.link_highlight(v.opt))) + '<span class="rfloat tcolor" onclick="action.answer_people_fetch(this,' + v.optid + ')">' + v.count + ' vote, ' + v.percent + '% </span></div></div>');
         }
         if (v.percent > 0)
         {
            $('#' + v.optid).css(
            {
               "width": v.percent + '%',
               "background": "#808080"
            });
         }
      });
      postid.children().eq(1).children().eq(3).children().eq(1).append('<div><input type="text" placeholder="+Add answer" value="" class="option" onkeydown="action.option_add(this,event)"><div>');
      if ((value.postby == myprofileid) || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
      {
         postid.append('<span onclick="ui.post_delete(this)" title="Delete this post"  class="post_setting"></span>');
      }
   }

   function time_tag_decode(value, tag, dom_id)
   {
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var postid = $('#' + dom_id);
      var exciting = 'Exciting';
      var class_type = 'response';
      var fun = 'action.response(this)';
      var pos = $.inArray(myprofileid, value.excited);
      if (value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
      {
         exciting = 'New-Pinch';
      }
      if (pos != -1)
      {
         exciting = 'Unexciting';
         class_type = 'responsed';
         fun = 'action.responsed(this)';
         if (value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
         {
            exciting = 'Unpinch';
         }
      }
      if (value.hasOwnProperty('admin_feed') && value.admin_feed == 1)
      {
         postid.children().eq(1).children().eq(3).append('<div class="time_tag_json" id="time_tag_json_'+value.pageid+'"><span onclick="' + fun + '" class="' + class_type + '" style="color:#336699;"></span><a href="action.php?actionid=' + value.pageid + '&life_is_fun=' + value.life_is_fun + '"><span class="glyphicon glyphicon-time" style="color:#ccc;"></span><span class="time" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></a></div>');
      }
      else
      {
         postid.children().eq(1).children().eq(3).append('<div class="time_tag_json" id="time_tag_json_'+value.pageid+'"><span onclick="' + fun + '" class="' + class_type + '" style="color:#336699;">' + exciting + ' </span><a href="action.php?actionid=' + value.pageid + '&life_is_fun=' + value.life_is_fun + '"><span class="glyphicon glyphicon-time" style="color:#ccc;"></span><span class="time" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></a></div>');
      }
      var container_to_append =$('#'+'time_tag_json_'+value.pageid);
      if (value.visible == 0)
      {
         container_to_append.append('&nbsp;&nbsp;&nbsp;<b>·</b><span class="post_privacy_display"><img style="height:1em" title="Shared with Everyone" width="15" height="15" src="' + icon_cdn + '/global.png" /></span>');
      }
   /*   else if (value.visible == 1)
      {
         postid.children().eq(1).children().eq(3).children().eq(2).append('&nbsp;&nbsp;&nbsp;<b>·</b><span class="post_privacy_display"><img style="height:1em" title="Shared with followers of followers" src="' + icon_cdn + '/meeting.png" /></span>');
      } */
      else if (value.visible == 2)
      {
         container_to_append.append('&nbsp;&nbsp;&nbsp;<b>·</b><span class="post_privacy_display"><img  style="height:1em" title="Shared with followers" src="' + icon_cdn + '/friend.png" /></span>');
      }
      else if (value.visible == 5)
      {
         container_to_append.append('&nbsp;&nbsp;&nbsp;<b>·</b><span class="post_privacy_display"><img  style="height:1em" title="Shared with this group" src="' + icon_cdn + '/group.png" /></span>');
      }
      else if (value.visible == 6)
      {
         container_to_append.append('&nbsp;&nbsp;&nbsp;<b>·</b><span class="post_privacy_display"><img  style="height:1em" title="Shared with this event" src="' + icon_cdn + '/event.png"/></span>');
      }
   
   /*   if ((value.actiontype < 200 || value.actiontype >= 200) && value.actiontype != 50)
      {
         var actionid = value.actionid;
         var lifeisfun = value.life_is_fun;
         postid.children().eq(1).children().eq(3).children().eq(2).append('&nbsp;&nbsp;&nbsp;<b>·</b><span data-toggle="modal"  data-target="#sharemodal" onclick=ui.share_post(\"' + lifeisfun + '\",' + actionid + ')>Share<span>');
      } */
   }

   function response_decode(value, name, dom_id)
   {
      var postid = $('#' + dom_id);
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var pos = $.inArray(myprofileid, value.excited);
      var exciting = 'Exciting';
      var class_type = 'response';
      var fun = 'action.response(this)';
      if (value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
      {
         exciting = 'New-Pinch';
      }
      if (pos != -1)
      {
         exciting = 'Unexciting';
         class_type = 'responsed';
         fun = 'action.responsed(this)';
         if (value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
         {
            exciting = 'Unpinch';
         }
      }
      postid.children().eq(1).children().eq(3).append('<div class="likeclass_json"><span class="excited_people" id="excited_people_'+value.actionid+dom_id+'"></span><span class="post_pointer"></span></div>');
      var excited_count = 0;
      var flag = 0;
      var excited_show_div =  $('#excited_people_'+value.actionid+dom_id);
      if (pos != -1)
      {
         value.excited.splice(pos, 1);
         if (value.excited.length > 1)
         {
            excited_show_div.append('<span>You, </span>');
         }
         else if (value.excited.length == 1)
         {
            excited_show_div.append('<span>You and </span>');
         }
         else
         {
            if (value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
            {
               excited_show_div.append('<span>You have new-pinched</span>');
            }
            else
            {
               excited_show_div.append('<span>You are excited at this</span>');
            }
            flag = 1;
         }
      }
      excited_count = value.excited.length - 3;
      $.each(value.excited, function(index, v)
      {
         if (index < 3)
         {
            excited_show_div.append('<a class="ajax_nav" href="profile.php?id=' + v + '">' + name[v] + '</a>');
            if (index == value.excited.length - 2 && index < 2)
            {
               excited_show_div.append(' and ');
               flag = 2;
            }
            else if (value.excited.length > 2 && index != value.excited.length - 2 && index < 1)
            {
               excited_show_div.append(', ');
               flag = 2;
            }
            else if (index < value.excited.length - 2 && index == 1)
            {
               excited_show_div.append(', ');
               flag = 2;
            }
         }
         else if (excited_count == 1)
         {
            excited_show_div.append(' and <a class="ajax_nav" href="profile.php?id=' + v + '">' + name[v] + '</a> are excited at this');
            flag = 1;
         }
      });
      if (flag == 0 && excited_count > -1) excited_show_div.append(' are excited at this');
      else if (flag == 2) excited_show_div.append(' are excited at this');
   }

   function comment_decode(value, name, pimage, myprofileid, dom_id)
   {
      var postid = $('#' + dom_id);
      var icon_cdn = $('#icon_cdn').attr('value');
      var icon_cdn = $('#icon_cdn').attr('value');
      if (value.comment_count > 3)
      {
         postid.children().eq(1).children().eq(3).append('<div class="comments_show"><input type="hidden" value="' + value.actionid_third + '" /><span class="show_all_comments" onclick="action.show_all_comments(this)" >Show all ' + value.comment_count + ' comments</span></div>');
      }
      $.each(value.com, function(index, com)
      {
         var comid = dom_id + '_' + com.com_actionid;
         var exciting = 'Exciting';
         var fun = 'action.response(this)';
         if (com.com_excited_mine)
         {
            exciting = 'Unexciting';
            fun = 'action.responsed(this)';
         }
         var userid = com.comment.substring(com.comment.indexOf('@[') + 2, com.comment.indexOf(']'));
         com.comment = com.comment.replace('@[' + userid + ']', '<a class="ajax_nav" href="profile.php?id=' + userid + '">' + name[userid] + '</a>');
         postid.children().eq(1).children().eq(3).append('<div class="cclass_json" id="' + comid + '" data="' + com.com_actionid + '" ><a class="ajax_nav" href="profile.php?id=' + com.commentby + '" target="_parent"><img class="lfloat" src =' + pimage[com.commentby] + ' height="32" width="32" /></a><div class="name_35"><div><a class="bold ajax_nav" style="margin-right:0.4em;" href="profile.php?id=' + com.commentby + '" target="_parent">' + name[com.commentby] + '</a><pre>' + ui.get_smiley(ui.see_more(ui.link_highlight(com.comment))) + '</pre></div><div><a class="comment_time_json" href="action.php?actionid=' + value.pageid + '&life_is_fun=' + value.life_is_fun + '"><img src="' + icon_cdn + '/clock.png" width="6" /><span class="time" data="' + com.com_time + '">' + ui.time_difference(com.com_time) + '</span></a><span data=' + com.commentby + ' class = "comment_excite_json" onclick="' + fun + '">' + exciting + '</span></div></div></div>');
         if (com.com_excited)
         {
            $("#" + comid).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="' + com.com_excited + '" onclick="action.response_fetch(this)" >' + com.com_excited + ' excited</span>');
         }
         else
         {
            $("#" + comid).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="0" class="more_excite_json" onclick="action.response_fetch(this)"></span>');
         }
         if (value.postby == myprofileid || com.remove == 1 || (value.hasOwnProperty('admin_feed') && value.admin_feed == 1))
         {
            $("#" + comid).append('<span onclick="ui.post_delete(this)" title="Delete this comment"  class="comment_setting">x</span>');
         }
      });
   }

   function comment_box(value, pimage, myprofileid, dom_id)
   {
      var postid = $('#' + dom_id);
      var myphoto = $('#myprofileimage_hidden').attr('value');
      postid.children().eq(1).children().eq(3).append('<div></div><div class="cclass_box" ><textarea class="commentbox" style="margin:0em 0em 0em 0.5em;" value="" placeholder="Add a comment..." onkeyup="action.comment(this, event)"></textarea></div>');
   }
   return {
      news_deploy: news_deploy,
      question_decode: question_decode,
      group_question_decode: group_question_decode,
      time_tag_decode: time_tag_decode,
      response_decode: response_decode,
      comment_decode: comment_decode,
      comment_box: comment_box
   }
})();