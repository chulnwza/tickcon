<?php
session_start();
if(!isset($_SESSION['member_id']) || (isset($_SESSION['$member_id']) && $_SESSION['$member_id'] == 'user')){
    header('location:index_notlogin.php');
}
 ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TICKCON</title>
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500;700&family=IBM+Plex+Sans+Thai:wght@500&family=Mohave:wght@700&display=swap" rel="stylesheet">

    <!-- bootstrap link and script -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- add style -->
    <style>
        .container {
            margin: auto;
            margin-bottom: 20px;
        }

        .comment {
            color: blue;
        }

        * {
            font-family: 'Dosis', sans-serif;
            font-family: 'IBM Plex Sans Thai', sans-serif;
        }

        .navbar-brand {
            font-family: 'Mohave', sans-serif;
        }

        .container-fluid {
            color: white;
        }

        .nav-link:hover {
            color: white;
            font-weight: bolder;
        }

        .btn-light {
            background-color: #C2D9FF;
            border-color: #C2D9FF;
        }

        .btn-outline-danger {
            color: white;
            border-color: white;
        }

        .card-text {
            max-width: 50ch;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card {
            margin: auto;
        }
        .nav-link {
            text-decoration: none;
            color: #000000;
        }
        .nav-link-1:hover {
            color: white;
            font-weight: bolder;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-md sticky-top shadow p-2 mb-5 " style="background-color : #0097B2">
        <div class="container-fluid">
            <a class="navbar-brand" href="index_admin.php">
                <img src="upload/logo/TICKCON.png" alt="Logo" width="150px" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 p-1 ms-0 ps-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index_admin.php">Cencerts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="con_waiting_list.php" style="color:white;">Pending List</a>
                    </li>
                </ul>
                <div class="mb-lg-0 me-3 mt-1">
                    <p style="color:black"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle"
                        viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd"
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                        <?= $_SESSION['firstname'] ?>
                    </p>
                </div>
                <form class="d-flex mb-2 mb-lg-0" action="index_notlogin.php">
                    <button class="btn btn-outline-danger" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- code -->

    <?php

    if ((!isset($_SESSION['concert_id']) && isset($_GET['concert_id'])) || (isset($_SESSION['concert_id']) && isset($_GET['concert_id']))) {
        $_SESSION['concert_id'] = $_GET['concert_id'];
    }

    $concert_id = $_SESSION['concert_id'];
    require_once 'config/db.php';
    //when click confirm button check
    if (isset($_GET['confirm'])) {
        $concert_name_comment = $_GET['concert_name_comment'];
        $detail_comment = $_GET['detail_comment'];
        $concert_img_comment = $_GET['concert_img_comment'];
        $show_date_comment = $_GET['show_date_comment'];
        $show_time_comment = $_GET['show_time_comment'];
        $copy_id_card_comment = $_GET['copy_id_card_comment'];
        $con_permission_comment = $_GET['con_permission_comment'];
        $stage_img_comment = $_GET['stage_img_comment'];
        $bank_name_comment = $_GET['bank_name_comment'];
        $bank_code_comment = $_GET['bank_code_comment'];
        $address_comment = $_GET['address_comment'];
        $ticket_comment = $_GET['ticket_comment'];
        $open_booking_date_comment = $_GET['open_booking_date_comment'];
        $requirement_comment = $_GET['requirement_comment'];
        if ($_GET['status-approve'] == 'approve') {
            $sql4 = <<<EOF
            UPDATE concert
            SET status = "approved"
            WHERE concert_id = $concert_id;
            EOF;
            $ret4 = $db->exec($sql4);
            header("Location: con_waiting_list.php");
        } else if ($_GET['status-reject'] == 'reject') {
            $sql5 = <<<EOF
            UPDATE concert
            SET status = "rejected",
            concert_name_comment = '$concert_name_comment',
            detail_comment = '$detail_comment',
            concert_img_comment = '$concert_img_comment',
            show_date_comment = '$show_date_comment',
            show_time_comment = '$show_time_comment',
            copy_id_card_comment = '$copy_id_card_comment',
            con_permission_comment = '$con_permission_comment',
            stage_img_comment = '$stage_img_comment',
            bank_name_comment = '$bank_name_comment',
            bank_code_comment = '$bank_code_comment',
            address_comment = '$address_comment',
            ticket_comment = '$ticket_comment',
            open_booking_date_comment = '$open_booking_date_comment',
            requirement_comment = '$requirement_comment'
            WHERE concert_id = $concert_id; 
            EOF;
            $ret5 = $db->exec($sql5);
            header("Location:con_waiting_list.php");
        }
    }

    //concert data
    $sql = <<<EOF
    SELECT * from concert
    WHERE concert_id = $concert_id;
    EOF;
    $ret = $db->query($sql);
    $row = $ret->fetchArray(SQLITE3_ASSOC);
    //user data
    $member_id = $row['member_id'];
    $sql2 = <<<EOF
    SELECT * from member
    WHERE member_id = $member_id;
    EOF;
    $ret2 = $db->query($sql2);
    $row2 = $ret2->fetchArray(SQLITE3_ASSOC);


    echo '<div class="container">
        <h4>'.$row['concert_name'].'</h4><hr><br>
        <form method="get" action="each_con_check.php" id="form1">
        <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="mb-3">
                <label for="cname" class="form-label"><b>ผู้สร้างคอนเสิร์ต</b></label>
                <input type="text" class="form-control" name="cname" value = "' . $row2['firstname'] . ' ' . $row2['lastname'] . '" disabled>
                <label for="cname" class="form-label"><b>email</b></label>
                <input type="text" class="form-control" name="cname" value = "' . $row2['email'] . '" disabled>
            </div>
            </div>
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="mb-3">
                <label for="cname" class="form-label"><b>ชื่อคอนเสิร์ต</b></label>
                <input type="text" class="form-control" name="cname" value = "' . $row['concert_name'] . '" disabled>
                <br><p class="comment">ความคิดเห็น :</p>' . '<textarea name="concert_name_comment" style="width: 50%; height: 50px;">'.$row['concert_name_comment'].'</textarea><hr>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label"><b>สถานที่จัดคอนเสิร์ต</b></label><br>
                <textarea name="address" style="width: 100%; height: 100px;" disabled>' . $row['address'] . '</textarea>
                <br><p class="comment">ความคิดเห็น :</p>' . '<textarea name="address_comment" style="width: 50%; height: 50px;">'.$row['address_comment'].'</textarea><hr>
            </div>
            <div class="mb-3">
                <label for="bdate" class="form-label"><b>วันที่เปิดให้จองบัตรคอนเสิร์ต</b></label>
                <input type="date" class="form-control" name="bdate" value = "' . $row['open_booking_date'] . '" disabled>
                <br><p class="comment">ความคิดเห็น :</p>' . '<textarea name="open_booking_date_comment" style="width: 50%; height: 50px;">'.$row['open_booking_date_comment'].'</textarea><hr>
            </div>
            <div class="mb-3">
                <label for="cdate" class="form-label"><b>วันที่จัดคอนเสิร์ต</b></label>
                <input type="date" class="form-control" name="cdate" value = "' . $row['show_date'] . '" disabled>
                <br><p class="comment">ความคิดเห็น :</p>' . '<textarea name="show_date_comment" style="width: 50%; height: 50px;">'.$row['show_date_comment'].'</textarea><hr>
            </div>
            <div class="mb-3">
                <label for="ctime" class="form-label"><b>เวลาเริ่มคอนเสิร์ต</b></label>
                <input type="time" class="form-control" name="ctime" value = "' . $row['show_time'] . '" disabled>
                <br><p class="comment">ความคิดเห็น :</p>' . '<textarea name="show_time_comment" style="width: 50%; height: 50px;">'.$row['show_time_comment'].'</textarea><hr>
            </div>
            <div class="mb-3">
                <label class="form-label"><b>รายละเอียดคอนเสิร์ต</b></label><br>
                <textarea name="detail" style="width: 100%; height: 100px;" disabled>' . $row['detail'] . '</textarea>
                <br><p class="comment">ความคิดเห็น :</p>' . '<textarea name="detail_comment" style="width: 50%; height: 50px;">'.$row['detail_comment'].'</textarea><hr>
            </div>
            <div class="mb-3">
                <label for="require" class="form-label"><b>ข้อจำกัดของคอนเสิร์ต</b></label>
                <input type="require" class="form-control" name="require" value = "' . $row['requirement'] . '" disabled>
                <br><p class="comment">ความคิดเห็น :</p>' . '<textarea name="requirement_comment" style="width: 50%; height: 50px;">'.$row['requirement_comment'].'</textarea><hr>
            </div>
            <div class="mb-3">
                <label for="poster_img" class="form-label"><b>โปสเตอร์คอนเสิร์ต</b></label><br>
                <img src="' . $row['concert_img_path'] . '" style="max-width : 40vw"><br><br>
                <p class="comment">ความคิดเห็น :</p>' . '<textarea name="concert_img_comment" style="width: 50%; height: 50px;">'.$row['concert_img_comment'].'</textarea><hr>
            </div>
            <div class="mb-3">
            <label for="con_img" class="form-label"><b>แผนผังคอนเสิร์ต</b></label><br>';

            if (is_null($row['stage_img'])) {
                echo '<p style="color : #808080;">ไม่ได้อัพโหลดแผนผังคอนเสิร์ต</p>';
            } else {
                echo '<img src="' . $row['stage_img'] . '" style="max-width : 40vw"><br><br>';
            }
            echo '<p class="comment">ความคิดเห็น :</p><textarea name="stage_img_comment" style="width: 50%; height: 50px;">'.$row['stage_img_comment'].'</textarea>
            </div>
            </div>
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="mb-3" id="tic_type_add">
            <label class="form-label"><b>บัตรคอนเสิร์ต :</b></label>';
    //ticket section start
    $sql3 = <<<EOF
        SELECT name,description,price,COUNT(detail_id)
        FROM ticket
        JOIN ticket_detail
        USING (detail_id)
        WHERE concert_id = $concert_id
        GROUP BY detail_id
        ORDER BY price ASC;
    EOF;
    $ret3 = $db->query($sql3);
    while ($row3 = $ret3->fetchArray(SQLITE3_ASSOC)) {
        echo '<div class="row">
                <div class="col">
                <label class="form-label">ชื่อบัตร</label>
                <input type="text" class="form-control" name="tic_name[]"  value = "' . $row3['name'] . '" disabled>
                </div>
                <div class="col">
                <label class="form-label">ราคาบัตร</label>
                <input type="number" class="form-control" name="tic_price[]"  value = "' . $row3['price'] . '" disabled>
                </div>
                <div class="col">
                <label class="form-label">จำนวนบัตร</label>
                <input type="number" class="form-control" name="tic_amount[]"  value = "' . $row3['COUNT(detail_id)'] . '" disabled>
                </div>
                <div class="col">
                <label class="form-label">คำอธิบาย</label>
                <textarea name="tic_detail[]" style="width: 100%; height: 40px;" disabled>' . $row3['description'] . '</textarea>
                </div>
                </div><hr>';
    }
    //ticket section end
    echo '<p class="comment">ความคิดเห็น :</p>' . '<textarea name="ticket_comment" style="width: 50%; height: 50px;">'.$row['ticket_comment'].'</textarea></div>
            </div>
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
            <label class="form-label"><b>ข้อมูลผู้จัดคอนเสิร์ต :</b></label>
            <div class="mb-3">
                <label for="id_card_img" class="form-label"><b>สำเนาบัตรประชาชนผู้จัดคอนเสิร์ต</b></label><br>
                <img src="' . $row['copy_id_card_img'] . '" style="max-width : 40vw"><br><br>
                <p class="comment">ความคิดเห็น :</p>' . '<textarea name="copy_id_card_comment" style="width: 50%; height: 50px;">'.$row['copy_id_card_comment'].'</textarea><hr>
            </div>
            <div class="mb-3">
                <label for="license_img" class="form-label"><b>ใบอนุญาตจัดคอนเสิร์ต</b></label><br>
                <img src="' . $row['con_permission_img'] . '" style="max-width : 40vw"><br><br>
                <p class="comment">ความคิดเห็น :</p>' . '<textarea name="con_permission_comment" style="width: 50%; height: 50px;">'.$row['con_permission_comment'].'</textarea><hr>
            </div>
            
             <div class="mb-3">
                <label for="bank_acc_name" class="form-label"><b>ชื่อธนาคารรับเงิน</b></label>
                <input type="text" class="form-control" name="bank_acc_name"  value = "' . $row['bank_name'] . '" disabled>
                <br><p class="comment">ความคิดเห็น :</p>' . '<textarea name="bank_name_comment" style="width: 50%; height: 50px;">'.$row['bank_name_comment'].'</textarea><hr>
                <label for="bank_acc_number" class="form-label"><b>เลขที่บัญชีธนาคารรับเงิน</b></label>
                <input type="text" class="form-control" name="bank_acc_number"  value = "' . $row['bank_code'] . '" disabled> 
                <br><p class="comment">ความคิดเห็น :</p>' . '<textarea name="bank_code_comment" style="width: 50%; height: 50px;">'.$row['bank_code_comment'].'</textarea><hr>
            </div></div>';
            //approve with modal
            echo '<button type="button" class="btn btn-success border-0 me-1" data-bs-toggle="modal" data-bs-target="#confirm1">Approve</button>';
            //reject with modal
            echo '<button type="button" class="btn btn-danger border-0 me-1" data-bs-toggle="modal" data-bs-target="#confirm2">Reject</button>';
                                                
            // echo '<button type = "submit" name="button" value = "approve" class="btn btn-primary">Approve</button>
            // <button type = "submit" name="button" value = "reject" class="btn btn-danger">Reject</button>
            // </form></div>';
    //modal when approve
    echo '<div class="modal fade" id="confirm1" tabindex="-1" role="dialog"
            aria-labelledby="Title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!--ส่วนหัว-->
                    <div class="modal-header">
                        <p class="modal-title fw-bold fs-6" id="Title">Approve this concert?</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <!--ส่วนฟอร์ม-->
                    <div class="modal-body">
                            <div class="modal-footer">
                                <input type="hidden" id="status-approve" name="status-approve">
                                <button type="submit" class="btn btn-success" id="confirm" id="form1"  name="confirm">Approve</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>   
                            </div>
                    </div>
                </div>
            </div>
        </div>';
    //modal when reject
    echo '<div class="modal fade" id="confirm2" tabindex="-1" role="dialog"
        aria-labelledby="Title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!--ส่วนหัว-->
                <div class="modal-header">
                    <p class="modal-title fw-bold fs-6" id="Title">Reject this concert?</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>
                <!--ส่วนฟอร์ม-->
                <div class="modal-body">
                        <div class="modal-footer">
                            <input type="hidden" id="status-reject" name="status-reject">
                            <button type="submit" class="btn btn-danger" id="confirm" id="form1" name="confirm">Reject</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>   
                        </div>
                </div>
            </div>
        </div>
    </div></form>';
    ?>
    <footer class="py-3 my-4 ">
        <hr>
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>
<script>
    $('#confirm1').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('#status-approve').val('approve');
    });
    $('#confirm2').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('#status-reject').val('reject');
    });
</script>
</html>