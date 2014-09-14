var callback = (function()
{
  var icon_cdn = $('#icon_cdn').attr('value');

  function add_friend(me, data)
  {
    if (data.ack == 1)
    {
      $(me).attr('value', data.message);
    }
  }

  function missu(me, data)
  {
    if (data.ack == 1)
    {
      $(me).attr('value', data.message);
      $(me).attr('class', 'missed_back');
    }
  }

  function feedback(me, data)
  {
    if (data.ack == 1)
    {
      $('.group_create_content').html('<div class="">Thank you for your feedback. Your feedback helps us improve the product over time. </div>');
    }
  }

  function contact(me, data)
  {
    if (data.ack == 1)
    {
      $('#message_leave').html('<div style="padding:0.5em;">Thank you for your time. We will get back to you. </div>');
    }
  }

  function group_join(me, data)
  {
    if (data.ack == 1)
    {
      $(me).attr('value', 'Requested');
    }
  }

  function user_details(me, data)
  {
    var text = $(me).attr('data');
    if (text == 'Add Admin') var function_call = "action.make_moderator(this," + data.profileid + ")";
    else if (text == 'Disable User') var function_call = "action.user_delete(this," + data.profileid + ")";
    $('#invite_button').attr('value', text);
    if (data.ack == 1)
    {
      $('#fetch_user_details').html('<div><a class="ajax_nav" href="profile.php?id=' + data.profileid + '"><img class="lfloat" src =' + data.pimage + ' height="80" width="80" /></a><div class="name_80"><a class="bold ajax_nav" href="profile.php?id=' + data.profileid + '">' + data.name + '</a></div><input type="submit" onclick=' + function_call + ' value=' + text + ' title=' + text + ' class="callback_user_details theme_button" /></div>');
    }
    else
    {
      $('#fetch_user_details').html('<div>' + data.error.message + '</div>');
    }
  }

  function user_delete(me, data)
  {
    var myprofileid = $('#myprofileid_hidden').attr('value');
    if (data.profileid != myprofileid)
    {
      if (data.ack == 1)
      {
        $('#fetch_user_details').html('<div>User account has been disabled .</div>');
      }
      else
      {
        $('#fetch_user_details').html('<div>' + data.error.message + '</div>');
      }
    }
    else
    {
      window.location = "/";
    }
  }

  function enable_user(me, data)
  {
    $(me).html('<a class="btn btn-primary btn-lg" role="button" href="/">Go to home</a>')
  }

  function make_moderator(me, data)
  {
    if (data.ack == 1)
    {
      $('#fetch_user_details').html('<div>User added as an admin successfully. </div>');
    }
    else
    {
      $('#fetch_user_details').html('<div>' + data.error.message + '</div>');
    }
  }

  function moderator_remove(me, data)
  {
    if (data.ack == 1)
    {
      $(me).attr("value", 'Removed');
    }
    else
    {
      //
    }
  }

  function star_remove(me, data)
  {
    if (data.ack == 1)
    {
      $(me).attr("value", 'Removed');
    }
    else
    {
      //
    }
  }

  function doc_remove(me, data)
  {
    if (data.ack == 1)
    {
      $('div#' + data.docid + '').remove();
    }
    else
    {
      //
    }
  }

  function event_join(me, data)
  {
    if (data.ack == 1)
    {
      $(me).attr('value', 'Going');
    }
  }

  function birthday_bomb(me, data)
  {
    if ($.trim(data) == 1)
    {
      $('#birthday_wish_container').html('You have successfully sent the birthday wish');
      $('.right_pointer_container').fadeOut(2000);
    }
  }

  function birthday_all(me, data)
  {
    $('#center').html('<div class="right_item" ><div class="subtitle" style="">Friend\'s Birthday</div></div>');
    $('#center').append('<table></table>');
    var i = 0;
    $.each(data.event, function(index, value)
    {
      if (i % 4 == 0)
      {
        $('table').append('<tr></tr>');
      }
      $('tr:last').append('<td style="color:blue;padding:2em;"><a class="ajax_nav " style="color:#336699;" href="profile.php?id=' + value.profileid + '&pl=diary"><img src="' + data.pimage[value.profileid] + '" height="60" width="60" /></a><br /><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.profileid + '&pl=diary">' + data.name[value.profileid] + '<br />' + value.birthday + ' </a></td>');
      i++;
    });
  }

  function bio_item_deply(contain, data_iteration, privacy, edit, title, edit_class, actiontype, name_call)
  {
    var container = $('#' + contain);
    container.append('<div class="panel panel-default"><div class="panel-heading" id="' + title.replace(/\s/g, '') + '_title">' + title + '</div><div class="panel-body" id="' + title.replace(/\s/g, '') + '_body"></div></div>');
    if (edit)
    {
      var edit_title = $('#' + title.replace(/\s/g, '') + '_title');
      edit_title.append('<span id="' + edit_class + '" class="item_edit_link" onclick="ui.bio_item_edit(' + edit_class + ',' + actiontype + ',&quot;' + name_call + '&quot;,' + privacy + ')">Edit</span>');
    }
    $.each(data_iteration, function(index, value)
    {
      var contain_body = $('#' + title.replace(/\s/g, '') + '_body');
      contain_body.append('<div class="item_each" style="margin:1em 0 0 0;color:#336699;">' + value.name + '<span class="item_edit_remove" onclick="action.bio_item_remove(this,' + value.id + ')">Remove<span></div>');
    });
  }

  function comment(me, data)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    var myprofileid = $('#myprofileid_hidden').attr('value');
    var myname = $('#myprofilename_hidden').attr('value');
    var myphoto = $('#myprofileimage_hidden').attr('value');
    var pageid = $(me).parent().parent().parent().attr('data');
    if (data.ack)
    {
/*var userid = data.comment.substring(data.comment.indexOf('@[')+2,data.comment.indexOf(']'));
				data.comment = data.comment.replace('@['+userid+']','<a class="ajax_nav" href="profile.php?id='+userid+'">'+data.name[userid]+'</a>'); */
      $('#nf_post_' + data.comment_time).attr('data', data.actionid);
      $('#nf_post_' + data.comment_time).attr('id', "nf_post_" + data.actionid);
      $('#' + data.comment_time).removeClass('glyphicon-time');
      $('#' + data.comment_time).addClass('glyphicon-ok');
    }
  }

  function option_add(me, data)
  {
    $(me).parent().prepend('<div class="option"><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, ' + data.actionid + ', ' + data.optionid + ')" checked/>' + ui.see_more(ui.get_smiley(ui.link_highlight(data.option))) + '<span class="rfloat tcolor" onclick="action.answer_people_fetch(this,' + data.optionid + ')"></span></div>');
  }

  function question(me, data)
  {
    var myprofileid = $('#myprofileid_hidden').attr('value');
    var profileid = $('#profileid_hidden').attr('value');
    var myphoto = $('#myprofileimage_hidden').attr('value');
    var myname = $('#myprofilename_hidden').attr('value');
    $('#prev').prepend('<div class="nf_post" data="' + data.actionid + '" id="nf_post_' + data.actionid + '"><div class="name_50"></div><div data=' + data.actionid + ' class="pageclass_json"><input type="hidden" value=' + profileid + ' /> <input type="hidden" value="2800"/><a class="ajax_nav" href="profile.php?id=' + myprofileid + '"><img class="lfloat" src =' + myphoto + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + myprofileid + '">' + myname + '</a> asked a question<div class="pclass_json"><pre style="margin-bottom:0.6em;">' + ui.get_smiley(ui.link_highlight(data.question)) + '</pre></div>');
    ui.response_comment('#nf_post_' + data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
    $.each(data.option, function(i, v)
    {
      $('#nf_post_' + data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, ' + data.actionid + ', ' + v.optid + ')"/>' + v.opt + '<span class="rfloat tcolor"></span></div>');
    });
    $('#nf_post_' + data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<div><input type="text" placeholder="+Add answer" value="" class="option" onkeydown="action.option_add(this,event)"><div>');
    ui.upload_default_state();
  }

  function comment_excite(me, data)
  {
    if ($.trim(data) != "")
    {
      obj.after("");
      obj.after(data);
    }
  }

  function answer(me, data)
  {
    var dom_id = 'nf_post_' + data.action[0].actionid;
    var postid = $('#' + dom_id);
    postid.html('');
    postid.append('<div class="news name_50"></div>');
    var container = '#prev';
    if (data.action[0].parenttype == 328)
    {
      feed.group_question_decode(data.action[0], data.name, data.pimage, container, dom_id);
    }
    else
    {
      feed.question_decode(data.action[0], data.name, data.pimage, container, dom_id);
    }
    feed.time_tag_decode(data.action[0], data.tag, dom_id);
    feed.response_decode(data.action[0], data.name, dom_id);
    feed.comment_decode(data.action[0], data.name, data.pimage, data.myprofileid, dom_id);
    feed.comment_box(data.action[0], data.pimage, data.myprofileid, dom_id);
  }

  function forgot_password(me, data)
  {
    if (data.ack == 1)
    {
      $('#forgot_password_info').html('We just sent you an email. Please follow the instructions in the email to reset your password.');
      $('#forgot_password_email').attr('value', '');
    }
    else if (data.error.code == 16)
    {
      $('#forgot_password_info').html('Sorry, we could not search you. Please enter your correct email.');
    }
    else if (data.error.code == 23)
    {
      $('#forgot_password_info').html('Please enter a valid email');
    }
    else if (data.ack == 15)
    {
      $('#forgot_password_info').html('Sorry, an error occured while reaching Quipmate. Please try again.');
    }
    else if (data.ack == 17)
    {
      $('#forgot_password_info').html('Sorry, an error occured while sending the email.');
    }
    else
    {
      $('#forgot_password_info').html('Please try again');
    }
  }

  function friend_accept(me, data)
  {
    $(me).remove();
  }

  function member_accept(me, data)
  {
    $(me).remove();
  }

  function guest_accept(me, data)
  {
    $(me).remove();
  }

  function bio_item_remove(me, data)
  {
    $(me).remove();
  }

  function group_invite(me, data)
  {
    if (data.ack)
    {
      $('#invite_box').attr('value', '');
      $('#group_invite_info').html(data.message);
      $(me).parent().html('');
    }
    else if (data.error)
    {
      $('#invite_box').attr('value', '');
      $('#group_invite_info').html(data.error.message);
      $(me).parent().html('');
    }
  }

  function friend_event(me, data)
  {
    if (data)
    {
      $('#friend_event').html('<div class="panel panel-default">Upcoming Birthdays<span onclick="see_all_birthday(this)" style="float:right;cursor:pointer;font-size:.8em;margin:0.3em 1.5em 0 0;color:#336688;">More</span></div>');
      var count = 0;
      $.each(data.event, function(index, value)
      {
        var birthday = new Date(value.birthday * 1000);
        var today = new Date();
        birthday = birthday.toString();
        today = today.toString();
        var bday = birthday.substring(4, birthday.length - 45);
        var tday = today.substring(4, today.length - 45);
        if (tday == bday)
        {
          $('#birthday_today').append('<div class="panel-body"><div class="container_32_35" id="' + value.profileid + '"><input type="hidden" value="' + value.profileid + '" /><input type="hidden" value="' + value.b + '" /><input type="hidden" value="' + value.pageid + '" /><div><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.profileid + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="35" width="32" /></a></div><div class="name_32"><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.profileid + '&pl=diary">' + data.name[value.profileid] + '</a></div></div></div>');
          if (value.bomb_status)
          {
            $('#' + value.profileid).append('<div class="name_32">birthday wish<span class="birthday_bomb_count" title="Number of people who sent birthday wish">' + value.bomb_count + '</span></div>');
          }
          else
          {
            $('#' + value.profileid).append('<div class="birthday_bomb name_32" style="cursor:pointer;"  title="Click to add a birthday wish">+birthday wish<span class="birthday_bomb_count" title="Number of people who sent birthday wish">' + value.bomb_count + '</span></div>');
          }
          count++;
        }
        else
        {
          $('#friend_event').append('<div class="panel-body"><div class="container_32_35"><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.profileid + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="35" width="32" /></a><div class="name_32"><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.profileid + '&pl=diary">' + data.name[value.profileid] + '</a><div>' + bday + '</div></div></div></div>');
        }
      });
      if (count)
      {
        $('#birthday_today').prepend('<div class="panel-heading">Birthday Today(' + count + ')</div>');
      }
    }
    else
    {
      $('#friend_event').remove();
    }
  }

  function group_top_influencer(me, data)
  {
    $('#friend_match').html('<div class="panel-heading">Top Influencers of this group(' + data.count + ')</div><div  id = "top_inf_body" class="panel-body"></div>');
    var i = 0;
    $.each(data.match, function(index, value)
    {
      if (i == 0)
      {
        $('#top_inf_body').append('<span class="friend_match_class" style="margin:0.1em;"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img src="' + data.pimage[value.profileid] + '" height="50" width="50" title="' + data.name[value.profileid] + '"></a></span>');
      }
      else
      {
        $('#top_inf_body').append('<span class="friend_match_class" style="margin:0.1em;"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img src="' + data.pimage[value.profileid] + '" height="40" width="40" title="' + data.name[value.profileid] + '"></a></span>');
      }
      i++;
    });
    if (data.count == 0)
    {
      $('#friend_match').remove();
    }
  }

  function friend_match(me, data)
  {
    if (data.count > 0)
    {
      $('#friend_match').html('<div class="panel-heading" >Follower match(' + data.count + ')</div><div class="panel-body" id="friend_match_body"></div>');
      $.each(data.match, function(index, value)
      {
        $('#friend_match_body').append('<span class="friend_match_class"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img src="' + data.pimage[value.profileid] + '" height="30" width="30" title="' + data.name[value.profileid] + '"></a></span>');
      });
    }
    else
    {
      $('#friend_match').remove();
    }
    if (data.ncount > 0)
    {
      $('#friend_non_match').html('<div class="panel-heading" >Follower non-match(' + data.ncount + ')</div><div class="panel-body" id="friend_non_match_body"></div>');
      $.each(data.non_match, function(index, value)
      {
        $('#friend_non_match_body').append('<span class="friend_match_class"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img src="' + data.pimage[value.profileid] + '" height="30" width="30" title="' + data.name[value.profileid] + '"></a></span>');
      });
    }
    else
    {
      $('#friend_non_match').remove();
    }
  }

  function share_post(me, data)
  {
    $('#sharemodal').modal('hide');
    $('.prompt_container').remove();
    $('.bg_hide_cover').remove();
    $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
    $('body').append('<div class="prompt_container"><div class="prompt_title">Action Successfully performed !</div><div class="prompt_content" id="invite_prompt_text"></div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
    $('body').css('overflow', 'hidden');
    if (data.ack == 1)
    {
      $('#invite_prompt_text').append('Posted successfully in your diary !');
    }
  }

  function employee_invite(me, data)
  {
    //$('#inviting').attr('id','invite_button');
    $('#employee_invite_button').attr('value', 'Invite');
    $('#employee_invite_box').attr('value', '');
    $('.prompt_container').remove();
    $('.bg_hide_cover').remove();
    $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
    $('body').append('<div class="prompt_container"><div class="prompt_title">Invite Prompt</div><div class="prompt_content" id="invite_prompt_text"></div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
    $('body').css('overflow', 'hidden');
    if (data.ack == 1)
    {
      $('#invite_prompt_text').append('Invitation completed.Please see details on page !');
    }
    $('.prompt_positive').live('click', function()
    {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
    });
    if (!(data.invited.length == 0))
    {
      $('#center').append('<h1 id="invited" class="invite_heading">People invited this time.</>');
      $.each(data.invited, function(index, value)
      {
        $('#center').append('<div class="show_emails" >' + value + '</div>');
      });
    }
    if (!(data.already_invited.length == 0))
    {
      $('#center').append('<h1 id="already_invited" class="invite_heading">People already invited .</>');
      $.each(data.already_invited, function(index, value)
      {
        $('#center').append('<div class="show_emails" >' + value + '</div>');
      });
    }
    if (!(data.existing.length == 0))
    {
      $('#center').append('<h1 id="existing" class="invite_heading" >Already joined.</>');
      $.each(data.existing, function(index, value)
      {
        $('#center').append('<div class="show_emails" >' + value + '</div>');
      });
    }
    if (!(data.invalid.length == 0))
    {
      $('#center').append('<h1 id="invalid" class="invite_heading">Invalid Emails</>');
      $.each(data.invalid, function(index, value)
      {
        $('#center').append('<div class="show_emails" >' + value + '</div>');
      });
    }
  }

  function usefullinks(me, data)
  {
    //$('#posting').attr('id','invite_button');
    $('#usefullinks_button').attr('value', 'Post');
    $('.prompt_container').remove();
    $('.bg_hide_cover').remove();
    $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
    $('body').append('<div class="prompt_container"><div class="prompt_title">Post Prompt</div><div class="prompt_content" id="post_prompt_text"></div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
    $('body').css('overflow', 'hidden');
    if (data.ack == 1)
    {
      $('#post_prompt_text').append(' Links Posted.Please see details on page !');
    }
    else
    {
      $('#post_prompt_text').append(data.error.message);
    }
    $('.prompt_positive').live('click', function()
    {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
    });
  }

  function usefullinks_fetch(me, data)
  {
    $.each(data, function(index, value)
    {
      $('#usefullinks_box').append('<div id="' + value.link_id + '" class="dsgn" style="position:relative;border-bottom: 0.1em solid rgb(221, 221, 221);clear: both;cursor: pointer;min-height: 2.5em;padding: 0.5em 0px 0.5em 0.4em;">' + value.title + '<span  onclick="ui.usefullinks_delete(this,' + value.link_id + ')" class="dsgn_setting" title="Delete this link"></span></div>');
    });
  }

  function usefullinks_load(me, data)
  {
    if (data.length > 0)
    {
      $('#right').append('<div id="useful_links_box" class="panel panel-default"><div class="panel-heading">Useful Links</div><div id="useful_links_box2" class="panel-body"></div></div>');
      $.each(data, function(index, value)
      {
        $('#useful_links_box2').append('<section><a  style="color:#336699;font-weight:bold;line-height:1.1;" href="' + value.link + '" target="blank">' + value.title + '</a><div>' + value.link + '</div></div></section>');
      });
    }
  }

  function usefullinks_delete(me, data)
  {
    if (data.ack == 1)
    {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('div#' + data.id + '').remove();
    }
    else
    {
      $('.prompt_content').html('Error performing the action, please try again');
    }
  }

  function sotw_fetch(me, data)
  {
    if (data.star.length > 0)
    {
      $('#right').append('<div id="sotw_box" class="panel panel-default"><div class="panel-heading">Star Of The Week</div><div id="sotw_box2" class="panel-body"></div></div>');
      $.each(data.star, function(index, value)
      {
        $('#sotw_box2').append('<div><img class="lfloat"  src="' + data.pimage[value.profileid] + '" width="35" height="32" style="padding-bottom:5px; "/><div class="name_32" ><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div>' + ui.see_more(ui.get_smiley(ui.link_highlight(value.contribution))) + '</div></div></br></div>');
      });
    }
  }

  function sotw_load(me, data)
  {
    $('#center').append('<h1 class="page_title">Existing Stars</h1>');
    $.each(data.star, function(index, value)
    {
      $('#center').append('<div style="height:8em;clear:both;padding:1.5em;"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + value.profileid + '"><img class="lfloat" height="80" width="80" src="' + data.pimage[value.profileid] + '" /></a><div class="name_80"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div>' + value.contribution + '</div><div style="float:right;"><input id="invite_button" class="theme_button" type="submit" onclick="action.star_remove(this,' + value.profileid + ')" value="Remove Star" title="Remove Star" style=" cursor:pointer;font-weight:bold;height: 3.1em;width:9.3em;margin-top:3em;" /></div></div></div>');
    });
  }

  function doc_load(me, data)
  {
    $('#center').append('<h1 class="page_title">Pinned Documents</h1><div id="existing" class="panel-body" align="left"></div>');
    $.each(data.pinned_doc, function(index, value)
    {
      var ext = value.caption.split('.').pop();
      var icon_cdn = $('#icon_cdn').attr('value');
      var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
      $('#existing').append('<div id="' + value.docid + '"  ><div class="name_50 display_inline_table"><img class="lfloat"  src="' + fileimage + '" width="50" height="50" style="padding-bottom:5px; "/><div class="name_50" ><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.filename + '">' + value.caption + '</a><div><a style="color:#808080;" target="_blank" href="https://docs.google.com/viewer?url=' + value.filename + '">Preview</a><a style="color:#808080;margin-left:1em;" href=' + value.filename + ' data="' + value.filename + '" target="_blank">Download</a></div><input id="invite_button" class="theme_button" type="submit" onclick="action.doc_remove(this,' + value.docid + ')" value="X" title="Remove" style=" cursor:pointer;font-weight:bold;height: 2.3em;width:2.3em;margin-left:18.1em;" /></div></br></div></div>');
    });
  }

  function praise_fetch(me, data)
  {
      var icon_cdn = $('#icon_cdn').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
  if(data.action.length)
  { 
    
    $.each(data.action, function(index, value)
    {
      var file = icon_cdn+'/'+value.file;
      $('#prev').append('<div style="height:8em;clear:both;padding:1.5em;"><a class="ajax_nav" href="profile.php?id=' + value.actionby_profileid + '"><img class="lfloat" src="' + data.pimage[value.actionby_profileid] + '" height="50" width="50"></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + value.actionby_profileid + '">' + value.actionby + '</a>  praised </div><div class="lfloat"><img src="'+file+'" width="70" height="70" /><div class="text-center"><strong>'+value.mood+'</strong></div></div><div class="praise_texts"><pre class="nf_page"><strong>For: '+ ui.see_more(ui.get_smiley(ui.link_highlight(value.title))) + '</strong></pre><pre style="margin:0.5em 0em;display:block;"><strong>Praise: </strong>'+ ui.see_more(ui.get_smiley(ui.link_highlight(value.comment))) + '</pre></div></div>');
    });
  }
  else
  {
    $('.load_more').show();
  }
  }

  function groups_fetch(me, data)
  {
    $.each(data.action, function(index, value)
    {
      var show = value.show;
      $('#center').append('<div style="height:8em;clear:both;padding:1.5em;"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + value.groupid + '"><img class="lfloat" height="80" width="80" src="' + value.pimage + '" /></a><div class="name_80"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + value.groupid + '">' + value.name + '</a><div>' + value.description + '</div><div style="float:right;"></div></div></div>');
      if (show == 0)
      {
        $('#center').append('<div style="float:right;"><input id="invite_button" class="theme_button" type="submit" onclick="action.groups_suggest_add(this,' + value.groupid + ')" value="Add Group" title="Add Group" style=" cursor:pointer;font-weight:bold;height: 3.1em;width:9.3em;margin-top:3em;" /></div>');
      }
      if (show == 1)
      {
        $('#center').append('<div style="float:right;"><input id="invite_button" class="theme_button" type="submit" onclick="action.group_suggest_remove(this,' + value.groupid + ')" value="Remove Group" title="Remove Group" style=" cursor:pointer;font-weight:bold;height: 3.1em;width:9.3em;margin-top:3em;" /></div>');
      }
    });
  }

  function md_load(me, data)
  {
    $('#center').append('<h1 class="page_title">Current MD </h1>');
    $('#center').append('<div style="height:8em;clear:both;padding:1.5em;"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + data.action['profileid'] + '"><img class="lfloat" height="80" width="80" src="' + data.action['image'] + '" /></a><div class="name_80"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + data.action['profileid'] + '">' + data.action['name'] + '</a><div style="float:right;"><input id="invite_button" class="theme_button" type="submit" onclick="action.md_remove(this,' + data.action['profileid'] + ')" value="Remove MD" title="Remove MD" style=" cursor:pointer;font-weight:bold;height: 3.1em;width:9.3em;margin-top:3em;" /></div></div></div>');
  }

  function md_remove(me, data)
  {
    if (data.ack == 1)
    {
      $(me).attr("value", 'Removed');
    }
    else
    {
      //
    }
  }

  function group_suggest_remove(me, data)
  {
    if (data.ack == 1)
    {
      $(me).attr("value", 'Removed');
    }
    else
    {
      //
    }
  }

  function groups_suggest_add(me, data)
  {
    if (data.ack == 1)
    {
      $(me).attr("value", 'Added');
    }
    else
    {
      //
    }
  }

  function group_add_fetch(me, data)
  {
    $('#center').append('<h1 class="page_title">Group Suggestions By Admin</h1>');
    $.each(data.action, function(index, value)
    {
      $('#center').append('<div style="height:8em;clear:both;padding:1.5em;"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + value.groupid + '"><img class="lfloat" height="80" width="80" src="' + value.pimage + '" /></a><div class="name_80"><a class="ajax_nav" style="font-weight:bold;" href="profile.php?id=' + value.groupid + '">' + value.name + '</a><div>' + value.description + '</div><div style="float:right;"><input id="invite_button" class="theme_button" type="submit" onclick="action.really_group_join(this)" value="+Join Group" title="Join Group" style=" cursor:pointer;font-weight:bold;height: 3.1em;width:9.3em;margin-top:3em;" /></div></div></div>');
    });
  }

  function flash_board_fetch(me, data)
  {
    if (data.flash.length > 0)
    {
      $('#right').append('<div id="flash_board_box" class="panel panel-default"><div id="flash_board_box2" class="panel-body"></div>');
      $.each(data.flash, function(index, value)
      {
        $('#flash_board_box2').append('<div><a href="' + value.description + '" target="_blank" ><img class="lfloat"  src="' + value.image + '" width="200" height="80" style="padding-bottom:5px; "/></a></br></div>');
      });
    }
  }

  function csv_fetch(me, data)
  {
  }

  function document_fetch(me, data)
  {
    if (data.pinned_doc != null && data.pinned_doc.length > 0)
    {
      $('#right').append('<div  class="panel panel-default"><div class="panel-heading">Documents</div><div id="document_box" class="panel-body"></div></div>');
      $.each(data.pinned_doc, function(index, value)
      {
        var ext = value.caption.split('.').pop();
        var icon_cdn = $('#icon_cdn').attr('value');
        var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
        $('#document_box').append('<div><img class="lfloat"  src="' + fileimage + '" width="30" height="30" style="padding-bottom:5px; "/><div class="name_32" ><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="' + value.filename + '">' + value.caption + '</a><div>' + value.description + '</div></div></br></div>');
      });
    }
  }

  function designation(me, data)
  {
    if (data.ack == 1)
    {
      $('#designation_box').attr('value', '');
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('#designation_button').attr('value', 'Add');
      $('#designation_show_box').append('<div id="' + data.infoid + '" class="dsgn" style="position:relative;border-bottom: 0.1em solid rgb(221, 221, 221);clear: both;cursor: pointer;min-height: 2.5em;padding: 0.5em 0px 0.5em 0.4em;">' + data.infoadd + '<span  onclick="ui.designation_delete(this,' + data.infoid + ')" class="dsgn_setting"></span></div>');
    }
    else
    {
      $('#designation_button').attr('value', 'Add');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Post Prompt</div><div class="prompt_content" id="post_prompt_text"></div><div class="prompt_button"><input class="prompt_positive" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
      $('body').css('overflow', 'hidden');
      $('#post_prompt_text').append(data.error.message);
    }
  }

  function designation_fetch(me, data)
  {
    $.each(data.info, function(index, value)
    {
      $('#designation_show_box').append('<div id="' + value.id + '" class="dsgn" style="position:relative;border-bottom: 0.1em solid rgb(221, 221, 221);clear: both;cursor: pointer;min-height: 2.5em;padding: 0.5em 0px 0.5em 0.4em;">' + value.name + '<span  onclick="ui.designation_delete(this,' + value.id + ')" class="dsgn_setting">X</span></div>');
    });
  }

  function designation_delete(me, data)
  {
    if (data.ack == 1)
    {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('div#' + data.id + '').remove();
    }
    else
    {
      $('.prompt_content').html('Error performing the action, please try again');
    }
  }

  function team(me, data)
  {
    $('#team_box').attr('value', '');
    $('.prompt_container').remove();
    $('.bg_hide_cover').remove();
    if (data.ack == 1)
    {
      $('#team_button').attr('value', 'Add');
      $('#team_show_box').append('<div id="' + data.infoid + '" class="dsgn" style="position:relative;border-bottom: 0.1em solid rgb(221, 221, 221);clear: both;cursor: pointer;min-height: 2.5em;padding: 0.5em 0px 0.5em 0.4em;">' + data.infoadd + '<span  onclick="ui.team_delete(this,' + data.infoid + ')" class="dsgn_setting">X</span></div>');
    }
    else
    {
      $('#team_button').attr('value', 'Add');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Post Prompt</div><div class="prompt_content" id="post_prompt_text"></div><div class="prompt_button"><input class="prompt_positive" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
      $('body').css('overflow', 'hidden');
      $('#post_prompt_text').append('Entry already exists.');
    }
  }

  function team_fetch(me, data)
  {
    $.each(data.info, function(index, value)
    {
      $('#team_show_box').append('<div id="' + value.id + '" class="dsgn" style="position:relative;border-bottom: 0.1em solid rgb(221, 221, 221);clear: both;cursor: pointer;min-height: 2.5em;padding: 0.5em 0px 0.5em 0.4em;">' + value.name + '<span  onclick="ui.team_delete(this,' + value.id + ')" class="dsgn_setting">X</span></div>');
    });
  }

  function team_delete(me, data)
  {
    if (data.ack == 1)
    {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('div#' + data.id + '').remove();
    }
    else
    {
      $('.prompt_content').html('Error performing the action, please try again');
    }
  }

  function addstar(me, data)
  {
    $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
    $('body').append('<div class="prompt_container"><div class="prompt_title">Post Prompt</div><div class="prompt_content" id="post_prompt_text"></div><div class="prompt_button"><input class="prompt_positive" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
    $('body').css('overflow', 'hidden');
    if (data.ack == 1)
    {
      $('#add_star_button').attr('value', 'Add');
      $('#post_prompt_text').append(' Star Added.Please see details on page !');
    }
    else
    {
      $('#post_prompt_text').append(data.error.message);
    }
    $('.prompt_positive').live('click', function()
    {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
    });
  }

  function addmd(me, data)
  {
    $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
    $('body').append('<div class="prompt_container"><div class="prompt_title">Post Prompt</div><div class="prompt_content" id="post_prompt_text"></div><div class="prompt_button"><input class="prompt_positive" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
    $('body').css('overflow', 'hidden');
    if (data.ack == 1)
    {
      $('#add_md_button').attr('value', 'Add MD');
      $('#hsomd').attr('value', '');
      $('#post_prompt_text').append(' MD Added.Please see details on page !');
    }
    if (data.ack == 2)
    {
      $('#add_md_button').attr('value', 'Add MD');
      $('#post_prompt_text').append(' Invitation to MD sent !');
    }
    $('.prompt_positive').live('click', function()
    {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
    });
  }

  function pro_stat(me, data)
  {
    $('#right').append('<div  class="panel panel-default"><div class="panel-heading">Profile Completion<a class="ajax_nav" href="profile.php?id=' + data.profileid + '&hl=bio"><span  style="float:right;cursor:pointer;font-size:.8em;margin:0.3em 1.5em 0 0;color:#336688;">Edit</span></a></div><div id="pro_stat" class="panel-body"></div></div>');
    $('#pro_stat').append('<div class="option"><div class="option_percentage" id="41" style="width: ' + data.bio_perc + '%; background: rgb(128, 128, 128);"><span class="rfloat tcolor" > ' + data.bio_perc + '% </span></div></div>');
  }

  function friend_invite(me, data)
  {
    $('#inviting').attr('id', 'invite_button');
    $('#invite_button').attr('value', 'Invite');
    $('#invite_box').attr('value', '');
    $('.prompt_container').remove();
    $('.bg_hide_cover').remove();
    $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
    $('body').append('<div class="prompt_container"><div class="prompt_title">Invite Prompt</div><div class="prompt_content" id="invite_prompt_text"></div><div class="prompt_button"><input class="prompt_positive" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
    $('body').css('overflow', 'hidden');
    if (data.ack == 0)
    {
      $('#invite_prompt_text').append('Ohhh come on! You cannot invite yourself. Try a different email address.');
    }
    else if (data.ack == 1)
    {
      $('#invite_prompt_text').append('Your friend having this email address has already joined Quipmate.');
    }
    else if (data.ack == 2)
    {
      $('#invite_prompt_text').append('You have successfully invited your friend to join Quipmate.');
    }
    else if (data.ack == 3)
    {
      $('#invite_prompt_text').append('Sorry this email address seems to be invalid. Please check for any possible mistake.');
    }
    else if (data.error)
    {
      $('#invite_prompt_text').append(data.error.message);
    }
    $('#invite_song_ok_button').live('click', function()
    {
      $('#invite_popup_container').remove();
      $('#bg_first').remove();
    });
  }

  function friend_request_fetch(me, data)
  {
    if (data.count > 0)
    {
      $('#friend_request').html('<div class="subtitle" >Friend Requests(' + data.count + ')</div>');
      $.each(data.friend, function(index, value)
      {
        $('#friend_request').append('<div data="' + value.profileid + '" class="friend_request_class"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" style="margin-right:1em;" src="' + data.pimage[value.profileid] + '" height="50" width="50"></a><div><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div><input type="submit" class="frequest" id="1" value="Accept" onclick="action.friend_accept(this, 1)" /><input type="submit" class="frequest" style="margin-left:0.5em;" id="0" value="Deny" onclick="action.friend_accept(this, 0)" /></div></div></div>');
      });
    }
    else
    {
      $('#friend_request').remove();
    }
  }

  function member_request_fetch(me, data)
  {
    if (data.count > 0)
    {
      $('#member_request').html('<div class="panel-heading" >Member Requests(' + data.count + ')</div><div id = "member_request_body" class="panel-body"></div>');
      $.each(data.member, function(index, value)
      {
        $('#member_request_body').append('<div data="' + value.profileid + '" class="friend_request_class"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" style="margin-right:1em;" src="' + data.pimage[value.profileid] + '" height="50" width="50"></a><div><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div><input type="submit" class="frequest" id="1" value="Add" onclick="action.member_accept(this, 1)" /><input type="submit" class="frequest" style="margin-left:0.5em;" id="0" value="Ignore" onclick="action.member_accept(this, 0)" /></div></div></div>');
      });
    }
    else
    {
      $('#member_request').remove();
    }
  }

  function friend_load(me, data)
  {
    if (data.ack)
    {
      $('#session_name_hidden').attr('value', JSON.stringify(data.name));
      $('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
      $.each(data.friend, function(index, value)
      {
        id = "friend_" + value;
        if ($('#' + id).length == 0)
        {
          $(me).append('<div class="chat_user" data="' + value + '" id="' + id + '"><img class="online_photo" height="30" width="30" src="' + data.pimage[value] + '" /><span class="online_name">' + data.name[value] + '</span><input type="hidden" value="' + data.name[value] + '" /></div>');
        }
      });
    }
    else
    {
      $(me).append('<div>Nobody is available at chat</div>');
    }
  }

  function friend_suggest(me, data)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    $('#right').append('<div id="friend_suggest" class="panel panel-default"></div>');
    $('#friend_suggest').html('<div class="panel-heading">You may follow <img title="Show different suggestions" class="refresh_friend_suggest" src="' + icon_cdn + '/refresh.jpg" onclick="action.suggest_refresh(this)"/></div><div class="panel-body suggest_container_body"><div class="suggest_container" id="suggest_container1"></div><div class="suggest_container" id="suggest_container2"></div><div class="suggest_container" id="suggest_container3"></div><div class="suggest_container" id="suggest_container4"></div><div class="suggest_container" id="suggest_container5"></div><div class="suggest_container" id="suggest_container6"></div><div>');
    if (data.action.length > 0)
    {
      ui.suggest_deploy(me, data);
    }
    else
    {
      $('#friend_suggest').remove();
    }
  }

  function friend_suggest_page(me, data)
  {
    $('#right').append('<div id="friend_suggest" class="right_item"></div>');
    $('#friend_suggest').html('<div class="suggest_container" id="suggest_container1"></div><div class="suggest_container" id="suggest_container2"></div><div class="suggest_container" id="suggest_container3"></div><div class="suggest_container" id="suggest_container4"></div><div class="suggest_container" id="suggest_container5"></div><div class="suggest_container" id="suggest_container6"></div><div class="suggest_container" id="suggest_container7"></div><div class="suggest_container" id="suggest_container8"></div><div class="suggest_container" id="suggest_container9"></div><div class="suggest_container" id="suggest_container10"></div><div class="suggest_container" id="suggest_container11"></div><div class="suggest_container" id="suggest_container12"></div><div class="suggest_container" id="suggest_container13"></div><div class="suggest_container" id="suggest_container14"></div><div class="suggest_container" id="suggest_container15"></div><div class="suggest_container" id="suggest_container16"></div><div class="suggest_container" id="suggest_container17"></div><div class="suggest_container" id="suggest_container18"></div><div class="suggest_container" id="suggest_container19"></div><div class="suggest_container" id="suggest_container20"><div class="suggest_container" id="suggest_container21"></div></div>');
    ui.suggest_deploy_page(me, data);
  }

  function group_suggest_page(me, data)
  {
    $('#right').append('<div id="group_suggest" class="right_item"></div>');
    $('#group_suggest').html('<div class="group_suggest_container" id="group_suggest_container1"></div><div class="group_suggest_container" id="group_suggest_container2"></div><div class="group_suggest_container" id="group_suggest_container3"></div><div class="group_suggest_container" id="group_suggest_container4"></div><div class="group_suggest_container" id="group_suggest_container5"></div><div class="group_suggest_container" id="group_suggest_container6"></div><div class="group_suggest_container" id="group_suggest_container6"></div><div class="group_suggest_container" id="group_suggest_container7"></div><div class="group_suggest_container" id="group_suggest_container8"></div><div class="group_suggest_container" id="group_suggest_container9"></div><div class="group_suggest_container" id="group_suggest_container10"></div><div class="group_suggest_container" id="group_suggest_container11"></div><div class="group_suggest_container" id="group_suggest_container12"></div><div class="group_suggest_container" id="group_suggest_container13"></div><div class="group_suggest_container" id="group_suggest_container14"></div><div class="group_suggest_container" id="group_suggest_container15"></div><div class="group_suggest_container" id="group_suggest_container16"></div><div class="group_suggest_container" id="group_suggest_container17"></div><div class="group_suggest_container" id="group_suggest_container18"></div><div class="group_suggest_container" id="group_suggest_container19"></div><div class="group_suggest_container" id="group_suggest_container20"></div><div class="group_suggest_container" id="group_suggest_container21"></div>');
    ui.group_suggest_page_deploy(me, data);
  }

  function group_suggest(me, data)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    $('#right').append('<div id="group_suggest" class="panel panel-default"></div>');
    $('#group_suggest').html('<div class="panel-heading">Group Suggestions<img title="Show different suggestions"  class="refresh_friend_suggest" src="' + icon_cdn + '/refresh.jpg" onclick="action.group_suggest_refresh(this)"/></div><div class="panel-body group_suggest_body"><div class="group_suggest_container" id="group_suggest_container1"></div><div class="group_suggest_container" id="group_suggest_container2"></div><div class="group_suggest_container" id="group_suggest_container3"></div><div class="group_suggest_container" id="group_suggest_container4"></div><div class="group_suggest_container" id="group_suggest_container5"></div><div class="group_suggest_container" id="group_suggest_container6"></div></div>');
    if (data.action.length > 0)
    {
      ui.group_suggest_deploy(me, data);
    }
    else
    {
      $('#group_suggest').remove();
    }
  }

  function event_suggest(me, data)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    $('#right').append('<div id="event_suggest" class="panel panel-default"></div>');
    $('#event_suggest').html('<div class="panel-heading">Event Suggestions<img title="Show different suggestions" class="refresh_friend_suggest" src="' + icon_cdn + '/refresh.jpg" onclick="action.event_suggest_refresh(this)"/></div><div class="panel-body event_suggest_body"><div class="event_suggest_container" id="event_suggest_container1"></div><div class="event_suggest_container" id="event_suggest_container2"></div><div class="event_suggest_container" id="event_suggest_container3"></div><div class="event_suggest_container" id="event_suggest_container4"></div><div class="event_suggest_container" id="event_suggest_container5"></div><div class="event_suggest_container" id="event_suggest_container6"></div></body>');
    if (data.action.length > 0)
    {
      ui.event_suggest_deploy(me, data);
    }
    else
    {
      $('#event_suggest').remove();
    }
  }

  function friendship_preview(me, data)
  {
    if (data.action.length > 0)
    {
      $('#friendship_recent').html('<div class="subtitle" >Recent Friendships</div>');
      $.each(data.action, function(index, value)
      {
        $('#friendship_recent').append('<div class="container_32"><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.actionon + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.actionon] + '" height="32" width="32" /></a><div class="name_32"><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.actionon + '&pl=diary">' + data.name[value.actionon] + '</a> with <a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.actionby + '&pl=diary">' + data.name[value.actionby] + '</a></div><div style="position:relative;top:-3em;left:4.5em;"></div></div>');
      });
    }
    else
    {
      $('#friendship_recent').remove();
    }
  }

  function gift(me, data)
  {
    if (data.ack)
    {
      $('#gift_container').html('<span>Your gift has been sent to your friend.</span>');
      $('#gift_container').fadeOut(1000);
      $('.bg_hide_cover').fadeOut(1000);
    }
  }

  function gift_preview(me, data)
  {
    if (data.action.length > 0)
    {
      $('#right').append('<div id="gift_recent" class="panel panel-default"></div>');
      $('#gift_recent').html('<div class="panel-heading" >Who Sent Gift To Whom</div><div id="gift_recent_body" class="panel-body"></div>');
      $.each(data.action, function(index, value)
      {
        $('#gift_' + value.actionby).remove();
        $('#gift_recent_body').append('<div class="container_32_35 pointer" onclick="ui.redirect_to_action(' + value.actionid + ',\'' + value.life_is_fun + '\')" id="gift_' + value.actionby + '"><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.actionby + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.actionby] + '" height="35" width="32" /></a><div class="name_32_35"><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.actionby + '&pl=diary">' + data.name[value.actionby] + '</a> To <a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.actionon + '&pl=diary">' + data.name[value.actionon] + '</a>: ' + value.gift + '<div>' + value.page + '</div></div></div>');
      });
    }
    else
    {
      $('#gift_recent').remove();
    }
  }

  function group_create(me, data)
  {
    if (data.error)
    {
      $('#group_info').html(data.error.message);
    }
    else
    {
      window.location = 'group.php?id=' + data.groupid;
    }
  }

  function page_create(me, data)
  {
    if (data.error)
    {
      $('#page_info').html(data.error.message);
    }
    else
    {
      window.location = 'page.php?id=' + data.pageid;
    }
  }

  function group_settings_save(me, data)
  {
    if (data.error)
    {
      $('#group_info').html(data.error.message);
    }
    else
    {
      $('#group_info').html("Settings Saved Successfully !");
    }
  }

  function event_create(me, data)
  {
    if (data.error)
    {
      $('#group_info').html(data.error.message);
    }
    else
    {
      window.location = 'event.php?id=' + data.eventid;
    }
  }

  function message(me, data)
  {
    if (data.ack)
    {
      $('#message_container').html('<span>The message has been sent.</span>');
      $('#message_container').fadeOut(2000);
      ui.bg_hide()
    }
  }

  function message_drop(me, data)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    var myprofileid = $('#myprofileid_hidden').attr('value');
    var myprofileid_image = $('#myprofileimage_hidden').attr('value');
    var myprofileid_name = $('#myprofilename_hidden').attr('value');
    if (data.ack)
    {
      $('#prev').prepend('<div id="' + data.actionid + '" data="' + data.actionid + '" class="message_each"><input type="hidden" value="' + myprofileid + '" /><input type="hidden" value="' + data.actionon + '" /><input type="hidden" value="' + data.actiontype + '" /><a class="ajax_nav" href="profile.php?id=' + myprofileid + '" ><img class="lfloat" src =' + myprofileid_image + ' height="50" width="50" /></a><div class="name_50"><a class="ajax_nav" href="profile.php?id=' + myprofileid + '">' + myprofileid_name + '</a> to <a class="ajax_nav" href="profile.php?id=' + myprofileid + '">' + myprofileid_name + '</a><div class="pclass_json"><pre>' + data.message + '</pre></div></div></div>');
      $('#' + data.actionid).append('<span class="time_tag_json"><img src="' + icon_cdn + '/clock.png" width="10" />Now</span><span class="reply" >Reply</span>');
    }
  }

  function message_recent_fetch(me, data, container)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    if (data.ack)
    {
      $('#session_name_hidden').attr('value', JSON.stringify(data.name));
      $('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
      var myprofileid = $('#myprofileid_hidden').attr('value');
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
        if ((value.message).length > 30) value.message = (value.message).slice(0, 27) + '...';
        $(container).append('<div class="inbox_user" data="' + showuser + '" id="' + showuser + '" onclick="ui.redirect_to_inbox(' + showuser + ')"><img class="online_photo" height="40" width="40" src="' + data.pimage[showuser] + '" /><span class="online_name" style="font-weight:bold;">' + data.name[showuser] + '</span><div><img height="20" width="20" src="' + showimage + '"/>' + value.message + '</div></div>');
      });
    }
  }

  function missu_fetch(me, data)
  {
    if (data.count)
    {
      $('#text').html('<div class="subtitle" >Friends Missing You(' + data.count + ')</div>');
      $.each(data.missu, function(index, value)
      {
        $('#text').append('<div class="missu_reminder_class" data="' + value.profileid + '"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="50" width="50"></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div><input type="submit" class="miss_back" data="' + value.profileid + '" onclick="action.missu(this)" value="Miss Back" /></div></div></div>');
      });
    }
    else
    {
      $('#text').remove();
    }
  }

  function request_fetch(me, data)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
/*	if(data.missu)
			{
				$('#text').html('<div class="subtitle" >Friends Missing You('+data.missu_count+')</div>');
				$.each(data.missu,function(index,value){
				$('#text').append('<div class="missu_reminder_class" data="'+value.profileid+'"><a class="ajax_nav" href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="50" width="50"></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div><input type="submit" class="miss_back" data="'+value.profileid+'" onclick="action.missu(this)" value="Miss Back" /></div></div></div>');
				}); 
			}
			else
			{
				$('#text').append('<div class="missu_reminder_class">No MissU</div>');
			} */
    if (data.friend)
    {
      $('#text').append('<div class="subtitle" >Followers(' + data.friend_request_count + ')</div>');
      $.each(data.friend, function(index, value)
      {
        $('#text').append('<div data="' + value.profileid + '" class="friend_request_class"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" style="margin-right:1em;" src="' + data.pimage[value.profileid] + '" height="50" width="50"></a><div><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + ' is now following you .</a><div><input type="submit" class="frequest" id="1" value="Follow" onclick="action.friend_accept(this, 1)" /><input type="submit" class="frequest" style="margin-left:0.5em;" id="0" value="Cancel" onclick="action.friend_accept(this, 0)" /></div></div></div>');
      });
    }
    else
    {
      $('#text').append('<div class="missu_reminder_class">No New Follower</div>');
    }
    if (data.event)
    {
      $('#text').append('<div class="subtitle" >Event Requests(' + data.event_request_count + ')</div>');
      $.each(data.event, function(index, value)
      {
        $('#text').append('<div data="' + value.eventid + '" class="friend_request_class"><a class="ajax_nav" href="event.php?id=' + value.eventid + '"><img class="lfloat" style="margin-right:1em;" src="' + icon_cdn + '/event.png" height="50" width="50"></a><div><a class="bold ajax_nav" href="event.php?id=' + value.eventid + '">' + value.event_name + '</a><div><input type="submit" class="frequest" id="1" value="Going" data="' + value.eventid + '" onclick="action.guest_accept(this, 1)" /><input type="submit" class="frequest"  data="' + value.eventid + '"  style="margin-left:0.5em;" id="0" value="Decline" onclick="action.guest_accept(this, 0)" /></div></div></div>');
      });
    }
    else
    {
      $('#text').append('<div class="missu_reminder_class">No Event Request</div>');
    }
  }

  function missu_preview(me, data)
  {
    if (data.action.length > 0)
    {
      $('#right').append('<div id="missu_recent" class="panel panel-default"></div>');
      $('#missu_recent').html('<div class="panel-heading" >Being Missed</div><div id="missu_recent_body" class="panel-body"></div>');
      $.each(data.action, function(index, value)
      {
        $('#missu_' + value.actionon).remove();
        $('#missu_recent_body').append('<div class="container_32 pointer" onclick="ui.redirect_to_action(' + value.actionid + ',\'' + value.life_is_fun + '\')" id="missu_' + value.actionon + '"><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.actionon + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.actionon] + '" height="32" width="32" /></a><div class="name_32"><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.actionon + '&pl=diary">' + data.name[value.actionon] + '</a></div></div>');
      });
    }
    else
    {
      $('#missu_recent').remove();
    }
  }

  function mood(me, data)
  {
    if (data.ack)
    {
      $('#mood_container').html('<span>Your new mood has been set and your followers have been informed about your new mood.</span>');
      $('#mood_container').fadeOut(1000);
      $('.bg_hide_cover').fadeOut(1000);
    }
  }

  function mood_preview(me, data)
  {
    if (data.action.length > 0)
    {
      $('#right').append('<div id="mood_recent" class="panel panel-default"></div>');
      $('#mood_recent').html('<div class="panel-heading" >Mood of your following </div><div  id="mood_recent_body"  class="panel-body"></div>');
      $.each(data.action, function(index, value)
      {
        $('#mood_' + value.actionby).remove();
        $('#mood_recent_body').append('<div class="container_32_35 pointer" onclick="ui.redirect_to_action(' + value.actionid + ',\'' + value.life_is_fun + '\')" id="mood_' + value.actionby + '"><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.actionby + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.actionby] + '" height="35" width="32" /></a><div class="name_32_35"><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.actionby + '&pl=diary">' + data.name[value.actionby] + '</a> is ' + value.mood + '<div>' + value.page + '</div></div></div>');
      });
    }
    else
    {
      $('#mood_recent').remove();
    }
  }

  function profile_update(me, data)
  {
    $("#save").html("Changes have been saved.");
    $('#loader2').html("");
    me.show();
  }

  function response(me, data)
  {
    if (data.ack == 1)
    {
      if (data.actiontype != 63)
      {
        me.parent().next().children().eq(0).prepend('<span>You,</span> ');
      }
      else
      {
        var excited_count = parseInt($(me).next().attr('data')) + 1;
        me.next().attr('data', excited_count);
        me.next().html(excited_count + ' excited');
      }
    }
  }

  function response_fetch(me, data)
  {
    $('#more_excite_people').remove();
    $('.bg_hide_cover').remove();
    $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
    $('body').append('<div id="more_excite_people" >Retreiving data</div>');
    $('#more_excite_people').append('<span onclick="ui.close()" class="closex" >x</span>');
    $("#more_excite_people").remove();
    $('body').append('<div id="more_excite_people"><div  class="prompt_title">People who responded to this<div onclick="ui.close()" class="closex">x</div></div></div>');
    $.each(data.excited, function(index, value)
    {
      $('#more_excite_people').append('<div class="more_excite_people_pic"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a></div></div>');
    });
  }

  function responsed(me, data)
  {
    if (data == '1')
    {
    }
    if (data.ack == 1)
    {
      if (data.actiontype != 63)
      {
        me.parent().next().children().eq(0).children().eq(0).remove();
      }
      else
      {
        var excited_count = parseInt($(me).next().attr('data')) - 1;
        if (excited_count != 0)
        {
          me.next().attr('data', excited_count);
          me.next().html(excited_count + ' excited');
        }
        else
        {
          me.next().attr('data', excited_count);
          me.next().html('');
        }
      }
    }
  }

  function show_all_comments(me, data)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    var myprofileid = $('#myprofileid_hidden').attr('value');
    $.each(data.com, function(index, com)
    {
      var com_id = 'nf_post_' + com.com_actionid;
      var exciting = 'Exciting';
      var fun = 'action.response(this)';
      if (com.com_excited_mine)
      {
        exciting = 'Unexciting';
        fun = 'action.responsed(this)';
      }
      var userid = com.comment.substring(com.comment.indexOf('@[') + 2, com.comment.indexOf(']'));
      com.comment = com.comment.replace('@[' + userid + ']', '<a class="ajax_nav" href="profile.php?id=' + userid + '">' + data.name[userid] + '</a>');
      $(me).parent().after('<div class="cclass_json" id="' + com_id + '" data="' + com.com_actionid + '"><a class="ajax_nav" href="profile.php?id=' + com.commentby + '"><img class="lfloat" src ="' + data.pimage[com.commentby] + '" height="32" width="32" /></a><div class="name_35"><div><a class="bold ajax_nav" style="margin-right:0.4em;" href="profile.php?id=' + com.commentby + '">' + data.name[com.commentby] + '</a><pre>' + ui.get_smiley(ui.link_highlight(com.comment)) + '</pre></div><div><a class="comment_time_json" href="action.php?actionid=' + com.com_pageid + '&life_is_fun=' + data.life_is_fun + '"><img src="' + icon_cdn + '/clock.png" width="6" /><span class="time" data="' + com.com_time + '">' + ui.time_difference(com.com_time) + '</span></a><span data=' + com.commentby + ' class = "comment_excite_json" onclick="' + fun + '">' + exciting + '</span></div></div></div>');
      if (com.com_excited)
      {
        $("#" + com_id).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="' + com.com_excited + '" onclick="action.response_fetch(this)" >' + com.com_excited + ' excited</span>');
      }
      else
      {
        $("#" + com_id).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="0" class="more_excite_json" onclick="action.response_fetch(this)"></span>');
      }
      if (com.postby == myprofileid || com.remove == 1 || (com.hasOwnProperty('admin_feed') && com.admin_feed == 1))
      {
        $("#" + com_id).append('<span class="del_post comment_setting" onclick="ui.post_delete(this)">x</span>');
      }
    });
    $(me).parent().remove();
  }

  function search(me, data)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    if (data.count >= 0)
    {
        console.log('cominng'+data.filter);
      $('#to').attr('value', data.key);
      if (data.count > 1)
      {
        $('#search_count').html('Search results :' + data.filter + ' matches for ' + data.key);
      }
      else if (data.count == 1)
      {
        $('#search_count').html('Search result :' + data.filter + ' match for ' + data.key);
      }
      else
      {
        $('#search_count').html('Search result : No ' + data.filter + ' match for ' + data.key);
        $('#center').append('<div style="text-align:center;margin:12em 0em;"><img src="' + icon_cdn + '/search_no_result.jpg"></div>');
      }
      //$('#search_result').html(''); 
      $.each(data.action, function(index, value)
      {
        if (data.filter == 'people')
        {
          $('#search_result').append('<div class="people_each"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="80" width="80" /></a><div class="name_80"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a></div></div>');
        }
        else if (data.filter == 'group')
        {
          $('#search_result').append('<div class="people_each"><a class="ajax_nav" href="group.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="80" width="80" /></a><div class="name_80"><a class="bold ajax_nav" href="group.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div>' + data.description[value.profileid] + '</div></div></div>');
        }
        else if (data.filter == 'event')
        {
          $('#search_result').append('<div class="people_each"><a class="ajax_nav" href="event.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="80" width="80" /></a><div class="name_80"><a class="bold ajax_nav" href="event.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div>' + data.description[value.profileid] + '</div></div></div>');
        }
        else if (data.filter == 'post' || data.filter == 'comment')
        {
          $('#search_result').append('<div class="people_each"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="80" width="80" /></a><div class="name_80"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div>' + ui.see_more(value.page) + '</div></div></div>');
        }
        else
        {
          $('#search_result').append('<div class="people_each"><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="80" width="80" /></a><div class="name_80"><a class="bold ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div style="margin-top:1em;">' + data.filter + ' matched: <b>' + value.page + '</b></div></div></div>');
        }
      });
    }
    else
    {
      $('#search_count').html('Please enter a search string');
      $('#center').append('<div style="text-align:center;margin:12em 0em;"><img src="' + icon_cdn + '/search_no_result.jpg"></div>');
    }
  }

  function tagline_preview(me, data)
  {
    if (data.action.length > 0)
    {
      $('#right').append('<div id="tagline_recent" class="panel panel-default"></div>');
      $('#tagline_recent').html('<div class="panel-heading" >Top Tagline from your network</div><div id ="tagline_recent_body" class="panel-body"></div>');
      $.each(data.action, function(index, value)
      {
        $('#tagline_' + value.actionby).remove();
        $('#tagline_recent_body').append('<div class="container_32_35 pointer" onclick="ui.redirect_to_action(' + value.actionid + ',\'' + value.life_is_fun + '\')" id="tagline_' + value.actionby + '"><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.actionby + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.actionby] + '" height="35" width="32" /></a><div class="name_32"><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.actionby + '&pl=diary">' + data.name[value.actionby] + '</a><div>' + value.tagline + '</div></div></div>');
      });
    }
    else
    {
      $('#tagline_recent').remove();
    }
  }

  function post_delete(me, data)
  {
    if (data.ack)
    {
      $('#nf_post_' + data.actionid).remove();
      $('#nf_post_' + data.pageid + '_' + data.actionid).remove();
      $('#if_post_' + data.pageid + '_' + data.actionid).remove();
      $('#pf_' + data.pageid + '_' + data.actionid).remove();
      $('.prompt_content').html('Action successfully performed');
      $('.prompt_container').remove();
      $('.prompt_button').html('<input id="prompt_ok" class="prompt_positive" type="submit" value="Ok" onClick=' + ui.bg_hide(this) + ' />');
    }
    else
    {
      $('.prompt_content').html('Error performing the action, please try again');
    }
  }

  function message_delete(me, data)
  {
    if (data.ack)
    {
      $('div#' + data.actionid + '.message_each').remove();
      $('.prompt_container').remove();
      $('.prompt_content').html('Action successfully performed');
      $('.prompt_button').html('<input id="prompt_ok" class="prompt_positive" type="submit" value="Ok" onClick=' + ui.bg_hide(this) + ' />');
    }
    else
    {
      $('.prompt_content').html('Error performing the action, please try again');
    }
  }

  function bio_update(me, data)
  {
    $("#save").html("Changes have been saved.");
    $(me).show();
  }

  function recover_password(me, data)
  {
    if (data == 2)
    {
      $('#recover_password_box').html('<h1>Your password has been updated successfully.</h1><h1>Please login to continue.</h1>');
    }
    else
    {
      $('#recover_password_info').html(data.error.message);
    }
  }

  function change_password(me, data)
  {
    if (data == 2)
    {
      $('#change_password_info').html('Your password has been updated successfully');
    }
    else
    {
      $('#change_password_info').html(data.error.message);
    }
  }

  function self_invite(me, data)
  {
    if (data.ack)
    {
      $('#signup_info').html(data.message);
      $('#signup_email').val('');
    }
    else
    {
      $('#signup_info').html(data.error.message);
    }
  }

  function register(me, data)
  {
    if ($.trim(data.ack) == 1)
    {
      $('#info').html("<span style=color:#00ff00>Fine</span>");
      window.location = '/';
    }
    else
    {
      $('#info').html('<span style="color:#ff2222">' + data.error.message + '</span>');
      $("#loading").remove();
      $(me).show();
    }
  }

  function event_leave(me, data)
  {
    var profileid = $('#profileid_hidden').attr('value');
    if (data.ack)
    {
      $('.prompt_content').html('You have successfully left the event');
      $('.prompt_button').html('<input class="prompt_positive" type="submit" value="Ok" onClick=' + ui.goBacktoProfile(profileid) + '/>');
    }
    else
    {
      $('.prompt_content').html('Error performing the action, please try again');
    }
  }

  function event_cancel(me, data)
  {
    var profileid = $('#profileid_hidden').attr('value');
    if (data.ack)
    {
      $('.prompt_content').html('You have successfully cancelled the event');
      $('.prompt_button').html('<input class="prompt_positive" type="submit" value="Ok" onClick=' + ui.goBacktoProfile(profileid) + '/>');
    }
    else
    {
      $('.prompt_content').html('Error performing the action, please try again');
    }
  }

  function group_leave(me, data)
  {
    var profileid = $('#profileid_hidden').attr('value');
    if (data.ack)
    {
      $('.prompt_content').html('You have successfully left the group');
      $('.prompt_button').html('<input class="prompt_positive" type="submit" value="Ok" onClick=' + ui.goBacktoProfile(profileid) + '/>');
    }
    else
    {
      $('.prompt_content').html('Error performing the action, please try again');
    }
  }

  function unfriend(me, data)
  {
    var profileid = $('#profileid_hidden').attr('value');
    var profile_name = $('#profilename_hidden').attr('value');
    if (data.ack)
    {
      $('.prompt_content').html(profile_name + ' has been successfully removed from your following list');
      $('.prompt_button').html('<input class="prompt_positive" type="submit" value="Ok" onClick=' + ui.goBacktoProfile(profileid) + '/>');
    }
    else
    {
      $('.prompt_content').html('Error performing the action, please try again');
    }
  }

  function profile_privacy_update(me, data)
  {
    var icon_cdn = $('#icon_cdn').attr('value');
    if (data.ack)
    {
      if (data.privacy == 0)
      {
        $(profile_post_privacy_link).html('<img title="Your next post will be shared with everyone on Quipmate" src="' + icon_cdn + '/global.png" height="14" width="14" />');
      }
      else if (data.privacy == 2)
      {
        $(profile_post_privacy_link).html('<img title="Your next post will be shared only with your followers" src="' + icon_cdn + '/friend.png" height="14" width="14" />');
      }
    }
  }

  function notification_setting_update(me)
  {
  }

  function feature_setting_update(me)
  {
  }

  function tagline(me, data)
  {
    if ($.trim(data) == '1')
    {
      $('#tagline_con').html('Your tagline has been successfully set.');
      $('#tagline_container').fadeOut(2000);
    }
  }

  function song_dedicate(me, data)
  {
    if (data.ack)
    {
      $('#song_dedicate_popup_container').html('<span>The song has been dedicated.</span>');
      $('#bg_hide').remove();
      $('#song_dedicate_popup_container').fadeOut(2000);
    }
  }

  function birthday_select(me, data)
  {
    if (data)
    {
      var count = 0,
          upcoming_count = 0;
      $.each(data.action, function(index, value)
      {
        var birthday = new Date(value.birthday * 1000);
        var today = new Date();
        birthday = birthday.toString();
        today = today.toString();
        var bday = birthday.substring(4, birthday.length - 45);
        var tday = today.substring(4, today.length - 45);
        if (tday == bday)
        {
          if (index == 0)
          {
            $('#birthday_today').append('<div id="birthday_today_body" class="panel-body"></div>');
          }
          $('#birthday_today_body').append('<div class="container_32_35" id="' + value.profileid + '"><input type="hidden" value="' + value.profileid + '" /><input type="hidden" value="' + value.b + '" /><input type="hidden" value="' + value.pageid + '" /><div><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.profileid + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="35" width="32" /></a></div><div class="name_32"><a class="ajax_nav"  style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.profileid + '&pl=diary">' + data.name[value.profileid] + '</a></div></div>');
          if (value.bomb_status)
          {
            $('#' + value.profileid).append('<div class="name_32">birthday wish<span class="birthday_bomb_count" title="Number of people who sent birthday wish">' + value.bomb_count + '</span></div>');
          }
          else
          {
            $('#' + value.profileid).append('<div class="birthday_bomb name_32" style="cursor:pointer;"  title="Click to add a birthday wish" onclick="ui.birthday_bomb(this,' + value.profileid + ',' + value.birthday + ',event)">+birthday wish<span class="birthday_bomb_count" title="Number of people who sent birthday wish">' + value.bomb_count + '</span></div>');
          }
          count++;
        }
        else
        {
          $('#friend_event_body').append('<div class="container_32_35"><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.profileid + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="35" width="32" /></a><div class="name_32"><a class="ajax_nav" style="color:#336699;font-weight:bold;" href="profile.php?id=' + value.profileid + '&pl=diary">' + data.name[value.profileid] + '</a><div>' + bday + '</div></div></div>');
          upcoming_count = 1;
        }
      });
      if (count)
      {
        $('#birthday_today').prepend('<div class="panel-heading">Birthday Today(' + count + ')</div>');
      }
      else
      {
        $('#birthday_today').remove();
      }
      if (data.action.length > 0)
      {
        $('#friend_event').prepend('<div class="panel-heading">Upcoming Events<span onclick="action.see_all_birthday(this)" style="float:right;cursor:pointer;font-size:.8em;margin:0.3em 1.5em 0 0;color:#336688;">More</span></div>');
      }
      else
      {
        $('#friend_event').remove();
      }
    }
    else
    {
      $('#friend_event').remove();
    }
    $.each(data.aevent, function(index, value)
    {
      $('#friend_event_body').append('<div class="container_32_35"><img class="lfloat" src="' + value.display_image + '" height="35" width="32" /><div class="name_32"><a class="ajax_nav" style="color:#336699;" href="event.php?id=' + value.eventid + '">' + value.name + '</a><div>' + value.date + '</div></div></div>');
    });
  }

  function birthday_select_all(data)
  {
    $('#center').html('<div class="right_item" ><div class="subtitle" style="">Colleagues\' Birthday</div></div>');
    $('#center').append('<table></table>');
    var i = 0;
    $.each(data.event, function(index, value)
    {
      if (i % 4 == 0)
      {
        $('table').append('<tr></tr>');
      }
      $('tr:last').append('<td style="color:blue;padding:2em;"><a class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.profileid + '&pl=diary"><img class="lfloat" src="' + data.pimage[value.profileid] + '" height="60" width="60" /></a><br /><a  class="ajax_nav" style="color:#336699;" href="profile.php?id=' + value.profileid + '&pl=diary">' + data.name[value.profileid] + '<br />' + value.birthday + ' </a></td>');
      i++;
    });
  }

  function getanalyticdetails(me, data)
  {
    //$('#center right_item').last().remove();
    $('#ana_left').remove();
    $('#center').append('<div class="right_item" id="ana_left" ><div id="anasub" style="">' + data.type + '</div><table  border="1px solid #D4D4D4" id="anatable"><tr><th>Total Post</th><th>Total Joined</th><th>Total Comment</th><th>Total Action</th></tr><tr><td>' + data.counts + '</td><td>' + data.joined + '</td><td>' + data.comment + '</td><td>' + data.total + '</td></tr></table></div>');
  }

  function group_and_event_select(me, data)
  {
    $.each(data.event, function(index, value)
    {
      $('#events_append').append('<li class="links"><a class="ajax_nav" href="event.php?id=' + value.eventid + '" title="Events"><span class="badge pull-right ellipsis "></span>' + value.eventname + '</a></li>');
    });
    $('#events_append').append('<li class=""><a href="#" onclick="ui.event_create(this)" title="Create an event"><span class="badge pull-right ellipsis "></span>Create Event</a></li>');
    $.each(data.group, function(index, value)
    {
      $('#groups_append').append('<li class="links"><a class="ajax_nav" href="group.php?id=' + value.groupid + '" title="Events"><span class="badge pull-right ellipsis"></span>' + value.groupname + '</a></li>');
    });
    $('#groups_append').append('<li class=""><a href="#" onclick="ui.group_create(this)" title="Create a group for people with a specific interest"><span class="badge pull-right ellipsis "></span>Create Group</a></li><li class=""><a  href="register.php?hl=group_suggest" title="Groups"><span class="badge pull-right ellipsis "></span>Browse Groups</a></li>');
  }

  function group_and_event_select_file(me, data)
  {
    var page = $('#page_hidden').attr('value');
    var hl ='';
    if(page == 'file')
    {
        hl ='file';
    }
    else if(page == 'video')
    {
        hl='video';
    }
    $.each(data.event, function(index, value)
    {
      $('.event_body').append('<div class="panel panel-default ajax_nav" href="event.php?id=' + value.eventid + '&hl='+hl+'"><div class="panel-heading pointer"><img src="' + icon_cdn + '/folder.png" width="20" height="20" /><h4 class="panel-title">' + value.eventname + '</h4></div></div>');
    });
    $.each(data.group, function(index, value)
    {
      $('.group_body').append('<div class="panel panel-default ajax_nav" href="group.php?id=' + value.groupid + '&hl='+hl+'"><div class="panel-heading pointer"><img src="' + icon_cdn + '/folder.png" width="20" height="20" /><h4 class="panel-title">' + value.groupname + '</h4></div></div>');
    });
  }

  function getanalyticdetails(me, data)
  {
    var day = [];
    var count = [];
    var i = 0;
    var j = 0;
    $.each(data.day, function(index, value)
    {
      day[i++] = value;
    });
    $.each(data.count, function(index, value)
    {
      count[j++] = value;
    });
    $('#chart').highcharts(
    {
      chart: {
        type: 'line'
      },
      title: {
        text: data.type
      },
      subtitle: {
        text: ' '
      },
      credits: {
        enabled: false
      },
      xAxis: {
        categories: JSON.parse("[" + day + "]")
      },
      yAxis: {
        title: {
          text: 'no.'
        }
      },
      plotOptions: {
        line: {
          dataLabels: {
            enabled: true
          },
          enableMouseTracking: false
        }
      },
      series: [
      {
        name: data.type,
        data: JSON.parse("[" + count + "]")
      }]
    });
  }
  return {
    enable_user: enable_user,
    bio_item_deply: bio_item_deply,
    share_post: share_post,
    getanalyticdetails: getanalyticdetails,
    group_and_event_select_file: group_and_event_select_file,
    group_and_event_select: group_and_event_select,
    contact: contact,
    getanalyticdetails: getanalyticdetails,
    employee_invite: employee_invite,
    usefullinks: usefullinks,
    usefullinks_fetch: usefullinks_fetch,
    usefullinks_load: usefullinks_load,
    designation: designation,
    designation_fetch: designation_fetch,
    designation_delete: designation_delete,
    team: team,
    team_fetch: team_fetch,
    team_delete: team_delete,
    moderator_remove: moderator_remove,
    make_moderator: make_moderator,
    feature_setting_update: feature_setting_update,
    page_create: page_create,
    message_delete: message_delete,
    birthday_select_all: birthday_select_all,
    birthday_select: birthday_select,
    answer: answer,
    add_friend: add_friend,
    birthday_all: birthday_all,
    bio_update: bio_update,
    bio_item_remove: bio_item_remove,
    change_password: change_password,
    comment: comment,
    comment_excite: comment_excite,
    event_create: event_create,
    event_cancel: event_cancel,
    event_join: event_join,
    event_suggest: event_suggest,
    event_leave: event_leave,
    group_suggest: group_suggest,
    group_suggest_page: group_suggest_page,
    forgot_password: forgot_password,
    friend_accept: friend_accept,
    friend_event: friend_event,
    friend_match: friend_match,
    friend_invite: friend_invite,
    friend_suggest: friend_suggest,
    friend_suggest_page: friend_suggest_page,
    friend_request_fetch: friend_request_fetch,
    friendship_preview: friendship_preview,
    feedback: feedback,
    group_top_influencer: group_top_influencer,
    gift: gift,
    gift_preview: gift_preview,
    group_create: group_create,
    group_invite: group_invite,
    group_join: group_join,
    group_leave: group_leave,
    group_settings_save: group_settings_save,
    guest_accept: guest_accept,
    message: message,
    member_accept: member_accept,
    message_drop: message_drop,
    member_request_fetch: member_request_fetch,
    message_recent_fetch: message_recent_fetch,
    missu: missu,
    missu_fetch: missu_fetch,
    missu_preview: missu_preview,
    mood: mood,
    mood_preview: mood_preview,
    option_add: option_add,
    post_delete: post_delete,
    profile_update: profile_update,
    profile_privacy_update: profile_privacy_update,
    question: question,
    doc_load: doc_load,
    notification_setting_update: notification_setting_update,
    recover_password: recover_password,
    register: register,
    request_fetch: request_fetch,
    response: response,
    response_fetch: response_fetch,
    responsed: responsed,
    self_invite: self_invite,
    search: search,
    sotw_fetch: sotw_fetch,
    flash_board_fetch: flash_board_fetch,
    csv_fetch: csv_fetch,
    document_fetch: document_fetch,
    addstar: addstar,
    addmd: addmd,
    md_load: md_load,
    md_remove: md_remove,
    doc_remove: doc_remove,
    sotw_load: sotw_load,
    star_remove: star_remove,
    show_all_comments: show_all_comments,
    tagline: tagline,
    tagline_preview: tagline_preview,
    unfriend: unfriend,
    user_details: user_details,
    praise_fetch: praise_fetch,
    groups_fetch: groups_fetch,
    groups_suggest_add: groups_suggest_add,
    group_suggest_remove: group_suggest_remove,
    group_add_fetch: group_add_fetch,
    pro_stat: pro_stat,
    usefullinks_delete: usefullinks_delete,
    user_delete: user_delete
  }
})();