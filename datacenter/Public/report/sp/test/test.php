<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>test</title>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="content">
    <p>这是一个测试页面&nbsp;&nbsp;<span style="font-size:12px">路径为sp/test/test.php</span></p>

    <p>测试调用全局方法
        <button onclick="window.parent.APP_STATUS.ope.serverListShow()">button</button>
    </p>
    <img src="img/titanfall.jpg" alt="">

    <form action="../../../index.php" method="post">
        <input type="hidden" name="controller" value="ajax">
        <input type="hidden" name="method" value="getdata">
        <input type="hidden" name="et" value="2014-04-16">
        <input type="hidden" name="ft" value="2014-04-13">
        <input type="hidden" name="game" value="diablo">

        <input type="hidden" name="sid[37wan]"
               value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207">
        <input type="hidden" name="output_excel" value="1">
        <!--        <input type="hidden" name="output_head_names" value="时间,平台,服务器,充值额(元)">-->
        <!--        <input type="hidden" name="output_filter_names" value="stattime,platform,worldid,addrecharge">-->


        <input type="hidden" name="output_tasikmalaya_name" value="pointname">    <!-- 打横的字段名称 -->
        <input type="hidden" name="output_tasikmalaya_group_name" value="statdate">   <!-- 打横的分组字段名称 -->
        <input type="hidden" name="output_tasikmalaya_group_head_name" value="日期">  <!-- 打横的分组字段标题 左上角的标题 -->
        <input type="hidden" name="output_tasikmalaya_data_name" value="num">   <!-- 数据显示字段名称-->
        <input type="hidden" name="sql_id" value="91">
        <input type="hidden" name="sql_key" value="loginpercent2">
        <!--        <input type="hidden" name="sql_id" value="124">-->
        <!--        <input type="hidden" name="sql_key" value="recharge_by_day">-->
        <!--        <input type="hidden" name="output_head_names" value="时间,平台,服务器,充值额(元)">-->
        <!--        <input type="hidden" name="output_filter_names" value="stattime,platform,worldid,addrecharge">-->

        <input type="submit" value="Submit"/>
    </form>
</div>
</body>
</html>


