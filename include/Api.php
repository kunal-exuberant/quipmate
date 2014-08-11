<?php
class Api
{
    function actiontype_preview()
    {
        global $help;
        if (isset($_GET['actiontype'])) {
            if (!empty($_GET['actiontype'])) {
                global $feed;
                global $database;
                global $memcached;
                global $json;
                global $encode;
                $actiontype = $_GET['actiontype'];
                $myprofileid = $_SESSION['userid'];
                global $action, $name, $pimage;
                $res = $database->actiontype_select($myprofileid, $actiontype, 0, 5);
                $k = 0;
                while ($NROW = $res->fetch_array()) {
                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $k++;
                }
                $data['action'] = $action;
                $data['myprofileid'] = $_SESSION['USERID'];
                $name[$data['myprofileid']] = $help->name_fetch($data['myprofileid'], $memcached,
                    $database);
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function action_fetch_life_is_not_always_fun()
    {
        global $help;
        if (isset($_GET['actionid']) && isset($_GET['life_is_fun'])) {
            if (!empty($_GET['actionid']) && !empty($_GET['life_is_fun'])) {
                global $action, $name, $pimage;
                global $feed;
                $actionid = $_GET['actionid'];
                $life_is_fun = $_GET['life_is_fun'];
                $data = array();
                global $database;
                global $memcached;
                global $json;
                global $encode;
                $r = $database->actionid_select($actionid);
                $k = 0;
                while ($NROW = $r->fetch_array()) {
                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $k++;
                }
                $data['action'] = $action;
                $data['myprofileid'] = $_SESSION['USERID'];
                $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                    $database);

                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function action_fetch()
    {
        global $help;
        if (isset($_GET['actionid']) && isset($_GET['life_is_fun'])) {
            if (!empty($_GET['actionid']) && !empty($_GET['life_is_fun'])) {
                global $action, $name, $pimage;
                global $feed;
                $actionid = $_GET['actionid'];
                $life_is_fun = $_GET['life_is_fun'];
                $validator = sha1($actionid . 'pass1reset!');
                if ($validator == $life_is_fun) {
                    $data = array();
                    global $database;
                    global $memcached;
                    global $json;
                    global $encode;
                    $r = $database->actionid_select($actionid);
                    $k = 0;
                    while ($NROW = $r->fetch_array()) {
                        $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                        $k++;
                    }
                    $data['action'] = $action;
                    $data['myprofileid'] = $_SESSION['USERID'];
                    $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                        $database);

                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    $data['tag'] = $_SESSION['tag_json'];
                    echo json_encode($data);
                } else {
                    $help->error_description(27);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_join()
    {
        global $help;
        if (isset($_GET['groupid'])) {
            $myprofileid = $_SESSION['userid'];
            $groupid = $_GET['groupid'];
            global $database;
            if ($database->group_exists($groupid) == $groupid) {
                $status = $database->membership_status($groupid, $myprofileid);
                if ($status == 3) {
                    $actionid = $database->get_actionid($groupid, 307, 0, 5);
                    $result = $database->member_request_insert($actionid, $groupid, $myprofileid,
                        time());
                    if ($result) {
                        $data['ack'] = 1;
                        $data['message'] = 'Requested';
                        echo json_encode($data);
                        $result = $database->group_admin_select($groupid);
                        while ($res = $result->fetch_array()) {
                            $admin_profileid = $res['profileid'];
                            $database->notice_insert($actionid, $admin_profileid, 307, $groupid);
                        }
                        $remail = $database->setting_email_select($myprofileid);
                        if ($remail['group_join']) {
                            global $email;
                            $param['type'] = 'group_join';
                            // $param[''] =
                            //$result = $email->email_sample($profileid,$myprofileid);
                        }
                    } else {
                        $help->error_description(15);
                    }
                } else
                    if ($status == 2) {
                        $data['ack'] = 0;
                        $data['message'] = "You have already requested to join this group";
                        echo json_encode($data);
                    } else {
                        $data['ack'] = 0;
                        $data['message'] = "You have already a member of this group";
                        echo json_encode($data);
                    }
            } else {
                echo $help->error_description(16);
            }
        } else {
            echo $help->error_description(9);
        }
    }

    function event_join()
    {
        global $help;
        if (isset($_GET['eventid'])) {
            $myprofileid = $_SESSION['userid'];
            $eventid = $_GET['eventid'];
            global $database;
            if ($database->event_exists($eventid) == $eventid) {
                $status = $database->guest_status($eventid, $myprofileid);
                if ($status == 4) {
                    $actionid = $database->get_actionid($eventid, 408, 0, 6);
                    $result = $database->guest_insert($actionid, $eventid, $myprofileid, 1);
                    if ($result) {
                        $data['ack'] = 1;
                        $data['message'] = 'Going';
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else
                    if ($status == 2 || $status == 3) {
                        $result = $database->guest_update($eventid, $myprofileid, 1);
                        if ($result) {
                            $data['ack'] = 1;
                            $data['message'] = 'Going';
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $data['ack'] = 1;
                        $data['message'] = 'Going';
                        echo json_encode($data);
                    }
            } else {
                echo $help->error_description(16);
            }
        } else {
            echo $help->error_description(9);
        }
    }

    function add_friend()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            $myprofileid = $_SESSION['USERID'];
            $profileid = $_GET['profileid'];
            global $database;
            $msg = $_GET['msg'];
            $check = $database->is_user($profileid);
            if ($check['USERID'] == $profileid) {
                $status = $database->check_friendship($myprofileid, $profileid);
                if ($status == 0) {
                    $actiontype = 7;
                    $actionid = $database->get_actionid($profileid, $actiontype);
                    $result = $database->friend_invite_insert($actionid, $profileid, $myprofileid);
                    if ($result) {
                        $data['ack'] = 1;
                        $data['message'] = 'Following ';
                        echo json_encode($data);
                        $rnotice = $database->setting_notice_select($profileid);
                        if ($rnotice['friend_request']) {
                            $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                        }
                        $remail = $database->setting_email_select($profileid);
                        if ($remail['friend_request']) {
                            global $email;
                            $param['type'] = 'friend_request';
                            $param['profileid'] = $profileid;
                            $param['friendid'] = $myprofileid;
                            $result = $email->email_sample($param);
                        }
                    } else {
                        $help->error_description(15);
                    }
                } else
                    if ($status == -1) {
                        $data['ack'] = 0;
                        $data['message'] = "You have already following";
                        echo json_encode($data);
                    } else
                        if ($status == 1) {
                            $data['ack'] = 0;
                            $data['message'] = "You are one of the followers";
                            echo json_encode($data);
                        } else
                            if ($status == 2) {
                                $data['ack'] = 0;
                                $data['message'] = "You are already following";
                                echo json_encode($data);
                            } else
                                if ($status == 3) {
                                    $data['ack'] = 0;
                                    $data['message'] = "Are you crazy? You want to follow yourself ! Well you already are!";
                                    echo json_encode($data);
                                } else {
                                    echo $help->error_description(-1);
                                }
            } else {
                echo $help->error_description(16);
            }
        } else {
            echo $help->error_description(9);
        }
    }

    function album_fetch()
    {
        global $help;
        if (isset($_GET['start'])) {
            if ($_GET['start'] != '') {
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                if (is_numeric($start)) {
                    $data = array();
                    $photo = array();
                    global $database;
                    $r = $database->photo_friend_select($myprofileid, $start, '5');
                    $k = 0;
                    while ($row = $r->fetch_array()) {
                        $photo[$k]['file'] = $row['CDN'] . $row['FILENAME'];
                        $photo[$k]['profileid'] = $row['PROFILEID'];
                        $photo[$k]['actionby'] = $row['ACTIONBY'];
                        $photo[$k]['actionid'] = $row['ACTIONID'];

                        global $memcached;

                        $name[$photo[$k]['actionby']] = $help->name_fetch($photo[$k]['actionby'], $memcached,
                            $database);
                        $pimage[$photo[$k]['actionby']] = $help->pimage_fetch($photo[$k]['actionby'], $memcached,
                            $database);

                        if ($photo[$k]['actionby'] != $photo[$k]['profileid']) {
                            $name[$photo[$k]['actionby']] = $help->name_fetch($photo[$k]['profileid'], $memcached,
                                $database);
                            $pimage[$photo[$k]['actionby']] = $help->pimage_fetch($photo[$k]['profileid'], $memcached,
                                $database);
                        }
                        $k++;
                    }
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    $data['action'] = $photo;
                    echo json_encode($data);
                } else {
                    $help->error_description(18);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function album_upload()
    {
        global $help;
        global $photo_cdn;
        global $video_cdn;
        $profileid = $_POST['moment_hidden_profileid'];
        $moment_name = $_POST['moment_name'];
        $count = $_POST['moment_photo_count'];
        $valid_formats = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg");
        $myprofileid = $_SESSION['userid'];
        $visible_id = $_SESSION['visible'];
        $actiontype = 5;
        if ($count == '') {
            $data['ack'] = 5;
            echo json_encode($data);
            exit();
        }
        while ($count >= 0) {
            $name = $_FILES['photo_box']['name'][$count];
            $size = $_FILES['photo_box']['size'][$count];
            if (strlen($name)) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), $valid_formats)) {
                    if ($size < (10240 * 1024)) {
                        ;
                    } else {
                        $data['ack'] = 3;
                        echo json_encode($data);
                        exit();
                    }
                } else {
                    $data['ack'] = 4;
                    echo json_encode($data);
                    exit();
                }
            } else {
                $data['ack'] = 5;
                json_encode($data);
                exit();
            }
            $count--;
        }

        global $database;
        $aid = $database->get_actionid($profileid, $actiontype, 0, $visible_id);
        $count = $_POST['moment_photo_count'];
        $c = $count + 1;
        $momentid = $database->moment_insert($profileid, $aid, $c, $moment_name, $desc =
            '');
        $data = array();
        $data['actionid'] = $aid;
        $data['life_is_fun'] = sha1($aid . 'pass1reset!');
        $data['time'] = time();
        $data['mname'] = $moment_name;
        $data['count'] = $c;
        $data['desc'] = $desc;
        $k = 0;
        while ($count >= 0) {
            $time = round(microtime(true) * 1000);
            $actual_image_name[$count] = $count . $time . "." . $ext;
            //Have used system function to read time in nanosecond format .

            $tmp = $_FILES['photo_box']['tmp_name'][$count];
            //$filename = $help->photo_name($ext);
            $filename = $_SESSION['userid'] . '_' . $time . '.' . $ext;
            if ($actual_image_name[$count] = $help->cdn_upload($tmp, 'photo', $filename)) {
                $caption = $_SESSION['NAME'];
                $actionid = array();
                $visible_id = $_SESSION['visible'];
                $actionid[$count] = $database->get_actionid($profileid, 51, -1, $visible_id);
                if ($actionid[$count]) {
                    $result = $database->image_insert($profileid, $actionid[$count], $actual_image_name[$count],
                        $momentid, $photo_cdn . '/');
                    $photo[$k]['file'] = $photo_cdn . '/' . $actual_image_name[$count];
                    $photo[$k]['actionid'] = $actionid[$count];
                    $data['ack'] = 1;
                    $k++;
                }
            } else {
                $data['ack'] = 2;
            }
            $count--;
        }
        $data['photo'] = $photo;
        echo json_encode($data);
        if ($profileid != $myprofileid) {
            $rnotice = $database->setting_notice_select($profileid);
            if ($rnotice['profile_post']) {
                $database->notice_insert($aid, $profileid, $actiontype, $aid);
            }
            $remail = $database->setting_email_select($profileid);
            if ($remail['profile_post']) {
                global $email;
                $param = array();
                $param['type'] = 'profile_post';
                $param['profileid'] = $profileid;
                $param['page'] = $moment_name;
                $param['actionby'] = $myprofileid;
                $param['actionid'] = $aid;
                $email->email_sample($param);
            }
        }
    }

    function birthday_select_all()
    {
        $data = array();
        $event = array();
        $today = array();
        $k = 0;
        $i = 0;
        $flag = 0;
        global $help;
        $myprofileid = $_SESSION['userid'];
        global $database;
        if ($bday = $database->birthday_select_next($myprofileid)) {
            global $memcached;
            while ($res = $bday->fetch_array()) {
                $birthday = $res['BIRTHDAY'];
                if (date('jS,M') == $birthday) {
                    $birthday = 'Today';
                }
                $event[$k]['profileid'] = $res['PROFILEID'];
                $event[$k]['birthday'] = $birthday;
                $name[$event[$k]['profileid']] = $help->name_fetch($event[$k]['profileid'], $memcached,
                    $database);
                $pimage[$event[$k]['profileid']] = $help->pimage_fetch($event[$k]['profileid'],
                    $memcached, $database);
                if ($i >= 30) {
                    $flag = 1;
                    break;
                }
                $i++;
                $k++;
            }
            if ($flag == 0) {
                $bday = $database->birthday_select_prev($myprofileid);
                while ($res = $bday->fetch_array()) {
                    $birthday = $res['BIRTHDAY'];
                    if (date('jS,M') == $birthday) {
                        $birthday = 'Today';
                    }
                    $event[$k]['profileid'] = $res['PROFILEID'];
                    $event[$k]['birthday'] = $birthday;
                    $name[$event[$k]['profileid']] = $help->name_fetch($event[$k]['profileid'], $memcached,
                        $database);
                    $pimage[$event[$k]['profileid']] = $help->pimage_fetch($event[$k]['profileid'],
                        $memcached, $database);
                    if ($i >= 90) {
                        break;
                    }
                    $i++;
                    $k++;
                }
            }
            $data['event'] = $event;
            $data['name'] = $name;
            $data['pimage'] = $pimage;
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }
    }

    function member_load()
    {
        global $help;
        if (isset($_GET['groupid']) && isset($_GET['start'])) {
            if (!empty($_GET['groupid']) && $_GET['start'] != '') {
                $data = array();
                $member = array();
                $groupid = $_GET['groupid'];
                $start = $_GET['start'];
                global $database;
                global $memcached;
                $result = $database->member_select($groupid, $start);
                if ($result->num_rows) {
                    $k = 0;
                    while ($row = $result->fetch_array()) {
                        $member[$k]['profileid'] = $row['profileid'];
                        $member[$k]['priviledge'] = $row['priviledge'];
                        $name[$member[$k]['profileid']] = $help->name_fetch($member[$k]['profileid'], $memcached,
                            $database);
                        $pimage[$member[$k]['profileid']] = $help->pimage_fetch($member[$k]['profileid'],
                            $memcached, $database);
                        $k++;
                    }
                    $data['count'] = $result->num_rows;
                    $data['action'] = $member;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function guest_load()
    {
        global $help;
        if (isset($_GET['eventid']) && isset($_GET['start'])) {
            if (!empty($_GET['eventid']) && $_GET['start'] != '') {
                $data = array();
                $going = array();
                $declined = array();
                $no_response = array();
                $eventid = $_GET['eventid'];
                $start = $_GET['start'];
                global $database;
                global $memcached;
                $result = $database->guest_select($eventid, $start);
                if ($result->num_rows) {
                    $k = 0;
                    while ($row = $result->fetch_array()) {
                        if ($row['priviledge'] == 0) {
                            $no_response[]['profileid'] = $row['profileid'];
                        } else
                            if ($row['priviledge'] == 1) {
                                $going[]['profileid'] = $row['profileid'];
                            } else
                                if ($row['priviledge'] == 2) {
                                    $declined[]['profileid'] = $row['profileid'];
                                }
                        $name[$row['profileid']] = $help->name_fetch($row['profileid'], $memcached, $database);
                        $pimage[$row['profileid']] = $help->pimage_fetch($row['profileid'], $memcached,
                            $database);
                        $k++;
                    }
                    //$data['count'] = $result->num_rows;
                    $action['going'] = $going;
                    $action['declined'] = $declined;
                    $action['no_response'] = $no_response;
                    $data['action'] = $action;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function following_load()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['start'])) {
            if (!empty($_GET['profileid']) && $_GET['start'] != '') {
                $profileid = $_GET['profileid'];
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                global $database;
                global $memcached;
                $result = $database->following_select_incremental($profileid, $start, '50');
                $data = array();
                $friend = array();
                $k = 0;
                while ($row = $result->fetch_array()) {
                    $friendid = $row['FRIENDID'];
                    if ($profileid != $myprofileid) {
                        $status = $database->check_friendship($friendid, $myprofileid);
                    } else {
                        $status = 3;
                    }

                    $name[$friendid] = $help->name_fetch($friendid, $memcached, $database);
                    $pimage[$friendid] = $help->pimage_fetch($friendid, $memcached, $database);

                    $friend[$k]['profileid'] = $friendid;
                    $friend[$k]['status'] = $status;
                    $k++;
                }
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['action'] = $friend;
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function followers_load()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['start'])) {
            if (!empty($_GET['profileid']) && $_GET['start'] != '') {
                $profileid = $_GET['profileid'];
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                global $database;
                global $memcached;
                $result = $database->followers_select_incremental($profileid, $start, '50');
                $data = array();
                $friend = array();
                $k = 0;
                while ($row = $result->fetch_array()) {
                    $friendid = $row['FRIENDID'];
                    if ($profileid != $myprofileid) {
                        $status = $database->check_friendship($friendid, $myprofileid);
                    } else {
                        $status = 3;
                    }

                    $name[$friendid] = $help->name_fetch($friendid, $memcached, $database);
                    $pimage[$friendid] = $help->pimage_fetch($friendid, $memcached, $database);

                    $friend[$k]['profileid'] = $friendid;
                    $friend[$k]['status'] = $status;
                    $k++;
                }
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['action'] = $friend;
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function friend_fetch()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            $profileid = $_GET['profileid'];
        } else {
            $profileid = $_SESSION['userid'];
        }
        global $database;
        global $memcached;
        $res = $database->message_order($profileid);
        $k = 0;
        $friend = array();
        $name = array();
        $pimage = array();
        $value = $memcached->get($_SESSION['database'] . '_friend_' . $profileid);
        if ($value) {
            $friend = $value;
            foreach ($friend as $f) {
                $name[$f] = $help->name_fetch($f, $memcached, $database);
                $pimage[$f] = $help->pimage_fetch($f, $memcached, $database);
            }
        } else {
            while ($NROW = $res->fetch_array()) {
                if ($NROW['ACTIONBY'] == $profileid) {
                    if (!in_array($NROW['ACTIONON'], $friend)) {
                        if ($database->check_friendship($profileid, $NROW['ACTIONON']) == 2) {
                            $friend[] = $NROW['ACTIONON'];
                            $name[$friend[$k]] = $help->name_fetch($friend[$k], $memcached, $database);
                            $pimage[$friend[$k]] = $help->pimage_fetch($friend[$k], $memcached, $database);
                            $k++;
                        }
                    }
                } else
                    if ($NROW['ACTIONON'] == $profileid) {
                        if (!in_array($NROW['ACTIONBY'], $friend)) {
                            if ($database->check_friendship($profileid, $NROW['ACTIONBY']) == 2) {
                                $friend[] = $NROW['ACTIONBY'];
                                $name[$friend[$k]] = $help->name_fetch($friend[$k], $memcached, $database);
                                $pimage[$friend[$k]] = $help->pimage_fetch($friend[$k], $memcached, $database);
                                $k++;
                            }
                        }
                    }
            }
            $res = $database->friend_select($profileid);
            while ($NROW = $res->fetch_array()) {
                if (!in_array($NROW['FRIENDID'], $friend)) {
                    $friend[] = $NROW['FRIENDID'];
                    $name[$friend[$k]] = $help->name_fetch($friend[$k], $memcached, $database);
                    $pimage[$friend[$k]] = $help->pimage_fetch($friend[$k], $memcached, $database);
                    $k++;
                }
            }
        }
        $memcached->set($_SESSION['database'] . '_friend_' . $profileid, $friend);
        $data['ack'] = 1;
        $data['action'] = $friend;
        $data['friend_count'] = count($friend);
        $data['name'] = $name;
        $data['pimage'] = $pimage;
        echo json_encode($data);
    }

    function friend_fetch_incremental()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['start'])) {
            if (!empty($_GET['profileid']) && $_GET['start'] != "") {
                $data = array();
                $friend = array();
                $profileid = $_GET['profileid'];
                $start = $_GET['start'];
                global $database;
                global $memcached;
                $result = $database->friend_select_incremental($profileid, $start, 20);
                if ($result->num_rows) {
                    $k = 0;
                    while ($row = $result->fetch_array()) {
                        $friend[$k] = $row['FRIENDID'];
                        $name[$friend[$k]] = $help->name_fetch($friend[$k], $memcached, $database);
                        $pimage[$friend[$k]] = $help->pimage_fetch($friend[$k], $memcached, $database);
                        $k++;
                    }
                    $data['count'] = $database->friend_count($profileid);
                    $data['action'] = $friend;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function event_invite()
    {
        global $help;
        if (isset($_GET['eventid']) && isset($_GET['profileid'])) {
            if (!empty($_GET['eventid']) && !empty($_GET['profileid'])) {
                global $database;
                $data = array();
                $myprofileid = $_SESSION['userid'];
                $eventid = $_GET['eventid'];
                $profileid = $_GET['profileid'];
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($profileid != $myprofileid) {
                        $erw = $database->event_select($eventid);
                        if ($erw['groupid'] == 0) {
                            if ($database->guest_status($eventid, $profileid) == 4) {
                                $res = 0;
                                $actiontype = 408;
                                $actionid = $database->get_actionid($eventid, $actiontype, 0, 6);
                                $result = $database->guest_insert($actionid, $eventid, $profileid, 0);
                                $rnotice = $database->setting_notice_select($profileid);
                                if ($rnotice['event_invite']) {
                                    $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                                }
                                $remail = $database->setting_email_select($profileid);
                                if ($remail['event_invite']) {
                                    $param = array();
                                    global $email;
                                    $param['type'] = 'event_invite';
                                    $param['actionby'] = $myprofileid;
                                    $param['profileid'] = $profileid;
                                    $param['eventid'] = $eventid;
                                    $result = $email->email_sample($param);
                                }
                                $data['ack'] = 1;
                                $data['response'] = 1;
                                $data['message'] = 'Friend invited to the event';
                                echo json_encode($data);
                            } else {
                                $help->error_description(38);
                            }
                        } else {
                            $help->error_description(41);
                        }
                    } else {
                        $help->error_description(2);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_invite()
    {
        global $help;
        if (isset($_GET['groupid']) && isset($_GET['profileid'])) {
            if (!empty($_GET['groupid']) && !empty($_GET['profileid'])) {
                global $database;
                $data = array();
                $myprofileid = $_SESSION['userid'];
                $groupid = $_GET['groupid'];
                $profileid = $_GET['profileid'];
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($profileid != $myprofileid) {
                        $status = $database->membership_status($groupid, $profileid);
                        if ($status != 0 && $status != 1) {
                            $res = 0;
                            $actiontype = 308;
                            $actionid = $database->get_actionid($groupid, $actiontype, 0, 5);
                            $result = $database->member_insert($actionid, $groupid, $profileid, 0);
                            $rnotice = $database->setting_notice_select($profileid);
                            if ($rnotice['group_invite']) {
                                $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                            }
                            $remail = $database->setting_email_select($profileid);
                            if ($remail['group_invite']) {
                                $param = array();
                                global $email;
                                $param['type'] = 'event_invite';
                                $param['actionby'] = $myprofileid;
                                $param['profileid'] = $profileid;
                                $param['groupid'] = $groupid;
                                $result = $email->email_sample($param);
                            }
                            $data['ack'] = 1;
                            $data['response'] = 1;
                            $data['message'] = 'Member added to the group';
                            echo json_encode($data);
                        } else {
                            $help->error_description(33);
                        }
                    } else {
                        $help->error_description(2);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function guest_accept()
    {
        global $help;
        if (isset($_GET['eventid']) && isset($_GET['flag'])) {
            if (!empty($_GET['eventid']) && $_GET['flag'] != '') {
                global $database;
                $data = array();
                $myprofileid = $_SESSION['userid'];
                $eventid = $_GET['eventid'];
                $flag = $_GET['flag'];
                if ($database->guest_status($eventid, $myprofileid) == 2) {
                    if ($flag == 0) {
                        $result = $database->guest_update($eventid, $myprofileid, 2);
                        if ($result) {
                            $data['ack'] = 1;
                            $data['response'] = 0;
                            $data['message'] = 'Event request declined';
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }
                    } else
                        if ($flag == 1) {
                            $result = $database->guest_update($eventid, $myprofileid, 1);
                            if ($result) {
                                $data['ack'] = 1;
                                $data['response'] = 1;
                                $data['message'] = 'Event request accepted';
                                echo json_encode($data);
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                } else {
                    $help->error_description(21);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function member_request_accept()
    {
        global $help;
        if (isset($_GET['groupid']) && isset($_GET['profileid']) && isset($_GET['flag'])) {
            if (!empty($_GET['groupid']) && !empty($_GET['profileid']) && $_GET['flag'] !=
                '') {
                global $database;
                $data = array();
                $myprofileid = $_SESSION['userid'];
                $groupid = $_GET['groupid'];
                $profileid = $_GET['profileid'];
                $flag = $_GET['flag'];
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($profileid != $myprofileid) {
                        $status = $database->membership_status($groupid, $profileid);
                        if ($status != 0 && $status != 1) {
                            if ($flag == 0) {
                                $ra = $database->member_request_actionid_select($groupid, $profileid);
                                $did = $ra['actionid'];
                                $res = 0;
                                $res = $database->action_delete($did);
                                if ($res) {
                                    $data['ack'] = 1;
                                    $data['response'] = 0;
                                    $data['message'] = 'Member request rejected';
                                    echo json_encode($data);
                                } else {
                                    $help->error_description(15);
                                }
                            } else
                                if ($flag == 1) {
                                    $actiontype = 308;
                                    $actionid = $database->get_actionid($groupid, $actiontype, 0, 5);
                                    $result = $database->member_insert($actionid, $groupid, $profileid, 0);
                                    $ra = $database->member_request_actionid_select($groupid, $profileid);
                                    $did = $ra['actionid'];
                                    $res = 0;
                                    $res = $database->action_delete($did);
                                    if ($res == 1) {
                                        $rnotice = $database->setting_notice_select($profileid);
                                        if ($rnotice['group_invite']) {
                                            $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                                        }
                                        $remail = $database->setting_email_select($profileid);
                                        if ($remail['group_invite']) {
                                            $param = array();
                                            global $email;
                                            $param['type'] = 'friend_confirm';
                                            $param['actionby'] = $myprofileid;
                                            $param['profileid'] = $profileid;
                                            $result = $email->email_sample($param);
                                        }
                                        $data['ack'] = 1;
                                        $data['response'] = 1;
                                        $data['message'] = 'Member request accpted';
                                        echo json_encode($data);
                                    }
                                } else {
                                    $help->error_description(21);
                                }
                        } else {
                            $help->error_description(21);
                        }
                    } else {
                        $help->error_description(2);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function friend_request_accept()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['flag'])) {
            if (!empty($_GET['profileid']) && $_GET['flag'] != '') {
                global $database;
                $data = array();
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                $flag = $_GET['flag'];
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($profileid != $myprofileid) {
                        $status = $database->check_friendship($myprofileid, $profileid);
                        if ($status == 1 || $status == -1) {
                            if ($flag == 0) {
                                $result = $database->friend_invite_delete($myprofileid, $profileid);
                                if ($result) {
                                    $data['ack'] = 1;
                                    $data['response'] = 0;
                                    $data['message'] = 'Friend request rejected';
                                    echo json_encode($data);
                                } else {
                                    $help->error_description(15);
                                }
                            } else
                                if ($flag == 1) {
                                    $result = 0;
                                    $result = $database->friend_insert($myprofileid, $profileid);
                                    if ($result) {
                                        global $memcached;
                                        $help->friend_memcache_update($myprofileid, $database, $memcached);
                                        $help->friend_memcache_update($profileid, $database, $memcached);
                                        $res = 0;
                                        $res = $database->friend_invite_delete($myprofileid, $profileid);
                                        if ($res == 1) {
                                            $visible_id = $_SESSION['visible'];
                                            $actiontype = 8;
                                            $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible_id);
                                            if ($actionid) {
                                                $rnotice = $database->setting_notice_select($profileid);
                                                if ($rnotice['friend_confirm']) {
                                                    $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                                                }
                                                $remail = $database->setting_email_select($profileid);
                                                if ($remail['friend_confirm']) {
                                                    $param = array();
                                                    global $email;
                                                    $param['type'] = 'friend_confirm';
                                                    $param['friendid'] = $profileid;
                                                    $param['profileid'] = $myprofileid;
                                                    $result = $email->email_sample($param);
                                                }
                                            }
                                            $data['ack'] = 1;
                                            $data['response'] = 1;
                                            $data['message'] = 'Friend request accpted';
                                            echo json_encode($data);
                                        }
                                    } else {
                                        $help->error_description(15);
                                    }
                                } else {
                                    $help->error_description(21);
                                }
                        } else {
                            $help->error_description(21);
                        }
                    } else {
                        $help->error_description(2);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function birthday_bomb()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['wish']) && isset($_GET['date'])) {
            if (!empty($_GET['profileid']) && !empty($_GET['wish']) && !empty($_GET['date'])) {
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                $wish = $_GET['wish'];
                $date = $_GET['date'];
                global $database;
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($database->check_friendship($myprofileid, $profileid) == 2) {
                        if (strlen($wish) <= 200) {
                            $visible_id = $_SESSION['visible'];
                            $actionid = $database->get_actionid($profileid, 1900, 0, $visible_id);
                            $database->diary_insert($actionid, $wish);
                            $yr = explode('-', $date);
                            $date = '2013' . '-' . $yr[1] . '-' . $yr[2];
                            $result = $database->birthday_bomb_insert($actionid, $profileid, $myprofileid, $date);
                            if ($result) {
                                $param = array();
                                global $email;
                                $param['type'] = 'birthday_bomb';
                                $param['actionby'] = $myprofileid;
                                $param['profileid'] = $profileid;
                                $param['actionid'] = $actionid;
                                $param['wish'] = $wish;
                                $result = $email->email_sample($param);
                                echo json_encode(1);
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function employee_invite_file_upload()
    {
        global $doc_cdn;
        $valid_formats = array("csv");
        $name = $_FILES['photo_box']['name'];
        $size = $_FILES['photo_box']['size'];
        $description = $_POST['photo_description'];
        $existing = array();
        $invited = array();
        $invalid = array();
        $profileid = $_SESSION['userid'];
        global $help;
        if (strlen($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            if (in_array(strtolower($ext), $valid_formats)) {
                $actiontype = 3000;
                $container = 'photo';
                $cdn = $doc_cdn . '/';
                $limit = 10240 * 1024;
            } else {
                $data['ack'] = 4;
                echo json_encode($data);
                exit(1);
            }
            if ($size < $limit) {
                $tmp = $_FILES['photo_box']['tmp_name'];
                global $database;
                if (($handle = fopen($tmp, "r")) !== false) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        $emails[] = $data[14];
                    }
                   // print_r($email_value);
                    fclose($handle);
                    foreach ($emails as $email_value) {
                        if ($help->is_email($email_value)) {

                            if ($_SESSION['database'] == $help->get_database_from_email($email_value, $database)) {
                                $myname = $_SESSION['name'];
                                $myphoto = $_GET['myphoto'];
                                $myprofileid = $_SESSION['userid'];
                                if ($email_value == $myemail) {
                                    array_push($existing, $email_value);
                                } else
                                    if ($help->is_email($email_value)) {
                                        $row = $database->is_already_user($email_value);
                                        if ($row['EMAIL'] == $email_value) {
                                            array_push($existing, $email_value);
                                        } else {
                                            $row = $database->is_virtual_user($email_value);
                                            if ($row['ack']) {
                                                array_push($invited, $email_value);
                                                $identifier = $row['uniqueid'];
                                            } else {
                                                $virtualid = $database->virtual_create($email_value);
                                                $vr = $database->v_select($virtualid);
                                                $identifier = $vr['UNIQUEID'];
                                                array_push($invited, $email_value);
                                            }

                                            $param = array();
                                            $param['type'] = 'people_invite';
                                            $param['email'] = $email_value;
                                            $param['identifier'] = $identifier;
                                            $param['myname'] = $myname;
                                            //		$param['myphoto'] = $myphoto;
                                            $param['actionby'] = $myprofileid;
                                            $email_object = new email();
                                            $er = $email_object->email_sample($param);

                                        }
                                    } else {
                                        array_push($invalid, $email_value);
                                    }
                            } else {
                                array_push($invalid, $email_value);
                            }


                        }
                    }
                    $data['invalid'] = $invalid;
                    $data['invited'] = $invited;
                    $data['existing'] = $existing;
                    $data['ack'] = 1;
                    echo json_encode($data);
                }

            } else {
                $help->error_description(12);
            }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }


    function set_MD()
    {
        global $help;
        if (isset($_GET['id']) && isset($_GET['value'])) {
            if (!empty($_GET['id'])) {
                global $database;

                $id = $_GET['id'];
                if ($database->is_user($id)) {
                    if (!$result = $database->check_MD()) {

                        if ($database->set_MD($id)) {
                            $data[ack] = 1;
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $data[ack] = 2;
                        echo json_encode($data);
                    }
                } else {
                    $help->error_description(16);
                }


            } else {
                $help->error_description(18);
            }
        } else
            if (!isset($_GET['id']) && isset($_GET['value'])) {
                if (!empty($_GET['value'])) {
                    $email = strtolower($_GET['value']);
                    if ($help->is_email($email)) {

                        $e = explode('@', $email);
                        $db = explode('.', $e[1]);

                        if ($_SESSION['database'] == $db[0]) {
                            $myname = $_SESSION['NAME'];
                            $myphoto = $_SESSION['pimage'];
                            $myprofileid = $_SESSION['userid'];
                            $param = array();
                            $param['type'] = 'MD_invite';
                            $param['email'] = $email;
                            $param['subject'] = 'REQUEST TO JOIN COMPANY NETWORK';
                            $param['myname'] = $myname;
                            $param['myphoto'] = $myphoto;
                            $param['actionby'] = $myprofileid;
                            $email_object = new email();
                            $er = $email_object->email_sample($param);
                            if ($er) {
                                $data['ack'] = 2;
                                echo json_encode($data);
                            }

                        }
                    } else {
                        $help->error_description(23);
                    }

                } else {
                    $help->error_description(18);
                }
            } else {
                $help->error_description(9);
            }

    }


    function md_load()
    {
        global $help, $database, $memcached;
        $action = array();
        $myprofileid = $_SESSION['userid'];
        $result = array();
        if ($database->moderator_check($myprofileid)) {
            if ($result = $database->MD_select()) {
                $action['profileid'] = $result['PROFILEID'];
                $action['name'] = $help->name_fetch($result['PROFILEID'], $memcached, $database);
                $action['image'] = $help->pimage_fetch($result['PROFILEID'], $memcached, $database);


                $data['action'] = $action;
                echo json_encode($data);
            } else {
                $help->error_description(15);
            }
        } else {
            $help->error_description(12);
        }
    }


    function birthday_bomb_fetch()
    {
        global $help;
        $data = array();
        $event = array();
        $name = array();
        $pimage = array();
        $k = 0;
        $i = 0;
        $myprofileid = $_SESSION['userid'];
        global $database;
        $e = $database->select_event($myprofileid);
        $m = 0;
        while ($res = $e->fetch_array()) {
            $a[$m]['name'] = $res['name'];
            $a[$m]['eventid'] = $res['eventid'];
            $a[$m]['date'] = $res['DATE'];
            $a[$m]['display_image'] =
                'https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/event.png';
            $m++;
        }
        $data['aevent'] = $a;

        $bday = $database->birthday_select($myprofileid);
        while ($res = $bday->fetch_array()) {
            $birthday = $res['BIRTHDAY'];
            $event[$k]['profileid'] = $res['PROFILEID'];
            $yr = explode('-', $birthday);
            $d = date('Y') . '-' . $yr[1] . '-' . $yr[2];
            $b = $database->birthday_bomb_select($event[$k]['profileid'], $d);
            $event[$k]['bomb_count'] = $b->num_rows;
            $event[$k]['bomb_status'] = 0;
            while ($br = $b->fetch_array()) {
                if ($br['ACTIONBY'] == $myprofileid) {
                    $event[$k]['bomb_status'] = 1;
                }
                $event[$k]['pageid'] = $br['ACTIONID'];
            }
            $event[$k]['b'] = $birthday;
            $event[$k]['birthday'] = strtotime($birthday);
            $i++;
            global $memcached;
            global $database;
            $name[$res['PROFILEID']] = $help->name_fetch($res['PROFILEID'], $memcached, $database);
            $pimage[$res['PROFILEID']] = $help->pimage_fetch($res['PROFILEID'], $memcached,
                $database);

            if ($i >= 3) {
                break;
            }
            $k++;
        }
        $data['action'] = $event;
        $data['name'] = $name;
        $data['pimage'] = $pimage;
        echo json_encode($data);
    }


    function callback()
    {
        global $help;
        $type = $_GET['type'];
        $k = $_GET['k'];
        if (isset($_GET['type']) && isset($_GET['k'])) {
            if (!empty($_GET['type']) && !empty($_GET['k'])) {
                global $database;
                $result = $database->data_select($type, $k);
                $n = 0;
                $data = array();
                while ($back = $result->fetch_array()) {
                    if (trim($back['NAME']) != "") {
                        $data[$n]['id'] = $back['ID'];
                        $data[$n]['school'] = $back['NAME'];
                    }
                    $n++;
                }
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function callback_not_found()
    {
        global $help;
        $myprofileid = $_SESSION['USERID'];
        if (isset($_GET['type']) && isset($_GET['name'])) {
            if (!empty($_GET['type']) && !empty($_GET['name'])) {
                $type = $_GET['type'];
                $name = ucwords(strtolower($_GET['name']));
                global $database;
                $back = $database->mydiary_create(0, $type, $name, '');
                if ($back != 0) {
                    $data['diaryid'] = $back['DIARYID'];
                    echo json_encode($data);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function change_password()
    {
        global $help;
        if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
            if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
                global $database;
                $myprofileid = $_SESSION['userid'];
                $email = $_SESSION['EMAIL'];
                if ($password = $database->password_select($myprofileid)) {
                    $crypt = sha1($email . $_POST['old_password']);
                    if ($password == $crypt) {
                        if (strlen($_POST['new_password']) > 5) {
                            if ($_POST['new_password'] == $_POST['confirm_password']) {
                                if ($_POST['new_password'] != $_POST['old_password']) {
                                    $crypt = sha1($email . $_POST['new_password']);
                                    $crypt2 = sha1($email . $_POST['new_password'] . 'pass1reset!');
                                    $update = $database->password_gain($crypt, $crypt2, $email);
                                    if ($update) {
                                        echo json_encode(2);
                                    } else {
                                        $help->error_description(15);
                                    }
                                } else {
                                    $help->error_description(30);
                                }
                            } else {
                                $help->error_description(25);
                            }
                        } else {
                            $help->error_description(26);
                        }
                    } else {
                        $help->error_description(31);
                    }
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function recover_password()
    {
        global $help;
        if (isset($_POST['email']) && isset($_POST['id']) && isset($_POST['new_password']) &&
            isset($_POST['confirm_password'])) {
            if (!empty($_POST['email']) && !empty($_POST['id']) && !empty($_POST['new_password']) &&
                !empty($_POST['confirm_password'])) {
                global $database;
                $email = $_POST['email'];
                if ($uniqueid = $database->select_uniqueid($email)) {
                    $id = $_POST['id'];
                    if ($uniqueid == $id) {
                        $pass = $_POST['new_password'];
                        if (strlen($pass) > 5) {
                            $confirmpass = $_POST['confirm_password'];
                            if ($pass == $confirmpass) {
                                $crypt = sha1($email . $pass);
                                $crypt2 = sha1($email . $pass . "pass1reset!");
                                $update = $database->password_gain($crypt, $crypt2, $email);
                                if ($update) {
                                    echo json_encode(2);
                                } else {
                                    $help->error_description(15);
                                }
                            } else {
                                $help->error_description(25);
                            }
                        } else {
                            $help->error_description(26);
                        }
                    } else {
                        $help->error_description(42);
                    }
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function chat_email()
    {
        global $help;
        if (isset($_GET['message']) && isset($_GET['profileid'])) {
            if (!empty($_GET['message']) && !empty($_GET['profileid'])) {
                global $database;
                $profileid = $_GET['profileid'];
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    $message = $_GET['message'];
                    $profileid = $_GET['profileid'];
                    $actionby = $_SESSION['userid'];
                    $name = $_SESSION['NAME'];
                    $param = array();
                    global $email;
                    $param['type'] = 'message';
                    $param['message'] = $message;
                    $param['profileid'] = $profileid;
                    $param['actionby'] = $actionby;
                    $param['name'] = $name;
                    if ($email->email_sample($param)) {
                        $data['ack'] = 1;
                        echo json_encode($data);
                    } else {
                        $data['ack'] = 0;
                        echo json_encode($data);
                    }
                } else {
                    $help->error_description(18);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function college_select()
    {
        global $help;
        if (isset($_GET['alphabet'])) {
            if (!empty($_GET['alphabet'])) {
                $data = array();
                global $database;
                $alphabet = $_GET['alphabet'];
                if ($result = $database->college_select_alphabet($alphabet)) {
                    while ($row = $result->fetch_array()) {
                        $name = $row['NAME'];
                        $diaryid = $row['DIARYID'];
                        $data[$diaryid] = $name;
                    }
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function college_student_select()
    {
        global $help;
        if (isset($_GET['college'])) {
            if (!empty($_GET['college'])) {
                global $database;
                $college = $_GET['college'];
                if ($res = $database->college_mate_select($college)) {
                    $user = array();
                    $k = 0;
                    while ($row = $res->fetch_array()) {
                        $user[$k]['profileid'] = $row['PROFILEID'];
                        $nrow = $database->get_name($user[$k]['profileid']);
                        $user[$k]['name'] = $nrow['NAME'];
                        $nrow = $database->get_image($user[$k]['profileid']);
                        $user[$k]['image'] = '';
                        $user[$k]['cyear'] = $row['CYEAR'];
                        $user[$k]['email'] = '';
                        $profession = $row['PROFESSION'];
                        $user[$k]['profession'] = '';
                        $company = '';
                        $user[$k]['company'] = '';
                        $user[$k]['status'] = $database->check_friendship($myprofileid, $user[$k]['profileid']);
                        $k++;
                    }
                    $data['user'] = $user;
                    echo json_encode($data);
                } else {
                    $help->error_description(9);
                }
            } else {
                $help->error_description(9);
            }
        } else {
            $help->error_description(9);
        }
    }

    function comment()
    {
        global $help;
        if (isset($_GET['pageid']) && isset($_GET['comment']) && isset($_GET['comment_time'])) {
            if (!empty($_GET['pageid']) && !empty($_GET['comment']) && !empty($_GET['comment_time'])) {
                $myprofileid = $_SESSION['userid'];
                $pageid = $_GET['pageid'];
                $comment = $_GET['comment'];
                $comment_time = $_GET['comment_time'];
                if (strlen($comment) <= 6072) {
                    global $database;
                    global $memcached;
                    $name = array();
                    $tag_index = array();
                    $result = $database->actionid_select($pageid);
                    if ($result->num_rows) {
                        $row = $result->fetch_array();
                        $profileid = $row['PROFILEID'];
                        global $help;
                        if ($help->permission_check($myprofileid, $profileid, $row['VISIBLE'])) {
                            $ctype = $help->comment_type_fetch($row['ACTIONTYPE']);
                            $actionid = $database->get_actionid($profileid, $ctype, $pageid);
                            if (isset($_GET['tag_name']))
                                $tag_name = $_GET['tag_name'];
                            else
                                $tag_name = array();
                            $tn = array();
                            $ti = array();
                            foreach ($tag_name as $t) {
                                array_push($tn, '/' . $t . '/');
                            }
                            if (isset($_GET['tag_index']))
                                $tag_index = $_GET['tag_index'];
                            else
                                $tag_index = array();
                            foreach ($tag_index as $t) {
                                $name[$t] = $help->name_fetch($t, $memcached, $database);
                                array_push($ti, '@[' . $t . '] ');
                            }
                            if ($actionid) {
                                $comment = preg_replace($tn, $ti, $comment);
                                $result = $database->comment_insert($actionid, $comment);
                                if ($result) {
                                    $data = array();
                                    $data['ack'] = $result;
                                    $data['actionid'] = $actionid;
                                    $data['name'] = $name;
                                    $data['life_is_fun'] = sha1($pageid . 'pass1reset!');
                                    $data['comment'] = $comment;
                                    $data['comment_time'] = $comment_time;
                                    $data['length'] = strlen($comment);
                                    echo json_encode($data);
                                    if ($profileid != $myprofileid) {
                                        $rnotice = $database->setting_notice_select($profileid);
                                        if ($rnotice['post_comment']) {
                                            $database->notice_insert($actionid, $profileid, $ctype, $pageid);
                                        }
                                        $remail = $database->setting_email_select($profileid);
                                        if ($remail['post_comment']) {
                                            if ($ctype == '2' || $ctype == '4' || $ctype == '26' || $ctype == '23' || $ctype ==
                                                '24' || $ctype == '25' || $ctype == '503' || $ctype == '802' || $ctype == '1103' ||
                                                $ctype == '1104' || $ctype == '1202' || $ctype == '1402' || $ctype == '1602' ||
                                                $ctype == '2002' || $ctype == '2102') {
                                                $param = array();
                                                global $email;
                                                $param['type'] = 'comment';
                                                $param['actionby'] = $myprofileid;
                                                $param['profileid'] = $profileid;
                                                $param['actionid'] = $actionid;
                                                $param['comment'] = $comment;
                                                $param['actiontype'] = $ctype;
                                                $result = $email->email_sample($param);
                                            }
                                        }
                                    }
                                } else {
                                    $help->error_description(15);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $error['code'] = 12;
                            $error['message'] = 'You don\'t have sufficient permission to perform this action';
                            $error['type'] = 'PermissionException';
                            $data['error'] = $error;
                            echo json_encode($data);
                        }
                    } else {
                        $help->error_description(11);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function show_all_comments()
    {
        global $help;
        if (isset($_GET['pageid'])) {
            if (!empty($_GET['pageid'])) {
                $pageid = $_GET['pageid'];
                $page = $_GET['page'];
                $life_is_fun = sha1($pageid . 'pass1reset!');
                global $database;
                if ($result = $database->actionid_select($pageid)) {
                    if ($result->num_rows) {
                        $crow = $result->fetch_array();
                        $actiontype = $crow['ACTIONTYPE'];
                        $ctype = $help->comment_type_fetch($actiontype);
                        global $encode;
                        $actionid_third = $database->comment_select_actionid_of_third($pageid, $ctype);
                        $comresult = $database->comment_select_all($pageid, $actionid_third);
                        $com = array();
                        $j = 0;
                        global $memcached;
                        $myprofileid = $_SESSION['userid'];
                        while ($comrow = $comresult->fetch_array()) {
                            $com[$j]['com_actionid'] = $comrow['ACTIONID'];
                            $com[$j]['postby'] = $comrow['PROFILEID'];
                            $com[$j]['com_time'] = $help->get_utc($comrow['TIMESTAMP']);
                            $com[$j]['commentby'] = $comrow['ACTIONBY'];
                            $com[$j]['remove'] = 0;
                            if (($com[$j]['commentby'] == $myprofileid) || ($page == 'admin_json')) {
                                $com[$j]['remove'] = 1;
                            }
                            $com[$j]['com_pageid'] = $comrow['PAGEID'];
                            $com_actionid = $com[$j]['com_actionid'] = $comrow['ACTIONID'];
                            $com[$j]['comment'] = stripslashes($comrow['COMMENT']);
                            $arr = explode('@[', $com[$j]['comment']);
                            $arr = explode(']', $arr[1]);
                            $name[$arr[0]] = $help->name_fetch($arr[0], $memcached, $database);
                            $excited_action = $database->get_excited_action($com_actionid, 63);
                            $com[$j]['com_excited_mine'] = 0;
                            while ($erow = $excited_action->fetch_array()) {
                                if ($erow['ACTIONBY'] == $myprofileid) {
                                    $com[$j]['com_excited_mine'] = 1;
                                }
                            }
                            $com[$j]['com_excited'] = $excited_action->num_rows;
                            $name[$com[$j]['commentby']] = $help->name_fetch($com[$j]['commentby'], $memcached,
                                $database);
                            $pimage[$com[$j]['commentby']] = $help->pimage_fetch($com[$j]['commentby'], $memcached,
                                $database);
                            $j++;
                        }
                        $data['life_is_fun'] = $life_is_fun;
                        $data['com'] = $com;
                        $data['name'] = $name;
                        $data['pimage'] = $pimage;
                        echo json_encode($data);
                    } else {
                        $help->error_description(11);
                    }
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function crush()
    {
        global $help;
        if (isset($_GET['email'])) {
            if (!empty($_GET['email'])) {
                $email = $_GET['email'];
                if ($email == $_SESSION['EMAIL']) {
                    $data['result'] = 0;
                    echo json_encode($data);
                    exit;
                }
                global $database;
                if ($help->is_valid_email($email)) {
                    $myemail = $_SESSION['email'];
                    $rets = $database->crush_status($email, $myemail);
                    if ($rets == -1) {
                        $row = $database->is_already_user($email);
                        if ($row['EMAIL'] != $email) {
                            $retv = $database->is_virtual_user($email);
                            if ($retv['ack'] == 0) {
                                $actiontype = 1151;
                                $profileid = $database->virtual_create($email);
                                $visible_id = $_SESSION['visible'];
                                $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible_id);
                            } else
                                if ($retv['ack'] == 1) {
                                    $actiontype = 1151;
                                    $profileid = $retv['virtualid'];
                                    $visible_id = $_SESSION['visible'];
                                    $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible_id);
                                }
                        } else {
                            $actiontype = 1101;
                            $profileid = $row['USERID'];
                            $visible_id = $_SESSION['visible'];
                            $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible_id);
                        }
                        if ($actionid) {
                            $result = $database->crush_insert($actionid, $email, $myemail);
                            if ($result == 1) {
                                $data['result'] = 1;
                                if ($actiontype = 1101) {
                                    $email_object->crush($profileid);
                                } else
                                    if ($actiontype = 1151) {
                                        $email_object->crush_outsource($email);
                                    }
                                echo json_encode($data);
                                exit;
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        if ($rets['status'] == 1) {
                            if ($rets['crushby'] == $myemail) {
                                $data['result'] = 2;
                                if ($actiontype = '1101') {
                                    $email_object->crush($profileid);
                                } else
                                    if ($actiontype = '1151') {
                                        $email_object->crush_outsource($email);
                                    }
                                echo json_encode($data);
                                exit;
                            } else
                                if ($rets['crushat'] == $myemail) {
                                    $status = $rets['status'] - 1;
                                    $pageid = $rets['actionid'];
                                    if ($status == 0) {
                                        $r = $database->is_already_user($email);
                                        $profileid = $r['USERID'];
                                        $actionid = $database->get_actionid($profileid, '1102');
                                    }
                                    $result = $database->crush_update($myemail, $email, $status);
                                    if ($result == 1) {
                                        $data['result'] = 3;
                                        $email_object->crush_match($profileid, $myprofileid);
                                        echo json_encode($data);
                                        exit;
                                    }
                                }
                        } else
                            if ($rets['status'] == 0) {
                                $data['result'] = 4;
                                echo json_encode($data);
                                exit;
                            }
                    }
                } else {
                    $help->error_description(23);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function diary_create()
    {
        global $help;
        if (isset($_GET['type']) && isset($_GET['name']) && isset($_GET['desc'])) {
            if (!empty($_GET['type']) && !empty($_GET['name']) && !empty($_GET['desc'])) {
                $myprofileid = $_SESSION['USERID'];
                $type = $_GET['type'];
                $name = $_GET['name'];
                $desc = $_GET['desc'];
                if (strlen($name <= 100)) {
                    if (strlen($desc <= 1000)) {
                        global $database;
                        if ($res = $database->mydiary_create($myprofileid, $type, $name, $desc)) {
                            if ($res != 0) {
                                $data['ack'] = 1;
                                $data['diaryid'] = $res['DIARYID'];
                                $data['message'] = 'Diary Created';
                            } else {
                                $data['ack'] = 0;
                                $data['message'] = 'Unable to create diary';
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function answer_people_fetch()
    {
        global $help;
        if (isset($_GET['optionid'])) {
            if (!empty($_GET['optionid'])) {
                $optionid = $_GET['optionid'];
                global $database;
                $rtype = 2801;
                $excited_action = $database->answer_select($optionid);
                if ($excited_action->num_rows != 0) {
                    global $memcached;
                    while ($row = $excited_action->fetch_array()) {
                        $actionby[]['profileid'] = $row['profileid'];
                        $name[$row['profileid']] = $help->name_fetch($row['profileid'], $memcached, $database);
                        $pimage[$row['profileid']] = $help->pimage_fetch($row['profileid'], $memcached,
                            $database);
                    }
                    $data['excited'] = $actionby;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                } else {
                    $help->error_description(24);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function response_fetch()
    {
        global $help;
        if (isset($_GET['pageid'])) {
            if (!empty($_GET['pageid'])) {
                $pageid = $_GET['pageid'];
                global $database;
                if ($result = $database->actionid_select($pageid)) {
                    if ($result->num_rows) {
                        $arow = $result->fetch_array();
                        $actiontype = $arow['ACTIONTYPE'];
                        $rtype = $help->response_type_fetch($actiontype);
                        $excited_action = $database->response_select($pageid, $rtype);

                        $num_excite = $excited_action->num_rows;
                        if ($num_excite != 0) {
                            global $memcached;
                            while ($row = $excited_action->fetch_array()) {
                                $actionby[]['profileid'] = $row['ACTIONBY'];
                                $name[$row['ACTIONBY']] = $help->name_fetch($row['ACTIONBY'], $memcached, $database);
                                $pimage[$row['ACTIONBY']] = $help->pimage_fetch($row['ACTIONBY'], $memcached, $database);
                            }
                            $data['excited'] = $actionby;
                            $data['name'] = $name;
                            $data['pimage'] = $pimage;
                            echo json_encode($data);
                        } else {
                            $help->error_description(24);
                        }
                    } else {
                        $help->error_description(11);
                    }
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function forgot_password()
    {
        global $help;
        if (isset($_GET['email'])) {
            if (!empty($_GET['email'])) {
                $email = $_GET['email'];
                if ($help->is_email($email)) {
                    global $database;
                    $help->assign_database($email, $database);
                    $database = null;
                    $database = new Database();
                    $ret = $database->check_email($email);
                    if ($ret == 1) {
                        $uniqueid = sha1(uniqid(rand(), 1));
                        if ($database->update_uniqueid($email, $uniqueid)) {
                            $param = array();
                            $email_object = new Email();
                            $param['type'] = 'password_recover';
                            $param['email'] = $email;
                            $param['uniqueid'] = $uniqueid;
                            if ($email_object->email_sample($param)) {
                                $data['ack'] = 1;
                                $data['message'] = 'A link has been sent to this email address. Please click at the link or paste the link in the browser to recover your password.';
                                echo json_encode($data);
                            } else {
                                $help->error_description(17);
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(16);
                    }
                } else {
                    $help->error_description(23);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function employee_invite()
    {
        global $database;
        $email_object = new Email();
        global $help;
        $existing = array();
        $invited = array();
        $invalid = array();
        if (isset($_GET['email'])) {
            if (!empty($_GET['email'])) {
                $email = $_GET['email'];
                $email_array = explode(',', $email);
                foreach ($email_array as $email_value) {
                    if ($_SESSION['database'] == $help->get_database_from_email($email_value, $database)) {
                        $myname = $_SESSION['name'];
                        $myphoto = $_GET['myphoto'];
                        $myprofileid = $_SESSION['userid'];
                        if ($email_value == $myemail) {
                            array_push($existing, $email_value);
                        } else
                            if ($help->is_email($email_value)) {
                                $row = $database->is_already_user($email_value);
                                if ($row['EMAIL'] == $email_value) {
                                    array_push($existing, $email_value);
                                } else {
                                    $row = $database->is_virtual_user($email_value);
                                    if ($row['ack']) {
                                        array_push($invited, $email_value);
                                        $identifier = $row['uniqueid'];
                                    } else {
                                        $virtualid = $database->virtual_create($email_value);
                                        $vr = $database->v_select($virtualid);
                                        $identifier = $vr['UNIQUEID'];
                                        array_push($invited, $email_value);
                                    }

                                    $param = array();
                                    $param['type'] = 'people_invite';
                                    $param['email'] = $email_value;
                                    $param['identifier'] = $identifier;
                                    $param['myname'] = $myname;
                                    $param['myphoto'] = $myphoto;
                                    $param['actionby'] = $myprofileid;
                                    $er = $email_object->email_sample($param);
                                }
                            } else {
                                array_push($invalid, $email_value);
                            }
                    } else {
                        array_push($invalid, $email_value);
                    }

                }
                $data['invalid'] = $invalid;
                $data['invited'] = $invited;
                $data['existing'] = $existing;
                $data['ack'] = 1;
                echo json_encode($data);

            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function friend_invite()
    {
        global $help;
        if (isset($_GET['email'])) {
            if (!empty($_GET['email'])) {
                $email = strtolower($_GET['email']);
                $myemail = $_SESSION['EMAIL'];
                global $database;
                $email_object = new Email();
                global $help;
                if ($_SESSION['database'] == $help->get_database_from_email($email, $database)) {
                    $myname = $_SESSION['NAME'];
                    $myphoto = $_SESSION['pimage'];
                    $myprofileid = $_SESSION['userid'];
                    if ($email == $myemail) {
                        $data['ack'] = 0;
                        echo json_encode($data);
                    } else
                        if ($help->is_email($email)) {
                            $row = $database->is_already_user($email);
                            if ($row['EMAIL'] == $email) {
                                $data['ack'] = 1;
                                $data['profileid'] = $row['USERID'];
                                echo json_encode($data);
                            } else {
                                $row = $database->is_virtual_user($email);
                                if ($row['ack']) {
                                    $virtualid = $row['virtualid'];
                                } else {
                                    $virtualid = $database->virtual_create($email);
                                }
                                $vr = $database->v_select($virtualid);
                                $identifier = $vr['UNIQUEID'];
                                $database->invite_insert($virtualid, $myprofileid);
                                $param = array();
                                $param['type'] = 'friend_invite';
                                $param['email'] = $email;
                                $param['identifier'] = $identifier;
                                $param['myname'] = $myname;
                                $param['myphoto'] = $myphoto;
                                $param['actionby'] = $myprofileid;
                                $er = $email_object->email_sample($param);
                                if ($er) {
                                    $data['ack'] = 2;
                                    echo json_encode($data);
                                }
                            }
                        } else {
                            $data['ack'] = 3;
                            echo json_encode($data);
                        }
                } else {
                    $help->error_description(36);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function self_invite()
    {
        global $help;
        if (isset($_GET['email'])) {
            if (!empty($_GET['email'])) {
                $email = strtolower($_GET['email']);
                if ($help->is_email($email)) {
                    global $database;
                    $email_object = new Email();
                    $help->assign_database($email, $database);
                    $database = null;
                    $database = new Database();
                    $row = $database->is_already_user($email);
                    if ($row['EMAIL'] == $email) {
                        $data['ack'] = 1;
                        $data['message'] = "This email is already registered with Quipmate. Please login to continue.";
                        $data['profileid'] = $row['USERID'];
                        echo json_encode($data);
                    } else {
                        $row = $database->is_virtual_user($email);
                        if ($row['ack']) {
                            $virtualid = $row['virtualid'];
                        } else {
                            $virtualid = $database->virtual_create($email);
                        }
                        $vr = $database->v_select($virtualid);
                        $identifier = $vr['UNIQUEID'];
                        $param = array();
                        $param['type'] = 'self_invite';
                        $param['email'] = $email;
                        $param['identifier'] = $identifier;
                        $er = $email_object->email_sample($param);
                        if ($er) {
                            $data['ack'] = 2;
                            $data['message'] = "A link has been sent to your email. Please click that link to register for Quipmate.";
                            echo json_encode($data);
                        } else {
                            $data['ack'] = 3;
                            $data['message'] = "There is some problem in sending registration link to your email!";
                            echo json_encode($data);
                        }
                    }
                } else {
                    $help->error_description(23);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function self_invite_mobile()
    {
        global $help;
        if (isset($_GET['email'])) {
            if (!empty($_GET['email'])) {
                $email = strtolower($_GET['email']);
                if ($help->is_email($email)) {
                    global $database;
                    $email_object = new Email();
                    $help->assign_database($email, $database);
                    $database = null;
                    $database = new Database();
                    $row = $database->is_already_user($email);
                    if ($row['EMAIL'] == $email) {
                        $data['ack'] = 1;
                        $data['message'] = "This email is already registered with Quipmate. Please login to continue.";
                        $data['profileid'] = $row['USERID'];
                        echo json_encode($data);
                    } else {
                        $row = $database->is_virtual_user($email);
                        if ($row['ack']) {
                            $virtualid = $row['virtualid'];
                            $code = $row['code'];
                        } else {
                            $code = rand(1000, 9999);
                            $virtualid = $database->virtual_create_mobile($email, $code);

                        }
                        $vr = $database->v_select($virtualid);


                        $param = array();
                        $param['type'] = 'self_invite';
                        $param['email'] = $email;
                        $param['identifier'] = $code;
                        $email_object = new EMAIL();
                        $er = $email_object->email_sample($param);
                        if ($er) {
                            $data['ack'] = 2;
                            $data['message'] = "A 4 digitcode has been sent to your email.";
                            $data['code'] = $code;
                            echo json_encode($data);
                        }
                    }
                } else {
                    $help->error_description(23);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function member_request_fetch()
    {
        global $help;
        if (isset($_GET['groupid'])) {
            if (!empty($_GET['groupid'])) {
                $data = array();
                $member = array();
                global $memcached;
                global $database;
                $groupid = $_GET['groupid'];
                if ($result = $database->member_request_select($groupid)) {
                    if ($result->num_rows) {
                        $k = 0;
                        while ($row = $result->fetch_array()) {
                            $member[$k]['profileid'] = $row['profileid'];
                            $name[$member[$k]['profileid']] = $help->name_fetch($member[$k]['profileid'], $memcached,
                                $database);
                            $pimage[$member[$k]['profileid']] = $help->pimage_fetch($member[$k]['profileid'],
                                $memcached, $database);
                            $k++;
                        }
                        $data['count'] = $result->num_rows;
                        $data['member'] = $member;
                        $data['name'] = $name;
                        $data['pimage'] = $pimage;
                        echo json_encode($data);
                    } else {
                        $data['count'] = 0;
                        $data['message'] = 'No pending member request';
                        echo json_encode($data);
                    }
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function friend_request_fetch()
    {
        global $help;
        $data = array();
        $friend = array();
        $myprofileid = $_SESSION['userid'];
        global $memcached;
        global $database;
        if ($result = $database->friend_invite_select($myprofileid)) {
            if ($result->num_rows) {
                $k = 0;
                while ($row = $result->fetch_array()) {
                    $friend[$k]['profileid'] = $row['FRIENDID'];
                    $name[$friend[$k]['profileid']] = $help->name_fetch($friend[$k]['profileid'], $memcached,
                        $database);
                    $pimage[$friend[$k]['profileid']] = $help->pimage_fetch($friend[$k]['profileid'],
                        $memcached, $database);
                    $k++;
                }
                $data['count'] = $result->num_rows;
                $data['friend'] = $friend;
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                echo json_encode($data);
            } else {
                $data['count'] = 0;
                $data['message'] = 'You don\'t have any pending friend request';
                echo json_encode($data);
            }
        } else {
            $help->error_description(15);
        }
    }

    function friend_details_fetch()
    {
        global $help;
        global $database;
        $profileid = $_GET['profileid'];
        if ($bio = $database->bio_complete_select($profileid)) {
            $data = array();
            $info = array();
            $age = $database->get_age($profileid);
            $info[0]['profileid'] = $profileid;
            $info[0]['age'] = $age;
            if ($help->checkPrivacy('CITY', $profileid) == 1) {
                $arr = $database->data_retrieve($bio['CITY']);
                $info[0]['city'] = $arr['NAME'];
            }
            if ($help->checkPrivacy('PROFESSION', $profileid) == 1) {
                $arr = $database->data_retrieve($bio['PROFESSION']);
                $info[0]['profession'] = $arr['NAME'];
            }
            if ($help->checkPrivacy('SCHOOL', $profileid) == 1) {
                $arr = $database->data_retrieve($bio['SCHOOL']);
                $info[0]['school'] = $arr['NAME'];
            }
            if ($help->checkPrivacy('COLLEGE', $profileid) == 1) {
                $arr = $database->data_retrieve($bio['COLLEGE']);
                $info[0]['college'] = $arr['NAME'];
            }
            $data['info'] = $info;
            $data['name'] = $_SESSION['name_json'];
            $data['pimage'] = $_SESSION['pimage_json'];
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }
    }

    function friend_search()
    {
        global $help;
        if (isset($_GET['q'])) {
            if (!empty($_GET['q'])) {
                $data = array();
                $friend = array();
                $q = $_GET['q'];
                if (isset($_GET['profileid']) && !empty($_GET['profileid'])) {
                    $profileid = $_GET['profileid'];
                } else {
                    $profileid = $_SESSION['userid'];
                }
                global $memcached;
                global $database;
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if (strlen($q) <= 50) {
                        $fres = $database->friend_search($profileid, $q, 1000);
                        $k = 0;
                        while ($frow = $fres->fetch_array()) {
                            $friend[$k]['profileid'] = $frow['PROFILEID'];
                            $name[$friend[$k]['profileid']] = $help->name_fetch($friend[$k]['profileid'], $memcached,
                                $database);
                            $pimage[$friend[$k]['profileid']] = $help->pimage_fetch($friend[$k]['profileid'],
                                $memcached, $database);
                            $k++;
                        }
                        $data['friend'] = $friend;
                        $data['name'] = $name;
                        $data['pimage'] = $pimage;
                        echo json_encode($data);
                    } else {
                        $error_description(10);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function gift()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['gift']) && isset($_GET['gift_desc'])) {
            if (!empty($_GET['profileid']) && !empty($_GET['gift'])) {
                global $email;
                $profileid = $_GET['profileid'];
                $myprofileid = $_SESSION['userid'];
                $gift = $_GET['gift'];
                $gift_desc = $_GET['gift_desc'];
                global $database;
                echo $profileid;
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($myprofileid != $profileid) {
                        if ($database->check_friendship($myprofileid, $profileid) == 2) {
                            $grow = $database->giftid_exists($gift);
                            if ($grow['GIFTID'] == $giftid) {
                                if (strlen($gift_desc) <= 6072) {
                                    $actiontype = 1401;
                                    $actionid = $database->get_actionid($profileid, $actiontype);
                                    if ($actionid) {
                                        $result = $database->diary_insert($actionid, $gift_desc);
                                        if ($result) {
                                            $res = $database->map_insert($actionid, $gift);
                                            if ($res) {
                                                $data = array();
                                                $data['ack'] = $res;
                                                $rnotice = $database->setting_notice_select($profileid);
                                                if ($rnotice['gift']) {
                                                    $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                                                }
                                                $remail = $database->setting_email_select($profileid);
                                                if ($remail['gift']) {
                                                    $param = array();
                                                    $param['type'] = 'gift';
                                                    $param['profileid'] = $profileid;
                                                    $param['actionby'] = $myprofileid;
                                                    $param['gift_desc'] = $gift_desc;
                                                    $email->email_sample($param);
                                                }
                                                echo json_encode($data);
                                            } else {
                                                $help->error_description(15);
                                            }
                                        } else {
                                            $help->error_description(15);
                                        }
                                    } else {
                                        $help->error_description(15);
                                    }
                                } else {
                                    $help->error_description(10);
                                }
                            } else {
                                $help->error_description(16);
                            }
                        } else {
                            $help->error_description(12);
                        }
                    } else {
                        $help->error_description(2);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_member_remove()
    {
        global $help;
        global $database;
        if (isset($_GET['groupid']) && isset($_GET['profileid'])) {
            if (!empty($_GET['groupid']) && !empty($_GET['profileid'])) {
                $groupid = $_GET['groupid'];
                $profileid = $_GET['profileid'];
                $result = $database->is_member($groupid, $profileid);
                $myprofileid = $_SESSION['userid'];
                if ($result->num_rows) {
                    $mrow = $result->fetch_array();
                    $row = $database->is_group_admin($groupid, $myprofileid);
                    if ($row['priviledge'] == 1) {
                        if ($database->action_delete($mrow['actionid'])) {
                            if ($database->unsubscribe($groupid, $profileid)) {
                                $data['ack'] = 1;
                                $data['message'] = 'Removed';
                                echo json_encode($data);
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(32);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_admin_make()
    {
        global $help;
        global $database;
        if (isset($_GET['groupid']) && isset($_GET['profileid'])) {
            if (!empty($_GET['groupid']) && !empty($_GET['profileid'])) {
                $groupid = $_GET['groupid'];
                $profileid = $_GET['profileid'];
                $result = $database->is_member($groupid, $profileid);
                $myprofileid = $_SESSION['userid'];
                if ($result->num_rows) {
                    $row = $database->is_group_admin($groupid, $myprofileid);
                    if ($row['priviledge'] == 1) {
                        $row = $database->is_group_admin($groupid, $profileid);
                        if ($row['priviledge'] == 0) {
                            $actionid = $database->get_actionid($groupid, 329);
                            if ($database->group_priviledge_update($groupid, $profileid, 1)) {
                                $rnotice = $database->setting_notice_select($profileid);
                                if ($rnotice['group_admin']) {
                                    $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                                }
                                $remail = $database->setting_email_select($profileid);
                                if ($remail['group_admin']) {
                                    global $email;
                                    $param = array();
                                    $param['type'] = 'group_admin';
                                    $param['profileid'] = $profileid;
                                    $param['actionby'] = $myprofileid;
                                    $param['groupid'] = $groupid;
                                    $email->email_sample($param);
                                }
                                $data['ack'] = 1;
                                $data['message'] = 'Admin';
                                echo json_encode($data);
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(32);
                        }
                    } else {
                        $help->error_description(32);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_admin_remove()
    {
        global $help;
        global $database;
        if (isset($_GET['groupid']) && isset($_GET['profileid'])) {
            if (!empty($_GET['groupid']) && !empty($_GET['profileid'])) {
                $groupid = $_GET['groupid'];
                $profileid = $_GET['profileid'];
                $myprofileid = $_SESSION['userid'];
                $row = $database->is_group_admin($groupid, $myprofileid);
                if ($row['priviledge'] == 1) {
                    $row = $database->is_group_admin($groupid, $profileid);
                    if ($row['priviledge'] == 1) {
                        if ($database->group_priviledge_update($groupid, $profileid, 0)) {
                            $data['ack'] = 1;
                            $data['message'] = 'Admin Removed';
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(32);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_settings_save()
    {
        global $help;
        global $database;
        if (isset($_GET['groupid']) && isset($_GET['invite']) && isset($_GET['description']) &&
            isset($_GET['privacy']) && isset($_GET['link'])) {
            if (!empty($_GET['groupid']) && $_GET['invite'] != '' && $_GET['privacy'] != '') {
                if (strlen($_GET['link']) < 500) {
                    if (strlen($_GET['description']) < 400) {
                        if ($_GET['invite'] == 1 || $_GET['invite'] == 0) {
                            if ($_GET['privacy'] == 0 || $_GET['privacy'] == 1) {
                                $groupid = $_GET['groupid'];
                                $myprofileid = $_SESSION['userid'];
                                $invite = $_GET['invite'];
                                $description = $_GET['description'];
                                $privacy = $_GET['privacy'];
                                $link = $_GET['link'];
                                $time = time();
                                $status = $database->membership_status($groupid, $myprofileid);
                                if ($status == 0) {
                                    if ($database->group_settings_save($groupid, $invite, $privacy, $link, $description)) {
                                        $data['ack'] = 1;
                                        $data['groupid'] = $groupid;
                                        echo json_encode($data);
                                    } else {
                                        $help->error_description(15);
                                    }
                                } else {
                                    $help->error_description(12);
                                }
                            } else {
                                $help->error_description(10);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_create()
    {
        global $help;
        global $database;
        if (isset($_GET['name']) && isset($_GET['description']) && isset($_GET['privacy']) &&
            isset($_GET['technical'])) {
            if (!empty($_GET['name']) && !empty($_GET['description']) && $_GET['privacy'] !=
                '' && $_GET['technical'] != '') {
                if (strlen($_GET['name']) < 100) {
                    if (strlen($_GET['description']) < 400) {
                        if ($_GET['technical'] == 1 || $_GET['technical'] == 0) {
                            if ($_GET['privacy'] == 0 || $_GET['privacy'] == 1) {
                                $name = $_GET['name'];
                                $description = $_GET['description'];
                                $privacy = $_GET['privacy'];
                                $technical = $_GET['technical'];
                                $myprofileid = $_SESSION['userid'];
                                $time = time();
                                $actionid = $database->get_actionid($myprofileid, 300);
                                if ($groupid = $database->group_create($actionid, $technical, $privacy, $name, $description,
                                    $myprofileid, $time)) {
                                    $database->action_update($actionid, $groupid);
                                    $data['ack'] = 1;
                                    $data['groupid'] = $groupid;
                                    echo json_encode($data);
                                } else {
                                    $help->error_description(15);
                                }
                            } else {
                                $help->error_description(10);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function page_create()
    {
        global $help;
        global $database;
        if (isset($_GET['name']) && isset($_GET['description'])) {
            if (!empty($_GET['name']) && !empty($_GET['description'])) {
                if (strlen($_GET['name']) < 100) {
                    if (strlen($_GET['description']) < 400) {
                        $name = $_GET['name'];
                        $description = $_GET['description'];
                        $myprofileid = $_SESSION['userid'];
                        $time = time();
                        $actionid = $database->get_actionid($myprofileid, 2900);
                        if ($pageid = $database->page_create($actionid, $name, $description, $myprofileid,
                            $time)) {
                            $database->action_update($actionid, $pageid);
                            $data['ack'] = 1;
                            $data['pageid'] = $pageid;
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }

                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function event_settings_save()
    {
        global $help;
        global $database;
        if (isset($_GET['eventid']) && isset($_GET['description']) && isset($_GET['privacy']) &&
            isset($_GET['invite']) && isset($_GET['day']) && isset($_GET['month']) && isset
            ($_GET['year']) && isset($_GET['time']) && isset($_GET['venue'])) {
            if (!empty($_GET['eventid']) && !empty($_GET['description']) && $_GET['privacy'] !=
                '' && $_GET['invite'] != '' && !empty($_GET['day']) && !empty($_GET['month']) &&
                !empty($_GET['year']) && !empty($_GET['time']) && !empty($_GET['venue'])) {
                if (strlen($_GET['description']) < 400) {
                    if ($_GET['invite'] == 1 || $_GET['invite'] == 0) {
                        if ($_GET['privacy'] == 0 || $_GET['privacy'] == 1) {
                            if ($help->validate_bday($_GET['day'], $_GET['month'], $_GET['year'])) {
                                if ($help->validate_time($_GET['time'])) {
                                    $eventid = $_GET['eventid'];
                                    $description = $_GET['description'];
                                    $privacy = $_GET['privacy'];
                                    $invite = $_GET['invite'];
                                    $day = $_GET['day'];
                                    $month = $_GET['month'];
                                    $year = $_GET['year'];
                                    $timimg = $_GET['time'];
                                    $venue = $_GET['venue'];
                                    $date = $year . '-' . $month . '-' . $day;
                                    $myprofileid = $_SESSION['userid'];
                                    $status = $database->guest_status($eventid, $myprofileid);
                                    if ($status == 0) {
                                        if ($eventid = $database->event_settings_save($eventid, $invite, $privacy, $description,
                                            $date, $timimg, $venue)) {
                                            $data['ack'] = 1;
                                            $data['eventid'] = $eventid;
                                            echo json_encode($data);
                                        } else {
                                            $help->error_description(15);
                                        }
                                    } else {
                                        $help->error_description(12);
                                    }
                                } else {
                                    $help->error_description(29);
                                }
                            } else {
                                $help->error_description(28);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_event_create()
    {
        global $help;
        global $database;
        if (isset($_GET['groupid']) && isset($_GET['name']) && isset($_GET['description']) &&
            isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year']) && isset($_GET['time']) &&
            isset($_GET['venue'])) {
            if (!empty($_GET['groupid']) && !empty($_GET['name']) && !empty($_GET['description']) &&
                !empty($_GET['day']) && !empty($_GET['month']) && !empty($_GET['year']) && !
                empty($_GET['time']) && !empty($_GET['venue'])) {
                if (strlen($_GET['name']) < 100) {
                    if (strlen($_GET['description']) < 400) {
                        if ($help->validate_bday($_GET['day'], $_GET['month'], $_GET['year'])) {
                            if ($help->validate_time($_GET['time'])) {
                                $name = $_GET['name'];
                                $description = $_GET['description'];
                                $privacy = 2;
                                $invite = 0;
                                $groupid = $_GET['groupid'];
                                $day = $_GET['day'];
                                $month = $_GET['month'];
                                $year = $_GET['year'];
                                $timimg = $_GET['time'];
                                $venue = $_GET['venue'];
                                $date = $year . '-' . $month . '-' . $day;
                                $myprofileid = $_SESSION['userid'];
                                $time = time();
                                if ($actionid = $database->get_actionid($myprofileid, 400)) {
                                    if ($aid = $database->get_actionid($groupid, 330, $actionid)) {
                                        $eventid = $database->event_create($actionid, $invite, $privacy, $name, $description,
                                            $date, $timimg, $venue, $myprofileid, $time, $groupid);
                                        $database->action_update($actionid, $eventid);
                                        $data['ack'] = 1;
                                        $data['eventid'] = $eventid;
                                        echo json_encode($data);
                                    } else {
                                        $help->error_description(15);
                                    }
                                } else {
                                    $help->error_description(29);
                                }
                            } else {
                                $help->error_description(29);
                            }
                        } else {
                            $help->error_description(28);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function event_create()
    {
        global $help;
        global $database;
        if (isset($_GET['name']) && isset($_GET['description']) && isset($_GET['privacy']) &&
            isset($_GET['invite']) && isset($_GET['day']) && isset($_GET['month']) && isset
            ($_GET['year']) && isset($_GET['time']) && isset($_GET['venue'])) {
            if (!empty($_GET['name']) && !empty($_GET['description']) && $_GET['privacy'] !=
                '' && $_GET['invite'] != '' && !empty($_GET['day']) && !empty($_GET['month']) &&
                !empty($_GET['year']) && !empty($_GET['time']) && !empty($_GET['venue'])) {
                if (strlen($_GET['name']) < 100) {
                    if (strlen($_GET['description']) < 400) {
                        if ($_GET['invite'] == 1 || $_GET['invite'] == 0) {
                            if ($_GET['privacy'] == 0 || $_GET['privacy'] == 1) {
                                if ($help->validate_bday($_GET['day'], $_GET['month'], $_GET['year'])) {
                                    if ($help->validate_time($_GET['time'])) {
                                        $name = $_GET['name'];
                                        $description = $_GET['description'];
                                        $privacy = $_GET['privacy'];
                                        $invite = $_GET['invite'];
                                        $day = $_GET['day'];
                                        $month = $_GET['month'];
                                        $year = $_GET['year'];
                                        $timimg = $_GET['time'];
                                        $venue = $_GET['venue'];
                                        $date = $year . '-' . $month . '-' . $day;
                                        $myprofileid = $_SESSION['userid'];
                                        $time = time();
                                        if ($actionid = $database->get_actionid($myprofileid, 400)) {
                                            $eventid = $database->event_create($actionid, $invite, $privacy, $name, $description,
                                                $date, $timimg, $venue, $myprofileid, $time);
                                            $database->action_update($actionid, $eventid);
                                            $data['ack'] = 1;
                                            $data['eventid'] = $eventid;
                                            echo json_encode($data);
                                        } else {
                                            $help->error_description(15);
                                        }
                                    } else {
                                        $help->error_description(29);
                                    }
                                } else {
                                    $help->error_description(28);
                                }
                            } else {
                                $help->error_description(10);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function link_details_fetch()
    {
        $data = array();
        global $help;
        if (isset($_GET['link'])) {
            if (!empty($_GET['link'])) {
                $str = $_GET['link'];
                $link = $str;
                $actiontype = 1;

                $pattern = '`.*?((www\.|https?:\/\/)[\w#$&+,\/:;=?@.-]+)[^\w#$&+,\/:;=?@.-]*?`i';
                preg_match_all($pattern, $str, $match, PREG_PATTERN_ORDER);

                foreach ($match[1] as $m) {
                    if (preg_match("/^http:\/\//", $m) || preg_match("/^https:\/\//", $m)) {
                        ;
                    } else {
                        $m = 'http://' . $m;
                    }
                    $actiontype = 1600;
                    $link = $m;
                    break;
                }
                if ($actiontype == 1) {
                    $data['actiontype'] = 1;
                    echo json_encode($data);
                } else {
                    $dom = new DOMDocument();
                    $src = array();
                    if (@$dom->loadHTMLFile($link)) {
                        $data['title'] = '';
                        $data['meta'] = '';
                        $list = $dom->getElementsByTagName("title");
                        if ($list->length > 0) {
                            $data['title'] = $list->item(0)->textContent;
                        }
                        $metas = $dom->getElementsByTagName("meta");
                        foreach ($metas as $meta) {
                            if ($meta->getAttribute('name') == 'description') {
                                $data['meta'] = $meta->getAttribute('content');
                                if (strlen($data['meta']) > 200) {
                                    $data['meta'] = substr($data['meta'], 0, 199);
                                }
                            }
                        }
                        $parse = parse_url($link);
                        $data['host'] = $host = 'http://' . $parse['host'] . '/';
                        $ext = pathinfo($link, PATHINFO_EXTENSION);
                        $valid_formats = array(
                            "jpg",
                            "png",
                            "gif",
                            "bmp",
                            "jpeg",
                            "cms");
                        if (in_array($ext, $valid_formats)) {
                            $data['actiontype'] = 1600;
                            $data['video'] = 0;
                            $src[] = $link;
                            $data['src'] = $src;
                            $data['link'] = $link;
                        } else
                            if ($host == 'http://youtu.be/' || $host == 'https://youtu.be/') {
                                $host = 'https://youtu.be/';
                                $data['actiontype'] = 1600;
                                $data['video'] = 1;
                                $path = explode($host, $link);
                                $data['link'] = $link;
                                $data['path'] = $path[1];
                            } else
                                if ($host == 'http://www.youtube.com/' || $host == 'https://www.youtube.com/') {
                                    $host == 'https://www.youtube.com/';
                                    $data['actiontype'] = 1600;
                                    $data['video'] = 1;
                                    $path = explode('v=', $link);
                                    $path = explode('&', $path[1]);
                                    $data['link'] = $link;
                                    $data['path'] = $path[0];
                                } else {
                                    $data['actiontype'] = 1600;
                                    $data['video'] = 0;
                                    $tags = $dom->getElementsByTagName("img");
                                    $valid_formats = array(
                                        "jpg",
                                        "png",
                                        "gif",
                                        "bmp",
                                        "jpeg",
                                        "cms");
                                    foreach ($tags as $tag) {
                                        $img = $tag->getAttribute('src');
                                        $ext = pathinfo($img, PATHINFO_EXTENSION);
                                        if (in_array($ext, $valid_formats)) {
                                            if (strpos($img, 'http://') === false && strpos($img, 'https://') === false) {
                                                $img = $host . $img;
                                            }
                                            $src[] = $img;
                                        }
                                    }
                                    $data['src'] = $src;
                                    $data['link'] = $link;
                                }
                                echo json_encode($data);
                    } else {
                        $help->error_description(19);
                    }
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function live_feed()
    {
        global $help;
        if (isset($_GET['start'])) {
            if ($_GET['start'] != '') {
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                if (is_numeric($start)) {
                    global $database;
                    global $memcached;
                    if ($res = $database->friend_action_select($myprofileid, $start, 20)) {
                        $action = array();
                        $data = array();
                        $name = array();
                        $pimage = array();
                        $k = 0;
                        while ($NROW = $res->fetch_array()) {
                            $action[$k]['actionid'] = $NROW['ACTIONID'];
                            $action[$k]['pageid'] = $NROW['PAGEID'];
                            $action[$k]['life_is_fun'] = sha1($NROW['PAGEID'] . 'pass1reset!');
                            $action[$k]['actiontype'] = $NROW['ACTIONTYPE'];
                            $action[$k]['actionby'] = $NROW['ACTIONBY'];
                            $action[$k]['actionon'] = $NROW['PROFILEID'];
                            $name[$action[$k]['actionby']] = $help->name_fetch($action[$k]['actionby'], $memcached,
                                $database);
                            $pimage[$action[$k]['actionby']] = $help->pimage_fetch($action[$k]['actionby'],
                                $memcached, $database);

                            if ($action[$k]['actionby'] != $action[$k]['actionon']) {
                                $name[$action[$k]['actionon']] = $help->name_fetch($action[$k]['actionon'], $memcached,
                                    $database);
                                $pimage[$action[$k]['actionon']] = $help->pimage_fetch($action[$k]['actionon'],
                                    $memcached, $database);
                            }
                            $k++;
                        }
                        $data['ack'] = 1;
                        $data['action'] = $action;
                        $data['name'] = $name;
                        $data['photo'] = $pimage;
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(22);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function message_fetch()
    {
        global $help;
        ini_set('default_charset', 'utf-8');
        if (isset($_GET['start']) && isset($_GET['profileid'])) {
            if (($_GET['start'] != '') && !empty($_GET['profileid'])) {
                $profileid = $_GET['profileid'];
                $start = $_GET['start'];
                $myprofileid = $_SESSION['userid'];
                $data = array();
                $message = array();
                $reply = array();
                global $database;
                global $memcached;
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    $name[$profileid] = $help->name_fetch($profileid, $memcached, $database);
                    $pimage[$profileid] = $help->pimage_fetch($profileid, $memcached, $database);
                    $database->inbox_update_readbit($myprofileid);
                    $result = $database->inbox_mutual_select($myprofileid, $profileid, $start);
                    $k = 0;
                    while ($row = $result->fetch_array()) {
                        $message[$k]['profileid'] = $row['ACTIONON'];
                        $message[$k]['actionid'] = $row['ACTIONID'];
                        $message[$k]['pageid'] = $row['ACTIONID'];
                        $message[$k]['actionby'] = $row['ACTIONBY'];
                        $message[$k]['actionon'] = $row['ACTIONON'];
                        $message[$k]['actiontype'] = 401;
                        $message[$k]['time'] = $row['TIME'];
                        $message[$k]['message'] = utf8_encode($row['MESSAGE']);
                        if ($message[$k]['profileid'] < 1000000000) {
                            $name[$message[$k]['actionon']] = $help->diary_name_fetch($message[$k]['actionon'],
                                $memcached, $database);
                        } else {
                            $name[$message[$k]['actionon']] = $help->name_fetch($message[$k]['actionon'], $memcached,
                                $database);
                        }
                        $name[$message[$k]['actionby']] = $help->name_fetch($message[$k]['actionby'], $memcached,
                            $database);
                        $pimage[$message[$k]['actionby']] = $help->pimage_fetch($message[$k]['actionby'],
                            $memcached, $database);
                        $k++;
                    }
                    $data['myprofileid'] = $_SESSION['USERID'];
                    $data['action'] = $message;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function message_recent_fetch()
    {
        global $help;
        $myprofileid = $_SESSION['userid'];
        global $database;
        global $memcached;
        $database->inbox_update_readbit($myprofileid);
        $res = $database->get_last_message_exchanged($myprofileid);
        $k = 0;
        $data['ack'] = 0;
        $friend = array();
        $message_sent_recieve = array();
        while ($NROW = $res->fetch_array()) {
            if ($NROW['ACTIONBY'] == $myprofileid) {
                if (!in_array($NROW['ACTIONON'], $friend)) {
                    $friend[] = $NROW['ACTIONON'];
                    $message_sent_recieve[$k]['actionon'] = $NROW['ACTIONON'];
                    $message_sent_recieve[$k]['actionby'] = $NROW['ACTIONBY'];
                    $message_sent_recieve[$k]['message'] = $NROW['MESSAGE'];
                    $message_sent_recieve[$k]['time'] = $NROW['TIME'];
                    $name[$friend[$k]] = $help->name_fetch($friend[$k], $memcached, $database);
                    $pimage[$friend[$k]] = $help->pimage_fetch($friend[$k], $memcached, $database);
                    $data['ack'] = 1;
                }
            } else
                if ($NROW['ACTIONON'] == $myprofileid) {
                    if (!in_array($NROW['ACTIONBY'], $friend)) {
                        $friend[] = $NROW['ACTIONBY'];
                        $message_sent_recieve[$k]['actionon'] = $NROW['ACTIONON'];
                        $message_sent_recieve[$k]['actionby'] = $NROW['ACTIONBY'];
                        $message_sent_recieve[$k]['message'] = $NROW['MESSAGE'];
                        $message_sent_recieve[$k]['time'] = $NROW['TIME'];
                        $name[$friend[$k]] = $help->name_fetch($friend[$k], $memcached, $database);
                        $pimage[$friend[$k]] = $help->pimage_fetch($friend[$k], $memcached, $database);
                        $data['ack'] = 1;
                    }
                }
            $k++;
        }
        $data['action'] = $message_sent_recieve;
        $data['name'] = $name;
        $data['pimage'] = $pimage;
        echo json_encode($data);
    }

    function message()
    {
        global $help;
        if (isset($_GET['message']) && isset($_GET['profileid'])) {
            if (!empty($_GET['message']) && !empty($_GET['profileid'])) {
                $message = $_GET['message'];
                $profileid = $_GET['profileid'];
                $actionby = $_SESSION['USERID'];
                global $database;
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($actionby != $profileid) {
                        if (strlen($message) <= 6072) {
                            $actionid = $database->get_actionid($profileid, 401);
                            $time = time();
                            $res = $database->message_insert($actionid, $actionby, $profileid, $message, $time);
                            if ($res) {
                                $remail = $database->setting_email_select($profileid);
                                if ($remail['message']) {
                                    global $email;
                                    $param = array();
                                    $param['type'] = 'message';
                                    $param['profileid'] = $profileid;
                                    $param['actionby'] = $actionby;
                                    $param['message'] = $message;
                                    $param['actionid'] = $actionid;
                                    $email->email_sample($param);
                                }
                                $data = array();
                                $data['ack'] = $res;
                                $data['actionid'] = $actionid;
                                $data['message'] = $message;
                                echo json_encode($data);
                            } else {
                                $help->error_description(10);
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(2);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function message_college()
    {
        global $help;
        if (isset($_GET['message']) && isset($_GET['college'])) {
            if (!empty($_GET['message']) && !empty($_GET['college'])) {
                $message = $_GET['message'];
                $college = $_GET['college'];
                $actionby = $_SESSION['USERID'];
                global $database;
                $drow = $database->diary_type_exists($college, 9);
                if ($drow['DIARYID'] == $college) {
                    if (strlen($message) <= 6072) {
                        $actionid = $database->get_actionid($college, 401);
                        $time = time();
                        $res = $database->message_insert($actionid, $actionby, $college, $message, $time);
                        if ($res) {
                            $result = $database->college_mate_select($college);
                            global $email;
                            $param = array();
                            $param['type'] = 'message';
                            $param['profileid'] = $row['PROFILEID'];
                            while ($row = $result->fetch_array()) {
                                $param['actionby'] = $actionby;
                                $param['message'] = $message;
                                $param['actionid'] = $actionid;
                                $email->email_sample($param);
                            }
                            $data = array();
                            $data['ack'] = $res;
                            $data['actionid'] = $actionid;
                            $data['message'] = $message;
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(11);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function mood()
    {
        global $help;
        if (isset($_GET['mood']) && isset($_GET['mood_desc'])) {
            if (!empty($_GET['mood'])) {
                $myprofileid = $_SESSION['userid'];
                $mood = $_GET['mood'];
                $mood_desc = $_GET['mood_desc'];
                global $database;
                $mrow = $database->mood_exists($mood);
                if ($mrow['MOODID'] == $mood) {
                    if (strlen($mood_desc) <= 6072) {
                        $actionid = $database->get_actionid($myprofileid, 1201);
                        if ($actionid) {
                            $result = $database->diary_insert($actionid, $mood_desc);
                            if ($result) {
                                $res = $database->map_insert($actionid, $mood);
                                if ($res) {
                                    $data = array();
                                    $data['ack'] = $res;
                                    echo json_encode($data);
                                }
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(11);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function request_fetch()
    {
        global $help;
        $data = array();
        $missu = array();
        $friend = array();
        $myprofileid = $_SESSION['userid'];
        global $database;
        global $memcached;
        $res = $database->request_notice_read($myprofileid);
        if ($result = $database->friend_invite_select($myprofileid)) {
            if ($result->num_rows) {
                $k = 0;
                while ($row = $result->fetch_array()) {
                    $friend[$k]['profileid'] = $row['FRIENDID'];
                    $name[$friend[$k]['profileid']] = $help->name_fetch($friend[$k]['profileid'], $memcached,
                        $database);
                    $pimage[$friend[$k]['profileid']] = $help->pimage_fetch($friend[$k]['profileid'],
                        $memcached, $database);
                    $k++;
                }
                $data['friend_request_count'] = $result->num_rows;
                $data['friend'] = $friend;
                $data['name'] = $name;
                $data['pimage'] = $pimage;
            } else {
                $data['count'] = 0;
                $data['message'] = 'You don\'t have any pending friend request';
            }
        }
        if ($result = $database->missu_select($myprofileid)) {
            if ($result->num_rows) {
                $k = 0;
                while ($row = $result->fetch_array()) {
                    $missu[$k]['profileid'] = $row['ACTIONBY'];
                    $missu[$k]['pageid'] = $row['ACTIONID'];
                    $name[$missu[$k]['profileid']] = $help->name_fetch($missu[$k]['profileid'], $memcached,
                        $database);
                    $pimage[$missu[$k]['profileid']] = $help->pimage_fetch($missu[$k]['profileid'],
                        $memcached, $database);
                    $k++;
                }
                $data['missu_count'] = $result->num_rows;
                $data['missu'] = $missu;
                $data['name'] = $name;
                $data['pimage'] = $pimage;
            } else {
                $data['count'] = 0;
                $data['message'] = 'Opps ! Nobody\'s missing you !';
            }
        }
        if ($result = $database->event_request_select($myprofileid)) {
            if ($result->num_rows) {
                $k = 0;
                while ($row = $result->fetch_array()) {
                    $event[$k]['eventid'] = $row['eventid'];
                    $event[$k]['pageid'] = $row['actionid'];
                    $e = $database->event_select($row['eventid']);
                    $event[$k]['event_name'] = $e['name'];
                    $k++;
                }
                $data['event_request_count'] = $result->num_rows;
                $data['event'] = $event;
            } else {
                $data['count'] = 0;
                $data['message'] = 'Opps ! No event requests !';
            }
        }
        echo json_encode($data);
    }

    function missu_fetch()
    {
        global $help;
        $data = array();
        $missu = array();
        $myprofileid = $_SESSION['userid'];
        global $database;
        global $memcached;
        if ($result = $database->missu_select($myprofileid)) {
            if ($result->num_rows) {
                $k = 0;
                while ($row = $result->fetch_array()) {
                    $missu[$k]['profileid'] = $row['ACTIONBY'];
                    $missu[$k]['pageid'] = $row['ACTIONID'];
                    $name[$missu[$k]['profileid']] = $help->name_fetch($missu[$k]['profileid'], $memcached,
                        $database);
                    $pimage[$missu[$k]['profileid']] = $help->pimage_fetch($missu[$k]['profileid'],
                        $memcached, $database);
                    $k++;
                }
                $data['count'] = $result->num_rows;
                $data['missu'] = $missu;
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                echo json_encode($data);
            } else {
                $data['count'] = 0;
                $data['message'] = 'Opps ! Nobody\'s missing you !';
                echo json_encode($data);
            }
        } else {
            $help->error_description(15);
        }
    }

    function missu()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            if (!empty($_GET['profileid'])) {
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                global $database;
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($myprofileid != $profileid) {
                        if ($database->check_friendship($myprofileid, $profileid) == 2) {
                            global $email;
                            $row = $database->missu_status($myprofileid, $profileid);
                            if ($row['status'] == 0) {
                                $actiontype = 501;
                                $actionid = $database->get_actionid($profileid, $actiontype);
                                if ($actionid) {
                                    $result = $database->missu_insert($actionid, $myprofileid, $profileid);
                                    if ($result == 1) {
                                        $data['result'] = $result;
                                        $data['actionid'] = $actionid;
                                        $data['message'] = 'Missed';
                                        $rnotice = $database->setting_notice_select($profileid);
                                        if ($rnotice['missu']) {
                                            $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                                        }
                                        $remail = $database->setting_email_select($profileid);
                                        if ($remail['missu']) {
                                            global $email;
                                            $param = array();
                                            $param['type'] = 'missu';
                                            $param['profileid'] = $profileid;
                                            $param['actionby'] = $myprofileid;
                                            $email->email_sample($param);
                                        }
                                        echo json_encode($data);
                                    }
                                } else {
                                    $help->error_description(15);

                                }
                            } else
                                if ($row['status'] == 2) {
                                    $pageid = $database->missu_actionid_select($myprofileid, $profileid);
                                    $actiontype = 502;
                                    $actionid = $database->get_actionid($profileid, $actiontype, $pageid);
                                    if ($actionid) {
                                        $result = $database->missu_delete($myprofileid, $profileid);
                                        $data['ack'] = 1;
                                        $data['message'] = 'Missed';
                                        echo json_encode($data);
                                        if ($result == 1) {
                                            $rnotice = $database->setting_notice_select($profileid);
                                            if ($rnotice['missu']) {
                                                $database->notice_insert($actionid, $profileid, $actiontype, $pageid);
                                            }
                                            $remail = $database->setting_email_select($profileid);
                                            if ($remail['missu']) {
                                                global $email;
                                                $param = array();
                                                $param['type'] = 'missu_return';
                                                $param['profileid'] = $profileid;
                                                $param['actionby'] = $myprofileid;
                                                $email->email_sample($param);
                                            }
                                        }
                                    } else {
                                        $help->error_description(15);
                                    }
                                } else {
                                    $data['ack'] = 0;
                                    $data['message'] = 'Please wait for a response on your miss u';
                                    echo json_encode($data);
                                }
                        } else {
                            $help->error_description(12);
                        }
                    } else {
                        $help->error_description(2);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_top_influencer_fetch()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            global $help;
            if (!empty($_GET['profileid'])) {
                $data = array();
                $match = array();
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                global $database;
                global $memcached;
                $check = $database->is_member($profileid, $myprofileid);
                if ($check->num_rows) {
                    if ($result = $database->top_influencer_select($profileid)) {
                        $k = 0;
                        while ($row = $result->fetch_array()) {
                            $match[$k]['profileid'] = $row['profileid'];
                            $name[$match[$k]['profileid']] = $help->name_fetch($match[$k]['profileid'], $memcached,
                                $database);
                            $pimage[$match[$k]['profileid']] = $help->pimage_fetch($match[$k]['profileid'],
                                $memcached, $database);
                            $k++;
                        }
                    }
                    $data['match'] = $match;
                    $data['count'] = count($match);
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function mutual_friend()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            global $help;
            if (!empty($_GET['profileid'])) {
                $data = array();
                $match = array();
                $non_match = array();
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                global $database;
                global $memcached;
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    $result = $database->friend_match($myprofileid, $profileid);
                    $num = $database->friend_match_count($myprofileid, $profileid);
                    if ($num) {
                        $k = 0;
                        while ($row = $result->fetch_array()) {
                            $match[$k]['profileid'] = $row['FRIENDID'];
                            $name[$match[$k]['profileid']] = $help->name_fetch($match[$k]['profileid'], $memcached,
                                $database);
                            $pimage[$match[$k]['profileid']] = $help->pimage_fetch($match[$k]['profileid'],
                                $memcached, $database);
                            $k++;
                        }
                    }
                    $data['count'] = $num;
                    $result = $database->friend_non_match($myprofileid, $profileid);
                    $num = $database->friend_non_match_count($myprofileid, $profileid);
                    if ($num) {
                        $k = 0;
                        while ($row = $result->fetch_array()) {
                            $non_match[$k]['profileid'] = $row['FRIENDID'];
                            $name[$non_match[$k]['profileid']] = $help->name_fetch($non_match[$k]['profileid'],
                                $memcached, $database);
                            $pimage[$non_match[$k]['profileid']] = $help->pimage_fetch($non_match[$k]['profileid'],
                                $memcached, $database);
                            $k++;
                        }
                    }
                    $data['ncount'] = $num;
                    $data['match'] = $match;
                    $data['non_match'] = $non_match;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function make_moderator()
    {
        global $help, $memcached, $database;
        if (isset($_GET['profileid'])) {
            if (isset($_GET['profileid'])) {
                $myprofileid = $_SESSION['userid'];
                if ($database->moderator_check($myprofileid)) {
                    $profileid = $_GET['profileid'];
                    $row = $database->is_user($profileid);
                    if ($row['USERID'] == $profileid) {
                        $database->make_moderator($profileid);
                        $value = $help->moderator_status($profileid, $memcached, $database, 1);
                        $data['ack'] = 1;
                        echo json_encode($data);
                    } else {
                        $help->error_description(16);
                    }
                } else {
                    $help->error_description(12);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    /*function md_load()
    {
    global $help,$database,$memcached;
    $action =array();
    $myprofileid = $_SESSION['userid'];
    $result = array();
    if($database->moderator_check($myprofileid))
    {	
    if($result = $database->MD_select())
    {
    $action['profileid'] = $result['PROFILEID'];
    $action['name'] = $help->name_fetch($result['PROFILEID'],$memcached,$database);
    $action['image'] = $help->pimage_fetch($result['PROFILEID'],$memcached,$database);
    
    
    $data['action'] = $action;
    echo json_encode($data);
    }
    else
    {	
    $help->error_description(15);
    }
    }	
    else
    {
    $help->error_description(12);					
    }
    }*/
    function md_remove()
    {
        global $help, $database, $memcached;
        if (isset($_GET['profileid'])) {
            if (!empty($_GET['profileid'])) {
                $action = array();
                $myprofileid = $_SESSION['userid'];
                $result = array();
                if ($database->moderator_check($myprofileid)) {
                    if ($result = $database->MD_remove($profileid)) {
                        $data['ack'] = '1';
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(12);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function moderator_fetch()
    {
        global $help, $database, $memcached;
        $action = array();
        $myprofileid = $_SESSION['userid'];
        $i = 0;
        if ($database->moderator_check($myprofileid)) {
            $result = $database->moderator_select();
            while ($row = $result->fetch_array()) {
                $action[$i]['profileid'] = $row['profileid'];
                $action[$i]['name'] = $help->name_fetch($row['profileid'], $memcached, $database);
                $action[$i]['image'] = $help->pimage_fetch($row['profileid'], $memcached, $database);
                $i++;
            }
            $data['action'] = $action;
            echo json_encode($data);
        } else {
            $help->error_description(12);
        }
    }
    function broadcast_pages_select()
    {
        global $help, $database, $memcached;
        $info = array();
        $myprofileid = $_SESSION['userid'];
        $i = 0;
        if ($database->moderator_check($myprofileid)) {
            $result = $database->page_select_all();
            while ($row = $result->fetch_array()) {
                $info[$i]['pageid'] = $row['pageid'];
                $info[$i]['pagename'] = $row['name'];
                $i++;
            }
            $data['info'] = $info;
            echo json_encode($data);
        } else {
            $help->error_description(12);
        }

    }
    function admin_usefullink()
    {
        global $help;
        if (isset($_GET['links']) && isset($_GET['title'])) {
            if (!empty($_GET['links']) && !empty($_GET['title'])) {
                global $database;

                $new_link = $_GET['links'];
                $link_title = $_GET['title'];
                $size = strlen($new_link);
                if ($size < 500) {

                    if ($data['link_id'] = $database->usefullink_insert($new_link, $link_title)) {
                        $data['ack'] = 1;
                        echo json_encode($data);
                    }

                } else {
                    $help->error_description(43);

                }
            } else {
                $help->error_description(18);
            }

        } else {
            $help->error_description(9);
        }

    }

    function admin_fetch_usefullink()
    {
        global $help;
        global $database;
        $k = 0;
        $data = array();

        $result = $database->usefullink_fetch();

        while ($res = $result->fetch_array()) {
            $data[$k]['link_id'] = $res['key'];
            $data[$k]['link'] = $res['usefullink'];
            $data[$k]['title'] = $res['title'];
            $k++;
        }

        echo json_encode($data);


    }

    function usefullink_delete()
    {
        global $help;
        if (isset($_GET['link_id'])) {
            if (!empty($_GET['link_id'])) {
                global $database;

                $link_id = $_GET['link_id'];

                if ($result = $database->delete_usefullink($link_id)) {
                    $data['ack'] = 1;
                    $data['id'] = $link_id;
                    echo json_encode($data);

                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }

        } else {
            $help->error_description(9);
        }

    }

    function info_update()
    {
        global $help;
        if (isset($_GET['infoadd']) && isset($_GET['infotype'])) {
            if (!empty($_GET['infoadd']) && !empty($_GET['infotype'])) {
                global $database;

                $info_name = $_GET['infoadd'];
                $type = $_GET['infotype'];

                if ($data['infoid'] = $database->mydiary_create_wo_admin($type, $info_name)) {
                    $data['ack'] = 1;
                    $data['infoadd'] = $info_name;
                    echo json_encode($data);

                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }

        } else {
            $help->error_description(9);
        }

    }

    function info_fetch()
    {
        global $help;
        global $database;
        if (isset($_GET['infotype'])) {
            if (!empty($_GET['infotype'])) {
                $info = array();
                $k = 0;
                $type = $_GET['infotype'];
                $result = $database->diary_fetch($type);
                while ($res = $result->fetch_array()) {
                    $info[$k]['id'] = $res['DIARYID'];
                    $info[$k]['name'] = $res['NAME'];
                    $k++;

                }
                $data['info'] = $info;

                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function info_delete()
    {
        global $help;
        if (isset($_GET['info_id'])) {
            if (!empty($_GET['info_id'])) {
                global $database;

                $info_id = $_GET['info_id'];

                if ($result = $database->delete_info($info_id)) {
                    $data['ack'] = 1;
                    $data['id'] = $info_id;
                    echo json_encode($data);

                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }

        } else {
            $help->error_description(9);
        }

    }

    function star_of_the_week()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['contribution'])) {
            if (!empty($_GET['profileid']) && !empty($_GET['contribution'])) {
                global $database;

                $profileid = $_GET['profileid'];
                $contribution = $_GET['contribution'];

                $size = strlen($contribution);
                if ($size < 500) {
                    $current_date = gmDate("Y-m-d");
                    $actiontype = 2450;
                    $actionid = $database->get_actionid($profileid, $actiontype);
                    if ($actionid) {
                        if ($result = $database->star_of_the_week($profileid, $contribution, $current_date,
                            $actionid)) {
                            $data['ack'] = 1;
                            echo json_encode($data);
                            global $email;
                            $param = array();

                            $res = $database->user_select_all_at_once();
                            while ($r = $res->fetch_array()) {
                                $profileid = $r['PROFILEID'];

                                $param['type'] = 'star_of_the_week_broadcast';
                                $param['email'] = $r['EMAIL'];
                                $param['profileid'] = $profileid;
                                $param['contribution'] = $contribution;
                                $param['date'] = $current_date;
                                $email->email_sample($param);
                            }

                        } else {
                            $help->error_description(15);
                        }
                    }
                } else {
                    $help->error_description(44);

                }
            } else {
                $help->error_description(18);
            }

        } else {
            $help->error_description(9);
        }

    }
    function star_of_the_week_fetch()
    {
        global $help;
        global $memcached;
        global $database;

        $star = array();
        if ($result = $database->star_of_the_week_fetch()) {
            $k = 0;
            while ($res = $result->fetch_array()) {
                $name[$res['PROFILEID']] = $help->name_fetch($res['PROFILEID'], $memcached, $database);
                $pimage[$res['PROFILEID']] = $help->pimage_fetch($res['PROFILEID'], $memcached,
                    $database);
                $star[$k]['profileid'] = $res['PROFILEID'];
                $star[$k]['contribution'] = $res['CONTRIBUTION'];
                $k++;
            }
            $data['pimage'] = $pimage;
            $data['name'] = $name;
            $data['star'] = $star;
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }


    }
    function group_pinned_doc_upload()
    {

        $doc_formats = array(
            "pdf",
            "pptx",
            "ppt",
            "docx",
            "doc",
            "txt",
            "xls",
            "xlsx",
            "ods",
            "one",
            "pps",
            "ps",
            "rtf",
            "msg",
            "pptm");

        $name = $_FILES['doc']['name'];
        $size = $_FILES['doc']['size'];
        $description = $_POST['doc_description'];
        $profileid = $_POST['doc_hidden_profileid'];
        $groupid = $profileid;
        $myprofileid = $_SESSION['userid'];
        global $help;
        global $doc_cdn;
        if (strlen($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            if (in_array(strtolower($ext), $doc_formats)) {
                $actiontype = 326;
                $container = 'doc';
                $cdn = $doc_cdn . '/';
                $limit = 10240 * 1024;
            } else {
                $data['ack'] = 4;
                echo json_encode($data);
                exit(1);
            }
            if ($size < $limit) {
                $tmp = $_FILES['doc']['tmp_name'];
                global $database;
                if ($database->group_exists($profileid) == $profileid) {
                    $row = $database->is_member($profileid, $myprofileid);
                    if ($row->num_rows) {
                        $file_to_be_uploaded = $_FILES['doc']['tmp_name'];
                        $ext = strtolower(pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION));
                        $filename = $help->photo_name($ext);
                        /*	echo $file_to_be_uploaded;
                        echo $container;
                        echo $filename;*/
                        if ($actual_doc_name = $help->cdn_upload($file_to_be_uploaded, $container, $filename)) {
                            if (isset($_SESSION['VISIBLE']))
                                $visible = $_SESSION['VISIBLE'];
                            else
                                $visible = 0;
                            global $database;
                            $actionid = $database->get_actionid($profileid, $actiontype, '0', $visible);
                            if ($actionid) {
                                $result = $database->diary_insert($actionid, $description);
                                if ($container == 'doc') {
                                    $result = $database->doc_insert($profileid, $actionid, $actual_doc_name, $name,
                                        $cdn);
                                    $res = $database->group_pinned_document_insert($actionid, $groupid);
                                }

                                $data = array();
                                $data['ack'] = 1;
                                $data['actiontype'] = $actiontype;
                                $data['profileid'] = $profileid;
                                $data['actionid'] = $actionid;
                                $data['time'] = time();
                                $data['page'] = $description;
                                $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                $data['file'] = $cdn . $actual_image_name;
                                $data['caption'] = $name;
                                echo json_encode($data);
                                $result = $database->member_select($profileid);
                                global $email;
                                $param = array();
                                $param['type'] = 'group_post';
                                $param['groupid'] = $profileid;
                                $param['page'] = $description;
                                $param['actionby'] = $myprofileid;
                                $param['actionid'] = $actionid;
                                while ($res = $result->fetch_array()) {
                                    $memberid = $res['profileid'];
                                    if ($memberid != $myprofileid) {
                                        $rnotice = $database->setting_notice_select($memberid);
                                        if ($rnotice['group_post']) {
                                            $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                        }
                                        $remail = $database->setting_email_select($memberid);
                                        if ($remail['group_post']) {
                                            $param['memberid'] = $memberid;
                                            $email->email_sample($param);

                                        }
                                    }
                                }
                            } else {
                                $data['ack'] = 0;
                                echo json_encode($data);
                            }
                        } else {
                            $data['ack'] = 2;
                            echo json_encode($data);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $data['ack'] = 3;
                echo json_encode($data);
            }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }


    function group_pinned_doc_fetch()
    {
        global $help;
        global $database;
        if (isset($_GET['groupid'])) {
            if (!empty($_GET['groupid'])) {
                $groupid = $_GET['groupid'];
                $type = 331;
                $res = $database->group_pinned_document_fetch($groupid);
                $k = 0;
                while ($NROW = $res->fetch_array()) {

                    $a[$k]['filename'] = $NROW['cdn'] . $NROW['filename'];
                    $a[$k]['caption'] = $NROW['caption'];
                    $a[$k]['docid'] = $NROW['docid'];
                    $dr = $database->diary_select($NROW['docid']);
                    $a[$k]['description'] = $dr['PAGE'];
                    $k++;
                } //$data['myprofileid'] = $_SESSION['USERID'];

                $data['pinned_doc'] = $a;
                echo json_encode($data);
            } else {
                $help->error_desscription(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function group_pinned_doc_remove()
    {
        global $help;
        global $database;
        if (isset($_GET['docid'])) {
            if (!empty($_GET['docid'])) {

                $docid = $_GET['docid'];
                if ($database->document_delete($docid)) {
                    $data['ack'] = 1;
                    $data['docid'] = $docid;
                    echo json_encode($data);
                } else {
                    $help->error_desscription(15);
                }

            } else {
                $help->error_desscription(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function flash_board()
    {
        global $photo_cdn;
        $valid_formats = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg");
        $name = $_FILES['photo_box']['name'];
        $size = $_FILES['photo_box']['size'];
        $description = $_POST['photo_description'];

        $profileid = $_SESSION['userid'];
        global $help;
        if (strlen($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            if (in_array(strtolower($ext), $valid_formats)) {
                $actiontype = 3000;
                $container = 'photo';
                $cdn = $photo_cdn . '/';
                $limit = 10240 * 1024;
            } else {
                $data['ack'] = 4;
                echo json_encode($data);
                exit(1);
            }
            if ($size < $limit) {
                $tmp = $_FILES['photo_box']['tmp_name'];
                global $database;
                $file_to_be_uploaded = $_FILES['photo_box']['tmp_name'];
                $ext = strtolower($ext);
                $filename = $help->photo_name($ext);

                if ($actual_image_name = $help->cdn_upload($file_to_be_uploaded, $container, $filename)) {
                    if (isset($_SESSION['VISIBLE']))
                        $visible = $_SESSION['VISIBLE'];
                    else
                        $visible = 0;
                    global $database;
                    $actionid = $database->get_actionid($profileid, $actiontype, '0', $visible);
                    if ($actionid) {

                        if ($container == 'photo') {
                            $result = $database->flash_board_insert($actual_image_name, $cdn, $description);
                        }
                        $data = array();
                        $data['ack'] = 1;
                        $data['actiontype'] = $actiontype;
                        //$data['profileid']=$profileid;
                        $data['actionid'] = $actionid;
                        $data['time'] = time();
                        $data['description'] = $description;
                        //$data['life_is_fun']= sha1($actionid.'pass1reset!');
                        $data['file'] = $cdn . $actual_image_name;
                        $data['caption'] = $name;
                        echo json_encode($data);
                    } else {
                        $data['ack'] = 0;
                        echo json_encode($data);
                    }
                } else {
                    $data['ack'] = 2;
                    echo json_encode($data);
                }
            } else {
                $help->error_description(12);
            }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }


    function flash_board_fetch()
    {
        global $help;
        global $memcached;
        global $database;
        $limit = 2;
        $star = array();
        if ($result = $database->flash_board_fetch($limit)) {


            $k = 0;
            while ($res = $result->fetch_array()) {

                $flash[$k]['image'] = $res['CDN'] . $res['FILENAME'];
                $flash[$k]['description'] = $res['DESCRIPTION'];
                $k++;
            }

            $data['flash'] = $flash;
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }


    }


    function star_remove()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            if (isset($_GET['profileid'])) {
                global $database;
                $myprofileid = $_SESSION['userid'];
                if ($database->star_check($myprofileid)) {
                    $profileid = $_GET['profileid'];
                    $row = $database->is_user($profileid);
                    if ($row['USERID'] == $profileid) {
                        $database->star_remove($profileid);
                        $data['ack'] = 1;
                        echo json_encode($data);
                    } else {
                        $help->error_description(16);
                    }
                } else {
                    $help->error_description(12);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function moderator_remove()
    {
        global $help, $memcached;
        if (isset($_GET['profileid'])) {
            if (isset($_GET['profileid'])) {
                global $database;
                $myprofileid = $_SESSION['userid'];
                if ($database->moderator_check($myprofileid)) {
                    $profileid = $_GET['profileid'];
                    $row = $database->is_user($profileid);
                    if ($row['USERID'] == $profileid) {
                        $database->moderator_remove($profileid);
                        $value = $help->moderator_status($profileid, $memcached, $database, 1);
                        $data['ack'] = 1;
                        echo json_encode($data);
                    } else {
                        $help->error_description(16);
                    }
                } else {
                    $help->error_description(12);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function user_delete()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            if (isset($_GET['profileid'])) {
                global $database;
                $myprofileid = $_SESSION['userid'];
                if ($database->moderator_check($myprofileid)) {
                    $profileid = $_GET['profileid'];
                    $row = $database->is_user($profileid);
                    if ($row['USERID'] == $profileid) {
                        $database->user_delete($profileid);
                        $data['ack'] = 1;
                        echo json_encode($data);
                    } else {
                        $help->error_description(16);
                    }
                } else {
                    $help->error_description(12);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function user_details_fetch()
    {
        global $help;
        if (isset($_GET['email'])) {
            if (isset($_GET['email'])) {
                global $database;
                $myprofileid = $_SESSION['userid'];
                if ($database->moderator_check($myprofileid)) {
                    global $memcached;
                    $email = $_GET['email'];
                    if ($help->is_email($email)) {
                        $row = $database->is_already_user($email);
                        if ($email == $row['EMAIL']) {
                            $profileid = $row['USERID'];
                            $data['ack'] = 1;
                            $data['profileid'] = $profileid;
                            $data['name'] = $help->name_fetch($profileid, $memcached, $database);
                            $data['pimage'] = $help->pimage_fetch($profileid, $memcached, $database);
                            echo json_encode($data);
                        } else {
                            $help->error_description(16);
                        }
                    } else {
                        $help->error_description(23);
                    }
                } else {
                    $help->error_description(12);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function admin_feed()
    {
        global $help;
        if (isset($_GET['start'])) {
            if (isset($_GET['start'])) {
                global $action, $name, $pimage;
                global $feed;
                global $database;
                $myprofileid = $_SESSION['userid'];
                if ($database->moderator_check($myprofileid)) {
                    global $memcached;
                    global $json;
                    global $encode;
                    $start = $_GET['start'];
                    $res = $database->everything_select($start, 10);
                    $k = 0;
                    while ($NROW = $res->fetch_array()) {
                        $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                        $action[$k]['admin_feed'] = 1;
                        $k++;

                    }
                    $data['action'] = $action;
                    $data['myprofileid'] = $_SESSION['USERID'];
                    $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                        $database);
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    $data['tag'] = $_SESSION['tag_json'];
                    echo json_encode($data);
                } else {
                    $help->error_description(12);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function technical_feed_fetch()
    {
        global $help;
        if (isset($_GET['start'])) {
            if (isset($_GET['start'])) {
                global $action, $name, $pimage;
                global $feed;
                global $database;
                global $memcached;
                global $json;
                global $encode;
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                $res = $database->tech_feed_select($myprofileid, $start, 10);
                $k = 0;
                while ($NROW = $res->fetch_array()) {
                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $k++;
                }
                $data['action'] = $action;
                $data['myprofileid'] = $_SESSION['USERID'];
                $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                    $database);
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function news_feed()
    {
        global $help;
        if (isset($_GET['start'])) {
            if (isset($_GET['start'])) {
                global $action, $name, $pimage;
                global $feed;
                global $database;
                global $memcached;
                global $json;
                global $encode;
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                $res = $database->new_friend_action_select($myprofileid, $start, 10);
                $k = 0;
                while ($NROW = $res->fetch_array()) {

                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $k++;
                }
                $data['action'] = $help->feed_privacy_filter($action, $myprofileid, $database);
                $data['myprofileid'] = $_SESSION['USERID'];
                $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                    $database);
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function notice_count()
    {
        global $help;
        global $database;
        $myprofileid = $_SESSION['userid'];
        $res = $database->notice_unread_count($myprofileid);
        $data['count'] = $res;
        echo json_encode($data);
    }

    function notice_fetch()
    {
        global $help;
        if (isset($_GET['start'])) {
            if ($_GET['start'] != '') {
                global $action, $name, $pimage;
                global $feed;
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                global $database;
                global $memcached;
                global $json;
                global $encode;
                $result = $database->notice_select($myprofileid, $start);
                $res = $database->notice_read($myprofileid);
                $k = 0;
                while ($NROW = $result->fetch_array()) {
                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $action[$k]['time'] = $help->get_utc($NROW['TIMESTAMP']); // Take the time of latest action
                    $k++;
                    $arr = explode(',', $NROW['ACTIONBY']);
                    foreach ($arr as $value) {
                        $name[$value] = $help->name_fetch($value, $memcached, $database);
                        $pimage[$value] = $help->pimage_fetch($value, $memcached, $database);
                    }
                }
                $data['action'] = $action;
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function people_fetch()
    {
        global $help;
        if (isset($_GET['start']) && (isset($_GET['college']) || isset($_GET['new_user']))) {
            if ($_GET['start'] != '' && (!empty($_GET['college']) || !empty($_GET['new_user']))) {
                $myprofileid = $_SESSION['USERID'];
                $start = $_GET['start'];
                global $database;
                global $memcached;
                if (isset($_GET['college'])) {
                    $res = $database->mate_select($start);
                } else
                    if (isset($_GET['new_user'])) {
                        $res = $database->user_select($start);
                    }
                $i = 0;
                while ($row = $res->fetch_array()) {
                    $people[$i]['profileid'] = $row['PROFILEID'];
                    $name[$people[$i]['profileid']] = $help->name_fetch($people[$i]['profileid'], $memcached,
                        $database);
                    $pimage[$people[$i]['profileid']] = $help->pimage_fetch($people[$i]['profileid'],
                        $memcached, $database);
                    if (isset($_GET['college'])) {
                        $people[$i]['cyear'] = $row['CYEAR'];
                        $profession = '';
                        $people[$i]['profession'] = '';
                        $company = $row['COMPANY'];
                        $people[$i]['company'] = '';
                    }
                    $people[$i]['status'] = $database->check_friendship($myprofileid, $people[$i]['profileid']);
                    $i++;
                }
                $data['action'] = $people;
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function pin_fetch()
    {
        global $help;
        global $feed;
        global $action, $name, $pimage;
        if (isset($_GET['start'])) {
            if (($_GET['start']) != '') {
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                $data = array();
                $photo = array();
                global $database;
                global $memcached;
                global $json;
                $r = $database->pin_select($myprofileid, $start, '10');
                $k = 0;
                while ($NROW = $r->fetch_array()) {
                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $k++;
                }
                $data['action'] = $action;
                $data['myprofileid'] = $myprofileid;
                $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                    $database);
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function blog_publish()
    {
        $path = "../user_image/";
        $valid_formats = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg");
        $name = $_FILES['photo_box']['name'];
        $size = $_FILES['photo_box']['size'];
        $blog_title = $_POST['blog_title'];
        $blog_content = $_POST['blog_content'];
        $profileid = $_POST['photo_hidden_profileid'];
        global $help;
        global $photo_cdn;
        global $video_cdn;
        global $doc_cdn;
        if (strlen($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $valid_formats)) {
                if ($size < (10240 * 1024)) // Image size max 10 MB
                    {
                    $actual_image_name = time() . "." . $ext;
                    $tmp = $_FILES['photo_box']['tmp_name'];
                    global $database;
                    $myprofileid = $_SESSION['userid'];
                    $check = $database->is_user($profileid);
                    if ($check['USERID'] == $profileid) {
                        if ($myprofileid == $profileid || $database->check_friendship($myprofileid, $profileid) ==
                            2) {
                            $file_to_be_uploaded = $_FILES['photo_box']['tmp_name'];
                            $ext = pathinfo($_FILES['photo_box']['name'], PATHINFO_EXTENSION);
                            $filename = $help->photo_name($ext);
                            if ($actual_image_name = $help->cdn_upload($file_to_be_uploaded, 'photo', $filename)) {
                                $caption = $_SESSION['NAME'];
                                if (isset($_SESSION['VISIBLE']))
                                    $visible = $_SESSION['VISIBLE'];
                                else
                                    $visible = 0;
                                global $database;
                                $actionid = $database->get_actionid($profileid, 600, 0, $visible);
                                if ($actionid) {
                                    $result = $database->diary_insert($actionid, $blog_title);
                                    $result = $database->comment_insert($actionid, $blog_content);
                                    $result = $database->image_insert($profileid, $actionid, $actual_image_name, '0',
                                        $photo_cdn . '/');
                                    $data = array();
                                    $data['ack'] = 1;
                                    $data['profileid'] = $profileid;
                                    $data['actionid'] = $actionid;
                                    $data['time'] = time();
                                    $data['page'] = $description;
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['file'] = $photo_cdn . '/' . $actual_image_name;
                                    echo json_encode($data);
                                } else {
                                    $data['ack'] = 0;
                                    echo json_encode($data);
                                }
                            } else {
                                $data['ack'] = 2;
                                echo json_encode($data);
                            }
                        } else {
                            $help->error_description();
                        }
                    }
                } else {
                    $data['ack'] = 3;
                    echo json_encode($data);
                }
            } else {
                $data['ack'] = 4;
                echo json_encode($data);
            }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }

    function profile_picture_upload()
    {
        $valid_formats = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg");
        $name = $_FILES['photo_box']['name'];
        $size = $_FILES['photo_box']['size'];
        $myprofileid = $_SESSION['userid'];
        global $help;
        global $photo_cdn;
        global $video_cdn;
        global $doc_cdn;
        global $profile1_cdn;
        if (strlen($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $valid_formats)) {
                if ($size < (10240 * 1024)) // Image size max 10 MB
                    {
                    $tmp = $_FILES['photo_box']['tmp_name'];
                    global $database;
                    $file_to_be_uploaded = $_FILES['photo_box']['tmp_name'];
                    $ext = pathinfo($_FILES['photo_box']['name'], PATHINFO_EXTENSION);
                    $filename = $help->photo_name($ext);
                    if ($actual_image_name = $help->cdn_upload($file_to_be_uploaded, 'profile', $filename)) {
                        $help->generate_image_thumbnail($file_to_be_uploaded, 100, 100);
                        if ($thumb_image_name = $help->cdn_upload($file_to_be_uploaded, 'profile-1', $filename)) {
                            if (isset($_SESSION['VISIBLE']))
                                $visible = $_SESSION['VISIBLE'];
                            else
                                $visible = 0;
                            $actionid = $database->get_actionid($myprofileid, 50, 0, $visible);
                            if ($actionid) {
                                $result = $database->image_insert($myprofileid, $actionid, $actual_image_name,
                                    '0', $profile1_cdn . '/');
                                $result = $database->profile_image_insert($actionid, 1, $actual_image_name, $profile1_cdn .
                                    '/');
                                $_SESSION['pimage'] = $profile1_cdn . '/' . $actual_image_name;
                                $_SESSION['profile_imageid'] = $actionid;
                                global $memcached;
                                $help->pimage_memcache_update($myprofileid, $profile1_cdn . '/' . $actual_image_name,
                                    $memcached);
                                $data = array();
                                $data['ack'] = 1;
                                $data['profileid'] = $myprofileid;
                                $data['actionid'] = $actionid;
                                $data['photo'] = $profile1_cdn . '/' . $filename;
                                $data['thumb'] = $profile1_cdn . '/' . $filename;
                                echo json_encode($data);
                            } else {
                                $data['ack'] = 0;
                                echo json_encode($data);
                            }
                        } else {
                            $data['ack'] = 2;
                            echo json_encode($data);
                        }
                    } else {
                        $data['ack'] = 2;
                        echo json_encode($data);
                    }
                } else {
                    $data['ack'] = 3;
                    echo json_encode($data);
                }
            } else {
                $data['ack'] = 4;
                echo json_encode($data);
            }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }

    function event_photo_upload()
    {
        $valid_formats = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg");
        $doc_formats = array(
            "pdf",
            "pptx",
            "ppt",
            "docx",
            "doc",
            "txt",
            "xls",
            "xlsx",
            "ods",
            "one",
            "pps",
            "ps",
            "rtf",
            "msg",
            "pptm");
        $video_formats = array(
            "mp4",
            "flv",
            "3gp",
            "mov",
            "mkv",
            "avi",
            "wmv");
        $name = $_FILES['photo_box']['name'];
        $size = $_FILES['photo_box']['size'];
        $description = $_POST['photo_description'];
        $profileid = $_POST['photo_hidden_profileid'];
        $myprofileid = $_SESSION['userid'];
        global $help;
        global $photo_cdn;
        global $video_cdn;
        global $doc_cdn;
        if (strlen($name)) {
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (in_array(strtolower($ext), $valid_formats)) {
                $actiontype = 406;
                $container = 'photo';
                $cdn = $photo_cdn . '/';
                $limit = 10240 * 1024;
            } else
                if (in_array(strtolower($ext), $video_formats)) {
                    $actiontype = 425;
                    $container = 'video';
                    $cdn = $video_cdn . '/';
                    $limit = 100960 * 1024;
                } else
                    if (in_array(strtolower($ext), $doc_formats)) {
                        $actiontype = 426;
                        $container = 'doc';
                        $cdn = $doc_cdn . '/';
                        $limit = 10240 * 1024;
                    } else {
                        $data['ack'] = 4;
                        echo json_encode($data);
                        exit(1);
                    }
                    if ($size < $limit) {
                        $tmp = $_FILES['photo_box']['tmp_name'];
                        global $database;
                        if ($database->event_exists($profileid) == $profileid) {
                            $row = $database->is_guest($profileid, $myprofileid);
                            if ($row->num_rows) {
                                $file_to_be_uploaded = $_FILES['photo_box']['tmp_name'];
                                $ext = strtolower(pathinfo($_FILES['photo_box']['name'], PATHINFO_EXTENSION));
                                $filename = $help->photo_name($ext);
                                if ($actiontype == 425) {
                                    $filename = $help->photo_name('flv');
                                    exec('/var/www/common/ffmpeg' . ' -i ' . $file_to_be_uploaded .
                                        ' -y -f flv -ar 44100 -ab 64 -ac 1 -acodec mp3 ' . '/var/www/video/' . $filename .
                                        ' &');
                                    $arr = explode('.', $filename);
                                    $vthumb = $arr[0] . '.jpg';
                                    exec('/var/www/common/ffmpeg' . ' -i ' . '/var/www/video/' . $filename .
                                        ' -ss 00:00:01.000 -f image2 -vframes 1 /var/www/video/' . $vthumb . ' &');
                                    $vthumb = $help->cdn_upload('/var/www/video/' . $vthumb, $container, $vthumb);
                                    $file_to_be_uploaded = '/var/www/video/' . $filename;
                                }
                                if ($actual_image_name = $help->cdn_upload($file_to_be_uploaded, $container, $filename)) {
                                    if (isset($_SESSION['VISIBLE']))
                                        $visible = $_SESSION['VISIBLE'];
                                    else
                                        $visible = 0;
                                    global $database;
                                    $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible);
                                    if ($actionid) {
                                        $result = $database->diary_insert($actionid, $description);
                                        if ($container == 'doc') {
                                            $result = $database->doc_insert($profileid, $actionid, $actual_image_name, $name,
                                                $cdn);
                                        } else
                                            if ($container == 'video') {
                                                $result = $database->video_insert($profileid, $actionid, $actual_image_name, $cdn);
                                                $name = $cdn . $vthumb;
                                            } else
                                                if ($container == 'photo') {
                                                    $result = $database->image_insert($profileid, $actionid, $actual_image_name, '0',
                                                        $cdn);
                                                }
                                        $data = array();
                                        $data['ack'] = 1;
                                        $data['actiontype'] = $actiontype;
                                        $data['profileid'] = $profileid;
                                        $data['actionid'] = $actionid;
                                        $data['time'] = time();
                                        $data['page'] = $description;
                                        $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                        $data['file'] = $cdn . $actual_image_name;
                                        $data['caption'] = $name;
                                        echo json_encode($data);
                                        $result = $database->guest_select($profileid);
                                        global $email;
                                        $param = array();
                                        $param['type'] = 'event_post';
                                        $param['eventid'] = $profileid;
                                        $param['page'] = $description;
                                        $param['actionby'] = $myprofileid;
                                        $param['actionid'] = $actionid;
                                        while ($res = $result->fetch_array()) {
                                            $memberid = $res['profileid'];
                                            if ($memberid != $myprofileid) {
                                                $rnotice = $database->setting_notice_select($memberid);
                                                if ($rnotice['event_post']) {
                                                    $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                                }
                                                $remail = $database->setting_email_select($memberid);
                                                if ($remail['event_post']) {
                                                    $param['memberid'] = $memberid;
                                                    $email->email_sample($param);
                                                }
                                            }
                                        }
                                    } else {
                                        $data['ack'] = 0;
                                        echo json_encode($data);
                                    }
                                } else {
                                    $data['ack'] = 2;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(12);
                            }
                        } else {
                            $help->error_description(16);
                        }
                    } else {
                        $data['ack'] = 3;
                        echo json_encode($data);
                    }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }
    function page_photo_upload()
    {
        $valid_formats = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg");
        $doc_formats = array(
            "pdf",
            "pptx",
            "ppt",
            "docx",
            "doc",
            "txt",
            "xls",
            "xlsx",
            "ods",
            "one",
            "pps",
            "ps",
            "rtf",
            "msg",
            "pptm");
        $video_formats = array(
            "mp4",
            "flv",
            "3gp",
            "mov",
            "mkv",
            "avi",
            "wmv");
        $name = $_FILES['photo_box']['name'];
        $size = $_FILES['photo_box']['size'];
        $description = $_POST['photo_description'];
        $profileid = $_POST['photo_hidden_profileid'];
        $myprofileid = $_SESSION['userid'];
        global $help;
        global $photo_cdn;
        global $video_cdn;
        global $doc_cdn;
        if (strlen($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $valid_formats)) {
                $actiontype = 2906;
                $container = 'photo';
                $cdn = $photo_cdn . '/';
                $limit = 10240 * 1024;
            } else
                if (in_array(strtolower($ext), $video_formats)) {
                    $actiontype = 2925;
                    $container = 'video';
                    $cdn = $video_cdn . '/';
                    $limit = 100960 * 1024;
                } else
                    if (in_array(strtolower($ext), $doc_formats)) {
                        $actiontype = 2926;
                        $container = 'doc';
                        $cdn = $doc_cdn . '/';
                        $limit = 10240 * 1024;
                    } else {
                        $data['ack'] = 4;
                        echo json_encode($data);
                        exit(1);
                    }
                    if ($size < $limit) {
                        $tmp = $_FILES['photo_box']['tmp_name'];
                        global $database;
                        $row = $database->page_exists($profileid);
                        if ($row['pageid'] == $profileid) {
                            $row1 = $database->is_follower($profileid, $myprofileid);
                            if ($row1->num_rows) {
                                $file_to_be_uploaded = $_FILES['photo_box']['tmp_name'];
                                $ext = strtolower(pathinfo($_FILES['photo_box']['name'], PATHINFO_EXTENSION));
                                $filename = $help->photo_name($ext);
                                if ($actiontype == 2925) {
                                    $filename = $help->photo_name('flv');
                                    exec('/var/www/common/ffmpeg' . ' -i ' . $file_to_be_uploaded .
                                        ' -y -f flv -ar 44100 -ab 64 -ac 1 -acodec mp3 ' . '/var/www/video/' . $filename .
                                        ' &');
                                    $arr = explode('.', $filename);
                                    $vthumb = $arr[0] . '.jpg';
                                    exec('/var/www/common/ffmpeg' . ' -i ' . '/var/www/video/' . $filename .
                                        ' -ss 00:00:01.000 -f image2 -vframes 1 /var/www/video/' . $vthumb . ' &');
                                    $vthumb = $help->cdn_upload('/var/www/video/' . $vthumb, $container, $vthumb);
                                    $file_to_be_uploaded = '/var/www/video/' . $filename;
                                }
                                if ($actual_image_name = $help->cdn_upload($file_to_be_uploaded, $container, $filename)) {
                                    $visible = 0;
                                    global $database;
                                    $actionid = $database->get_actionid($profileid, $actiontype, '0', $visible);
                                    if ($actionid) {
                                        $result = $database->diary_insert($actionid, $description);
                                        if ($container == 'doc') {
                                            $result = $database->doc_insert($profileid, $actionid, $actual_image_name, $name,
                                                $cdn);
                                        } else
                                            if ($container == 'video') {
                                                $result = $database->video_insert($profileid, $actionid, $actual_image_name, $cdn);
                                                $name = $cdn . $vthumb;
                                            } else
                                                if ($container == 'photo') {
                                                    $result = $database->image_insert($profileid, $actionid, $actual_image_name, '0',
                                                        $cdn);
                                                }
                                        $data = array();
                                        $data['ack'] = 1;
                                        $data['actiontype'] = $actiontype;
                                        $data['profileid'] = $profileid;
                                        $data['actionid'] = $actionid;
                                        $data['page_pageid'] = $row['pageid'];
                                        $data['page_name'] = $row['name'];
                                        $data['time'] = time();
                                        $data['page'] = $description;
                                        $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                        $data['file'] = $cdn . $actual_image_name;
                                        $data['caption'] = $name;
                                        echo json_encode($data);
                                        global $email;
                                        $param = array();
                                        $param['type'] = 'page_post';
                                        $param['profileid'] = $profileid;
                                        $param['page'] = $description;
                                        $param['actionby'] = $myprofileid;
                                        $param['actionid'] = $actionid;
                                        $database->broadcast_notice_insert($actionid, $actiontype, $profileid);
                                    } else {
                                        $data['ack'] = 0;
                                        echo json_encode($data);
                                    }
                                } else {
                                    $data['ack'] = 2;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(12);
                            }
                        } else {
                            $help->error_description(16);
                        }
                    } else {
                        $data['ack'] = 3;
                        echo json_encode($data);
                    }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }
    function group_photo_upload()
    {

        $valid_formats = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg");
        $doc_formats = array(
            "pdf",
            "pptx",
            "ppt",
            "docx",
            "doc",
            "txt",
            "xls",
            "xlsx",
            "ods",
            "one",
            "pps",
            "ps",
            "rtf",
            "msg",
            "pptm");
        $video_formats = array(
            "mp4",
            "flv",
            "3gp",
            "mov",
            "mkv",
            "avi",
            "wmv");
        $name = $_FILES['photo_box']['name'];
        $size = $_FILES['photo_box']['size'];
        $description = $_POST['photo_description'];
        $profileid = $_POST['photo_hidden_profileid'];
        $myprofileid = $_SESSION['userid'];
        global $help;
        global $photo_cdn;
        global $video_cdn;
        global $doc_cdn;
        if (strlen($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $valid_formats)) {
                $actiontype = 306;
                $container = 'photo';
                $cdn = $photo_cdn . '/';
                $limit = 10240 * 1024;
            } else
                if (in_array(strtolower($ext), $video_formats)) {
                    $actiontype = 325;
                    $container = 'video';
                    $cdn = $video_cdn . '/';
                    $limit = 100960 * 1024;
                } else
                    if (in_array(strtolower($ext), $doc_formats)) {
                        $actiontype = 326;
                        $container = 'doc';
                        $cdn = $doc_cdn . '/';
                        $limit = 10240 * 1024;
                    } else {
                        $data['ack'] = 4;
                        echo json_encode($data);
                        exit(1);
                    }
                    if ($size < $limit) {
                        $tmp = $_FILES['photo_box']['tmp_name'];
                        global $database;
                        if ($database->group_exists($profileid) == $profileid) {
                            $row = $database->is_member($profileid, $myprofileid);
                            if ($row->num_rows) {
                                $file_to_be_uploaded = $_FILES['photo_box']['tmp_name'];
                                $ext = strtolower(pathinfo($_FILES['photo_box']['name'], PATHINFO_EXTENSION));
                                $filename = $help->photo_name($ext);
                                if ($actiontype == 325) {
                                    $filename = $help->photo_name('flv');
                                    exec('/var/www/common/ffmpeg' . ' -i ' . $file_to_be_uploaded .
                                        ' -y -f flv -ar 44100 -ab 64 -ac 1 -acodec mp3 ' . '/var/www/video/' . $filename .
                                        ' &');
                                    $arr = explode('.', $filename);
                                    $vthumb = $arr[0] . '.jpg';
                                    exec('/var/www/common/ffmpeg' . ' -i ' . '/var/www/video/' . $filename .
                                        ' -ss 00:00:01.000 -f image2 -vframes 1 /var/www/video/' . $vthumb . ' &');
                                    $vthumb = $help->cdn_upload('/var/www/video/' . $vthumb, $container, $vthumb);
                                    $file_to_be_uploaded = '/var/www/video/' . $filename;
                                }
                                if ($actual_image_name = $help->cdn_upload($file_to_be_uploaded, $container, $filename)) {
                                    if (isset($_SESSION['VISIBLE']))
                                        $visible = $_SESSION['VISIBLE'];
                                    else
                                        $visible = 0;
                                    global $database;
                                    $actionid = $database->get_actionid($profileid, $actiontype, '0', $visible);
                                    if ($actionid) {
                                        $result = $database->diary_insert($actionid, $description);
                                        if ($container == 'doc') {
                                            $result = $database->doc_insert($profileid, $actionid, $actual_image_name, $name,
                                                $cdn);
                                        } else
                                            if ($container == 'video') {
                                                $result = $database->video_insert($profileid, $actionid, $actual_image_name, $cdn);
                                                $name = $cdn . $vthumb;
                                            } else
                                                if ($container == 'photo') {
                                                    $result = $database->image_insert($profileid, $actionid, $actual_image_name, '0',
                                                        $cdn);
                                                }
                                        $data = array();
                                        $data['ack'] = 1;
                                        $data['actiontype'] = $actiontype;
                                        $data['profileid'] = $profileid;
                                        $data['actionid'] = $actionid;
                                        $data['time'] = time();
                                        $data['page'] = $description;
                                        $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                        $data['file'] = $cdn . $actual_image_name;
                                        $data['caption'] = $name;
                                        echo json_encode($data);
                                        $result = $database->member_select($profileid);
                                        global $email;
                                        $param = array();
                                        $param['type'] = 'group_post';
                                        $param['groupid'] = $profileid;
                                        $param['page'] = $description;
                                        $param['actionby'] = $myprofileid;
                                        $param['actionid'] = $actionid;
                                        while ($res = $result->fetch_array()) {
                                            $memberid = $res['profileid'];
                                            if ($memberid != $myprofileid) {
                                                $rnotice = $database->setting_notice_select($memberid);
                                                if ($rnotice['group_post']) {
                                                    $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                                }
                                                $remail = $database->setting_email_select($memberid);
                                                if ($remail['group_post']) {
                                                    $param['memberid'] = $memberid;
                                                    $email->email_sample($param);

                                                }
                                            }
                                        }
                                    } else {
                                        $data['ack'] = 0;
                                        echo json_encode($data);
                                    }
                                } else {
                                    $data['ack'] = 2;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(12);
                            }
                        } else {
                            $help->error_description(16);
                        }
                    } else {
                        $data['ack'] = 3;
                        echo json_encode($data);
                    }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }

    function new_version_upload()
    {
        $valid_formats = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg");
        $doc_formats = array(
            "pdf",
            "pptx",
            "ppt",
            "docx",
            "doc",
            "txt",
            "xls",
            "xlsx",
            "ods",
            "one",
            "pps",
            "ps",
            "rtf",
            "msg",
            "pptm");
        $video_formats = array(
            "mp4",
            "flv",
            "3gp",
            "mov",
            "mkv",
            "avi",
            "wmv");
        $name = $_FILES['photo_box']['name'];
        $size = $_FILES['photo_box']['size'];
        $description = 'A new version of the file';
        $profileid = $_POST['photo_hidden_profileid'];
        $pageid = $_POST['pageid'];
        $myprofileid = $_SESSION['userid'];
        global $help;
        global $photo_cdn;
        global $video_cdn;
        global $doc_cdn;
        if (strlen($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $doc_formats)) {
                $actiontype = 327;
                $container = 'doc';
                $cdn = $doc_cdn . '/';
                $limit = 10240 * 1024;
            } else {
                $data['ack'] = 4;
                echo json_encode($data);
                exit(1);
            }
            if ($size < $limit) {
                $tmp = $_FILES['photo_box']['tmp_name'];
                global $database;
                if ($database->group_exists($profileid) == $profileid) {
                    $row = $database->is_member($profileid, $myprofileid);
                    if ($row->num_rows) {
                        $file_to_be_uploaded = $_FILES['photo_box']['tmp_name'];
                        $ext = strtolower(pathinfo($_FILES['photo_box']['name'], PATHINFO_EXTENSION));
                        $filename = $help->photo_name($ext);
                        if ($actual_image_name = $help->cdn_upload($file_to_be_uploaded, $container, $filename)) {
                            if (isset($_SESSION['VISIBLE']))
                                $visible = $_SESSION['VISIBLE'];
                            else
                                $visible = 0;
                            global $database;
                            $actionid = $database->get_actionid($profileid, $actiontype, $pageid, $visible);
                            if ($actionid) {
                                if ($container == 'doc') {
                                    $result = $database->doc_insert($profileid, $actionid, $actual_image_name, $name,
                                        $cdn);
                                }
                                $data = array();
                                $data['ack'] = 1;
                                $data['actiontype'] = $actiontype;
                                $data['profileid'] = $profileid;
                                $data['actionid'] = $actionid;
                                $data['time'] = time();
                                $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                $data['file'] = $cdn . $actual_image_name;
                                $data['caption'] = $name;
                                echo json_encode($data);
                                $result = $database->member_select($profileid);
                                global $email;
                                $param = array();
                                $param['type'] = 'group_post';
                                $param['groupid'] = $profileid;
                                $param['page'] = $description;
                                $param['actionby'] = $myprofileid;
                                $param['actionid'] = $actionid;

                                while ($res = $result->fetch_array()) {
                                    $memberid = $res['profileid'];
                                    if ($memberid != $myprofileid) {
                                        $rnotice = $database->setting_notice_select($memberid);
                                        if ($rnotice['group_post']) {
                                            $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                        }
                                        $remail = $database->setting_email_select($memberid);
                                        if ($remail['group_post']) {
                                            $param['memberid'] = $memberid;
                                            $email->email_sample($param);

                                        }
                                    }
                                }
                            } else {
                                $data['ack'] = 0;
                                echo json_encode($data);
                            }
                        } else {
                            $data['ack'] = 2;
                            echo json_encode($data);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $data['ack'] = 3;
                echo json_encode($data);
            }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }

    function photo_upload()
    {
        global $photo_cdn;
        global $video_cdn;
        global $doc_cdn;
        $valid_formats = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg");
        $doc_formats = array(
            "pdf",
            "pptx",
            "ppt",
            "docx",
            "doc",
            "txt",
            "xls",
            "xlsx",
            "ods",
            "one",
            "pps",
            "ps",
            "rtf",
            "msg",
            "pptm");
        $video_formats = array(
            "mp4",
            "flv",
            "3gp",
            "mov",
            "mkv",
            "avi",
            "wmv");
        $name = $_FILES['photo_box']['name'];
        $size = $_FILES['photo_box']['size'];
        $description = $_POST['photo_description'];
        $profileid = $_POST['photo_hidden_profileid'];
        $myprofileid = $_SESSION['userid'];
        global $help;
        if (strlen($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $valid_formats)) {
                $actiontype = 6;
                $container = 'photo';
                $cdn = $photo_cdn . '/';
                $limit = 10240 * 1024;
            } else
                if (in_array(strtolower($ext), $video_formats)) {
                    $actiontype = 2500;
                    $container = 'video';
                    $cdn = $video_cdn . '/';
                    $limit = 100960 * 1024;
                } else
                    if (in_array(strtolower($ext), $doc_formats)) {
                        $actiontype = 2600;
                        $container = 'doc';
                        $cdn = $doc_cdn . '/';
                        $limit = 10240 * 1024;
                    } else {
                        $data['ack'] = 4;
                        echo json_encode($data);
                        exit(1);
                    }
                    if ($size < $limit) {
                        $tmp = $_FILES['photo_box']['tmp_name'];
                        global $database;
                        $check = $database->is_user($profileid);
                        if ($check['USERID'] == $profileid) {
                            if ($myprofileid == $profileid || $database->check_friendship($myprofileid, $profileid) ==
                                2) {
                                $file_to_be_uploaded = $_FILES['photo_box']['tmp_name'];
                                $ext = strtolower(pathinfo($_FILES['photo_box']['name'], PATHINFO_EXTENSION));
                                $filename = $help->photo_name($ext);
                                if ($actiontype == 2500) {
                                    $filename = $help->photo_name('flv');
                                    exec('/var/www/common/ffmpeg' . ' -i ' . $file_to_be_uploaded .
                                        ' -y -f flv -ar 44100 -ab 64 -ac 1 -acodec mp3 ' . '/var/www/video/' . $filename .
                                        ' &');
                                    $arr = explode('.', $filename);
                                    $vthumb = $arr[0] . '.jpg';
                                    exec('/var/www/common/ffmpeg' . ' -i ' . '/var/www/video/' . $filename .
                                        ' -ss 00:00:01.000 -f image2 -vframes 1 /var/www/video/' . $vthumb . ' &');
                                    $vthumb = $help->cdn_upload('/var/www/video/' . $vthumb, $container, $vthumb);
                                    $file_to_be_uploaded = '/var/www/video/' . $filename;
                                }
                                if ($actual_image_name = $help->cdn_upload($file_to_be_uploaded, $container, $filename)) {
                                    if (isset($_SESSION['VISIBLE']))
                                        $visible = $_SESSION['VISIBLE'];
                                    else
                                        $visible = 0;
                                    global $database;
                                    $actionid = $database->get_actionid($profileid, $actiontype, '0', $visible);
                                    if ($actionid) {
                                        $result = $database->diary_insert($actionid, $description);
                                        if ($container == 'doc') {
                                            $result = $database->doc_insert($profileid, $actionid, $actual_image_name, $name,
                                                $cdn);
                                        } else
                                            if ($container == 'video') {
                                                $result = $database->video_insert($profileid, $actionid, $actual_image_name, $cdn,
                                                    $vthumb);
                                                $name = $cdn . $vthumb;
                                            } else
                                                if ($container == 'photo') {
                                                    $result = $database->image_insert($profileid, $actionid, $actual_image_name, '0',
                                                        $cdn);
                                                }
                                        $data = array();
                                        $data['ack'] = 1;
                                        $data['actiontype'] = $actiontype;
                                        $data['profileid'] = $profileid;
                                        $data['actionid'] = $actionid;
                                        $data['time'] = time();
                                        $data['page'] = $description;
                                        $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                        $data['file'] = $cdn . $actual_image_name;
                                        $data['caption'] = $name;
                                        echo json_encode($data);
                                        if ($profileid != $myprofileid) {
                                            $rnotice = $database->setting_notice_select($profileid);
                                            if ($rnotice['profile_post']) {
                                                $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                                            }
                                            $remail = $database->setting_email_select($profileid);
                                            if ($remail['profile_post']) {
                                                global $email;
                                                $param = array();
                                                $param['type'] = 'profile_post';
                                                $param['profileid'] = $profileid;
                                                $param['page'] = $description;
                                                $param['actionby'] = $myprofileid;
                                                $param['actionid'] = $actionid;
                                                $email->email_sample($param);
                                            }
                                        }
                                    } else {
                                        $data['ack'] = 0;
                                        echo json_encode($data);
                                    }
                                } else {
                                    $data['ack'] = 2;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(12);
                            }
                        } else {
                            $help->error_description(16);
                        }
                    } else {
                        $data['ack'] = 3;
                        echo json_encode($data);
                    }
        } else {
            $data['ack'] = 5;
            echo json_encode($data);
        }
    }

    function poll()
    {
        global $help;
        global $action, $name, $pimage;
        if (isset($_GET['last_poll_time'])) {
            if (!empty($_GET['last_poll_time'])) {
                $last_poll_time = $_GET['last_poll_time'];
                $myprofileid = $_SESSION['userid'];
                global $database;
                global $memcached;
                global $encode;
                global $json;
                global $feed;
                $res = $database->news_poll($myprofileid, $last_poll_time);
                $k = 0;
                while ($NROW = $res->fetch_array()) {
                    $feed->actiontype_encode($NROW, '0', $json, $help, $encode, $database, $memcached);
                }
                $data['action'] = $action;
                $data['myprofileid'] = $_SESSION['USERID'];
                $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                    $database);
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function praise()
    {
        global $help;
        if (isset($_GET['letter_title']) && isset($_GET['letter_content']) && isset($_GET['profileid'])) {
            if (!empty($_GET['letter_title']) && !empty($_GET['letter_content']) && $_GET['profileid'] !=
                '') {
                $myprofileid = $_SESSION['userid'];
                $letter_title = $_GET['letter_title'];
                global $database;
                $letter_content = $_GET['letter_content'];
                $profileid = $_GET['profileid'];
                if (strlen($letter_title) <= 6072 && strlen($letter_content) <= 6072) {
                    $visible = 7;
                    $actiontype = 2400;
                    $actionid = $database->get_actionid($profileid, $actiontype, 0, 0);
                    if ($actionid) {
                        $result = $database->diary_insert($actionid, $letter_title);
                        $result = $database->comment_insert($actionid, $letter_content);
                        if ($result) {
                            $rnotice = $database->setting_notice_select($profileid);
                            if ($rnotice['praise']) {
                                $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                            }
                            $remail = $database->setting_email_select($profileid);
                            if ($remail['praise']) {
                                global $email;
                                $param = array();
                                $param['type'] = 'praise';
                                $param['profileid'] = $profileid;
                                $param['page'] = $letter_title;
                                $param['content'] = $letter_content;
                                $param['actionid'] = $actionid;
                                $email->email_sample($param);
                            }
                            $data['ack'] = $result;
                            $data['actionid'] = $actionid;
                            $data['letter_title'] = $letter_title;
                            $data['letter_content'] = $letter_content;
                            echo json_encode($data);
                        }
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function group_fetch()
    {
        global $help;


        $myprofileid = $_SESSION['userid'];
        global $database, $icon_cdn;
        global $help;
        global $json;
        global $memcached;
        $group = array();
        if ($result = $database->group_fetch()) {
            $k = 0;
            while ($row = $result->fetch_array()) {
                $group[$k]['groupid'] = $row['groupid'];
                $group[$k]['description'] = $row['description'];
                $group[$k]['show'] = $row['show'];
                $group[$k]['name'] = $row['name'];
                $group[$k]['pimage'] = $icon_cdn . '/group.png';
                $k++;
            }
            $data['action'] = $group;
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }


    }


    function group_add_fetch()
    {
        global $help;


        $myprofileid = $_SESSION['userid'];
        global $database, $icon_cdn;
        global $help;
        global $json;
        global $memcached;
        $guess = array();
        $name = array();
        $pimage = array();
        if ($result = $database->added_group_fetch()) {
            $k = 0;
            while ($row = $result->fetch_array()) {
                $group[$k]['groupid'] = $row['groupid'];
                $group[$k]['description'] = $row['description'];
                $group[$k]['name'] = $row['name'];
                $group[$k]['pimage'] = $icon_cdn . '/group.png';
                $k++;

            }

            $data['action'] = $group;
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }


    }


    function group_suggest_add()
    {
        global $help;
        if (isset($_GET['groupid'])) {
            if (!empty($_GET['groupid'])) {

                $groupid = $_GET['groupid'];
                $myprofileid = $_SESSION['userid'];
                global $database;
                global $help;
                global $json;
                global $memcached;
                $guess = array();
                $name = array();
                $pimage = array();
                if ($result = $database->group_add($groupid)) {


                    $data['ack'] = '1';
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_remove()
    {
        global $help;
        if (isset($_GET['groupid'])) {
            if (!empty($_GET['groupid'])) {

                $groupid = $_GET['groupid'];
                $myprofileid = $_SESSION['userid'];
                global $database;
                global $help;
                global $json;
                global $memcached;
                $guess = array();
                $name = array();
                $pimage = array();
                if ($result = $database->group_remove($groupid)) {


                    $data['ack'] = '1';
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function bio_percentage()
    {

        global $help, $database;

        $myprofileid = $_SESSION['userid'];

        $x = 0;
        $total = 19;

        if ($r = $database->info_fetch($myprofileid, '234')) {

            $x++;

        }

        if ($r = $database->info_fetch($myprofileid, '202')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '239')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '235')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '230')) {
            $x++;
        }
        if ($r = $database->info_fetch($myprofileid, '236')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '231')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '232')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '233')) {
            $x++;
        }


        if ($r = $database->info_fetch($myprofileid, '205')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '204')) {
            $x++;
        }


        if ($r = $database->info_fetch($myprofileid, '203')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '201')) {
            $x++;
        }


        if ($r = $database->info_fetch($myprofileid, '211')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '206')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '207')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '208')) {
            $x++;
        }

        if ($r = $database->info_fetch($myprofileid, '209')) {
            $x++;
        }


        $bio_perc = ($x / $total) * 100;
        $perc = floor($bio_perc);
        $data['bio_perc'] = $perc;
        $data['profileid'] = $myprofileid;
        echo json_encode($data);
    }


    function praise_fetch()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            if (!empty($_GET['profileid'])) {

                $profileid = $_GET['profileid'];

                $data = array();


                global $database, $memcached;
                $actiontype = 2400;
                if ($result = $database->bio_select($profileid)) {
                    $name = $result['NAME'];
                }
                if ($r = $database->fetch_actionid($profileid, $actiontype)) {
                    $k = 0;
                    while ($row = $r->fetch_array()) {
                        $actionid = $row['ACTIONID'];
                        $praise[$k]['actionby_profileid'] = $row['ACTIONBY'];

                        if ($result = $database->bio_select($row['ACTIONBY'])) {
                            $praise[$k]['actionon'] = $name;
                            $praise[$k]['actionby'] = $result['NAME'];
                            $pimage[$praise[$k]['actionby_profileid']] = $help->pimage_fetch($praise[$k]['actionby_profileid'],
                                $memcached, $database);
                        }
                        if ($m = $database->praise_select($actionid)) {

                            $praise[$k]['title'] = $m['PAGE'];

                            $praise[$k]['comment'] = $m['COMMENT'];

                            $k++;
                        }
                    }

                    $data['action'] = $praise;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);

                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }

    }


    function direct_letter()
    {
        global $help;
        if (isset($_GET['letter_title']) && isset($_GET['letter_content']) && isset($_GET['letter_open'])) {
            if (!empty($_GET['letter_title']) && !empty($_GET['letter_content']) && $_GET['letter_open'] !=
                '') {
                $md_profileid = 1000000122;
                $myprofileid = $_SESSION['userid'];
                $letter_title = $_GET['letter_title'];
                global $database;
                $letter_content = $_GET['letter_content'];
                $letter_open = $_GET['letter_open'];
                if (strlen($letter_title) <= 6072 && strlen($letter_content) <= 6072) {
                    $visible = 7;
                    if (letter_open == 1) {
                        $visible = 0;
                    }
                    $actiontype = 700;
                    $actionid = $database->get_actionid($md_profileid, $actiontype, 0, $visible);
                    if ($actionid) {
                        $result = $database->diary_insert($actionid, $letter_title);
                        $result = $database->comment_insert($actionid, $letter_content);
                        if ($result) {
                            $rnotice = $database->setting_notice_select($profileid);
                            if ($rnotice['direct_letter']) {
                                $database->notice_insert($actionid, $profileid, $actiontype, $actionid);
                            }
                            $remail = $database->setting_email_select($profileid);
                            if ($remail['direct_letter']) {
                                global $email;
                                $param = array();
                                $param['type'] = 'direct_letter';
                                $param['profileid'] = $profileid;
                                $param['page'] = $letter_title;
                                $param['actionby'] = $myprofileid;
                                $param['actionid'] = $actionid;
                                $email->email_sample($param);
                            }
                            $data['ack'] = $result;
                            $data['actionid'] = $actionid;
                            $data['letter_title'] = $letter_title;
                            $data['letter_content'] = $letter_content;
                            echo json_encode($data);
                        }
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function answer()
    {
        global $help;
        if (isset($_GET['pageid']) && isset($_GET['optionid'])) {
            if (!empty($_GET['pageid']) && !empty($_GET['optionid'])) {
                $myprofileid = $_SESSION['userid'];
                $pageid = $_GET['pageid'];
                $optionid = $_GET['optionid'];
                global $database;
                $result = $database->actionid_select($pageid);
                if ($result->num_rows) {
                    $row = $result->fetch_array();
                    $profileid = $row['PROFILEID'];
                    global $help;
                    if ($help->permission_check($myprofileid, $profileid, $row['VISIBLE'])) {
                        $ctype = 2801;
                        if (!$database->answer_mine_check($optionid, $myprofileid)) {
                            $actionid = $database->get_actionid($profileid, $ctype, $pageid);
                            if ($actionid) {
                                $result = $database->answer_insert($pageid, $actionid, $optionid, $myprofileid);
                                if ($result) {
                                    $data = array();
                                    global $action, $name, $pimage;
                                    global $feed;
                                    global $database;
                                    global $memcached;
                                    global $json;
                                    global $encode;
                                    $k = 0;
                                    $myprofileid = $_SESSION['userid'];
                                    $NROW = $database->action_select($actionid);
                                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                                    //echo json_encode($data);
                                    $data['action'] = $help->feed_privacy_filter($action, $myprofileid, $database);
                                    $data['myprofileid'] = $_SESSION['USERID'];
                                    $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                                        $database);
                                    $data['name'] = $name;
                                    $data['pimage'] = $pimage;
                                    $data['tag'] = $_SESSION['tag_json'];
                                    echo json_encode($data);
                                    $rnotice = $database->setting_notice_select($profileid);
                                    if ($rnotice['answer']) {
                                        $database->notice_insert($actionid, $profileid, $ctype, $pageid);
                                    }
                                    $remail = $database->setting_email_select($profileid);
                                    if ($remail['answer']) {
                                        global $email;
                                        $param = array();
                                        $param['type'] = 'answer';
                                        $param['profileid'] = $profileid;
                                        $param['page'] = $optionid;
                                        $param['actionby'] = $myprofileid;
                                        $param['actionid'] = $actionid;
                                        $email->email_sample($param);
                                    }
                                } else {
                                    $help->error_description(15);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            if ($rw = $database->myanswer_select($optionid, $myprofileid)) {
                                $answerid = $rw['answerid'];
                                $questionid = $rw['questionid'];
                                if ($database->action_delete($answerid)) {
                                    $data = array();
                                    global $action, $name, $pimage;
                                    global $feed;
                                    global $database;
                                    global $memcached;
                                    global $json;
                                    global $encode;
                                    $k = 0;
                                    $myprofileid = $_SESSION['userid'];
                                    $NROW = $database->max_action_select($questionid);
                                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                                    $data['action'] = $help->feed_privacy_filter($action, $myprofileid, $database);
                                    $data['myprofileid'] = $_SESSION['USERID'];
                                    $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                                        $database);
                                    $data['name'] = $name;
                                    $data['pimage'] = $pimage;
                                    $data['tag'] = $_SESSION['tag_json'];
                                    echo json_encode($data);
                                } else {
                                    $help->error_description(15);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        }
                    } else {
                        $error['code'] = 12;
                        $error['message'] = 'You don\'t have sufficient permission to perform this action';
                        $error['type'] = 'PermissionException';
                        $data['error'] = $error;
                        echo json_encode($data);
                    }
                } else {
                    $help->error_description(11);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_post_question()
    {
        global $help;
        if (isset($_GET['question']) && isset($_GET['profileid'])) {
            if (!empty($_GET['question']) && !empty($_GET['profileid'])) {
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                global $database;
                $question = $_GET['question'];
                $option = array();
                if (isset($_GET['option']) && !empty($_GET['option'])) {
                    $option = $_GET['option'];
                }
                if ($profileid = $database->group_exists($profileid)) {
                    $status = $database->membership_status($profileid, $myprofileid);
                    if ($status == 0 || $status == 1) {
                        if (strlen($question) <= 6072) {
                            $visible_id = 5;
                            $actiontype = 328;
                            $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible_id);
                            if ($actionid) {
                                $result = $database->diary_insert($actionid, $question);
                                foreach ($option as $p) {
                                    if (!$result = $database->option_insert($actionid, $p)) {
                                        $help->error_description(15);
                                    }
                                }
                                if ($result) {
                                    $result = $database->member_select($profileid);
                                    global $email;
                                    $param = array();
                                    $param['type'] = 'event_post';
                                    $param['profileid'] = $profileid;
                                    $param['page'] = $page;
                                    $param['actionby'] = $myprofileid;
                                    $param['actionid'] = $actionid;
                                    while ($res = $result->fetch_array()) {
                                        $memberid = $res['profileid'];
                                        if ($memberid != $myprofileid) {
                                            $rnotice = $database->setting_notice_select($memberid);
                                            if ($rnotice['group_post']) {
                                                $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                            }
                                            $remail = $database->setting_email_select($memberid);
                                            if ($remail['group_post']) {
                                                $param['memberid'] = $memberid;
                                                $email->email_sample($param);
                                            }
                                        }
                                    }
                                    $data['ack'] = 1;
                                    $data['actionid'] = $actionid;
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['time'] = time();
                                    $data['question'] = $question;
                                    $rw = $database->option_select($actionid);
                                    $k = 0;
                                    $option = array();
                                    while ($ow = $rw->fetch_array()) {
                                        $option[$k]['opt'] = $ow['option'];
                                        $option[$k]['optid'] = $ow['optionid'];
                                        $k++;
                                    }

                                    $data['option'] = $option;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function option_add()
    {
        global $help;
        if (isset($_GET['pageid']) && isset($_GET['option'])) {
            if (!empty($_GET['pageid']) && !empty($_GET['option'])) {
                $myprofileid = $_SESSION['userid'];
                global $database;
                $pageid = $_GET['pageid'];
                $option = $_GET['option'];
                $result = $database->actionid_select($pageid);
                if ($result->num_rows) {
                    $row = $result->fetch_array();
                    $profileid = $row['PROFILEID'];
                    $ctype = 2801;
                    global $help;
                    if ($help->permission_check($myprofileid, $profileid, $row['VISIBLE'])) {
                        if ($result = $database->option_insert($pageid, $option)) {
                            $actionid = $database->get_actionid($profileid, $ctype, $pageid);
                            $optionid = $database->optionid_select($pageid, $option);
                            $result = $database->answer_insert($pageid, $actionid, $optionid, $myprofileid);
                            if ($result) {
                                $data = array();
                                $data['ack'] = 1;
                                $data['message'] = 'answered';
                                $data['actionid'] = $actionid;
                                $data['optionid'] = $optionid;
                                $data['option'] = $option;
                                echo json_encode($data);
                                $rnotice = $database->setting_notice_select($profileid);
                                if ($rnotice['answer']) {
                                    $database->notice_insert($actionid, $profileid, $ctype, $pageid);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(13);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function post_question()
    {
        global $help;
        if (isset($_GET['question']) && isset($_GET['profileid'])) {
            if (!empty($_GET['question']) && !empty($_GET['profileid'])) {
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                global $database;
                $question = $_GET['question'];
                $option = array();
                if (isset($_GET['option']) && !empty($_GET['option'])) {
                    $option = $_GET['option'];
                }
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($myprofileid == $profileid || $database->check_friendship($myprofileid, $profileid) ==
                        2) {
                        if (strlen($question) <= 6072) {
                            $visible_id = $_SESSION['visible'];
                            $actionid = $database->get_actionid($profileid, 2800, 0, $visible_id);
                            if ($actionid) {
                                $result = $database->diary_insert($actionid, $question);
                                foreach ($option as $p) {
                                    if (!$result = $database->option_insert($actionid, $p)) {
                                        $help->error_description(15);
                                    }
                                }
                                if ($result) {
                                    if ($myprofileid != $profileid) {
                                        $remail = $database->setting_email_select($profileid);
                                        if ($remail['profile_post']) {
                                            global $email;
                                            $param = array();
                                            $param['type'] = 'profile_post';
                                            $param['profileid'] = $profileid;
                                            $param['page'] = $question;
                                            $param['actionby'] = $myprofileid;
                                            $param['actionid'] = $actionid;
                                            $email->email_sample($param);
                                        }
                                    }
                                    $data['ack'] = $result;
                                    $data['actionid'] = $actionid;
                                    $data['question'] = $question;
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['time'] = time();
                                    $rw = $database->option_select($actionid);
                                    $k = 0;
                                    $option = array();
                                    while ($ow = $rw->fetch_array()) {
                                        $option[$k]['opt'] = $ow['option'];
                                        $option[$k]['optid'] = $ow['optionid'];
                                        $k++;
                                    }

                                    $data['option'] = $option;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function share_post()
    {
        global $help;
        if (isset($_GET['text']) && isset($_GET['actionid'])) {
            if (!empty($_GET['text']) && !empty($_GET['actionid'])) {
                $myprofileid = $_SESSION['userid'];
                global $database;
                $page = $_GET['text'];
                $actionid = $_GET['actionid'];
                $result = $database->actionid_select($actionid);
                $check = $result->fetch_array();
                $profileid = $check['ACTIONBY'];
                if ($check['ACTIONID'] == $actionid) {
                    if (strlen($page) <= 6072) {
                        $visible_id = $_SESSION['visible'];
                        $actionid_new = $database->get_actionid($profileid, 10, 0, $visible_id);
                        if ($actionid_new) {
                            $result = $database->diary_insert($actionid_new, $page);
                            $result = $database->map_insert($actionid_new, $actionid);
                            if ($result) {
                                if ($myprofileid != $profileid) {
                                    $remail = $database->setting_email_select($profileid);
                                    if ($remail['profile_post']) //We need to add a column for share_post
                                        {
                                        global $email;
                                        $param = array();
                                        $param['type'] = 'share_post';
                                        $param['profileid'] = $profileid;
                                        $param['page'] = $page;
                                        $param['actionby'] = $myprofileid;
                                        $param['actionid'] = $actionid_new;
                                        $email->email_sample($param);
                                    }
                                }
                                $data['ack'] = $result;
                                $data['actionid'] = $actionid_new;
                                $data['life_is_fun'] = sha1($actionid_new . 'pass1reset!');
                                $data['time'] = time();
                                $data['page'] = $page;
                                echo json_encode($data);
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(11);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function post_status()
    {
        global $help;
        if (isset($_GET['page']) && isset($_GET['profileid'])) {
            if (!empty($_GET['page']) && !empty($_GET['profileid'])) {
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                global $database;
                $page = $_GET['page'];
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($myprofileid == $profileid || $database->check_friendship($myprofileid, $profileid) ==
                        2) {
                        if (strlen($page) <= 6072) {
                            $visible_id = $_SESSION['visible'];
                            $actionid = $database->get_actionid($profileid, 1, 0, $visible_id);
                            if ($actionid) {
                                $result = $database->diary_insert($actionid, $page);
                                if ($result) {
                                    if ($myprofileid != $profileid) {
                                        $remail = $database->setting_email_select($profileid);
                                        if ($remail['profile_post']) {
                                            global $email;
                                            $param = array();
                                            $param['type'] = 'profile_post';
                                            $param['profileid'] = $profileid;
                                            $param['page'] = $page;
                                            $param['actionby'] = $myprofileid;
                                            $param['actionid'] = $actionid;
                                            $email->email_sample($param);
                                        }
                                    }
                                    $data['ack'] = $result;
                                    $data['actionid'] = $actionid;
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['time'] = time();
                                    $data['page'] = $page;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function page_status()
    {
        global $help;
        if (isset($_GET['page']) && isset($_GET['profileid'])) {
            if (!empty($_GET['page']) && !empty($_GET['profileid'])) {
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                global $database, $email;
                $page = $_GET['page'];
                $row = $database->page_exists($profileid);
                $profileid = $row['pageid'];
                if ($profileid) {
                    $status = $database->follower_status($profileid, $myprofileid);
                    if ($status == 0) {
                        if (strlen($page) <= 6072) {
                            $visible_id = 0;
                            $actiontype = 2901;
                            $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible_id);
                            if ($actionid) {
                                $result = $database->diary_insert($actionid, $page);
                                if ($result) {
                                    $database->broadcast_notice_insert($actionid, $actiontype, $profileid);
                                    $data['ack'] = 1;
                                    $data['actionid'] = $actionid;
                                    $data['actiontype'] = $actiontype;
                                    $data['page_name'] = $row['name'];
                                    $data['page_pageid'] = $row['pageid'];
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['time'] = time();
                                    $data['page'] = $page;

                                    $param = array();
                                    $param['type'] = 'page_post';
                                    $param['page_name'] = $row['name'];
                                    $param['page_pageid'] = $row['pageid'];
                                    $param['page'] = $page;
                                    $param['actionid'] = $actionid;
                                    $email->email_sample($param);

                                    echo json_encode($data);
                                    /*	$result = $database->follower_select($profileid);
                                    $param = array();
                                    $param['type'] = 'page_post';
                                    $param['page_name'] =$row['name'];
                                    $param['page_pageid'] =$row['pageid'];
                                    $param['page'] = $page;
                                    $param['actionby'] = $myprofileid;
                                    $param['actionid'] = $actionid;
                                    while($res = $result->fetch_array())
                                    {
                                    $followerid = $res['profileid'] ;
                                    if($followerid != $myprofileid )
                                    {
                                    $param['followerid'] = $followerid; 
                                    $email->email_sample($param);												
                                    }
                                    }
                                    */
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function group_status()
    {
        global $help;
        if (isset($_GET['page']) && isset($_GET['profileid'])) {
            if (!empty($_GET['page']) && !empty($_GET['profileid'])) {
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                global $database;
                $page = $_GET['page'];
                if ($profileid = $database->group_exists($profileid)) {
                    $status = $database->membership_status($profileid, $myprofileid);
                    if ($status == 0 || $status == 1) {
                        if (strlen($page) <= 6072) {
                            $visible_id = 5;
                            $actiontype = 301;
                            $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible_id);
                            if ($actionid) {
                                $result = $database->diary_insert($actionid, $page);
                                if ($result) {
                                    $result = $database->member_select($profileid);
                                    global $email;
                                    $param = array();
                                    $param['type'] = 'group_post';
                                    $param['groupid'] = $profileid;
                                    $param['page'] = $page;
                                    $param['actionby'] = $myprofileid;
                                    $param['actionid'] = $actionid;
                                    while ($res = $result->fetch_array()) {
                                        $memberid = $res['profileid'];
                                        if ($memberid != $myprofileid) {
                                            $rnotice = $database->setting_notice_select($memberid);
                                            if ($rnotice['group_post']) {
                                                $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                            }
                                            $remail = $database->setting_email_select($memberid);
                                            if ($remail['group_post']) {
                                                $param['memberid'] = $memberid;
                                                $email->email_sample($param);
                                            }
                                        }
                                    }
                                    $data['ack'] = 1;
                                    $data['actionid'] = $actionid;
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['time'] = time();
                                    $data['page'] = $page;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function event_status()
    {
        global $help;
        if (isset($_GET['page']) && isset($_GET['profileid'])) {
            if (!empty($_GET['page']) && !empty($_GET['profileid'])) {
                $myprofileid = $_SESSION['userid'];
                $eventid = $_GET['profileid'];
                global $database;
                $page = $_GET['page'];
                if ($eventid = $database->event_exists($eventid)) {
                    if (strlen($page) <= 6072) {
                        $actiontype = 403;
                        $actionid = $database->get_actionid($eventid, $actiontype, 0, 6);
                        if ($actionid) {
                            $result = $database->diary_insert($actionid, $page);
                            if ($result) {
                                $result = $database->guest_select($eventid);
                                global $email;
                                $param = array();
                                $param['type'] = 'event_post';
                                $param['eventid'] = $eventid;
                                $param['page'] = $page;
                                $param['actionby'] = $myprofileid;
                                $param['actionid'] = $actionid;
                                while ($res = $result->fetch_array()) {
                                    $memberid = $res['profileid'];
                                    if ($memberid != $myprofileid) {
                                        $rnotice = $database->setting_notice_select($memberid);
                                        if ($rnotice['event_post']) {
                                            $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                        }
                                        $remail = $database->setting_email_select($memberid);
                                        if ($remail['event_post']) {
                                            $param['memberid'] = $memberid;
                                            $email->email_sample($param);
                                        }
                                    }
                                }
                                $data['ack'] = 1;
                                $data['actionid'] = $actionid;
                                $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                $data['time'] = time();
                                $data['page'] = $page;
                                echo json_encode($data);
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(10);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function event_post_link()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['title']) && isset($_GET['link']) &&
            isset($_GET['meta']) && isset($_GET['page']) && isset($_GET['file'])) {
            if (!empty($_GET['profileid']) && !empty($_GET['link']) && !empty($_GET['page'])) {
                $myprofileid = $_SESSION['userid'];
                global $database;
                $profileid = $_GET['profileid'];
                if ($database->event_exists($profileid) == $profileid) {
                    $status = $database->is_guest($profileid, $myprofileid);
                    if ($status->num_rows) {
                        $page = $_GET['page'];
                        if (strlen($page) <= 6072) {
                            $profileid = $_GET['profileid'];
                            $actiontype = 416;
                            $title = $_GET['title'];
                            $link = $_GET['link'];
                            $meta = $_GET['meta'];
                            $page = $_GET['page'];
                            $file = $_GET['file'];
                            $actionid = $database->get_actionid($profileid, $actiontype, 0, 6);
                            if ($actionid) {
                                $result = $database->link_insert($actionid, $title, $link, $meta, $page, $file);
                                if ($result) {
                                    $data['ack'] = $result;
                                    $data['actionid'] = $actionid;
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['time'] = time();
                                    $data['page'] = $page;
                                    echo json_encode($data);
                                    $result = $database->guest_select($profileid);
                                    global $email;
                                    $param = array();
                                    $param['type'] = 'event_post';
                                    $param['eventid'] = $profileid;
                                    $param['page'] = $page;
                                    $param['actionby'] = $myprofileid;
                                    $param['actionid'] = $actionid;
                                    while ($res = $result->fetch_array()) {
                                        $memberid = $res['profileid'];
                                        if ($memberid != $myprofileid) {
                                            $rnotice = $database->setting_notice_select($memberid);
                                            if ($rnotice['event_post']) {
                                                $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                            }
                                            $remail = $database->setting_notice_select($memberid);
                                            if ($remail['event_post']) {
                                                $param['memberid'] = $memberid;
                                                $email->email_sample($param);
                                            }
                                        }
                                    }
                                } else {
                                    $help->error_description(15);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function group_post_link()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['title']) && isset($_GET['link']) &&
            isset($_GET['meta']) && isset($_GET['page']) && isset($_GET['file'])) {
            if (!empty($_GET['profileid']) && !empty($_GET['link']) && !empty($_GET['page'])) {
                $myprofileid = $_SESSION['userid'];
                global $database;
                $profileid = $_GET['profileid'];
                if ($database->group_exists($profileid) == $profileid) {
                    $status = $database->membership_status($profileid, $myprofileid);
                    if ($status == 0 || $status == 1) {
                        $page = $_GET['page'];
                        if (strlen($page) <= 6072) {
                            $profileid = $_GET['profileid'];
                            $actiontype = 316;
                            $title = $_GET['title'];
                            $link = $_GET['link'];
                            $meta = $_GET['meta'];
                            $page = $_GET['page'];
                            $file = $_GET['file'];
                            $actionid = $database->get_actionid($profileid, $actiontype, 0, 5);
                            if ($actionid) {
                                $result = $database->link_insert($actionid, $title, $link, $meta, $page, $file);
                                if ($result) {
                                    $data['ack'] = $result;
                                    $data['actionid'] = $actionid;
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['time'] = time();
                                    $data['page'] = $page;
                                    echo json_encode($data);
                                    $result = $database->member_select($profileid);
                                    global $email;
                                    $param = array();
                                    $param['type'] = 'group_post';
                                    $param['groupid'] = $profileid;
                                    $param['page'] = $page;
                                    $param['actionby'] = $myprofileid;
                                    $param['actionid'] = $actionid;
                                    while ($res = $result->fetch_array()) {
                                        $memberid = $res['profileid'];
                                        if ($memberid != $myprofileid) {
                                            $rnotice = $database->setting_notice_select($memberid);
                                            if ($rnotice['group_post']) {
                                                $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                            }
                                            $remail = $database->setting_email_select($memberid);
                                            if ($remail['group_post']) {
                                                $param['memberid'] = $memberid;
                                                $email->email_sample($param);
                                            }
                                        }
                                    }

                                } else {
                                    $help->error_description(15);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function page_post_link()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['title']) && isset($_GET['link']) &&
            isset($_GET['meta']) && isset($_GET['page']) && isset($_GET['file'])) {
            if (!empty($_GET['profileid']) && !empty($_GET['link']) && !empty($_GET['page'])) {
                $myprofileid = $_SESSION['userid'];
                global $database;
                $profileid = $_GET['profileid'];
                $row = $database->page_exists($profileid);
                if ($row['pageid'] == $profileid) {
                    $status = $database->follower_status($profileid, $myprofileid);
                    if ($status == 0 || $status == 1) {
                        $page = $_GET['page'];
                        if (strlen($page) <= 6072) {
                            $profileid = $_GET['profileid'];
                            $actiontype = 2916;
                            $title = $_GET['title'];
                            $link = $_GET['link'];
                            $meta = $_GET['meta'];
                            $page = $_GET['page'];
                            $file = $_GET['file'];
                            $visible = 0;
                            $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible);
                            if ($actionid) {
                                $result = $database->link_insert($actionid, $title, $link, $meta, $page, $file);
                                if ($result) {
                                    $data['ack'] = $result;
                                    $data['actionid'] = $actionid;
                                    $data['actiontype'] = $actiontype;
                                    $data['page_name'] = $row['name'];
                                    $data['page_pageid'] = $row['pageid'];
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['time'] = time();
                                    $data['page'] = $page;
                                    echo json_encode($data);
                                    $result = $database->follower_select($profileid);
                                    global $email;
                                    $param = array();
                                    $param['type'] = 'page_post';
                                    $param['profileid'] = $profileid;
                                    $param['page'] = $page;
                                    $param['actionby'] = $myprofileid;
                                    $param['actionid'] = $actionid;
                                    while ($res = $result->fetch_array()) {
                                        $memberid = $res['profileid'];
                                        if ($memberid != $myprofileid) {
                                            $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                            $rnotice = $database->setting_notice_select($memberid);
                                            if ($rnotice['page_post']) {
                                                $database->notice_insert($actionid, $memberid, $actiontype, $actionid);
                                            }
                                            /*	$remail = $database->setting_email_select($memberid);
                                            if($remail['group_post'])
                                            {
                                            $param['memberid'] = $memberid; 
                                            $email->email_sample($param);	
                                            }	*/
                                        }
                                    }

                                } else {
                                    $help->error_description(15);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function post_link()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['title']) && isset($_GET['link']) &&
            isset($_GET['meta']) && isset($_GET['page']) && isset($_GET['file'])) {
            if (!empty($_GET['profileid']) && !empty($_GET['link']) && !empty($_GET['page'])) {
                $myprofileid = $_SESSION['userid'];
                global $database;
                $profileid = $_GET['profileid'];
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($myprofileid == $profileid || $database->check_friendship($myprofileid, $profileid) ==
                        2) {
                        if (strlen($page) <= 6072) {
                            $profileid = $_GET['profileid'];
                            $actiontype = 1600;
                            $title = $_GET['title'];
                            $link = $_GET['link'];
                            $meta = $_GET['meta'];
                            $page = $_GET['page'];
                            $file = $_GET['file'];
                            $visible_id = $_SESSION['visible'];
                            $actionid = $database->get_actionid($profileid, $actiontype, 0, $visible_id);
                            if ($actionid) {
                                $result = $database->link_insert($actionid, $title, $link, $meta, $page, $file);
                                if ($result) {
                                    $data['ack'] = $result;
                                    $data['actionid'] = $actionid;
                                    $data['life_is_fun'] = sha1($actionid . 'pass1reset!');
                                    $data['time'] = time();
                                    $data['page'] = $page;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(10);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function photo_friend_fetch()
    {
        global $help;
        if (isset($_GET['start'])) {
            if ($_GET['start'] != '') {
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                $data = array();
                $photo = array();
                if (is_numeric($start)) {
                    global $database;
                    if ($r = $database->photo_friend_select($myprofileid, $start, 20)) {
                        $k = 0;
                        while ($row = $r->fetch_array()) {
                            $photo[$k]['file'] = $row['CDN'] . $row['FILENAME'];
                            $photo[$k]['profileid'] = $row['PROFILEID'];
                            $photo[$k]['actionby'] = $row['ACTIONBY'];
                            $photo[$k]['actionid'] = $row['IMAGEID'];
                            $photo[$k]['life_is_fun'] = sha1($row['IMAGEID'] . 'pass1reset!');
                            global $memcached;
                            $name[$photo[$k]['actionby']] = $help->name_fetch($photo[$k]['actionby'], $memcached,
                                $database);

                            if ($photo[$k]['actionby'] != $photo[$k]['profileid']) {
                                $name[$photo[$k]['actionby']] = $help->name_fetch($photo[$k]['actionby'], $memcached,
                                    $database);
                            }
                            $k++;
                        }
                        $data['name'] = $name;
                        $data['action'] = $photo;
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(22);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function photo_fetch()
    {
        global $help;
        if (isset($_GET['start'])) {
            if ($_GET['start'] != '') {
                $profileid = $_GET['profileid'];
                $start = $_GET['start'];
                $data = array();
                $photo = array();
                if (is_numeric($start)) {
                    global $database;
                    if ($r = $database->photo_json($profileid, $start, 20)) {
                        $k = 0;
                        while ($row = $r->fetch_array()) {
                            $photo[$k]['file'] = $row['CDN'] . $row['FILENAME'];
                            $photo[$k]['profileid'] = $row['PROFILEID'];
                            $photo[$k]['actionby'] = $row['ACTIONBY'];
                            $photo[$k]['actionid'] = $row['IMAGEID'];
                            $photo[$k]['life_is_fun'] = sha1($row['IMAGEID'] . 'pass1reset!');
                            global $memcached;
                            $name[$photo[$k]['actionby']] = $help->name_fetch($photo[$k]['actionby'], $memcached,
                                $database);

                            if ($photo[$k]['actionby'] != $photo[$k]['profileid']) {
                                $name[$photo[$k]['actionby']] = $help->name_fetch($photo[$k]['actionby'], $memcached,
                                    $database);
                            }
                            $k++;
                        }
                        $data['name'] = $name;
                        $data['action'] = $photo;
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(20);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function video_fetch()
    {
        global $help;
        if (isset($_GET['start'])) {
            if ($_GET['start'] != '') {
                $profileid = $_GET['profileid'];
                $start = $_GET['start'];
                $data = array();
                $video = array();
                if (is_numeric($start)) {
                    global $database;
                    if ($r = $database->video_json($profileid, $start, 20)) {
                        $k = 0;
                        while ($row = $r->fetch_array()) {
                            $video[$k]['file'] = $row['cdn'] . $row['filename'];
                            $video[$k]['profileid'] = $row['profileid'];
                            $video[$k]['actionby'] = $row['actionby'];
                            $video[$k]['actionid'] = $row['videoid'];
                            $video[$k]['caption'] = $row['PAGE'];
                            $video[$k]['thumbnail'] = $row['cdn'] . $row['thumbnail'];
                            $video[$k]['life_is_fun'] = sha1($row['videoid'] . 'pass1reset!');
                            global $memcached;
                            $name[$video[$k]['actionby']] = $help->name_fetch($video[$k]['actionby'], $memcached,
                                $database);


                            $name[$video[$k]['actionby']] = $help->name_fetch($video[$k]['actionby'], $memcached,
                                $database);
                            $pimage[$video[$k]['actionby']] = $help->pimage_fetch($video[$k]['actionby'], $memcached,
                                $database);

                            $k++;
                        }
                        $data['name'] = $name;
                        $data['pimage'] = $pimage;
                        $data['action'] = $video;
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(20);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function file_fetch()
    {
        global $help;
        if (isset($_GET['start'])) {
            if ($_GET['start'] != '') {
                $profileid = $_GET['profileid'];
                $start = $_GET['start'];
                $data = array();
                $file = array();
                if (is_numeric($start)) {
                    global $database;
                    if ($r = $database->file_json($profileid, $start, 20)) {
                        $k = 0;
                        while ($row = $r->fetch_array()) {
                            $file[$k]['file'] = $row['cdn'] . $row['filename'];
                            $file[$k]['profileid'] = $row['profileid'];
                            $file[$k]['actionby'] = $row['actionby'];
                            $file[$k]['actionid'] = $row['docid'];
                            $file[$k]['caption'] = $row['caption'];
                            $file[$k]['life_is_fun'] = sha1($row['docid'] . 'pass1reset!');
                            global $memcached;
                            $name[$file[$k]['actionby']] = $help->name_fetch($file[$k]['actionby'], $memcached,
                                $database);


                            $name[$file[$k]['actionby']] = $help->name_fetch($file[$k]['actionby'], $memcached,
                                $database);
                            $pimage[$file[$k]['actionby']] = $help->pimage_fetch($file[$k]['actionby'], $memcached,
                                $database);

                            $k++;
                        }
                        $data['name'] = $name;
                        $data['pimage'] = $pimage;
                        $data['action'] = $file;
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(20);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function message_delete()
    {
        global $help;
        if (isset($_GET['del_actionid'])) {
            if (!empty($_GET['del_actionid'])) {
                $myprofileid = $_SESSION['userid'];
                $actionid = $_GET['del_actionid'];
                global $database;
                if ($database->action_ownership_check_inbox($actionid, $myprofileid)) {
                    $result = $database->message_delete($actionid, $myprofileid);
                    if ($result) {
                        $data['ack'] = 1;
                        $data['actionid'] = $actionid;
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(12);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function post_delete()
    {
        global $help;
        if (isset($_GET['del_actionid'])) {
            if (!empty($_GET['del_actionid'])) {
                $myprofileid = $_SESSION['userid'];
                $actionid = $_GET['del_actionid'];
                global $database;
                $result = $database->actionid_select($actionid);
                if ($result->num_rows) {
                    if (($database->action_ownership_check($actionid, $myprofileid)) || ($database->
                        moderator_check($myprofileid))) {
                        $rs = $result->fetch_array();
                        $pageid = $rs['PAGEID'];
                        $result = $database->action_delete($actionid);
                        if ($result) {
                            $data['ack'] = 1;
                            $data['actionid'] = $actionid;
                            $data['pageid'] = $pageid;
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(12);
                    }
                } else {
                    $help->error_description(11);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function page_feed()
    {
        global $help;
        if (isset($_GET['start']) && isset($_GET['pageid'])) {
            if ($_GET['start'] != '' && !empty($_GET['pageid'])) {
                global $feed;
                global $database;
                global $memcached;
                global $json;
                global $encode;
                global $action, $name, $pimage;
                $start = $_GET['start'];
                $pageid = $_GET['pageid'];
                $res = $database->page_feed_select($pageid, $start);
                $k = 0;
                while ($NROW = $res->fetch_array()) {
                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $k++;
                }
                $data['action'] = $action;
                $data['myprofileid'] = $_SESSION['USERID'];
                $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                    $database);
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_desscription(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function group_feed()
    {
        global $help;
        if (isset($_GET['start']) && isset($_GET['groupid'])) {
            if ($_GET['start'] != '' && !empty($_GET['groupid'])) {
                global $feed;
                global $database;
                global $memcached;
                global $json;
                global $encode;
                global $action, $name, $pimage;
                $start = $_GET['start'];
                $groupid = $_GET['groupid'];
                $res = $database->group_feed_select($groupid, $start);
                $k = 0;
                while ($NROW = $res->fetch_array()) {
                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $k++;
                }
                $data['action'] = $action;
                $data['myprofileid'] = $_SESSION['USERID'];
                $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                    $database);
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_desscription(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function event_feed()
    {
        global $help;
        if (isset($_GET['start']) && isset($_GET['eventid'])) {
            if ($_GET['start'] != '' && !empty($_GET['eventid'])) {
                global $feed;
                global $database;
                global $memcached;
                global $json;
                global $encode;
                global $action, $name, $pimage;
                $start = $_GET['start'];
                $eventid = $_GET['eventid'];
                $res = $database->event_feed_select($eventid, $start);
                $k = 0;
                while ($NROW = $res->fetch_array()) {
                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $k++;
                }
                $data['action'] = $action;
                $data['myprofileid'] = $_SESSION['USERID'];
                $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                    $database);
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_desscription(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function profile_feed()
    {
        global $help;
        if (isset($_GET['start']) && isset($_GET['profileid'])) {
            if ($_GET['start'] != '' && !empty($_GET['profileid'])) {
                global $feed;
                global $database;
                global $memcached;
                global $json;
                global $encode;
                global $action, $name, $pimage;
                $start = $_GET['start'];
                $profileid = $_GET['profileid'];
                $myprofileid = $_SESSION['userid'];
                $res = $database->get_profile_post($profileid, $start);
                $k = 0;
                while ($NROW = $res->fetch_array()) {
                    $feed->actiontype_encode($NROW, $k, $json, $help, $encode, $database, $memcached);
                    $k++;
                }
                $data['action'] = $help->feed_privacy_filter($action, $myprofileid, $database);
                $data['myprofileid'] = $myprofileid;
                $pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcached,
                    $database);
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                $data['tag'] = $_SESSION['tag_json'];
                echo json_encode($data);
            } else {
                $help->error_desscription(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function feature_setting_update()
    {
        global $help;
        global $database;
        $memcached = new Memcached();
        if (isset($_GET['field'])) {
            if (!empty($_GET['field'])) {
                $field = $_GET['field'];
                $myprofileid = $_SESSION['userid'];
                if ($check = $database->moderator_check($myprofileid)) {
                    if ($rse = $database->setting_feature_field_select($field, $myprofileid)) {
                        $flag = 1 - $rse['flag'];
                        if ($database->setting_feature_update($field, $flag)) {
                            $help->feature_fetch($field, $memcached, $database, 1);
                            $data['ack'] = 1;
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(0);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function notification_setting_update()
    {
        global $help;
        global $database;
        if (isset($_GET['field'])) {
            if (!empty($_GET['field'])) {
                $field = $_GET['field'];
                $myprofileid = $_SESSION['userid'];
                if ($rse = $database->setting_notice_field_select($field, $myprofileid)) {
                    $privacy = 1 - $rse[$field];
                    if ($database->setting_notice_update($field, $privacy, $myprofileid)) {
                        $data['ack'] = 1;
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function email_setting_update()
    {
        global $help;
        global $database;
        if (isset($_GET['field'])) {
            if (!empty($_GET['field'])) {
                $field = $_GET['field'];
                $myprofileid = $_SESSION['userid'];
                if ($rse = $database->setting_email_field_select($field, $myprofileid)) {
                    $privacy = 1 - $rse[$field];
                    if ($database->setting_email_update($field, $privacy, $myprofileid)) {
                        $data['ack'] = 1;
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function profile_privacy_update()
    {
        global $help;
        global $database;
        if (isset($_GET['field']) && isset($_GET['privacy'])) {
            if (!empty($_GET['field']) && $_GET['privacy'] != '') {
                $field = $_GET['field'];
                $privacy = $_GET['privacy'];
                $myprofileid = $_SESSION['userid'];
                if ($database->profile_privacy_update($field, $privacy, $myprofileid)) {
                    $data['ack'] = 1;
                    $data['privacy'] = $privacy;
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function bio_item_remove()
    {
        global $help;
        if (isset($_GET['diaryid'])) {
            if (!empty($_GET['diaryid'])) {
                $diaryid = $_GET['diaryid'];
                $myprofileid = $_SESSION['userid'];
                global $database;
                if ($database->action_delete($diaryid)) {
                    $data['ack'] = 1;
                    $data['message'] = 'Removed';
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(9);
            }
        } else {
            $help->error_description(18);
        }
    }

    function contact()
    {
        global $help;
        if (isset($_GET['email'])) {
            if (!empty($_GET['email'])) {
                global $database;
                $name = $_GET['name'];
                $message = $_GET['message'];
                $email = $_GET['email'];
                $contact = $_GET['contact'];
                if ($actionid = $database->contact_insert($name, $email, $contact, $message)) {
                    $data['ack'] = 1;
                    $data['message'] = 'Message Dropped';
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function feedback()
    {
        global $help;
        if (isset($_GET['name']) && isset($_GET['description'])) {
            if (!empty($_GET['name']) != '' && !empty($_GET['description'])) {
                global $database;
                $name = $_GET['name'];
                $description = $_GET['description'];
                $email = $_SESSION['EMAIL'];
                $company = $_SESSION['database'];
                if ($actionid = $database->feedback_insert($email, $name, $description, $company)) {
                    $data['ack'] = 1;
                    $data['message'] = 'Feedback sent';
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function bio_item_add()
    {
        global $help;
        if (isset($_GET['item']) && isset($_GET['name'])) {
            if ($_GET['item'] != '' && !empty($_GET['name'])) {
                $item = $_GET['item'];
                global $database;
                $value = $_GET['name'];
                if (!isset($_GET['diaryid']) || empty($_GET['diaryid'])) {
                    if ($diaryid = $database->diaryid_select($item, $value)) {
                        ;
                    } else {
                        $diaryid = $database->mydiary_create_wo_admin($item, $value);
                    }
                } else {
                    $diaryid = $_GET['diaryid'];
                }
                $myprofileid = $_SESSION['userid'];
                if ($actionid = $database->get_actionid($myprofileid, $item)) {
                    if ($database->bio_item_add($actionid, $myprofileid, $item, $diaryid)) {
                        if ($item == 234) //check if this is a team
                            {
                            $result = $database->team_member_add($actionid, $myprofileid, $value);
                        }
                        $data['ack'] = 1;
                        $data['message'] = 'Added';
                        echo json_encode($data);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function recently_talked_people()
    {
        global $help;
        if (isset($_GET['start'])) {
            if ($_GET['start'] != '') {
                $myprofileid = $_SESSION['userid'];
                $start = $_GET['start'];
                $inbox = array();
                $friend = array();
                global $database;
                global $json;
                global $help;
                global $memcached;
                $res = $database->message_order_inbox($myprofileid);
                $k = 0;
                while ($NROW = $res->fetch_array()) {
                    if ($NROW['ACTIONBY'] == $myprofileid) {
                        $friend[$k] = $NROW['ACTIONON'];
                        $inbox[$k]['friend'] = $NROW['ACTIONON'];
                    } else
                        if ($NROW['ACTIONON'] == $myprofileid) {
                            $friend[$k] = $NROW['ACTIONON'];
                            $inbox[$k]['friend'] = $NROW['ACTIONBY'];
                        }
                    $inbox[$k]['message'] = $NROW['MESSAGE'];
                    $name[$inbox[$k]['friend']] = $help->name_fetch($inbox[$k]['friend'], $memcached,
                        $database);
                    $pimage[$inbox[$k]['friend']] = $help->pimage_fetch($inbox[$k]['friend'], $memcached,
                        $database);
                    $k++;
                }
                $data['ack'] = 1;
                $data['inbox'] = $inbox;
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function validate_user_mobile()
    {
        global $help;
        if (isset($_POST['email']) && isset($_POST['identifier']) && isset($_POST['name']) &&
            isset($_POST['password']) && isset($_POST['gender']) && isset($_POST['day']) &&
            isset($_POST['month']) && isset($_POST['year'])) {
            if (!empty($_POST['email']) && !empty($_POST['identifier']) && !empty($_POST['name']) &&
                !empty($_POST['password']) && $_POST['gender'] != '' && !empty($_POST['day']) &&
                !empty($_POST['month']) && !empty($_POST['year'])) {
                $email = $_POST['email'];
                $identifier = $_POST['identifier'];
                $name = trim($_POST['name']);
                $password = trim($_POST['password']);
                $gender = trim($_POST['gender']);
                $day = trim($_POST['day']);
                $month = trim($_POST['month']);
                $year = trim($_POST['year']);
                if ($name != '' && $password != '' && $gender != -1 && $day != -1 && $month != -
                    1 && $year != -1) {
                    if (preg_match("/^[[:space:]]*[a-zA-Z]+[[:space:]]*[a-zA-Z]*[[:space:]]*[a-zA-Z]*$/",
                        $name)) {
                        if (strlen($password) > 5) {
                            if ($gender == 0 || $gender == 1) {
                                if ($day == 31) {
                                    switch ($month) {
                                        case 2:
                                            $data['ack'] = 4;
                                            echo json_encode($data);
                                            exit;
                                        case 1:
                                        case 3:
                                        case 5:
                                        case 7:
                                        case 8:
                                        case 10:
                                        case 12:
                                            $help->register_user_mobile($email, $identifier, $name, $password, $gender, $day,
                                                $month, $year);
                                            exit;
                                        default:
                                            $help->error_description(28);
                                    }
                                } else
                                    if ($day == 30) {
                                        switch ($month) {
                                            case 2:
                                                $help->error_description(28);
                                            default:
                                                $help->register_user_mobile($email, $identifier, $name, $password, $gender, $day,
                                                    $month, $year);
                                                exit;
                                        }

                                    } else
                                        if ($day == 29) {
                                            switch ($month) {
                                                case 2:
                                                    if ($year % 400 == 0) {
                                                        $help->register_user_mobile($email, $identifier, $name, $password, $gender, $day,
                                                            $month, $year);
                                                        exit;
                                                    } else
                                                        if ($year % 100 == 0) {
                                                            $help->error_description(28);
                                                        } else
                                                            if ($year % 4 == 0) {
                                                                $help->register_user_moblile($email, $identifier, $name, $password, $gender, $day,
                                                                    $month, $year);
                                                                exit;
                                                            } else {
                                                                $help->register_user_mobile($email, $identifier, $name, $password, $gender, $day,
                                                                    $month, $year);
                                                                exit;
                                                            }
                                                        default:
                                                            $help->register_user_mobile($email, $identifier, $name, $password, $gender, $day,
                                                                $month, $year);
                                                    exit;
                                            }
                                        } else {
                                            $help->register_user_mobile($email, $identifier, $name, $password, $gender, $day,
                                                $month, $year);
                                        }
                            } else {
                                $help->error_description(18);
                            }
                        } else {
                            $help->error_description(26);
                        }
                    } else {
                        $help->error_description(35);
                    }
                } else {
                    $help->error_description(18);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }

    }

    function validate_user()
    {
        global $help;
        if (isset($_POST['email']) && isset($_POST['identifier']) && isset($_POST['name']) &&
            isset($_POST['password']) && isset($_POST['gender']) && isset($_POST['day']) &&
            isset($_POST['month']) && isset($_POST['year'])) {
            if (!empty($_POST['email']) && !empty($_POST['identifier']) && !empty($_POST['name']) &&
                !empty($_POST['password']) && $_POST['gender'] != '' && !empty($_POST['day']) &&
                !empty($_POST['month']) && !empty($_POST['year'])) {
                $email = $_POST['email'];
                $identifier = $_POST['identifier'];
                $name = trim($_POST['name']);
                $password = trim($_POST['password']);
                $gender = trim($_POST['gender']);
                $day = trim($_POST['day']);
                $month = trim($_POST['month']);
                $year = trim($_POST['year']);
                if ($name != '' && $password != '' && $gender != -1 && $day != -1 && $month != -
                    1 && $year != -1) {
                    if (preg_match("/^[[:space:]]*[a-zA-Z]+[[:space:]]*[a-zA-Z]*[[:space:]]*[a-zA-Z]*$/",
                        $name)) {
                        if (strlen($password) > 5) {
                            if ($gender == 0 || $gender == 1) {
                                if ($day == 31) {
                                    switch ($month) {
                                        case 2:
                                            $data['ack'] = 4;
                                            echo json_encode($data);
                                            exit;
                                        case 1:
                                        case 3:
                                        case 5:
                                        case 7:
                                        case 8:
                                        case 10:
                                        case 12:
                                            $help->register_user($email, $identifier, $name, $password, $gender, $day, $month,
                                                $year);
                                            exit;
                                        default:
                                            $help->error_description(28);
                                    }
                                } else
                                    if ($day == 30) {
                                        switch ($month) {
                                            case 2:
                                                $help->error_description(28);
                                            default:
                                                $help->register_user($email, $identifier, $name, $password, $gender, $day, $month,
                                                    $year);
                                                exit;
                                        }

                                    } else
                                        if ($day == 29) {
                                            switch ($month) {
                                                case 2:
                                                    if ($year % 400 == 0) {
                                                        $help->register_user($email, $identifier, $name, $password, $gender, $day, $month,
                                                            $year);
                                                        exit;
                                                    } else
                                                        if ($year % 100 == 0) {
                                                            $help->error_description(28);
                                                        } else
                                                            if ($year % 4 == 0) {
                                                                $help->register_user($email, $identifier, $name, $password, $gender, $day, $month,
                                                                    $year);
                                                                exit;
                                                            } else {
                                                                $help->register_user($email, $identifier, $name, $password, $gender, $day, $month,
                                                                    $year);
                                                                exit;
                                                            }
                                                        default:
                                                            $help->register_user($email, $identifier, $name, $password, $gender, $day, $month,
                                                                $year);
                                                    exit;
                                            }
                                        } else {
                                            $help->register_user($email, $identifier, $name, $password, $gender, $day, $month,
                                                $year);
                                        }
                            } else {
                                $help->error_description(18);
                            }
                        } else {
                            $help->error_description(26);
                        }
                    } else {
                        $help->error_description(35);
                    }
                } else {
                    $help->error_description(18);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }

    }

    function response()
    {
        global $help;
        if (isset($_GET['pageid'])) {
            if (!empty($_GET['pageid'])) {
                $myprofileid = $_SESSION['userid'];
                $pageid = $_GET['pageid'];
                global $database;
                $result = $database->actionid_select($pageid);
                if ($result->num_rows) {
                    $row = $result->fetch_array();
                    $rtype = $help->response_type_fetch($row['ACTIONTYPE']);
                    $r = $database->response_mine_check($pageid, $rtype);
                    if ($myprofileid != $r['ACTIONBY']) {
                        $profileid = $row['PROFILEID'];
                        if ($rtype == 63) {
                            $profileid = $row['ACTIONBY'];
                        }
                        global $help;
                        if ($help->permission_check($myprofileid, $profileid, $row['VISIBLE'])) {
                            $actionid = $database->get_actionid($profileid, $rtype, $pageid);
                            if ($actionid) {
                                if ($profileid != $myprofileid) {
                                    $rnotice = $database->setting_notice_select($profileid);
                                    if ($rnotice['post_response']) {
                                        $database->notice_insert($actionid, $profileid, $rtype, $pageid);
                                    }
                                    $remail = $database->setting_email_select($profileid);
                                    if ($remail['post_response']) {
                                        if ($rtype == 11 || $rtype == 12 || $rtype == 13 || $rtype == 14 || $rtype == 15 ||
                                            $rtype == 16 || $rtype == 17 || $rtype == 18 || $rtype == 511 || $rtype == 512 ||
                                            $rtype == 811 || $rtype == 812 || $rtype == 1111 || $rtype == 1112 || $rtype ==
                                            1211 || $rtype == 1212 || $rtype == 1411 || $rtype == 1412 || $rtype == 1611 ||
                                            $rtype == 1612 || $rtype == 2011 || $rtype == 2012 || $rtype == 2111 || $rtype ==
                                            2112) {
                                            global $email;
                                            $param = array();
                                            $param['type'] = 'event_cancel';
                                            $param['profileid'] = $profileid;
                                            $param['rtype'] = $rtype;
                                            $param['actionby'] = $myprofileid;
                                            $param['actionid'] = $actionid;
                                            $email->email_sample($param);
                                        }
                                    }
                                }
                                $data['ack'] = 1;
                                $data['actiontype'] = $rtype;
                                echo json_encode($data);
                            } else {
                                $help->error_description(15);
                            }

                        } else {
                            $help->error_description(12);
                        }
                    } else {
                        $help->error_description(13);
                    }

                } else {
                    $help->error_description(11);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function response_delete()
    {
        global $help;
        if (isset($_GET['pageid'])) {
            if (!empty($_GET['pageid'])) {
                global $database;
                $pageid = $_GET['pageid'];
                $myprofileid = $_SESSION['userid'];
                $result = $database->actionid_select($pageid);
                if ($result->num_rows) {
                    $row = $result->fetch_array();
                    $rtype = $help->response_type_fetch($row['ACTIONTYPE']);
                    $check = $database->response_mine_check($pageid, $rtype);
                    if ($check['ACTIONBY'] == $myprofileid) {
                        $result = $database->response_delete($pageid, $rtype, $myprofileid);
                        $data['ack'] = 1;
                        $data['actiontype'] = $rtype;
                        echo json_encode($data);
                    } else {
                        $help->error_description(14);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function search()
    {
        global $help, $icon_cdn;
        if (isset($_GET['q'])) {
            if (!empty($_GET['q'])) {
                $q = $_GET['q'];
                $data['key'] = $q;
                global $database;
                global $memcached;
                if (isset($_GET['filter']) && !empty($_GET['filter'])) {
                    $filter = $_GET['filter'];
                } else {
                    $filter = 'people';
                }
                if (isset($_GET['start']) && $_GET['start'] != '') {
                    $start = $_GET['start'];
                } else {
                    $start = 0;
                }
                if ($filter == 'people') {
                    if ($help->is_email($q)) {
                        $fres = $database->profile_email_search($q);
                    } else {
                        $fres = $database->profile_search($q, $start);
                    }
                    $k = 0;
                    while ($frow = $fres->fetch_array()) {
                        $search[$k]['profileid'] = $frow['PROFILEID'];
                        $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                            $database);
                        $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                            $memcached, $database);
                        $k++;
                    }
                    $data['count'] = $k;
                    $data['filter'] = $filter;
                    $data['action'] = $search;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                } else
                    if ($filter == 'group') {
                        $fres = $database->group_search($q, $start);
                        $k = 0;
                        while ($frow = $fres->fetch_array()) {
                            $search[$k]['profileid'] = $frow['groupid'];
                            $name[$search[$k]['profileid']] = $frow['name'];
                            $pimage[$search[$k]['profileid']] = $icon_cdn . '/group.png';
                            $description[$search[$k]['profileid']] = $frow['description'];
                            $k++;
                        }
                        $data['count'] = $k;
                        $data['filter'] = $filter;
                        $data['action'] = $search;
                        $data['name'] = $name;
                        $data['description'] = $description;
                        $data['pimage'] = $pimage;
                        echo json_encode($data);
                    } else
                        if ($filter == 'event') {
                            $fres = $database->event_search($q, $start);
                            $k = 0;
                            while ($frow = $fres->fetch_array()) {
                                $search[$k]['profileid'] = $frow['eventid'];
                                $name[$search[$k]['profileid']] = $frow['name'];
                                $pimage[$search[$k]['profileid']] = $icon_cdn . '/event.png';
                                $description[$search[$k]['profileid']] = $frow['description'];
                                $k++;
                            }
                            $data['count'] = $k;
                            $data['filter'] = $filter;
                            $data['action'] = $search;
                            $data['name'] = $name;
                            $data['description'] = $description;
                            $data['pimage'] = $pimage;
                            echo json_encode($data);
                        } else
                            if ($filter == 'post') {
                                $fres = $database->post_search($q, $start);
                                $k = 0;
                                while ($frow = $fres->fetch_array()) {
                                    $search[$k]['profileid'] = $frow['ACTIONBY'];
                                    $search[$k]['page'] = $frow['PAGE'];
                                    $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                        $database);
                                    $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                        $memcached, $database);
                                    $k++;
                                }
                                $data['count'] = $k;
                                $data['filter'] = $filter;
                                $data['action'] = $search;
                                $data['post'] = $post;
                                $data['name'] = $name;
                                $data['pimage'] = $pimage;
                                echo json_encode($data);
                            } else
                                if ($filter == 'comment') {
                                    $fres = $database->comment_search($q, $start);
                                    $k = 0;
                                    while ($frow = $fres->fetch_array()) {
                                        $search[$k]['profileid'] = $frow['ACTIONBY'];
                                        $search[$k]['page'] = $frow['COMMENT'];
                                        $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                            $database);
                                        $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                            $memcached, $database);
                                        $k++;
                                    }
                                    $data['count'] = $k;
                                    $data['filter'] = $filter;
                                    $data['action'] = $search;
                                    $data['post'] = $post;
                                    $data['name'] = $name;
                                    $data['pimage'] = $pimage;
                                    echo json_encode($data);
                                } else
                                    if ($filter == 'skill') {
                                        $fres = $database->bio_history_search(230, $q, $start);
                                        $k = 0;
                                        while ($frow = $fres->fetch_array()) {
                                            $search[$k]['profileid'] = $frow['profileid'];
                                            $search[$k]['page'] = $frow['skill'];
                                            $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                $database);
                                            $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                $memcached, $database);
                                            $k++;
                                        }
                                        $data['count'] = $k;
                                        $data['filter'] = $filter;
                                        $data['action'] = $search;
                                        $data['post'] = $post;
                                        $data['name'] = $name;
                                        $data['pimage'] = $pimage;
                                        echo json_encode($data);
                                    } else
                                        if ($filter == 'project') {
                                            $fres = $database->bio_history_search(231, $q, $start);
                                            $k = 0;
                                            while ($frow = $fres->fetch_array()) {
                                                $search[$k]['profileid'] = $frow['profileid'];
                                                $search[$k]['page'] = $frow['skill'];
                                                $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                    $database);
                                                $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                    $memcached, $database);
                                                $k++;
                                            }
                                            $data['count'] = $k;
                                            $data['filter'] = $filter;
                                            $data['action'] = $search;
                                            $data['post'] = $post;
                                            $data['name'] = $name;
                                            $data['pimage'] = $pimage;
                                            echo json_encode($data);
                                        } else
                                            if ($filter == 'tool') {
                                                $fres = $database->bio_history_search(236, $q, $start);
                                                $k = 0;
                                                while ($frow = $fres->fetch_array()) {
                                                    $search[$k]['profileid'] = $frow['profileid'];
                                                    $search[$k]['page'] = $frow['skill'];
                                                    $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                        $database);
                                                    $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                        $memcached, $database);
                                                    $k++;
                                                }
                                                $data['count'] = $k;
                                                $data['filter'] = $filter;
                                                $data['action'] = $search;
                                                $data['post'] = $post;
                                                $data['name'] = $name;
                                                $data['pimage'] = $pimage;
                                                echo json_encode($data);
                                            } else
                                                if ($filter == 'major') {
                                                    $fres = $database->bio_history_search(235, $q, $start);
                                                    $k = 0;
                                                    while ($frow = $fres->fetch_array()) {
                                                        $search[$k]['profileid'] = $frow['profileid'];
                                                        $search[$k]['page'] = $frow['skill'];
                                                        $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                            $database);
                                                        $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                            $memcached, $database);
                                                        $k++;
                                                    }
                                                    $data['count'] = $k;
                                                    $data['filter'] = $filter;
                                                    $data['action'] = $search;
                                                    $data['post'] = $post;
                                                    $data['name'] = $name;
                                                    $data['pimage'] = $pimage;
                                                    echo json_encode($data);
                                                } else
                                                    if ($filter == 'certificate') {
                                                        $fres = $database->bio_history_search(232, $q, $start);
                                                        $k = 0;
                                                        while ($frow = $fres->fetch_array()) {
                                                            $search[$k]['profileid'] = $frow['profileid'];
                                                            $search[$k]['page'] = $frow['skill'];
                                                            $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                $database);
                                                            $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                $memcached, $database);
                                                            $k++;
                                                        }
                                                        $data['count'] = $k;
                                                        $data['filter'] = $filter;
                                                        $data['action'] = $search;
                                                        $data['post'] = $post;
                                                        $data['name'] = $name;
                                                        $data['pimage'] = $pimage;
                                                        echo json_encode($data);
                                                    } else
                                                        if ($filter == 'award') {
                                                            $fres = $database->bio_history_search(233, $q, $start);
                                                            $k = 0;
                                                            while ($frow = $fres->fetch_array()) {
                                                                $search[$k]['profileid'] = $frow['profileid'];
                                                                $search[$k]['page'] = $frow['skill'];
                                                                $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                    $database);
                                                                $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                    $memcached, $database);
                                                                $k++;
                                                            }
                                                            $data['count'] = $k;
                                                            $data['filter'] = $filter;
                                                            $data['action'] = $search;
                                                            $data['post'] = $post;
                                                            $data['name'] = $name;
                                                            $data['pimage'] = $pimage;
                                                            echo json_encode($data);
                                                        } else
                                                            if ($filter == 'hobby') {
                                                                $fres = $database->bio_history_search(211, $q, $start);
                                                                $k = 0;
                                                                while ($frow = $fres->fetch_array()) {
                                                                    $search[$k]['profileid'] = $frow['profileid'];
                                                                    $search[$k]['page'] = $frow['skill'];
                                                                    $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                        $database);
                                                                    $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                        $memcached, $database);
                                                                    $k++;
                                                                }
                                                                $data['count'] = $k;
                                                                $data['filter'] = $filter;
                                                                $data['action'] = $search;
                                                                $data['post'] = $post;
                                                                $data['name'] = $name;
                                                                $data['pimage'] = $pimage;
                                                                echo json_encode($data);
                                                            } else
                                                                if ($filter == 'sports') {
                                                                    $fres = $database->bio_history_search(209, $q, $start);
                                                                    $k = 0;
                                                                    while ($frow = $fres->fetch_array()) {
                                                                        $search[$k]['profileid'] = $frow['profileid'];
                                                                        $search[$k]['page'] = $frow['skill'];
                                                                        $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                            $database);
                                                                        $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                            $memcached, $database);
                                                                        $k++;
                                                                    }
                                                                    $data['count'] = $k;
                                                                    $data['filter'] = $filter;
                                                                    $data['action'] = $search;
                                                                    $data['post'] = $post;
                                                                    $data['name'] = $name;
                                                                    $data['pimage'] = $pimage;
                                                                    echo json_encode($data);
                                                                } else
                                                                    if ($filter == 'book') {
                                                                        $fres = $database->bio_history_search(208, $q, $start);
                                                                        $k = 0;
                                                                        while ($frow = $fres->fetch_array()) {
                                                                            $search[$k]['profileid'] = $frow['profileid'];
                                                                            $search[$k]['page'] = $frow['skill'];
                                                                            $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                                $database);
                                                                            $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                                $memcached, $database);
                                                                            $k++;
                                                                        }
                                                                        $data['count'] = $k;
                                                                        $data['filter'] = $filter;
                                                                        $data['action'] = $search;
                                                                        $data['post'] = $post;
                                                                        $data['name'] = $name;
                                                                        $data['pimage'] = $pimage;
                                                                        echo json_encode($data);
                                                                    } else
                                                                        if ($filter == 'movie') {
                                                                            $fres = $database->bio_history_search(207, $q, $start);
                                                                            $k = 0;
                                                                            while ($frow = $fres->fetch_array()) {
                                                                                $search[$k]['profileid'] = $frow['profileid'];
                                                                                $search[$k]['page'] = $frow['skill'];
                                                                                $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                                    $database);
                                                                                $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                                    $memcached, $database);
                                                                                $k++;
                                                                            }
                                                                            $data['count'] = $k;
                                                                            $data['filter'] = $filter;
                                                                            $data['action'] = $search;
                                                                            $data['post'] = $post;
                                                                            $data['name'] = $name;
                                                                            $data['pimage'] = $pimage;
                                                                            echo json_encode($data);
                                                                        } else
                                                                            if ($filter == 'music') {
                                                                                $fres = $database->bio_history_search(206, $q, $start);
                                                                                $k = 0;
                                                                                while ($frow = $fres->fetch_array()) {
                                                                                    $search[$k]['profileid'] = $frow['profileid'];
                                                                                    $search[$k]['page'] = $frow['skill'];
                                                                                    $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                                        $database);
                                                                                    $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                                        $memcached, $database);
                                                                                    $k++;
                                                                                }
                                                                                $data['count'] = $k;
                                                                                $data['filter'] = $filter;
                                                                                $data['action'] = $search;
                                                                                $data['post'] = $post;
                                                                                $data['name'] = $name;
                                                                                $data['pimage'] = $pimage;
                                                                                echo json_encode($data);
                                                                            } else
                                                                                if ($filter == 'company') {
                                                                                    $fres = $database->bio_history_search(205, $q, $start);
                                                                                    $k = 0;
                                                                                    while ($frow = $fres->fetch_array()) {
                                                                                        $search[$k]['profileid'] = $frow['profileid'];
                                                                                        $search[$k]['page'] = $frow['skill'];
                                                                                        $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                                            $database);
                                                                                        $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                                            $memcached, $database);
                                                                                        $k++;
                                                                                    }
                                                                                    $data['count'] = $k;
                                                                                    $data['filter'] = $filter;
                                                                                    $data['action'] = $search;
                                                                                    $data['post'] = $post;
                                                                                    $data['name'] = $name;
                                                                                    $data['pimage'] = $pimage;
                                                                                    echo json_encode($data);
                                                                                } else
                                                                                    if ($filter == 'college') {
                                                                                        $fres = $database->bio_history_search(204, $q, $start);
                                                                                        $k = 0;
                                                                                        while ($frow = $fres->fetch_array()) {
                                                                                            $search[$k]['profileid'] = $frow['profileid'];
                                                                                            $search[$k]['page'] = $frow['skill'];
                                                                                            $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                                                $database);
                                                                                            $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                                                $memcached, $database);
                                                                                            $k++;
                                                                                        }
                                                                                        $data['count'] = $k;
                                                                                        $data['filter'] = $filter;
                                                                                        $data['action'] = $search;
                                                                                        $data['post'] = $post;
                                                                                        $data['name'] = $name;
                                                                                        $data['pimage'] = $pimage;
                                                                                        echo json_encode($data);
                                                                                    } else
                                                                                        if ($filter == 'school') {
                                                                                            $fres = $database->bio_history_search(203, $q, $start);
                                                                                            $k = 0;
                                                                                            while ($frow = $fres->fetch_array()) {
                                                                                                $search[$k]['profileid'] = $frow['profileid'];
                                                                                                $search[$k]['page'] = $frow['skill'];
                                                                                                $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                                                    $database);
                                                                                                $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                                                    $memcached, $database);
                                                                                                $k++;
                                                                                            }
                                                                                            $data['count'] = $k;
                                                                                            $data['filter'] = $filter;
                                                                                            $data['action'] = $search;
                                                                                            $data['post'] = $post;
                                                                                            $data['name'] = $name;
                                                                                            $data['pimage'] = $pimage;
                                                                                            echo json_encode($data);
                                                                                        } else
                                                                                            if ($filter == 'profession') {
                                                                                                $fres = $database->bio_history_search(202, $q, $start);
                                                                                                $k = 0;
                                                                                                while ($frow = $fres->fetch_array()) {
                                                                                                    $search[$k]['profileid'] = $frow['profileid'];
                                                                                                    $search[$k]['page'] = $frow['skill'];
                                                                                                    $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                                                        $database);
                                                                                                    $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                                                        $memcached, $database);
                                                                                                    $k++;
                                                                                                }
                                                                                                $data['count'] = $k;
                                                                                                $data['filter'] = $filter;
                                                                                                $data['action'] = $search;
                                                                                                $data['post'] = $post;
                                                                                                $data['name'] = $name;
                                                                                                $data['pimage'] = $pimage;
                                                                                                echo json_encode($data);
                                                                                            } else
                                                                                                if ($filter == 'city') {
                                                                                                    $fres = $database->bio_history_search(201, $q, $start);
                                                                                                    $k = 0;
                                                                                                    while ($frow = $fres->fetch_array()) {
                                                                                                        $search[$k]['profileid'] = $frow['profileid'];
                                                                                                        $search[$k]['page'] = $frow['skill'];
                                                                                                        $name[$search[$k]['profileid']] = $help->name_fetch($search[$k]['profileid'], $memcached,
                                                                                                            $database);
                                                                                                        $pimage[$search[$k]['profileid']] = $help->pimage_fetch($search[$k]['profileid'],
                                                                                                            $memcached, $database);
                                                                                                        $k++;
                                                                                                    }
                                                                                                    $data['count'] = $k;
                                                                                                    $data['filter'] = $filter;
                                                                                                    $data['action'] = $search;
                                                                                                    $data['post'] = $post;
                                                                                                    $data['name'] = $name;
                                                                                                    $data['pimage'] = $pimage;
                                                                                                    echo json_encode($data);
                                                                                                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function search_people()
    {
        global $help;
        if (isset($_GET['q'])) {
            if (!empty($_GET['q'])) {
                $q = $_GET['q'];
                global $database;
                global $memcached;

                if ($help->is_email($q)) {
                    $fres = $database->profile_email_search($q);
                } else {
                    $fres = $database->profile_search($q, 0);
                }
                $k = 0;
                while ($frow = $fres->fetch_array()) {
                    $search[$k] = $frow['PROFILEID'];
                    $name[$search[$k]] = $help->name_fetch($search[$k], $memcached, $database);
                    $pimage[$search[$k]] = $help->pimage_fetch($search[$k], $memcached, $database);
                    $k++;
                }
                $data['action'] = $search;
                $data['name'] = $name;
                $data['pimage'] = $pimage;
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function setting_save()
    {
        if (isset($_GET['key']) && isset($_GET['value'])) {
            $key = $_GET['key'];
            $value = $_GET['value'];
            $result = $database->setting_email_json_update($key, $value);
            if ($result) {
                $data['ack'] = 1;
                echo json_encode($data);
            } else {
                $data['ack'] = 0;
                echo json_encode($data);
            }
        } else {
            $data['ack'] = -1;
            echo json_encode($data);
        }
    }

    function friend_suggest()
    {
        global $help;
        if (isset($_GET['count'])) {
            if (!empty($_GET['count'])) {
                $limit = $_GET['count'];
                $myprofileid = $_SESSION['userid'];
                global $database;
                global $json;
                global $memcached;
                $guess = array();
                $name = array();
                $pimage = array();
                if ($result = $database->suggest_select($myprofileid, $limit)) {
                    $k = 0;
                    while ($row = $result->fetch_array()) {
                        $guess[$k]['profileid'] = $row['PROFILEID'];
                        $name[$guess[$k]['profileid']] = $help->name_fetch($guess[$k]['profileid'], $memcached,
                            $database);
                        $pimage[$guess[$k]['profileid']] = $help->pimage_fetch($guess[$k]['profileid'],
                            $memcached, $database);
                        $k++;
                    }
                    $data['action'] = $guess;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function event_suggest()
    {
        $guess = array();
        $name = array();
        $pimage = array();
        if (isset($_GET['count'])) {
            if (!empty($_GET['count'])) {
                $limit = $_GET['count'];
                $myprofileid = $_SESSION['userid'];
                global $database;
                global $help;
                global $json;
                global $memcached;
                $guess = array();
                $name = array();
                $pimage = array();
                if ($result = $database->event_suggest($myprofileid, $limit)) {
                    $k = 0;
                    while ($row = $result->fetch_array()) {
                        $guess[$k]['profileid'] = $row['eventid'];
                        $name[$guess[$k]['profileid']] = $row['eventname'];
                        $pimage[$guess[$k]['profileid']] = $icon_cdn . '/event.png';
                        $k++;
                    }
                    $data['action'] = $guess;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function group_suggest()
    {
        global $help;
        if (isset($_GET['count'])) {
            if (!empty($_GET['count'])) {
                $limit = $_GET['count'];
                $myprofileid = $_SESSION['userid'];
                global $database, $icon_cdn;
                global $help;
                global $json;
                global $memcached;
                $guess = array();
                $name = array();
                $pimage = array();
                if ($result = $database->group_suggest($myprofileid, $limit)) {
                    $k = 0;
                    while ($row = $result->fetch_array()) {
                        $guess[$k]['profileid'] = $row['groupid'];
                        $name[$guess[$k]['profileid']] = $row['groupname'];
                        $pimage[$guess[$k]['profileid']] = $icon_cdn . '/group.png';
                        $k++;
                    }
                    $data['action'] = $guess;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function song_search()
    {
        global $help;
        if (isset($_GET['q']) && isset($_GET['song_limit'])) {
            if (!empty($_GET['q']) && $_GET['song_limit'] != '') {
                $q = $_GET['q'];
                $song_limit = $_GET['song_limit'];
                global $database;
                if ($fres = $database->song_search($q, $song_limit, '6')) {
                    $k = 0;
                    while ($frow = $fres->fetch_array()) {
                        $song[$k]['songid'] = $frow['SONGID'];
                        $song[$k]['song'] = $frow['SONG'];
                        $song[$k]['file'] = $frow['FILENAME'];
                        $k++;
                    }
                    $data['song'] = $song;
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function status_song()
    {
        global $help;
        if (isset($_GET['songid']) && isset($_GET['song_status'])) {
            if (!empty($_GET['songid']) && !empty($_GET['song_status'])) {
                $myprofileid = $_SESSION['userid'];
                if (strlen($song_line) <= 6072) {
                    $songid = $_GET['songid'];
                    global $database;
                    $srow = $database->songid_exists($songid);
                    if ($srow['SONGID'] == $songid) {
                        $songid = $_GET['songid'];
                        $song_status = $_GET['song_status'];
                        $visible_id = $_SESSION['visible'];
                        $actionid = $database->get_actionid($myprofileid, 2000, 0, $visible_id);
                        if ($actionid) {
                            $result = $database->diary_insert($actionid, $song_status);
                            if ($result) {
                                $res = $database->map_insert($actionid, $songid);
                                if ($res) {
                                    $data = array();
                                    $data['ack'] = $res;
                                    echo json_encode($data);
                                }
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(11);
                    }
                } else {
                    $help->error_description(10);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function song_dedicate()
    {
        global $help;
        if (isset($_GET['profileid']) && isset($_GET['songid']) && isset($_GET['song_line'])) {
            if (!empty($_GET['profileid']) && !empty($_GET['songid']) && !empty($_GET['song_line'])) {
                global $database;
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                $songid = $_GET['songid'];
                $song_line = $_GET['song_line'];
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($profileid != $myprofileid) {
                        if ($database->check_friendship($myprofileid, $profileid) == 2) {
                            if (strlen($song_line) <= 6072) {
                                $srow = $database->songid_exists($songid);
                                if ($srow['SONGID'] == $songid) {
                                    $visible_id = $_SESSION['visible'];
                                    $actionid = $database->get_actionid($profileid, '2100', 0, $visible_get);
                                    if ($actionid) {
                                        $result = $database->diary_insert($actionid, $song_line);
                                        if ($result) {
                                            $res = $database->map_insert($actionid, $songid);
                                            if ($res) {
                                                $data = array();
                                                $data['ack'] = $res;
                                                echo json_encode($data);
                                            }
                                        } else {
                                            $help->error_description(15);
                                        }
                                    } else {
                                        $help->error_description(15);
                                    }
                                } else {
                                    $help->error_description(11);
                                }
                            } else {
                                $help->error_description(10);
                            }
                        } else {
                            $help->error_description(1);
                        }
                    } else {
                        $help->error_description(2);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function stepup()
    {
        global $help;
        global $database;
        $myprofileid = $_SESSION['userid'];
        $step = $_SESSION['STEP'];
        if ($step == 1 || $step == 2) {
            $step += 1;
        } else {
            $step = 0;
        }
        if ($database->stepup($step, $myprofileid)) {
            $_SESSION['STEP'] = $step;
            $data['ack'] = 1;
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }
    }

    function school_update()
    {
        $school = $_GET['school'];
        if (isset($_GET['syear'])) {
            $column1 = 'SCHOOL';
            $column2 = 'SYEAR';
            $year = $_GET['syear'];
            $_SESSION['SCHOOL'] = $school;
        } else
            if (isset($_GET['cyear'])) {
                $column1 = 'COLLEGE';
                $column2 = 'CYEAR';
                $year = $_GET['cyear'];
                $_SESSION['COLLEGE'] = $school;
            }
        if ($column1 && $column2) {
            $database = new Database();
            $result = $database->school_update($column1, $column2, $school, $year);
            echo $result;
        }
    }

    function tagline_set()
    {
        global $help;
        if (isset($_GET['tagline'])) {
            if (!empty($_GET['tagline'])) {
                $tagline = $_GET['tagline'];
                $myprofileid = $_SESSION['userid'];
                if (strlen($tagline) <= 50) {
                    global $database;
                    $visible_id = $_SESSION['visible'];
                    $actionid = $database->get_actionid($myprofileid, 800, 0, $visible_id, 1);
                    if ($actionid) {
                        $result = $database->set_tag($tagline);
                        $result = $database->diary_insert($actionid, $tagline);
                        echo json_encode(1);
                    } else {
                        $help->error_description(15);
                    }
                } else {
                    $help->error_description(18);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function event_cancel()
    {
        global $help;
        if (isset($_GET['eventid'])) {
            if (!empty($_GET['eventid'])) {
                $myprofileid = $_SESSION['userid'];
                $eventid = $_GET['eventid'];
                global $database;
                if ($database->event_exists($eventid) == $eventid) {
                    $row = $database->event_select($eventid);
                    if ($row['host'] == $myprofileid) {
                        $actiontype = 410;
                        $actionid = $database->get_actionid($eventid, $actiontype, 0, 6);
                        if ($actionid) {
                            $eventname = $row['name'];
                            if ($database->event_cancel($eventid)) {
                                $guests = $database->guest_select($eventid);
                                global $email;
                                $param = array();
                                $param['type'] = 'event_cancel';
                                $param['eventname'] = $eventname;
                                $param['actionby'] = $myprofileid;
                                $param['actionid'] = $actionid;
                                while ($res = $guests->fetch_array()) {
                                    $memberid = $res['profileid'];
                                    if ($memberid != $myprofileid) {
                                        $rnotice = $database->setting_notice_select($memberid);
                                        if ($rnotice['event_cancel']) {
                                            $database->notice_insert($actionid, $eventid, $actiontype, $actionid);
                                        }
                                        $remail = $database->setting_email_select($memberid);
                                        if ($remail['event_cancel']) {
                                            $param['memberid'] = $memberid;
                                            $email->email_sample($param);
                                        }
                                    }
                                }
                                $data['ack'] = 1;
                                echo json_encode($data);
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(1);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function event_leave()
    {
        global $help;
        if (isset($_GET['eventid'])) {
            if (!empty($_GET['eventid'])) {
                $myprofileid = $_SESSION['userid'];
                $eventid = $_GET['eventid'];
                global $database;
                $check = $database->event_exists($eventid);
                if ($check == $eventid) {
                    $row = $database->is_guest($eventid, $myprofileid);
                    if ($row->num_rows) {
                        $n = $database->guest_select_profileid($eventid, $myprofileid);
                        if ($database->action_delete($n['actionid'])) {
                            if ($database->unsubscribe($eventid, $myprofileid)) {
                                $data['actionid'] = $database->get_actionid($eventid, 409, 0, 5);
                                $data['ack'] = 1;
                                echo json_encode($data);
                            } else {
                                $help->error_description(15);
                            }
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(39);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }


    function group_leave()
    {
        global $help;
        if (isset($_GET['groupid'])) {
            if (!empty($_GET['groupid'])) {
                $myprofileid = $_SESSION['userid'];
                $groupid = $_GET['groupid'];
                global $database;
                $check = $database->group_exists($groupid);
                if ($check == $groupid) {
                    $row = $database->is_member($groupid, $myprofileid);
                    if ($row->num_rows) {
                        $n = $database->member_select_profileid($groupid, $myprofileid);
                        if ($database->action_delete($n['actionid'])) {
                            $data['actionid'] = $database->get_actionid($groupid, 309, 0, 5);
                            $data['ack'] = 1;
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(40);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function unfriend()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            if (!empty($_GET['profileid'])) {
                $myprofileid = $_SESSION['userid'];
                $profileid = $_GET['profileid'];
                global $database;
                global $memcached;
                $check = $database->is_user($profileid);
                if ($check['USERID'] == $profileid) {
                    if ($database->check_friendship($myprofileid, $profileid) == 2) {
                        $visible_id = $_SESSION['visible'];
                        $actionid = $database->get_actionid($profileid, '9', 0, $visible_id);
                        if ($actionid) {
                            $result = $database->friend_delete($profileid);
                            $help->friend_memcache_update($myprofileid, $database, $memcached);
                            $help->friend_memcache_update($profileid, $database, $memcached);
                            $data['ack'] = 1;
                            echo json_encode($data);
                        } else {
                            $help->error_description(15);
                        }
                    } else {
                        $help->error_description(1);
                    }
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function validate()
    {
        global $help;
        if (isset($_GET['name']) && isset($_GET['password']) && isset($_GET['gender']) &&
            isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])) {
            if (!empty($_GET['name']) && !empty($_GET['password']) && $_GET['gender'] != '' &&
                !empty($_GET['day']) && !empty($_GET['month']) && !empty($_GET['year'])) {
                $name = trim($_GET['name']);
                $password = trim($_GET['password']);
                $gender = trim($_GET['gender']);
                $day = trim($_GET['day']);
                $month = trim($_GET['month']);
                $year = trim($_GET['year']);
                if ($name != '' && $password != '' && $gender != -1 && $day != -1 && $month != -
                    1 && $year != -1) {
                    if (preg_match("/^[[:space:]]*[a-zA-Z]+[[:space:]]*[a-zA-Z]*[[:space:]]*[a-zA-Z]*$/",
                        $name)) {
                        if (strlen($password) > 5) {
                            if ($gender == 0 || $gender == 1) {
                                if ($day == 31) {
                                    switch ($month) {
                                        case 2:
                                            echo json_encode(4);
                                            exit;
                                        case 1:
                                        case 3:
                                        case 5:
                                        case 7:
                                        case 8:
                                        case 10:
                                        case 12:
                                            echo json_encode(5);
                                            exit;
                                        default:
                                            echo json_encode(4);
                                            exit;
                                    }
                                } else
                                    if ($day == 30) {
                                        switch ($month) {
                                            case 2:
                                                echo json_encode(4);
                                                exit;
                                            default:
                                                echo json_encode(5);
                                                exit;
                                        }

                                    } else
                                        if ($day == 29) {
                                            switch ($month) {
                                                case 2:
                                                    if ($year % 400 == 0) {
                                                        echo json_encode(5);
                                                        exit;
                                                    } else
                                                        if ($year % 100 == 0) {
                                                            echo json_encode(4);
                                                            exit;
                                                        } else
                                                            if ($year % 4 == 0) {
                                                                echo json_encode(5);
                                                                exit;
                                                            } else {
                                                                echo json_encode(4);
                                                                exit;
                                                            }
                                                        default:
                                                            echo json_encode(5);
                                                    exit;
                                            }
                                        } else {
                                            echo json_encode(5);
                                            exit;
                                        }
                            } else {
                                echo json_encode(3);
                            }
                        } else {
                            echo json_encode(2);
                        }
                    } else {
                        echo json_encode(1);
                    }
                } else {
                    echo json_encode(0);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function validate_email()
    {
        global $help;
        if (isset($_GET['email'])) {
            if (!empty($_GET['email'])) {
                echo json_encode($help->validate_email($_GET['email']));
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function validate_name()
    {
        global $help;
        if (isset($_GET['name'])) {
            if (!empty($_GET['name'])) {
                echo json_encode($help->validate_name($_GET['name']));
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function validate_password()
    {
        global $help;
        if (isset($_POST['password'])) {
            if (!empty($_POST['password'])) {
                echo json_encode($help->validate_password($_POST['password']));
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function validate_school()
    {
        global $help;
        if (isset($_GET['school'])) {
            if (!empty($_GET['school'])) {
                echo json_encode($help->validate_school($_GET['school']));
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function validate_year()
    {
        global $help;
        if (isset($_GET['year'])) {
            if (!empty($_GET['year'])) {
                echo json_encode($help->validate_year($_GET['year']));
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }

    function login_get()
    {
        $help = new Help();
        global $memcached;
        if (isset($_GET['email']) && isset($_GET['password'])) {
            if (!empty($_GET['email']) && !empty($_GET['password'])) {
                $email = trim($_REQUEST['email']);
                $password = trim($_REQUEST['password']);
                $password = sha1($email . $password);
                $database_old = new Database();
                $help->assign_database($email, $database_old);
                $database_old = null;
                $database = new Database();
                $row = $database->login_user($email, $password);
                $pass = $row['PASSWORD'];
                if ($password == $pass) {
                    $myprofileid = $row['USERID'];
                    $_SESSION['auth'] = $row['USERID'];
                    $_SESSION['userid'] = $_SESSION['USERID'] = $row['USERID'];
                    $sid = session_id();
                    setcookie(session_name(), $sid, time() + 3600000, '/');
                    $data['ack'] = 1;
                    $data['message'] = 'Login Successful';
                    $data['myprofileid'] = $row['USERID'];
                    $data['sessionid'] = $sid;
                    $data['database'] = $_SESSION['database'];
                    $data['name'] = $help->name_fetch($row['USERID'], $memcached, $database);
                    $data['photo'] = $help->pimage_fetch($row['USERID'], $memcached, $database);
                    $data['session_name'] = session_name();
                    echo json_encode($data);
                } else {
                    $help->error_description(37);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function login()
    {
        global $help, $memcached;
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $email = trim($_REQUEST['email']);
                $password = trim($_REQUEST['password']);
                $password = sha1($email . $password);
                $database_old = new Database();
                $help->assign_database($email, $database_old);
                $database_old = null;
                $database = new Database();
                $row = $database->login_user($email, $password);
                $pass = $row['PASSWORD'];
                if ($password == $pass) {
                    $myprofileid = $row['USERID'];
                    $_SESSION['auth'] = $row['USERID'];
                    $_SESSION['userid'] = $_SESSION['USERID'] = $row['USERID'];
                    $sid = session_id();
                    setcookie(session_name(), $sid, time() + 3600000, '/');
                    $data['ack'] = 1;
                    $data['message'] = 'Login Successful';
                    $data['myprofileid'] = $row['USERID'];
                    $data['database'] = $_SESSION['database'];
                    $data['sessionid'] = $sid;
                    $data['name'] = $help->name_fetch($row['USERID'], $memcached, $database);
                    $data['photo'] = $help->pimage_fetch($row['USERID'], $memcached, $database);
                    $data['session_name'] = session_name();
                    echo json_encode($data);
                } else {
                    $help->error_description(37);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function analytics()
    {
        global $database;
        $row = $database->get_analytics();
    }
    function daily_report()
    {
        global $help;
        global $database;
        $count = array();
        $count = $database->get_daily_report();
        if ($count) {
            $data['counts'] = $count[0];
            $data['joined'] = $count[1];
            $data['comment'] = $count[2];
            $data['type'] = "Daily";
            $data['total'] = $count[0] + $count[1] + $count[2];
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }
    }
    function weekly_report()
    {
        global $help;
        global $database;
        $count = array();
        $count = $database->get_weekly_report();
        if ($count) {
            $data['counts'] = $count[0];
            $data['joined'] = $count[1];
            $data['comment'] = $count[2];
            $data['type'] = "Weekly";
            $data['total'] = $count[0] + $count[1] + $count[2];
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }
    }
    function monthly_report()
    {
        global $help;
        global $database;
        $count = array();
        $count = $database->get_monthly_report();
        if ($count) {
            $data['counts'] = $count[0];
            $data['joined'] = $count[1];
            $data['comment'] = $count[2];
            $data['type'] = "Monthly";
            $data['total'] = $count[0] + $count[1] + $count[2];
            echo json_encode($data);
        } else {
            $help->error_description(15);
        }
    }

    //We need to free below functions from using html code and convert into pure JSON , only we need to encode the feature glag which are set.
    function actions_load()
    {
        global $help, $memcached, $database, $icon_cdn;
        $page = $_GET['page'];
        $profile_relation = $_GET['profile_relation'];
        if ($page == 'group_json' && ($profile_relation == 0 || $profile_relation == 1)) {
?>
			<div id="upload_box"> 
				<ol class="breadcrumb">
				  <li id="status_link" ><a href="#">Discussion</a></li>
				  <li id="photo_link" ><a href="#">File</a></li>
				  <li id="question_link" onclick="ui.group_question(this)"  ><a href="#">Question</a></li>
				  <li id="event_link" onclick="ui.group_event_create(this,1)" ><a href="#">Event</a></li>	
				</ol>
				<div  id="uploader">  
				<!--	<input type="text" id="status_box" value="" placeholder="Post in <?php //echo $profile_name; ?> group"/>
					<input id="link_button" type="submit" value="Post">     -->
				</div>
			</div>
			<?php
        } else
            if ($page == 'event_json' || $page == 'page_json') {
?>
			<div id="upload_box"> 
				<ol class="breadcrumb">
				  <li id="status_link" ><a href="#">Post</a></li>
				  <li id="photo_link" ><a href="#">File</a></li>
				</ol>
				<div  id="uploader">  
				<!--	<input type="text" id="status_box" value="" placeholder="Post in <?php //echo $profile_name; ?> event"/>
					<input id="link_button" type="submit" value="Post">     -->
				</div>
			</div>
			<?php
            } else
                if ($profile_relation == 0) {
                    $myprofileid = $_SESSION['userid'];
                    $flag = $database->privacy_item_select('profile_post_next', $myprofileid);
                    switch ($flag) {
                        case 0:
                            $icon_image = $icon_cdn . '/global.png';
                            break;
                        case 1:
                            $icon_image = $icon_cdn . '/meeting.png';
                            break;
                        case 2:
                            $icon_image = $icon_cdn . '/friend.png';
                            break;
                        default:
                            $icon_image = $icon_cdn . '/global.png';
                            break;
                    }
?>
				<div id="upload_box"> 
					<ol class="breadcrumb">
					  <li id="status_link" ><a href="#">Status</a></li>
					  <li id="photo_link" ><a href="#">File</a></li>
					  <li id="moment_link" ><a href="#">Album</a></li>
					  <li id="question_link" ><a href="#">Question</a></li>
					  <?php
                    if ($help->feature_fetch('mood', $memcached, $database)) {
?>
						  <li onclick="ui.mood(this)" ><a href="#">Mood</a></li>
					  <?php
                    }
?>
						<span id="profile_post_privacy_link" onclick="ui.profile_post_privacy(this,event)" style="margin-left:0.5em;cursor:pointer;"><img title="Set the privacy of your next post" src="<?php echo
                    $icon_image; ?>" height="14" width="14" /></span>
										
					</ol> 
					<div id="uploader">
					<!--	<input type="text" id="status_box" value="" placeholder="What are you working on today?"/>
						<input id="link_button" type="submit" value="Share"> -->
					</div> 
				</div>
			<?php
                } else
                    if ($profile_relation == 1) {
?>
				<div id="upload_box"> 
					<ol class="breadcrumb">
					  <li id="status_link" ><a href="#">Post</a></li>
					  <li id="photo_link" ><a href="#">File</a></li>
					  <li id="moment_link" ><a href="#">Album</a></li>
					  <?php
                        if ($help->feature_fetch('gift', $memcached, $database)) {
?>
						  <li onclick="ui.gift_ui_create(this)" ><a href="#">Send-Gift</a></li>
					  <?php
                        }
?>				
					</ol>
					<div  id="uploader">  
					<!--	<input type="text" id="status_box" value="" placeholder="Post in <?php //echo $profile_name; ?>'s diary"/>
						<input id="link_button" type="submit" value="Post">   -->  
					</div>
				</div>
			<?php
                    }
    }
    function page_details_fetch()
    {
        global $database, $memcached, $help;
        if (isset($_GET['pageid'])) {
            if (!empty($_GET['pageid'])) {
                $myprofileid = $_SESSION['userid'];
                $pageid = $_GET['pageid'];
                $info = array();
                if ($result = $database->page_select($pageid)) {
                    $info['pagename'] = $result['name'];
                    $info['page_description'] = $result['description'];
                    $data['info'] = $info;
                    echo json_encode($data);
                } else {
                    $help->error_description(15);
                }

            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }

    }
    function setting_feature_select()
    {
        global $database, $memcached, $help;
        $info = array();
        /*$missu['status'] = $help->feature_fetch('missu',$memcached, $database);
        $gift['status'] = $help->feature_fetch('gift',$memcached, $database);
        $mood['status'] = $help->feature_fetch('mood',$memcached, $database);
        $birthday['status'] = $help->feature_fetch('birthday',$memcached, $database);
        $actiontype_preview['status'] = $help->feature_fetch('actiontype_preview',$memcached, $database);
        $invite_friend['status'] = $help->feature_fetch('invite_friend',$memcached, $database);*/
        if ($help->feature_fetch('missu', $memcached, $database))
            $info['missu'] = 'checked';
        else
            $info['missu'] = 'unchecked';
        if ($help->feature_fetch('gift', $memcached, $database))
            $info['gift'] = 'checked';
        else
            $info['gift'] = 'unchecked';
        if ($help->feature_fetch('mood', $memcached, $database))
            $info['mood'] = 'checked';
        else
            $info['mood'] = 'unchecked';
        if ($help->feature_fetch('birthday', $memcached, $database))
            $info['birthday'] = 'checked';
        else
            $info['birthday'] = 'unchecked';
        if ($help->feature_fetch('actiontype_preview', $memcached, $database))
            $info['actiontype_preview'] = 'checked';
        else
            $info['actiontype_preview'] = 'unchecked';
        if ($help->feature_fetch('invite_friend', $memcached, $database))
            $info['invite_friend'] = 'checked';
        else
            $info['invite_friend'] = 'unchecked';

        $data['info'] = $info;
        echo json_encode($data);
    }
    function profile_details_fetch()
    {
        global $help, $profile_cdn;
        if (isset($_GET['profileid'])) {
            if (!empty($_GET['profileid'])) {
                global $database, $memcached;
                $info = array();
                $profileid = $_GET['profileid'];
                $profile_relation = -99;
                $myprofileid = $_SESSION['userid'];
                if ($result = $database->bio_select($profileid)) {
                    $info['name'] = $result['NAME'];
                    $info['fname'] = $result['FNAME'];
                    $info['mname'] = $result['MNAME'];
                    $info['lname'] = $result['LNAME'];
                    $info['sex'] = $result['SEX'];
                    $info['birthday'] = $result['BIRTHDAY'];

                    $friendship_status = $database->check_friendship($profileid, $myprofileid);
                    $info['friendship_status'] = $friendship_status;
                    $info['following_count'] = $database->following_count($profileid);
                    $info['followers_count'] = $database->followers_count($profileid);
                    if ($profileid == $myprofileid) {
                        $profile_relation = 0;
                    }
                    if ($friendship_status == 2) {
                        $profile_relation = 1;
                    }
                    $info['profile_relation'] = $profile_relation;
                    if ($profileid == $myprofileid) {
                        $info['profile_image'] = $_SESSION['pimage'];
                        $info['profile_imageid'] = $_SESSION['profile_imageid'];
                    } else {
                        $pirow = $database->get_image($profileid);
                        $info['profile_image'] = $pirow['CDN'] . $pirow['FILENAME'];
                        $info['profile_imageid'] = $pirow['IMAGEID'];
                    }
                    $ext = pathinfo($info['profile_image'], PATHINFO_EXTENSION);
                    if (strpos($info['profile_image'], '_t') > -1) {
                        $arr = explode('_', $info['profile_image']);
                        $info['profile_image'] = $arr[0] . '.' . $ext;
                    } else {
                        $arr = explode('/', $info['profile_image']);
                        $info['profile_image'] = $profile_cdn . '/' . $arr[3];
                    }
                    $info['missu'] = $help->feature_fetch('missu', $memcached, $database);
                    $info['gift'] = $help->feature_fetch('gift', $memcached, $database);
                    $info['mood'] = $help->feature_fetch('mood', $memcached, $database);
                    //mutual_friend can be called to fectch friend_match and friend_non_match .
                    $data['info'] = $info;
                    echo json_encode($data);
                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function event_details_fetch()
    {
        global $help, $icon_cdn;
        if (isset($_GET['eventid'])) {
            if (!empty($_GET['eventid'])) {
                global $database, $memcached;
                $info = array();
                $action = array();
                $eventid = $_GET['eventid'];
                $myprofileid = $_SESSION['userid'];
                if ($result = $database->event_select($eventid)) {
                    $info['eventid'] = $result['eventid'];
                    $info['eventname'] = $result['name'];
                    $info['description'] = $result['description'];
                    $info['invite'] = $result['invite'];
                    $info['privacy'] = $result['privacy'];
                    $info['date'] = date('j M,Y', strtotime($result['date']));
                    $info['time'] = $result['timing'];
                    $info['venue'] = $result['venue'];
                    $info['cancel'] = $result['cancel'];
                    $info['priviledge'] = $database->guest_status($eventid, $myprofileid);
                    $info['guest_count'] = $database->guest_count($eventid);
                    $info['groupid'] = $result['groupid'];
                    $info['event_photo'] = $icon_cdn . '/event.png';

                    $host = $result['host'];
                    $name[$host] = $help->name_fetch($host, $memcached, $database);
                    $pimage[$host] = $help->pimage_fetch($host, $memcached, $database);

                    $data['info'] = $info;
                    $data['host'] = $host;
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);

                } else {
                    $help->error_description(16);
                }
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function group_details_fetch()
    {
        global $help, $icon_cdn;
        if (isset($_GET['groupid'])) {
            if (!empty($_GET['groupid'])) {
                global $database, $memcached;
                $action = array();
                $info = array();
                $member = array();
                $groupid = $_GET['groupid'];
                $myprofileid = $_SESSION['userid'];
                if ($result = $database->group_select($groupid)) {
                    $info['groupname'] = $result['name'];
                    $info['groupid'] = $result['groupid'];
                    $info['priviledge'] = $database->membership_status($groupid, $myprofileid);
                    $info['description'] = $result['description'];
                    $info['link'] = $result['link'];
                    $info['createdby'] = $result['createdby'];
                    $name[$info['createdby']] = $help->name_fetch($info['createdby'], $memcached, $database);
                    $pimage[$info['createdby']] = $help->pimage_fetch($info['createdby'], $memcached,
                        $database);
                    $info['type'] = $result['type'];
                    $info['invite'] = $result['invite'];
                    $info['technical'] = $result['type'];
                    $info['member_count'] = $database->member_count($groupid);
                    $info['group_photo'] = $icon_cdn . '/group.png';

                    if ($res = $database->top_influencer_select($groupid)) {
                        $k = 0;
                        while ($row = $res->fetch_array()) {
                            $checkk = $database->is_member($groupid, $row['profileid']);
                            if ($checkk->num_rows) {
                                $top_influencer[$k] = $row['profileid'];
                                $name[$top_influencer[$k]] = $help->name_fetch($top_influencer[$k], $memcached,
                                    $database);
                                $pimage[$top_influencer[$k]] = $help->pimage_fetch($top_influencer[$k], $memcached,
                                    $database);
                                $k++;
                            } else {
                                $k++;
                            }
                        }
                    }
                    $data['info'] = $info;
                    $data['top_influencer'] = $top_influencer;
                    $data['count'] = count($match);
                    $data['name'] = $name;
                    $data['pimage'] = $pimage;
                    echo json_encode($data);
                } else {
                    $help->error_description(16);
                }

            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function group_and_event_select()
    {
        $data = array();
        $group = array();
        $event = array();
        global $database;
        $myprofileid = $_SESSION['USERID'];
        $i = 0;
        $k = 0;
        $result = $database->mygroup_select($myprofileid);
        while ($row = $result->fetch_array()) {
            $group[$i]['groupid'] = $row['groupid'];
            $group[$i]['groupname'] = $row['name'];
            $i++;
        }

        $result_event = $database->myevent_select($myprofileid, time());

        while ($rowev = $result_event->fetch_array()) {
            $event[$k]['eventid'] = $rowev['eventid'];
            $event[$k]['eventname'] = $rowev['name'];
            $k++;
        }

        $data['group'] = $group;
        $data['event'] = $event;
        echo json_encode($data);
    }

    function bio_fetch()
    {
        global $help;
        if (isset($_GET['profileid'])) {
            if (!empty($_GET['profileid'])) {
                $database = new Database();
                $profileid = $_GET['profileid'];
                $newrow = $database->bio_complete_select($profileid);
                $res = $database->bio_select_new($profileid);
                $company = array();
                $team = array();
                $major = array();
                $skill = array();
                $tool = array();
                $mobile = array();
                $extension = array();
                $certificate = array();
                $project = array();
                $award = array();
                $college = array();
                $school = array();
                $music = array();
                $movie = array();
                $sports = array();
                $book = array();
                $city = array();
                $hobby = array();
                $flag_des = 0;
                $flag = 0;
                $profession = '';
                $designation = '';
                $a = 0;
                $b = 0;
                $c = 0;
                $d = 0;
                $e = 0;
                $f = 0;
                $g = 0;
                $h = 0;
                $i = 0;
                $j = 0;
                $k = 0;
                $l = 0;
                $m = 0;
                $n = 0;
                $o = 0;
                $p = 0;
                $q = 0;
                $r = 0;
                $s = 0;
                $t = 0;
                while ($brow = $res->fetch_array()) {
                    if ($brow['type'] == 205) {
                        $company[$a]['name'] = $brow['name'];
                        $company[$a]['id'] = $brow['actionid'];
                        $a++;
                    } else
                        if ($brow['type'] == 202) {
                            if ($flag == 0) {
                                $profession[$b]['name'] = $brow['name'];
                                $profession[$b]['id'] = $brow['actionid'];
                                $flag = 1;
                                $b++;
                            }
                        } else
                            if ($brow['type'] == 239) {
                                if ($flag_des == 0) {
                                    $designation[$c]['name'] = $brow['name'];
                                    $designation[$c]['id'] = $brow['actionid'];
                                    $flag_des = 1;
                                    $c++;
                                }
                            } else
                                if ($brow['type'] == 204) {
                                    $college[$d]['name'] = $brow['name'];
                                    $college[$d]['id'] = $brow['actionid'];
                                    $d++;
                                } else
                                    if ($brow['type'] == 203) {
                                        $school[$e]['name'] = $brow['name'];
                                        $school[$e]['id'] = $brow['actionid'];
                                        $e++;
                                    } else
                                        if ($brow['type'] == 206) {
                                            $music[$f]['name'] = $brow['name'];
                                            $music[$f]['id'] = $brow['actionid'];
                                            $f++;
                                        } else
                                            if ($brow['type'] == 209) {
                                                $sports[$g]['name'] = $brow['name'];
                                                $sports[$g]['id'] = $brow['actionid'];
                                                $g++;
                                            } else
                                                if ($brow['type'] == 208) {
                                                    $book[$h]['name'] = $brow['name'];
                                                    $book[$h]['id'] = $brow['actionid'];
                                                    $h++;
                                                } else
                                                    if ($brow['type'] == 201) {
                                                        $city[$i]['name'] = $brow['name'];
                                                        $city[$i]['id'] = $brow['actionid'];
                                                        $i++;
                                                    } else
                                                        if ($brow['type'] == 207) {
                                                            $movie[$j]['name'] = $brow['name'];
                                                            $movie[$j]['id'] = $brow['actionid'];
                                                            $j++;
                                                        } else
                                                            if ($brow['type'] == 211) {
                                                                $hobby[$k]['name'] = $brow['name'];
                                                                $hobby[$k]['id'] = $brow['actionid'];
                                                                $k++;
                                                            } else
                                                                if ($brow['type'] == 215) {
                                                                    $mobile[$l]['name'] = $brow['name'];
                                                                    $mobile[$l]['id'] = $brow['actionid'];
                                                                    $l++;
                                                                } else
                                                                    if ($brow['type'] == 230) {
                                                                        $skill[$m]['name'] = $brow['name'];
                                                                        $skill[$m]['id'] = $brow['actionid'];
                                                                        $m++;
                                                                    } else
                                                                        if ($brow['type'] == 231) {
                                                                            $project[$n]['name'] = $brow['name'];
                                                                            $project[$n]['id'] = $brow['actionid'];
                                                                            $n++;
                                                                        } else
                                                                            if ($brow['type'] == 232) {
                                                                                $certificate[$o]['name'] = $brow['name'];
                                                                                $certificate[$o]['id'] = $brow['actionid'];
                                                                                $o++;
                                                                            } else
                                                                                if ($brow['type'] == 233) {
                                                                                    $award[$p]['name'] = $brow['name'];
                                                                                    $award[$p]['id'] = $brow['actionid'];
                                                                                    $p++;
                                                                                } else
                                                                                    if ($brow['type'] == 234) {
                                                                                        $team[$q]['name'] = $brow['name'];
                                                                                        $team[$q]['id'] = $brow['actionid'];
                                                                                        $q++;
                                                                                    } else
                                                                                        if ($brow['type'] == 235) {
                                                                                            $major[$r]['name'] = $brow['name'];
                                                                                            $major[$r]['id'] = $brow['actionid'];
                                                                                            $r++;
                                                                                        } else
                                                                                            if ($brow['type'] == 236) {
                                                                                                $tool[$s]['name'] = $brow['name'];
                                                                                                $tool[$s]['id'] = $brow['actionid'];
                                                                                                $s++;
                                                                                            } else
                                                                                                if ($brow['type'] == 237) {
                                                                                                    $extension[$t]['name'] = $brow['name'];
                                                                                                    $extension[$t]['id'] = $brow['actionid'];
                                                                                                    $t++;
                                                                                                }
                }
                $data['company'] = $company;
                $data['profession'] = $profession;
                $data['designation'] = $designation;
                $data['college'] = $college;
                $data['school'] = $school;
                $data['music'] = $music;
                $data['sports'] = $sports;
                $data['book'] = $book;
                $data['city'] = $city;
                $data['movie'] = $movie;
                $data['hobby'] = $hobby;
                $data['mobile'] = $mobile;
                $data['skill'] = $skill;
                $data['project'] = $project;
                $data['certificate'] = $certificate;
                $data['award'] = $award;
                $data['team'] = $team;
                $data['major'] = $major;
                $data['tool'] = $tool;
                $data['extesnion'] = $extension;

                $row = $database->privacy_select($profileid);

                $privacy['company'] = $row['company'];
                $privacy['designation'] = $row['designation'];
                $privacy['college'] = $row['college'];
                $privacy['school'] = $row['school'];
                $privacy['music'] = $row['music'];
                $privacy['sports'] = $row['sports'];
                $privacy['book'] = $row['book'];
                $privacy['city'] = $row['city'];
                $privacy['movie'] = $row['movie'];
                $privacy['hobby'] = $row['hobby'];
                $privacy['mobile'] = $row['mobile'];
                $privacy['skill'] = $row['skill'];
                $privacy['project'] = $row['project'];
                $privacy['certificate'] = $row['certificate'];
                $privacy['award'] = $row['award'];
                $privacy['team'] = $row['team'];
                $privacy['major'] = $row['major'];
                $privacy['tool'] = $row['tool'];
                $privacy['extesnion'] = $row['extension'];

                $data['privacy'] = $privacy;

                $data['sex'] = $newrow['SEX'];
                $email = $newrow['EMAIL'];
                $bday = $newrow['BIRTHDAY'];
                $nickname = $newrow['NICKNAME'];
                $relation = $newrow['RELATION'];
                $data['name'] = $newrow['NAME'];
                $data['tagline'] = stripslashes($newrow['TAGLINE']);
                if (isset($nickname)) {
                    if ($help->checkPrivacy('NICKNAME', $profileid) == 1 && $nickname != "") {
                        $data['nickname'] = $nickname;
                    }
                }
                $data['age'] = $database->get_age($profileid) . ' years old';
                if ($help->checkPrivacy('EMAIL', $profileid) == 1) {
                    $data['email'] = $email;
                }
                if (isset($bday)) {
                    if ($help->checkPrivacy('BIRTHDAY', $profileid) == 1 && $bday != "") {
                        $data['birthday'] = date('j M,Y', strtotime($bday));
                    }
                }
                $data['edit'] = 0;
                if ($profileid == $_SESSION['userid']) {
                    $data['edit'] = 1;
                }
                $data['action'] = 'brijesh';
                echo json_encode($data);
            } else {
                $help->error_description(18);
            }
        } else {
            $help->error_description(9);
        }
    }
    function analytics_details_post()
    {
        $database = new Database();
        $data = array();
        $actionday = array();
        $actioncount = array();
        $i = 0;
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
        $count = $database->analytics_details_post($startdate, $enddate);
        while ($row = $count->fetch_array()) {
            $actionday[$i] = $row["day"];
            $actioncount[$i] = $row["count(1)"];
            ++$i;
        }

        $data["day"] = $actionday;
        $data["count"] = $actioncount;
        $data["type"] = "Post";
        echo json_encode($data);
    }
    function analytics_details_joined()
    {
        $database = new Database();
        $data = array();
        $actionday = array();
        $actioncount = array();
        $i = 0;
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
        $count = $database->analytics_details_joined($startdate, $enddate);
        while ($row = $count->fetch_array()) {
            $actionday[$i] = $row["day"];
            $actioncount[$i] = $row["count(1)"];
            ++$i;
        }

        $data["day"] = $actionday;
        $data["count"] = $actioncount;
        $data["type"] = "Joined";
        echo json_encode($data);
    }
    function analytics_details_comment()
    {
        $database = new Database();
        $data = array();
        $actionday = array();
        $actioncount = array();
        $i = 0;
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
        $count = $database->analytics_details_comment($startdate, $enddate);
        while ($row = $count->fetch_array()) {
            $actionday[$i] = $row["day"];
            $actioncount[$i] = $row["count(1)"];
            ++$i;
        }

        $data["day"] = $actionday;
        $data["count"] = $actioncount;
        $data["type"] = "Comments";
        echo json_encode($data);
    }
    function analytics_details_view()
    {
        $database = new Database();
        $data = array();
        $actionday = array();
        $actioncount = array();
        $i = 0;
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
        $count = $database->analytics_details_view($startdate, $enddate);
        while ($row = $count->fetch_array()) {
            $actionday[$i] = $row["day"];
            $actioncount[$i] = $row["count(1)"];
            ++$i;
        }

        $data["day"] = $actionday;
        $data["count"] = $actioncount;
        $data["type"] = "View";
        echo json_encode($data);
    }
    function analytics_details_visit()
    {
        $database = new Database();
        $data = array();
        $actionday = array();
        $actioncount = array();
        $i = 0;
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
        $count = $database->analytics_details_visit($startdate, $enddate);
        while ($row = $count->fetch_array()) {
            $actionday[$i] = $row["day"];
            $actioncount[$i] = $row["count"];
            ++$i;
        }

        $data["day"] = $actionday;
        $data["count"] = $actioncount;
        $data["type"] = "Visit";
        echo json_encode($data);
    }
}
?>