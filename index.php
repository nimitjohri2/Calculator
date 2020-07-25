<?php require_once('./config/config.php');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Calculator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body style="background-color:#DFDEDC">
<div class="container" style="padding-left: 15%; padding-right: 15%; padding-top: 7%">
    <div class="panel panel-default">
        <div class="panel panel-heading" style="background-color: #E1EDF6">
            Calculator
        </div>
        <div class="panel panel-body">
            <form id="calculator" method="post">
                <div class="row">
                    <div class="col-md-2"><input type="number" class="form-control" name="first" id="first" style="width: 100px" onkeydown="javascript: return event.keyCode==69||event.keyCode==53||event.keyCode==55?false:true" required /></div>
                    <div class="col-md-2">
                        <select name="operator" class="form-control" id="operator">
                            <option value="1">+</option>
                            <option value="2">-</option>
                            <option value="3">*</option>
                            <option value="4">/</option>
                        </select>
                    </div>
                    <div class="col-md-2"><input type="number" class="form-control" name="second" id="second" style="width: 100px" required /></div>
                    <div class="col-md-1">=</div>
                    <div class="col-md-3"><input type="text" class="form-control" name="answer" id="answer" disabled></div>
                    <div class="col-md-2"><input type="submit" class="btn btn-warning" name="submit" id="submit" value="Submit"></div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-heading" style="background-color: #E1EDF6">
            LIVE
        </div>
        <div class="panel panel-body">
            <div id="feed"></div>
        </div>
    </div>
</div>

<script>
    $( document ).ready(function() {

        setInterval(update,2000);

        $( "#calculator" ).submit(function(e) {

            e.preventDefault();

            var formdata = new FormData();
            formdata.append('first', $("#first").val());
            formdata.append('operator', $("#operator option:selected").val());
            formdata.append('second', $("#second").val());

            $.ajax({
                type: "POST",
                url: 'log.php',
                data:  formdata,
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){
                    console.log(response);
                    var answer = JSON.parse(response);
                    console.log(answer);
                    $('#answer').val(answer.answer);

                }
            });
        });
    });

    function update() {
        $.ajax({
            type: "POST",
            url: 'update.php',
            //data:  formdata,
            contentType: false,
            cache: false,
            processData:false,
            //datatype: 'json',
            success: function(response){
                var feed = JSON.parse(response);
                console.log(feed);

                $('#feed').empty();

                $.each(feed, function (id, equation){
                    //console.log('id = ' + id + ' value = ' + equation);
                    var pageFeed = jQuery(
                        "<div  class='row' id=" + equation[0] + " style=' padding-top: 2%; border-style: ridge;' >" +
                        "<div class='col-md-12'>" + equation[1] + "</div>" +
                        "</div>"
                    );
                    jQuery('#feed').append(pageFeed);
                    //$('#' + id).fadeIn(1000);
                });
            }
        });
    }
</script>

</body>
</html>
