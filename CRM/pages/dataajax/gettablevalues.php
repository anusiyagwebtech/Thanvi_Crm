<?php

include ('../../config/config.inc.php');

//ini_set('display_errors','1');
//error_reporting(E_ALL);
function mres($value) {
    $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
    return str_replace($search, $replace, $value);
}

/* Declaration table name start here */

if ($_REQUEST['types'] == 'news1table') {
    $aColumns = array('nid', 'date','title', 'order', 'status');
    $sIndexColumn = "nid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "news";
}

if ($_REQUEST['types'] == 'testimonial1table') {
    $aColumns = array('tid','image','content1', 'content',  'order', 'status');
    $sIndexColumn = "tid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "testimonial";
}

if ($_REQUEST['types'] == 'testimonial2table') {
    $aColumns = array('tid','image','content1', 'content',  'order', 'status');
    $sIndexColumn = "tid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "about_testimonial";
}


if ($_REQUEST['types'] == 'aboutus1table') {
    $aColumns = array('aid','image','content1', 'content','list1','list2','list3',  'order', 'status',);
    $sIndexColumn = "aid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "aboutus";
}


if ($_REQUEST['types'] == 'bannertable') {
    $aColumns = array('bid', 'date','title', 'order', 'status');
    $sIndexColumn = "bid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "banner";
}

if ($_REQUEST['types'] == 'banner3table') {
    $aColumns = array('wid', 'image','content1', 'content',  'order', 'status');
    $sIndexColumn = "wid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "works_banner";
}


if ($_REQUEST['types'] == 'workstable') {
    $aColumns = array('bid', 'image','content1', 'content',  'order', 'status');
    $sIndexColumn = "bid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "works";
}

if ($_REQUEST['types'] == 'banner4table') {
    $aColumns = array('nid', 'image','content1', 'content',  'order', 'status');
    $sIndexColumn = "nid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "news_banner";
}

if ($_REQUEST['types'] == 'company1table') {
    $aColumns = array('cid', 'image','content1', 'content',  'order', 'status');
    $sIndexColumn = "cid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "company";
}

if ($_REQUEST['types'] == 'renovationtable') {
    $aColumns = array('cid', 'image','content1', 'content',  'order', 'status');
    $sIndexColumn = "cid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "renovation";
}

if ($_REQUEST['types'] == 'banner2table') {
    $aColumns = array('bid', 'image','content1', 'content',  'order', 'status');
    $sIndexColumn = "bid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "about_banner";
}

if ($_REQUEST['types'] == 'traintable') {
    $aColumns = array('nid', 'date','title', 'order', 'status');
    $sIndexColumn = "nid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "training";
}

if ($_REQUEST['types'] == 'visitortable') {
    $aColumns = array('tid', 'name','email', 'check_in', 'check_out');
    $sIndexColumn = "tid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "train_user";
}

if ($_REQUEST['types'] == 'careertable') {
    $aColumns = array('cid', 'jobcode','title', 'order', 'status');
    $sIndexColumn = "cid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "careers";
}
if ($_REQUEST['types'] == 'billtable') {
    $aColumns = array('id', 'type', 'prefix', 'format');
    $sIndexColumn = "id";
    $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "bill_settings";
}

if ($_REQUEST['types'] == 'contacttable') {
    $aColumns = array('coid', 'date', 'firstname', 'emailid','phoneno','subject');
    $sIndexColumn = "coid";
    $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editcontact" : "editcontact";
    $sTable = "contact_form";
}



if ($_REQUEST['types'] == 'leadtable') {
    $aColumns = array('lid', 'type','sentthrough', 'sentto', 'date', 'proposal', 'leadtype', 'domain');
    $sIndexColumn = "lid";
    $sTable = "lead_form";
}

if ($_REQUEST['types'] == 'employeetable') {
    $aColumns = array('rid', 'name','password', 'domain');
    $sIndexColumn = "rid";
    $sTable = "employee";
}


if ($_REQUEST['types'] == 'followtable') {
    $aColumns = array('fid', 'name','process', 'last', 'next');
    $sIndexColumn = "fid";
    $sTable = "follow";
}

if ($_REQUEST['types'] == 'tasktable') {
    $aColumns = array('tid', 'domain','emp_name', 'task_name', 'project_name','start', 'end', 'priority');
    $sIndexColumn = "tid";
    $sTable = "task";
}

if ($_REQUEST['types'] == 'clienttable') {
    $aColumns = array('cid', 'cus_name','com_name', 'mobile', 'email','address', 'domain');
    $sIndexColumn = "cid";
    $sTable = "client";
}

if ($_REQUEST['types'] == 'servicetable') {
    $aColumns = array('nid', 'title', 'order', 'status');
    $sIndexColumn = "nid";
    $sTable = "service";
}

if ($_REQUEST['types'] == 'recent1table') {
    $aColumns = array('rid','image','image_title', 'content','image_alt','order', 'status');
    $sIndexColumn = "rid";
    $sTable = "recent";
}


if ($_REQUEST['types'] == 'banner1table') {
    $aColumns = array('bid', 'image', 'content','content1', 'order', 'status');
    $sIndexColumn = "bid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "banner";
}


if ($_REQUEST['types'] == 'interiortable') {
    $aColumns = array('bid', 'image', 'content','content1', 'order', 'status');
    $sIndexColumn = "bid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "interior";
}



 if ($_REQUEST['types'] == 'servicestable') {
    $aColumns = array('sid', 'lable1', 'lable2','order', 'status');
    $sIndexColumn = "sid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "services";
}

if ($_REQUEST['types'] == 'aboutustable') {
    $aColumns = array('aid', 'lable1', 'lable2','order', 'status');
    $sIndexColumn = "aid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "aboutus";
}



if ($_REQUEST['types'] == 'amenitiestable') {
    $aColumns = array('aid', 'title', 'price', 'image', 'order', 'status');
    $sIndexColumn = "aid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "amenities";
}
if ($_REQUEST['types'] == 'eventstable') {
    $aColumns = array('eid', 'title', 'order', 'status');
    $sIndexColumn = "eid";
    $sTable = "events";
}

if ($_REQUEST['types'] == 'pressreleasetable') {
    $aColumns = array('pid', 'title', 'order', 'status');
    $sIndexColumn = "pid";
    $sTable = "pressrelease";
}
if ($_REQUEST['types'] == 'imagescategorytable') {
    $aColumns = array('aid', 'title', 'order', 'status');
    $sIndexColumn = "aid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "album";
}
if ($_REQUEST['types'] == 'diningcategorytable') {
    $aColumns = array('dcid', 'title', 'order', 'status');
    $sIndexColumn = "dcid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "diningcategory";
}
if ($_REQUEST['types'] == 'diningtable') {
    $aColumns = array('did', 'title', 'image', 'order', 'status');
    $sIndexColumn = "did";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "dining";
}
if ($_REQUEST['types'] == 'hoteltable') {
    $aColumns = array('hoid', 'title', 'order', 'status');
    $sIndexColumn = "hoid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "hotel";
}

if ($_REQUEST['types'] == 'promo_code') {
    $aColumns = array('pcid', 'promo_code', 'type', 'value', 'status');
    $sIndexColumn = "pcid";
    $sTable = "promocode";
}
if ($_REQUEST['types'] == 'accommodationtable') {
    $aColumns = array('hoid', 'title', 'totalrooms', 'single', 'double', 'order', 'status');
    $sIndexColumn = "hoid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "accommodation";
}
if ($_REQUEST['types'] == 'thingstodotable') {
    $aColumns = array('hoid', 'title', 'order', 'status');
    $sIndexColumn = "hoid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbanner" : "editbanner";
    $sTable = "thingstodo";
}

if ($_REQUEST['types'] == 'videotable') {
    $aColumns = array('vid', 'title', 'order', 'status');
    $sIndexColumn = "vid";
    $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editvideo" : "editvideo";
    $sTable = "video";
}

if ($_REQUEST['types'] == 'producttable') {
    $aColumns = array('pid', 'productname', 'status', 'order');
    $sIndexColumn = "pid";
    $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editproduct" : "editproduct";
    $sTable = "product";
}

if ($_REQUEST['types'] == 'registertable') {
    $aColumns = array('rid', 'name', 'phone', 'email', 'status');
    $sIndexColumn = "rid";
    $sTable = "register";
}



if ($_REQUEST['types'] == 'feedbacktable') {
    $aColumns = array('fdid', 'name', 'email', 'contactno', 'view', 'replay');
    $sIndexColumn = "fdid";
    $sTable = "feedback";
}

if ($_REQUEST['types'] == 'enquirytable') {
    $aColumns = array('eid', 'date', 'firstname', 'email', 'phone');
    $sIndexColumn = "eid";
    // $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editenquirylist" : "editenquirylist";
    $sTable = "enquirenow";
}

if ($_REQUEST['types'] == 'faqcategorytable') {
    $aColumns = array('fcid', 'category', 'order', 'status');
    $sIndexColumn = "fcid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaqcategory" : "editfaqcategory";
    $sTable = "faqcategory";
}

if ($_REQUEST['types'] == 'faqtable') {
    $aColumns = array('fid', 'category', 'title', 'order', 'status');
    $sIndexColumn = "fid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaq" : "editfaq";
    $sTable = "faq";
}

if ($_REQUEST['types'] == 'gallerytable') {
    $aColumns = array('gaid', 'album_id', 'title', 'image', 'order', 'status');
    $sIndexColumn = "gaid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editcontactus" : "editcontactus";
    $sTable = "gallery";
}

if ($_REQUEST['types'] == 'bannergallerytable') {
    $aColumns = array('gaid', 'ip', 'title', 'image', 'order', 'status');
    $sIndexColumn = "gaid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editcontactus" : "editcontactus";
    $sTable = "bannergallery";
}
if ($_REQUEST['types'] == 'vgallerytable') {
    $aColumns = array('gaid', 'title', 'order', 'status');
    $sIndexColumn = "gaid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editcontactus" : "editcontactus";
    $sTable = "vgallery";
}

if ($_REQUEST['types'] == 'virtualtourtable') {
    $aColumns = array('vid', 'title', 'image', 'order', 'status');
    $sIndexColumn = "vid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editcontactus" : "editcontactus";
    $sTable = "virtualtour";
}


if ($_REQUEST['types'] == 'packagetable') {
    $aColumns = array('pid', 'title', 'order', 'status');
    $sIndexColumn = "pid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editcontactus" : "editcontactus";
    $sTable = "packages";
}



if ($_REQUEST['types'] == 'testimonialtable') {
    $aColumns = array('tid', 'title', 'Designation', 'order', 'status');
    $sIndexColumn = "tid";
    $sTable = "testimonial";
}

if ($_REQUEST['types'] == 'newscategorytable') {
    $aColumns = array('ncid', 'category', 'order', 'status');
    $sIndexColumn = "ncid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editfaqcategory" : "editfaqcategory";
    $sTable = "newscategory";
}


if ($_REQUEST['types'] == 'newslettertable') {
    $aColumns = array('id', 'datetime', 'email', 'ip');
    $sIndexColumn = "id";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editcontactus" : "editcontactus";
    $sTable = "newsletter";
}

if ($_REQUEST['types'] == 'newslettertemplate') {
    $aColumns = array('temid', 'newsletter_title', 'status');
    $sIndexColumn = "temid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editcontactus" : "editcontactus";
    $sTable = "newstemplate";
}

if ($_REQUEST['types'] == 'contactustable') {
    $aColumns = array('id', 'name', 'phone', 'email');
    $sIndexColumn = "id";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editcontactus" : "editcontactus";
    $sTable = "contact";
}

if ($_REQUEST['types'] == 'static_pages') {
    $aColumns = array('stid', 'title');
    $sIndexColumn = "stid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "editstatic" : "editstati";
    $sTable = "static_pages";
}

if ($_REQUEST['types'] == 'socialmedia') {
    $aColumns = array('sid', 'sname', 'order', 'status');
    $sIndexColumn = "sid";
    //$editpage = ($_REQUEST['db_table_for'] == 'live') ? "edit" : "editstati";
    $sTable = "socialmedia";
}

if ($_REQUEST['types'] == 'roomstable') {
    $aColumns = array('rid', 'roomtype', 'room_name', 'room_number', 'order', 'status');
    $sIndexColumn = "rid";
    $sTable = "rooms";
}

$aColumns1 = $aColumns;

function fatal_error($sErrorMessage = '') {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    die($sErrorMessage);
}

$sLimit = "";

if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
    $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
}

$sOrder = "ORDER BY `$sIndexColumn` DESC";

if (isset($_GET['iSortCol_0'])) {
    $sOrder = "ORDER BY  ";
    if (in_array("order", $aColumns)) {
        $sOrder .= "`order` asc, ";
    } else if (in_array("Order", $aColumns)) {
        $sOrder .= "`Order` asc, ";
    }
    for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
        if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
            $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
        }
        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY ") {
            $sOrder = " ";
        }
    }
}

if (($_REQUEST['types'] == 'visitortable')) {
    $sOrder = " ORDER BY check_in asc ";
    $defaultpageload = '0';
}

$sWhere = "";

if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
    $sWhere .= " AND (";
    for ($i = 0; $i < count($aColumns); $i++) {		
        if ($aColumns[$i] == 'Status') {
            if (strtolower($_GET['sSearch']) == 'active') {
                $sWhere .= " `Status`='1' OR ";
            } elseif (strtolower($_GET['sSearch']) == 'inactive') {
                $sWhere .= " `Status`='0' OR ";
            } else {
                $sWhere .= "";
            }
        } else {
			if ($aColumns[$i] == 'date') {
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mres(date("Y-m-d", strtotime($_GET['sSearch']))) . "%' OR ";
            } else {
				$sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mres($_GET['sSearch']) . "%' OR ";
			}
		}
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
}

if ($_REQUEST['types'] == 'careerstable') {  
     $sWhere .= $_SESSION['customer_search'];          
}
if (($_REQUEST['types'] == 'categorytable') || ($_REQUEST['types'] == 'subcategorytable') || ($_REQUEST['types'] == 'innercategorytable')) {
    $sWhere .= " AND `status`!='2'";
}
if ($sWhere != '') {
    $sWhere = "WHERE `$sIndexColumn`!='' $sWhere";
}
try {
    $sQuery = "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(",", "`,`", implode(",", $aColumns)) . "` FROM $sTable $sWhere $sOrder $sLimit ";
    $rResult = $db->prepare($sQuery);
    $rResult->execute();
} catch (Exception $exc) {
    echo "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(",", "`,`", implode(",", $aColumns)) . "` FROM $sTable $sWhere $sOrder $sLimit ";
    echo '<br/><br/><br/><br/><br/><br/><br/>';

    echo $exc;
}


$sQuery = "SELECT FOUND_ROWS()";

$rResultFilterTotal = $db->prepare($sQuery);
$rResultFilterTotal->execute();

$aResultFilterTotal = $rResultFilterTotal->fetch();
$iFilteredTotal = $aResultFilterTotal[0];

$sQuery = "SELECT COUNT(" . $sIndexColumn . ") FROM $sTable";
$rResultTotal = $db->prepare($sQuery);
$rResultTotal->execute();

$aResultTotal = $rResultTotal->fetch();
$iTotal = $aResultTotal[0];

$output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
);

$ij = 1;
$k = $_GET['iDisplayStart'];

while ($aRow = $rResult->fetch(PDO::FETCH_ASSOC)) {
    $k++;
    $row = array();

    for ($i = 0; $i < count($aColumns1); $i++) {
        if ($_REQUEST['types'] == 'bannertable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'image') {
                $row[] = '<img src="' . $fsitename . 'images/banner/' . $aRow[$aColumns1[$i]] . '" style="padding-bottom:10px;" height="100" />';
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'contacttable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'date') {
                $row[] = date('d-M-y', strtotime($aRow[$aColumns1[$i]]));
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        }  else if ($_REQUEST['types'] == 'careerstable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'date') {
                $row[] = date('d-M-y', strtotime($aRow[$aColumns1[$i]]));
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        }  elseif ($_REQUEST['types'] == 'amenitiestable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'image') {
                $row[] = '<img src="' . $fsitename . 'images/amenities/' . $aRow[$aColumns1[$i]] . '" style="padding-bottom:10px;" height="100" />';
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'diningtable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'image') {
                $row[] = '<img src="' . $fsitename . 'images/dining/' . $aRow[$aColumns1[$i]] . '" style="padding-bottom:10px;" height="100" />';
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'faqcategorytable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'faqtable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'category') {
                $row[] = getfaqcategory('category', $aRow[$aColumns1[$i]]);
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'gallerytable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'album_id') {
                $row[] = getalbum('title', $aRow[$aColumns1[$i]]);
            } elseif ($aColumns1[$i] == 'image') {
                $row[] = '<img src="' . $fsitename . 'images/gallery/thump/' . $aRow[$aColumns1[$i]] . '" style="padding-bottom:10px; max-width:140px;" />';
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        }  else if ($_REQUEST['types'] == 'vgallerytable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'album_id') {
                $row[] = getalbum('title', $aRow[$aColumns1[$i]]);
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'virtualtourtable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'image') {
                $row[] = '<img src="' . $fsitename . 'images/virtualtour/thump/' . $aRow[$aColumns1[$i]] . '" style="padding-bottom:10px;" height="100" />';
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'accommodationtable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'totalrooms') {
                $ft = FETCH_all("SELECT COUNT(`roomtype`) AS `rooms` FROM `booking` WHERE (CURDATE() BETWEEN `bookingfrom` AND `bookingto`) AND `order_status`=? AND `roomtype`=?", '1', $aRow[$sIndexColumn]);
                $avail = getaccommodation('totalrooms', $aRow[$sIndexColumn]) - $ft['rooms'];
                $row[] = $avail;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'ourpartnerstable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'image') {
                $row[] = '<img src="' . $fsitename . 'images/ourpartners/thump/' . $aRow[$aColumns1[$i]] . '" style="padding-bottom:10px;" height="100" />';
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'servicetable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'image') {
                $row[] = '<img src="' . $fsitename . 'images/services/' . $aRow[$aColumns1[$i]] . '" style="padding-bottom:10px;" height="100" />';
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'testimonialtable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'date') {
                $row[] = date('d-m-Y', strtotime($aRow[$aColumns1[$i]]));
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'blogcategorytable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'blogtable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'category') {
                $cat = explode(",", $aRow[$aColumns1[$i]]);
                $catss = '';
                foreach ($cat as $cats) {
                    $catss .= getblogcategory('category', $cats) . ',';
                }
                $row[] = substr($catss, 0, -1);
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'newscategorytable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'news1table') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'date') {
                $row[] = date('d-m-Y', strtotime($aRow[$aColumns1[$i]]));
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'careertable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'newslettertable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'datetime') {
                $row[] = date('d-M-Y h:i:s a', strtotime($aRow[$aColumns1[$i]]));
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'newslettertemplate') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'usertable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'socialmedia') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'faqtable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'brandtable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'typetable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'currencytable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'productreviewtable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'productname') {
                $row[] = getproduct('productname', $aRow[$aColumns1[$i]]);
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'customertable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'Status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'videotable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'feedbacktable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'datetime') {
                $row[] = date('d-M-y', strtotime($aRow[$aColumns1[$i]]));
            } elseif ($aColumns1[$i] == 'view') {
                $row[] = $aRow[$aColumns1[$i]] ? "Yes" : "No";
            } elseif ($aColumns1[$i] == 'replay') {
                $row[] = $aRow[$aColumns1[$i]] ? "Yes" : "No";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'enquirytable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'date') {
                $row[] = date('d-M-y', strtotime($aRow[$aColumns1[$i]]));
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'quatationlist') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'read_msg') {
                $row[] = ($aRow[$aColumns1[$i]] == '1') ? 'YES' : 'NO';
            } elseif ($aColumns1[$i] == 'replay') {
                $row[] = ($aRow[$aColumns1[$i]] == '1') ? 'YES' : 'NO';
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } else if ($_REQUEST['types'] == 'roomstable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'roomtype') {
                $row[] = getaccommodation('title', $aRow[$aColumns1[$i]]);
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } 

         /* else if ($_REQUEST['types'] == 'employeetable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'domain') {
                if ($aRow[$aColumns1[$i]]==1){
                    $row[]='Android';
                }
                elseif ($aRow[$aColumns1[$i]]==2){
                    $row[]='Web';
                }
                elseif ($aRow[$aColumns1[$i]]==3){
                    $row[]='SEO';
                } 
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } */
        else if ($_REQUEST['types'] == 'employeetable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'domain') {
                if ($aRow[$aColumns1[$i]]==1){
                    $row[]='Android';
                }
                elseif ($aRow[$aColumns1[$i]]==2){
                    $row[]='Web';
                }
                elseif ($aRow[$aColumns1[$i]]==3){
                    $row[]='SEO';
                } 
                else
                {
                      $row[] = $aRow[$aColumns1[$i]];
                }
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } 
        else if ($_REQUEST['types'] == 'tasktable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'domain') {
                if ($aRow[$aColumns1[$i]]==1){
                    $row[]='Android';
                }
                elseif ($aRow[$aColumns1[$i]]==2){
                    $row[]='Web';
                }
                elseif ($aRow[$aColumns1[$i]]==3){
                    $row[]='SEO';
                } 
                else{
                    $row[] = $aRow[$aColumns1[$i]];
                }
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } 
       else if ($_REQUEST['types'] == 'clienttable') {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'domain') {
                if ($aRow[$aColumns1[$i]]==1){
                    $row[]='Android';
                }
                elseif ($aRow[$aColumns1[$i]]==2){
                    $row[]='Web';
                }
                elseif ($aRow[$aColumns1[$i]]==3){
                    $row[]='SEO';
                } 
                 else{
                    $row[] = $aRow[$aColumns1[$i]];
                }
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } 




        else {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'Status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        }
    }
    /* Edit page  change start here */

    if ($_REQUEST['types'] == 'producttable') {
        $row[] = "<a href='" . $sitename . "products/" . $aRow[$sIndexColumn] . "/editproduct.htm' target='_blank' style='cursor:pointer;'><i class='fa fa-edit' ></i> Edit</a>";
    } elseif (($_REQUEST['types'] == 'contacttable') || ($_REQUEST['types'] == 'careerstable')|| ($_REQUEST['types'] == 'leadtable')) {
        $row[] = "<i class='fa fa-edit' onclick='javascript:editthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'> </i>";
    } elseif ($_REQUEST['types'] == 'newslettertable') {
        
    } else {
        $row[] = "<i class='fa fa-edit' onclick='javascript:editthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'> Edit </i>";
    }
    if (($_REQUEST['types'] == 'ordertable')||($_REQUEST['types'] == 'leadtable')) {
        $row[] = "<i class='fa fa-eye' onclick='javascript:viewthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'></i> ";
    } elseif ($_REQUEST['types'] == 'customertable') {
        $row[] = "<i class='fa fa-eye' onclick='javascript:editthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'></i>";
    }

    $row[] = '<input type="checkbox"  name="chk[]" id="chk[]" value="' . $aRow[$sIndexColumn] . '" />';


    $output['aaData'][] = $row;
    $ij++;
}

echo json_encode($output);
?>
 
