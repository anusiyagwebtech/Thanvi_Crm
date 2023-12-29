<?php

function getbanner($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `banner` WHERE `bid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addbanner($title, $link, $description, $image, $imagename, $imagealt, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link22 = FETCH_all("SELECT * FROM `banner` WHERE `imagename`=?", $imagename);
        if ($link22['imagename'] == '') {

            $resa = $db->prepare("INSERT INTO `banner` ( `title`, `link`,`content`, `image_alt`,`imagename`,`image`,`Order`, `status`, `ip`, `Updated_By`) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($title, $link, $description, $imagename, $imagealt, $image, $order, $status, $ip, $_SESSION['UID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    } else {
        $link22 = FETCH_all("SELECT * FROM `banner` WHERE `imagename`=? AND `bid`!=?", $imagename, $getid);
        if ($link22['imagename'] == '') {
            $resa = $db->prepare("UPDATE `banner` SET `title`=?, `link`=?,`content`=?, `image`=?,`imagename`=?,`image_alt`=?,`Order`=?, `status`=?, `ip`=?, `Updated_By`=? WHERE `bid`=?");
            $resa->execute(array(trim($title), trim($link), trim($description), trim($image), trim($imagename), trim($imagealt), trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Banner Mgmt', 11, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    }
    return $res;
}

function delbanner($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `banner` WHERE `bid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getfaqcategory($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `faqcategory` WHERE `fcid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addfaqcategory($title, $link, $image, $imagealt, $imagename, $content, $meta_title, $meta_keywords, $meta_description, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `fcid` FROM `faqcategory` WHERE `image_name`=?", $imagename);
        if ($link1['fcid'] == '') {
            $link2 = FETCH_all("SELECT `fcid` FROM `faqcategory` WHERE `link`=?", $link);
            if ($link2['fcid'] == '') {
                $resa = $db->prepare("INSERT INTO `faqcategory`(`category`,`link`,`description`,`image_alt`,`image_name`,`image`,`order`,`status`,`meta_title`,`meta_keywords`,`meta_description`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($title, $link, $content, $imagealt, $imagename, $image, $order, $status, $meta_title, $meta_keywords, $meta_description, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `fcid` FROM `faqcategory` WHERE `image_name`=? AND `fcid`!=?", $imagename, $getid);
        if ($link1['fcid'] == '') {
            $link2 = FETCH_all("SELECT `fcid` FROM `faqcategory` WHERE `link`=? AND `fcid`!=?", $link, $getid);
            if ($link2['fcid'] == '') {
                $resa = $db->prepare("UPDATE `faqcategory` SET `category`=?, `link`=?,`description`=?, `image`=?,`image_alt`=?,`image_name`=?,`order`=?, `status`=?, `meta_title`=?, `meta_keywords`=?, `meta_description`=?, `ip`=?, `updated_by`=? WHERE `fcid`=?");
                $resa->execute(array(trim($title), trim($link), trim($content), trim($image), trim($imagealt), trim($imagename), trim($order), trim($status), trim($meta_title), trim($meta_keywords), trim($meta_description), trim($ip), $_SESSION['UID'], $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    }
    return $res;
}

function delfaqcategory($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `faqcategory` WHERE `fcid`=?", $c);
        unlink('../../images/faqcategory/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `faqcategory` WHERE `fcid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getfaq($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `faq` WHERE `fid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addfaq($category, $title, $link, $image, $imagealt, $imagename, $content, $meta_title, $meta_keywords, $meta_description, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `fid` FROM `faq` WHERE `image_name`=?", $imagename);
        if ($link1['fcid'] == '') {
            $link2 = FETCH_all("SELECT `fid` FROM `faq` WHERE `link`=?", $link);
            if ($link2['fcid'] == '') {
                $resa = $db->prepare("INSERT INTO `faq`(`category`,`title`,`link`,`description`,`image_alt`,`image_name`,`image`,`order`,`status`,`meta_title`,`meta_keywords`,`meta_description`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($category, $title, $link, $content, $imagealt, $imagename, $image, $order, $status, $meta_title, $meta_keywords, $meta_description, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `fid` FROM `faq` WHERE `image_name`=? AND `fid`!=?", $imagename, $getid);
        if ($link1['fid'] == '') {
            $link2 = FETCH_all("SELECT `fid` FROM `faq` WHERE `link`=? AND `fid`!=?", $link, $getid);
            if ($link2['fid'] == '') {
                $resa = $db->prepare("UPDATE `faq` SET `category`=?, `title`=?, `link`=?,`description`=?, `image`=?,`image_alt`=?,`image_name`=?,`order`=?, `status`=?, `meta_title`=?, `meta_keywords`=?, `meta_description`=?, `ip`=?, `updated_by`=? WHERE `fid`=?");
                $resa->execute(array(trim($category), trim($title), trim($link), trim($content), trim($image), trim($imagealt), trim($imagename), trim($order), trim($status), trim($meta_title), trim($meta_keywords), trim($meta_description), trim($ip), $_SESSION['UID'], $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    }
    return $res;
}

function delfaq($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `faq` WHERE `fid`=?", $c);
        unlink('../../images/faq/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `faq` WHERE `fid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getgallery($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `gallery` WHERE `gaid`= ? ");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}

function delgallery($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `gallery` WHERE `gaid`=?", $c);
        unlink('../../images/gallery/' . $getc['image']);
        unlink('../../images/gallery/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `gallery` WHERE `gaid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addgallery($title, $image, $imagealt, $imagetitle, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link22 = DB_QUERY("SELECT * FROM `banner` WHERE `imagename`='$imagename'");
        $link22 = FETCH_all("SELECT * FROM `gallery` WHERE `imagetitle`=?", $imagetitle);
        if ($link22['imagetitle'] == '') {

            $resa = $db->prepare("INSERT INTO `gallery` ( `title`,`image`, `imagealt`,`imagetitle`,`order`,`status`,`ip`,`updated_By`) VALUES(?,?,?,?,?,?,?,?)");
            $resa->execute(array($title, $image, $imagealt, $imagetitle, $order, $status, $ip, $_SESSION['UID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Image Name already exists!</h4></div>';
        }
    } else {
        $link22 = FETCH_all("SELECT * FROM `gallery` WHERE `imagetitle`=? AND `gaid`!=?", $imagetitle, $getid);
        if ($link22['imagetitle'] == '') {
            $resa = $db->prepare("UPDATE `gallery` SET `title`=?, `image`=?,`imagealt`=?,`imagetitle`=?, `order`=?, `status`=?, `ip`=?, `Updated_By`=? WHERE `gaid`=?");
            $resa->execute(array(trim($title), trim($image), trim($imagealt), trim($imagetitle), trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Gallery Mgmt', 12, 'Update', $_SESSION['UID'], $ip, $id));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Image Name already exists!</h4></div>';
        }
    }
    return $res;
}

function getourpartners($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `ourpartners` WHERE `paid`= ? ");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}

function delourpartners($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `ourpartners` WHERE `paid`=?", $c);
        unlink('../../images/ourpartners/' . $getc['image']);
        unlink('../../images/ourpartners/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `ourpartners` WHERE `paid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addourpartners($title,$externallink, $image, $imagealt, $imagetitle, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link22 = FETCH_all("SELECT * FROM `ourpartners` WHERE `imagetitle`=?", $imagetitle);
        if ($link22['imagetitle'] == '') {
            $resa = $db->prepare("INSERT INTO `ourpartners` (`title`,`external_link`,`image`, `imagealt`,`imagetitle`,`order`,`status`,`ip`,`updated_By`) VALUES(?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($title, $externallink, $image, $imagealt, $imagetitle, $order, $status, $ip, $_SESSION['UID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Image Name already exists!</h4></div>';
        }
    } else {
        $link22 = FETCH_all("SELECT * FROM `ourpartners` WHERE `imagetitle`=? AND `paid`!=?", $imagetitle, $getid);
        if ($link22['imagetitle'] == '') {
            $resa = $db->prepare("UPDATE `ourpartners` SET `title`=?, `external_link`=?,`image`=?,`imagealt`=?,`imagetitle`=?, `order`=?, `status`=?, `ip`=?, `Updated_By`=? WHERE `paid`=?");
            $resa->execute(array(trim($title),trim($externallink), trim($image), trim($imagealt), trim($imagetitle), trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Image Name already exists!</h4></div>';
        }
    }
    return $res;
}

function getservices($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `services` WHERE `sid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delservice($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `services` WHERE `sid`=?", $c);
        unlink('../../images/services/' . $getc['image']);
        unlink('../../images/services/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `services` WHERE `sid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addservice($title, $link, $description, $image, $imagename, $imagealt, $order, $status, $meta_title, $meta_keywords, $meta_description, $ip, $getid) {
    global $db;
    if ($getid == '') {

        $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `imagename`=?", $imagename);
        if ($link1['fcid'] == '') {
            $link2 = FETCH_all("SELECT `sid` FROM `services` WHERE `link`=?", $link);
            if ($link2['fcid'] == '') {
                $resa = $db->prepare("INSERT INTO `services` (`title`,`link`,`content`,`image_alt`,`imagename`,`image`,`order`,`status`,`meta_title`,`meta_keywords`,`meta_description`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($title, $link, $description, $imagealt, $imagename, $image, $order, $status, $meta_title, $meta_keywords, $meta_description, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `imagename`=? AND `sid`!=?", $imagename, $getid);
        if ($link1['sid'] == '') {
            $link2 = FETCH_all("SELECT `sid` FROM `services` WHERE `link`=? AND `sid`!=?", $link, $getid);
            if ($link2['sid'] == '') {
                $resa = $db->prepare("UPDATE `services` SET `title`=?, `link`=?,`content`=?, `image`=?,`image_alt`=?,`imagename`=?,`order`=?, `status`=?, `meta_title`=?, `meta_keywords`=?, `meta_description`=?, `ip`=?, `updated_by`=? WHERE `sid`=?");
                $resa->execute(array(trim($title), trim($link), trim($description), trim($image), trim($imagealt), trim($imagename), trim($order), trim($status), trim($meta_title), trim($meta_keywords), trim($meta_description), trim($ip), $_SESSION['UID'], $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    }
    return $res;
}

function gettestimonials($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `testimonial` WHERE `tid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function deltestimonials($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `testimonial` WHERE `tid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addtestimonials($title, $designation, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `tid` FROM `testimonial` WHERE `title`=?", $title);
        if ($link2['tid'] == '') {
            $resa = $db->prepare("INSERT INTO `testimonial` (`title`,`Designation`,`Content`, `order`,`status`, `ip`,`updated_by`) VALUES(?,?,?,?,?,?,?)");
            $resa->execute(array($title, $designation, $content, $order, $status, $ip, $_SESSION['UID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Title already exists!</h4></div>';
        }
    } else {

        $link2 = FETCH_all("SELECT `tid` FROM `testimonial` WHERE `title`=? AND `tid`!=?", $title, $getid);
        if ($link2['tid'] == '') {
            $resa = $db->prepare("UPDATE `testimonial` SET `title`=?, `Designation`=?, `Content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `tid`=?");
            $resa->execute(array(trim($title), trim($designation), trim($content), trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
        }
    }
    return $res;
}

function addimage($image, $imagename, $imagealt, $status, $ip, $thispageid, $getid) {
    global $db;
    if ($getid == '') {

        $link23 = $db->prepare("SELECT * FROM `imageup` WHERE `image_name`= ? ");
        $link23->execute(array($imagename));
        $link22 = $link23->fetch();
        if ($link22['image_name'] == '') {

            $qa = $db->prepare("INSERT INTO `imageup` (`image`,`image_name`,`image_alt` ,`status` ,`ip`,`updated_by`) values (?,?,?,?,?,?) ");
            $qa->execute(array($image, $imagename, $imagealt, $status, $ip, $_SESSION['UID']));


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('imageup', $thispageid, 'Insert', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button><h4><i class="icon fa fa-close"></i> Image Name already exists!</h4></div>';
        }
        return $res;
    }
}

function getimage($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `imageup` WHERE `aiid`= ? ");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}


?>
