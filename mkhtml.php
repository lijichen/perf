<?php
include("../config.php");
$id=$_GET['id'];
echo "<br />";

if (preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/","$id")  || strlen($id) != "51")
{
#echo "back to url";
backurl();
}

else
{

#$uploaddir="/html/perf/mkhtml/$id";
#$uploadfile=exec("sudo ls /html/upload/$id/ |egrep 'DataCollector01.csv'");
$dcfile="./mkhtml/$id/DataCollector01.csv";






// 创建目录 "mkhtml" 如果它不存在
if (!is_dir('mkhtml')) {
    mkdir('mkhtml', 0777, true);
}

// 读取CSV文件
$file = $dcfile;
$data = [];
if (($handle = fopen($file, 'r')) !== false) {
    $header = fgetcsv($handle); // 读取CSV文件的标题行
    fclose($handle);
}

// 准备用于删除特殊字符的正则表达式
$pattern = '/[\/\(\)%\\\\]/';

// 生成单独的HTML文件，每个文件显示一列数据
for ($i = 1; $i < count($header); $i++) {
    $xAxis = [];
    $yAxis = [];

    if (($handle = fopen($file, 'r')) !== false) {
        while (($row = fgetcsv($handle)) !== false) {
            $xAxis[] = $row[0]; // 第一列数据作为X轴
            $yAxis[] = $row[$i]; // 选择第i列的数据
        }
        fclose($handle);
    }

    $columnTitle = $header[$i]; // 获取当前列的标题作为文件名
    // 使用正则表达式删除文件名中的特殊字符
    $columnTitle = preg_replace($pattern, ' ', $columnTitle);
    $columnTitle = str_replace('#', $replacement, $columnTitle);
    $columnTitle = str_replace('%', $replacement, $columnTitle);
    
    $htmlContent = '<!DOCTYPE html>' .
        '<html>' .
        '<head>' .
        '    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>' .
        '</head>' .
        '<body>' .
        '    <canvas id="myChart"></canvas>' .
        '    <script>' .
        '        var ctx = document.getElementById("myChart").getContext("2d");' .
        '        var chartData = {' .
        '            labels: ' . json_encode($xAxis) . ',' .
        '            datasets: [' .
        '                {' .
        '                    label: "' . $columnTitle . '",' .
        '                    data: ' . json_encode($yAxis) . ',' .
        '                    fill: false,' .
        '                    borderColor: "rgba(75, 192, 192, 1)",' .
        '                    borderWidth: 2,' .
        '                    pointRadius: 0' .
        '                }' .
        '            ]' .
        '        };' .
        '        var myChart = new Chart(ctx, {' .
        '            type: "line",' .
        '            data: chartData,' .
        '            options: {' .
        '                scales: {' .
        '                    y: {' .
        '                        beginAtZero: true,' .
        '                        suggestedMax: 150,' .
        '                        callback: function (value, index, values) {' .
        '                            return value + "%";' .
        '                        }' .
        '                    }' .
        '                }' .
        '            }' .
        '        });' .
        '    </script>' .
        '</body>' .
        '</html>';

    $filename = "mkhtml/$id/" . $columnTitle . '.html'; // 使用单斜杠 / 开头的相对路径
    file_put_contents($filename, $htmlContent);
    echo "Generated HTML file for <a href='$filename' target='_blank'>$columnTitle</a><br>"; // 添加链接到生成的HTML文件
}
}
?>

