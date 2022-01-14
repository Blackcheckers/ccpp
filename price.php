<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <!-- <meta name="viewport" content="width=device-width, user-scalable=no"> -->
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="p-2">
            <table class="table table-striped table-bordered">
                <?php
                $col = 5;
                $cnt = 40;
                $price = 1200;
                ?>
                <tbody>
                    <?php for ($i=0; $i < $cnt/$col; $i++) { ?>
                        <tr>
                            <?php for ($j=1; $j <= $col; $j++) { $no = $j+($i*$col); ?>
                                <td>
                                    <span class="badge badge-primary"><?php echo $no; ?></span>
                                    <span class="price"><?php echo number_format($price*$no); ?></span>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="form-group">
              <input type="tel" class="form-control m-1" name="" id="m" aria-describedby="helpId" placeholder="받은돈">
              <input type="tel" class="form-control m-1" name="" id="p" aria-describedby="helpId" placeholder="가격">
              <div class="m-1">
                <hr>
                <div class="result"></div>
                <hr>
              </div>
              <input type="submit" value="계산" class="btn btn-danger m-1" id="cal">
              <input type="submit" value="초기화" class="btn btn-secondary m-1" id="reset">
            </div>
        </div>
    </div>
    <style>
        @media(max-width: 720px){
            table{
                font-size: 12px;
            }
        }
    </style>
    <script>
        $(document).ready(function(){
            $("td").click(function(){
                var price = $(this).find(".price").text().replace(',', '');
                $("#p").val(price);
                $("#m").focus();
            });

            $("#cal").click(function(e){
                e.preventDefault();
                var m = Number($('#m').val());
                var p = $('#p').val().replace(',', '');
                $(".result").text(m-p);
            });

            $(body).keydown(function(e){
                if(e.which == 13) {
                    e.preventDefault();
                    var m = Number($('#m').val());
                    var p = $('#p').val().replace(',', '');
                    $(".result").text(m-p);
                }
            })
        }); 
    </script>
</body>
</html>