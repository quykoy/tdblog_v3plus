<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <style>
            .red{
                color: red;
            }
            .blue{
                color:blue;
            }
            .pink{
                color:pink;
            }
        </style>
        <script language="javascript">
            $(document).ready(function()
            {
                display_html(<?php echo $data['page'] ?>);
                function display_html(num)
                {
                    var html = '';

                    html += '<table class="table table-bordered">';
                        html += '<tr>';
                            html += '<td>page</td>';
                            html += '<td>Status</td>';
                        html += '</tr>';

                    for (var i = 1; i <= num; i++){
                        html += '<tr>';
                            html += '<td>'+i+'</td>';
                            html += '<td id="waitting'+i+'" class="active">Đợi xử lý...</td>';
                        html += '</tr>';
                    }
                    html += '</table>'

                    $('#results').html(html);
                }

                function send_ajax(num, index)
                {
                    var category = 1;
                    category = $("#category").find(":selected").val();
                    // Kiểm tra xem task đã hết chưa, nếu hết thì dừng
                    if (index > num){
                        $(".progress-bar").css("width", "100%");
                        alert("LEECH HOÀN TẤT");
                        return false;
                    }
                    // Chuyển trang thái từ waitting san sendding
                    $('#waitting'+index).removeClass('pink').addClass('danger').html('Đang xử lý...');

                    // Gửi ajax
                    $.ajax({
                        url : '<?php echo base_url(); ?>/hinh/process?cate=<?php echo $_GET['cate']; ?>&page='+index+'&category='+category,
                        type : 'post',
                        dataType : 'text',
                        success : function()
                        {
                            // Sau khi thành công thì chuyển trạng thái sang finisk
                            $('#waitting'+index).removeClass('danger').addClass('success');
                            $('#waitting'+index).html('Hoàn thành');
                        }
                    })
                    .always(function(){
                        // Xử lý task tiếp theo
                        num = eval(<?php echo $data['page'] ?>+1);
                        percent = Math.ceil((index*100)/num);
                        $(".sr-only").text(percent+"%");
                        $(".progress-bar").css("width", percent+"%");
                        send_ajax(num, ++index);
                    });
                }
                
                $('#send-request').click(function()
                {    
                    // Lấy số lượng task từ user nhập vào
                    var num = <?php echo $data['page'] ?>;
                    $('#send-request').text('ĐANG LEECH...');
                    // Hiển thị table danh sách task
                    display_html(num);
                    // gửi ajax cho lần đầu tiên (task = 0)
                    send_ajax(num, 1);
                });
            });
        </script>
    </head>
    <body>
    <div style="margin: 20px 100px 20px 100px; text-align: center;">
        <select name="category" id="category" style="width: 102px;height: 37px;margin-bottom: 10px;">
            <?php
                foreach($data['listCategory'] as $category){
                    if($category['parent'] == 0){
                        echo '<option value="false">----------------</option>';
                        echo '<option value="'.$category['id'].'"><span class="main-cate"> +  '.$category['name'].'</span></option>';
                        foreach ($data['listCategory'] as $scategory) {
                            if($category['id'] == $scategory["parent"]){
                                echo '<option value="'.$scategory['id'].'"><span class="sub-cate"> -    '.$scategory['name'].'</span></option>';
                            }
                        }
                    }
                }
            ?>
        </select>
        <button type="button" class="btn btn-primary btn-lg btn-block" id="send-request" style="margin-bottom: 15px;">BẮT ĐẦU LEECH</button>
        <div class="progress" style="margin-top:10ox;">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
            <span class="sr-only">45% Complete</span>
          </div>
        </div>
        <div id="results"></div>
    </div>
    </body>
</html>