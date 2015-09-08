var action = (function()
{
  var url = 'ajax/write.php';
  var param =
  {
  };
  var data =
  { 
  };
  var tag_name = [];
  var tag_index = [];
  var icon_cdn = $('#icon_cdn').attr('value');
  var last_chat_time = -1;

  function first_loader(page, param)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    $('.no_feed_show').remove();
    if (param.action != '')
    {
      window.ajax_queue.push($.getJSON(url, param, function(data)
      {
        console.log(page);
        if (page == 'search' ||  data.action.length > 0)
        {
          window.load = true;
          switch (page)
          {
          case 'news_json':
            feed.news_deploy(data, '#prev');
            break;
          case 'admin_json':
            feed.news_deploy(data, '#prev');
            break;
          case 'tech_json':
            feed.news_deploy(data, '#prev');
            break;
          case 'quip':
            feed.news_deploy(data, '#prev');
            break;
          case 'notice_json':
            deploy.notice_deploy(data, '#prev');
            break;
          case 'bio':
            deploy.bio_deploy(data);
            break;
          case 'action':
            feed.news_deploy(data, '#prev');
            break;
          case 'profile_json':
            feed.news_deploy(data, '#prev');
            break;
          case 'group_json':
            feed.news_deploy(data, '#prev');
            break;
          case 'page_json':
            feed.news_deploy(data, '#prev');
            break;
          case 'event_json':
            feed.news_deploy(data, '#prev');
            break;
          case 'album':
            deploy.album_deploy(data);
            break;
          case 'photo':
            deploy.photo_deploy(data);
            break;
          case 'file':
            deploy.file_deploy(data);
            break;
          case 'group_file':
            deploy.file_deploy(data);
            break;
          case 'event_file':
            deploy.file_deploy(data);
            break;  
          case 'video':
            deploy.video_deploy(data);
            break;
          case 'group_video':
            deploy.video_deploy(data);
            break;
          case 'event_video':
            deploy.video_deploy(data);
            break;
          case 'pphoto':
            deploy.photo_deploy(data);
            break;
          case 'college_mate':
            deploy.people_deploy(data);
            break;
          case 'new_user':
            deploy.people_deploy(data);
            break;
          case 'following':
            deploy.friend_deploy(data,'#prev');
            break;
          case 'followers':
            deploy.friend_deploy(data,'#prev');
            break;
          case 'group_member':
            deploy.member_deploy(data);
            break;
          case 'guest':
            deploy.guest_deploy(data, '#prev');
            break;
          case 'search':
            callback.search('a', data);
            break;
          default:
            $("#prev").append(data);
            break;
          }
          var oldh = $("#prev").height();
          oldh = parseInt(oldh) + 500;
          $("#center").height(oldh);
          param.start += window.increment;
          $('.load_more').show();
        }
        else
        {
          window.load = false;
          $('#loading').remove();
          if (page == 'news_json')
          {
            $('#prev').append('<div style="text-align:center;"><img width="136" height="136" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/noposts.png" alt=""><div style="font-size:2.4em;color:#adb2bb;font-weight:bold;">No posts to show</div><div style="margin-top:1.45em;"><a style="float:left;margin-left:4em;" class="really_group_join" href="/register.php?hl=friend_suggest">Find Friends</a><a style="margin-right:4em;" class="really_group_join" href="/register.php?hl=group_suggest">Join Groups</a></div></div>');
          }
          else 
          {
/* ***************************** this has to show if no data comes *************************/            
            ui.central_repo_heading(data);
/********************************************************** */            
            $('#prev').append('<div style="text-align:center;" class="no_feed_show"><img src="' + icon_cdn + '/feed.jpg" /><div style="margin-top:1em;text-align:center;">Nothing to show !</div></div>');
          }
        }
      }));
    }
  }

  function actiontype_preview(me)
  {
    var rand = Math.random() * 20;
    param.action = 'actiontype_preview';
    if (rand >= 10)
    {
      param.actiontype = 1201;
      ajax.getJSON_ajax(url, param, me, callback.mood_preview);
/*	param.actiontype = 501;
					ajax.getJSON_ajax(url, param, me, callback.missu_preview); */
    }
    else
    {
/*	param.actiontype = 1401;
					ajax.getJSON_ajax(url, param, me, callback.gift_preview); */
      param.actiontype = 800;
      ajax.getJSON_ajax(url, param, me, callback.tagline_preview);
/*      param.actiontype = 8;
      ajax.getJSON_ajax(url, param, me, callback.friendship_preview); */
    }
  }

  function group_join(me)
  {
    $(me).attr("value", 'Requesting...');
    param.action = 'group_join';
    param.groupid = $(me).attr('id');
    ajax.getJSON_ajax(url, param, me, callback.group_join);
  }

  function new_version_upload(me,event)
  {
    event.preventDefault();
    $('#photo_box').click();
    $('#pform').show();
    $('#new_version_upload_button').show();
  }

  function user_details(me)
  {
    $(me).attr("value", 'Requesting...');
    param.action = 'user_details_fetch';
    param.email = $('#remove_user_email').attr('value');
    ajax.getJSON_ajax(url, param, me, callback.user_details);
  }

  function enable_user_account(me)
  {
    $(me).attr("value", 'Enabling');
    param.action ='enable_user';
    ajax.getJSON_ajax(url, param, me, callback.enable_user);
  }
  function user_delete(me, profileid)
  {
    $(me).attr("value", 'Requesting...');
    param.action = 'user_delete';
    param.profileid = profileid;
    ajax.getJSON_ajax(url, param, me, callback.user_delete);
  }

  function make_moderator(me, profileid)
  {
    $(me).attr("value", 'Requesting...');
    param.action = 'make_moderator';
    param.profileid = profileid;
    ajax.getJSON_ajax(url, param, me, callback.make_moderator);
  }

  function moderator_remove(me, profileid)
  {
    $(me).attr("value", 'Requesting...');
    param.action = 'moderator_remove';
    param.profileid = profileid;
    ajax.getJSON_ajax(url, param, me, callback.moderator_remove);
  }

  function event_join(me)
  {
    $(me).attr("value", 'Joining...');
    param.action = 'event_join';
    param.eventid = $(me).attr('id');
    ajax.getJSON_ajax(url, param, me, callback.event_join);
  }

  function add_friend(me, profileid)
  {
    $(me).attr("value", 'Requesting...');
    param.action = 'add_friend';
    param.profileid = profileid;
    ajax.getJSON_ajax(url, param, me, callback.add_friend);
  }

  function album_upload_button_click(me)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    param.action = 'album_upload';
    $('#mform').ajaxForm(function()
    {
    });
    $('#moment_upload_button').live('click', function()
    {
      var moment_name = $.trim($('#moment_name').attr('value'));
      $("#moment_preview").html('<img src="' + icon_cdn + '/loading.gif" alt="Uploading...."/>');
      $("#mform").ajaxSubmit(
      {
        type: 'json',
        success: function(response)
        {
          var data = $.parseJSON(response);
          callback.album_upload($('#prev'), data);
        }
      });
      return false;
    });
  }

  function birthday_bomb(me, profileid, wish, date)
  {
    $('#birthday_wish_container').html('<span>Wishing...</span>');
    param.action = 'birthday_bomb';
    param.profileid = profileid;
    param.date = date;
    param.wish = wish;
    ajax.getJSON_ajax(url, param, me, callback.birthday_bomb);
  }

  function birthday_fetch(me)
  {
    param.action = 'birthday_bomb_fetch';
    ajax.getJSON_ajax(url, param, me, callback.birthday_select);
  }

  function birthday_all(me)
  {
  }

  function share_post(me)
  {
    param.action = 'share_post';
    param.actionid = $(me).attr('data');
    param.text = $('#reshare_box').val();
    ajax.getJSON_ajax(url, param, me, callback.share_post);
  }

  function comment(me, event)
  {
    var e = event.which;
    if (e == 13)
    {
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var myname = $('#myprofilename_hidden').attr('value');
      var myphoto = $('#myprofileimage_hidden').attr('value');
      var pageid = $(me).parent().parent().parent().attr('data');
      var comment_time = new Date().getTime();
      var comment = ui.escape_tags($.trim($(me).val()));
      var pageid = $(me).parent().parent().parent().attr('data');
      param.action = 'comment';
      param.pageid = pageid;
      param.comment = comment;
      param.tag_index = tag_index;
      param.tag_name = tag_name;
      param.comment_time = comment_time;
      $(me).val('');
      var me = $(me).parent().prev();
      //trying to make comment before ack from server .
      $(me).append('<div class="cclass_json" data="' + comment_time + '" id="nf_post_' + comment_time + '"><a class="ajax_nav" href="profile.php?id=' + myprofileid + '"><img class="lfloat" src =' + myphoto + ' height="32" width="32" /></a><div class="name_35"><div><a class="bold ajax_nav" style="margin-right:0.4em;" href="profile.php?id=' + myprofileid + '" >' + myname + '</a><pre>' + ui.get_smiley(ui.link_highlight(comment)) + '</pre></div><div><a class="comment_time_json" href="action.php?actionid=' + pageid + '&life_is_fun=0b79e9873e5cfb160d3720845df2ba4c63919f9a"><img src="' + icon_cdn + '/clock.png" width="6" /><span class="time" data="' + Math.floor((new Date()).getTime() / 1000) + '">' + ui.time_difference(Math.floor((new Date()).getTime() / 1000)) + '</span></a><span data=' + myprofileid + ' class = "comment_excite_json" onclick="action.response(this)">Exciting</span><span class="more_excite_json" onclick="action.response_fetch(this)" data="0"></span><span id ="' + comment_time + '" class="glyphicon glyphicon-time rfloat" style="color:#ccc;"></span></div></div><span class="comment_setting" onclick="ui.post_delete(this)" >x</span></div>');
      $('.commentbox').css({"height":"2.5em"});
      ajax.getJSON_ajax(url, param, me, callback.comment);
    }
    else
    {
      // *********************
      var q = $.trim($(me).val());
      var me = $(me);
      if (q.indexOf('@') != '-1')
      {
        q = q.substring(1);
        var posx = $(me).parent().position().left;
        var posy = $(me).parent().position().top;
        $('#mention_container').remove();
        $(me).parent().append('<div id="mention_container" style="position:absolute;text-align:left;z-index:1;cursor:pointer;max-height:18em;width:20em;background-color:#ffffff;top:10em;left:10em;"></div>');
        $('#mention_container').css('left', 50 + posx);
        $('#mention_container').css('top', 35 + posy);
        var global_name = JSON.parse($('#myfriends_name_hidden').attr('value'));
        var global_pimage = JSON.parse($('#myfriends_pimage_hidden').attr('value'));
        var count = 0;
        $.each(global_name, function(index, value)
        {
          if (value != null)
          {
            if (q.indexOf(' ') == -1)
            {
              var search_name = value.toLowerCase().split(" ");
              for (var i = 0; i < search_name.length; i++)
              {
                if ((count < 5) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
                {
                  $('#group_invite_' + index).remove();
                  $('#mention_container').append('<div class="con_32" id="group_invite_' + index + '" data="' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="32" height="32" /><div class="name_35">' + global_name[index] + '</div></div>');
                  $('.search_items:first').css('background', '##ebebeb');
                  $('.search_items:first .name_50 a').css('color', 'white');
                  count++;
                }
              }
            }
            else
            {
              if ((count < 5) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                $('#group_invite_' + index).remove();
                $('#mention_container').append('<div class="con_32" id="group_invite_' + index + '" data="' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="35" height="35" /><div class="name_35">' + global_name[index] + '</div></div>');
                $('.search_items:first').css('background', '##ebebeb');
                $('.search_items:first .name_50 a').css('color', 'white');
                count++;
              }
            }
          }
        });
        $('.con_32').live('click', function()
        {
          me.val('@' + global_name[$(this).attr("data")] + ': ');
          tag_name = [];
          tag_index = [];
          tag_name.push('@' + global_name[$(this).attr('data')] + ': ');
          tag_index.push($(this).attr('data'));
        });
      }
      // ****************
    }
  }
//************************** All these search can be combined into one ********************************************************
  function global_search(action, q, request, event)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    var i;
    if (q != $.trim($('#to').attr('value')))
    {
      for (i = 0; i < request.length; i++)
      {
        request[i].abort();
      }
      q = $.trim($('#to').attr('value'));
      request.push($.getJSON('ajax/write.php', {
        action: action,
        q: q
      }, function(data)
      {
        var global_name = JSON.parse($('#session_name_hidden').attr('value'));
        var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
        var global_skill = JSON.parse($('#session_skill_hidden').attr('value'));
        var global_group = JSON.parse($('#session_group_hidden').attr('value'));
        $('#session_name_hidden').attr('value', JSON.stringify($.extend(global_name, data.name)));
        $('#session_pimage_hidden').attr('value', JSON.stringify($.extend(global_pimage, data.pimage)));
        $('#session_skill_hidden').attr('value', JSON.stringify($.extend({},global_skill,data.skillname)));
        $('#session_group_hidden').attr('value', JSON.stringify($.extend({},global_group,data.groupname)));
        global_name = JSON.parse($('#session_name_hidden').attr('value'));
                
        global_skill = JSON.parse($('#session_skill_hidden').attr('value'));
        global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
        global_group = JSON.parse($('#session_group_hidden').attr('value'));
        $('#search_container').html('');
        $('#search_container').append('<table width="100%"><tbody><tr id="result_people" class="search-result_left"><td width="30%" class="text-center bold">People</td><td width="70%"></td></tr><tr id="result_skill" class="search-result_left"><td width="30%" class="text-center bold">Skill</td><td width="70%"></td></tr><tr id="result_group" class="search-result_left"><td width="30%" class="text-center bold">Group</td><td width="70%"></td></tr></tbody></table>')
        var count = 0;
        if(!data.skillname)
        {
            $('#result_skill').hide();
        }
        if(!data.groupname)
        {
            $('#result_group').hide();
        }
        if(!data.name)
        {
            $('#result_people').hide();
        }
        if(!data.email)
        {
            $.each(global_name, function(index, value)
            {
              if (value != null)
              {
                if (q.indexOf(' ') == -1)
                {
                  var search_name = value.toLowerCase().split(" ");
                  for (var i = 0; i < search_name.length; i++)
                  {
                    if ((count < 5) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
                    {
                      $('#search_' + index).remove();
                      $('#result_people td:last').append('<div class="search_items container_50 ajax_nav" href="profile.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                      $('.search_items:first').css('background', '#cccccc');
                      $('.search_items:first .name_50 a').css('color', 'white');
                      count++;
                    }
                  }
                }
                else
                {
                  if ((count < 5) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
                  {
                    $('#search_' + index).remove();
                    $('#result_people td:last').append('<div class="search_items container_50 ajax_nav" href="profile.php?id=' + index + '" id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                    $('.search_items:first').css('background', '#cccccc');
                    $('.search_items:first .name_50 a').css('color', 'white');
                    count++;
                  }
                }

              }
      
            });
            if (count == 0)
              {
                   $('#result_people').hide();                
              }
//****************************** Skill ******************************************

      
        var count_s = 0;
        $.each(global_skill, function(index, value)
            {
              if (value != null)
              {
                if (q.indexOf(' ') == -1)
                {
                  var search_name = value.toLowerCase().split(" ");
                  for (var i = 0; i < search_name.length; i++)
                  {
                    if ((count_s < 5) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
                    {
                      $('#search_' + index).remove();
                      $('#result_skill td:last').append('<div class="search_items container_50 ajax_nav" href="profile.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div><div class="left4">Skill matched :'+value+'</div></div>');
                      $('.search_items:first').css('background', '#cccccc');
                      $('.search_items:first .name_50 a').css('color', 'white');
                      count_s++;
                    }
                  }
                }
                else
                {
                  if ((count_s < 5) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
                  {
                    $('#search_' + index).remove();
                    $('#result_skill td:last').append('<div class="search_items container_50 ajax_nav" href="profile.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div><div class="name_50 ">Skill matched :'+value+'</div></div>');
                    $('.search_items:first').css('background', '#cccccc');
                    $('.search_items:first .name_50 a').css('color', 'white');
                    count_s++;
                  }
                }
              }
            });
//*************************************************************************
//********************************** group search *********************************
 var count_g = 0;
 $.each(global_group, function(index, value)
            {
              if (value != null)
              {
                if (q.indexOf(' ') == -1)
                {
                  var search_name = value.toLowerCase().split(" ");
                  for (var i = 0; i < search_name.length; i++)
                  {
                    if ((count_g < 5) && (search_name[i].toLowerCase().search(q.toLowerCase()) != -1))
                    {
                      $('#search_' + index).remove();
                      $('#result_group td:last').append('<div class="search_items container_50 ajax_nav" href="group.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="group.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="group.php?id=' + index + '">' + value + '</a></div></div>');
                      $('.search_items:first').css('background', '#cccccc');
                      $('.search_items:first .name_50 a').css('color', 'white');
                      count_g++;
                    }
                  }
                }
                else
                {
                  if ((count_g < 5) && (value.toLowerCase().search(q.toLowerCase()) != -1))
                  {
                    $('#search_' + index).remove();
                    $('#result_group td:last').append('<div class="search_items container_50 ajax_nav" href="group.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="group.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="group.php?id=' + index + '">' + value + '</a></div></div>');
                    $('.search_items:first').css('background', '#cccccc');
                    $('.search_items:first .name_50 a').css('color', 'white');
                    count_g++;
                  }
                }
              }
            });
//***********************************************************************************
        }
        else
        {
             $('#result_people td:last').append('<div class="search_items container_50 ajax_nav" href="profile.php?id=' + data.action[0] + '"  id="search_' + data.action[0] + '" data="' + data.action[0] + '"><a class="ajax_nav" href="profile.php?id=' + data.action[0] + '"><img class="lfloat" src=' + global_pimage[data.action[0]] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + data.action[0] + '">' + global_name[data.action[0]] + '</a></div></div>');
        }
      }));
      $('#search_container').html('');
      var global_name = JSON.parse($('#session_name_hidden').attr('value'));
      var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
      var global_skill = JSON.parse($('#session_skill_hidden').attr('value'));
      var global_group = JSON.parse($('#session_group_hidden').attr('value'));
      var count = 0;
      $.each(global_name, function(index, value)
      {
        if (value != null)
        {
          if (q.indexOf(' ') == -1)
          {
            var search_name = value.toLowerCase().split(" ");
            for (var i = 0; i < search_name.length; i++)
            {
              if ((count < 5) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                $('#search_' + index).remove();
                $('#result_people td:last').append('<div class="search_items container_50 ajax_nav" href="profile.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                $('.search_items:first').css('background', '#cccccc');
                $('.search_items:first .name_50 a').css('color', 'white');
                count++;
              }
            }
          }
          else
          {
            if ((count < 5) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
            {
              $('#search_' + index).remove();
              $('#result_people td:last').append('<div class="search_items container_50 ajax_nav" href="profile.php?id=' + index + '" id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
              $('.search_items:first').css('background', '#cccccc');
              $('.search_items:first .name_50 a').css('color', 'white');
              count++;
            }
          }
        }
      });
 //************************************ Skill search *******************************************
  var count_s =0;
  $.each(global_skill, function(index, value)
      {
        if (value != null)
        {
          if (q.indexOf(' ') == -1)
          {
            var search_name = value.toLowerCase().split(" ");
            for (var i = 0; i < search_name.length; i++)
            {
              if ((count_s < 5) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                $('#search_' + index).remove();
                $('#result_skill td:last').append('<div class="search_items container_50 ajax_nav" href="profile.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div><div class="left4">Skill matched :'+value+'</div></div>');
                $('.search_items:first').css('background', '#cccccc');
                $('.search_items:first .name_50 a').css('color', 'white');
                count_s++;
              }
            }
          }
          else
          {
            if ((count_s < 5) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
            {
              $('#search_' + index).remove();
              $('#result_skill td:last').append('<div class="search_items container_50 ajax_nav" href="profile.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div><div class="left4">Skill matched :'+value+'</div></div>');
              $('.search_items:first').css('background', '#cccccc');
              $('.search_items:first .name_50 a').css('color', 'white');
              count_s++;
            }
          }
        }
      });
 //*********************************************************************************************    
 //********************************* group search ************************************************
 var count_g =0 ;
 $.each(global_group, function(index, value)
      {
        if (value != null)
        {
          if (q.indexOf(' ') == -1)
          {
            var search_name = value.toLowerCase().split(" ");
            for (var i = 0; i < search_name.length; i++)
            {
              if ((count_g < 5) && (search_name[i].toLowerCase().search(q.toLowerCase()) != -1))
              {
                $('#search_' + index).remove();
                $('#result_group td:last').append('<div class="search_items container_50 ajax_nav" href="group.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="group.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="group.php?id=' + index + '">' + value + '</a></div></div>');
                $('.search_items:first').css('background', '#cccccc');
                $('.search_items:first .name_50 a').css('color', 'white');
                count_g++;
              }
            }
          }
          else
          {
            if ((count_g < 5) && (value.toLowerCase().search(q.toLowerCase()) != -1))
            {
              $('#search_' + index).remove();
              $('#result_group td:last').append('<div class="search_items container_50 ajax_nav" href="group.php?id=' + index + '"  id="search_' + index + '" data="' + index + '"><a class="ajax_nav" href="group.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="group.php?id=' + index + '">' + value + '</a></div></div>');
              $('.search_items:first').css('background', '#cccccc');
              $('.search_items:first .name_50 a').css('color', 'white');
              count_g++;
            }
          }
        }
      });
 //************************************************************************************************  
      $('#to').keydown(function(e)
      {
        if (e.keyCode == 40)
        {
          $('#search_conainer').focus();
        }
      });
    }
    else if ($.trim($('#to').attr('value')) == '')
    {
      $('#search_container').html('<div class="search_items container_50" data="people"><img class="lfloat" src="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/male.png" width="40" height="40" /><div class="left4"><a class="bold">Search People</a></div></div><div class="search_items container_50" data="group"><img class="lfloat" src="' + icon_cdn + '/group.png" width="40" height="40" /><div class="left4"><a class="bold">Search Group</a></div></div><div class="search_items container_50" data="skill"><img class="lfloat" src="' + icon_cdn + '/skill.png" width="40" height="40" /><div class="left4"><a class="bold">Search Skills</a></div></div><div class="search_items container_50" data="event"><img class="lfloat" src="' + icon_cdn + '/event.png" width="40" height="40" /><div class="left4"><a class="bold">Search Event</a></div></div><div class="search_items container_50" data="post"><img class="lfloat" src="' + icon_cdn + '/post_icon.png" width="40" height="40" /><div class="left4"><a class="bold">Search Post</a></div></div>');
    }
  }
 function colleague_search(action, q, request)
  {
    var icon_cdn = $('#chat_search_box').val();
    var i;
    if (q != $.trim($('#chat_search_box').val()))
    {
      for (i = 0; i < request.length; i++)
      {
        request[i].abort();
      }
      q = $.trim($('#chat_search_box').val());
      request.push($.getJSON('ajax/write.php', {
        action: action,
        q: q
      }, function(data)
      {
        var global_name = JSON.parse($('#session_name_hidden').attr('value'));
        var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
        var global_tagline = JSON.parse($('#session_tagline_hidden').attr('value'));
        $('#session_name_hidden').attr('value', JSON.stringify($.extend({},global_name, data.name)));
        $('#session_pimage_hidden').attr('value', JSON.stringify($.extend({},global_pimage, data.pimage)));
        $('#session_tagline_hidden').attr('value', JSON.stringify($.extend({},global_tagline, data.tagline)));
        global_name = JSON.parse($('#session_name_hidden').attr('value'));
        global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
        var count = 0;
        $.each(global_name, function(index, value)
        {
          if (value != null)
          {
            if (q.indexOf(' ') == -1)
            {
              var search_name = value.toLowerCase().split(" ");
              for (var i = 0; i < search_name.length; i++)
              {
                var name = global_name[index];
                if ((count < 9) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
                {
                  var name = global_name[index];
                  $('#friend_' + index).remove();
                  $('.online_user').append('<div class="chat_user" data="'+index+'" id="friend_'+index+'"><img class="online_photo" height="30" width="30" src="'+global_pimage[index]+'"><span class="online_name">'+global_name[index]+'</span><input type="hidden" value="'+global_name[index]+'"></div>');
                  count++;                
                }
              }
            }
            else
            {
              if ((count < 9) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                var name = global_name[index];
                  $('#friend_' + index).remove();
                  $('.online_user').append('<div class="chat_user" data="'+index+'" id="friend_'+index+'"><img class="online_photo" height="30" width="30" src="'+global_pimage[index]+'"><span class="online_name">'+global_name[index]+'</span><input type="hidden" value="'+global_name[index]+'"></div>');
                  
                count++;
              }
            }
          }
        });
      }));
      var global_name = JSON.parse($('#session_name_hidden').attr('value'));
      var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
      var count = 0;
      $.each(global_name, function(index, value)
      {
        if (value != null)
        {
          if (q.indexOf(' ') == -1)
          {
            var search_name = value.toLowerCase().split(" ");
            for (var i = 0; i < search_name.length; i++)
            {
              if ((count < 9) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                var name = global_name[index];
                  $('#friend_' + index).remove();
                  $('.online_user').append('<div class="chat_user" data="'+index+'" id="friend_'+index+'"><img class="online_photo" height="30" width="30" src="'+global_pimage[index]+'"><span class="online_name">'+global_name[index]+'</span><input type="hidden" value="'+global_name[index]+'"></div>');
                  
                count++;
              }
            }
          }
          else
          {
            if ((count < 9) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
            {
              var name = global_name[index];
                  $('#friend_' + index).remove();
                  $('.online_user').append('<div class="chat_user" data="'+index+'" id="friend_'+index+'"><img class="online_photo" height="30" width="30" src="'+global_pimage[index]+'"><span class="online_name">'+global_name[index]+'</span><input type="hidden" value="'+global_name[index]+'"></div>');
                  
              count++;
            }
          }
        }
      });
    }
  }
  function star_search(action, q, request)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    var i;
    if (q != $.trim($('#hso').attr('value')))
    {
      for (i = 0; i < request.length; i++)
      {
        request[i].abort();
      }
      q = $.trim($('#hso').attr('value'));
      request.push($.getJSON('ajax/write.php', {
        action: action,
        q: q
      }, function(data)
      {
        var global_name = JSON.parse($('#session_name_hidden').attr('value'));
        var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
        $('#session_name_hidden').attr('value', JSON.stringify($.extend(global_name, data.name)));
        $('#session_pimage_hidden').attr('value', JSON.stringify($.extend(global_pimage, data.pimage)));
        global_name = JSON.parse($('#session_name_hidden').attr('value'));
        global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
        $('#star_container').html('');
        var count = 0;
        $.each(global_name, function(index, value)
        {
          if (value != null)
          {
            if (q.indexOf(' ') == -1)
            {
              var search_name = value.toLowerCase().split(" ");
              for (var i = 0; i < search_name.length; i++)
              {
                var name = global_name[index];
                if ((count < 9) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
                {
                  var name = global_name[index];
                  $('#search_' + index).remove();
                  $('#star_container').append('<div class="star_items container_50" id="search_' + index + '" data="' + index + '" pname="' + name + '" ><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                  $('.star_items:first').css('background', '#4C66A4');
                  $('.star_items:first .name_50 a').css('color', 'white');
                  count++;
                }
              }
            }
            else
            {
              if ((count < 9) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                var name = global_name[index];
                $('#search_' + index).remove();
                $('#star_container').append('<div class="star_items container_50" id="search_' + index + '" data="' + index + '" pname="' + name + '" ><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                $('.star_items:first').css('background', '#4C66A4');
                $('.star_items:first .name_50 a').css('color', 'white');
                count++;
              }
            }
          }
        });
      }));
      $('#star_container').html('');
      var global_name = JSON.parse($('#session_name_hidden').attr('value'));
      var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
      var count = 0;
      $.each(global_name, function(index, value)
      {
        if (value != null)
        {
          if (q.indexOf(' ') == -1)
          {
            var search_name = value.toLowerCase().split(" ");
            for (var i = 0; i < search_name.length; i++)
            {
              if ((count < 9) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                var name = global_name[index];
                $('#search_' + index).remove();
                $('#star_container').append('<div class="star_items container_50" id="search_' + index + '" data="' + index + '" pname="' + name + '" ><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                $('.star_items:first').css('background', '#4C66A4');
                $('.star_items:first .name_50 a').css('color', 'white');
                count++;
              }
            }
          }
          else
          {
            if ((count < 9) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
            {
              var name = global_name[index];
              $('#search_' + index).remove();
              $('#star_container').append('<div class="star_items container_50" id="search_' + index + '" data="' + index + '" pname="' + name + '" ><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
              $('.star_items:first').css('background', '#4C66A4');
              $('.star_items:first .name_50 a').css('color', 'white');
              count++;
            }
          }
        }
      });
      $('#hso').keydown(function(e)
      {
        if (e.keyCode == 40)
        {
          $('#search_conainer').focus();
        }
      });
    }
    else if ($.trim($('#hso').attr('value')) == '')
    {
      $('#star_container').html('<div class="star_items container_50" data="people"><img class="lfloat" src="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/male.png" width="30" height="30" /><div class="left4"><a class="bold">Search People</a></div></div>');
    }
    $('.star_items').live('click', function()
    {
      $('#star_co').remove();
      $('#sotw2').append('<div id="star_co" style="width:30em; margin-left:20px;"></div>');
      $('#hso').attr('value', $(this).attr('pname'));
      $('#hso').attr('pid', $(this).attr('data'));
      $('#star_container').hide();
      $('#star_co').html('<br><textarea id="star_c"  autocomplete="off" style="width:20em;height:7em;" class="form-control" placeholder="Add Contribution"></textarea><input type="submit" style="margin-top:-64px;" onclick="action.addstar(this)" value="Add Star" id="add_star_button" title="Add Star" />');
      $('#hso').keyup(function()
      {
        $('#star_co').remove();
        $('br').remove();
        $('#add_star_button').remove();
        $('#star_container').show();
      });
    });
  }

  function md_search(action, q, request)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    var i;
    if (q != $.trim($('#mdadd').attr('value')))
    {
      for (i = 0; i < request.length; i++)
      {
        request[i].abort();
      }
      q = $.trim($('#mdadd').attr('value'));
      request.push($.getJSON('ajax/write.php', {
        action: action,
        q: q
      }, function(data)
      {
        var global_name = JSON.parse($('#session_name_hidden').attr('value'));
        var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
        $('#session_name_hidden').attr('value', JSON.stringify($.extend(global_name, data.name)));
        $('#session_pimage_hidden').attr('value', JSON.stringify($.extend(global_pimage, data.pimage)));
        global_name = JSON.parse($('#session_name_hidden').attr('value'));
        global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
        $('#md_container').html('');
        var count = 0;
        $.each(global_name, function(index, value)
        {
          if (value != null)
          {
            if (q.indexOf(' ') == -1)
            {
              var search_name = value.toLowerCase().split(" ");
              for (var i = 0; i < search_name.length; i++)
              {
                var name = global_name[index];
                if ((count < 9) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
                {
                  var name = global_name[index];
                  $('#search_' + index).remove();
                  $('#md_container').append('<div class="md_items container_50" id="search_' + index + '" data="' + index + '" pname="' + name + '" ><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                  $('.md_items:first').css('background', '#4C66A4');
                  $('.md_items:first .name_50 a').css('color', 'white');
                  count++;
                }
              }
            }
            else
            {
              if ((count < 9) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                var name = global_name[index];
                $('#search_' + index).remove();
                $('#md_container').append('<div class="md_items container_50" id="search_' + index + '" data="' + index + '" pname="' + name + '" ><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                $('.md_items:first').css('background', '#4C66A4');
                $('.md_items:first .name_50 a').css('color', 'white');
                count++;
              }
            }
          }
        });
      }));
      $('#md_container').html('');
      var global_name = JSON.parse($('#session_name_hidden').attr('value'));
      var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
      var count = 0;
      $.each(global_name, function(index, value)
      {
        if (value != null)
        {
          if (q.indexOf(' ') == -1)
          {
            var search_name = value.toLowerCase().split(" ");
            for (var i = 0; i < search_name.length; i++)
            {
              if ((count < 9) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                var name = global_name[index];
                $('#search_' + index).remove();
                $('#md_container').append('<div class="md_items container_50" id="search_' + index + '" data="' + index + '" pname="' + name + '" ><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                $('.md_items:first').css('background', '#4C66A4');
                $('.md_items:first .name_50 a').css('color', 'white');
                count++;
              }
            }
          }
          else
          {
            if ((count < 9) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
            {
              var name = global_name[index];
              $('#search_' + index).remove();
              $('#md_container').append('<div class="md_items container_50" id="search_' + index + '" data="' + index + '" pname="' + name + '" ><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="bold ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
              $('.md_items:first').css('background', '#4C66A4');
              $('.md_items:first .name_50 a').css('color', 'white');
              count++;
            }
          }
        }
      });
      $('#mdadd').keydown(function(e)
      {
        if (e.keyCode == 40)
        {
          $('#search_conainer').focus();
        }
      });
    }
    else if ($.trim($('#mdadd').attr('value')) == '')
    {
      $('#md_container').html('<div class="star_items container_50" data="people"><img class="lfloat" src="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/male.png" width="30" height="30" /><div class="left4"><a class="bold">Search People</a></div></div>');
    }
    $('.md_items').live('click', function()
    {
      $('#mdadd').attr('value', $(this).attr('pname'));
      $('#mdadd').attr('pid', $(this).attr('data'));
      $('#md_container').hide();
      $('#mdadd').keyup(function()
      {
        $('br').remove();
        $('#add_md_button').remove();
        $('#md_container').show();
      });
    });
  }
//**************************************************************************************************************************
  function addstar(me)
  {
    param.action = 'star_of_the_week';
    param.profileid = $('#hso').attr('pid');
    param.contribution = $('#star_c').attr('value');
    if (param.addstar != '')
    {
      $(me).attr('value', 'Adding');
      ajax.getJSON_ajax(url, param, me, callback.addstar);
    }
  }

  function addmd(me)
  {
    param.action = 'set_MD';
    var id = $('#mdadd').attr('pid');
    if (id == '')
    {
      param.value = $('#mdadd').attr('value');
      $(me).attr('value', 'Adding');
      ajax.getJSON_ajax(url, param, me, callback.addmd);
    }
    else
    {
      param.id = $('#mdadd').attr('pid');
      param.value = $('#mdadd').attr('value');
      $(me).attr('value', 'Adding');
      ajax.getJSON_ajax(url, param, me, callback.addmd);
    }
  }

  function option(me, event)
  {
    var e = event.which;
    var opt = $.trim($(me).attr('value'));
    if (opt != '')
    {
      if (e == 13)
      {
        $(me).parent().append('<div class="ask_option">' + opt + '<span onclick="ui.parentRemove(this)" class="glyphicon glyphicon-remove rfloat pointer"></span></div>');
        $(me).attr('value', '');
      }
    }
  }

  function option_add(me, event)
  {
    var e = event.which;
    var opt = $.trim($(me).attr('value'));
    if (opt != '')
    {
      if (e == 13)
      {
        param.action = 'option_add';
        param.option = opt;
        $(me).attr('value', '');
        param.pageid = $(me).parent().parent().parent().parent().attr('data');
        ajax.getJSON_ajax(url, param, me, callback.option_add);
      }
    }
  }

  function answer(me, pageid, optionid)
  {
    param.action = 'answer';
    param.optionid = optionid;
    param.pageid = pageid;
    ajax.getJSON_ajax(url, param, me, callback.answer);
  }

  function question_button(me)
  {
    if ($('#question_box').val() != '')
    {
      var option = [];
      $('.ask_option').each(function(elem)
      {
        option.push($(this).html());
      });
      param.action = 'post_question';
      param.question = $('#question_box').val();
      param.option = option;
      param.profileid = $('#profileid_hidden').attr('value').trim();
      ajax.getJSON_ajax(url, param, me, callback.question);
    }
  }

  function group_question_button(me)
  {
    if ($('#question_box').val() != '')
    {
      var option = [];
      $('.ask_option').each(function(elem)
      {
        option.push($(this).html());
      });
      param.action = 'group_post_question';
      param.question = $('#question_box').val();
      param.option = option;
      param.profileid = $('#profileid_hidden').attr('value').trim();
      ajax.getJSON_ajax(url, param, me, callback.question);
    }
  }

  function response_fetch(me)
  {
    param.action = 'response_fetch';
    param.pageid = $(me).parent().parent().parent().attr('data');
    $("#more_excite_people").remove();
    $('body').append('<div id="more_excite_people" ">Retreiving data</div>');
    $('#more_excite_people').append('<span id="diary_close" style="position:absolute;top:1em;right:1em;cursor:pointer;">x</span>');
    data = ajax.getJSON_ajax(url, param, me, callback.response_fetch);
  }

  function answer_people_fetch(me, optionid)
  {
    param.action = 'answer_people_fetch';
    param.optionid = optionid;
    $("#more_excite_people").remove();
    $('body').append('<div id="more_excite_people" >Retreiving data</div>');
    $('#more_excite_people').append('<span id="diary_close" style="position:absolute;top:1em;right:1em;cursor:pointer;">x</span>');
    data = ajax.getJSON_ajax(url, param, me, callback.response_fetch);
  }

  function suggest_know(me)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    $('#friend_req').remove();
    var profileid = $(me).parent().parent().parent().attr('data');
    $('#center, #right , #left , #header').css("opacity", ".4");
    $('body').append('<div style="cursor:pointer;position:fixed;left:45em;top:20em;height:250px;width:36em;background:#f9f9f9;border:.4em solid #7090ab;border-radius:.2em;z-index:189;" id="friend_req"></div>');
    $('#friend_req').append('<span id="know_close" style="position:absolute;top:1em;right:1em;font-size:1.5em;color:black:font-weight:bold;">x</span>');
    $('#friend_req').append('<p align="center"><img src="' + icon_cdn + '/loading.gif" id="loading"></p>');
    $('#know_close').live('click', function()
    {
      $('#loading').remove();
      $('#center, #right , #left , #header').css("opacity", "1");
      $('#friend_req').remove();
    });
    $.getJSON('ajax/write.php', {
      action: 'friend_details_fetch',
      profileid: profileid
    }, function(data)
    {
      $('#loading').remove();
      $.each(data.info, function(index, value)
      {
        $('#friend_req').append('<div class="people" id="' + value.profileid + '" class=""><div style="position:relative;top:1em;left:2em;height:4em;"><div><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="80" width="80" /></a></div><div style="position:relative;top:-7em;left:8.5em;"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a></div>');
        $('#friend_req').append('<div style="position:relative;top:-3em;left:8.5em;">' + value.age + ' years</div>');
        if (value.city != null)
        {
          $('#friend_req').append('<div style="position:relative;top:-2em;left:8.5em;">' + value.city + '</div>');
        }
        if (value.school != null)
        {
          $('#friend_req').append('<div style="position:relative;top:-1em;left:8.5em;">' + value.school + '</div>');
        }
        if (value.college != null)
        {
          $('#friend_req').append('<div style="position:relative;top:-0em;left:8.5em;">' + value.college + '</div>');
        }
        if (value.profession != null)
        {
          $('#friend_req').append('<div style="position:relative;top:1em;left:8.5em;">' + value.profession + '</div>');
        }
      });
    });
  }

  function createCookie(name, value, days)
  {
    if (days)
    {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      var expires = "; expires=" + date.toGMTString();
    }
    else
    var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
  }

  function getCookie(c_name)
  {
    if (document.cookie.length > 0)
    {
      c_start = document.cookie.indexOf(c_name + "=");
      if (c_start != -1)
      {
        c_start = c_start + c_name.length + 1;
        c_end = document.cookie.indexOf(";", c_start);
        if (c_end == -1)
        {
          c_end = document.cookie.length;
        }
        return unescape(document.cookie.substring(c_start, c_end));
      }
    }
    return "";
  }

  function cookie_delete(name)
  {
    document.cookie = name + '=; Max-Age=0'
  }

  function forgot_password(me)
  {
    $('#forgot_password_info').html("Sending Email...");
    param.action = 'forgot_password';
    param.email = $("#forgot_password_email").attr("value");
    ajax.getJSON_ajax(url, param, me, callback.forgot_password);
  }

  function change_password(me)
  {
    $('#change_password_info').html("Updating...");
    param.action = 'change_password';
    param.old_password = $('#old_password').val();
    param.new_password = $('#new_password').val();
    param.confirm_password = $('#confirm_password').val();
    data = ajax.postJSON_ajax(url, param, me, callback.change_password);
  }

  function self_invite(me)
  {
    $('#signup_info').html("Signing Up...");
    param.action = 'self_invite';
    param.email = $('#signup_email').val();
    data = ajax.getJSON_ajax(url, param, me, callback.self_invite);
  }

  function recover_password(me)
  {
    $('#recover_password_info').html("Updating...");
    param.action = 'recover_password';
    param.new_password = $("#pass").val();
    param.confirm_password = $("#confirmpass").val();
    param.email = $("#recover_password_email").val();
    param.id = $("#recover_password_uniqueid").val();
    data = ajax.postJSON_ajax(url, param, me, callback.recover_password);
  }

  function friend_invite(me)
  {
    $('#invite_button').attr('id', 'inviting');
    param.action = 'friend_invite';
    param.email = $('#invite_box').attr('value');
    if (param.email != '')
    {
      $(me).attr('value', 'Inviting');
      ajax.getJSON_ajax(url, param, me, callback.friend_invite);
    }
  }

  function employee_invite(me)
  {
    param.action = 'employee_invite';
    param.email = $('#employee_invite_box').attr('value');
    if (param.email != '')ui.chat_time_show(this)
    {
      $(me).attr('value', 'Inviting');
      ajax.getJSON_ajax(url, param, me, callback.employee_invite);
    }
  }
  
  function group_invite_email(me)
  {
    param.action = 'group_invite_email';
    param.email = $('#employee_invite_box').attr('value');
	param.groupid = $('#profileid_hidden').attr('value');
    if (param.email != '')
    {
      $(me).attr('value', 'Inviting');
      ajax.getJSON_ajax(url, param, me, callback.group_invite_email);
    }
  }

  function usefullinks(me, title, link)
  {
    param.action = 'usefullinks';
    param.links = link;
    param.title = title;
    if (param.links != '')
    {
      $(me).attr('value', 'Posting');
      ajax.getJSON_ajax(url, param, me, callback.usefullinks);
    }
  }

  function usefullinks_fetch(me)
  {
    param.action = 'usefullinks_fetch';
    ajax.getJSON_ajax(url, param, me, callback.usefullinks_fetch);
  }

  function usefullinks_load(me)
  {
    param.action = 'usefullinks_fetch';
    ajax.getJSON_ajax(url, param, me, callback.usefullinks_load);
  }

  function usefullinks_delete_positive(me, actionid)
  {
    $('.prompt_button').html('');
    param.action = 'usefullink_delete';
    param.link_id = actionid;
    data = ajax.getJSON_ajax(url, param, me, callback.usefullinks_delete);
  }

  function star_of_the_week_fetch(me)
  {
    param.action = 'star_of_the_week_fetch';
    ajax.getJSON_ajax(url, param, me, callback.sotw_fetch);
  }

  function sotw_load(me)
  {
    param.action = 'star_of_the_week_fetch';
    ajax.getJSON_ajax(url, param, me, callback.sotw_load);
  }

  function md_load(me)
  {
    param.action = 'md_load';
    ajax.getJSON_ajax(url, param, me, callback.md_load);
  }

  function star_remove(me, profileid)
  {
    $(me).attr("value", 'Requesting...');
    param.profileid = profileid;
    param.action = 'star_remove';
    ajax.getJSON_ajax(url, param, me, callback.star_remove);
  }

  function md_remove(me, profileid)
  {
    $(me).attr("value", 'Requesting...');
    param.profileid = profileid;
    param.action = 'md_remove';
    ajax.getJSON_ajax(url, param, me, callback.md_remove);
  }

  function doc_remove(me, docid)
  {
    param.docid = docid;
    param.action = 'group_pinned_doc_remove';
    ajax.getJSON_ajax(url, param, me, callback.doc_remove);
  }

  function flash_board_fetch(me)
  {
    param.action = 'flash_board_fetch';
    ajax.getJSON_ajax(url, param, me, callback.flash_board_fetch);
  }

  function csv_fetch(me)
  {
    param.action = 'employee_invite_file_upload';
    ajax.getJSON_ajax(url, param, me, callback.csv_fetch);
  }

  function document_fetch(me, groupid)
  {
    param.action = 'group_pinned_doc_fetch';
    param.groupid = groupid;
    ajax.getJSON_ajax(url, param, me, callback.document_fetch);
  }
 /* function group_doc_fetch(me,groupid)
  {
    param.action = 'group_doc_fetch';
    param.groupid = groupid.trim();
    ajax.getJSON_ajax(url, param, me, callback.group_doc_fetch);
  }
  function event_doc_fetch(me,eventid)
  {
    param.action = 'event_doc_fetch';
    param.eventid = eventid.trim();
    ajax.getJSON_ajax(url, param, me, callback.event_doc_fetch);
  }
  */
  function doc_load(me, groupid)
  {
    param.action = 'group_pinned_doc_fetch';
    param.groupid = groupid;
    ajax.getJSON_ajax(url, param, me, callback.doc_load);
  }

  function designation(me)
  {
    param.action = 'info_update';
    param.infotype = 239;
    param.infoadd = $('#designation_box').attr('value');
    if (param.designation != '')
    {
      $(me).attr('value', 'Adding');
      ajax.getJSON_ajax(url, param, me, callback.designation);
    }
  }

  function designation_fetch(me)
  {
    param.action = 'info_fetch';
    param.infotype = 239;
    ajax.getJSON_ajax(url, param, me, callback.designation_fetch);
  }

  function team(me)
  {
    param.action = 'info_update';
    param.infotype = 234;
    param.infoadd = $('#team_box').attr('value');
    if (param.team != '')
    {
      $(me).attr('value', 'Adding');
      ajax.getJSON_ajax(url, param, me, callback.team);
    }
  }

  function team_fetch(me)
  {
    param.action = 'info_fetch';
    param.infotype = 234;
    ajax.getJSON_ajax(url, param, me, callback.team_fetch);
  }

  function designation_delete_positive(me, actionid)
  {
    param.infotype = 239;
    $('.prompt_button').html('');
    param.action = 'info_delete';
    param.info_id = actionid;
    data = ajax.getJSON_ajax(url, param, me, callback.designation_delete);
  }

  function team_delete_positive(me, actionid)
  {
    param.infotype = 234;
    $('.prompt_button').html('');
    param.action = 'info_delete';
    param.info_id = actionid;
    data = ajax.getJSON_ajax(url, param, me, callback.team_delete);
  }

  function pro_stat(me)
  {
    param.action = 'bio_percentage';
    ajax.getJSON_ajax(url, param, me, callback.pro_stat);
  }

  function group_top_influencer(me)
  {
    var profileid = $('#profileid_hidden').attr('value');
    param.action = 'group_top_influencer_fetch';
    param.profileid = profileid;
    ajax.getJSON_ajax(url, param, me, callback.group_top_influencer);
  }

  function friend_match(me)
  {
    var profileid = $('#profileid_hidden').attr('value');
    var myprofileid = $('#myprofileid_hidden').attr('value');
    if (profileid != myprofileid)
    {
      param.action = 'mutual_friend';
      param.profileid = profileid;
      ajax.getJSON_ajax(url, param, me, callback.friend_match);
    }
  }

  function following_load(me)
  {
    param.action = 'following_load';
    param.profileid = profileid;
    var data = ajax.getJSON_ajax(url, param, me, callback.friend_load);
  }

  function followers_load(me)
  {
    param.action = 'followers_load';
    param.profileid = profileid;
    var data = ajax.getJSON_ajax(url, param, me, callback.friend_load);
  }

  function friend_request_fetch(me)
  {
    param.action = 'friend_request_fetch';
    ajax.getJSON_ajax(url, param, me, callback.friend_request_fetch);
  }

  function member_request_fetch(me)
  {
    param.action = 'member_request_fetch';
    param.groupid = $('#profileid_hidden').attr('value');
    ajax.getJSON_ajax(url, param, me, callback.member_request_fetch);
  }

  function friend_accept(me, flag)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    param.action = 'friend_request_accept';
    param.flag = flag;
    var type = $(me).attr('data');
    if (type=="follow_back")
    {
     param.profileid=$(me).attr('id');   
     ajax.getJSON_ajax(url, param, me, callback.friend_accept);
    }
    else
    {                
     param.profileid = $(me).parent().parent().parent().attr('data');
     var me = $(me).parent().parent().parent();
     $(me).html('<img src="' + icon_cdn + '/loading.gif" />');
     $(me).attr('class', 'accepted');
     ajax.getJSON_ajax(url, param, me, callback.friend_accept);
    }                
  }

  function group_invite(me, flag)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    $(me).html('<img src="' + icon_cdn + '/loading.gif" />');
    param.action = 'group_invite';
    param.flag = flag;
    param.eventid = $('#profileid_hidden').attr('value');
    param.profileid = $(me).attr('data');
    ajax.getJSON_ajax(url, param, me, callback.group_invite);
  }

  function event_invite(me, flag)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    $(me).html('<img src="' + icon_cdn + '/loading.gif" />');
    param.action = 'event_invite';
    param.flag = flag;
    param.eventid = $('#profileid_hidden').attr('value');
    param.profileid = $(me).attr('data');
    ajax.getJSON_ajax(url, param, me, callback.group_invite);
  }

  function member_accept(me, flag)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    param.action = 'member_request_accept';
    param.flag = flag;
    param.profileid = $(me).parent().parent().parent().attr('data');
    var me = $(me).parent().parent().parent();
    $(me).html('<img src="' + icon_cdn + '/loading.gif" />');
    $(me).attr('class', 'accepted');
    ajax.getJSON_ajax(url, param, me, callback.member_accept);
  }

  function guest_accept(me, flag)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    param.action = 'guest_accept';
    param.flag = flag;
    param.eventid = $(me).attr('data');
    var me = $(me).parent().parent().parent();
    $(me).html('<img src="' + icon_cdn + '/loading.gif" />');
    ajax.getJSON_ajax(url, param, me, callback.guest_accept);
  }

  function friend_suggest(me, count)
  {
    param.action = 'friend_suggest';
    param.count = count;
    ajax.getJSON_ajax(url, param, me, callback.friend_suggest);
  }

  function friend_suggest_page(me, count)
  {
    param.action = 'friend_suggest';
    param.count = count;
    ajax.getJSON_ajax(url, param, me, callback.friend_suggest_page);
  }

  function group_suggest_page(me, count)
  {
    param.action = 'group_suggest';
    param.count = count;
    ajax.getJSON_ajax(url, param, me, callback.group_suggest_page);
  }

  function group_suggest(me, count)
  {
    param.action = 'group_suggest';
    param.count = count;
    ajax.getJSON_ajax(url, param, me, callback.group_suggest);
  }

  function event_suggest(me, count)
  {
    param.action = 'event_suggest';
    param.count = count;
    ajax.getJSON_ajax(url, param, me, callback.event_suggest);
  }

  function gift(me, gift)
  {
    param.action = 'gift';
    param.profileid = $('#profileid_hidden').attr('value');
    param.gift = gift;
    param.gift_desc = $.trim($('#gift_desc').attr('value'));
    $('#gift_done').hide();
    $('#gift_container').html('<span>Sending your gift...</span>');
    ajax.getJSON_ajax(url, param, me, callback.gift);
  }

  function group_create(me)
  {
    param.action = 'group_create';
    param.name = $('#group_name').attr('value');
    param.description = $('#group_description').attr('value');
    param.privacy = $("#group_privacy").val();
    param.technical = 0;
    if ($('#group_technical:checked').length == 1) param.technical = 1;
    ajax.getJSON_ajax(url, param, me, callback.group_create);
  }

  function groups_fetch(me)
  {
    param.action = 'group_fetch';
    ajax.getJSON_ajax(url, param, me, callback.groups_fetch);
  }

  function praise_fetch(me, profileid)
  {
    param.action = 'praise_fetch';
    param.profileid = profileid;
    ajax.getJSON_ajax(url, param, me, callback.praise_fetch);
  }

  function group_add_fetch(me)
  {
    param.action = 'group_add_fetch';
    ajax.getJSON_ajax(url, param, me, callback.group_add_fetch);
  }

  function groups_suggest_add(me, profileid)
  {
    param.action = 'group_suggest_add';
    param.groupid = profileid;
    ajax.getJSON_ajax(url, param, me, callback.groups_suggest_add);
  }

  function group_suggest_remove(me, profileid)
  {
    param.action = 'group_remove';
    param.groupid = profileid;
    ajax.getJSON_ajax(url, param, me, callback.group_suggest_remove);
  }

  function feedback(me)
  {
    param.action = 'feedback';
    param.name = $('#group_name').attr('value');
    param.description = $('#group_description').attr('value');
    ajax.getJSON_ajax(url, param, me, callback.feedback);
  }

  function contact(me)
  {
    param.action = 'contact';
    param.name = $('#contact_name').attr('value');
    param.email = $('#contact_email').attr('value');
    param.message = $('#contact_message').val();
    param.contact = $('#contact_mobile').attr('value');
    ajax.getJSON_ajax(url, param, me, callback.contact);
  }

  function page_create(me)
  {
    param.action = 'page_create';
    param.name = $('#page_name').attr('value');
    param.description = $('#page_description').attr('value');
    ajax.getJSON_ajax(url, param, me, callback.page_create);
  }

  function group_admin_make(me, priviledge)
  {
    if (priviledge == 1)
    {
      param.action = 'group_admin_make';
    }
    else if (priviledge == 0)
    {
      param.action = 'group_admin_remove';
    }
    else if (priviledge == 2)
    {
      param.action = 'group_member_remove';
    }
    param.profileid = $(me).parent().parent().attr('data');
    param.groupid = $('#profileid_hidden').attr('value');
    ajax.getJSON_ajax(url, param, me, callback.add_friend);
  }

  function group_settings_save(me)
  {
    param.action = 'group_settings_save';
    param.groupid = $('#profileid_hidden').attr('value');
    param.link = $('#group_link').val();
    param.description = $('#group_description').val();
    param.privacy = $("#group_privacy").val();
    param.invite = 0;
    if ($('#group_invite:checked').length == 1) param.invite = 1;
    ajax.getJSON_ajax(url, param, me, callback.group_settings_save);
  }

  function event_settings_save(me)
  {
    param.action = 'event_settings_save';
    param.eventid = $('#profileid_hidden').attr('value');
    param.day = $('#event_day').val();
    param.month = $('#event_month').val();
    param.year = $('#event_year').val();
    param.time = $('#event_time').val();
    param.venue = $('#event_where').val();
    param.description = $('#group_description').val();
    param.privacy = $("#group_privacy").val();
    param.invite = 0;
    if ($('#group_invite:checked').length == 1) param.invite = 1;
    ajax.getJSON_ajax(url, param, me, callback.group_settings_save);
  }

  function event_create(me)
  {
    param.action = 'event_create';
    param.name = $('#event_name').attr('value');
    param.description = $('#event_description').attr('value');
    param.privacy = $("#event_privacy").val();
    param.day = $("#event_day").val();
    param.month = $("#event_month").val();
    param.year = $("#event_year").val();
    param.time = $("#event_time").val();
    param.venue = $("#event_where").val();
    param.invite = 0;
    if ($('#event_invite:checked').length == 1) param.invite = 1;
    ajax.getJSON_ajax(url, param, me, callback.event_create);
  }

  function group_event_create(me)
  {
    param.action = 'group_event_create';
    param.groupid = $('#profileid_hidden').attr('value');
    param.name = $('#event_name').attr('value');
    param.description = $('#event_description').attr('value');
    param.day = $("#event_day").val();
    param.month = $("#event_month").val();
    param.year = $("#event_year").val();
    param.time = $("#event_time").val();
    param.venue = $("#event_where").val();
    ajax.getJSON_ajax(url, param, me, callback.event_create);
  }

  function profile_privacy_update(me)
  {
    param.action = 'profile_privacy_update';
    param.privacy = $(me).attr('value');
    param.field = $(me).attr('data');
    $('#profile_post_privacy_drop').remove();
    ajax.getJSON_ajax(url, param, me, callback.profile_privacy_update);
  }

  function notification_setting_update(me)
  {
    param.action = 'notification_setting_update';
    param.field = $(me).attr('data');
    ajax.getJSON_ajax(url, param, me, callback.notification_setting_update);
  }

  function feature_setting_update(me)
  {
    param.action = 'feature_setting_update';
    param.field = $(me).attr('data');
    ajax.getJSON_ajax(url, param, me, callback.feature_setting_update);
  }

  function email_setting_update(me)
  {
    param.action = 'email_setting_update';
    param.field = $(me).attr('data');
    ajax.getJSON_ajax(url, param, me, callback.notification_setting_update);
  }

  function message(me)
  {
    var profileid = $('#profileid_hidden').attr('value');
    param.profileid = profileid;
    param.action = 'message';
    param.message = $.trim($('#message_textarea').val());
    if (param.message != '')
    {
      $('#message_textarea').val('');
      $('#message_ok').hide();
      $('#message_container').html('<span>Sending...</span>');
      ajax.getJSON_ajax(url, param, me, callback.message);
    }
  }

  function message_drop(me)
  {
    param.action = 'message';
    param.profileid = $('#profileid_hidden').attr('value');
    param.message = $.trim($('#message_textarea').val());
    $('#message_textarea').val('');
    ajax.getJSON_ajax(url, param, me, callback.message_drop);
  }

  function missu_fetch(me)
  {
    param.action = 'missu_fetch';
    ajax.getJSON_ajax(url, param, me, callback.missu_fetch);
  }

  function missu(me)
  {
    $(me).attr('class', 'missed_back');
    $(me).attr('value', 'Missing');
    param.profileid = $(me).attr('data');
    param.action = 'missu';
    ajax.getJSON_ajax(url, param, me, callback.missu);
  }

  function mood_done(me, mood)
  {
    param.action = 'mood';
    param.mood_desc = $.trim($('#mood_desc').attr('value'));
    param.mood = mood;
    if (mood_desc != '' && mood_desc != "Add few more words")
    {
      $('#mood_done').hide();
      $('#mood_container').html('<span>Setting your mood...</span>');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      ajax.getJSON_ajax(url, param, me, callback.mood);
    }
  }

  function photo_upload()
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    $('#pform').ajaxForm(function()
    {
    });
    $("#photo_preview").html('<img src="' + icon_cdn + '/loading.gif" alt="Uploading...."/>');
    $("#pform").ajaxSubmit(
    {
      type: 'json',
      success: function(response)
      {
        var data = $.parseJSON(response);
        callback.photo_upload(me, data);
      }
    });
  }

  function register(me)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    param.action = 'validate_user';
    param.email = $(me).parent().children(0).attr('value');
    param.identifier = $('#identifier_hidden').val();
    $(me).hide();
    $('#info').html('<div class="alert alert-success" role="alert">Registering .Please wait ...</div>');
    $('#signup_button_container').append('<img src="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/loading.gif"  alt="Signing Up..." id ="loading"  />');
    param.name = $('#signup_name').val();
    param.password = $('#signup_password').val();
    param.gender = $('#signup_gender').val();
    param.day = $('#day').val();
    param.month = $('#month').val();
    //param.year = $('#year').val();
    param.designation = $('#signup_designation').val();
    param.team = $('#signup_team').val();
    ajax.postJSON_ajax(url, param, me, callback.register);
  }

  function response(me)
  {
    var pagetype = $(me).parent().parent().parent().children().eq(1).attr('value');
    if (pagetype == '50') $(me).html('Unpinch ');
    else
    $(me).html('Unexciting ');
    $(me).attr('onclick', 'action.responsed(this)');
    $(me).parent().next().children().eq(0).focus();
    param.action = 'response';
    param.pageid = $(me).parent().parent().parent().attr('data');
    me = $(me).parent().children().eq(1);
    ajax.getJSON_ajax(url, param, me, callback.response);
  }

  function responsed(me)
  {
    var pagetype = $(me).parent().parent().parent().children().eq(1).attr('value');
    if (pagetype == '50') $(me).html('New-Pinch ');
    else
    $(me).html('Exciting ');
    $(me).attr('onclick', 'action.response(this)');
    $(me).parent().next().children().eq(0).focus();
    param.action = 'responsed';
    param.pageid = $(me).parent().parent().parent().attr('data');
    me = $(me).parent().children().eq(1);
    ajax.getJSON_ajax(url, param, me, callback.responsed);
  }

  function rtm_load(me)
  {
    var rtm_load = true;
    var start = 50;
    $('#rtm_container').bind('scroll', function()
    {
      if ($('#rtm_container').get(0).scrollTop > $('#rtm_container').get(0).scrollHeight * 0.6 && rtm_load)
      {
        rtm_load = false;
        $.getJSON('ajax/news_json.php', {
          profileid: profileid,
          start: start,
          real_time: 'real_time'
        }, function(data)
        {
          start += 10;
          rtm_load = true;
          real_time_deploy_append(data);
        });
      }
    });
  }
  var request = [],
      i;

  function search(me)
  {
    param.action = 'search';
    param.q = $('#search_key_hidden').attr('value');
    param.filter = $('#filter_hidden').attr('value');
    ajax.getJSON_ajax(url, param, me, callback.search);
  }
  
  function message_send(me, event)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    var user = $(me).parent().children().eq(0).attr('value');
    var name = $('#myprofilename_hidden').attr('value');
    var profileid = $('#profileid_hidden').attr('value');
    var chat_sent_time = new Date().getTime();
    if (event.which == 13 && $.trim($(me).val()))
    {
      typing = true;
      var message = $(me).val();
      var photo = $('#myprofileimage_hidden').attr('value');
      $(me).attr('value', '');
      var database = $('#database_hidden').attr('value');
      var param =
      {
        "profileid": profileid,
        "userid": user,
        "message": message,
        "name": name,
        "photo": photo,
        "database": database,
        "chat_sent_time": chat_sent_time
      }
    //Append the message before ack comes from server .
   $(me).parent().children().eq(3).append('<div class="message_each" id="message_' + chat_sent_time + '"><img class="message_each_photo" title="' + name + '" height="50" width=50 src="' + photo + '"><div class="message_each_message"><pre>' + ui.get_smiley(ui.link_highlight(message)) + '</pre></div><div style="text-align:right;color:gray;" class="message_time_other"><img width="6" src="' + icon_cdn + '/clock.png"><span style="color:gray;" class="time" data="' +chat_sent_time + '">' + ui.time_difference(chat_sent_time) + '</span></div><span id="' + chat_sent_time + '" class="glyphicon glyphicon-time rfloat" style="color:#ccc;"></span></div>');
  $('.sendbox').css({"height": "3em"}); 
   $(me).parent().children().eq(3).scrollTop($('.inboxui_msg').get(0).scrollHeight);
      $.postJSON('/chat/chat_new', param, function(data)
      {
        $.each(data.action, function(index, value)
        {
          action.last_chat_time = value.time;
          $('#chat_' + value.actionid).remove();
           $('#message_' + value.chat_sent_time).attr('id',value.actionid);
           //$('#chat_time_' + value.chat_sent_time).attr('data', value.time);
          // $('#chat_time_' + value.chat_sent_time).html('' + ui.time_difference(value.time) + '');
          $('.message_time_other').append('<span onclick="ui.message_delete(this,' + value.actionid + ')" class="post_setting"></span>');
           $('#' + value.chat_sent_time).removeClass('glyphicon-time');
           $('#' + value.chat_sent_time).addClass('glyphicon-ok');
           $(me).parent().children().eq(3).scrollTop($('.inboxui_msg').get(0).scrollHeight);
         
        });
        
      });
    }
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

  function previous_talk_message(user, chat_start, opening)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    $.getJSON('ajax/write.php', {
      action: 'message_fetch',
      profileid: user,
      start: chat_start
    }, function(data)
    {
      $.each(data.action, function(index, value)
      {
        $('#inbox_' + user).children().eq(3).prepend('<div class="message_each" id=' + value.actionid + '><img class="message_each_photo" title="' + data.name[value.actionby] + '" height="50" width="50" src="' + data.pimage[value.actionby] + '"><div class="message_each_message"></div><div style="text-align:right;color:gray;"><img src="' + icon_cdn + '/clock.png" width="6" /><span style="color:gray;" class="time" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></a></div><span onclick="ui.message_delete(this,' + value.actionid + ')" class="post_setting"></span></div>');
              
        if(value.file == 1)
        {
            var icon_cdn = $('#icon_cdn').attr('value');
            var ext = value.message.split('.').pop();
            var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
            $('#'+ value.actionid+' .message_each_message').append('<pre><img class="lfloat" src="'+fileimage+'" width="25" height="25" /><div><a href="/uploads/'+value.message+'">'+value.message+'</a></div></pre>');
        }
        else
        {
            $('#'+ value.actionid+' .message_each_message').append('<pre>' + ui.get_smiley(ui.link_highlight(value.message)) + '</pre>');
        }
      
    });   
      if (opening)
      {
        if ($('.inboxui_msg').length > 0)
        {
          $('#inbox_'+user).children().eq(3).scrollTop($('.inboxui_msg').get(0).scrollHeight);
        }
      }
      chat_load = true;
    });
  }

  function search_ajax(me)
  {
    var q = $.trim($('#to').attr('value'));
    $('#to').bind('keyup mousedown input', function()
    {
      if (q != $.trim($('#to').attr('value')) && $.trim($('#to').attr('value')) != '')
      {
        for (i = 0; i < request.length; i++)
        {
          request[i].abort();
        }
        q = $.trim($('#to').attr('value'));
        request.push($.getJSON('ajax/search_ajax.php', {
          q: q
        }, function(data)
        {
          $('#session_name_hidden').attr('value', JSON.stringify(data.name));
          $('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
        }));
        $('#search_container').html('');
        var global_name = JSON.parse($('#session_name_hidden').attr('value'));
        var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
        var count = 0;
        $.each(global_name, function(index, value)
        {
          if (value != null)
          {
            if (q.indexOf(' ') == -1)
            {
              var search_name = value.toLowerCase().split(" ");
              for (var i = 0; i < search_name.length; i++)
              {
                if ((count < 9) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
                {
                  $('#search_container').append('<div class="search_items container_50" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                  $('.search_items:first').css('background', '##ebebeb');
                  $('.search_items:first .name_50 a').css('color', 'white');
                  count++;
                }
              }
            }
            else
            {
              if ((count < 9) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
              {
                $('#search_container').append('<div class="search_items container_50" data="' + index + '"><a class="ajax_nav" href="profile.php?id=' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="40" height="40" /></a><div class="left4"><a class="ajax_nav" href="profile.php?id=' + index + '">' + global_name[index] + '</a></div></div>');
                $('.search_items:first').css('background', '##ebebeb');
                $('.search_items:first .name_50 a').css('color', 'white');
                count++;
              }
            }
          }
        });
        $('#to').keydown(function(e)
        {
          if (e.keyCode == 40)
          {
            $('#search_conainer').focus();
          }
        });
      }
    });
  }

  function show_all_comments(me)
  {
    $(me).html('<span style="padding-left:10px;" id="loadtext">Loading...</span>');
    $(me).removeClass();
    param.action = 'show_all_comments';
    param.page = $('#page_hidden').attr('value');
    param.pageid = $(me).parent().parent().parent().attr('data');
    var t = $(me).parent();
    var data = ajax.getJSON_ajax(url, param, me, callback.show_all_comments);
  }

  function suggest_refresh(me)
  {
    $('.suggest_container').remove();
    $('.suggest_container_body').append('<div class="suggest_container" id="suggest_container1"></div><div class="suggest_container" id="suggest_container2"></div><div class="suggest_container" id="suggest_container3"></div><div class="suggest_container" id="suggest_container4"></div><div class="suggest_container" id="suggest_container5"></div><div class="suggest_container" id="suggest_container6"></div>');
    param.action = 'friend_suggest';
    param.count = 6;
    ajax.getJSON_ajax(url, param, me, ui.suggest_deploy);
  }

  function group_suggest_refresh(me)
  {
    $('.group_suggest_container').remove();
    $('.group_suggest_body').append('<div class="group_suggest_container" id="group_suggest_container1"></div><div class="group_suggest_container" id="group_suggest_container2"></div><div class="group_suggest_container" id="group_suggest_container3"></div><div class="group_suggest_container" id="group_suggest_container4"></div><div class="group_suggest_container" id="group_suggest_container5"></div><div class="group_suggest_container" id="group_suggest_container6"></div>');
    param.action = 'group_suggest';
    param.count = 6;
    ajax.getJSON_ajax(url, param, me, ui.group_suggest_deploy);
  }

  function event_suggest_refresh(me)
  {
    $('.event_suggest_container').remove();
    $('.event_suggest_body').append('<div class="event_suggest_container" id="event_suggest_container1"></div><div class="event_suggest_container" id="event_suggest_container2"></div><div class="event_suggest_container" id="event_suggest_container3"></div><div class="event_suggest_container" id="event_suggest_container4"></div><div class="event_suggest_container" id="event_suggest_container5"></div><div class="event_suggest_container" id="event_suggest_container6"></div>');
    param.action = 'event_suggest';
    param.count = 6;
    ajax.getJSON_ajax(url, param, me, ui.event_suggest_deploy);
  }

  function post_delete_positive(me, del_actionid)
  {
    $('.prompt_button').html('');
    param.action = 'post_delete';
    param.del_actionid = del_actionid;
    data = ajax.getJSON_ajax(url, param, me, callback.post_delete);
  }

  function message_delete_positive(me, actionid)
  {
    $('.prompt_button').html('');
    param.action = 'message_delete';
    param.del_actionid = actionid;
    data = ajax.getJSON_ajax(url, param, me, callback.message_delete);
  }

  function bio_item_remove(me, diaryid)
  {
    $(me).parent().remove();
    param.action = 'bio_item_remove';
    param.diaryid = diaryid;
    data = ajax.getJSON_ajax(url, param, me, callback.bio_item_remove);
  }

  function really_add_friend(me)
  {
    var profileid = $(me).parent().parent().parent().attr('data');
    var me = $(me).parent().parent().parent().parent();
    $('#suggest_' + profileid).slideUp("normal", function(){ $(this).remove();} );
    param.action = 'add_friend';
    param.profileid = profileid;
    ajax.getJSON_ajax(url, param, me, callback.add_friend);
    param.action = 'friend_suggest';
    param.count = 1;
    ajax.getJSON_ajax(url, param, me, ui.suggest_single_deploy);
  }

  function really_add_friend_page(me)
  {
    var profileid = $(me).parent().parent().parent().attr('data');
    var me = $(me).parent().parent().parent().parent();
    $('#suggest_' + profileid).slideUp("normal", function(){ $(this).remove();} );
    param.action = 'add_friend';
    param.profileid = profileid;
    param.msg = 'Hi';
    ajax.getJSON_ajax(url, param, me, callback.add_friend);
    param.action = 'friend_suggest';
    param.count = 1;
    ajax.getJSON_ajax(url, param, me, ui.suggest_single_deploy_page);
  }

  function really_going_event(me)
  {
    var eventid = $(me).parent().parent().parent().attr('data');
    var me = $(me).parent().parent().parent().parent();
    $('#suggest_' + eventid).slideUp("normal", function(){ $(this).remove();} );
    param.action = 'event_join';
    param.eventid = eventid;
    ajax.getJSON_ajax(url, param, me, callback.add_friend);
    param.action = 'event_suggest';
    param.count = 1;
    ajax.getJSON_ajax(url, param, me, ui.event_suggest_single_deploy);
  }

  function really_group_join(me)
  {
    var groupid = $(me).parent().parent().parent().attr('data');
    var me = $(me).parent().parent().parent().parent();
    $('#suggest_' + groupid).slideUp("normal", function(){ $(this).remove();} );
    param.action = 'group_join';
    param.groupid = groupid;
    ajax.getJSON_ajax(url, param, me, callback.add_friend);
    param.action = 'group_suggest';
    param.count = 1;
    ajax.getJSON_ajax(url, param, me, ui.group_suggest_single_deploy);
  }

  function really_group_join_page(me)
  {
    var groupid = $(me).parent().parent().parent().attr('data');
    var me = $(me).parent().parent().parent().parent();
    $('#suggest_' + groupid).slideUp("normal", function(){ $(this).remove();} );
    param.action = 'group_join';
    param.groupid = groupid;
    ajax.getJSON_ajax(url, param, me, callback.group_join);
    param.action = 'group_suggest';
    param.count = 1;
    ajax.getJSON_ajax(url, param, me, ui.group_suggest_single_deploy_page);
  }

  function tagline(me)
  {
    var tagline = $('#tagline_box').val();
    if (tagline != '')
    {
      $('#tagline_ok').hide();
      $('#message_container').html('<span>Setting your tagline...</span>');
      param.action = 'tagline_set';
      param.tagline = tagline;
      data = ajax.getJSON_ajax(url, param, me, callback.tagline);
    }
  }

  function group_leave_positive(me)
  {
    param.action = 'group_leave';
    param.groupid = $.trim($('#profileid_hidden').attr('value'));
    data = ajax.getJSON_ajax(url, param, me, callback.group_leave);
  }

  function event_leave(me)
  {
    param.action = 'event_leave';
    param.eventid = $.trim($('#profileid_hidden').attr('value'));
    data = ajax.getJSON_ajax(url, param, me, callback.event_leave);
  }

  function event_cancel_positive(me)
  {
    param.action = 'event_cancel';
    param.eventid = $.trim($('#profileid_hidden').attr('value'));
    data = ajax.getJSON_ajax(url, param, me, callback.event_cancel);
  }

  function unfriend_positive(me)
  {
    param.action = 'unfriend';
    param.profileid = $.trim($('#profileid_hidden').attr('value'));
    data = ajax.getJSON_ajax(url, param, me, callback.unfriend);
  }

  function group_and_event_select(me)
  {
     param.action = 'group_and_event_select';
    var page = $('#page_hidden').attr('value');

     if(page == 'file' || page == 'video')
     {
       data = ajax.getJSON_ajax(url, param, me, callback.group_and_event_select_file);
     }
     else
     {
       data = ajax.getJSON_ajax(url, param, me, callback.group_and_event_select);
     }
  }

  function name_split(name, value)
  {
    var arr = value.split(',');
    var arrayofprofileid = [];
    var len = arr.length;
    //Taking Ids is another array in reverse order
    for (var j = 0; j < len; j++)
    {
      arrayofprofileid.push(arr[len - 1 - j]);
    }
    var totalcount = arrayofprofileid.length;
    var count = 0;
    var names = "";
    for (var i = 0; i < totalcount; i++)
    {
      if (i == 0 && totalcount < 3)
      {
        names = '<span style="font-weight:bold;">' + name[arrayofprofileid[i]] + '</span>';
      }
      else if (i == 0 && totalcount > 2)
      {
        names = '<span style="font-weight:bold;">' + name[arrayofprofileid[i]] + '</span>' + ', ';
      }
      else if (i == 1 && totalcount == 2)
      {
        names = names + ' and ' + name[arrayofprofileid[i]];
      }
      else if (i == 1 && totalcount > 2)
      {
        names = names + name[arrayofprofileid[i]];
      }
      else if (i == 2 && totalcount == 3)
      {
        names = names + ' and ' + name[arrayofprofileid[i]];
      }
      else count = count + 1;
    }
    if (totalcount <= 3) return names;
    else
    return names + ' and ' + count + ' more ';
  }

  function getanalyticdetails(me, value)
  {
    param.action = value;
    data = ajax.getJSON_ajax(url, param, me, callback.getanalyticdetails);
  }

  function friend_fetch()
  {
    var profileid = $('#myprofileid_hidden').attr('value');
    $.getJSON('ajax/write.php', {
      action: 'friend_fetch',
      profileid: profileid
    }, function(data)
    {
      if (data.friend_count)
      {
        $('#myfriends_name_hidden').attr('value', JSON.stringify(data.name));
        $('#myfriends_pimage_hidden').attr('value', JSON.stringify(data.pimage));
        $('#session_tagline_hidden').attr('value', JSON.stringify(data.tagline));
        var global_name = JSON.parse($('#session_name_hidden').attr('value'));
        var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
      //  var global_tagline = JSON.parse($('#session_tagline_hidden').attr('value'));
        var friend_name = JSON.parse($('#myfriends_name_hidden').attr('value'));
        var friend_pimage = JSON.parse($('#myfriends_pimage_hidden').attr('value'));
      //  var friend_tagline = JSON.parse($('#myfriends_tagline_hidden').attr('value'));
        $('#session_name_hidden').attr('value', JSON.stringify($.extend(global_name, friend_name)));
        $('#session_pimage_hidden').attr('value', JSON.stringify($.extend(global_pimage, friend_pimage)));
      //  $('#session_tagline_hidden').attr('value', JSON.stringify(friend_tagline));
        $.each(data.action, function(index, value)
        {
          id = "friend_" + value;
          if ($('#' + id).length == 0)
          {
            $('.online_user').append('<div class="chat_user" data="' + value + '" id="' + id + '"><img class="online_photo" height="30" width="30" src="' + data.pimage[value] + '" /><span class="online_name">' + data.name[value] + '</span><input type="hidden" value="' + data.name[value] + '" /></div>');
          }
        });
      }
      else
      {
        $('#sidebar').remove();
        $('#bottombar').remove();
      }
    });
  }

  function previous_talk(user, chat_start, opening)
  {
    var myprofileid = $('#myprofileid_hidden').attr('value');
    $.getJSON('ajax/write.php', {
      action: 'message_fetch',
      profileid: user,
      start: chat_start
    }, function(data)
    {
      $.each(data.action, function(index, value)
      {
        $('#chat_' + value.actionid).remove();
        if (value.actionby == myprofileid)
        {
          $('#chatbox_' + user).children().eq(3).prepend('<div class="chat_each" id="chat_' + value.actionid + '" onmouseover="ui.chat_time_show(this)" onmouseleave="ui.chat_time_hide(this)"><div class="chat_each_message chat_actionbyme"></div><span class="time chat_time glyphicon glyphicon-time" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></div>');
        }
        else
        {
          $('#chatbox_' + user).children().eq(3).prepend('<div class="chat_each" id="chat_' + value.actionid + '" onmouseover="ui.chat_time_show(this)" onmouseleave="ui.chat_time_hide(this)"><img class="img-thumbnail" src="'+data.pimage[value.actionby]+'" width="35" heigth="35"/><div class="chat_each_message chat_actiononme"></div><span class="time chat_time glyphicon glyphicon-time" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></div>');
        }
        if(value.file == 1)
        {
            var icon_cdn = $('#icon_cdn').attr('value');
            var ext = value.message.split('.').pop();
            var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
            $('#chat_'+ value.actionid+' .chat_each_message').append('<pre><img class="lfloat" src="'+fileimage+'" width="25" height="25" /><div><a  target="_blank" href="/uploads/'+value.message+'">'+value.message+'</a></div></pre>');
        }
        else
        {
            $('#chat_'+ value.actionid+' .chat_each_message').append('<pre>' + ui.get_smiley(ui.link_highlight(value.message)) + '</pre>');
        }
/* Old code
                        	 $('#chatbox_'+user).children().eq(3).prepend('<div class="chat_each" id="chat_'+value.actionid+'" onmouseover="ui.chat_time_show(this)" onmouseleave="ui.chat_time_hide(this)"><img class="chat_each_photo" title="'+data.name[value.actionby]+'" height="25" width="25" src="'+data.pimage[value.actionby]+'"><div class="chat_each_message"><pre>'+ui.get_smiley(ui.link_highlight(value.message))+'</pre></div><span class="time chat_time" data="'+value.time+'">'+ui.time_difference(value.time)+'</span></div>'); 
                        	                             
                        	 */
      });
      if (opening)
      {
        $('#chatbox_' + user).children().eq(3).scrollTop($('.chatboxui_msg').get(0).scrollHeight);
      }
      chat_load = true;
    });
  }

  function real_time()
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    var profileid = $('#myprofileid_hidden').attr('value');
    var database = $('#database_hidden').attr('value');
    var param =
    {
      "profileid": profileid,
      "last_poll_time": last_poll_time_rt,
      "database": database
    }
    $.postJSON('/chat/real_time', param, function(data)
    {
      global_time = Math.floor((new Date()).getTime() / 1000);
      $('#online_hidden').attr('value', JSON.stringify(data.user));
     var tagline = JSON.parse($('#session_tagline_hidden').attr('value'));
     $('#session_tagline_hidden').attr('value', JSON.stringify($.extend({},tagline,data.tag)));
      $('.online_icon').remove();
      $('.chatbox_online_icon').remove();
      if (data.ack)
      {
        $.each(data.user, function(index, value)
        {
          if (value != profileid)
          {
            var id = 'friend_' + value;
            $('#' + id).remove();
            $('.' + id).remove();
            $('.online_user').prepend('<div class="chat_user iamonline ' + id + '" data="' + value + '" id="' + id + '"><img class="online_photo" height="30" width="30" src="' + data.photo[value] + '" /><span class="online_name">' + data.name[value] + '</span><input type="hidden" value="' + data.name[value] + '" /><img class="online_icon" src="' + icon_cdn + '/online.png" /></div>');
            $('#chatbox_' + value).children().eq(2).html('<img class="chatbox_online_icon" src="' + icon_cdn + '/online.png" /><a class="ajax_nav" href="profile.php?id=' + value + ' ">' + data.name[value] + '</a>');
          }
        });
      }
      var req_count = 0,
          notice_count = 0,
          message_count = 0;
      if (data.count != 0)
      {
        var notice_count = parseInt(data.count) + parseInt($('#numnotice').attr('data'));
        $('#numnotice').html(notice_count);
        $('#numnotice').attr('data', notice_count);
      }
      if (data.message_count != 0)
      {
        var message_count = parseInt(data.message_count) + parseInt($('#message_count').attr('data'));
        $('#message_count').html(message_count);
        $('#message_count').attr('data', message_count);
      }
      if (data.request_count != 0)
      {
        var req_count = parseInt(data.request_count) + parseInt($('#request_count').attr('data'));
        $('#request_count').html(req_count);
        $('#request_count').attr('data', req_count);
      } //To check if we can add the count to existing count.
      var total_count = notice_count + message_count + req_count;
      if (total_count) $(document).attr('title', '(' + total_count + ') Quipmate');
      //deploy.real_time_deploy(data); 
      $.each(data.action, function(index, value)
      {
        var dom_id = 'lf_' + value.pageid;
        deploy.action_decode('live_feed', value, data.name, data.photo, '#rtm_container', dom_id, 1, 0);
      });
      var response = jQuery.parseJSON(data.response);
      var page = $('#page_hidden').attr('value');
      if(page == 'home' || page == 'news_json')
      {
      if (response) feed.news_deploy(response, '#prev', 0, 0);
      }
      last_poll_time_rt = data.last_poll_time
      setTimeout(real_time, 0);
    });
  }

  function individualChat()
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    var random = $('#random_hidden').attr('value');
    var myprofileid = $('#myprofileid_hidden').attr('value');
    var database = $('#database_hidden').attr('value');
    var param =
    {
      "profileid": myprofileid,
      "random": random,
      "database": database,
      "last_chat_time": last_chat_time
    }

    $.postJSON('/chat/chat_update', param, function(data)
    {
      var chat_notify = false;
      var icon_cdn = $('#icon_cdn').attr('value');
      $.each(data.action, function(index, value)
      {
        if (value.type == 1)
        {
          if ($('#chatbox_' + value.sentto).length != 0)
          {
            $('#chatbox_' + value.sentto).children().eq(2).html('<img class="chatbox_online_icon" src="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/online.png" /><a class="ajax_nav" href="profile.php?id=' + value.sentby + ' ">' + data.name[value.sentby] + '</a> saw your message');
          }
        }
        else if (value.type == 2)
        {
          if ($('#chatbox_' + value.sentby).length != 0)
          {
            $('#chatbox_' + value.sentby).children().eq(2).html('<img class="chatbox_online_icon" src="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/online.png" /><a class="ajax_nav" href="profile.php?id=' + value.sentby + ' ">' + data.name[value.sentby] + '</a> is typing');
          }
        }
        else if (value.type == 3)
        {
          if ((!document.hasFocus() || sound_flag == 1) && value.sentto == myprofileid)
          {
            ui.chat_notify = true;
            ui.chat_new_notify(data.name[value.sentby], value.message,ui.chat_notify);
            ui.chat_sound_play();
            sound_flag = 0;
          }
          else
          {
             $(document).attr('title', 'Quipmate');
          }
          var you = value.sentby,
              unread = 1;
          if (value.sentby == myprofileid)
          {
            you = value.sentto;
            unread = 0;
          }
          if ($('#chatbox_' + you).length == 0)
          {
            var is_online = false;
            if ($('#friend_' + you).children().eq(3).length > 0) is_online = true;
            ui.createChatBoxUI(you, data.name[you], is_online);
            action.previous_talk(you, 0, 1);
            if (!$('#chatbox_' + you).is(':focus') && unread == 1) ui.chat_unread(you);
          }
          else
          {
            $('#chatbox_' + value.you).children().eq(2).html('<img class="chatbox_online_icon" src="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/online.png" /><a class="ajax_nav" href="profile.php?id=' + you + ' ">' + data.name[you] + '</a>');
            $('#chat_' + value.actionid).remove();
            if (value.sentby == myprofileid)
            {
              $('#chatbox_' + you).children().eq(3).append('<div class="chat_each" id="chat_' + value.actionid + '" onmouseover="ui.chat_time_show(this)" onmouseleave="ui.chat_time_hide(this)"><div class="chat_each_message chat_actionbyme"><pre>' + ui.get_smiley(ui.link_highlight(value.message)) + '</pre></div><span class="time chat_time" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></div>');
            }
            else
            {
              if(value.file)
              {
                var icon_cdn = $('#icon_cdn').attr('value');
                var filename = value.message;
                var ext = filename.split('.').pop();
                var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
                $('#chatbox_' + you).children().eq(3).append('<div class="chat_each" id="chat_' + value.actionid + '" onmouseover="ui.chat_time_show(this)" onmouseleave="ui.chat_time_hide(this)"><img class="img-thumbnail" src="'+data.photo[value.sentby]+'" width="35" heigth="35"/><div class="chat_each_message chat_actiononme"><pre><img class="lfloat" src="'+fileimage+'" width="25" height="25" /><a href="/uploads/'+value.message+'" target="_blank"><div>'+value.message+'</div></a></pre></div><span class="time chat_time" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></div>');  
              } 
              else
              {
              $('#chatbox_' + you).children().eq(3).append('<div class="chat_each" id="chat_' + value.actionid + '" onmouseover="ui.chat_time_show(this)" onmouseleave="ui.chat_time_hide(this)"><img class="img-thumbnail" src="'+data.photo[value.sentby]+'" width="35" heigth="35"/><div class="chat_each_message chat_actiononme"><pre>' + ui.get_smiley(ui.link_highlight(value.message)) + '</pre></div><span class="time chat_time" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></div>');
              }
            }
            $('#chatbox_' + you).children().eq(3).scrollTop($('.chatboxui_msg').get(0).scrollHeight);
            if (!$('#chatbox_' + you).is(':focus') && unread == 1) ui.chat_unread(you);
          }
          action.last_chat_time = value.time;
        }

      });
      setTimeout(individualChat, 0);
    });
  }

  function image_viewer(me)
  {
    $('#image_con').remove();
    var actionid = $(me).attr('id');
    var life_is_fun = $(me).parent().children().eq(0).attr('value');
    var page = $('')
    if ($(me).parent().attr('class') == 'photo_feed')
    {
      var profileid = $(me).parent().children().eq(0).attr('value');
      var actiontype = $(me).parent().children().eq(1).attr('value');
    }
    else
    {
      var profileid = $(me).parent().parent().parent().children().eq(0).attr('value');
      var actiontype = $(me).parent().parent().parent().children().eq(1).attr('value');
    }
    if (actiontype == 5) actiontype = 6; // if it is an album, comment and exciting as if doing on a normal photo
    var file = $(me).attr('data');
    var maxw = $(window).width() - 470;
    var maxh = $(window).height() - 20;
    var myphoto = $('#myprofileimage_hidden').attr('value');
    $('body').css('overflow', 'hidden');
    $('body').append('<div id="bg_first" class ="img_viewer_bg" ></div>');
    if ($(me).hasClass('video_play'))
    {
      var videoid = $(me).parent().children().eq(0).attr('value');
      $('body').append('<div id="image_con" class="container-fluid" ><div id="container_for_image" class="col-md-7" style="height:' + maxh + 'px;float:none;"><iframe id="video_playing" height ="' + maxh + '" width ="' + maxw + '" src="https://www.youtube.com/embed/' + videoid + '?autoplay=1" frameborder="0"></iframe></div><div style="height:' + maxh + 'px;"><div class="img_viewer_div col-md-4"  data=' + actionid + ' id="viweable_sidebar" ><input type="hidden" value="' + profileid + '"/><input type="hidden" value="' + actiontype + '"/></div></div></div>');
    }
    else
    {
      $('body').append('<div id="image_con" class="container-fluid"  ><div id="container_for_image" class="col-md-7" style="height:' + maxh + 'px;float:none;"><img src="thumbnail.php?file=' + file + '&maxw=' + maxw + '&maxh=' + maxh + '"/></div><div class="img_viewer_div col-md-4" style="height:' + maxh + 'px;"><div data=' + actionid + ' id="viweable_sidebar"><input type="hidden" value="' + profileid + '"/><input type="hidden" value="' + actiontype + '"/></div></div></div>');
    }
    //<span class="glyphicon glyphicon-chevron-right pointer next-image"></span>
    //<span class="glyphicon glyphicon-chevron-left pointer prev-image"></span>        
    $.getJSON('ajax/write.php', {
      action: 'action_fetch_life_is_not_always_fun',
      actionid: actionid,
      life_is_fun: life_is_fun
    }, function(data)
    {
      $.each(data.action, function(index, value)
      {
        if (!value.page) value.page = '';
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
          fun = 'action.responsed(me)';
          if (value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
          {
            exciting = 'Unpinch';
          }
        }
        $('#viweable_sidebar').append('<a class="ajax_nav" href="profile.php?id=' + value.actionby + ' " ><img class="lfloat" src =' + data.pimage[value.actionby] + ' height="50" width="50" /></a><div class="name_50_viewable"><a class="bold ajax_nav left1" href="profile.php?id=' + value.actionby + ' " >' + data.name[value.actionby] + '</a><div id="image_con_close">x</div><div class="left1">' + value.page + '</div><div class="time_tag_json"><span onclick="' + fun + '" class="' + class_type + '" style="color:#336699;">' + exciting + ' </span><a href="action.php?actionid=' + value.pageid + '&life_is_fun=' + value.life_is_fun + '"><img src="' + icon_cdn + '/clock.png" width="6" /><span class="time" data="' + value.time + '">' + ui.time_difference(value.time) + '</span></a></div></div>');
        $('#viweable_sidebar').children().eq(3).append('<div class="likeclass_json"><span id="viewable_sidebar_response" class="excited_people"></span><span class="post_pointer"></span></div>');
        var excited_count = 0;
        if (pos != -1)
        {
          value.excited.splice(pos, 1);
          if (value.excited.length > 1)
          {
            $('#viewable_sidebar_response').append('<span>You, </span>');
          }
          else if (value.excited.length == 1)
          {
            $('#viewable_sidebar_response').append('<span>You and </span>');
          }
          else
          {
            if (value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
            {
              $('#viewable_sidebar_response').append('<span>You have new-pinched</span>');
            }
            else
            {
              $('#viewable_sidebar_response').append('<span>You are excited at this</span>');
            }
          }
        }
        excited_count = value.excited.length - 3;
        $.each(value.excited, function(index, v)
        {
          if (index < 3)
          {
            $('#viewable_sidebar_response').append('<a class="ajax_nav" href="profile.php?id=' + v + '">' + data.name[v] + '</a>');
            if (index == value.excited.length - 2 && index < 2)
            {
              $('#viewable_sidebar_response').append(' and ');
            }
            else if (value.excited.length > 2 && index != value.excited.length - 2 && index < 1)
            {
              $('#viewable_sidebar_response').append(', ');
            }
            else if (index < value.excited.length - 2 && index == 1)
            {
              $('#viewable_sidebar_response').append(', ');
            }
          }
          else if (excited_count == 1)
          {
            $('#viewable_sidebar_response').append(' and <a class="ajax_nav" href="profile.php?id=' + v + '">' + data.name[v] + '</a>');
          }
        });
        if (excited_count > 1)
        {
          $('#viewable_sidebar_response').append(' and ' + excited_count + ' more');
        }
        if (value.comment_count > 3)
        {
          $('#viweable_sidebar').children().eq(3).append('<div class="comments_show"><input type="hidden" value="' + value.actionid_third + '" /><span class="show_all_comments" onclick="action.show_all_comments(this)" >Show all ' + value.comment_count + ' comments</span></div>');
        }
        $.each(value.com, function(index, com)
        {
          var comid = 'pf_' + value.actionid + '_' + com.com_actionid;
          var exciting = 'Exciting';
          var fun = 'action.response(this)';
          if (com.com_excited_mine)
          {
            exciting = 'Unexciting';
            fun = 'action.responsed(this)';
          }
          $('#viweable_sidebar').children().eq(3).append('<div class="cclass_json" id="' + comid + '" data="' + com.com_actionid + '" ><a class="ajax_nav" href="profile.php?id=' + com.commentby + '" target="_parent"><img class="lfloat" src =' + data.pimage[com.commentby] + ' height="32" width="32" /></a><div class="name_35"><div><a class="bold ajax_nav" href="profile.php?id=' + com.commentby + '" target="_parent">' + data.name[com.commentby] + '</a> ' + ui.see_more(ui.get_smiley(ui.link_highlight(com.comment))) + '</div><div><a class="comment_time_json" href="action.php?actionid=' + value.pageid + '&life_is_fun=' + value.life_is_fun + '"><img src="' + icon_cdn + '/clock.png" width="6" /><span class="time" data="' + com.com_time + '">' + ui.time_difference(com.com_time) + '</span></a><span data=' + com.commentby + ' class = "comment_excite_json" onclick="' + fun + '">' + exciting + '</span></div></div></div>');
          if (com.com_excited)
          {
            $("#" + comid).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="' + com.com_excited + '" onclick="action.response_fetch(this)" >' + com.com_excited + ' excited</span>');
          }
          else
          {
            $("#" + comid).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="0" class="more_excite_json" onclick="action.response_fetch(this)"></span>');
          }
          if (value.postby == myprofileid || com.commentby == myprofileid)
          {
            $("#" + comid).append('<span onclick="ui.post_delete(this)" class="comment_setting">x</span>');
          }
        });
        $('#viweable_sidebar').children().eq(3).append('<div></div><div class="cclass_box" ><input style="margin:0em 0em 0em 0.5em;"class="commentbox" onkeydown="action.comment(this,event)" type="text" value="" placeholder="Add a comment..." /></div>');
      });
    });
  }

  function praise_send(me)
  {
      var letter_title = $('#letter_title').attr('value');
      var letter_content = $('#letter_content').val();
      var badgeid = $('#badge_id').attr('value');
      var profileid = $('#profileid_hidden').attr('value');
      $.getJSON('ajax/write.php', {
        action: 'praise',
        letter_title: letter_title,
        letter_content: letter_content,
        profileid: profileid,
        badgeid : badgeid
      }, function(data)
      {
        if (data.ack)
        {
          $('#praisemodal').modal('hide');
        }
      });
  }

  function direct_to_md_send(me)
  {
    var wish = $('#birthday_wish_box').val();
    if (wish != '')
    {
      $('#letter_send').hide();
      var letter_title = $.trim($('#letter_title').attr('value'));
      var letter_content = $.trim($('#letter_content').val());
      var letter_open = 0;
      if ($('#letter_open:checked').length == 1) letter_open = 1;
      if (letter_content != '' && letter_title != '')
      {
        $('#direct_to_md__container').html('<span>Sending...</span>');
        $.getJSON('ajax/write.php', {
          action: 'direct_letter',
          letter_title: letter_title,
          letter_content: letter_content,
          letter_open: letter_open
        }, function(data)
        {
          if (data.ack)
          {
            $('#direct_to_md__container').html('Letter has been sent to the Managaing director.');
            $('.right_pointer_container').fadeOut(2000);
          }
        });
      }
    }
  }

  function see_all_birthday(me)
  {
    location.hash = '/birthday';
    $.getJSON('ajax/write.php', {
      action: 'birthday_select_all'
    }, function(data)
    {
      $('#center').html('<div class="right_item" ><div class="subtitle" style="">Colleagues\' Birthday</div></div>');
      $('#center').append('<table></table>');
      var i = 0;
      $.each(data.event, function(index, value)
      {
        if (i % 5 == 0)
        {
          $('table').append('<tr></tr>');
        }
        $('tr:last').append('<td class="friends_birthday_show text-center" ><a  class="ajax_nav" href="profile.php?id=' + value.profileid + '&pl=diary"><img class="text-center" src="' + data.pimage[value.profileid] + '" height="90" width="90" /></a><br /><a  class = "ajax_nav" href="profile.php?id=' + value.profileid + '&pl=diary">' + data.name[value.profileid] + '</a><br />' + value.birthday + ' </td>');
        i++;
      });
    });
  }

  function getanalyticdetails(me, startdate, enddate, typedata)
  {
    if (enddate)
    {
      $('#error').hide();
      var oneDay = 24 * 60 * 60 * 1000;
      //var diff =  Date.parse(enddate)-Date.parse(startdate) / (24*60*60*1000);
      var firstDate = new Date(startdate);
      var secondDate = new Date(enddate);
      var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime()) / (oneDay)));
      if (diffDays <= 15)
      {
        $('#rangeError').hide();
        param.action = 'analytics';
        param.startdate = startdate;
        param.enddate = enddate;
        param.typedata = typedata;
        data = ajax.getJSON_ajax(url, param, me, callback.getanalyticdetails);
      }
      else
      {
        $('#rangeError').show();
      }
    }
    else
    {
      $('#error').show();
    }
  }
  return {
    enable_user_account:enable_user_account,
    colleague_search:colleague_search,
    share_post: share_post,
    getanalyticdetails: getanalyticdetails,
    praise_send: praise_send,
    direct_to_md_send: direct_to_md_send,
    see_all_birthday: see_all_birthday,
    image_viewer: image_viewer,
    individualChat: individualChat,
    real_time: real_time,
    previous_talk: previous_talk,
    friend_fetch: friend_fetch,
    group_and_event_select: group_and_event_select,
    first_loader: first_loader,
    getanalyticdetails: getanalyticdetails,
    employee_invite: employee_invite,
	group_invite_email:group_invite_email,
    moderator_remove: moderator_remove,
    make_moderator: make_moderator,
    feature_setting_update: feature_setting_update,
    page_create: page_create,
    message_delete_positive: message_delete_positive,
    name_split: name_split,
    answer_people_fetch: answer_people_fetch,
    contact: contact,
    actiontype_preview: actiontype_preview,
    add_friend: add_friend,
    answer: answer,
    album_upload_button_click: album_upload_button_click,
    birthday_bomb: birthday_bomb,
    birthday_fetch: birthday_fetch,
    birthday_all: birthday_all,
    comment: comment,
    createCookie: createCookie,
    change_password: change_password,
    cookie_delete: cookie_delete,
    event_create: event_create,
    event_invite: event_invite,
    event_join: event_join,
    event_leave: event_leave,
    global_search: global_search,
    star_search: star_search,
    md_search: md_search,
    event_cancel_positive: event_cancel_positive,
    event_suggest_refresh: event_suggest_refresh,
    group_suggest_refresh: group_suggest_refresh,
    group_suggest_page: group_suggest_page,
    group_question_button: group_question_button,
    event_suggest: event_suggest,
    group_event_create: group_event_create,
    group_suggest: group_suggest,
    event_settings_save: event_settings_save,
    email_setting_update: email_setting_update,
    forgot_password: forgot_password,
    friend_invite: friend_invite,
    following_load: following_load,
    followers_load: followers_load,
    friend_request_fetch: friend_request_fetch,
    friend_accept: friend_accept,
    friend_match: friend_match,
    friend_suggest: friend_suggest,
    friend_suggest_page: friend_suggest_page,
    feedback: feedback,
    group_top_influencer: group_top_influencer,
    getCookie: getCookie,
    gift: gift,
    guest_accept: guest_accept,
    group_create: group_create,
    group_join: group_join,
    group_invite: group_invite,
    group_admin_make: group_admin_make,
    group_leave_positive: group_leave_positive,
    group_settings_save: group_settings_save,
    message: message,
    message_drop: message_drop,
    member_accept: member_accept,
    message_send: message_send,
    member_request_fetch: member_request_fetch,
    message_recent_fetch: message_recent_fetch,
    missu: missu,
    missu_fetch: missu_fetch,
    mood_done: mood_done,
    new_version_upload: new_version_upload,
    notification_setting_update: notification_setting_update,
    photo_upload: photo_upload,
    bio_item_remove: bio_item_remove,
    option: option,
    option_add: option_add,
    post_delete_positive: post_delete_positive,
    profile_privacy_update: profile_privacy_update,
    previous_talk_message: previous_talk_message,
    question_button: question_button,
    really_add_friend: really_add_friend,
    really_add_friend_page: really_add_friend_page,
    really_going_event: really_going_event,
    really_group_join: really_group_join,
    really_group_join_page: really_group_join_page,
    recover_password: recover_password,
    register: register,
    response: response,
    response_fetch: response_fetch,
    responsed: responsed,
    rtm_load: rtm_load,
    self_invite: self_invite,
    search: search,
    show_all_comments: show_all_comments,
    suggest_refresh: suggest_refresh,
    suggest_know: suggest_know,
    tagline: tagline,
    user_details: user_details,
    user_delete: user_delete,
    usefullinks: usefullinks,
    usefullinks_fetch: usefullinks_fetch,
    usefullinks_load: usefullinks_load,
    designation: designation,
    designation_fetch: designation_fetch,
    designation_delete_positive: designation_delete_positive,
    team: team,
    team_fetch: team_fetch,
    team_delete_positive: team_delete_positive,
    star_of_the_week_fetch: star_of_the_week_fetch,
    flash_board_fetch: flash_board_fetch,
    csv_fetch: csv_fetch,
    document_fetch: document_fetch,
    doc_load: doc_load,
    addstar: addstar,
    addmd: addmd,
    groups_fetch: groups_fetch,
    sotw_load: sotw_load,
    star_remove: star_remove,
    md_load: md_load,
    md_remove: md_remove,
    doc_remove: doc_remove,
    praise_fetch: praise_fetch,
    groups_suggest_add: groups_suggest_add,
    group_suggest_remove: group_suggest_remove,
    group_add_fetch: group_add_fetch,
    pro_stat: pro_stat,
    usefullinks_delete_positive: usefullinks_delete_positive,
    unfriend_positive: unfriend_positive
  }
})();