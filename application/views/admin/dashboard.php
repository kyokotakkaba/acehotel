<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?=base_url("dist/css/bootstrap.min.css");?>">
        <link rel="stylesheet" href="<?=base_url("dist/css/bootstrap-grid.min.css");?>">
        <link rel="stylesheet" href="<?=base_url("dist/css/style.css");?>">
		<link rel="stylesheet" href="<?=base_url("dist/css/font-awesome.min.css");?>">

        <title>DASHBOARD ADMIN</title>
    </head>
    <style>
        .is-active {
            background-color: #1C7CD5;
            color: white !important;

        }

        .square-box {
            float: left;
            position: relative;
            width: 50%;
            overflow: hidden;
            border: solid 1px #ddd;
        }

        .square-box:before {
            content: "";
            display: block;
            padding-top: 100%;
        }

        .square-content {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            padding: 15% 0;

        }

        .square-content div {
            display: table;
            width: 100%;
            height: 100%;

        }

        .sm-font {
            font-size: 0.9rem;
            color: grey;
        }

        .mgn-list {
            margin-top: 3%;
        }

        .dashboard-big-font {
            font-size: 2rem;
        }

        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 10%;
            right: 10%;
            background-color: #1C7CD5;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .my-float {
            margin-top: 22px;
		}
		
		#nama_hotel{
			display: block;
  white-space: nowrap;
  width: 7em;
  overflow: hidden;
  text-overflow: ellipsis;
		}
    </style>

    <body>
        <?php $this->load->view("admin/header");?>
        <div class="container">
            <div class="row" style="margin-top:20%; margin-left:1%; margin-right:1%;">
                <div class="col-6 text-center">
                    <p>Today Report</p>
                </div>
                <div class="col-6 text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary" id="nama_hotel">Loading</button>
                        <button
                            type="button"
                            class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <span class="sr-only"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" id="list_hotel"></div>
                    </div>
                </div>

                <div class="col-12" style="margin-top:5%;">
                    <div class="square-box">
                        <div class="square-content">
                            <div class="text-center">
                                <h5 class="text-success">To Check In</h5>
                                <span class="dashboard-big-font">01</span>
                                <span class="text-secondary">/</span>
                                <span class="text-secondary">04</span>
                                <p>Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="square-box">
                        <div class="square-content">
                            <div class="text-center">
                                <h5 class="text-danger">To Check Out</h5>
                                <span class="dashboard-big-font">01</span>
                                <span class="text-secondary">/</span>
                                <span class="text-secondary">04</span>
                                <p>Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="square-box">
                        <div class="square-content">
                            <div class="text-center">
                                <h5 class="text-warning">In House</h5>
                                <span class="dashboard-big-font">01</span>
                                <span class="text-secondary">/</span>
                                <span class="text-secondary">04</span>
                                <p>Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="square-box">
                        <div class="square-content">
                            <div class="text-center">
                                <h5 class="text-primary">EOD Occ.</h5>
                                <span class="dashboard-big-font">4</span>
                                <span class="text-secondary">%</span>
                                <p>Bookings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view("admin/footer");?>
    </body>
    <script src="<?=base_url("dist/js/jquery.min.js");?>"></script>
    <script src="<?=base_url("dist/js/popper.min.js");?>"></script>
    <script src="<?=base_url("dist/js/bootstrap.min.js");?>"></script>
    

    <script id="hotel_option" type="text/HTML">
        <a class="dropdown-item" href="#">test</a>
    </script>

    <script>
        $(document).ready(function () {
            $("#dashboard_footer").addClass('is-active');
            $("#header_title").text('Dashboard');
        });

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '-' + dd + '-' + yyyy;
        console.log(today);

        $.ajax({
            url: "<?php echo base_url() ?>index.php/get_all_hotel",
            type: 'get',
            dataType: "json",
            success: function (response) {
                $('#nama_hotel').text(response[0].nama_hotel);
                for (i = 0; i < response.length; i++) {
                    var tmp = $('#hotel_option')[0].innerHTML;
                    tmp = $.parseHTML(tmp);
                    $(tmp).text(response[i].nama_hotel);
                    $(tmp).data('id', response[i].id_hotel);
                    $(tmp).data('nama', response[i].nama_hotel);
                    $(tmp).appendTo('#list_hotel');
                    console.log(tmp);
                }
                $('.dropdown-toggle').dropdown();
            }
        });

        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus');
        });

        $(document).on('click', '.dropdown-item', function () {
            var namaHotel = $(this).data('nama');
            var idHotel = $(this).data('id');

            $('#nama_hotel').text(namaHotel);
            $.ajax({
                url: "<?php echo base_url() ?>index.php/get_order_by_hotel/" + idHotel,
                type: 'get',
                dataType: "json",
                success: function (response) {
                    console.log(response[0].nama_hotel);

                }
            });
        });
    </script>

</html>